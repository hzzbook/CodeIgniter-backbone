<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/3/1
 * 
 */

class cms_model extends MY_Model
{
    /**
     * 文章分类列表
     * @param null $fid
     * @param int $page
     * @param int $num
     * @return mixed
     */
    public function articles($data)
    {
        $list = $this->_articles($data);
        return $list;
    }

    /**
     * 文章列表
     * @param $data
     */
    public function _articles($data, $all = null)
    {
        $where = array(
            'title' => array(
                'filed'     => 'title',
                'type' 		=> "string",
                'table' 	=> 'article',
                'expression'    => 'like'
            ),
            'cate' => array(
                'filed'     => 'id',
                'type' 		=> "string",
                'table' 	=> 'category',
                'expression'    => '='
            ),
            'start' => array(     #文章分布时间
                'filed' => 'logtime',
                'type' => 'date',
                'table' => 'article',
                'expression' => '>='
            ),
            'end' => array(     #文章发布时间
                'filed' => 'logtime',
                'type' => 'date',
                'table' => 'article',
                'expression' => '<='
            ),
            'status' => array(     #文章分类ID
                'filed' => 'status',
                'type' => 'int',
                'table' => 'article',
                'expression' => '='
            ),
        );
        $where = $this->where($where, $data);
        #根据得到数据条数
        $result['sum'] = $this->_getArticlesTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $orderdata = $this->makeOrder($orderdata, $data['order']);

                $order = $this->order($orderdata);
            } else {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $order = $this->order($orderdata);
            }
            #echo $order;exit;
            if ($all == 'all') {
                $limit = '';
            } else {
                $limit = $this->limit($data, $sum);
                if ($limit == 'toobig') {
                    $back = array(
                        'status' => 'false',
                        'code' => '406',
                        'info' => urlencode('没有更多数据了')
                    );
                    return $back;
                }
            }

            $result['data'] = $this->_getArticlesList($where, $order, $limit['string'], $sum);
            $result['page'] = $limit['page'];
            $result['status'] = 'true';
            $result['code'] = '0';
        } else {
            $result['data'] = 'false';
            $result['status'] = 'false';
            $result['code'] = '404';
        }
        return $result;
    }

    private function _getArticlesTotal($where)
    {
        $sql = "select count(article.id) as sum from "
            . $this->db->dbprefix('cms_article') . ' as article  '
            . ' left join '
            . $this->db->dbprefix('cms_category') . ' as category '
            . ' on article.cateid=category.id'
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    private function _getArticlesList($where, $order, $limit)
    {
        $sql = "select article.*, category.title as catetitle from "
            . $this->db->dbprefix('cms_article') . ' as article  '
            . ' left join '
            . $this->db->dbprefix('cms_category') . ' as category '
            . ' on article.cateid=category.id'
            . $where
            . $order
            . $limit;
        #echo $sql;
        return $this->getResult($sql);
    }

    /**
     * 文章内容
     */
    public function article($aid)
    {
        $articleInfo = $this->_article($aid);
        if ($articleInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '文章不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $articleInfo
            );
        }
        return $back;
    }

    /**
     * 文章内容
     * @param $aid
     */
    private function _article($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'article',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_articleSQL($where);
        return $result;
    }

    private function _articleSQL($where)
    {
        $where = $this->One($where);
        $sql = "select article.*, category.title as catetitle from "
            . $this->db->dbprefix('cms_article') . ' as article '
            . ' inner join '
            . $this->db->dbprefix('cms_category') . ' as category '
            . $where;
        return $this->getRow($sql);
    }

    //上一篇文章
    public function preArticle($id, $cid) {
        $sql = "select id, title from ".$this->db->dbprefix('cms_article')
            ." where id < '".$id."' and cateid='".$cid."' and status=1 order by id desc limit 1";
        return $this->getRow($sql);
    }

    //下一篇文章
    public function nextArticle($id, $cid) {
        $sql = "select id, title from ".$this->db->dbprefix('cms_article')
            ." where id > '".$id."' and cateid='".$cid."' and status=1 order by id desc limit 1";
        return $this->getRow($sql);
    }

    //添加文章
    public function addArticle($data)
    {
        $data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('cms_article', $data);
    }

    //浏览文章
    public function viewArticle($id, $pv)
    {
        $data = array(
            'pv' => $pv
        );
        return $this->update('cms_article', $data, $id);
    }

    //编辑文章
    public function updateArticle($id, $data)
    {
        return $this->update('cms_article', $data, $id);
    }

    /**
     * 文章分类列表
     * @param null $fid
     * @param int $page
     * @param int $num
     * @return mixed
     */
    public function categorys($data)
    {
        $list = $this->_categorys($data);
        return $list;
    }

    /**
     * 文章列表
     * @param $data
     */
    public function _categorys($data, $all = null)
    {
        $where = array(
            'title' => array(
                'filed'     => 'title',
                'type' 		=> "string",
                'table' 	=> 'A',
                'expression'    => 'like'
            ),
            'cate' => array(
                'filed'     => 'fid',
                'type' 		=> "string",
                'table' 	=> 'A',
                'expression'    => '='
            ),
        );
        $where = $this->where($where, $data);

        #根据得到数据条数
        $result['sum'] = $this->_getcategoryTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "A"
                    ),
                );
                $orderdata = $this->makeOrder($orderdata, $data['order']);

                $order = $this->order($orderdata);
            } else {
                $order = '';
            }
            if ($all == 'all') {
                $limit = '';
            } else {
                $limit = $this->limit($data, $sum);
                if ($limit == 'toobig') {
                    $back = array(
                        'status' => 'false',
                        'code' => '406',
                        'info' => urlencode('没有更多数据了')
                    );
                    return $back;
                }
            }

            $result['data'] = $this->_getcategoryList($where, $order, $limit['string'], $sum);
            $result['page'] = $limit['page'];
            $result['status'] = 'true';
            $result['code'] = '0';
        } else {
            $result['data'] = 'false';
            $result['status'] = 'false';
            $result['code'] = '404';
        }
        return $result;
    }

    private function _getcategoryTotal($where)
    {
        $sql = "select count(A.id) as sum from "
            . $this->db->dbprefix('cms_category') . ' as A  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    private function _getcategoryList($where, $order, $limit)
    {
        $sql = "select A.*, B.title as catetitle from "
            . $this->db->dbprefix('cms_category') . ' as A  '
            . ' left join '.$this->db->dbprefix('cms_category'). ' as B on A.fid = B.id '
            . $where
            . $order
            . $limit;

        return $this->getResult($sql);
    }

    /**
     * 文章内容
     */
    public function category($aid)
    {
        $categoryInfo = $this->_category($aid);
        if ($categoryInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '文章不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $categoryInfo
            );
        }
        return $back;
    }

    /**
     * 文章内容
     * @param $aid
     */
    private function _category($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'category',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_categoryQL($where);
        return $result;
    }

    private function _categoryQL($where)
    {
        $where = $this->One($where);
        $sql = "select category.*, category.title as catetitle from "
            . $this->db->dbprefix('cms_category') . ' as category '
            . $where;
        return $this->getRow($sql);
    }

    //添加文章
    public function addcategory($data)
    {
        $data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('cms_category', $data);
    }

    //编辑文章
    public function updatecategory($id, $data)
    {
        return $this->update('cms_category', $data, $id);
    }

    /*******************************图片**********************************/
    public function images($data)
    {
        $list = $this->_images($data);
        return $list;
    }

    /**
     * 文章列表
     * @param $data
     */
    public function _images($data, $all = null)
    {
        $where = array(
            'title' => array(
                'filed'     => 'title',
                'type' 		=> "string",
                'table' 	=> 'article',
                'expression'    => 'like'
            ),
            'cate' => array(
                'filed'     => 'sn',
                'type' 		=> "string",
                'table' 	=> 'category',
                'expression'    => '='
            )
        );
        $where = $this->where($where, $data);
        #根据得到数据条数
        $result['sum'] = $this->_getImagesTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $orderdata = $this->makeOrder($orderdata, $data['order']);

                $order = $this->order($orderdata);
            } else {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $order = $this->order($orderdata);
            }
            #echo $order;exit;
            if ($all == 'all') {
                $limit = '';
            } else {
                $limit = $this->limit($data, $sum);
                if ($limit == 'toobig') {
                    $back = array(
                        'status' => 'false',
                        'code' => '406',
                        'info' => urlencode('没有更多数据了')
                    );
                    return $back;
                }
            }

            $result['data'] = $this->_getImagesList($where, $order, $limit['string'], $sum);
            $result['page'] = $limit['page'];
            $result['status'] = 'true';
            $result['code'] = '0';
        } else {
            $result['data'] = 'false';
            $result['status'] = 'false';
            $result['code'] = '404';
        }
        return $result;
    }

    private function _getImagesTotal($where)
    {
        $sql = "select count(article.id) as sum from "
            . $this->db->dbprefix('cms_image') . ' as article  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    private function _getImagesList($where, $order, $limit)
    {
        $sql = "select article.* from "
            . $this->db->dbprefix('cms_image') . ' as article  '
            . $where
            . $order
            . $limit;
        #echo $sql;
        return $this->getResult($sql);
    }

    /**
     * 文章内容
     */
    public function image($aid)
    {
        $articleInfo = $this->_image($aid);
        if ($articleInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $articleInfo
            );
        }
        return $back;
    }

    /**
     * 文章内容
     * @param $aid
     */
    private function _image($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'article',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_imageSQL($where);
        return $result;
    }

    private function _imageSQL($where)
    {
        $where = $this->One($where);
        $sql = "select article.* from "
            . $this->db->dbprefix('cms_image') . ' as article '
            . $where;
        return $this->getRow($sql);
    }


    //添加文章
    public function addImage($data)
    {
        #$data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('cms_image', $data);
    }


    //编辑文章
    public function updateImage($id, $data)
    {
        return $this->update('cms_image', $data, $id);
    }


    /**************************************内容片段*****************************************/
    public function contents($data)
    {
        $list = $this->_contents($data);
        return $list;
    }

    /**
     * 文章列表
     * @param $data
     */
    public function _contents($data, $all = null)
    {
        $where = array(
            'title' => array(
                'filed'     => 'title',
                'type' 		=> "string",
                'table' 	=> 'article',
                'expression'    => 'like'
            ),
            'cate' => array(
                'filed'     => 'sn',
                'type' 		=> "string",
                'table' 	=> 'category',
                'expression'    => '='
            )
        );
        $where = $this->where($where, $data);
        #根据得到数据条数
        $result['sum'] = $this->_getContentsTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $orderdata = $this->makeOrder($orderdata, $data['order']);

                $order = $this->order($orderdata);
            } else {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $order = $this->order($orderdata);
            }
            #echo $order;exit;
            if ($all == 'all') {
                $limit = '';
            } else {
                $limit = $this->limit($data, $sum);
                if ($limit == 'toobig') {
                    $back = array(
                        'status' => 'false',
                        'code' => '406',
                        'info' => urlencode('没有更多数据了')
                    );
                    return $back;
                }
            }

            $result['data'] = $this->_getContentsList($where, $order, $limit['string'], $sum);
            $result['page'] = $limit['page'];
            $result['status'] = 'true';
            $result['code'] = '0';
        } else {
            $result['data'] = 'false';
            $result['status'] = 'false';
            $result['code'] = '404';
        }
        return $result;
    }

    private function _getContentsTotal($where)
    {
        $sql = "select count(article.id) as sum from "
            . $this->db->dbprefix('cms_content') . ' as article  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    private function _getContentsList($where, $order, $limit)
    {
        $sql = "select article.* from "
            . $this->db->dbprefix('cms_content') . ' as article  '
            . $where
            . $order
            . $limit;
        #echo $sql;
        return $this->getResult($sql);
    }

    /**
     * 文章内容
     */
    public function content($aid)
    {
        $articleInfo = $this->_content($aid);
        if ($articleInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $articleInfo
            );
        }
        return $back;
    }

    /**
     * 文章内容
     * @param $aid
     */
    private function _content($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'article',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_contentsQL($where);
        return $result;
    }

    private function _contentsQL($where)
    {
        $where = $this->One($where);
        $sql = "select article.* from "
            . $this->db->dbprefix('cms_content') . ' as article '
            . $where;
        return $this->getRow($sql);
    }


    //添加文章
    public function addContent($data)
    {
        #$data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('cms_content', $data);
    }


    //编辑文章
    public function updateContent($id, $data)
    {
        return $this->update('cms_content', $data, $id);
    }

    /**************banner**************/
    public function banners($data)
    {
        $list = $this->_banners($data);
        return $list;
    }

    /**
     * 文章列表
     * @param $data
     */
    public function _banners($data, $all = null)
    {
        $where = array(
            'title' => array(
                'filed'     => 'title',
                'type' 		=> "string",
                'table' 	=> 'article',
                'expression'    => 'like'
            ),
            'cate' => array(
                'filed'     => 'sn',
                'type' 		=> "string",
                'table' 	=> 'article',
                'expression'    => '='
            )
        );
        $where = $this->where($where, $data);
        #根据得到数据条数
        $result['sum'] = $this->_getBannersTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $orderdata = $this->makeOrder($orderdata, $data['order']);

                $order = $this->order($orderdata);
            } else {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $order = $this->order($orderdata);
            }
            #echo $order;exit;
            if ($all == 'all') {
                $limit = '';
            } else {
                $limit = $this->limit($data, $sum);
                if ($limit == 'toobig') {
                    $back = array(
                        'status' => 'false',
                        'code' => '406',
                        'info' => urlencode('没有更多数据了')
                    );
                    return $back;
                }
            }

            $result['data'] = $this->_getBannersList($where, $order, $limit['string'], $sum);
            $result['page'] = $limit['page'];
            $result['status'] = 'true';
            $result['code'] = '0';
        } else {
            $result['data'] = 'false';
            $result['status'] = 'false';
            $result['code'] = '404';
        }
        return $result;
    }

    private function _getBannersTotal($where)
    {
        $sql = "select count(article.id) as sum from "
            . $this->db->dbprefix('cms_banner') . ' as article  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    private function _getBannersList($where, $order, $limit)
    {
        $sql = "select article.* from "
            . $this->db->dbprefix('cms_banner') . ' as article  '
            . $where
            . $order
            . $limit;
        #echo $sql;
        return $this->getResult($sql);
    }

    /**
     * 文章内容
     */
    public function banner($aid)
    {
        $articleInfo = $this->_banner($aid);
        if ($articleInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $articleInfo
            );
        }
        return $back;
    }

    /**
     * 文章内容
     * @param $aid
     */
    private function _banner($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'article',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_bannersQL($where);
        return $result;
    }

    private function _bannersQL($where)
    {
        $where = $this->One($where);
        $sql = "select article.* from "
            . $this->db->dbprefix('cms_banner') . ' as article '
            . $where;
        return $this->getRow($sql);
    }


    //添加文章
    public function addBanner($data)
    {
        #$data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('cms_banner', $data);
    }


    //编辑文章
    public function updateBanner($id, $data)
    {
        return $this->update('cms_banner', $data, $id);
    }

    /**************banner**************/
    public function friendlinks($data)
    {
        $list = $this->_friendlinks($data);
        return $list;
    }

    /**
     * 文章列表
     * @param $data
     */
    public function _friendlinks($data, $all = null)
    {
        $where = array(
            'title' => array(
                'filed'     => 'title',
                'type' 		=> "string",
                'table' 	=> 'article',
                'expression'    => 'like'
            ),
            'cate' => array(
                'filed'     => 'sn',
                'type' 		=> "string",
                'table' 	=> 'category',
                'expression'    => '='
            )
        );
        $where = $this->where($where, $data);
        #根据得到数据条数
        $result['sum'] = $this->_getFriendlinksTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $orderdata = $this->makeOrder($orderdata, $data['order']);

                $order = $this->order($orderdata);
            } else {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $order = $this->order($orderdata);
            }
            #echo $order;exit;
            if ($all == 'all') {
                $limit = '';
            } else {
                $limit = $this->limit($data, $sum);
                if ($limit == 'toobig') {
                    $back = array(
                        'status' => 'false',
                        'code' => '406',
                        'info' => urlencode('没有更多数据了')
                    );
                    return $back;
                }
            }

            $result['data'] = $this->_getFriendlinksList($where, $order, $limit['string'], $sum);
            $result['page'] = $limit['page'];
            $result['status'] = 'true';
            $result['code'] = '0';
        } else {
            $result['data'] = 'false';
            $result['status'] = 'false';
            $result['code'] = '404';
        }
        return $result;
    }

    private function _getFriendlinksTotal($where)
    {
        $sql = "select count(article.id) as sum from "
            . $this->db->dbprefix('cms_friendlylink') . ' as article  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    private function _getFriendlinksList($where, $order, $limit)
    {
        $sql = "select article.* from "
            . $this->db->dbprefix('cms_friendlylink') . ' as article  '
            . $where
            . $order
            . $limit;
        #echo $sql;
        return $this->getResult($sql);
    }

    /**
     * 文章内容
     */
    public function friendlink($aid)
    {
        $articleInfo = $this->_friendlink($aid);
        if ($articleInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $articleInfo
            );
        }
        return $back;
    }

    /**
     * 文章内容
     * @param $aid
     */
    private function _friendlink($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'article',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_friendlinksQL($where);
        return $result;
    }

    private function _friendlinksQL($where)
    {
        $where = $this->One($where);
        $sql = "select article.* from "
            . $this->db->dbprefix('cms_friendlylink') . ' as article '
            . $where;
        return $this->getRow($sql);
    }


    //添加文章
    public function addFriendlink($data)
    {
        $data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('cms_friendlylink', $data);
    }


    //编辑文章
    public function updateFriendlink($id, $data)
    {
        return $this->update('cms_friendlylink', $data, $id);
    }

    public function website()
    {
        $sql = "select * from "
            . $this->db->dbprefix('system_setting');
        return $this->getResult($sql);
    }

    public function single($key)
    {
        $sql = "select * from "
            . $this->db->dbprefix('cms_singlepage')
            . " where keys='{$key}'";
        return $this->getRow($sql);
    }

    public function seos($data)
    {
        $list = $this->_seos($data);
        return $list;
    }

    /**
     * 文章列表
     * @param $data
     */
    public function _seos($data, $all = null)
    {
        $where = array(
            'title' => array(
                'filed'     => 'title',
                'type' 		=> "string",
                'table' 	=> 'A',
                'expression'    => 'like'
            ),
            'cate' => array(
                'filed'     => 'fid',
                'type' 		=> "string",
                'table' 	=> 'A',
                'expression'    => '='
            ),
        );
        $where = $this->where($where, $data);

        #根据得到数据条数
        $result['sum'] = $this->_getseoTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "A"
                    ),
                );
                $orderdata = $this->makeOrder($orderdata, $data['order']);

                $order = $this->order($orderdata);
            } else {
                $order = '';
            }
            if ($all == 'all') {
                $limit = '';
            } else {
                $limit = $this->limit($data, $sum);
                if ($limit == 'toobig') {
                    $back = array(
                        'status' => 'false',
                        'code' => '406',
                        'info' => urlencode('没有更多数据了')
                    );
                    return $back;
                }
            }

            $result['data'] = $this->_getseoList($where, $order, $limit['string'], $sum);
            $result['page'] = $limit['page'];
            $result['status'] = 'true';
            $result['code'] = '0';
        } else {
            $result['data'] = 'false';
            $result['status'] = 'false';
            $result['code'] = '404';
        }
        return $result;
    }

    private function _getseoTotal($where)
    {
        $sql = "select count(A.id) as sum from "
            . $this->db->dbprefix('cms_seo') . ' as A  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    private function _getseoList($where, $order, $limit)
    {
        $sql = "select A.* from "
            . $this->db->dbprefix('cms_seo') . ' as A  '
            . $where
            . $order
            . $limit;

        return $this->getResult($sql);
    }

    public function seo($aid)
    {
        $seoInfo = $this->_seo($aid);
        if ($seoInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $seoInfo
            );
        }
        return $back;
    }

    private function _seo($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'seo',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_seoQL($where);
        return $result;
    }

    private function _seoQL($where)
    {
        $where = $this->One($where);
        $sql = "select seo.* from "
            . $this->db->dbprefix('cms_seo') . ' as seo '
            . $where;
        return $this->getRow($sql);
    }

    public function updateSeo($id, $data)
    {
        return $this->update('cms_seo', $data, $id);
    }

}