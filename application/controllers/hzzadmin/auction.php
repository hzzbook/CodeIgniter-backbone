<?php
/**
 * 积分商城
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/3/29
 * 
 */
class auction extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 积分商城统计信息
     */
    public function index()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function']
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

    public function categorys()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('auction/category_model', 'category_model');
        $data = $this->category_model->lists($input);
        echo urldecode(json_encode($data));
    }

    public function category()
    {
        $input = $this->input->post();
        $this->load->model('auction/category_model', 'category_model');
        $data = $this->category_model->item('id', $input['id']);
        echo urldecode(json_encode($data));
    }
    /**
     * 商品分类数据列表
     */
    public function categorysPage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    /**
     * 商品分类数据页
     */
    public function categoryPage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function categoryAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('categoryAdd');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'  => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function categoryUpdatePage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('categoryUpdate');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token' => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function categoryAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('categoryAdd', $input['token']);
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
            'title', 'cateid', 'content'
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

        $this->load->model('auction/category_model', 'category_model');
        $res = $this->category_model->itemAdd($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加成功'),
                'id'     => $res        #返回模版ID
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

    public function categoryUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('categoryUpdate', $input['token']);
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
            'title', 'cateid', 'content'
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

        $this->load->model('auction/category_model', 'category_model');
        $res = $this->category_model->itemUpdate($input, $input['id']);
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

    public function categoryDelete()
    {
        $id = $this->input->post('id');
        $this->load->model('auction/category_model', 'category_model');
        $res = $this->category_model->itemDelete($id);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('删除成功')
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

    public function goods()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('auction/good_model', 'good_model');
        $data = $this->good_model->lists($input);
        echo urldecode(json_encode($data));
    }

    public function good()
    {
        $input = $this->input->post();
        $this->load->model('auction/good_model', 'good_model');
        $data = $this->good_model->item('id', $input['id']);
        echo urldecode(json_encode($data));
    }
    /**
     * 积分商品数据列表
     */
    public function goodsPage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    /**
     * 积分商品数据页
     */
    public function goodPage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function goodAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('goodAdd');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'  => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function goodUpdatePage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('goodUpdate');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token' => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function goodAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('goodAdd', $input['token']);
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
            'title', 'cateid', 'content'
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

        $this->load->model('auction/good_model', 'good_model');
        $res = $this->good_model->itemAdd($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加成功'),
                'id'     => $res        #返回模版ID
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

    public function goodUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('goodUpdate', $input['token']);
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
            'title', 'cateid', 'content'
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

        $this->load->model('auction/good_model', 'good_model');
        $res = $this->good_model->itemUpdate($input, $input['id']);
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

    public function goodDelete()
    {
        $id = $this->input->post('id');
        $this->load->model('auction/good_model', 'good_model');
        $res = $this->good_model->itemDelete($id);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('删除成功')
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

    public function converts()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('auction/convert_model', 'convert_model');
        $data = $this->convert_model->lists($input);
        echo urldecode(json_encode($data));
    }

    public function convert()
    {
        $input = $this->input->post();
        $this->load->model('auction/convert_model', 'convert_model');
        $data = $this->convert_model->item('id', $input['id']);
        echo urldecode(json_encode($data));
    }
    /**
     * 积分兑换数据列表
     */
    public function convertsPage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    /**
     * 积分兑换数据页
     */
    public function convertPage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function convertAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('convertAdd');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'  => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function convertUpdatePage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('convertUpdate');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token' => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function convertAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('convertAdd', $input['token']);
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
            'title', 'cateid', 'content'
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

        $this->load->model('auction/convert_model', 'convert_model');
        $res = $this->convert_model->itemAdd($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加成功'),
                'id'     => $res        #返回模版ID
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

    public function convertUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('convertUpdate', $input['token']);
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
            'title', 'cateid', 'content'
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

        $this->load->model('auction/convert_model', 'convert_model');
        $res = $this->convert_model->itemUpdate($input, $input['id']);
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

    public function convertDelete()
    {
        $id = $this->input->post('id');
        $this->load->model('auction/convert_model', 'convert_model');
        $res = $this->convert_model->itemDelete($id);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('删除成功')
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

#-------------footer----------------#


}