<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends frontbase
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('content/article_model', 'article_model');

        #幸福生活
        $typeData = array(      #取5条cateid=2的文章数据
            'cate' => '2',
            'num' => 5,
        );
        $cateid2 = $this->article_model->lists($typeData);
        #幸福生活
        $typeData1 = array(      #取5条cateid=2的文章数据
            'cate' => '1',
            'num' => 5,
        );
        $cateid1 = $this->article_model->lists($typeData1);

        $data = array(
            'cateid2' => $cateid2['data'],
            'cateid1' => $cateid1['data']
        );

        $this->display('pcweb/index', $data);
    }
	

	

}
