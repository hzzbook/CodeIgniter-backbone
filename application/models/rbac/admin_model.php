<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/7/26
 * 
 */
class admin_model extends Temp_Model
{
    var $table ="rbac_admin";

    public function admins()
    {
        $sql = "select admin.*, role.rolename from "
            . $this->db->dbprefix($this->table) . ' as admin '
            . ' left join '
            . $this->db->dbprefix('rbac_role') . ' as role '
            . ' on admin.role_id = role.id ';

        $data['data'] =  $this->getResult($sql);
        return $data;
    }

    public function random($length=4)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
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

    public function adminsRole()
    {
        $sql = "select * from "
            . $this->db->dbprefix($this->table) . ' as admin '
            . ' left join '
            . $this->db->dbprefix('rbac_role') .' as role '
            . ' on admin.role_id = role.id ';

        return $this->getResult($sql);
    }

    public function admin($id)
    {
        $sql = "select * from "
            . $this->db->dbprefix($this->table)
            . " where id='{$id}'";
        return $this->getRow($sql);
    }

    public function adminRole($id)
    {
        $sql = "select admin.*, role.rolename from "
            . $this->db->dbprefix($this->table) . ' as admin '
            . ' left join '
            . $this->db->dbprefix('rbac_role') .' as role '
            . ' on admin.role_id = role.id '
            . " where id='{$id}'";

        return $this->getRow($sql);
    }

    public function adminByUsername($username)
    {
        $sql = "select admin.*, role.rolename from "
            . $this->db->dbprefix($this->table) . ' as admin '
            . ' left join '
            . $this->db->dbprefix('rbac_role') .' as role '
            . ' on admin.role_id = role.id '
            . " where admin.username='{$username}'";

        return $this->getRow($sql);
    }

    public function adminUpdate($data, $id)
    {
        if (isset($data['password']) && $data['password'] != '') {
            $admin = $this->admin($id);
            $data['password'] = $this->encrypt($data['password'], $admin['salt']);
        } else {
            unset($data['password']);
        }
        return $this->update($this->table, $data, $id);
    }

    public function encrypt($password, $salt)
    {
        return md5(md5($password, $salt).'I~@j');
    }

    public function adminAdd($data)
    {
        $data['salt'] = $this->random();
        $data['password'] = $this->encrypt($data['password'], $data['salt']);
        $data['addtime'] = time();
        $addid = $this->add($this->table, $data);
        return $addid;
    }

    public function adminDelete($id)
    {
        $this->delete($this->table, $id);
    }
}