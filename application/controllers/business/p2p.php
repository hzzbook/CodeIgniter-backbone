<?php
/**
 * p2p 网贷
 * 说明：
 * 涉及的对象有
 * 借款人 loaner，投资人 invester，平台 paaser，托管银行 banker
 *
 * 核心业务列表
 * 1、借款人通过平台方发布借款，完成借款项目，平台方抽取佣金
 * 2、投资人在平台搜索意向借款项目进行投资，借款回款后，平台方抽取佣金
 * 3、资金的流动都通过托管银行
 *
 *
 *
 * @Author: hzz
 * @Date: 2017/11/13
 * 
 */

class p2p extends MY_Controller
{

    //发布借款
    public function publish()
    {
        #借款人信息
        $loanerInfo = array(

        );
        #借款项目信息
        $loanInfo = array(

        );
    }


}