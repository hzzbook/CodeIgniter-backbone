<?php
/**
 * 微信用户管理
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2016/10/26
 * 
 */
include_once('wechat.php');
class User extends Wechat
{

    /**
     * 创建分组
     * @param $access_token
     */
    public function createGroups($access_token, $name)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/groups/create?access_token=$access_token";
        $data = array(
            "group" => array(
                'name' => $name
            )
        );
        $data = json_encode($data);
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 获取分组
     */
    public function getGroups($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/groups/get?access_token=$access_token";
        $data = '';
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 查询用户所在分组
     */
    public function getidGroups($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/groups/getid?access_token=$access_token";
        $data = array(
            'openid' => $openid
        );
        $data = json_encode($data);
        $res = $this->curl->post($url, $data);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 更新分组名称
     *
     */
    public function updateGroups($access_token, $id, $name)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/groups/update?access_token=$access_token";
        $data = array(
            "group" => array(
                "id" => $id,
                "name" => $name
            )
        );
        $json = json_encode($data);
        $res = $this->curl->post($url, $json);
        $back = json_decode($res, true);
        return $back;
    }

    //移动用户分组
    public function updateMembers($access_token, $openid, $id) {
        $url = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=$access_token";
        $data = array(
            'openid' => $openid,	//用户唯一标识符
            'to_groupid' => $id						//分组ID
        );
        $json = json_encode($data);
        $res = $this->curl->post($url, $json);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 批量移动用户分组
     * @param $access_token
     * @param $list 用户标识符数组
     * @param $id   用户组ID
     * @return mixed
     */
    public function batchaupdate ($access_token, $list, $id) {
        $ACCESS_TOKEN = $this->token;
        $url = "https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate?access_token=$access_token";
        $data = array(
            'openid_list' => $list,
            'to_group' => $id
        );
        $json = json_encode($data);

        $res = $this->curl->post($url, $json);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 删除分组
     */
    public function deleteGroups($access_token, $id)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/groups/delete?access_token=$access_token";
        $data = array(
            'group' => array(
                'id' => $id
            )
        );
        $json = json_encode($data);
        $res = $this->curl->post($url, $json);
        $back = json_decode($res, true);
        return $back;
    }

    /**
     * 获取用户所在分组
     * @param $access_token
     * @param $openid
     * @return mixed
     */
    public function get($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$openid";
        $json = '';
        $res = $this->curl->post($url, $json);
        $res = json_decode($res, true);
        return $res;
    }

    /**
     * 获取用户信息
     * @param $access_token
     * @param $openid
     */
    public function info($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $json = '';
        $res = $this->curl->post($url, $json);
        $res = json_decode($res, true);
        return $res;
    }

}