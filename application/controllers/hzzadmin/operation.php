<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/1/17
 * 
 */

class operation extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
            'slider_tag' => 'operation',
            'nav_tag' => 'index'
        );
        $this->display('backbone/operation/index', $data);
    }

    public function sms()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],

        );
        $this->display('backbone/operation/smsPage', $data);
    }

    public function postemail()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],

        );
        $this->display('backbone/operation/emailPage', $data);
    }

    public function postmsg()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],

        );
        $this->display('backbone/operation/msgPage', $data);
    }
}