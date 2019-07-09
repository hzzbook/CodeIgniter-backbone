<?php
/**
 * 
 * 说明：
 * 开发框架
 *
 * @Author: hzz
 * @Date: 2018/4/5
 * 
 */

class frame extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
            'slider_tag' => 'frame',
            'nav_tag' => 'index'
        );
        $this->display('backbone/frame/index', $data);
    }

    public function demo()
    {
        echo "good";
    }

    public function demos(){
        $this->load->model('content/article_model','artmodel');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        if ($limit == '' && $offset == '') {
            $where = $this->input->get();
            $res = $this->artmodel->tablelists($where, 'all');
        } else {
            $where = array(
                'page' => $offset / $limit + 1,
                'pagenum' => $limit,
                'orderby' => 'id:desc'
            );
            $where = array_merge($where, $this->input->get());
            $res = $this->artmodel->tablelists($where);
        }
        echo json_encode($res);
    }

    public function demoAddPage()
    {
        $data = array(
            'token' => '23433'
        );
        $this->load->view('backbone/frame/articleAddPage', $data);
    }

    public function demoEditPage()
    {
        $data = array(
            'token' => '23433',
            'id'    => $this->input->get('id')
        );
        $this->load->view('backbone/frame/articleUpdatePage', $data);
    }

}