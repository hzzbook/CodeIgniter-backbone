<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/9/25
 * 
 */
class index extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkEnvironment()
    {
        #判断PHP版本
        $phpversion = phpversion();
        echo $phpversion;
        #判断是否安装memcached
        if (function_exists('memcache_debug')) {
            echo "memcache安装正常";
        }
        #判断是否安装redis
        if (function_exists('')) {

        }

    }

    public function index()
    {
        $this->load->view('mill');
    }

    public function begin()
    {
        $this->load->view('mill/begin');
    }

    public function itemMore()
    {
        $id = $this->input->post('id');
        $id = 13;
        $this->load->model('content/article_model', 'art_model');
        $artItem = $this->art_model->nextArticle($id);
        var_dump($artItem);
    }

    public function listMore()
    {
        $id = $this->input->post('id');
        $id = 1;        #分类id
        $page = 4;      #页数
        $num = 10;      #每页显示条数
        $this->load->model('content/article_model', 'art_model');
        $artLists = $this->art_model->nextLists($id, $page, $num);
        echo "<pre>";
        var_dump($artLists);

    }

    public function preNext()
    {
        $this->load->model('content/article_model', 'art_model');
        $id = 1;
        $cid = 1;
        $pre = $this->art_model->preArticle($id, $cid);
        $next = $this->art_model->nextArticle($id, $cid);
        var_dump($pre, $next);
    }

    public function page()
    {
        $page = $this->input->get('page');
        if ($page == '')
            $page = 1;
        $res = array(
            'total' => 25
        );
        $num = 10;
        $this->load->library('Pageclass');
        $input = $this->input->get();
        if (isset($input['page']) && $input['page'] != '')
            unset($input['page']);
        $getstring = http_build_query($input);
        $Pageclass = new Pageclass('?'.$getstring.'&', $res['total'], $page, $num);
        $pagestring = $Pageclass->show();
        echo $pagestring;
    }

    public function lately($id = 1, $num = 10)
    {
        $id = '1';
        $this->load->model('content/article_model', 'art_model');
        $s = array(
            'cate' => $id,
            'pagenum' => $num
        );
        $res = $this->art_model->lists($s);
        var_dump($res);
    }

    public function hotly($id = 1, $num = 10)
    {
        $this->load->model('content/article_model', 'art_model');
        $s = array(
            'cate' => $id,
            'pagenum' => $num,
            'order'  => 'pv',
        );
        $res = $this->art_model->lists($s);
        var_dump($res);
    }

    public function products()
    {
        $this->load->model('test/product_model', 'pro_model');

        $input = $this->input->get();
        //if (isset($input['sort']) && $input['sort'] != '')
        $input['sort'] = 'least';

        $page = $this->input->get('page');
        if ($page == '')
            $page = 1;
        $num = 2;

        $input['pricetype'] = 2;
        if (isset($input['pricetype'])  && $input['pricetype'] != '') {
            $pricetype = array(
                '1' => array('di'=> 100, 'gao' => 400),
                '2' => array('di'=> 400, 'gao' => 800),
                '3' => array('di'=> 800, 'gao' => 1000),
            );
            $price = $pricetype[$input['pricetype']];
        } else
            $price = false;

        $s = array(
            'brand' => 'nike',
            'price1' => $price['di'],
            'price2' => $price['gao'],
            'page' => $page,
            'pagenum' => $num,
            'order' => $input['sort']
        );
        $res = $this->pro_model->lists($s);

        if ($res['status'] == 'false') {
            echo "没有更多了";exit;
        }
        $this->load->library('Pageclass');
        if (isset($input['page']) && $input['page'] != '')
            unset($input['page']);
        if ($input != false && count($input) >= 1)
            $getstring = http_build_query($input).'&';
        else
            $getstring = '';
        $Pageclass = new Pageclass('?'.$getstring, $res['total'], $page, $num);
        $pagestring = $Pageclass->show();
        $data = array(
            'pagestring' => $pagestring,
            'data' => $res['data'],
        );
        $this->load->view('mill/products', $data);
    }

    #取对应文章分类的对应条数
    public function teamCate()
    {
        $this->load->model('content/article_model', 'art_model');
        $cate = array(
            '1', '3', '4'       #文章分类数组
        );
        foreach ($cate as $key => $value) {
            $s = array(
                'cate' => $value,
                'pagenum' => 1,
            );
            $res = $this->art_model->lists($s);
            $data[$value] = $res['data'];
        }
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

}