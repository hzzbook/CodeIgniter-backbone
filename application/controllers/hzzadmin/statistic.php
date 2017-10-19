<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/1/17
 * 
 */

class statistic extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data = array(
            'slider_tag' => 'statistic',
            'nav_tag' => 'index'
        );
        $this->display('backbone/statistic/index', $data);
    }

    public function normalPage()
    {
        $data = array(
            'slider_tag' => 'statistic',
            'nav_tag' => 'normalPage'
        );
        $this->display('backbone/statistic/normalPage', $data);
    }

    public function user()
    {
        $data = array(
            'slider_tag' => 'statistic',
            'nav_tag' => 'user'
        );
        $this->display('backbone/statistic/user', $data);
    }

    /**
     * 查询用户数
     */
    public function userbytime()
    {
        $type = $this->input->put('type');
        switch ($type)
        {
            case 'time':
                $startime = strtotime($this->input->put('start'));
                $endtime = strtotime($this->input->put('end'));
                break;
            case 'today':   #今日
                $starttime = time();
                $endtime = strtotime('+1 day', date('Y-m-d'))-1;
                break;
            case 'week':    #本周
                break;
            case 'month':   #本月
        }


    }


    public function booking()
    {
        $data = array(
            'slider_tag' => 'statistic',
            'nav_tag'    => 'booking'
        );
        $this->display('backbone/statistic/booking', $data);
    }

}