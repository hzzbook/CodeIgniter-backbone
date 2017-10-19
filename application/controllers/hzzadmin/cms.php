<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/1/17
 * 
 */

class cms extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cms_model', 'model');
    }

    public function index()
    {
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag' => 'index'
        );
        $this->display('backbone/cms/index', $data);
    }

    //文章列表数据
    public function articles()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('content/article_model', 'article_model');
        $data = $this->article_model->lists($input);
        echo urldecode(json_encode($data));
    }

    //文章数据
    public function article()
    {
        $input = $this->input->post();
        $this->load->model('content/article_model', 'article_model');
        $data = $this->article_model->item($input['id']);
        echo urldecode(json_encode($data));
    }

    //添加文章页面
    public function articleAddPage()
    {
        $this->load->library('formtoken');
        $token = $this->formtoken->create('aritcle');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'add',
            'token'     => $token
        );
        $this->display('backbone/cms/addArticle', $data);
    }

    //保存并且发布
    public function articleAdd()
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
        $this->load->model('content/article_model', 'artmodel');
        $res = $this->artmodel->articleAdd($input);
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
    public function articleUpdatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editaritcle');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'edit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/cms/editArticle', $data);
    }

    //更新文章操作
    public function articleUpdate()
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

        $this->load->model('content/article_model', 'article_model');
        $res = $this->article_model->itemUpdate($input, $input['id']);
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
    public function articleDelete()
    {
        $input = $this->input->post();
        //$input['status'] = 0;
        $this->load->model('content/article_model', 'article_model');
        $res = $this->article_model->itemDelete($input['id']);
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

    //分类列表数据
    public function categorys()
    {
        $input = $this->input->post();
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
    public function categoryPage()
    {
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag' => 'categoryPage'
        );
        $this->display('backbone/cms/category', $data);
    }

    public function categoryAddPage()
    {
        $this->load->library('formtoken');
        $token = $this->formtoken->create('category');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'addcategory',
            'token'     => $token
        );
        $this->display('backbone/cms/addCategory', $data);
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
        $this->load->model('content/category_model', 'category_model');
        $res = $this->category_model->itemAdd($input);
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

    //编辑文章页面
    public function categoryUpdatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editcategory');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'edit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/cms/editCategory', $data);
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
        $this->load->model('content/category_model', 'category_model');
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
                'info'   => urldecode('添加失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    //删除文章操作
    public function categoryDelete()
    {
        $input = $this->input->post();
        $this->load->model('content/category_model', 'category_model');
        $res = $this->category_model->itemDelete($input['id']);
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


    /****---------------文章分类内容-------------------**/

    public function imagesPage()
    {
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'imagesPage'
        );
        $this->display('backbone/cms/images', $data);
    }

    public function imageAddPage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('image');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'addimage',
            'token'     => $token
        );
        $this->display('backbone/cms/addImage', $data);
    }

    //分类列表数据
    public function images()
    {
        $input = $this->input->post();
        $this->load->model('content/image_model', 'image_model');
        $data = $this->image_model->lists($input);
        echo urldecode(json_encode($data));
    }

    //文章数据
    public function image()
    {
        $input = $this->input->post();
        $this->load->model('content/image_model', 'image_model');
        $data = $this->image_model->item($input['id']);
        echo urldecode(json_encode($data));
    }

    //保存并且发布
    public function imageAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token = $this->formtoken->check('image', $input['token']);
        if ($token['status'] == 'false') {
            $back = array(
                'status' => 'false',
                'code' => '868',
                'info' => urlencode('表单token失效'),
                'token' => $token['token']
            );
            echo urldecode(json_encode($back));
            exit;
        }
        unset($input['token']);

        $checkForm = array(
            'title', 'url'
        );
        if ($this->formtoken->blank($checkForm, $input) == false) {
            $back = array(
                'status' => 'false',
                'code' => '869',
                'info' => urldecode('确认必填项填写完毕')
            );
            echo urldecode(json_encode($back));
            exit;
        }
        $this->load->model('content/image_model', 'image_model');
        $res = $this->image_model->itemAdd($input);
        if ($res == true) {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'info' => urldecode('添加文章成功'),
                'id' => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code' => '500',
                'info' => urldecode('添加文章失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    public function imageUpdatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editimage');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'edit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/cms/editImage', $data);
    }

    //更新文章操作
    public function imageUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('editimage', $input['token']);
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
            'title', 'url'
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
        $this->load->model('content/image_model', 'image_model');
        $res = $this->image_model->itemUpdate($input, $input['id']);
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
    public function deleteImage()
    {
        $input = $this->input->post();
        $this->load->model('content/image_model', 'image_model');
        $res = $this->image_model->itemDelete($input['id']);
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
    /***-----------------------图片内容------------------------------**/

    public function contentPage()
    {
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'contentPage'
        );
        $this->display('backbone/cms/content', $data);
    }

    public function contents()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }

        $data = $this->model->contents($input);
        echo urldecode(json_encode($data));
    }

    public function content()
    {
        $input = $this->input->post();
        $data = $this->model->content($input['id']);
        echo urldecode(json_encode($data));
    }

    public function contentAddPage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('content');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'addcontent',
            'token'      => $token
        );
        $this->display('backbone/cms/addContent', $data);
    }

    public function contentAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('content', $input['token']);
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
            'title', 'content'
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
        $this->load->model('content/content_model', 'content_model');
        $res = $this->content_model->itemAdd($input);
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
    public function contentUpdatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editcontent');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'edit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/cms/editContent', $data);
    }

    //更新文章操作
    public function contentUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('editcontent', $input['token']);
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
            'title', 'content'
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
        $this->load->model('content/content_model', 'content_model');
        $res = $this->content_model->itemUpdate($input, $input['id']);
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
    public function contentDelete()
    {
        $input = $this->input->post();
        $this->load->model('content/content_model', 'content_model');
        $res = $this->content_model->itemDelete($input['id']);
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

    /*---------------------内容片段----------------------------*/

    public function bannerPage()
    {
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'bannerPage'
        );
        $this->display('backbone/cms/banner', $data);
    }

    public function bannerAddPage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('banner');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'addbanner',
            'token'     => $token
        );
        $this->display('backbone/cms/addBanner', $data);
    }

    public function banners()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('content/banner_model', 'banner_model');
        $data = $this->banner_model->lists($input);
        echo urldecode(json_encode($data));
    }

    public function banner()
    {
        $input = $this->input->post();
        $this->load->model('content/banner_model', 'banner_model');
        $data = $this->banner_model->item($input['id']);
        echo urldecode(json_encode($data));
    }

    public function bannerAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('banner', $input['token']);
        if ($token['status'] == 'false')
        {
            $back = array(
                'status' => 'false',
                'code'   => '868',
                'info'   => urlencode('表单tokeng失效'),
                'token'  => $token['token']
            );
            echo urldecode(json_encode($back)); exit;
        }
        unset($input['token']);

        $checkForm = array(
            'title',  'url'
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

        $this->load->model('content/banner_model', 'banner_model');
        $res = $this->banner_model->itemAdd($input);
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
    public function bannerUpdatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editbanner');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'edit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/cms/editBanner', $data);
    }

    //更新文章操作
    public function bannerUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('editbanner', $input['token']);
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
            'title', 'url'
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
        $this->load->model('content/banner_model', 'banner_model');
        $res = $this->banner_model->itemUpdate( $input, $input['id']);
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
    public function bannerDelete()
    {
        $input = $this->input->post();
        $this->load->model('content/banner_model', 'banner_model');
        $res = $this->banner_model->itemDelete($input['id']);
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


    /*----------------------轮播内容----------------------*/


    public function friendlinkPage()
    {
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'friendlinkPage'
        );
        $this->display('backbone/cms/friendlink', $data);
    }

    public function friendlinkAddPage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('banner');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'addbanner',
            'token'     => $token
        );
        $this->display('backbone/cms/addFriendlink', $data);
    }

    public function friendlinks()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('content/friendly_model', 'friendly_model');
        $data = $this->friendly_model->lists($input);
        echo urldecode(json_encode($data));
    }

    public function friendlink()
    {
        $input = $this->input->post();
        $this->load->model('content/friendly_model', 'friendly_model');
        $data = $this->friendly_model->item($input['id']);
        echo urldecode(json_encode($data));
    }

    public function friendlinkAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('friendlink', $input['token']);
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
            'title',  'url'
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
        $this->load->model('content/friendly_model', 'friendly_model');
        $res = $this->friendly_model->itemAdd($input);
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
    public function friendlinkUpdatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editfriendlink');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'edit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/cms/editFriendlink', $data);
    }

    //更新文章操作
    public function friendlinkUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('editfriendlink', $input['token']);
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
        $this->load->model('content/friendly_model', 'friendly_model');

        $res = $this->friendly_model->itemUpdate($input, $input['id']);
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
    public function deleteFriendlink()
    {
        $input = $this->input->post();
        $this->load->model('content/friendly_model', 'friendly_model');
        $res = $this->friendly_model->itemDelete($input['id']);
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


    /*----------------------轮播内容----------------------*/


    public function banners2()
    {
        $page = $this->input->get_post('page');
        $data = array(
            'pages' => '10',
            'list' => array(
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'.$page
                ),
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'.$page
                ),
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'
                ),
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'
                ),
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'
                ),
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'
                ),
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'
                ),
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'
                ),
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'
                ),
                array(
                    'name' => 'XSJIOJI',
                    'city' => '深圳'
                ),
            )
        );
        echo json_encode($data);
    }

    public function chart()
    {
        $get = $this->input->get('date');

        switch($get)
        {
            case 'today':
                $data = array(
                    'xaxis' => array(
                        '2:00','4:00', '6:00', '8:00',
                        '10:00','12:00', '14:00', '16:00',
                        '18:00', '20:00', '22:00', '24:00'
                    ),
                    'data'  => array(
                        20, 40, 80, 30,
                        20, 40, 80, 30,
                        20, 40, 80, 30,
                    )
                );
                break;
            case 'week':
                $data = array(
                    'xaxis' => array(
                        '周一', '周二', '周三', '周四', '周五', '周六', '周日'
                    ),
                    'data' => array(
                        '20', '300', '360', '380', '260', '230', '50', '60'
                    )
                );
                break;
            case 'month':
                $data = array(
                    'xaxis' => array(
                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                    ),
                    'data' => array(
                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                    )
                );
                break;
        }

        echo json_encode($data);
    }

    public function pie()
    {
        $data = array(
            'legend' => array(
                '直接访问','邮件营销','联盟广告','视频广告','搜索引擎'
            ),
            'data' => array(
              array('value' => 335, 'name' => '直接访问'),
              array('value' => 310, 'name' => '邮件营销'),
              array('value' => 234, 'name' => '联盟广告'),
              array('value' => 135, 'name' => '视频广告'),
              array('value' => 1548, 'name' => '搜索引擎'),
            )
        );
        echo json_encode($data);
    }

    public function singlepagePage()
    {
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'singlepagePage'
        );
        $this->display('backbone/cms/singlepage', $data);
    }

    public function singlepages()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('content/singlepage_model', 'singlepage_model');
        $data = $this->singlepage_model->lists($input);
        echo urldecode(json_encode($data));
    }

    public function singlepage()
    {
        $input = $this->input->post();
        $this->load->model('content/singlepage_model', 'singlepage_model');
        $data = $this->singlepage_model->item($input['id']);
        echo urldecode(json_encode($data));
    }

    public function singlepageAddPage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('content');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'singlepageAddPage',
            'token'      => $token
        );
        $this->display('backbone/cms/addSinglepage', $data);
    }

    public function singlepageAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('content', $input['token']);
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
            'title', 'content'
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
        $this->load->model('content/singlepage_model', 'singlepage_model');
        $res = $this->singlepage_model->itemAdd($input);
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

    //编辑文章页面
    public function singlepageUpdatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('editcontent');
        $data = array(
            'slider_tag' => 'cms',
            'nav_tag'    => 'edit',
            'token'     => $token,
            'id'        => $id
        );
        $this->display('backbone/cms/editSinglepage', $data);
    }

    //更新文章操作
    public function singlepageUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('editcontent', $input['token']);
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
            'title', 'content'
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
        $this->load->model('content/singlepage_model', 'singlepage_model');
        $res = $this->singlepage_model->itemUpdate($input, $input['id']);
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
    public function singlepageDelete()
    {
        $input = $this->input->post();
        $this->load->model('content/singlepage_model', 'singlepage_model');
        $res = $this->singlepage_model->itemDelete($input['id']);
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

}