<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/3/13
 * 
 */

class product extends frontbase
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model', 'model');
    }

    /**
     * 产品列表首页
     */
    public function index($id = null)
    {
        $input = $this->input->get();
        if (isset($input['page']) && $input['page'] != '')
        {
            $page = intval($input['page']);
        } else {
            $page = 1;
        }
        if ($id == '')
            $id = 1;
        $nums = 1;
        $cateInfo = $this->model->category($id);
        $data = array();
        $cate = $this->model->categorys($data);
        $data = array(
            'cate' => $id,
            'num' => $nums,
            'page' => $page,
        );
        $res = $this->model->products($data);

        $this->load->library('Pageclass');
        $get = $this->input->get();
        if (isset($get[$page]) && $get[$page] != '')
            unset($get[$page]);
        if ($get != false && count($get) >= 1)
            $getstring = http_build_query($get).'&';
        else
            $getstring = '';

        $Pageclass = new Pageclass('?'.$getstring, $res['sum'], $page, $nums);
        $pagestring = $Pageclass->show();
        $data = array(
            'nav_key' => 'product',
            'info' => $cateInfo,
            'list'  => $res,
            'cate'  => $cate,
            'pagestring' => $pagestring,
        );
        $this->display('pcweb/product/index', $data);
    }

    public function item($id = null)
    {
        if ($id == '')
        {
            $this->error('404');
        }
        $productInfo = $this->model->product($id);
        $data = array(
            'info' => $productInfo,
        );
        $this->display('pcweb/product/item', $data);
    }

}