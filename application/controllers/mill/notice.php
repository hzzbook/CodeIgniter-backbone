<?php
/**
 * 通知系统
 * 说明：
 * 1、邮件推送
 * 2、短信推送
 * 3、ios、安卓推送
 *
 * @Author: hzz
 * @Date: 2017/11/6
 * 
 */
class notice extends MY_Controller
{

    public function index()
    {
        $this->load->view('mill/email/index');
    }

    public function email()
    {
        $this->load->view('mill/notice/email');
    }

    public function sendEmail()
    {
        $this->load->library('email');
        $mail = new Email();
        $email = '403936464@qq.com';
        $subject = '测试邮件';
        $content = '快乐无处屋子';
        //$content = file_get_contents('email.html');
        $nickname = '好孩子';
        $res = $mail->send($email, $subject, $content, $nickname);
        if ($res['status'] == 'true')
        {
            echo "发送成功";
        } else {
            var_dump($res);
        }
    }

    public function filer()
    {
        $this->load->library('file');
        $file = new File();
        $data = '你好吗';
        $file->input('测试文件', 'pdf', $data);

        $file->create();
    }



}