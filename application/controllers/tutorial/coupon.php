<?php
/**
 *
 * 红包 优惠券
 * 说明：
 * 1、返现券
 *      购买某个商品，及时返还一点优惠金额 ----简单粗暴
 * 2、满减
 *      购买达到一定金额，可以扣除优惠金额-----凑单
 * 3、
 *
 * 表结构
 * 券id
 * 券的优惠方式
 * 优惠金额
 * 券的类型
 * 券的使用范围
 * 券的获取时间 及 有效期限
 * 券的使用状态
 *
 * 
 * @Author: hzz
 * @Date: 2017/9/25
 * 
 */
class coupon extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //红包/券发放情况
    public function index()
    {

    }

    //个人红包/券情况
    public function lists()
    {

    }

    //发放操作
    public function send()
    {

    }

    //使用操作
    public function used()
    {

    }
}