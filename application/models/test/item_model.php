<?php
/**
 * 测试模型
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/8/29
 * 
 */
class item_model extends Temp_model
{
    #表名
    var $table = 'test_item';
    #表的别名
    var $alias = 'item';
    #关联表
    var $link = array(
        'test_cate' => array(
            'alias' => 'cate',
            'relation_id' => 'id',
            'foreign_key' => 'cateid',
        ),
        'test_user' => array(
            'alias' => 'users',
            'relation_id' => 'id',
            'foreign_key' => 'authorid',
        ),
    );

    #设置唯一查询的列
    var $itemKey = array(
        'id' => array(
            'filed' => 'id'
        ),
        'content' => array(
            'filed' => 'content'
        ),
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
            'filed' => 'catename',
            'table' => 'cate'
        ),
        'authorname' => array(
            'filed' => 'realname',
            'table' => 'users'
        )
    );

    #查询过滤
    var $where = array(
        'cateid' => array(  #分类筛选
            'table' => 'cate',
            'filed' => 'id',
            'expression' => '='
        ),
        'name' => array(
            'table' => '',
            'filed' => 'name',
            'expression' => 'like'
        ),
        'status' => array(
            'filed' => 'status',
            'expression' => '='
        ),
        'starttime' => array(
            'filed' => 'addtime',
            'type' => 'date',
            'expression' => '>='
        ),
        'endtime' => array(
            'filed' => 'addtime',
            'type' => 'date',
            'expression' => '<='
        ),
    );

    var $order = array(
        'id' => array(
            'table' => '',
            'filed' => 'id',
            'orderby' => 'desc'
        ),
    );

    var $limit = array(
        'page' => 1,
        'num'  => 6
    );

    //验证
    var $_validate = array(

    );

    var $column2 = array(

    );

    function setC()
    {
        $this->setColumn($this->column2);
    }

}