<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2016/10/26
 * 
 */
include('curl.php');
class Wechat
{
    public $curl;
    public function __construct()
    {
        $this->curl = new Curl;
    }
}