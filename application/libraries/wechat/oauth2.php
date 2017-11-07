<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2016/10/26
 * 
 */

include_once ('wechat.php');
class Oauth2 extends Wechat
{
    /**
     * 获得token凭证
     * @param $APPID
     * @param $APPSECRET
     * @param $CODE
     * @return mixed|string
     */
    public function access_token($APPID, $APPSECRET, $CODE)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$APPID&secret=$APPSECRET&code=$CODE&grant_type=authorization_code";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 获取刷新token凭证
     * @param $APPID
     * @param $token
     * @return mixed|string
     */
    public function refresh_token($APPID, $token)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$APPID&grant_type=refresh_token&refresh_token=$token";
        $data = '';
        $res = $this->curl->post($url, $data);
        $data = json_decode($res, true);
        return $data;
    }

    /**
     * 获取用户信息
     * @param $token
     * @param $openid
     */
    public function userinfo($token, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

}