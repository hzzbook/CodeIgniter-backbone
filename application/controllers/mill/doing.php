<?php
/**
 * 用户行为研究
 * 说明：
 * 什么时间，什么地点，什么人，做什么事
 * 得到什么结果
 * @Author: hzz
 * @Date: 2017/10/17
 * 
 */
class doing extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //设计模式
    public function index()
    {

    }

    public function loginDo($data)
    {
        //判断用户的身份



    }

    public function login()
    {
        //
        echo "登录操作";
        $DoData = array(
            'uid' => '123',
            'time' => '2017-10-17 17:42',
            'ip' => '124.20.34.23',
            'channel' => 'app'
        );


    }

    //签到
    public function sign()
    {

    }

    #分页模式
    public function page()
    {
        
    }






}