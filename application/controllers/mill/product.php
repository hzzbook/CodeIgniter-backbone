<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/9/28
 * 
 */

class product extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('mill/product/index');
    }

    public function item()
    {
        $product = array(
            'id' => '23',
            'name' => '产品名称',
            'price' => '产品价格',
            'sellid' => '28',       #卖家id
            'cateid' => '2',        #产品分类，可能不止一个分类
        );


        $activity1 = array(
            '23'
        );



    }



}