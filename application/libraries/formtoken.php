<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/3/1
 * 
 */
class formtoken
{
    var $ci;
    public function __construct()
    {
        $this->ci =& get_instance();
    }

    //获取新的token
    public function get($key)
    {
        return $this->create($key);
    }

    //生成新的token
    public function create($key)
    {
        $tokenkey = 'form_'.$key;
        $tokenvalue= $this->random();
        $this->ci->session->set_userdata(array($tokenkey=> $tokenvalue));
        return $tokenvalue;
    }

    public function random($length=12)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $password;
    }

    //判断token是否正确
    public function check($key, $value)
    {
        $tokenkey = 'form_'.$key;
        $tokenvalue = $this->ci->session->userdata($tokenkey);

        if ($value == $tokenvalue)
        {
            $this->ci->session->set_userdata(array($tokenkey=> ''));
            $back = array(
                'status' => 'true'
            );
            return $back;
        } else {
            $newvalue = $this->create($key);
            $back = array(
                'status' => 'false',
                'token'  => $newvalue
            );
            return $back;
        }
    }

    //判断不能为空的字段
    public function blank($format, $input)
    {
        foreach ($format as $key => $value)
        {
            if (isset($input[$value]) && $input[$value] !='') {

            } else {
                return false;
            }
        }
        return true;
    }

}