<?php
/**
 * 签到活动
 * 说明：
 *
 * 签到表
    用户id  签到时间
   补签机会
 *
 *
 * @Author: hzz
 * @Date: 2017/9/25
 * 
 */
class sign extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo "签到活动";
        $userid = 1;
        $this->load->model('test/sign_model', 'sign_model');
        $res = $this->sign_model->isSigned($userid);
        var_dump($res);
    }

    //签到操作
    public function doing()
    {
        $date = time();
        $this->load->model('test/sign_model', 'sign_model');
        $userid = 1;
        $res = $this->sign_model->signing($userid, $date);
        var_dump($res);
    }


    //获取补签卡
    public function mend()
    {

    }




}