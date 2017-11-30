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

    public function normalPage()
    {
        $data = array(
            'slider_tag' => 'operation',
            'nav_tag' => 'normalPage'
        );
        $this->display('backbone/operation/normalPage', $data);
    }

    public function channelsPage()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],

        );
        $this->display('backbone/operation/channelsPage', $data);
    }

    public function channelAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create($classinfo['function']);

        $node = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'   => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $node);
    }

    public function linkAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create($classinfo['function']);

        $node = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'   => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $node);
    }

    public function channelAdd()
    {
        $input = $this->input->post();
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->check($classinfo['function'].'Page', $input['token']);
        if ($token === true)
        {
            $back = array(
                'status' => 'false',
                'code'   => '868',
                'info'   => urlencode('表单token失效'),
                'token'  => $token['token']
            );
            echo urldecode(json_encode($back)); exit;
        }
        unset($input['token']);

        $checkForm = array(         //必填字段
            'name',
        );
        if ($this->formtoken->blank($checkForm, $input) == false)
        {
            $back = array(
                'status' => 'false',
                'code'   => '869',
                'info'   => urldecode('确认必填项填写完毕')
            );
            echo urldecode(json_encode($back)); exit;
        }
        $this->load->model('operation/channel_model', 'channel_model');
        $res = $this->channel_model->itemAdd($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加权限结点成功'),
                'id'     => $res        #返回权限结点ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('添加权限结点失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    public function channelUpdatePage()
    {
        $id = $this->input->get_post('id');

        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create($classinfo['function']);
        $node = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'   => $token,
            'id'      => $id
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $node);
    }

    public function linkUpdatePage()
    {
        $id = $this->input->get_post('id');

        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create($classinfo['function']);
        $node = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'   => $token,
            'id'      => $id
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $node);
    }

}