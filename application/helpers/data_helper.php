<?php
/**
 * 赋予view直接获取数据的方法
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/13
 * 
 */

function data_lists($table, $num = 10, $page = 1, $order = 'desc')
{
    $CI = &get_instance();
    $start = ($page - 1) * $num;
    $limit = " limit $start, $num ";
    $sql = "select * from "
        . $CI->db->dbprefix($table)
        . " order by id $order"
        . $limit ;
    $result = $CI->db->query($sql);
    return $result->result_array();
}

function data_item($table, $id, $filed = 'id')
{
    $CI = &get_instance();
    $sql = "select * from "
        . $CI->db->dbprefix($table)
        . "where $filed = '{$id}'";
    $result = $CI->db->query($sql);
    return $result->row_array();
}