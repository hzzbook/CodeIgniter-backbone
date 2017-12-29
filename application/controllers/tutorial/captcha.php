<?php
/**
 * 验证码
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/6
 * 
 */
class captcha extends MY_Controller
{

    public function geetest()
    {
        $this->load->view('mill/notice/geetest');
    }

    public function startCaptcha()
    {
        $data = array(
            "user_id" => "test", # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
        );
        $this->load->library('geetest');
        $geetest = new Geetest();
        $geetest->pre_process($data);
        echo $geetest->get_response_str();
    }

    private function validateCaptcha($challenge, $validate, $code, $data)
    {
        $this->load->library('geetest');
        $geetest = new Geetest();
        $result = $geetest->validate($challenge, $validate, $code, $data);
        return $result;
    }

    public function login()
    {
        $data = array(
            "user_id" => "test", # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
        );
        $challenge = $this->input->post('geetest_challenge');
        $validate = $this->input->post('geetest_validate');
        $code = $this->input->post('geetest_seccode');
        if ($this->validateCaptcha($challenge, $validate, $code, $data))
        {
            #图形验证码通过验证
            echo "登录成功";
        } else {
            echo "登录失败";
        }
    }



}