<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/6
 * 
 */
define("CAPTCHA_ID", "XXXX");
define("PRIVATE_KEY", "XXXX");
require_once('gt3/lib/class.geetestlib.php');
class Geetest
{
    var $single;

    public function __construct($id = CAPTCHA_ID, $key = PRIVATE_KEY)
    {
        $this->single = new GeetestLib($id, $key);
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