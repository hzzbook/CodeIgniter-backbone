<?php
/**
 * JSSDK 类
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2016/10/26
 * 
 */
include_once('wechat.php');
class Jssdk extends Wechat
{

    /**
     * 获取jssdk使用的token凭证
     * @param $APPID
     * @param $APPSECRET
     */
    public function token($APPID, $APPSECRET)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$APPSECRET";
        $res = $this->curl->post($url, '');
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 获取ticket
     * @param $token
     * @return mixed
     */
    public function getticket($token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$token";
        $res = $this->curl->post($url, '');
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 获取签名
     */
    public function getsignPackage($token, $APPID)
    {
        $jsapiTicket = $this->getticket($token);
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCI 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $APPID,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    /**
     * 创建随机字符串
     * @param int $length
     * @return string
     */
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


}