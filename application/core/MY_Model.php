<?php


class MY_Model extends CI_Model {
	
	public function __construct($group_name = '') {
		parent::__construct();
        $this->initDb($group_name);
    }

    #读写分离
    private function initDb($group_name = '')
    {
        $db_conn_name = $this->getDbName($group_name);
        $CI = & get_instance();
        if(isset($CI->{$db_conn_name}) && is_object($CI->{$db_conn_name})) {
            $this->db = $CI->{$db_conn_name};
        } else {
            $CI->{$db_conn_name} = $this->db = $this->load->database($group_name, TRUE);
        }
    }
    private function getDbName($group_name = '')
    {
        if($group_name == '') {
            $db_conn_name = 'db';
        } else {
            $db_conn_name = 'db_'.$group_name;
        }
        return $db_conn_name;
    }
	
	//获取一条记录的条件生成
	/**
	 * $where = array('type'=>'int/string','table'=>'','key'=>'', 'value' => '');
	 */
	function One($where) {
		if (!isset($where['key']) || !isset($where['value']) || $where['key'] == '' || $where['value'] == '') {
			return false;
		}
		switch($where['type']) {
			case 'int':
				$string = $where['table'].'.'.$where['key'].'='.$where['value'];
				break;
			case 'string':
				$string = $where['table'].'.'.$where['key'].'="'.$where['value'].'"';
				break;
			default:
				$string = $where['table'].'.'.$where['key'].'="'.$where['value'].'"';
				break;
		}
		return ' where '.$string;
	}
	
	/**
	 * $where = array(
	 * 		'name' => array(
	 * 			'类型type', '数据表名table', '表达式expression'
	 * 		 	# 类型有：time, date, string, int, like, prelike, sulike
	 * 			# 表达式 ： =   > <   <=  >= 
	 * 		)
	 * );
	 * 
	 * 示例：
	 * $where = array(
		'type' =>array(
			'filed' => 'filedname',
			'type' => 'int',
			'table' => 'hua',
			'expression' =>'='
		),
		'price_up' => array(
			'filed' => 'filedname',
			'type' => 'int',
			'table' => 'hua',
			'expression' =>'<'
		),
		'price_down' => array(
			'filed' => 'filedname',
			'type' => 'int',
			'table' => 'hua',
			'expression' =>'>'
		),
	);
	 */
	function where($where, $get_post, $page = 'page'){
		if (empty($where)) {
			return '';
		}
		if(isset($get_post[$page])) {
			unset($get_post[$page]);
		}
		if (empty($get_post)) {
			return '';
		}
		
		$constring = array();
		foreach ($get_post as $key =>$value){
			if (isset($where[$key]) && $value !='') {
				switch($where[$key]['type']) {
					case 'string':
						$value = "'".$value."'";
						break;
					case 'date':
						$value = "'".$value."'";
						break;
					case 'time':
						$value = "'".$value."'";
				}
				if ($where[$key]['expression'] == 'like'){
					$constring[]= $where[$key]['table'].'.'.$where[$key]['filed'].' like '.'"%'.$value.'%"';
				}elseif ($where[$key]['expression'] == 'prelike'){
					$constring[]= $where[$key]['table'].'.'.$where[$key]['filed'].' like '. '"'.$value.'%"';
				}elseif($where[$key]['expression'] == 'sulike') {
					$constring[]= $where[$key]['table'].'.'.$where[$key]['filed'].' like '.'"%'.$value.'"';
				} else 
					$constring[]= $where[$key]['table'].'.'.$where[$key]['filed'].' '.$where[$key]['expression'].' '.$value;
			}
		}

		if (empty($constring)) {
			return '';
		}
		return " where ". implode(' and ', $constring);
	}
	
	public function makeOrder($orderData, $get)
	{
	
		foreach ($orderData as $key => $value)
		{
			if (isset($get[$key])){
				$orderData[$key]['orderby'] = $get[$key];
			}
		}
		return $orderData;
	}
	

    /**
     *
     * @param array $order
     * $order = array(
     * 		'name' => array('table' => '', 'orderby' => ''),		#order in asc ,desc
     * );
     */
    function order ($order) {
        $temp = array();

        if (empty($order)) {
            return '';
        }

        foreach ($order as $key=> $value) {
            if (isset($value['table']))
                $temp[] = $value['table'].'.'.$key.' '.$value['orderby'];
            else
                $temp[] = $key.' '.$value['orderby'];
        }
        return ' order by '. implode(', ', $temp);
    }
	
	/**
	 * 生成分页信息
	 * @param array $limit
	 */
	public function limit($limit, $sum) {
		if (!isset($limit['page']) || $limit['page'] == '') {
			$page = 1;
		} else {
			$page = $limit['page']; //当前页数
		}
		if (!isset($limit['num']) || $limit['num'] == '') {
			$num = 10;
		} else {
			$num  = $limit['num'];	//每页显示条数
		}

		$bigest_page = ceil($sum / $num);
		if ($page > $bigest_page) {
			$page = $bigest_page;	#页数不能超过最大的页数
            return 'toobig';
		}

		$start = ($page-1) * $num;
        $data = array(
            'page' => $bigest_page,
            'string' => ' limit '.$start.','.$num
        );
		return $data;
	}
	
	/**
	 * 
	 * 单表插入数据
	 * 
	 * @param 表名 $table
	 * @param 数据 $data
	 * @return 成功返回插入的ID，不成功发挥false
	 */
	protected function add($table, $data) {
		$this->db->insert($table, $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

    /**
     * 单表批量插入数据
     * @param $table
     * @param $data
     * @return mixed
     */
    protected function bulk($table, $data){
        $filed = array();
        foreach ($data[0] as $k => $v)
        {
            $filed[] = $k;
        }
        $content = array();
        foreach ($data as $key => $value)
        {
            $item = array();
            foreach ($value as $k => $v)
            {
                $item[] = "'".$v."'";
            }
            $string = '('.implode(',', $item).')';
            $content[] = $string;
        }
        $filedstring = implode(',', $filed);
        $contentstring = implode(',', $content);
        $sql = "insert into ".$this->db->dbprefix.$table."($filedstring) values $contentstring;";
        $res = $this->db->query($sql);
        return $res;
    }
	
	/**
	 * 
	 * 单表真正删除数据
	 * 
	 * @param ID $id
	 * @param string $table 表名
	 * @return boolean
	 */
	protected function delete($table, $id) {
		$this->db->where('id', $id);
		$this->db->delete($table);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else
			return false;
	}
	
	/**
	 * 单表更新数据
	 * 
	 * @param string $table 表名
	 * @param array $data   更新的数据
	 * @param int $id		更新条目的ID
	 * @return boolean
	 */
	protected function update($table, $data, $id) {
		$this->db->where('id', $id);
		$this->db->update($table, $data);
	
		if ($this->db->affected_rows() > 0) {
			return true;
		} else
			return false;
	}
	
	/*
	 * 多表条件下的增加修改
	 */
	protected function  multi_add($table, $data) {
		$this->db->insert($table, $data);
	}
	
	protected function multi_update($table, $data, $id) {
		$this->db->where('id', $id);
		$this->db->update($table, $data);
	}
	
	protected function multi_start() {
		$this->db->trans_start();
	}
	
	protected function multi_end() {
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

}

class Temp_model extends MY_Model
{
    #表名
    var $table;
    #表的别名
    var $alias;
    #关联表
    var $link = array(
       /* 'test_cate' => array(
            'alias' => 'cate',
            'relation_id' => 'id',
            'foreign_key' => 'cateid',
        ),
        'test_user' => array(
            'alias' => 'users',
            'relation_id' => 'id',
            'foreign_key' => 'authorid',
        ),*/
    );

    #设置唯一查询的列
    var $itemKey = array(
       /* 'id' => array(
            'filed' => 'id'
        ),
        'content' => array(
            'filed' => 'content'
        ),*/
    );

    var $column = array(
       /* 'id' => array(
            'filed' => 'id'
        ),
        'name' => array(
            'filed' => 'name'
        ),
        'cateid' => array(
            'filed' => 'cateid'
        ),
        'content' => array(
            'filed' => 'content'
        ),
        'cover' => array(
            'filed' => 'cover'
        ),
        'status' => array(
            'filed' => 'status'
        ),
        'authorid' => array(
            'filed' => 'authorid'
        ),
        'addtime' => array(
            'filed' => 'addtime'
        ),
        'catename' => array(
            'filed' => 'catename',
            'table' => 'cate'
        ),
        'authorname' => array(
            'filed' => 'realname',
            'table' => 'users'
        )*/
    );

    #查询过滤
    var $where = array(
        /*'cateid' => array(  #分类筛选
            'table' => 'cate',
            'filed' => 'id',
            'expression' => '='
        ),
        'name' => array(
            'table' => '',
            'filed' => 'name',
            'expression' => 'like'
        ),
        'status' => array(
            'filed' => 'status',
            'expression' => '='
        ),
        'starttime' => array(
            'filed' => 'addtime',
            'type' => 'date',
            'expression' => '>='
        ),
        'endtime' => array(
            'filed' => 'addtime',
            'type' => 'date',
            'expression' => '<='
        ),*/
    );

    var $order = array(
       /* 'id' => array(
            'table' => '',
            'filed' => 'id',
            'orderby' => 'desc'
        ),*/
    );

    var $limit = array(
       'page' => 1,
        'num'  => 10
    );

    /**
     * 设置关联数据
     * @param $data
     */
    public function setLink($data)
    {
        $this->link = $data;
    }

    /**
     * 设置获取获取列
     * @param $data
     */
    public function setColumn($data)
    {
        $this->column = $data;
    }

    function column($all = '*')
    {
        $column = array();
        $defaultTable = $this->alias == '' ? $this->db->dbprefix($this->table):$this->alias;
        if ($all == '*')
            $column[]= $defaultTable.'.*';
        foreach ($this->column as $key => $value) {
            if ($all == '*') {
                if (isset($value['table']) && $value['table'] != '' && $value['table'] != $defaultTable) {
                    $column[] = $value['table'] . '.' . $value['filed'] . ' ' . $key;
                }
            } else {
                if (isset($value['table']) && $value['table'] != '' && $value['table'] != $defaultTable) {
                    $column[] = $value['table'] . '.' . $value['filed'] . ' ' . $key;
                } else {
                    $column[] = $defaultTable . '.' . $value['filed'] . ' ' . $key;
                }
            }
        }
        return implode(',', $column);
    }

    function where($where, $input, $page = 'page')
    {
        if (empty($where)) {
            return '';
        }

        if (empty($input)) {
            return '';
        }

        $constring = array();
        $defaultTable = $this->alias == '' ? $this->db->dbprefix($this->table):$this->alias;
        foreach ($input as $key =>$value){
            if (isset($where[$key]['type']) && $where[$key]['type'] == 'date') {
                $value = strtotime($value);
            }
            if (isset($where[$key]) && $value !='') {
                if (isset($where[$key]['type']) && $where[$key]['type'] == 'int'){
                    $value = "".$value."";
                } elseif ($where[$key]['expression'] =='like' || $where[$key]['expression'] =='prelike' || $where[$key]['expression'] =='sulike') {
                    $value = "".$value."";
                } else {
                    $value = "'".$value."'";
                }
                $table = isset($where[$key]['table']) && $where[$key]['table'] !='' ? $where[$key]['table'] : $defaultTable;

                if ($where[$key]['expression'] == 'like'){
                    $constring[]= $table.'.'.$where[$key]['filed'].' like '.'"%'.$value.'%"';
                }elseif ($where[$key]['expression'] == 'prelike'){
                    $constring[]= $table.'.'.$where[$key]['filed'].' like '. '"'.$value.'%"';
                }elseif($where[$key]['expression'] == 'sulike') {
                    $constring[]= $table.'.'.$where[$key]['filed'].' like '.'"%'.$value.'"';
                } else
                    $constring[]= $table.'.'.$where[$key]['filed'].' '.$where[$key]['expression'].' '.$value;
            }
        }

        if (empty($constring)) {
            return '';
        } else {
            return $constring;
        }

    }

    function changeOrder($orderArray)
    {
        $tabelName = $this->alias == '' ? $this->db->dbprefix($this->table):$this->alias;
        foreach ($orderArray as $key=> $value) {
            if (isset($value['table']) && $value['table'] !='')
                $temp[] = $value['table'].'.'.$value['filed'].' '.$value['orderby'];
            else
                $temp[] = $tabelName.'.'.$value['filed'].' '.$value['orderby'];
        }
        return $temp;
    }

    function order ($input)
    {
        $temp = array();
        if (empty($this->order)) {
            return '';
        }

        if (isset($input['order']) && array_key_exists($input['order'], $this->order)) {
            $orderArray = array($this->order[$input['order']]);
            $temp = $this->changeOrder($orderArray);
        } elseif(isset($this->order['default'])) {
            $orderArray = array($this->order['default']);
            $temp = $this->changeOrder($orderArray);
        } else {
            $temp = array();
        }

        if (empty($temp))
            return '';
        return ' order by '. implode(', ', $temp);
    }

    public function linkSql($input = '')
    {
        $sql = "";
        $linkArray = array();
        $linkArray[] = $this->db->dbprefix($this->table).' '. $this->alias;

        $tabelName = $this->alias == '' ? $this->db->dbprefix($this->table):$this->alias;

        $whereArray = array();
        foreach ($this->link as $key => $value)
        {
            $linkArray[] = $this->db->dbprefix($key).' '.$value['alias'];
            $linkTable = isset($value['alias']) && $value['alias'] != '' ? $value['alias']:$this->db->dbprefix($key);
            $whereArray[] = $tabelName.'.'.$value['foreign_key'].'='.$linkTable.'.'.$value['relation_id'];
        }
        if (is_array($input)) {
            $where = $this->where($this->where, $input);
            if ($where !='')
                $whereArray = array_merge($whereArray, $where);
            if (count($whereArray) == 0)
                $sql =  $sql . implode(', ', $linkArray);
            else
                $sql = $sql . implode(', ', $linkArray).' where '. implode(' and ', $whereArray);
        } else {
            $whereArray[] = $input;
            if (count($whereArray) == 0)
                $sql =  $sql . implode(', ', $linkArray);
            else
                $sql = $sql . implode(', ', $linkArray).' where '. implode(' and ', $whereArray);
        }

        return $sql;
    }

    public function leftSql($input = '')
    {
        $sql = "";
        $sql .= $this->db->dbprefix($this->table).' '. $this->alias;
        $tabelName = $this->alias == '' ? $this->db->dbprefix($this->table):$this->alias;

        foreach ($this->link as $key => $value)
        {
            $sql  .= ' left join '. $this->db->dbprefix($key).' '.$value['alias'];
            $linkTable = isset($value['alias']) && $value['alias'] != '' ? $value['alias']:$this->db->dbprefix($key);
            $sql  .= " on ".$tabelName.'.'.$value['foreign_key'].'='.$linkTable.'.'.$value['relation_id'];
        }

        if (is_array($input)) {
            $where = $this->where($this->where, $input);
            $sql .= ' where '. implode(' and ', $where);
        } else {
            $sql = $sql .' where '. $input;
        }

        return $sql;
    }

    public function lists($input = null)    #input 表示筛选数据  常用  like 模糊查询   = 　> <  limit
    {
        if ($input != '') {
            $where = " where ";
        }

        /*  $sql = "select * from "
             . $this->db->dbprefix('test_item');   #获取数据表中所有数据

       $sql = "select item.*, cate.catename from "
             . $this->db->dbprefix('test_item'). ' item, '
             . $this->db->dbprefix('test_cate'). ' cate '
             . " where item.cateid = cate.id ";     #获取两个关联表的所有数据，结果相当于join

        $sql = "select item.*, cate.catename from "
             . $this->db->dbprefix('test_item'). ' as item '
             . ' left join '
             . $this->db->dbprefix('test_cate'). ' as cate '
             . ' on item.cateid= cate.id';         #使用左连接操作,   如果cate表中无相应的分类id数据，也同样可以查出数据，假设删除了分类，分类

         $sql = "select item.*, cate.catename from "
             . $this->db->dbprefix('test_item'). ' as item '
             . ' join '
             . $this->db->dbprefix('test_cate'). ' as cate '
             . ' on item.cateid= cate.id';         #使用连接操作,   如果cate表中无相应的分类id数据，就查不出数据

         $sql = "select item.*, cate.catename from "
             . $this->db->dbprefix('test_item'). ' as item '
             . ' right join '
             . $this->db->dbprefix('test_cate'). ' as cate '
             . ' on item.cateid= cate.id';         #使用右连接操作,   如果cate表中无相应的分类id数据，就查不出数据*/
        $sql = $this->linkSql($input);
        #$sql = $this->leftSql($input);
        $tableName = $this->alias == '' ? $this->db->dbprefix($this->table):$this->alias;
        $numSql = " select count({$tableName}.id) as sum from ".$sql;

        $total = $this->getRow($numSql);

        if ($total['sum'] == '0') {
            $back = array(
                'status' => 'false',
                'code'   => '404',      #无数据
            );
            return $back;
        }
        $limitArray = array(
            'page' => isset($input['page']) && $input['page'] !='' ? intval($input['page']) : 1,
            'num'  => isset($input['pagenum']) && $input['pagenum'] != '' ? intval($input['pagenum']) : $this->limit['num'],
        );

        $limit = $this->limit($limitArray, $total['sum']);
        if ($limit == 'toobig') {
            $back = array(
                'status' => 'false',
                'code'   => '405',
                'info'   => '没有更多数据'
            );
        } else {
            $order = $this->order($input);
            $column = $this->column();
            $resSql = " select $column from " . $sql . ' ' . $order . ' ' . $limit['string'];

            $result = $this->getResult($resSql);
            /**********************数据处理***********************/
            if ($result !== false) {
                $back = array(
                    'status' => 'true',
                    'code'   => '0',
                    'data'   => $result,            #单页记录数据
                    'total'  => $total['sum'],      #记录总数
                    'page'   => $limit['page']      #当前页数
                );
            } else {
                $back = array(
                    'status' => 'false',
                    'code'   => '404',      #无数据
                );

            }
        }
        return $back;
    }

    public function itemSql($input, $key)
    {
        $tableName = $this->alias == '' ? $this->db->dbprefix($this->table):$this->alias;
        if (array_key_exists($key, $this->itemKey)) {
            if (isset($this->itemKey[$key]['table']) && $this->itemKey[$key]['table'] !='')
                $where = $this->itemKey[$key]['table'].'.'.$this->itemKey[$key]['filed']."='{$input}'";
            else
                $where = $tableName.'.'.$this->itemKey[$key]['filed']."='{$input}'";
        } else {
            $where = $tableName.'.id'."='{$input}'";
        }
        return $where;
    }

    public function item($key = 'id', $value)
    {
        $column = $this->column();
        $input = $this->itemSql($value, $key);
        $tableSql = $this->linkSql($input);

        $sql = "select $column from "
            . $tableSql;
        #echo $sql;
        $result = $this->getRow($sql);
        if ($result !== false) {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'data'   => $result,            #单页记录数据
            );
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '404',      #无数据
            );

        }
        return $back;
    }

    public function itemAdd($data)
    {
        return $this->add($this->table, $data);
    }

    public function itemUpdate($data, $id)
    {
        return $this->update($this->table, $data, $id);
    }

    public function itemDelete($id)
    {
        return $this->delete($this->table, $id);
    }

}