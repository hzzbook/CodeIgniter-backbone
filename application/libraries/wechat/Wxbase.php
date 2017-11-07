<?php
/**
 * 微信基础
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2016/10/26
 * 
 */
include_once('wechat.php');
class Wxbase extends Wechat
{
    var $TOKEN;
    var $APPID;
    var $APPSECRET;

    public function __construct()
    {
        if ( ! file_exists($file_path = APPPATH.'config/thirdpart.php'))
        {
            show_error('The configuration file thirdpart.php does not exist.');
        } else {
            include($file_path);        #包含Mailer配置文件
        }
        if (!isset($Wechat_config)) {
            show_error('The Wechat_config does not exist.');
        } else {
            $this->TOKEN = $Wechat_config['token'];
            $this->APPID = $Wechat_config['appid'];
            $this->APPSECRET = $Wechat_config['appsecret'];
        }
    }

    /**
     * 获取微信服务器的IP地址
     * @param $access_token
     * @return mixed
     */
    public function wechatIP($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$access_token";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 获取token凭证
     *
     * @param $APPID
     * @param $APPSECRET
     * @return mixed
     */
    public function token()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->APPID&secret=$this->APPSECRET";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 获取用户得到二维码的ticket
     * @param $token
     * @param $id
     * @return mixed
     */
    public function qrcode($token, $id)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token";
        $json = '{"expire_seconds": 604800, "action_name": "QR_SCENE", 	"action_info": {"scene": {"scene_id": '.$id.'}}}';
        $res = $this->curl->post($url, $json);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 获取用Ticket换二维码
     * @param $ticket
     * @param $id
     * @return mixed
     */
    public function showQrcode($ticket, $id)
    {
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
        $json = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$id.'}}}';
        $res = $this->curl->post($url, $json);
        $back = json_decode($res, true);
        return $back;
    }

    //验证消息真实性
    public function checkSignature($signature, $timestamp, $nonce) {
        $token = $this->TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

}