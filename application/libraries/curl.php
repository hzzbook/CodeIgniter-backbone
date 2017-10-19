<?php

class Curl {
	
	public function __construct() {
		
	}
	
	//CURL 获取GET返回的数据
	public  function doCurlGetRequest($url, $data, $timeout = 5) {
		
		if ($url == '' || $timeout <= 0) {
			return false;
		}
		$url = $url . '?' .http_build_query($data);
		echo $url;
		$con = curl_init((string)$url);
		curl_setopt($con, CURLOPT_HEADER, false);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
		
		return curl_exec($con);
		
	}
	
 	private function httpGet($url) {
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($curl, CURLOPT_URL, $url);
	
	    $res = curl_exec($curl);
	    curl_close($curl);
	
	    return $res;
	  }
	
	public function post($url, $data) {
		 $ch = curl_init();
 		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		 curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 $tmpInfo = curl_exec($ch);
		 if (curl_errno($ch)) {
		  return curl_error($ch);
		 }
		 curl_close($ch);
		 return $tmpInfo;
	}
	
	//CURL 获取POST返回数据
	public function doCurlPostRequest($url, $requestString, $timeout = 5) {
		if ($url == '' || $requestString == '' || $timeout <=0) {
			return false;
		}
		
		$con = curl_init((string)$url);
		curl_setopt($con, CURLOPT_HEADER, false);
		curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
		curl_setopt($con, CURLOPT_POST, true);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
		
		return curl_exec($con);
		
	}
	
	
}