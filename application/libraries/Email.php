<?php
require_once 'email/class.phpmailer.php';      #加载第三方发送邮件类库
include_once 'email/class.pop3.php';
include_once 'email/class.smtp.php';

class Email
{
    #私有干活的驴
    private $donkey;

    #主人的必要信息
    private $host = EMAIL_HOST;     #发送邮件的服务器
    private $port = 25;                 #发送邮件的端口
    private $username = EMAIL_USERNAME;     #邮件服务器的账户  ex. xxx@xx.com
    private $password = EMAIL_PASSWORD;     #对应SMTP邮件服务器账户的密码，而不是邮箱登录密码

    public  function __construct()
    {
        $this->donkey = new PHPMailer();
    }


    /**
     * 设置发送配置信息
     *
     * @param $username
     * @param $password
     */
    public function setUser($host, $username, $password)
    {
        $this->host     = $host;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * 发送操作
     *
     * @param $email    邮件地址
     * @param $content  邮件内容
     */
    public function send($email, $subject, $content, $nickname)
    {
        $this->donkey->IsSMTP();
        $this->donkey->CharSet      = 'UTF-8';
        $this->donkey->SMTPAuth     = TRUE;
        $this->donkey->Host         = $this->host;
        $this->donkey->Port         = $this->port;
        $this->donkey->Username     = $this->username;
        $this->donkey->Password     = $this->password;

        $this->donkey->SetFrom($this->username, $this->username);
        $this->donkey->AddReplyTo($this->username, $this->username);

        $this->donkey->Subject    = $subject;
        $this->donkey->MsgHTML($content);

        $this->donkey->AddAddress($email, $nickname);         #添加发送列表

        if (!$this->donkey->Send())
        {
            $error = $this->donkey->ErrorInfo();
            //todo 根据错误信息寄去错误码
            $errorInfo = $this->errorCode_126($error);
            $back = array(
                'status' => 'false',
                'info'  => $errorInfo
            );
            return $back;
        }
        else
        {
            $back = array(
                'status' => 'true',
                'info'   => 'success'
            );
            return $back;
        }
    }

    private function errorCode_126($code)
    {
        switch($code)
        {
            case 'HL:REP':
                $info = '该IP发送行为异常，存在接收者大量不存在情况，
                被临时禁止连接。请检查是否有用户发送病毒或者垃圾邮件，
                并核对发送列表有效性；';
                break;
            case 'HL:ICC':
                $info = '该IP同时并发连接数过大，超过了网易的限制，被临时禁止连接。
                请检查是否有用户发送病毒或者垃圾邮件，并降低IP并发连接数量；';
                break;
            case 'HL:IFC':
                $info = '该IP同时并发连接数过大，超过了网易的限制，被临时禁止连接。
                请检查是否有用户发送病毒或者垃圾邮件，并降低IP并发连接数量；';
                break;
            case 'HL:MEP':
                $info = '该IP发送行为异常，存在大量伪造发送域域名行为，被临时禁止连接。
                请检查是否有用户发送病毒或者垃圾邮件，并使用真实有效的域名发送';
                break;
            case 'MI:CEL':
                $info = '发送方出现过多的错误指令。请检查发信程序；';
                break;
            case 'MI:DMC':
                $info = '当前连接发送的邮件数量超出限制。请减少每次连接中投递的邮件数量；';
                break;
            case 'MI:CCL':
                $info = '发送方发送超出正常的指令数量。请检查发信程序；';
                break;
            case 'RP:DRC':
                $info = '当前连接发送的收件人数量超出限制。请控制每次连接投递的邮件数量；';
                break;
            case 'RP:CCL':
                $info = '发送方发送超出正常的指令数量。请检查发信程序；';
                break;
            case 'WM:BLI':
                $info = '该IP不在网易允许的发送地址列表里；';
                break;
            case 'WM:BLU':
                $info = '此用户不在网易允许的发信用户列表里；';
                break;
            case 'DT:SPM':
                $info = '邮件正文带有垃圾邮件特征或发送环境缺乏规范性，被临时拒收。
            请保持邮件队列，两分钟后重投邮件。需调整邮件内容或优化发送环境；';
                break;
            case 'RP:RCL':
                $info = '群发收件人数量超过了限额，请减少每封邮件的收件人数量；';
                break;
            case 'Invalid User':
                $info = '请求的用户不存在；';
                break;
            default:
                $info = "更多错误信息，请查看网易http://help.163.com/09/1224/17/5RAJ4LMH00753VB8.html";
                break;
        }
        return $info;
    }

    /**
     * 根据模版号生成模板内容
     * @param $tempNo
     */
    public function writeContent($tempNo, $argsr)
    {

    }

}