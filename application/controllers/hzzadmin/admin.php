<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/3/3 *
 */
class admin extends MY_Controller
{
    public function testlogin()
    {
        $this->session->set_userdata(array('hzzadminid'=> '0'));
    }

    //登录页
    public function login()
    {
        $this->load->library('formtoken');
        $token = $this->formtoken->create('login');
        $data = array(
            'token'     => $token
        );
        $this->load->view('backbone/common/login', $data);
    }

    public function makeCaptcha() {
        $this->load->library('captcha');
        $captcha = new Captcha();
        $captcha->setSence('login');
        $captcha->setSite('100', '30');
        $captcha->create();
    }

    public function captcha()
    {
        $this->load->helper('captcha');
        $this->load->helper('strhelp');
        $word = randomstr(4);
        $vals = array(
            'word'=>$word,
            'img_path' => './public/captcha/',
            'img_url' => $this->config->item('base_url').'/public/captcha/',
            'img_width' => '100',
            'img_height'  => 32,
            'expiration' => 7200
        );

        $cap = create_captcha($vals);

        //将验证码的字符写入session
        $this->session->set_userdata(array('logincaptchacode' => strtolower($word)));

        if (isset($cap['image'])  && $cap['image'] !='') {
            $return = array(
                'status' => 'true',
                'src' => $cap['image']
            );
        } else {
            $return = array(
                'status' => 'false',
                'info' => '出错了,请检查'.$vals['img_url']
            );
        }
        echo json_encode($return);exit;
    }

    /**
     *
     * 验证图形验证码
     *
     */
    public function valiCaptcha($code = null) {
        if ($this->input->is_ajax_request() == false) {
            $code = $this->input->post("captcha");
        }
        $this->load->library('captcha');
        $captcha = new Captcha();
        $sence = 'login';
        $res  = $captcha->checkCode($code, $sence);

        if ($res != false) { #验证登录图形验证码
            //验证通过
            $return = array(
                'status' => "true",
                'info' => 'ok'
            );
        } else {
            $return = array(
                'status' => 'false',
                'info' => '图形验证码不正确'
            );
        }
        return($return);
    }

    //登录操作
    public function loginDO()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('login', $input['token']);
        if ($token['status'] == 'false')
        {
            $back = array(
                'status' => 'false',
                'code'   => '868',
                'info'   => urlencode('表单token失效'),
                'token'  => $token['token']
            );
            echo urldecode(json_encode($back)); exit;
        }
        $captcha = $this->valiCaptcha($input['captcha']);
        if ($captcha['status'] == 'false')
        {
            $back = array(
                'status' => 'false',
                'code'   => '869',
                'info'   => urlencode('图形验证码不正确'),
            );
            echo urldecode(json_encode($back)); exit;
        }
        $this->session->set_userdata(array('captchacode' => ''));

        //$this->load->model('systems_model', 'model');
        //$res = $this->model->auth($input['username'], $input['password']);
        $this->load->library('rbac');
        $res = $this->rbac->login($input['username'], $input['password']);

        if ($res['status'] == 'false') {
            echo urldecode(json_encode($res));
        } else {
            echo urldecode(json_encode($res));
        }
    }

    public function logout()
    {
        $adminsession = array(
            'hzzadminid' => '',
            'hzzadminuser' => ''
        );
        $this->session->set_userdata($adminsession);
        redirect(base_url('/backendlogin.html'));
    }







}