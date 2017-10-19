<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/10/19
 * 
 */
class auction extends frontbase
{

    public function __construct()
    {
        parent::__construct();
    }

    #用户获取积分
    public function get()
    {
        $this->load->model('auction/credit_model', 'model');
        $uid = 1;
        $credit = 10;
        $from ='签到';
        $sn = '123232';
        $remark = '签到1天';
        $this->model->addCredit($uid, $credit, $from, $sn, $remark);
    }


}