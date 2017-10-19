<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/3/3
 * 
 */
class user_model extends MY_Model
{

    public function users($data)
    {
        $list = $this->_users($data);
        return $list;
    }

    /**
     * 用户列表
     * @param $data
     */
    public function _users($data, $all = null)
    {
        $where = array(
            'username' => array(
                'filed'     => 'username',
                'type' 		=> "string",
                'table' 	=> 'users',
                'expression'    => 'like'
            ),
            'start' => array(     #用户分布时间
                'filed' => 'logtime',
                'type' => 'date',
                'table' => 'users',
                'expression' => '>='
            ),
            'end' => array(     #用户发布时间
                'filed' => 'logtime',
                'type' => 'date',
                'table' => 'users',
                'expression' => '<='
            ),
            'status' => array(     #用户分类ID
                'filed' => 'status',
                'type' => 'int',
                'table' => 'users',
                'expression' => '='
            ),
        );
        $where = $this->where($where, $data);
        #根据得到数据条数
        $result['sum'] = $this->_getusersTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "users",
                        'orderby' => 'desc'
                    ),
                );
                $orderdata = $this->makeOrder($orderdata, $data['order']);

                $order = $this->order($orderdata);
            } else {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
                        'orderby' => 'desc'
                    ),
                );
                $order = $this->order($orderdata);
            }
            #echo $order;exit;
            if ($all == 'all') {
                $limit = '';
            } else {
                $limit = $this->limit($data, $sum);
                if ($limit == 'toobig') {
                    $back = array(
                        'status' => 'false',
                        'code' => '406',
                        'info' => urlencode('没有更多数据了')
                    );
                    return $back;
                }
            }

            $result['data'] = $this->_getusersList($where, $order, $limit['string'], $sum);
            $result['page'] = $limit['page'];
            $result['status'] = 'true';
            $result['code'] = '0';
        } else {
            $result['data'] = 'false';
            $result['status'] = 'false';
            $result['code'] = '404';
        }
        return $result;
    }

    private function _getusersTotal($where)
    {
        $sql = "select count(users.id) as sum from "
            . $this->db->dbprefix('users') . ' as users  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    private function _getusersList($where, $order, $limit)
    {
        $sql = "select users.* from "
            . $this->db->dbprefix('users') . ' as users  '
            . $where
            . $order
            . $limit;
        #echo $sql;
        return $this->getResult($sql);
    }

    /**
     * 用户内容
     */
    public function user($aid)
    {
        $userInfo = $this->_user($aid);
        if ($userInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '用户不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $userInfo
            );
        }
        return $back;
    }

    /**
     * 用户内容
     * @param $aid
     */
    private function _user($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'user',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_usersQL($where);
        return $result;
    }

    private function _usersQL($where)
    {
        $where = $this->One($where);
        $sql = "select user.*, category.title as catetitle from "
            . $this->db->dbprefix('users') . ' as user '
            . $where;
        return $this->getRow($sql);
    }
    
    //添加用户
    public function adduser($data)
    {
        $data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('users', $data);
    }

    //浏览用户
    public function viewuser($id, $pv)
    {
        $data = array(
            'pv' => $pv
        );
        return $this->update('users', $data, $id);
    }

    //编辑用户
    public function updateuser($id, $data)
    {
        return $this->update('users', $data, $id);
    }


}