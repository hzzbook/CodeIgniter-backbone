<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 22:01
 */
class category_model extends Temp_model
{
    var $table = 'cms_category';

    var $where = array(
        'id' => array(
            'filed' => 'id',
            'expression' => '='
        ),
        'cate' => array(
            'filed' => 'fid',
            'expression' => '='
        ),
    );

}