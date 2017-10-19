<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/1/17
 * 
 */

class systems extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('systems_model', 'model');
    }

    public function index()
    {
        $website = $this->model->website();
        $webData = array();
        foreach ($website as $key=>$value) {
            $webData[$value['var']] = $value['val'];
        }
        $data = array(
            'slider_tag' => 'systems',
            'nav_tag' => 'index',
            'website' => $webData
        );
        $this->display('backbone/systems/index', $data);
    }

    public function websiteUpdate()
    {
        $input = $this->input->post();
        $res = $this->model->websiteUpdate($input);
        $data = array(
            'status' => 'true'
        );
        echo json_encode($data);
    }

    public function check()
    {
        $data = array(
            'username' => 'userhanem',
            'password' => '123456'
        );
        $res = $this->model->auth($data['username'], $data['password']);
        var_dump($res);
    }

    public function adminPage()
    {
        $data = array(
            'slider_tag' => 'systems',
            'nav_tag'    => 'adminPage'
        );
        $this->display('backbone/systems/admin', $data);
    }

    public function adminAddPage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('admin');
        $data = array(
            'slider_tag' => 'systems',
            'nav_tag'    => 'adminAddPage',
            'token'     => $token
        );
        $this->display('backbone/systems/addAdmin', $data);
    }

    public function admins()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('rbac/admin_model', 'admin_model');
        $data = $this->admin_model->admins($input);
        echo urldecode(json_encode($data));
    }

    public function admin()
    {
        $input = $this->input->post();
        $this->load->model('rbac/admin_model', 'admin_model');
        $data = $this->admin_model->admin($input['id']);
        echo urldecode(json_encode($data));
    }

    public function adminAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('admin', $input['token']);
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
        unset($input['token']);

        $checkForm = array(
            'username',  'password'
        );
        if ($this->formtoken->blank($checkForm, $input) == false)
        {
            $back = array(
                'status' => 'false',
                'code'   => '869',
                'info'   => urldecode('确认必填项填写完毕')
            );
            echo urldecode(json_encode($back)); exit;
        }
        $this->load->model('rbac/admin_model', 'admin_model');
        $res = $this->admin_model->adminAdd($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('添加失败')
            );
            echo urldecode(json_encode($back));
        }
    }


    public function adminUpdatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editadmin');
        $data = array(
            'slider_tag' => 'systems',
            'nav_tag'    => 'adminedit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/systems/editAdmin', $data);
    }

    public function adminUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('editadmin', $input['token']);
        if ($token === true)
        {
            $back = array(
                'status' => 'false',
                'code'   => '868',
                'info'   => urlencode('表单token失效'),
                'token'  => $token
            );
            echo urldecode(json_encode($back)); exit;
        }
        unset($input['token']);

        $checkForm = array(
            'username'
        );
        if ($this->formtoken->blank($checkForm, $input) == false)
        {
            $back = array(
                'status' => 'false',
                'code'   => '869',
                'info'   => urldecode('确认必填项填写完毕')
            );
            echo urldecode(json_encode($back)); exit;
        }
        $this->load->model('rbac/admin_model', 'admin_model');
        $res = $this->admin_model->adminUpdate($input, $input['id']);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('修改成功'),
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('修改失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    //删除文章操作
    public function adminDelete()
    {
        $input = $this->input->post();
        $this->load->model('rbase/admin_model', 'admin_model');
        $res = $this->admin_model->adminDelete($input['id']);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('删除成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('删除失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    public function pays()
    {
        $input = $this->input->post();
        $data = $this->model->pays($input);
        echo urldecode(json_encode($data));
    }

    public function pay()
    {
        $input = $this->input->get_post();
        $data = $this->model->pay($input['id']);
        echo urldecode(json_encode($data));
    }


    /**
     * 支付通道管理
     */
    public function payPage()
    {
        $data = array(
            'slider_tag' => 'systems',
            'nav_tag' => 'pay'
        );
        $this->display('backbone/systems/pay', $data);
    }

    public function paymentAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create($classinfo['function']);
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'     => $token,
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

    public function paymentAdd()
    {
        $input = $this->input->post();
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->check($classinfo['function'].'Page', $input['token']);
        if ($token === true)
        {
            $back = array(
                'status' => 'false',
                'code'   => '868',
                'info'   => urlencode('表单token失效'),
                'token'  => $token['token']
            );
            echo urldecode(json_encode($back)); exit;
        }
        unset($input['token']);

        $checkForm = array(         //必填字段
            'code', 'name', 'account', 'password'
        );
        if ($this->formtoken->blank($checkForm, $input) == false)
        {
            $back = array(
                'status' => 'false',
                'code'   => '869',
                'info'   => urldecode('确认必填项填写完毕')
            );
            echo urldecode(json_encode($back)); exit;
        }
        $res = $this->model->$classinfo['function']($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加支付方式成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('添加支付方式失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    /**
     * 数据修改页面
     */
    public function paymentUpdatePage()
    {
        $id = $this->input->get_post('id');

        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create($classinfo['function']);
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'   => $token,
            'id'      => $id
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

    /**
     * 数据修改操作
     */
    public function paymentUpdate()
    {
        $input = $this->input->post();      //输入数据
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->check($classinfo['function'].'Page', $input['token']);
        if ($token === true)
        {
            $back = array(
                'status' => 'false',
                'code'   => '868',
                'info'   => urlencode('表单token失效'),
                'token'  => $token['token']
            );
            echo urldecode(json_encode($back)); exit;
        }
        unset($input['token']);

        $res = $this->model->$classinfo['function']($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('修改支付方式成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('修改支付方式失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    /**
     * 数据删除操作
     */
    public function paymentDelete()
    {
        $input = $this->input->post();
        $input['datastatus'] = 0;                   //数据状态
        $res = $this->model->paymentUpdate($input['id'], $input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('删除支付方式成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('删除支付方式失败')
            );
            echo urldecode(json_encode($back));
        }
    }

}