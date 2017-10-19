<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/1/16
 * 
 */

class backbone extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
            'slider_tag' => '',
            'slider' => '',
        );
        $this->display('backbone/index', $data);
    }


}