<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/12/27
 * 
 */
class tutorial extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    function getResult($sql) {
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getRow($sql) {
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

}