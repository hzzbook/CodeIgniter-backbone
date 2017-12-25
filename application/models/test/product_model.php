<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/10/24
 * 
 */
class product_model extends Temp_model
{

    var $table = 'test_product';
    var $primary_key = 'id';

    var $where = array(
        'brand' => array(  #分类筛选
            'table' => '',
            'filed' => 'brand',
            'expression' => '='
        ),
        'price1' => array(
            'table' => '',
            'filed' => 'price',
            'expression' => '>='
        ),
        'price2' => array(
            'filed' => 'price',
            'expression' => '<='
        )
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

    var $order = array(
        'price_desc' => array(  #价格由高到低
            'table' => '',
            'filed' => 'price',
            'orderby' => 'desc'
        ),
        'price_asc' => array(   #价格由低到高
            'table' => '',
            'filed' => 'price',
            'orderby' => 'asc'
        ),
        'default' => array(       #最新
            'table' => '',
            'filed' => 'logtime',
            'orderby' => 'desc'
        ),
    );

}