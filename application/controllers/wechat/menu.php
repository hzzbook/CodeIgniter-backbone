<?php
/**
 *
 * 微信菜单修改
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/14
 * 
 */
include 'backbone.php';
class menu extends backbone
{
    protected $_wxmenu;

    public function __construct()
    {
        parent::get_instance();
        $this->load->library('wechat/menu');
        $this->_wxmenu = new Menu();
    }

    public function index()
    {
        $this->load->view('wechat/menu');
    }

    #获取菜单信息
    public function getMenu()
    {
        $token = $this->getToken();
        $res = $this->_wxmenu->get($token);
        return $res;
    }

    #创建修改菜单
    public function createMenu()
    {
        $post = $this->input->post();

        $menuInput = array();

        $token = $this->getToken();
        $res = $this->_wxmenu->create($token, $menuInput);

    }

    public function deleteMenu()
    {
        $token = $this->getToken();
        $res = $this->_wxmenu->delete($token);
    }



}