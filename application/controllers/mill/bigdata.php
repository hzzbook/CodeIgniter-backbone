<?php
/**
 * 大数据模拟
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/22
 * 
 */
class bigdata extends MY_Controller
{

    public function __construct()
    {
        parent::get_instance();
    }

    #创建数据，一张表1800万数据
    public function make()
    {
        $contime_start = 20150101;
        $confid = mt_rand(100000,999999);
        $i=$v=0;
        while($v<1800){
            $confid = mt_rand(100000,999999);
            while($i<100){
                $sql="insert into testtime values('',{$confid},{$contime_start})";
                for($t=0;$t<100;$t++){
                    $contime_start++;
                    $sql.=",('',{$confid},{$contime_start})";
                }
                if ($this->db->query($sql)){
                    echo "insert ok ".$v.'----'.$i."\r\n";
                }else{
                    echo "Error creating database: error" ;
                    exit();
                }
                $i++;
            }

            $i=0;
            $v++;
            echo $v."\r\n";
        }
    }

}