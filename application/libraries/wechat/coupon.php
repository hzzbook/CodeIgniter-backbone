<?php
/**
 *  微信卡券
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/5/25
 * 
 */

include_once ('wechat.php');

class Coupon extends Wechat
{

    /**
     * 上传图片
     *
     * @param $access_token
     * @param $buffer       文件的数据流
     */
    public function uploadimg($access_token, $buffer)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=$access_token";
        $res = $this->curl->post($url, $buffer);
        return $res;
    }

    /**
     * 创建卡券
     * @param $access_token
     * @param $post
     * @return mixed|string
     */
    public function create($access_token, $post)
    {
        $url = "https://api.weixin.qq.com/card/create?access_token=$access_token";
        $res = $this->curl->post($url, $post);
        return $res;
    }

}