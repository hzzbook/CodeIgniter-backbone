<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/3/1
 * 
 */

class cms extends frontbase
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cms_model', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => '内容中心'
        );
        $this->display('pcweb/cms/index', $data);
    }

    public function news()
    {
        $id = 1;
        $cateInfo = $this->model->category($id);    #获取分类的信息

        $data = array(
            'cate' => $id
        );
        $input = $this->input->get();
        if (is_array($input))
            $data = array_merge($data, $input);
        $res = $this->model->articles($data);
        if (isset($input['page']) && $input['page'] != '')
        {
            $page = intval($input['page']);
        } else {
            $page = 1;
        }

        $this->load->library('Pageclass');
        $Pageclass = new Pageclass('?', $res['sum'], $page);
        $pagestring = $Pageclass->show();
        $data = array(
            'info' => $cateInfo,
            'list'  => $res['data'],
            'pagestring' => $pagestring,
            'nav_key' => 'news'
        );
        $this->display('pcweb/cms/news', $data);
    }

    public function aboutus($key = null)
    {
        if ($key == '')
            $key = 'index';

        $id = 2;
        $content = $this->model->content($id);
        $data = array(
            'content' => $content['data'],
            'nav_key' => 'aboutus',
            'aboutus_key' => $key
        );
        $this->display('pcweb/cms/aboutus', $data);
    }

    public function contact()
    {
        $id =4;
        $content = $this->model->content($id);
        $data = array(
            'content' => $content['data'],
        );
        $this->display('pcweb/cms/contact', $data);
    }

    public function culture()
    {
        $id = 1;
        $content = $this->model->content($id);
        $data = array(
            'content' => $content['data'],
        );
        $this->display('pcweb/cms/culture', $data);
    }

    public function single($key) {
        $webinfo = $this->model->single($key);
        $data = array(
            'title' => $webinfo['title'],
            'keyword' => $webinfo['keyword'],
            'description' => $webinfo['description'],
            'data'   => $webinfo
        );
        $this->display('pcweb/cms/single', $data);
    }

    public function articlelist($type = null)
    {
        switch ($type)
        {
            case 'news':    #新闻中心
                $id = 1;
                $type = 'list';
                break;
            case 'aboutus':  #公司简介
                $id = '5';
                $type = 'article';
            case 'contact':
                $id = '5';
                $type = 'article';
            case 'culture':
                $id = '6';
                $type = 'article';
            default:
                $id = 1;
                $type = 'article';
                break;
        }
        if ($type='list') {

            $cateInfo = $this->model->category($id);    #获取分类的信息

            $data = array(
                'cate' => $id
            );
            $input = $this->input->get();
            if (is_array($input))
                $data = array_merge($data, $input);
            $res = $this->model->articles($data);
            if (isset($input['page']) && $input['page'] != '')
            {
                $page = intval($input['page']);
            } else {
                $page = 1;
            }

                $this->load->library('Pageclass');
                $Pageclass = new Pageclass('?', $res['sum'], $page);
                $pagestring = $Pageclass->show();
            $data = array(
                'info' => $cateInfo,
                'list'  => $res['data'],
                'pagestring' => $pagestring,
            );
            $this->display('pcweb/cms/list', $data);

        } else {
            $article = $this->model->article($id);
            $data = array(
                'article' => $article
            );
            $this->display('pcweb/cms/article', $data);
        }
    }

    /**
     * 文章列表内容
     *
     * 1.只需要分类ID，根据ID获取列表内容
     * 2.后台操作中需要根据，分类，发布时间，标题，作者等搜索内容然后编辑
     * 3.全文索引来查询含有内容字符的文章列表,【暂时不做考虑】
     *
     */
    public function articles()
    {
        $data = array(
            'cate' => '2',      #分类
        );
        $res  = $this->model->articles($data);    #第一种情况
        echo "<pre>",urldecode(json_encode(($res)));

        $data = array(
            'cate' => '1',
            'page' => '2',
            'start' => date('Y-m-d'),
        );
        $res = $this->model->articles($data); #第二种情况
        echo "<hr>",urldecode(json_encode(($res)));
    }

    public function article($id = NULL)
    {
        if ($id == '') {
            echo "错误";
            exit;
        }
        $res = $this->model->article($id);
        if ($res['status'] == false) {
            //文章不存在，推荐文章内容显示
            #$this->display('cms/article404');
        }else{
            $preres = $this->model->preArticle($id, $res['data']['cateid']);
            $nextres = $this->model->nextArticle($id, $res['data']['cateid']);
            $res['data']['pv'] ++;          #文章的浏览量增加
            $this->model->viewArticle($id, $res['data']['pv']);

            $data = array(
                'title'   => $res['data']['title'],
                'keyword'   => $res['data']['keyword'],
                'description' => $res['data']['description'],
                'article' => $res['data'],
                'pre'     => $preres,
                'nextres' => $nextres
            );
            $this->display('pcweb/cms/article', $data);
        }

    }


}