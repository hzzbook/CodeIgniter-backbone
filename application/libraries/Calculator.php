<?php
/**
 * 还款计算器
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/8/10
 * 
 */
/*
 *
$caluator = new caluator();
$money = 10000;
$rate = 12;
$date = '2017-8-30;
$timeline = 12;
$type = 'A';
$timetype = 'm';
$result = $caluator->doing($money, $rate, $date, $timeline, $type, $timetype);
if ($result != false) {

}
 *
 */
class calculator
{

    function __construct()
    {
        bcscale(6);     #因为小数点的位数也会产生一定的误差，需要说明计算的位数
    }

    /**
     *
     * 计算过程
     *
     * @param $money 借款总额
     * @param $rate  借款利率   统一为年利率
     * @param $date  计息日期
     * @param $timeline 借款时长
     * @param $type     计息方式    A表示本息到期一次归还，  B表示按月还息到期还本， C表示等额本息， D表示等额本金
     * @param $timetype 时长单位 m 表示月  d表示天  y表示年
     */
    function doing($money, $rate, $date, $timeline, $type = 'A', $timetype = 'm')
    {
        if ($timetype == 'd') { #按天计息，只有一次到期归还
            $type = 'Ad';
            $back = $this->$type($money, $rate, $date, $timeline);
            return $back;
        } elseif ($timetype == 'm') {
            $type = $type.'m';
            $back = $this->$type($money, $rate, $date, $timeline);
            return $back;
        } elseif ($timetype == 'y') {
            $timeline = $timeline * 12;
            $type = $type.'m';
            $back = $this->$type($money, $rate, $date, $timeline);
            return $back;
        }
        return false;
    }

    function Ad($money, $rate, $date, $timeline) #A表示本息到期一次归还
    {
        #还款日
        $backdate = date('Y-m-d', strtotime('+'.$timeline.' days', strtotime($date)));
        #日利率
        $dayrate = bcdiv(bcdiv($rate, 100), 365);  #以一年为365日来计算日利息
        #总利息
        $interest = bcmul(bcmul($money, $dayrate), $timeline);
        $total = bcadd($money, $interest);
        $back = array(
            'backdate' => $backdate,
            'interest' => $interest,
            'total'    => $total
        );
        return $back;
    }

    function Am($money, $rate, $date, $timeline)    #A表示本息到期一次归还
    {
        #还款日
        $backdate = date('Y-m-d', strtotime('+'.$timeline.' months', strtotime($date)));
        #月利率
        $monthrate = bcdiv(bcdiv($rate, 100), 12);  #以一年为12个月
        #总利息
        $interest = bcmul(bcmul($money, $monthrate), $timeline);
        $total = bcadd($money, $interest);

        $back = array(
            'backdate' => $backdate,
            'interest' => $interest,
            'total'    => $total
        );
        return $back;
    }

    function Bm($money, $rate, $date, $timeline)    #B表示按月还息到期还本
    {
        #结款日
        $backdate = date('Y-m-d', strtotime('+'.$timeline.' months', strtotime($date)));
        #月利率
        $monthrate = bcdiv(bcdiv($rate, 100), 12);  #以一年为12个月
        #总利息
        $interest = bcmul(bcmul($money, $monthrate), $timeline);
        $total = bcadd($money, $interest);

        $backplan = array();

        for($i =1;$i<=$timeline; $i++) {
            $item['num'] = $i;
            $item['date'] = date('Y-m-d', strtotime('+'.$i.' months', strtotime($date)));
            $item['interest'] = bcmul($money, $monthrate);
            if ($i == $timeline) {
                $item['total'] = $money + $item['interest'];
            } else {
                $item['total'] = 0;
            }
            $backplan[] = $item;
        }

        $back = array(
            'backdate' => $backdate,
            'interest' => $interest,
            'total'    => $total,
            'backplan' => $backplan
        );
        return $back;
    }

    function Cm($money, $rate, $date, $timeline)    #C表示等额本息
    {
        #结款日
        $backdate = date('Y-m-d', strtotime('+'.$timeline.' months', strtotime($date)));
        #月利率
        $monthrate = bcdiv(bcdiv($rate, 100), 12);  #以一年为12个月

        $cifang = bcpow((1+$monthrate), $timeline);//(1+月利率)^借款期限
        $month = bcdiv(bcmul(bcmul($money,$monthrate),$cifang), ($cifang-1));//每月固定还款金额
        $total = bcmul($timeline, $month);
        $monthtotal = $month;
        //$interest = $total - $money;      #这样计算的还款利息会高于分别几个月环境利息之和，因为有小数点后3位乘误差
        $backplan = array();
        $interest = 0;
        for ($i = 1; $i <= $timeline; $i ++) {
            $item['num'] = $i;
            $item['date'] =  $item['date'] = date('Y-m-d', strtotime('+'.$i.' months', strtotime($date)));;
            //每月应还利息=贷款本金×月利率×〔(1+月利率)^还款月数-(1+月利率)^(还款月序号-1)〕÷〔(1+月利率)^还款月数-1〕
            $item['interest'] = bcdiv(bcmul(bcmul($money, $monthrate), (bcpow((1+$monthrate), $timeline))-bcpow((1+$monthrate), ($i-1))) , (bcpow((1+$monthrate), $timeline) - 1));
            #每月应该还的本息总额
            //$total2 = bcdiv(bcmul(bcmul($total, $monthrate), bcpow((1+$monthrate), $timeline)), (bcpow((1+$monthrate), $timeline) - 1));
            $interest = $interest + $item['interest'];
            $item['total'] = $monthtotal;
            $backplan[] = $item;
        }
        $back = array(
            'backdate' => $backdate,
            'interest' => $interest,
            'total'    => $total,
            'backplan' => $backplan
        );

        return $back;
    }

    function Dm($money, $rate, $date, $timeline)    #D表示等额本金
    {
        #结款日
        $backdate = date('Y-m-d', strtotime('+'.$timeline.' months', strtotime($date)));
        #月利率
        $monthrate = bcdiv(bcdiv($rate, 100), 12);  #以一年为12个月

        #每个月还的本金
        $month_money = bcdiv($money, $timeline);
        //$interest = $total - $money;      #这样计算的还款利息会高于分别几个月环境利息之和，因为有小数点后3位乘误差
        $backplan = array();
        $interest = 0;
        $total = 0;
        for ($i = 1; $i <= $timeline; $i ++) {
            $item['num'] = $i;
            $item['date'] =  $item['date'] = date('Y-m-d', strtotime('+'.$i.' months', strtotime($date)));;
            //（本金 — 已归还本金累计额）×每月利率
            $item['interest'] = bcmul(bcsub($money, bcmul($month_money, $i-1)), $monthrate);
            $interest = $interest + $item['interest'];
            $item['total'] = bcadd($month_money, $item['interest']);
            $total = $total + $item['total'];
            $backplan[] = $item;
        }
        $back = array(
            'backdate' => $backdate,
            'interest' => $interest,
            'total'    => $total,
            'backplan' => $backplan
        );

        return $back;
    }

}