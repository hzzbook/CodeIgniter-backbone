<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/9/27
 * 
 */
class sign_model extends MY_Model
{

    var $table = 'test_sign';

    public function isSigned($userid, $date = null)
    {
        if ($date == '')
            $day = date('Y-m-d');
        else
            $day = $date;
        $sql = "select id from "
            . $this->db->dbprefix($this->table)
            .  " where signtime='{$day}' and userid='{$userid}'";
        $res = $this->getRow($sql);
        if ($res == FALSE)
        {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function signing($userid, $date = null)
    {
        $signed = $this->isSigned($userid, $date);
        if ($signed == FALSE) {
            $today = date('Y-m-d');
            $data = array(
                'userid' => $userid,
                'signtime' => $today,
                'addtime' => time()
            );
            $res = $this->add($this->table, $data);
            if ($res != false) {
                $back = array(
                    'status' => 'false',
                    'code' => '500',
                    'info' => '已经签到过了'
                );
            } else {
                $back = array(
                    'status' => 'false',
                    'code' => '500',
                    'info' => '已经签到过了'
                );
            }
            return $back;
        } else {
            $back = array(
                'status' => 'false',
                'code' => '500',
                'info' => '已经签到过了'
            );
            return $back;
        }
    }

}