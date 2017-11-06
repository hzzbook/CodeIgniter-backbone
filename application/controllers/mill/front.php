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

    #普通后端渲染页面
    public function normalPage()
    {
        $output = array(
            'title' => "后端渲染页面",
            'lists' => array(
                array(
                    'title' => "AAAA1",
                    'price' => "100",
                ),
                array(
                    'title' => "AAAA2",
                    'price' => "100",
                ),
                array(
                    'title' => "AAAA3",
                    'price' => "100",
                ),
            ),
        );
        $this->load->view('mill/front/normal', $output);
    }

    #前后端分离页面
    public function separationPage()
    {
        $this->load->view('mill/front/separation');
    }

    #前端模板引擎
    public function template()
    {
        $this->load->view('mill/front/template');
    }

    #后端单条数据
    public function item()
    {
        $output = array(

        );
        echo json_encode($output);
    }

    #后端多条数据
    public function lists()
    {
        $output = array(

        );
        echo json_encode($output);
    }
}