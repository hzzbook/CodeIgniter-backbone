<?php
/**
 * 素材管理
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2016/10/26
 * 
 */
include_once('wechat.php');
class Media
{

    //上传临时素材
    public function upload($access_token, $TYPE)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$access_token&type=$TYPE";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    //获取临时素材
    public function get($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=MEDIA_ID";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    //增加永久图文素材
    public function add_news($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=$access_token";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    //获取永久素材
    public function get_material($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=$access_token";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    //删除永久素材
    public function del_material($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$access_token";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    //修改永久图文素材
    public function update_news($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=$access_token";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    //获取素材总数
    public function get_materialcount($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=$access_token";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    //获取素材列表
    public function batchget_material($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$access_token";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }


}