<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/5/25
 * 
 */

class data_model extends MY_Model
{
    public function datas($data)
    {
        $list = $this->_datas($data);
        return $list;
    }

    public function _datas($data, $all = null)
    {
        $where = array(							#列表的过滤条件： 模糊查询，时间段过滤
            'manager' => array(
                'filed'     => 'id',
                'type' 		=> "string",
                'table' 	=> 'data',
                'expression'    => '='
            )
        );
        $where = $this->where($where, $data);
        #根据得到数据条数
        $result['sum'] = $this->_datasTotal($where);

        if ($result['sum'] != 0) {
            #有数据再去将具体数据读取出来
            $sum = $result['sum'];
            if (isset($data['order'])) {
                $orderdata = array(
                    'id' => array(        #字段名
                        'table' => "data",
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

            $result['data'] = $this->_datasList($where, $order, $limit['string'], $sum);
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
    private function _datasTotal($where)
    {
        $sql = "select count(data.id) as sum from "
            . $this->db->dbprefix('data') . ' as data  '
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
    private function _datasList($where, $order, $limit)
    {
        $sql = "select data.* from "
            . $this->db->dbprefix('data') . ' as data  '
            . $where
            . $order
            . $limit;

        return $this->getResult($sql);
    }

    /**
     * 模版数据内容
     */
    public function data($id)
    {
        $dataInfo = $this->_data($id);
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
    private function _data($id)
    {
        $where = array(
            'type' => 'int',
            'table' => 'data',
            'key' => 'id',
            'value' => $id,
        );
        $result = $this->_dataSQL($where);
        return $result;
    }

    private function _dataSQL($where)
    {
        $where = $this->One($where);
        $sql = "select data.* from "
            . $this->db->dbprefix('data') . ' as data '
            . $where;
        return $this->getRow($sql);
    }

    public function dataUpdate($id, $data)	#数据的验证
    {
        return $this->update('data', $data, $id);
    }

    public function dataAdd($data)
    {
        $data['logtime'] = date('Y-m-d H:i:s');
        return $this->add('data', $data);
    }



}