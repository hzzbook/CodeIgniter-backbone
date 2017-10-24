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
        $artItem = $this->art_model->nextArticleMore($id);
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
        var_dump($artLists);
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

}