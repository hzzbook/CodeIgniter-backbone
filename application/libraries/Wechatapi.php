<?php

include_once('curl.php');
class Wechatapi {
	
	var $curl;
	public function __construct() {
		$this->curl = new Curl();
	}
	
	/**
	 * 
	 * 获取用户信息
	 * @param string $OPENID
	 * @param string $token
	 * @return mixed
	 */
	public function getUserInfo($OPENID, $token) {
		$ACCESS_TOKEN = $token;
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$ACCESS_TOKEN&openid=$OPENID&lang=zh_CN";
		$json = '';
		$res = $this->curl->post($url, $json);
		$res = json_decode($res, true);
		return $res;
	}
	
	/**
	 * 
	 * 获得Ticket
	 * @param unknown_type $token
	 */
	public function getQrcodeTicket($token) {
		$ACCESS_TOKEN = $token;
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$ACCESS_TOKEN";
		$json = '{"expire_seconds": 604800, "action_name": "QR_SCENE", 	"action_info": {"scene": {"scene_id": 123}}}';
		$res = $this->curl->post($url, $json);
		$res = json_decode($res, true);
		return $res;
	}
	
	/**
	 * 
	 * 根据Ticket换二维码
	 * 
	 */
	public function getQrcode($ticket, $scen_id=1) {
		$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
		$json = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scen_id.'}}}';
		$res = $this->curl->post($url, $json);
		$res = json_decode($res, true);
		return $res;
	}
	
}