<?php
/**
 * 数据入口
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/8/30
 * 
 */

class inflow extends MY_Controller
{
    public function index()
    {
        $data = array();
        $this->load->view('inflow/index', $data);
    }

    public function createFile()
    {
        $Controller = $this->input->post('controller');
        $Function = $this->input->post('function');
        $Table = $this->input->post('table');
        $name = $this->input->post('name');

        if ($Controller == '')
            redirect('/inflow/index');

        /*$array = array(
            'pages' => $Function.'sPage',
            'addpage' => $Function.'AddPage',
            'updatepage' => $Function.'UpdatePage',
        );
        $path = APPPATH.'/views/backbone';
        foreach ($array as $key => $value) {
            file_put_contents($path.'/'.$Controller.'/'.$value.'.php', '<?php ');
        }*/

        $ControllerPath = APPPATH.'controllers/hzzadmin/';
        $controllerFile = $ControllerPath.$Controller.'.php';
        $templatePath = APPPATH.'codetmp/';
        if (file_exists($controllerFile)) {

        } else {
            $contents = file_get_contents($templatePath.'controller_tmp.php');
            $new = str_replace('__Controller__', $Controller, $contents);
            file_put_contents($controllerFile, $new);
        }
        $this->writeController($Controller, $Function, $name);
        $this->writeModel($Controller,$Function, $Table);
        $this->writeView($Controller, $Function, $name);
        redirect('/mill/inflow/index');
    }

    public function writeController($controller, $function, $name)
    {
        $templatePath = APPPATH.'codetmp/';
        $contents = file_get_contents($templatePath.'tmp_controller.php');
        $pattern = '/'.$function.'sPage/';
        if (preg_match($pattern, $contents)) {
            echo "方法名冲突";
        } else {
            $before = array(
                '__Controller__',
                'Template',
                '__name__'
            );
            $after = array(
                $controller,
                $function,
                $name
            );
            $newContents = str_replace($before, $after, $contents);

            $ControllerPath = APPPATH.'controllers/hzzadmin/';
            $controllerFile = $ControllerPath.$controller.'.php';
            $controllerContents = file_get_contents($controllerFile);

            $footer = '#-------------footer----------------#';
            $newController = str_replace($footer, $newContents, $controllerContents);
            file_put_contents($controllerFile, $newController);
        }
    }

    public function writeModel($controller, $function, $table)
    {
        $modelPath = APPPATH.'models/';
        $modelFile = $modelPath.$controller.'/'.$function.'_model.php';
        if (!file_exists($modelPath.'/'.$controller)) {
            mkdir($modelPath.'/'.$controller);
        }
        if (!file_exists($modelFile)){
            $templatePath = APPPATH.'codetmp/';
            $contents = file_get_contents($templatePath.'model_tmp.php');
            $before = array(
                '__Function__', '__Table__'
            );
            $after = array(
                $function.'_model', $table
            );
            $newContents = str_replace($before, $after, $contents);
            file_put_contents($modelFile, $newContents);
        }
    }

    public function writeView($controller, $function, $name)
    {
        $templatePath = APPPATH.'codetmp/';
        $pages = file_get_contents($templatePath.'tmp_sPage.php');
        $addPage = file_get_contents($templatePath.'tmp_AddPage.php');
        $updatePage = file_get_contents($templatePath.'tmp_UpdatePage.php');

        $before = array(
            '__Controller__', '__Function__', '__name__'
        );
        $after = array(
            $controller, $function, $name
        );
        $pages = str_replace($before, $after, $pages);
        $addPage = str_replace($before, $after, $addPage);
        $updatePage = str_replace($before, $after, $updatePage);

        $path = APPPATH.'views/backbone';
        if (!file_exists($path.'/'.$controller)) {
            mkdir($path.'/'.$controller);
        }
        $pagesFile = $path.'/'.$controller.'/'.$function.'sPage.php';
        $addpageFile = $path.'/'.$controller.'/'.$function.'AddPage.php';
        $updatepageFile = $path.'/'.$controller.'/'.$function.'UpdatePage.php';

        if (!file_exists($pagesFile))
            file_put_contents($pagesFile, $pages);
        if (!file_exists($addpageFile))
            file_put_contents($addpageFile, $addPage);
        if (!file_exists($updatepageFile))
            file_put_contents($updatepageFile, $updatePage);
    }

    public function list_fields()
    {
        $table = "user";
        $result = $this->db->list_fields($table);
        var_dump($result);
    }


    /**
     *
     * type
     *      text  文本类型
     *      bigtext   长文本
     *      textarea    文本框
     *      richtext    富文本
     *      select      下拉
     *      upload_img  图片上传
     *      upload_img_group  多图片上传
     *      upload_file 附件上传
     *      upload_file_group 多附件上传
     *
     */
    public function makeForm()
    {

        $input = array(
            array(
                'fields' => 'username', #字段的名称
                'type'   => 'text',     #文本的类型
                'need'   => '1'         #是否是必要的
            ),
            array(
                'fields' => 'password',
                'type'   => 'text',
                'need'   => '1',
            ),
            array(
                'fields' => 'nickname',
                'type'   => 'text',
                'need'   => '1',
            ),
            array(
                'fields' => 'email',
                'type'   => 'text',
                'need'   => '0'
            ),
        );
    }



}