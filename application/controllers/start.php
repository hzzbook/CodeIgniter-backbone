<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/12/25
 * 
 */
class start extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        $this->load->model('content/article_model','artmodel');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        /*if ($limit == '' && $offset == '') {
            $where = $this->input->get();
            $res = $this->artmodel->tablelists($where, 'all');
        } else {
            $where = array(
                'page' => $offset / $limit + 1,
                'pagenum' => $limit,
                'orderby' => 'id:asc'
            );
            $where = array_merge($where, $this->input->get());
            $res = $this->artmodel->tablelists($where);
        }*/
        if ($offset == '') {
            $offset = 1;
        }
        if ($limit == '') {
            $limit = 10;
        }
        $where = array(
            'page' => floor($offset / $limit) + 1,
            'pagenum' => $limit,
           // 'orderby' => 'id:desc'
        );
        $where = array_merge($where, $this->input->get());
        echo "<pre>";
        $res = $this->artmodel->tablelists($where);
        echo "<pre>";
        var_dump($res);
    }

    public function index2()
    {
        echo "goood";
    }

    #读取配置信息方法
    public function config_item()
    {
        #$this->config->load('thirdpart');
        //$Weibologin_config = $this->config->item('Weibologin_config');
        include_once (APPPATH.'config/thirdpart.php');
        var_dump($Weibologin_config);
    }

    /**
     * 查询过滤
     * @param string $page
     * @param int $num
     * @param array rdata   用于传递通过路由方式获取的额外数据
     * @return array
     */
    public function input_list_filter($page = 'page', $num = 10, $model_where, $rdata = null)
    {
        $input = $this->input->all();
        if ($rdata != NULL)
            $input = array_merge($input, $rdata);
        $filter = array();
        if (!isset($input[$page]) || intval($input[$page]) == 0)
            $filter['page'] = 1;
        else {
            $filter['page'] = intval($input[$page]);
        }
        $filter['pagenum'] = $num;

        if ($model_where !='' && !empty($model_where)) {
            foreach ($model_where as $key) {
                if (isset($input[$key]))
                    $filter[$key] = $input[$key];
            }
        }

        return $filter;
    }

    public function input_item_filter($key, $model_where,  $rdata = null)
    {
        $input = $this->input->all();
        if ($rdata != NULL)
            $input = array_merge($input, $rdata);
        $filter = '';
        if ($model_where !='' && !empty($model_where)) {
            if (isset($input[$key]))
                $filter = $input[$key];
        }
        return $filter;
    }

    public function output_filter()
    {

    }

    #生成分页
    public function pagestring($page = 'page',$total, $filter)
    {
        $this->load->library('Pageclass');
        $get = $this->input->get();
        if (isset($get[$page]) && $get[$page] != '')
            unset($get[$page]);
        if ($get != false && count($get) >= 1)
            $getstring = http_build_query($get).'&';
        else
            $getstring = '';

        $Pageclass = new Pageclass('?'.$getstring, $total, $filter['page'], $filter['pagenum']);
        $pagestring = $Pageclass->show();
        return $pagestring;
    }

    public function index()
    {
        #Input
        $rdata = array();
        $pricetype = $this->input->get('price');
        if ($pricetype != '') {
            switch ($pricetype) {
                case 'type1':
                    $rdata = array(
                        'price1' => 100,
                        'price2' => 400,
                    );
                    break;
                case 'type2':
                    $rdata = array(
                        'price1' => 401,
                        'price2' => 800,
                    );
                    break;
                case 'type3':
                    $rdata = array(
                        'price1' => 801,
                        'price2' => 2500,
                    );
                    break;
                case 'type4':
                    $rdata = array(
                        'price1' => 2500
                    );
                    break;
            }
        }

        $model_where = array(
            'brand', #查询品牌
            'price1', #查询大于价格
            'price2', #查询小于价格
        );
        $filter = $this->input_list_filter('page', 1, $model_where, $rdata);

        #Data
        $this->load->model('test/product_model', 'pro_model');
        $pro_lists = $this->pro_model->lists($filter);

        #Output
        if (isset($pro_lists['data'])) {
            $pro_list = $pro_lists['data'];
            foreach ($pro_list as $key => $value) {
                $pro_list[$key]['logtime'] = date('Y年m月d日', strtotime($value['logtime']));
            }
            $pro_lists['data'] = $pro_list;
            $pagestring = $this->pagestring('page', $pro_lists['total'], $filter);
        } else {
            $pagestring = '';
        }

        #view
        $view_data = array(
            'pro_lists' => $pro_lists,
            'pagestring' => $pagestring
        );
        $this->load->view("start/index", $view_data);
    }

    public function pro_lists()
    {
        #Input
        $model_where = array(
            'brand', #查询品牌
            'price1', #查询大于价格
            'price2', #查询小于价格
            'order', #排序[price_desc， price_asc, default]
        );
        $filter = $this->input_list_filter('page', 10, $model_where);

        #Data
        $this->load->model('test/product_model', 'pro_model');
        $pro_lists = $this->pro_model->lists($filter);

        #Output
        if (isset($pro_lists['data'])) {
            $pro_list = $pro_lists['data'];
            foreach ($pro_list as $key => $value) {
                $pro_list[$key]['logtime'] = date('Y年m月d日', strtotime($value['logtime']));
            }
            $pro_lists['data'] = $pro_list;
        }
        echo json_encode($pro_lists);
    }

    public function pro_lists_next()
    {

    }

    #单页
    public function single()
    {
        $rdata = array(
            'id' => 1
        );

        $model_where = array(
            'id', #根据ID查询单一数据
        );
        $filter = $this->input_item_filter('id', $model_where, $rdata);

        #Data
        $this->load->model('test/product_model', 'pro_model');
        $pro_item = $this->pro_model->item('id', $filter);
        if ($pro_item['status'] != "false") {
            #Output
            $pro_item['data']['logtime'] = date('Y年m月d日', strtotime($pro_item['data']['logtime']));
        } else {
            show_404();
        }

        $view_data = array(
            'pro_item' => $pro_item
        );
        $this->load->view('start/single', $view_data);
    }

    public function pro_item()
    {
        #Input
        $model_where = array(
            'id', #根据ID查询单一数据
        );
        $filter = $this->input_item_filter('id', $model_where);

        #Data
        $this->load->model('test/product_model', 'pro_model');
        $pro_item = $this->pro_model->item('id', $filter);
        if ($pro_item['status'] != "false") {
            #Output
            $pro_item['data']['logtime'] = date('Y年m月d日', strtotime($pro_item['data']['logtime']));
        }
        echo json_encode($pro_item);
    }


    /************************管理后台*********************/
    public function display($view, $data)
    {
        $this->load->view('backbone/common/header', $data);
        $this->load->view($view, $data);
    }

    public function templates()
    {
        $input = $this->input->post();
        if (!isset($input['status']) || $input['status'] == ''){
            $input['status'] = 1;
        }
        $this->load->model('content/friendly_model', 'friendly_model');
        $data = $this->friendly_model->lists($input);
        echo urldecode(json_encode($data));
    }

    public function template()
    {
        $input = $this->input->post();
        $this->load->model('content/friendly_model', 'friendly_model');
        $data = $this->friendly_model->item('id', $input['id']);
        echo urldecode(json_encode($data));
    }

    public function templatesPage()
    {
        $data = array();
        $this->display('start/admin/templatesPage', $data);
    }

    public function templateAddPage()
    {
        $this->load->library('formtoken');
        $token = $this->formtoken->create('template');

        $data = array(
            'token'     => $token
        );
        $this->display('start/admin/templateAddPage', $data);
    }

    public function addShow($filed)
    {
        $string = '';
        foreach ($filed as $key => $value) {
            switch($value['type']) {
                case 'text':
                    break;
                case 'longtext':
                    break;
                case 'image':
                    break;
                case 'image_group':
                    break;
                case 'select':
                    break;
                case 'single':
                    break;
                case 'multi':
                    break;
                case 'fulltext':
                    break;
            }
        }
    }

    public function templateAddPage2()
    {
        $this->load->library('formtoken');
        $token = $this->formtoken->create('template');

        $filed = array(
            'name' => array(
                'type' => 'text',
                'title' => "标题",
            ),
            'cover' => array(
                'type' => 'image',
                'title' => "标题",
            ),
            'country' => array(
                'type' => 'select',
                'title' => "标题",
                'data' => array(
                    array(
                        'val' => 's1',
                        'label' => '单选1'
                    ),
                    array(
                        'val' => 's2',
                        'label' => '单选2'
                    ),
                    array(
                        'val' => 's3',
                        'label' => '单选3'
                    ),
                )
            ),
            'single' => array(
                'type' => 'single',
                'title' => "标题",
                'data' => array(
                    array(
                        'val' => 's1',
                        'label' => '单选1'
                    ),
                    array(
                        'val' => 's2',
                        'label' => '单选2'
                    ),
                    array(
                        'val' => 's3',
                        'label' => '单选3'
                    ),
                )
            ),
                'multi' => array(
                    'type' => 'multi',
                    'title' => "标题",
                    'data' => array(
                        array(
                            'val' => 'm1',
                            'label' => '多项1'
                        ),
                        array(
                            'val' => 'm2',
                            'label' => '多项2'
                        ),
                        array(
                            'val' => 'm3',
                            'label' => '多项3'
                        ),

                    ),
                ),
                'fulltext' => array(
                    'type' => 'fulltext',
                    'title' => "标题",
                )
        );

        $this->load->helper('form');
        $filed_string = filed_show($filed);

        $data = array(
            'filed_string' => $filed_string,
            'token'     => $token
        );
        $this->display('start/admin/templateAddPage2', $data);
    }

    public function templateAdd()
    {
        $input = $this->input->post();

        $this->load->library('formtoken');
        $token =  $this->formtoken->check('template', $input['token']);
        if ($token['status'] == 'false')
        {
            $back = array(
                'status' => 'false',
                'code'   => '868',
                'info'   => urlencode('表单token失效'),
                'token'  => $token['token']
            );
            echo urldecode(json_encode($back)); exit;
        }
        unset($input['token']);

        $checkForm = array(

        );
        if ($this->formtoken->blank($checkForm, $input) == false)
        {
            $back = array(
                'status' => 'false',
                'code'   => '869',
                'info'   => urldecode('确认必填项填写完毕')
            );
            echo urldecode(json_encode($back)); exit;
        }
        $this->load->model('content/friendly_model', 'friendly_model');
        $res = $this->friendly_model->itemAdd($input);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('添加成功'),
                'id'     => $res
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('添加失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    public function templateUpldatePage()
    {
        $id = $this->input->get('id');

        $this->load->library('formtoken');
        $token = $this->formtoken->create('templateUpldate');
        $data = array(
            'token'     => $token,
            'id'        => $id
        );
        $this->display('start/admin/templateUpldatePage', $data);
    }

    public function templateUpdate()
    {
        $input = $this->input->post();
        $this->load->library('formtoken');
        $token =  $this->formtoken->check('templateUpldate', $input['token']);
        if ($token === true)
        {
            $back = array(
                'status' => 'false',
                'code'   => '868',
                'info'   => urlencode('表单token失效'),
                'token'  => $token
            );
            echo urldecode(json_encode($back)); exit;
        }
        unset($input['token']);

        $checkForm = array(

        );
        if ($this->formtoken->blank($checkForm, $input) == false)
        {
            $back = array(
                'status' => 'false',
                'code'   => '869',
                'info'   => urldecode('确认必填项填写完毕')
            );
            echo urldecode(json_encode($back)); exit;
        }
        $this->load->model('content/friendly_model', 'friendly_model');

        $res = $this->friendly_model->itemUpdate($input, $input['id']);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('修改成功'),
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('添加失败')
            );
            echo urldecode(json_encode($back));
        }
    }

    public function templateDelete()
    {
        $input = $this->input->post();
        $this->load->model('content/friendly_model', 'friendly_model');
        $res = $this->friendly_model->itemDelete($input['id']);
        if ($res == true)
        {
            $back = array(
                'status' => 'true',
                'code'   => '0',
                'info'   => urldecode('删除成功'),
                'id'     => $res
            );
            echo urldecode(json_encode($back));
        } else {
            $back = array(
                'status' => 'false',
                'code'   => '500',
                'info'   => urldecode('删除失败')
            );
            echo urldecode(json_encode($back));
        }
    }




}