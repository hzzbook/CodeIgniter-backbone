<?php
/**
 * 支付宝支付类
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/7
 * 
 */
require_once 'alipay/pagepay/service/AlipayTradeService.php';
require_once 'alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';
class Alipay
{
    var $Alipay_config;
    var $alipayService;

    public function __construct()
    {
        if ( ! file_exists($file_path = APPPATH.'config/thirdpart.php'))
        {
            show_error('The configuration file thirdpart.php does not exist.');
        } else {
            include($file_path);        #包含Mailer配置文件
        }
        if (!isset($Alipay_config)) {
            show_error('The Alipay_config does not exist.');
        } else {
            $this->Alipay_config = $Alipay_config;
            $this->alipaySevice = new AlipayTradeService($Alipay_config);
        }
    }

    //请求支付
    /**
     * @param $out_trade_no     商户订单号
     * @param $subject          订单名称
     * @param $total_amount     付款金额
     * @param string $body      商品描述    可空
     */
    public function pay($out_trade_no, $subject, $total_amount, $body = '')
    {
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $response = $this->alipaySevice->pagePay($payRequestBuilder, $this->Alipay_config['return_url'], $this->Alipay_config['notify_url']);
        return $response;
    }

    //同步跳转
    public function notify($input)
    {
        $result = $this->alipayService->check($input);
        return $result;
    }

    //异步通知
    public function returnback($input)
    {
        $result = $this->alipayService->check($input);
        return $result;
    }
}