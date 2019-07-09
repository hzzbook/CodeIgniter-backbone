<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/3/6
 * 
 */
class product_model extends MY_Model
{

    public function products($data)
    {
        $list = $this->_products($data);
        return $list;
    }

    public function _products($data, $all = null)
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
                        'filed' => 'id',
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
            . $this->db->dbprefix('product_items') . ' as article  '
            . ' left join '
            . $this->db->dbprefix('product_category') . ' as category '
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
            . $this->db->dbprefix('product_items') . ' as article  '
            . ' left join '
            . $this->db->dbprefix('product_category') . ' as category '
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
    public function product($aid)
    {
        $articleInfo = $this->_product($aid);
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
    private function _product($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'article',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_productSQL($where);
        return $result;
    }

    private function _productSQL($where)
    {
        $where = $this->One($where);
        $sql = "select article.*, category.title as catetitle from "
            . $this->db->dbprefix('product_items') . ' as article '
            . ' inner join '
            . $this->db->dbprefix('product_category') . ' as category '
            . $where;
        return $this->getRow($sql);
    }

    //上一篇文章
    public function preArticle($id, $cid) {
        $sql = "select id, title from ".$this->db->dbprefix('product_items')
            ." where id < '".$id."' and cateid='".$cid."' and status=1 order by id desc limit 1";
        return $this->getRow($sql);
    }

    //下一篇文章
    public function nextArticle($id, $cid) {
        $sql = "select id, title from ".$this->db->dbprefix('product_items')
            ." where id > '".$id."' and cateid='".$cid."' and status=1 order by id desc limit 1";
        return $this->getRow($sql);
    }

    //添加文章
    public function addArticle($data)
    {
        $data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('product_items', $data);
    }

    //浏览文章
    public function viewProduct($id, $pv)
    {
        $data = array(
            'pv' => $pv
        );
        return $this->update('product_items', $data, $id);
    }

    //编辑文章
    public function updateArticle($id, $data)
    {
        return $this->update('product_items', $data, $id);
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
            . $this->db->dbprefix('product_category') . ' as A  '
            . ' left join '
            . $this->db->dbprefix('product_category') . ' as B '
            . ' on A.fid= B.id'
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
            . $this->db->dbprefix('product_category') . ' as A  '
            . ' left join '
            . $this->db->dbprefix('product_category') . ' as B '
            . ' on A.fid= B.id'
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
        $sql = "select category.*  from "
            . $this->db->dbprefix('product_category') . ' as category '
            . $where;
        return $this->getRow($sql);
    }

    //添加文章
    public function addcategory($data)
    {
        #$data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('product_category', $data);
    }

    //编辑文章
    public function updatecategory($id, $data)
    {
        return $this->update('product_category', $data, $id);
    }

}