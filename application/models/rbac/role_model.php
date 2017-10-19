<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/7/26
 * 
 */

class role_model extends Temp_model
{
    var $table = 'rbac_role';

    /**
     * 角色列表
     * @return bool
     */
    public function roles()
    {
        $sql = "select * from "
            . $this->db->dbprefix($this->table);

        $data['data'] = $this->getResult($sql);
        return $data;
    }


    /**
     * 角色信息
     * @param $id
     * @return bool
     */
    public function role($id)
    {
        $sql = "select * from "
            . $this->db->dbprefix($this->table)
            . " where id='{$id}'";

        $dataInfo = $this->getRow($sql);
        if ($dataInfo == FALSE) {
            $back = array(
                'status' => 'false',
                'code' => '404',
                'info' => '角色不存在'
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
     * 角色权限
     * @param $id
     * @return bool
     */
    public function roleNode($id)
    {
        if ($id == 1) {     #超级管理员具有绝对权限
            $sql = "select * from "
                . $this->db->dbprefix('rbac_node')
                . ' order by p_id asc, ordernum asc ';
        }  else {
            $sql = "select node.* from "
                . $this->db->dbprefix($this->table) . ' as role '
                . ' left join '
                . $this->db->dbprefix('rbac_role_node') . ' as rolenode '
                . ' on role.id = rolenode.role_id '
                . ' left join '
                . $this->db->dbprefix('rbac_node') . ' as node '
                . ' on rolenode.node_id = node.id'
                . " where role.id = '{$id}'"
                . ' order by p_id asc, ordernum asc, id asc ';
        }
        return $this->getResult($sql);
    }

    /**
     * 授权操作
     */
    public function authorize($id, $nodelist)
    {
        $now = $this->roleNode($id);
        $type = array();
        if ($now != false)
        {
            foreach ($now as $key => $value)
            {
                $type[] = $value['id'];
            }
        }
        $delete = array_diff($type, $nodelist);;
        $add = array_diff($nodelist, $type);
        foreach ($delete as $value)
        {
            $con = array('role_id' => $id, 'node_id' => $value);
            $this->db->where($con);
            $this->db->delete('rbac_role_node');
        }

        foreach ($add as $value)
        {
            $con = array('role_id' => $id, 'node_id' => $value);
            $this->db->insert('rbac_role_node', $con);
        }
        return true;

    }



}