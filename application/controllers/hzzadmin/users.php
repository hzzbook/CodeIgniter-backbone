<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/1/16
 * 
 */

class users extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 用户列表主页
     */
    public function index()
    {
        $data = array(
            'slider_tag' => 'users',
            'nav_tag' => 'index'
        );
        $this->display('backbone/users/index', $data);
    }

    public function userlist()
    {
        $input = $this->input->post();
        $this->load->model('core/user_model', 'model');
        $res = $this->model->lists($input);
        #
        if ($res['status'] == 'true')
        {
            echo urldecode(json_encode($res));
        } else
            echo urldecode(json_encode($res));
    }

    /**
     * 用户详细信息页
     */
    public function info()
    {
        $data = array(
            'slider_tag' => 'users',
            'nav_tag' => 'info'
        );
        $this->display('backbone/users/info', $data);
    }

    /**
     * 实名认证列表
     */
    public function realauth()
    {
        $data = array(
            'slider_tag' => 'users',
            'nav_tag' => 'realauth'
        );
        $this->display('backbone/users/realauth', $data);
    }

    /**
     * 绑定银行卡列表
     */
    public function bankcard()
    {
        $data = array(
            'slider_tag' => 'users',
            'nav_tag' => 'bankcard'
        );
        $this->display('backbone/users/bankcard', $data);
    }

    /**
     * 黑名单
     */
    public function blacklist()
    {
        $data = array(
            'slider_tag' => 'users',
            'nav_tag' => 'blacklist'
        );
        $this->display('backbone/users/blacklist', $data);
    }



}