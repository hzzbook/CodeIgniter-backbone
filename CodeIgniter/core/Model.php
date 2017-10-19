<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
	
	function getResult($sql) {
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	function getRow($sql) {
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	function change($sql) {
		$this->db->query($sql);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 *  获得where条件字符串
	 *  $condition = array(
	 *  	array(字段名, 'like', 值, 表名),
	 *  	array(字段名, '>', 值),
	 *  	array(字段名, '=', 值)
	 *  );
	 * 
	 * 
	 */
	public function constring($condition) {
		
	 	if ($condition == '' || count($condition) == 0) {
	 		return '';
	 	}
	 	$cstr = array();
	 	foreach ($condition as $key=>$val) {
	 		if (isset($val[3])) {
		 		if ($val['1'] == 'like') {
		 			$cstr[$key] = $val['3'].'.'.$val[0].' '.$val[1]. ' "%'.$val[2].'%"';
		 		} else {
		 			$cstr[$key] = $val['3'].'.'.$val[0].' '.$val[1]. ' "'.$val[2].'"';
		 		}
	 		} else {
	 			if ($val['1'] == 'like') {
		 			$cstr[$key] = $val[0].' '.$val[1]. ' "%'.$val[2].'%"';
		 		} else {
		 			$cstr[$key] = $val[0].' '.$val[1]. ' "'.$val[2].'"';
		 		}
	 		}
	 	}
	 	$cstrs = ' where '.implode(' and ', $cstr);
	 	return  $cstrs;
	}
	
	//获取字段列表
	public function fieldlist($field) {
		if ($condition == '' || count($condition) == 0) {
	 		return '*';
	 	}
	 	$farr = $array();
	 	foreach ($field as $key=> $val) {
	 		if (isset($val[1]) && $val[1] != '') {
	 			$farr[] = $val[1].'.'.$val[0];
	 		} else {
	 			$farr[] = $val[0];
	 		}
	 	}
	 	$fieldstring = implode(',', $farr);
	 	return $fieldstring;
	}
	
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */