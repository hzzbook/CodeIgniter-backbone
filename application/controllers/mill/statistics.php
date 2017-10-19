<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/9/21
 * 
 */

class statistics extends MY_Controller
{
    public function display($view, $data = null)
    {
        $path  = 'statistics/';
        $this->load->view($path.$view, $data);
    }

    public function index()
    {
        $this->display('index');
    }




}