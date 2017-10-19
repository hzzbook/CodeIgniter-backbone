<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/10/19
 * 
 */
class credit_model extends Temp_model
{

    var $table = 'auction_credit';


    #获取用户积分数
    public function get($uid)
    {
        $sql = "select * from "
            . $this->db->dbprefix($this->table)
            . " where id='{$uid}'";
        return $this->getRow($sql);
    }

    #用户增加积分
    /**
     * @param  $uid   用户id
     * @param $credit 增加的积分数
     * @param $from   积分来源
     * @param $sn     sn编号
     * @param $remark   备注
     */
    public function addCredit($uid, $credit, $from, $sn, $remark)
    {
        $userInfo = $this->get($uid);
        if ($userInfo == false) {
            $userInfo['id'] = $uid;
            $userInfo['credit'] = 0;
            $userInfo['credit'] = 0;
            $this->add($this->table, $userInfo);
        }
        $userData = array(
            'credit' => $userInfo['credit'] + $credit
        );
        $this->update($this->table, $userData, $uid);

        $billData = array(
            'uid' => $uid,
            'sn' => $sn,
            'from' => $from,
            'tag' => '1',
            'number' => $credit,
            'total' => $userData['credit'],
            'logtime' => time(),
            'remark' => $remark,
            'status' => '1'
        );
        $this->add('auction_bill', $billData);
        $back = array(
            'status' => 'true',
            'code' => '0'
        );
        return $back;
    }

    public function subCredit($uid, $credit, $from, $sn, $remark)
    {
        $userInfo = $this->get($uid);
        if ($userInfo == false) {
            $back = array(
                'status' => 'false',
                'code' => '400',
                'info' => '用户积分不足'
            );
            return $back;
        }
        $userData = array(
            'credit' => $userInfo['credit'] - $credit
        );
        if ($userData['cretid'] < 0) {
            $back = array(
                'status' => 'false',
                'code' => '400',
                'info' => '用户积分不足'
            );
            return $back;
        }
        $this->update($this->table, $userData, $uid);
        $billData = array(
            'uid' => $uid,
            'sn' => $sn,
            'from' => $from,
            'tag' => '0',
            'number' => $credit,
            'total' => $userData['credit'],
            'logtime' => time(),
            'remark' => $remark,
            'status' => '1'
        );
        $this->add('auction_bill', $billData);
        $back = array(
            'status' => 'true',
            'code' => '0'
        );
        return $back;
    }



}