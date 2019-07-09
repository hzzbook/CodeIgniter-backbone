<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 22:01
 */
class article_model extends Temp_model
{
    var $table = 'cms_article';
    var $alias = 'article';
    #关联表
    var $link = array(
        'cms_category' => array(
             'alias' => 'cate',
             'relation_id' => 'id',
             'foreign_key' => 'cateid',
         )
    );

    var $column = array(
        'id' => array(
             'filed' => 'id'
         ),
         'name' => array(
             'filed' => 'name'
         ),
         'cateid' => array(
             'filed' => 'cateid'
         ),
         'content' => array(
             'filed' => 'content'
         ),
         'cover' => array(
             'filed' => 'cover'
         ),
         'status' => array(
             'filed' => 'status'
         ),
         'authorid' => array(
             'filed' => 'authorid'
         ),
         'addtime' => array(
             'filed' => 'addtime'
         ),
         'catename' => array(
             'filed' => 'title',
             'table' => 'cate'
         )
    );

    #查询过滤
    var $where = array(
        'cate' => array(  #分类筛选
            'table' => 'cate',
            'filed' => 'id',
            'expression' => '='
        ),
        'title' => array(
            'table' => '',
            'filed' => 'title',
            'expression' => 'like'
        ),
        'status' => array(
            'filed' => 'status',
            'expression' => '='
        ),
        'start' => array(
            'filed' => 'logtime',
            'type' => 'time',
            'expression' => '>='
        ),
        'end' => array(
            'filed' => 'logtime',
            'type' => 'time',
            'expression' => '<='
        ),
    );

    var $order = array(
        'id' => array(
             'table' => '',
             'filed' => 'id'
         ),
    );

    public function __construct()
    {
        parent::__construct();
    }

    public function articleAdd($data)
    {
        $data['logtime'] = date('Y-m-d H:i:s');
        return $this->itemAdd($data);
    }

    //上一篇文章
    public function preArticle($id, $cid = '')
    {
        if ($cid == '') {
            $itemInfo = $this->item($id);
            $cid = $itemInfo['data']['cateid'];
        }

        $sql = "select * from ".$this->db->dbprefix('cms_article')
            ." where id < '".$id."' and cateid='".$cid."' and status=1 order by id desc limit 1";
        return $this->getRow($sql);
    }

    //下一篇文章
    public function nextArticle($id, $cid = '')
    {
        if ($cid == '') {
            $itemInfo = $this->item($id);
            $cid = $itemInfo['data']['cateid'];
        }
        $sql = "select * from ".$this->db->dbprefix('cms_article')
            ." where id > '".$id."' and cateid='".$cid."' and status=1 order by id asc limit 1";
        return $this->getRow($sql);
    }

/*    public function nextArticleMore($id)
    {
        $itemInfo = $this->item($id);
        $cid = $itemInfo['data']['cateid'];

        $sql = "select * from ".$this->db->dbprefix('cms_article')
            ." where id > '".$id."' and cateid='".$cid."' and status=1 order by id asc limit 1";

        return $this->getRow($sql);
    }*/

    public function nextLists($id, $page = 1, $num = 10)
    {
        $s = array(
            'cate' => $id,
            'page' => $page + 1,
            'pagenum' => $num,
        );
        return $this->lists($s);
    }

    public function website() {
        $sql = "select * from "
            . $this->db->dbprefix('system_setting');
        return $this->getResult($sql);
    }

}