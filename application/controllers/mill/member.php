<?php
/**
 * 会员成长体系
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/9/26
 * 
 */

class member extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function display($view, $data = null)
    {
        $path  = 'member/';
        $this->load->view($path.$view, $data);
    }

    public function index()
    {
        $this->load->model('test/integral_model', 'integral_model');
        $userid = '1';
        $res = $this->integral_model->item($userid, 'userid');
        if ($res['status'] == 'false' && $res['code'] == '404')
        {
            $this->integral_model->init($userid);
        }

        $this->display('index');
    }

    #会员等级确定
    #会员等级表          用户Id   会员   会员等级   起始时间     结束时间
    #会员等级变动表      用户Id   会员等级   变动原因
    public function level()
    {

    }

    #获取积分
    /*
     数据表结构
    1、用户积分表    用户Id  积分总数
    2、用户积分流水表    用户id  积分总数  变动积分数   变动时间   变动原因    使用渠道
     *
     */
    public function gain()
    {

    }

    #使用积分
    public function expend()
    {

    }



}