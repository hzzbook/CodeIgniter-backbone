<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 /**
  * 
  * 分页类
  * 
  * @author Hzz
  *
  */ 
class Pageclass {
	private $nums = 10;   //单页显示条数
	private $pages = 1;   //当前页数
	private $total = 122;		  //总条数
	private $string = ''; 		//过滤条件
	private $totalpage = 10;
	
	public function __construct($string='', $total = 0, $cur = 1, $nums = 2) {
		$this->string = strtolower($string);
		$this->totalpage = $total;
		$this->pages = $cur;
		$this->nums = $nums;
		$this->totalpage = ceil($total/$nums);
	}
	
	public function show($type = 'default') {
		switch ($type) {
			case '1':
				$result = $this->show_type1();
				break;
			case '2':
				$result = $this->show_type2();
				break;
			case '3':
				$result = $this->show_type3();
				break;
			default:
				$result = $this->show_type1();
		}
		return $result;
	}
	
	/*
	 * 上一页
	 */
	private function prepage() {
		if ($this->pages != 1) 
			$page = $this->pages - 1;
			
		$str = "<li><a class='preclass' href='".$this->string.'page='.$page."'>上一页</a></li>";

		return $str;
	}
	
	/*
	 * 
	 * 下一页
	 */
	private function nextpage() {
		if ($this->pages != $this->totalpage)
			$page = $this->pages + 1;
		$str = "<li><a class='nextpage' href='".$this->string.'page='.$page."'>下一页</a></li>";

		return $str;
	}
	
	/*
	 * 
	 * 第一页
	 */
	private function firstpage() {
		$str = "<li><a class='firstpage' href='".$this->string."page=1'>第一页</a></li>";
		return $str;
	}
	
	/*
	 * 最后一页 
	 * 
	 */
	private function lastpage() {
		if ($this->pages != $this->totalpage)
			$page = $this->pages - 1;
		else 
			$page = $this-pages;
		$str = "<li><a class='lastpage' href='".$this->string."page=".$this->totalpage."'>尾页</a></li>";
		return $str;
	}
	
	public function getData($userlist) {
		$nums = $this->nums;
		$min = ($this->pages-1) * $nums;
		$max = $min + $nums;
		$userlists = array();
		if ($userlist !== false) {
		foreach ($userlist as $key=>$val) {
			if ($key >= $min && $key < $max) {
				$userlists[] = $val;
			}
		}
		} else {
			return false;
		}
		return $userlists;
	}
	
	
	public function show_type1() {
		if ($this->totalpage <= 1) {
			return '';
		}
		$string = '<div class="pagination"><ul>';
		if ($this->pages != 1) {
			$string .= $this->firstpage();
			$string .= $this->prepage();
			
		}
		if ($this->pages <= 3) {
			$start = 1;
		} else {
			$start = $this->pages - 3;
		}
		
		if ($this->pages >= $this->totalpage -3) {
			$end = $this->totalpage;
		} else {
			$end = $this->totalpage - 3;
		}
		for($i = $start; $i < $start+7 && $i <= $this->totalpage; $i++) {
			if ($i == $this->pages) {
				$string .= '<li><a class="curpage" href="'.$this->string.'page='.$i.'">'.$i.'</a></li>';
			} else 
				$string .= '<li><a href="'.$this->string.'page='.$i.'">'.$i.'</a></li>';
		}
	/*	$string .= '<li><a>...</a></li>';
		for($i = $end-3; $i < $end; $i++) {
			if ($i == $this->pages) {
				$string .= '<li><a class="curpage" href="'.$this->string.'page='.$i.'">'.$i.'</a></li>';
			} else 
				$string .= '<li><a href="'.$this->string.'page='.$i.'">'.$i.'</a></li>';
		}*/
		
		if ($this->pages != $this->totalpage) {
			$string .= $this->nextpage();
			//var_dump($this->lastpage());
			$string .= $this->lastpage();
		}
		$string .= '</ul></div>';
		return $string;
	}
	
	
	
}