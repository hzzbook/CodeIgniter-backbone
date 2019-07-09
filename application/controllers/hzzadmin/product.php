<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/1/17
 * 
 */

class product extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
            'slider_tag' => 'product',
            'nav_tag' => 'index'
        );
        $this->display('backbone/product/index', $data);
    }



    //文章列表数据
    public function products()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('product/product_model', 'model');
        $data = $this->model->lists($input);
        echo urldecode(json_encode($data));
    }

    //文章数据
    public function article()
    {
        $input = $this->input->post();
        $this->load->model('product/product_model', 'model');
        $data = $this->model->product('id', $input['id']);
        echo urldecode(json_encode($data));
    }

    //添加文章页面
    public function add()
    {
        $this->load->library('formtoken');
        $token = $this->formtoken->create('aritcle');
        $data = array(
            'slider_tag' => 'product',
            'nav_tag'    => 'add',
            'token'     => $token
        );
        $this->display('backbone/product/addProduct', $data);
    }

    //保存并且发布
    public function addArticleDO()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('aritcle', $input['token']);
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
            'name', 'cateid', 'content'
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

        $res = $this->model->addArticle($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加文章成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('添加文章失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    //编辑文章页面
    public function articleedit()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editaritcle');
        $data = array(
            'slider_tag' => 'product',
            'nav_tag'    => 'edit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/product/editProduct', $data);
    }

    //更新文章操作
    public function updateArticleDO()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('editaritcle', $input['token']);
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

        $res = $this->model->updateArticle($input['id'], $input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('修改文章成功'),
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('添加文章失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    //删除文章操作
    public function deleteArticle()
    {
        $input = $this->input->post();
        $input['status'] = 0;
        $res = $this->model->updateArticle($input['id'], $input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('删除文章成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('删除文章失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    /*------------------------文章操作---------------------------*/

    public function categoryPage()
    {
        $data = array(
            'slider_tag' => 'product',
            'nav_tag'    => 'categoryPage'
        );
        $this->display('backbone/product/category', $data);
    }

    //分类列表数据
    public function categorys()
    {
        $input = array();
        $data = $this->model->categorys($input);
        echo urldecode(json_encode($data));
    }

    //文章数据
    public function category()
    {
        $input = $this->input->post();
        $data = $this->model->category($input['id']);
        echo urldecode(json_encode($data));
    }

    //显示分类列表页面
    public function categorypage2()
    {
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag' => 'category'
        );
        $this->display('backbone/product/category', $data);
    }

    public function categoryAddPage()
    {
        $this->load->library('formtoken');
        $token = $this->formtoken->create('category');
        $data = array(
            'slider_tag' => 'product',
            'nav_tag'    => 'categoryAddPage',
            'token'     => $token
        );
        $this->display('backbone/product/addCategory', $data);
    }

    //保存并且发布
    public function categoryAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('category', $input['token']);
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
            'title', 'fid', 'content'
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

        $res = $this->model->addCategory($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加文章成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('添加文章失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    //编辑文章页面
    public function categoryUpdatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editcategory');
        $data = array(
            'slider_tag' => 'product',
            'nav_tag'    => 'edit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/product/editCategory', $data);
    }

    //更新文章操作
    public function categoryUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('editcategory', $input['token']);
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
            /*'title', 'fid', 'content'*/
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

        $res = $this->model->updateCategory($input['id'], $input);
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
                'info'   => urldecode('添加失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    //删除文章操作
    public function categoryDelete()
    {
        $input = $this->input->post();
        $input['status'] = 0;
        $res = $this->model->updateCategory($input['id'], $input);
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

    public function book()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],

        );
        $this->display('backbone/product/book', $data);
    }

    public function ApiPage()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

        public function funds()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('product/fund_model', 'fund_model');
        $data = $this->fund_model->lists($input);
        echo urldecode(json_encode($data));
    }

    public function fund()
    {
        $input = $this->input->post();
        $this->load->model('product/fund_model', 'fund_model');
        $data = $this->fund_model->item('id', $input['id']);
        echo urldecode(json_encode($data));
    }
    /**
     * fund_items数据列表
     */
    public function fundsPage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    /**
     * fund_items数据页
     */
    public function fundPage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function fundAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('fundAdd');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'  => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function fundUpdatePage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('fundUpdate');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token' => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function fundAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('fundAdd', $input['token']);
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

        $this->load->model('product/fund_model', 'fund_model');
        $res = $this->fund_model->itemAdd($input);
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

    public function fundUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('fundUpdate', $input['token']);
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

        $this->load->model('product/fund_model', 'fund_model');
        $res = $this->fund_model->itemUpdate($input, $input['id']);
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

    public function fundDelete()
    {
        $id = $this->input->post('id');
        $this->load->model('product/fund_model', 'fund_model');
        $res = $this->fund_model->itemDelete($id);
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