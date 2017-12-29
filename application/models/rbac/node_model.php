<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/7/26
 * 
 */
class node_model extends Temp_model
{
    var $table = 'rbac_node';

    var $where = array(
        'title' => array(
            'filed' => 'node_name',
            'expression' => 'like'
        ),
    );

    public function nodeLevel()
    {
        $sql = " select * from "
            . $this->db->dbprefix($this->table)
            . " where p_id = 0 and node_type=1";
        return $this->getResult($sql);
    }

    public function nodes($node, $all = null)
    {
        $list = $this->_nodes($node, $all);
        return $list;
    }

    public function _nodes($node, $all = null)
    {
        $where = array(							#列表的过滤条件： 模糊查询，时间段过滤
            'manager' => array(
                'filed'     => 'id',
                'type' 		=> "string",
                'table' 	=> 'node',
                'expression'    => '='
            )
        );
        $where = $this->where($where, $node);
        #根据得到数据条数
        $result['sum'] = $this->_nodesTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($node['order'])) {
                $ordernode = array(
                    'id' => array(        #字段名
                        'table' => "node",
                        'orderby' => 'desc'
                    ),
                );
                $ordernode = $this->makeOrder($ordernode, $node['order']);

                $order = $this->order($ordernode);
            } else {
                $ordernode = array(
                    'id' => array(        #字段名
                        'table' => "node",
                        'filed' => "id",
                        'orderby' => 'asc'
                    ),
                );
                $order = $this->order($ordernode);
            }

            if ($all == 'all') {
                $limit = array();
                $limit['string'] = '';
                $limit['page'] = 1;
            } else {
                $limit = $this->limit($node, $sum);
                if ($limit == 'toobig') {
                    $back = array(
                        'status' => 'false',
                        'code' => '406',
                        'info' => urlencode('没有更多数据了')
                    );
                    return $back;
                }
            }

            $result['data'] = $this->_nodesList($where, $order, $limit['string'], $sum);
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
     *	权限结点总数
     */
    private function _nodesTotal($where)
    {
        $sql = "select count(node.id) as sum from "
            . $this->db->dbprefix($this->table) . ' as node  '
            . $where;

        $result = $this->getRow($sql);
        if ($result['sum'] >= 1) {
            return $result['sum'];
        } else {
            return 0;
        }
    }

    /**
     * 权限结点列表数据
     */
    private function _nodesList($where, $order, $limit)
    {
        $sql = "select node.* from "
            . $this->db->dbprefix($this->table) . ' as node  '
            . $where
            . $order
            . $limit;
        return $this->getResult($sql);
    }

    public function node($id)
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

    public function nodeAdd($data)
    {
        $addid = $this->add($this->table, $data);
        return $addid;
    }


}