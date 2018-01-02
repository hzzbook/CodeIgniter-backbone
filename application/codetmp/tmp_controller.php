    public function Templates()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('__Controller__/Template_model', 'Template_model');
        $data = $this->Template_model->lists($input);
        echo urldecode(json_encode($data));
    }

    public function Template()
    {
        $input = $this->input->post();
        $this->load->model('__Controller__/Template_model', 'Template_model');
        $data = $this->Template_model->item($input['id']);
        echo urldecode(json_encode($data));
    }
    /**
     * __name__数据列表
     */
    public function TemplatesPage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    /**
     * __name__数据页
     */
    public function TemplatePage()
    {
        $classinfo = $this->backconfig();
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function TemplateAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('TemplateAdd');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'  => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function TemplateUpdatePage()
    {
        $id = $this->input->get('id');
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create('TemplateUpdate');
        $nodeData = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token' => $token,
            'id'    => $id,
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $nodeData);
    }

    public function TemplateAdd()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('TemplateAdd', $input['token']);
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
            //'title', 'cateid', 'content'
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

        $this->load->model('__Controller__/Template_model', 'Template_model');
        $res = $this->Template_model->itemAdd($input);
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

    public function TemplateUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('TemplateUpdate', $input['token']);
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
            //'title', 'cateid', 'content'
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

        $this->load->model('__Controller__/Template_model', 'Template_model');
        $res = $this->Template_model->itemUpdate($input, $input['id']);
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

    public function TemplateDelete()
    {
        $id = $this->input->post('id');
        $this->load->model('__Controller__/Template_model', 'Template_model');
        $res = $this->Template_model->itemDelete($id);
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