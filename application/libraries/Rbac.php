<?php
/**
 * 权限管理类
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/7/26
 * 
 */

class Rbac
{
    var $_CI;
    #权限验证级别 main表示验证主控制器
    var $_level = 'main';
    /**
     * 初始化函数
     */
    public function __construct($level = 'main')
    {
        $this->_CI = &get_instance();
        $this->_level = $level;
    }

    /**
     * 登录操作
     * @param $username
     * @param $password
     * @return array
     */
    public function login($username, $password)
    {
        $this->_CI->load->model('rbac/admin_model', 'adminmodel');

        $userinfo = $this->_CI->adminmodel->adminByUsername($username);
        if ($userinfo == false) {
            $back = array(
                'status' => 'false',
                'code'   => '400',
                'info'   => '用户不存在'
            );
            return $back;
        }
        $password_en = $this->_CI->adminmodel->encrypt($password, $userinfo['salt']);
        if ($userinfo['password'] != $password_en) {
            $back = array(
                'status' => 'false',
                'code'   => '405',
                'info'   => '用户或密码不正确'
            );
            return $back;
        }
        $nick = $userinfo['username'];
        $session = array(
            'hzzadminid' => $userinfo['id'],
            'nick' => $nick,
            'role_id' => $userinfo['role_id']
        );
        $this->menu($userinfo['role_id']);
        $this->_CI->session->set_userdata($session);
        $back = array(
            'status' => 'true',
            'code'   => '0',
        );
        return $back;
    }

    /**
     * 获取用户的权限列表
     * @return mixed
     */
    public function fetch_authlist()
    {
        return $this->_CI->session->userdata('authlist');
    }

    /**
     * 获取用户的菜单
     * @param $id
     * @return array
     */
    public function menu($id)
    {
        $this->_CI->load->model('rbac/role_model', 'role_model');
        $roles = $this->_CI->role_model->roleNode($id);

        if ($roles != false) {
            $output = array();
            $auth = array();
            foreach ($roles as $key=> $value) {
                if ($value['p_id'] == 0 && $value['node_type'] == 1) {
                    $output[$value['id']] = $value;
                } elseif (array_key_exists($value['p_id'], $output) && $value['node_type'] == 1) {
                    if ($output[$value['p_id']]['cont'] == '')  {
                        $output[$value['p_id']]['cont'] = $value['cont'];
                        $output[$value['p_id']]['func'] = $value['func'];
                        $output[$value['p_id']]['node_url'] = $value['node_url'];
                    }
                    $output[$value['p_id']]['submenu'][] = $value;
                }
                if ($value['cont'] !='') {
                    $auth[] = $value['cont'].'/'.$value['func'];
                }
            }
        }

        $auth = implode(',', $auth);
        $this->_CI->session->set_userdata(array('authlist' => $auth));
        return $output;
    }

    //验证用户是否有权限
    public function auth()
    {
        $userid = $this->_CI->session->userdata('hzzadminid');
        if ($userid =='') {
            if ($this->_CI->input->is_ajax_request()) {
                $output = array(
                    'status' => 'false',
                    'code' => '400',
                    'info' => '用户未登录'
                );
                echo json_encode($output);die();
            } else {
                $back = array(
                    'status' => 'false',
                    'code' => '400',
                    'info' => '用户未登录'
                );
                return $back;
            }
        }

        $class = $this->_CI->router->fetch_class();
        $method = $this->_CI->router->fetch_method();
        if ($this->_level == 'main') {
            $router = $class;
        } else {
            $router = $class . '/' . $method;
        }
        $string = $this->_CI->session->userdata('authlist');     #权限列表
        if (strpos($string, $router)  === false ){
            if ($router == 'backbone/index') {

            } else {
            if ($this->_CI->input->is_ajax_request()) {
                $output = array(
                    'status' => 'false',
                    'code' => '401',
                    'info' => '无权限，未对该用户授权访问'
                );
                echo json_encode($output);die();
            } else {
                $back = array(
                    'status' => 'false',
                    'code' => '401',
                    'info' => '无权限，未对该用户授权访问'
                );
                return $back;
            }
            }
        }
        $role_id = $this->_CI->session->userdata('role_id');
        $back = array(
            'status' => 'true',
            'userid' => $this->_CI->session->userdata('hzzadminid'),
            'nick' => $this->_CI->session->userdata('nick'),
            'role_id' => $role_id,
            'menu'  => $this->menu($role_id),
            'contrller' => $class,
            'method' => $method,
        );
        return $back;
    }

}