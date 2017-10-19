<?php

function getChartXTime($unit,$starttime,$stoptime){
	$x = array();
	if($unit=='y'){
		/*年*/
		for($i=date("Y",$starttime);$i<=date("Y",$stoptime);$i++){
			$x[]=$i;
		}
	}
	if($unit=='m'){
		/*月*/
		$m = (date("Y",$stoptime)-date("Y",$starttime))*12+(date("m",$stoptime)-date("m",$starttime));
		for($i=0;$i<=$m;$i++){
			$x[]=date("Ym", strtotime('+'.$i.' month',$starttime));
		}
	}
	if($unit=='d'){
		/*天*/
		$d = ($stoptime-$starttime)/3600/24;
		for($i=0;$i<=$d;$i++){
			$x[]=date("Ymd", strtotime('+'.$i.' day',$starttime));
		}
	}
	if($unit=='h'){
		/*小时*/
		for($i=0;$i<=23;$i++){
			$x[]=date("H", strtotime('+'.$i.' hour',$starttime));
		}
	}
	return $x;
}

function formaTime($unit,$time){
	if($unit=='y'){
		/*年*/
		return date("Y",strtotime($time));
	}
	if($unit=='m'){
		/*月*/
		return date("Ym",strtotime($time));
	}
	if($unit=='d'){
		/*天*/
		return date("Ymd",strtotime($time));
	}
}