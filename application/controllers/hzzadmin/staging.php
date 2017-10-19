<?php
/**
 * 工作脚手架
 * 说明：
 * 自动化构建页面
 *
 * @Author: hzz
 * @Date: 2017/4/24
 * 
 */

class staging extends MY_Controller
{

    public function index()
    {
        $table = $this->getTable();
        $data = array(
            'table' => $table
        );
        $this->load->view('/backbone/staging/auto', $data);
    }

    function searchDir($path,&$data){
        if(is_dir($path)){
            $dp=dir($path);
            while($file=$dp->read()){
                if($file!='.'&& $file!='..'){
                    searchDir($path.'/'.$file,$data);
                }
            }
            $dp->close();
        }
        if(is_file($path)){
            $data[]=$path;
        }
    }

    public function filelist()
    {
        $controller = APPPATH.'/controllers';
        $data = array();
        $this->searchDir($controller, $data);
        print_r($data);
    }

    public function makefile()
    {
        $controllerfile = APPPATH.'/hzzadmin/testController.php';
        $modelfile = APPPATH.'/hzzadmin/testController.php';
        $outputContent = '';
        if (is_file($controllerfile)){
            //存在控制器文件,添加到末尾

        } else {
            file_put_contents($controllerfile, $outputContent);   #写Controller
        }
        if (is_file($modelfile)){
            //存在控制器文件,添加到末尾

        } else {
            file_put_contents($modelfile, $outputContent);  #写model
        }
        file_put_contents($modelfile, $outputContent);  #写列表数据页面
        file_put_contents($modelfile, $outputContent);  #写添加数据页面
        file_put_contents($modelfile, $outputContent);  #写编辑数据页面

    }

    //获取数据库的数据表
    public function getTable() {
        $tables = $this->db->list_tables();

        foreach ($tables as $key=>$value) {
            $tables[$key] = str_replace('al_', '', $value);
        }
        return $tables;
    }

    //获取表中的字段
    public function getField() {
        $table = $this->input->get_post('table');
        //$table = $this->db->dbprefix($table);
        $fields = $this->db->list_fields($table);
        echo json_encode($fields);
    }

    public function contact()
    {
        echo json_encode($this->getTable());
    }

    //单表生成
    public function autoDo() {
        $array = array(
            'table' => 'test',
            'tablealis' => 'test',
            'tablename' => 'alltype',
            'filename' => 'Hua',  #生成文件名
            'key'	=> 'Hua',
            'fields' => array(	#字段列表
                '*'
            ),
            'where' => "array(	#过滤条件
                'id' => array(
                    'type' 		=> 'int',
                    'table' 	=> 'alltype',
                    'expression' 	=> '='
                ),
            );"
        );

        $string = '';

        $pattern = array(
            '/__TableMethod__/',	#表方法名
            '/__TableName__/',		#表名
            '/__TableAlice__/',		#表别名
            '/__FieldList__/',		#字段列表
            '/__MultiTable__/',		#多表关联
            '/__Where__/',			#查询条件
        );

        $table = $array['table'];
        $tablename = $array['tablename'];
        $tablealis = $array['tablealis'];
        $fileds    = '*';
        $jointable = '""';
        $where     = $array['where'];

        $replace = array(
            $table,
            $tablename,
            $tablealis,
            $fileds,
            $jointable,
            $where,
        );
        $tempContent = file_get_contents(APPPATH.'codetmp/list_tmp.php');
        $appendContent = preg_replace($pattern, $replace, $tempContent);

        $modelName = 'auto_model';
        $MODLEPATH = APPPATH.'models/';
        $file = $MODLEPATH.$modelName.'.php';

        $replaceHead = array(
            '/#-------------header----------------#/'
        );
        $replaceFooter = array(
            '/#-------------footer----------------#/'
        );
        if (is_file($file)) {
            $fileContent = file_get_contents($file);
            $replaceBody = array(
                $replaceHead[0].$appendContent
            );
            $outputContent = preg_replace($pattern, $replaceBody, $fileContent);
        } else {
            $model_tmp = file_get_contents(APPPATH.'codetmp/model_tmp.php');
            $patternModel = array(
                '/__ModelFile__/'
            );
            $replaceModel = array(
                $modelName
            );
            $fileContent = preg_replace($patternModel, $replaceModel, $model_tmp);
            //$fileContent = $fileContent;
        }

        $replaceBody = array(
            "#-------------header----------------#
".$appendContent
        );
        $outputContent = preg_replace($replaceHead, $replaceBody, $fileContent);

        file_put_contents($file, $outputContent);

    }


}