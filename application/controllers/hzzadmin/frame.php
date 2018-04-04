<?php
/**
 * 后台搭建框架
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2018/4/3
 * 
 */

class frame extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    #主页-控制面板
    public function index()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function']
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

    #数据列表
    public function tempsPage()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function']
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

    #数据添加
    public function tempAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('aritcle');
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'     => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }


    #数据编辑
    public function tempUpdatePage()
    {
        $id = $this->input->get('id');
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('editaritcle');

        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

    #局部加载
    public function datalist()
    {

    }

    #饼图
    public function pie()
    {
        $data = array(
            'legend' => array(
                '直接访问','邮件营销','联盟广告','视频广告','搜索引擎'
            ),
            'data' => array(
                array('value' => 335, 'name' => '直接访问'),
                array('value' => 310, 'name' => '邮件营销'),
                array('value' => 234, 'name' => '联盟广告'),
                array('value' => 135, 'name' => '视频广告'),
                array('value' => 1548, 'name' => '搜索引擎'),
            )
        );
        echo json_encode($data);
    }

    #线性图
    public function line()
    {
        $get = $this->input->get('date');

        switch($get)
        {
            case 'today':
                $data = array(
                    'xaxis' => array(
                        '2:00','4:00', '6:00', '8:00',
                        '10:00','12:00', '14:00', '16:00',
                        '18:00', '20:00', '22:00', '24:00'
                    ),
                    'data'  => array(
                        20, 40, 80, 30,
                        20, 40, 80, 30,
                        20, 40, 80, 30,
                    )
                );
                break;
            case 'week':
                $data = array(
                    'xaxis' => array(
                        '周一', '周二', '周三', '周四', '周五', '周六', '周日'
                    ),
                    'data' => array(
                        '20', '300', '360', '380', '260', '230', '50', '60'
                    )
                );
                break;
            case 'month':
                $data = array(
                    'xaxis' => array(
                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                    ),
                    'data' => array(
                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                    )
                );
                break;
        }

        echo json_encode($data);
    }






}