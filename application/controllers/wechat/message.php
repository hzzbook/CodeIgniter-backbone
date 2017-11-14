<?php
/**
 * 微信消息推送
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/14
 * 
 */
include 'backbone.php';
class message extends backbone
{
    protected $_wxmessage;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('wechat/template');
        $this->_wxmessage = new Template();
    }

    public function send($openid, $template_id, $data)
    {
        $token = $this->getToken();
        $res = $this->_wxmessage->send($token, $openid, $template_id, $data);
        return $res;
    }


}