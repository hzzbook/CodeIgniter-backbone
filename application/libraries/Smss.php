<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/6
 * 
 */
include_once("./smss/CCPRestSmsSDK.php");
class Smss
{

    //主帐号,对应开官网发者主账号下的 ACCOUNT SID
    var $accountSid= '';

    //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
    var $accountToken= '';

    //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
    //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
    var $appId='';

    //请求地址
    //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
    //生产环境（用户应用上线使用）：app.cloopen.com
    var $serverIP='app.cloopen.com';


    //请求端口，生产环境和沙盒环境一致
    var $serverPort='8883';

    //REST版本号，在官网文档REST介绍中获得。
    var $softVersion='2013-12-26';

    function __construct() {
        if ( ! file_exists($file_path = APPPATH.'config/thirdpart.php'))
        {
            show_error('The configuration file thirdpart.php does not exist.');
        } else {
            include($file_path);
        }
        if (!isset($CCP)) {
            show_error('The CCP does not exist.');
        } else {
            $this->accountSid = $CCP['accountSid'];
            $this->accountToken = $CCP['accountToken'];
            $this->appId = $CCP['appId'];
        }
    }


    /**
     * 发送模板短信
     * @param to 手机号码集合,用英文逗号分开
     * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
     * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
     */
    function sendTemplateSMS($to,$datas,$tempId)
    {
        // 初始化REST SDK
        global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
        $rest = new REST($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);

        // 发送模板短信
        echo "Sending TemplateSMS to $to <br/>";
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL ) {
            echo "result error!";exit;
        }
        if($result->statusCode!=0) {
            echo "error code :" . $result->statusCode . "<br>";
            echo "error msg :" . $result->statusMsg . "<br>";
            //TODO 添加错误处理逻辑
        }else{
            echo "Sendind TemplateSMS success!<br/>";
            // 获取返回信息
            $smsmessage = $result->TemplateSMS;
            echo "dateCreated:".$smsmessage->dateCreated."<br/>";
            echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
            //TODO 添加成功处理逻辑
        }
    }
}