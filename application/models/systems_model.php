<?php
/**
 * 旧版本系统管理
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/3/2
 * 
 */
class systems_model extends MY_Model
{

    public function website()
    {
        $sql = " select * from "
            . $this->db->dbprefix('system_setting');
        return $this->getResult($sql);
    }

    public function websiteUpdate($input)
    {
        foreach ($input as $key=>$value) {
            $this->db->where('var', $key);
            $update = array('val' => $value);
            $this->db->update('system_setting',$update);
        }
        return true;
    }

    public function regEncry($password, $salt) {
        $encry = md5(md5($password).$salt.'5g@0I');
        return $encry;
    }

    public function random($length=4)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $password = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $password;
    }

    public function auth($username, $password)
    {
        $res = $this->exitByusername($username);
        if ($res == false)
        {
            $back = array(
                'status' => 'false',
                'code'   => '201',
                'info'   => urlencode('用户不存在!')
            );
            return $back;
        }
        $pwd = $this->regEncry($password, $res['salt']);
        if ($pwd != $res['password'])
        {
            $back = array(
                'status' => 'false',
                'code'   => '202',
                'info'   => urlencode('用户名或密码不正确!')
            );
            return $back;
        }
        $back = array(
            'status' => 'true',
            'code'   => '0',
            'data'   => $res
        );
        return $back;
    }

    public function exitByusername($username)
    {
        $sql = "select * from "
            . $this->db->dbprefix('system_admin')
            . " where username='{$username}'";
        $res = $this->getRow($sql);
        return $res;
    }

    public function admins($data)
    {
        $list = $this->_admins($data);
        return $list;
    }

    /**
     * 管理员列表
     * @param $data
     */
    public function _admins($data, $all = null)
    {
        $where = array(
            'id' => array(
                'filed'     => 'id',
                'type' 		=> "string",
                'table' 	=> 'article',
                'expression'    => '='
            ),
            'status' => array(
                'filed'     => 'status',
                'type' 		=> "string",
                'table' 	=> 'article',
                'expression'    => '='
            )
        );
        $where = $this->where($where, $data);
        if ($where == '')
        {
            $where = " where article.id !=0";
        } else {
            $where .= " and article.id !=0";
        }
        #根据得到数据条数
        $result['sum'] = $this->_getAdminsTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "article",
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

            $result['data'] = $this->_getAdminsList($where, $order, $limit['string'], $sum);
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

    private function _getAdminsTotal($where)
    {
        $sql = "select count(article.id) as sum from "
            . $this->db->dbprefix('system_admin') . ' as article  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    private function _getAdminsList($where, $order, $limit)
    {
        $sql = "select article.* from "
            . $this->db->dbprefix('system_admin') . ' as article  '
            . $where
            . $order
            . $limit;
        #echo $sql;
        return $this->getResult($sql);
    }

    public function admin($aid)
    {
        $articleInfo = $this->_admin($aid);
        if ($articleInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $articleInfo
            );
        }
        return $back;
    }

    /**
     * 管理员内容
     * @param $aid
     */
    private function _admin($aid)
    {
        $where = array(
            'type' => 'int',        //int / string
            'table' => 'article',
            'key' => 'id',
            'value' => $aid,
        );
        $result = $this->_adminSQL($where);
        return $result;
    }

    private function _adminSQL($where)
    {
        $where = $this->One($where);
        $sql = "select article.* from "
            . $this->db->dbprefix('system_admin') . ' as article '
            . $where;
        return $this->getRow($sql);
    }


    //添加管理员
    public function addAdmin($data)
    {
        $data['logtime'] = date('Y-m-d H:i:s');
        $data['salt'] = $this->random();
        $data['password'] = $this->regEncry($data['password'], $data['salt']);
        return $this->add('system_admin', $data);
    }


    //编辑管理员
    public function updateAdmin($id, $data)
    {
        return $this->update('system_admin', $data, $id);
    }

    public function pays($data)
    {
        $list = $this->_pays($data);
        return $list;
    }

    public function _pays($data, $all = null)
    {
        $where = array(							#列表的过滤条件： 模糊查询，时间段过滤
            'manager' => array(
                'filed'     => 'id',
                'type' 		=> "string",
                'table' 	=> 'pay',
                'expression'    => '='
            )
        );
        $where = $this->where($where, $data);
        #根据得到数据条数
        $result['sum'] = $this->_paysTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "pay",
                        'orderby' => 'desc'
                    ),
                );
                $orderdata = $this->makeOrder($orderdata, $data['order']);

                $order = $this->order($orderdata);
            } else {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "data",
                        'orderby' => 'desc'
                    ),
                );
                $order = $this->order($orderdata);
            }

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

            $result['data'] = $this->_paysList($where, $order, $limit['string'], $sum);
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

    /**
     *	模版数据总数
     */
    private function _paysTotal($where)
    {
        $sql = "select count(pay.id) as sum from "
            . $this->db->dbprefix('system_payment') . ' as pay  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    /**
     * 模版数据列表数据
     */
    private function _paysList($where, $order, $limit)
    {
        $sql = "select pay.* from "
            . $this->db->dbprefix('system_payment') . ' as pay  '
            . $where
            . $order
            . $limit;

        return $this->getResult($sql);
    }

    /**
     * 模版数据内容
     */
    public function pay($id)
    {
        $dataInfo = $this->_pay($id);
        if ($dataInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '模版数据不存在'
            );
        } else {
            $back = array(
                'status' => 'true',
                'code' => '0',
                'data' => $dataInfo
            );
        }
        return $back;
    }

    /**
     * 模版基金内容
     * @param $aid
     */
    private function _pay($id)
    {
        $where = array(
            'type' => 'int',
            'table' => 'data',
            'key' => 'id',
            'value' => $id,
        );
        $result = $this->_paySQL($where);
        return $result;
    }

    private function _paySQL($where)
    {
        $where = $this->One($where);
        $sql = "select pay.* from "
            . $this->db->dbprefix('system_payment') . ' as pay '
            . $where;
        return $this->getRow($sql);
    }

    public function paymentUpdate($id, $data)	#数据的验证
    {
        return $this->update('system_payment', $data, $id);
    }

    public function paymentAdd($data)
    {
        #$data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('system_payment', $data);
    }

}