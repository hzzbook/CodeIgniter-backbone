<?php
/**
 *  微信消息处理主控制器
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/9/11
 * 
 */
define("TOKEN", 'weixin');
define("APPID", "");
define("APPSECRET", "");

class backbone extends  MY_Controller
{
    public function __construct() {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
        $this->load->library('curl');
        $this->load->driver('cache', array('adapter' => 'file'));
    }

    public function getToken() {
        $appid = $this->input->post('appid');
        $appsecret = $this->input->post('appsecret');
        $res = $this->_getToken($appid, $appsecret);
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            // ajax 请求的处理方式
            echo $res['access_token'];
        }else{
            // 正常请求的处理方式
            // $this->session->set_userdata($res);
            var_dump($res);
        };
    }

    //获取凭证
    private function _getToken($appid = '', $appsecret = '') {
        $appid == '' ? $APPID = $this->input->post('appid') : $APPID = $appid;
        $appsecret == '' ? $APPSECRET = $this->input->post('appsecret') : $APPSECRET = $appsecret;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$APPSECRET";
        $data = '';
        $res = $this->curl->post($url, $data);
        $data = json_decode($res, true);
        return $data;
    }

    //内部
    public function getTokenFromIn() {
        //$token = $this->session->userdata('access_token');
        //$token = $this->cache->get('access_token');
        $token = '';
        if ($token == '') {
            $appid = APPID;
            $appsecret = APPSECRET;
            $res = $this->_getToken($appid, $appsecret);
            //如果没有正确获取懂Token,返回错误消息

            //$this->cache->save("access_token", $res, 7200);
            $this->session->set_userdata(array('access_token'=> $res['access_token']));
            $token = $res['access_token'];
        }
        return $token;
    }

    public function getWxIP() {
        $ACCESS_TOKEN = $this->getTokenFromIn();
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$ACCESS_TOKEN";
        $data = '';
        $res = $this->curl->post($url, $data);
        $data = json_decode($res, true);
        var_dump($data);
        return $data;
    }

    function index()
    {
        echo "Goood luck to you!";
    }

    //微信接口配置url
    public function service()
    {
        if (!isset($_GET['echostr'])) {
            $this->responseMsg();
        }else{
            $this->checkSignature();
        }
    }

    //验证消息真实性
    private function checkSignature() {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        if ($this->_checkSignature($signature, $timestamp, $nonce) === true) {
            echo $echoStr;
            return true;
        } else {
            return false;
        }
    }

    private function _checkSignature($signature, $timestamp, $nonce) {
        $token = TOKEN;
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

    //接收用户请求信息
    public function responseMsg() {
        $token = $this->getTokenFromIn();

        $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch ($RX_TYPE)
            {
                case "text":	//字符串消息
                  /*  $this->load->controller("wx/msg", 'msg');
                    $resultStr = $this->msg->receiveText($postObj, $token);*/
                    break;
                case "image":	//图片消息
                    /*$this->load->controller("wx/msg", 'msg');
                    $resultStr = $this->msg->receiveImage($postObj);*/
                    break;
                case "voice":	//音频消息
                    /*$this->load->controller("wx/msg", 'msg');
                    $resultStr = $this->msg->reviceVoice($postObj);*/
                    break;
                case "video":	//视频消息
                    /*$this->load->controller("wx/msg", 'msg');
                    $resultStr = $this->msg->reviceVideo($postObj);*/
                    break;
                case "shortvideo":	//短视频
                    /*$this->load->controller("wx/msg", 'msg');
                    $resultStr = $this->msg->reviceShortvideo($postObj);*/
                    break;
                case "location":	//地理位置
                    /*$this->load->controller("wx/msg", 'msg');
                    $resultStr = $this->msg->reviceLocation($postObj);*/
                    break;
                case "link":	//链接
                    /*$this->load->controller("wx/msg", 'msg');
                    $resultStr = $this->msg->reviceLink($postObj);*/
                    break;
                case "event":	//事件
                    /*$this->load->controller('wx/event', 'event');
                    $resultStr = $this->event->receiveEvent($postObj);*/
                    break;
                default:
                    $resultStr = "";
                    break;
            }
            //$result = $this->formatXML($postObj, $resultStr);
            //$this->log($postObj);
            echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }


}