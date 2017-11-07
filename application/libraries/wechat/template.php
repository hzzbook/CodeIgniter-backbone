<?php
/**
 * 推送模版消息
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/5/25
 * 
 */
include_once('wechat.php');
class Template extends Wechat
{

    /**
     * 模板信息推送
     *
     * @param $access_token 访问令牌
     * @param $openid   已经关注了公众号的微信id
     * @param $template_id  模板id
     * @param $data     具体的数据
     *  $data =array(
            'key' => array('value' => '', 'color' => '173177'),
     * );
     */
    public function send($access_token, $openid, $template_id, $data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
        $input = array(
            "touser" => $openid,
            "template_id" => $template_id,
            'topcolor' => '#FF0000',
            "data" => $data
        );
        $input = json_encode($input);
        $res = $this->curl->post($url, $input);
        return $res;
    }

}