<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/6
 * 
 */
if (!function_exists('nextday')) {
    function nextday($date = null) {
        if ($date == '') {
            return date('Ymd', strtotime("+1 day", time()));
        } else {
            return date('Ymd', strtotime("+1 day", strtotime($date)));
        }
    }
}

/**
 * 获取前一天的日期
 */
if (!function_exists('preday')) {
    function preday($date = null) {
        if ($date != '') {
            return date('Ymd', strtotime("-1 day", strtotime($date)));
        } else {
            return date('Ymd', strtotime("-1 day", time()));
        }
    }
}

/**
 * 获取下一月的日期
 */
if (!function_exists('nextmonth')) {
    function nextmonth($date = null) {
        if ($date != '') {
            return date('Ymd', strtotime("+1 month", strtotime($date)));
        } else {
            return date('Ymd', strtotime("+1 month", time()));
        }
    }
}

/**
 * 获取上一月的日期
 */
if (!function_exists('premonth')) {
    function premonth($date = null) {
        if ($date != '') {
            return date('Ymd', strtotime("-1 month", strtotime($date)));
        } else {
            return date('Ymd', strtotime("-1 month", time()));
        }
    }
}

/**
 * 获取本日的时间范围
 * $data data[0] 为起始时间(UNIX时间) data[1] 为终止时间
 */
if (!function_exists('todaytime')) {
    function todayTime($date = null) {
        if ($date != '') {
            $today  = $date;
        } else {
            $today = date('Ymd');
        }
        $today = strtotime($today);
        $nextday = strtotime("+1 day", $today)-1;
        return array($today, $nextday);
    }
}

/**
 *
 * 获取本周时间
 * @param unknown_type $date
 */
if (!function_exists('weekTime')) {
    function weekTime($date = null) {
        if ($date != '') {
            $time = strtotime($date);
            $start = mktime(0,0,0,date("m", $time),date("d", $time)-date("w", $time)+1,date("Y", $time));
            $end = mktime(23,59,59,date("m", $time),date("d", $time)-date("w", $time)+7,date("Y", $time));
        } else {
            $start = mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"));
            $end = mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"));
        }
        $data = array($start, $end);
        return $data;
    }
}

/**
 * 获取本月的时间
 * @return $data data[0] 为起始时间(UNIX时间) data[1] 为终止时间
 */
if (!function_exists('monthTime')) {
    function monthTime($date = null) {
        if ($date != '') {
            $curmon = date('Ym', strtotime($date));
        } else {
            $curmon = date('Ym', time());
        }
        $data[] = strtotime($curmon.'01');
        $data[] = strtotime("+1 month", $data[0])-1;
        return $data;
    }
}

/**
 *
 * 获取本年的时间
 * @param $data data[0] 为起始时间(UNIX时间) data[1] 为终止时间
 */

if (!function_exists('yearTime')) {
    function yearTime($date = null) {
        if ($date != '' ) {
            $curyear = date('Y', strtotime($date));
        } else {
            $curyear = date('Y', time());
        }
        $data[] = strtotime($curyear.'-1-1');
        $data[] = strtotime("+1 year", $data[0])-1;
        return $data;
    }
}

/**
 *
 * 获取到7天内时间
 * @param $date
 */
if (!function_exists('nextWeek')) {
    function nextWeek($date = null) {
        if ($date != '') {
            $now = strtotime($date);
        } else {
            $now = time();
        }
        return date('Ymd', $now+60*60*24*7);
    }
}

/**
 *
 * 获取7日前时间
 * @param unknown_type $date
 */
if (!function_exists('preWeek')) {
    function preWeek($date = null) {
        if ($date != '') {
            $now = strtotime($date);
        } else {
            $now = time();
        }
        return date('Y-m-d', $now-60*60*24*7);
    }
}



/**
 * 获取月份的日数
 */
if (!function_exists('daylist')) {
    function daylist($date) {
        $year = date("Y", strtotime($date));
        $month = date("m", strtotime($date));
        if (in_array($month, array(1, 3, 5, 7, 8, '01', '03', '05', '07', '08', 10, 12))) {
            $days = '31';
        }elseif ($month == 2){
            if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 !== 0)) {        //判断是否是闰年
                $days = '29';
            } else {
                $days = '28';
            }
        } else {
            $days = '30';
        }
        $daylist = array();
        for($i = 1; $i <= $days; $i++) {
            if ($i < 10){
                $daylist[] = '0'.$i;
            } else {
                $daylist[] = $i;
            }
        }
        return $daylist;
    }
}

if (!function_exists('toDate')) {
    function toDate($time) {
        return date('Y-m-d', $time);
    }
}