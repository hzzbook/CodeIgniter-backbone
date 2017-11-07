<?php
/**
 *  微信消息处理主控制器
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/9/11
 * 
 */
class backbone extends  MY_Controller
{
    public function __construct() {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
        $this->load->driver('cache', array('adapter' => 'file'));
    }

    public function getToken() {
        $res = $this->_getToken();
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
    private function _getToken() {
        $this->load->library('wechat/Wxbase');
        $Wxbase = new Wxbase();
        $token = $Wxbase->token();
        return $token;
    }

    //内部
    public function getTokenFromIn() {
        //$token = $this->session->userdata('access_token');
        //$token = $this->cache->get('access_token');
        $token = '';
        if ($token == '') {
            $res = $this->_getToken();
            //如果没有正确获取懂Token,返回错误消息

            //$this->cache->save("access_token", $res, 7200);
            $this->session->set_userdata(array('access_token'=> $res['access_token']));
            $token = $res['access_token'];
        }
        return $token;
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

        $this->load->library('wechat/Wxbase');
        $Wxbase = new Wxbase();
        $token = $Wxbase->checkSignature($signature, $timestamp, $nonce);
        if ($token === true) {
            return true;
        } else {
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