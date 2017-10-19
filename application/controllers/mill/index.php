<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/9/25
 * 
 */
class index extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('mill');
    }

    public function begin()
    {
        $this->load->view('mill/begin');
    }

}