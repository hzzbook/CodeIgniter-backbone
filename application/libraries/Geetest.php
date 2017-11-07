<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/6
 * 
 */
require_once('gt3/lib/class.geetestlib.php');
class Geetest
{
    var $single;

    public function __construct()
    {
        if ( ! file_exists($file_path = APPPATH.'config/thirdpart.php'))
        {
            show_error('The configuration file thirdpart.php does not exist.');
        } else {
            include($file_path);        #包含Mailer配置文件
        }
        if (!isset($Geetest_config)) {
            show_error('The Alipay_config does not exist.');
        } else {
            $id = $Geetest_config['captcha_id'];
            $key = $Geetest_config['private_key'];
            $this->single = new GeetestLib($id, $key);
        }
    }

    public function pre_process($data)
    {
        return $this->single->pre_process($data, 1);
    }

    public function get_response_str()
    {
        return $this->single->get_response_str();
    }

    public function validate($challenge, $validate, $seccode, $data)
    {
        return  $this->single->success_validate($challenge, $validate, $seccode, $data);
    }




}