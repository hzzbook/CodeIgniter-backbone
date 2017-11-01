<?php
/**
 *  前端控制器
 *
 * 前后端设计方案
 *
 * User: hzz
 * Date: 2017/9/21
 * Time: 23:34
 */

class front extends MY_Controller
{
    public function index()
    {
        $this->load->view('mill/front/index');
    }

    public function page()
    {

    }

    public function item()
    {
        $output = array(

        );
        echo json_encode($output);
    }

    public function lists()
    {
        $output = array(

        );
        echo json_encode($output);
    }
}