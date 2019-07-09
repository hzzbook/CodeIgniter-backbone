<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2018/1/2
 * 
 */
class frontend extends frontbase
{

    public function index()
    {
        $this->load->helper('data');
        $this->load->model('content/article_model', 'article_model');

        #幸福生活
        $typeData = array(      #取5条cateid=2的文章数据
            'cate' => '2',
            'pagenum' => 2,
        );
        $cateid2 = $this->article_model->lists($typeData);
        if ($cateid2['code'] == '404') {
            $cateid2['data'] = '';
        }
        #幸福生活
        $typeData1 = array(      #取5条cateid=2的文章数据
            'cate' => '1',
            'pagenum' => 2,
        );
        $cateid1 = $this->article_model->lists($typeData1);


        $banner_filter = array(

        );
        $this->load->model('content/banner_model', 'banner_model');
        $banner = $this->banner_model->lists($banner_filter);

        $friendly_filter = array();
        $this->load->model('content/friendly_model', 'friendly_model');
        $friendly = $this->friendly_model->lists($friendly_filter);

        $view_data = array(
            'cateid1_filter' => $typeData1,
            'cateid1' => $cateid1['data'],
            'cateid2_filter' => $typeData,
            'cateid2' => $cateid2['data'],
            'banner_filter' => $banner_filter,
            'banner' => $banner,
            'friendly_filter' => $friendly_filter,
            'friendly' => $friendly,
        );

        $this->display('pcweb/index', $view_data);
    }


}