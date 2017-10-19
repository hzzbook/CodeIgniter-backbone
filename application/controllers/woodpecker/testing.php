<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/8/7
 * 
 */

class testing extends MY_Controller
{

    public function paybackday()
    {
        $month = 1;
        $days = 30;
        $date = '2017-3-31';
        $this->monthlypayment($date, $month);
        $this->daylypayment($date, $days);
    }

    function session()
    {
        session_start();
        $res = session_id();
        var_dump($res);
    }

    function captcha()
    {
        $this->load->library('captcha');
        $captcha = new Captcha();
        //$captcha->setSence('login');
        $captcha->setSite('100', '30');
        $captcha->create();

    }

    function checkCaptcha()
    {
        $this->load->library('captcha');
        $captcha = new Captcha();
        $code = '471h';
        //$sence = 'login';
        $res  = $captcha->checkCode($code);
        var_dump($res);
    }

    function getCode()
    {
        $this->load->library('captcha');
        $captcha = new Captcha();
        $res = $captcha->createCode();
        $res = $captcha->getCode();
        var_dump($res);
    }

    function case1()
    {
        $money = 5000;  #借款总额
        $rate =  16;    #年利率
        $timeline = 6;  #借款时长
        $startdate = '2017-10-6'; #计息日
        $type = '1';


    }

    function cal()
    {
        $this->load->library('calculator');
        $Calculator = new calculator();
        $money = 5000;
        $rate = 12;
        $date = '2017-3-12';
        $timeline = 6;
        $type = 'D';
        $timetype = 'm';
        $back = $Calculator->doing($money, $rate, $date, $timeline, $type, $timetype);
        var_dump($back);
    }


    /*
     * strtotime('+1 months' ）
     *  2-28的下一个月  是3-28
     *  3-31的下一个月  是5-1
     *  4-1的下一个月  5-1
     *
     *
     *
     */
    public function monthlypayment($date, $month)
    {
        $nextmonth = date('Y-m-d', strtotime('+1 months', strtotime($date)));
        var_dump($nextmonth);
    }

    public function daylypayment($date, $day)
    {
        $nextday = date('Y-m-d', strtotime('+'.$day.' days', strtotime($date)));
        var_dump($nextday);
    }

    public function money($total, $rate, $time, $endtime, $ckqx)
    {
        bcscale(6); //精确计算小数点后6位的数字
        $money = array();
        $monrate = bcdiv($rate , 100*12);  //月利率
        $dqrq = date('Y-m-d',$endtime);//到期时间  取得发布时间
        $dqrq = date('Y-m-d',strtotime("$dqrq + {$ckqx} day"));	//到期时间即约定满标时间
        $money['dqrq']=$dqrq;
        $type =1;
        switch($type) {
            case 1:
                //一次到期还本付息
                $money['yhlx'] = bcmul($total, $monrate)*$time;//应还利息
                $money['yhje'] = bcadd($money['yhlx'] , $total);//应还金额
                $money['yhbj'] = $total;//应还本金
                $money['dsje'] = $money['yhje'];
                $money['zqs']=1;//还款总期数
                $money['qs']=1;//还款期数
                $money['dqsj']=strtotime(date('Y-m-d',strtotime("$dqrq + {$time} month")));//到期时间
                $money['ye']=0;//还款余额
                break;
            case 2:
                //按月付息到期还本
                $moninte = bcmul($total, $monrate);//月利息
                $inte = bcmul($time,$moninte);//总的利息
                $sum = $total + $inte;//总额
                $money['yhje'] = bcadd($total, $moninte);//最后一个月的应还金额=本金+月利息
                //$money['dsje'] = bcadd(bcmul($moninte, ($time-1)),$money['yhje']);//待收金额=前面几个月的利息之和+最后一个月的应还金额
                $money['dsje'] = $sum;
                $money['yhlx'] = $moninte;
                $money['yhbj'] = $total;
                //$money['ye'] = bcsub($sum, $moninte);//余额，还差多少没还
                $money['qs'] = $time+1;
                $money['zqs'] = $time;
                $money['dqsj']=strtotime(date('Y-m-d',strtotime("$dqrq + {$money['qs']} month")));//到期时间
                break;
            case 3:
                //等额本息
                $cifang = bcpow((1+$monrate), $time);//(1+月利率)^借款期限
                $month = $total*$monrate*$cifang/($cifang-1);//每月固定还款金额
                $sum = $time*$month;
                $money['yhje'] = $month;
                $money['dsje'] = $sum;
                $money['yhlx'] = bcmul($total,$monrate);
                $money['yhbj'] = bcsub($money['yhje'],$money['yhlx']);
                $qs = $time+1;
                //$money['ye'] = bcmul($month,bcsub($time,$qs));//余额，还差多少没还
                $money['qs'] = $qs;
                $money['zqs'] = $time;
                $money['dqsj']=strtotime(date('Y-m-d',strtotime("$dqrq + {$qs} month")));//到期时间
                break;
        }
        var_dump($money);
    }

    public function lists()
    {
        $this->load->model('test/item_model', 'test_model');
        $input = $this->input->post();
        $input = array(
            'cateid' => '1',
            'starttime' => '2017-6-3',
            'endtime' => '2017-8-31',
            'name' => '花',
            'page' => 2
        );
        //$this->test_model->setC();
        $res = $this->test_model->lists($input);
        $this->config->load('datastatus', false, true);
        include(FCPATH.'app/config/datastatus.php');

        if ($res['status'] == 'true') {
            $data = $res['data'];
            foreach ($data as $key => $value) {
                $data[$key]['status'] = $datastatus[$value['status']];
                $data[$key]['addtime'] = date('Y-m-d', $value['addtime']);
            }
            $res['data'] = $data;
        }
        var_dump($res);
    }

    public function item()
    {
        $id = 3;
        $this->load->model('test/item_model', 'test_model');
        $res = $this->test_model->item($id);
        var_dump($res);
    }

    public function itemAdd()
    {
        $this->load->model('test/item_model', 'test_model');
        $res = $this->test_model->itemAdd();
    }

    public function itemUpdate()
    {

    }

    public function active()
    {
        $nav = '10';

        if ($nav == '10') echo "active10";
        if ($nav == '11') echo "active11";
        if ($nav == '12') echo "active12";
        if ($nav == '13') echo "active13";
    }



}