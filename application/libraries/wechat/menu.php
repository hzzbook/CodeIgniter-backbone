<?php
/**
 * 微信的菜单接口
 *
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2016/10/26
 * 
 */
include_once('wechat.php');
class Menu extends Wechat
{
    /**
     * 删除按钮
     * @param $access_token
     * @return mixed
     */
    public function delete($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=$access_token";
        $res = $this->curl->post($url, '');
        return $res;
    }

    /*
     * 获取微信公众号的菜单项
     */
    public function get($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$access_token";
        $data = '';
        $res = $this->curl->post($url, $data);
        return $res;
    }

    /**
     * 创建菜单
     */
    public function create($access_token, $data)
    {
        /*$data = '{
		     "button":[
		      {
		           "name":"H5页面",
		           "sub_button":[
		             {
		                    "type":"view",
		             		 "name":"商城",
		               		"url":"http://wechat.hzzbook.com/emall"
		             },
					 {
		               		"type":"view",
		             		 "name":"查订单",
		               		"url":"http://wechat.hzzbook.com/order"
		            },
					{
		            		"type":"view",
		             		 "name":"个人中心",
		               		"url":"http://wechat.hzzbook.com/ucenter"
			        },
					{
		               "type":"view",
		               "name":"游戏",
		               "url":"http://wechat.hzzbook.com/game"
		            },{
		               "type":"view",
		               "name":"授权用户信息",
		               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxadb649788ff73a41&redirect_uri=http%3A%2F%2Fwechat.hzzbook.com%2Fpage%2Forderlist&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
		            }]
		       },
			   {
		           "name":"功能大全",
		           "sub_button":[
		             {
		                  "type":"click",
		              	 "name":"签到",
		                  "key":"signup"
		                },
					 {
		               "type":"view",
		               "name":"jssdk页面",
		               "url":"http://wechat.hzzbook.com/jssdk"
		            },
					{
			            "type":"view",
			             "name":"卡券",
			             "url":"http://wechat.hzzbook.com/coupons"
			        },
					{
		               "type":"view",
		               "name":"G4",
		               "url":"http://version2.gftp2p.com/book/game/g4.php"
		            }]
		       },
				{
		           "name":"更多功能",
		           "sub_button":[
		            {
		               "type":"click",
		               "name":"文字回复",
		               "key":"textback"
		            },
					{
		              	"type":"click",
		               "name":"图文回复",
		               "key":"picback"
		            },
					    {
		                    "type":"click",
		               		"name":"多图文回复",
		               		"key":"morepicback"
		                },
					{
		                    "type":"click",
		               		"name":"临时二维码",
		               		"key":"qrcode1"
		            },
		            {
		                    "type":"click",
		               		"name":"永久二维码",
		               		"key":"qrcode"
		            }
		            ]
		       }
			 ]
		 }';*/
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $res = $this->curl->post($url, $data);
        return $res;
    }


}