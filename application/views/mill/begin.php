<!DOCTYPE HTML>
<html>
<head>
    <title>代码方案</title>
    <link href="/asset/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1>列表</h1>
            <div><span>控制器</span>
            <pre>
                $input = $this->input->get();
                if (isset($input['page']) && $input['page'] != '')      #当前页码
                {
                    $page = intval($input['page']);
                } else {
                    $page = 1;
                }
                if ($id == '')
                    $id = 1;        #默认的分类
                $nums = 1;
                $cateInfo = $this->model->item($id);        #获取当前分类信息
                $data = array();
                $cate = $this->model->lists($data);         #获取所有分类的列表数据
                $data = array(
                    'cate' => $id,          #分类id
                    'num' => $nums,         #获取数据的条数
                    'page' => $page,        #当前页码
                );
                $res = $this->model->lists($data);           #获取当前分类的数据列表

                $this->load->library('Pageclass');
                $Pageclass = new Pageclass('?', $res['sum'], $page, $nums);
                $pagestring = $Pageclass->show();               #生成分页代码
                $data = array(
                    'nav_key' => 'product',             #导航标识
                    'info' => $cateInfo,                #分类信息
                    'list'  => $res,                    #列表数据
                    'cate'  => $cate,                   #分类列表
                    'pagestring' => $pagestring,        #分页代码
                );
                $this->display('pcweb/product/index', $data);
            </pre>
            </div>
            <div>
                <span>模型</span>
                <pre>
    var $table = 'cms_article';
    var $alias = 'article';
    #关联表
    var $link = array(
        'cms_category' => array(
             'alias' => 'cate',
             'relation_id' => 'id',
             'foreign_key' => 'cateid',
         )
    );

    var $column = array(
        'id' => array(
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
             'filed' => 'title',
             'table' => 'cate'
         )
    );

    #查询过滤
    var $where = array(
        'cate' => array(  #分类筛选
            'table' => 'cate',
            'filed' => 'id',
            'expression' => '='
        ),
        'title' => array(
            'table' => '',
            'filed' => 'title',
            'expression' => 'like'
        ),
        'status' => array(
            'filed' => 'status',
            'expression' => '='
        ),
        'start' => array(
            'filed' => 'logtime',
            'type' => 'time',
            'expression' => '>='
        ),
        'end' => array(
            'filed' => 'logtime',
            'type' => 'time',
            'expression' => '<='
        ),
    );
                </pre>
            </div>
        </div>

        <div class="col-lg-12">
            <h1>单条数据</h1>
            <div><span>控制器</span>
            <pre>

            </pre></div>
        </div>
    </div>
</div>

</body>
</html>