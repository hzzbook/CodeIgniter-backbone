<?php
/**
 * 获取IP地址
 */
if ( ! function_exists('GetIP')) {
	function GetIP(){ 
			if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
				$ip = getenv("HTTP_CLIENT_IP"); 
			else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
				$ip = getenv("HTTP_X_FORWARDED_FOR"); 
			else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
				$ip = getenv("REMOTE_ADDR"); 
			else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
				$ip = $_SERVER['REMOTE_ADDR']; 
			else 
				$ip = "0.0.0.0"; 
			return($ip); 
		}
}

/**
 * 将部分字符替换为*号
 */
if ( !function_exists('replaceX')) {
        function replaceX($str, $start = 2, $end = 2, $time = 4) {
                $strlen = strlen($str);
                $len = $strlen-$start-$end;
                $restr = str_repeat('*', $time);
                return substr_replace($str, $restr, $start, $len);
        }
}

/**
 * 
 * 获取随机字符串
 * 
 */
if (!function_exists('randomstr')) {
	function randomstr($len, $type = null) {
		switch ($type) {
			case 'word':
				$c = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
				break;
			case 'num':
				$c = "0123456789";
				break;
			default:
				$c = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
				break;
		}
		srand((double)microtime()*1000000);
		$rand = ''; 
		for($i=0; $i<$len; $i++) { 
			$rand.= $c[rand()%strlen($c)]; 
		} 
		return $rand; 
	}
}

/**
 * 添加千分位符
 */
if (!function_exists('thousandsX') ) {
	function thousandsX($str) {
		
		$pos = strpos($str, '.');
		if ($pos === false) {
			$line = $str;
			$end = '';
		} else {
			$end = substr($str, $pos);
			$endlen = strlen($end);
			$strlen = strlen($str);
			$line = substr($str, 0, $strlen-$endlen);
		}
		if (strlen($line) > 3) {
			$linelen = strlen($line) % 3;
			$line_e = substr($line, $linelen);
			if ($linelen != 0) {
				$s = substr($line, 0, $linelen);
				$data = str_split($line_e, 3);
				array_unshift($data, $s);
			} else {
				$data = str_split($line_e, 3);
			}
			$start = implode(',', $data);
		} else {
			$start = $line;
		}
		return $start.$end;	
	}
}

/**
 * 取小数点后两位
 */
if ( ! function_exists('pointtwo')) {
	function pointtwo($str) {
		return number_format($str, 2, '.', '');
	}
}
