<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends frontbase
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('content/article_model', 'article_model');

        #幸福生活
        $typeData = array(      #取5条cateid=2的文章数据
            'cate' => '2',
            'num' => 5,
        );
        //$cateid2 = $this->article_model->lists($typeData);
        #幸福生活
        $typeData1 = array(      #取5条cateid=2的文章数据
            'cate' => '1',
            'num' => 5,
        );
        $cateid1 = $this->article_model->lists($typeData1);

        $data = array(
           // 'cateid2' => $cateid2['data'],
            'cateid1' => $cateid1['data']
        );

        $this->display('pcweb/index', $data);
    }

    #登录
    public function login()
    {
        $this->load->view('pcweb/login');
    }

    public function loginDo()
    {
        $input = $this->input->post();

        //图形验证码验证

        $username = $input['username'];
        $password = $input['password'];
        $this->load->model('core/user_model', 'user_model');
        $userInfo = $this->user_model->item($username, 'username');

        if ($userInfo['status'] == 'false' && $userInfo['code'] == '404')
        {
            echo "用户不存在";exit;
        }

        if ($this->user_model->checkPassword($password, $userInfo['data']) == FALSE)
        {
            echo "用户密码错误";exit;
        } else {
            echo "用户登录成功";exit;
        }
    }

    #注册
    public function register()
    {
        $this->load->view('pcweb/register');
    }

    #注册
    public function registerDo()
    {
        $input = $this->input->post();
        $this->load->model('core/user_model', 'user_model');
        $userInfo = $this->user_model->item($input['username'], 'username');
        if ($userInfo['status'] == 'true' && $userInfo['code'] == '0')
        {
            echo "用户已经存在";
        } else {
            $user = $this->user_model->register($input);
            var_dump($user);
        }
    }

    public function checkUnique($value, $key = 'username')
    {
        $checkArray = array('username', 'mobile', 'idcard', 'email');
        if (!array_key_exists($key, $checkArray))
        {
            $output = array(
                'status' => 'false',
                'info'   => '参数错误'
            );
            echo json_encode($output);exit;
        }
        $this->load->model('core/user_model', 'user_model');
        $userinfo = $this->user_model->item($value, $key);
        if ($userinfo['status'] == 'true')
        {
            $output = array(
                'status' => "false",     #说明字符不可用
                'info'   => '已经被占用'
            );
        } else {
            $output = array(
                'status' => "true",      #说明字符可用
                'info'   => '可用'
            );
        }
        echo json_encode($output);
    }

    #忘记密码
    public function forget()
    {
        $this->load->view('pcweb/forget');
    }

}
