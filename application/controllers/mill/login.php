<?php
/**
 *
 * 第三方登录
 * 说明：
 * 1、微信登录
 * 2、QQ登录
 * 3、微博登录
 *
 *
 * @Author: hzz
 * @Date: 2017/11/6
 * 
 */
class login extends MY_Controller
{

    public function wechatWebLogin()
    {

    }

    public function index()
    {
        $this->load->view('mill/login/index');
    }

}