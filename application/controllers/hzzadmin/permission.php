<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/2/8
 * 
 */


class permission extends  Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('permission_model', 'model');
    }

    public function index()
    {
        $classinfo = $this->backconfig();
        $node = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],

        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $node);
    }

    public function authorizePage()
    {
        $classinfo = $this->backconfig();
        $id = $this->input->get('id');
        $this->load->model('rbac/role_model', 'role_model');
        $rolenode = $this->role_model->roleNode($id);
        $node = array();
        if ($rolenode !=false) {
            foreach ($rolenode as $key => $value) {
                $node[] = $value['id'];
            }
        }
        $this->load->model('rbac/node_model', 'node_model');
        $input = array();
        $nodelist = $this->node_model->nodes($input, 'all');
        $output = array();

        foreach ($nodelist['data'] as $key=> $value) {
            if ($value['p_id'] == 0 && $value['node_type'] == 1) {
                $output[$value['id']] = $value;
            } elseif (array_key_exists($value['p_id'], $output)) {
                $output[$value['p_id']]['submenu'][] = $value;
            }
        }

        $node = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'roleNode' => $node,
            'nodelist' => $output,
            'id'     => $id
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $node);
    }

    //授权操作
    public function authorize()
    {
        $input = $this->input->post();
        $this->load->model('rbac/role_model', 'role_model');

        $this->role_model->authorize($input['id'], $input['node']);
        $back = array(
            'status' => 'true'
        );
        echo json_encode($back);
    }

    /**
     * 权限结点列表页
     */
    public function nodesPage()
    {
        $classinfo = $this->backconfig();
        $node = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],

        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $node);
    }

    /**
     * 权限结点列表api接口
     */
    public function nodes()
    {
        $input = $this->input->post();
        $this->load->model('rbac/node_model', 'node_model');
        $nodes = $this->node_model->nodes($input);
        if ($nodes['status'] == true) {
            $level = $this->node_model->nodeLevel();
            $top = array();
            foreach ($level as $key => $value)
            {
                $top[$value['id']]  = $value['node_name'];
            }
            $top[0] = '顶级菜单';
            $type = array(
                '1' => '菜单',
                '2' => '操作',
                '3' => '页面',
                '9' => '其他'
            );
            foreach ($nodes['data'] as $key => $value) {
                $nodes['data'][$key]['pname'] = $top[$value['p_id']];
                $nodes['data'][$key]['type'] = $type[$value['node_type']];
            }
        }
        echo json_encode($nodes);
    }

    public function nodeLevel()
    {
        $this->load->model('rbac/node_model', 'node_model');
        $level = $this->node_model->nodeLevel();
        $top = array();
        $top[] = array('id'=> 0, 'node_name'=>'顶级菜单');
        foreach ($level as $key => $value)
        {
            $top[]  = $value;
        }

        echo json_encode($top);
    }

    /**
     * 权限结点详情api接口
     */
    public function node()
    {
        $input = $this->input->post();
        if (isset($inpt['id']) && $input['id'] == '')
        {
            $result = array(
                'code' => '999',
                'info' => urlencode('参数不能为空')
            );
            echo urldecode(json_encode($result));exit;
        }
        $this->load->model('rbac/node_model', 'node_model');
        $node = $this->node_model->node($input['id']);
        echo urldecode(json_encode($node));
    }

    /**
     * 权限结点添加页面
     */
    public function nodeAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create($classinfo['function']);

        $node = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'   => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $node);
    }

    public function testtoken()
    {
        $this->load->library('formtoken');
        var_dump($this->formtoken->check('2343', '12423'));
    }

    /**
     * 权限结点添加操作
     */
    public function nodeAdd()
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
            'node_name',
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
        $this->load->model('rbac/node_model', 'node_model');
        $res = $this->node_model->$classinfo['function']($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加权限结点成功'),
                'id'     => $res        #返回权限结点ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('添加权限结点失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    /**
     * 权限结点修改页面
     */
    public function nodeUpdatePage()
    {
        $id = $this->input->get_post('id');

        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create($classinfo['function']);
        $node = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'   => $token,
            'id'      => $id
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $node);
    }

    /**
     * 角色修改操作
     */
    public function nodeUpdate()
    {
        $input = $this->input->post();      //输入角色
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
        $this->load->model('rbac/node_model', 'node_model');
        $res = $this->node_model->itemUpdate($input, $input['id']);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('修改结点成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('修改结点失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    /**
     * 角色删除操作
     */
    public function nodeDelete()
    {
        $input = $this->input->post();
        $this->load->model('rbac/node_model', 'node_model');
        $res = $this->node_model->itemDelete($input['id']);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('删除结点成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('删除结点失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    /**
     * 角色列表页
     */
    public function rolesPage()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],

        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

    /**
     * 角色列表api接口
     */
    public function roles()
    {
        $input = array();
        $this->load->model('rbac/role_model', 'role_model');
        $role = $this->role_model->roles($input);
        echo urldecode(json_encode($role));
    }

    /**
     * 角色详情api接口
     */
    public function role()
    {
        $input = $this->input->post();
        $this->load->model('rbac/role_model', 'role_model');
        $role = $this->role_model->role($input['id']);
        echo urldecode(json_encode($role));
    }

    /**
     * 角色详情页
     */
    public function rolePage()
    {
        $classinfo = $this->backconfig();
        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],

        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

    /**
     * 角色添加页面
     */
    public function roleAddPage()
    {
        $classinfo = $this->backconfig();
        $this->load->library('formtoken');
        $token = $this->formtoken->create($classinfo['function']);

        $data = array(
            'slider_tag' => $classinfo['class'],
            'nav_tag' => $classinfo['function'],
            'token'   => $token
        );
        $this->display('backbone/'.$classinfo['class'].'/'.$classinfo['function'], $data);
    }

    /**
     * 角色添加操作
     */
    public function roleAdd()
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
            'rolename'
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
        $this->load->model('rbac/role_model', 'role_model');
        $res = $this->role_model->itemAdd($input);
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
                'info'   => urldecode('添加文章失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    /**
     * 角色修改页面
     */
    public function roleUpdatePage()
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
     * 角色修改操作
     */
    public function roleUpdate()
    {
        $input = $this->input->post();      //输入角色
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
        $this->load->model('rbac/role_model', 'role_model');
        $res = $this->role_model->itemUpdate($input, $input['id']);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('修改角色成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('修改角色失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    /**
     * 角色删除操作
     */
    public function roleDelete()
    {
        $input = $this->input->post();
        $input['datastatus'] = 0;                   //角色状态
        $res = $this->model->roleUpdate($input['id'], $input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('删除角色成功'),
                'id'     => $res        #返回文章ID
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('删除角色失败')
            );
            echo urldecode(json_encode($back));
        }
    }

}