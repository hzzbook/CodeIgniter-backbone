<link rel="stylesheet" href="/adminasset/css/user_return.css">
<script src="/adminasset/js/laydate/laydate.js"></script>
<div class="mainWrap">
    <h4 class="cont_title"><span>产品列表</span></h4>

    <div class="return_box">
        <div class="search_box">
            <div class="text_inputs">
                <a href="/b_product_add.html" class="button" style="background: #ffcc33">添加产品</a>
                <span>标题：</span>
                <input type="text" id="title" placeholder="产品标题">
                <span>分类：</span>
                <select name="cate" id="cate">
                    <option value="">未选择</option>
                </select>
                <span>状态：</span>
                <select name="status" id="status">
                    <option value="">未选择</option>
                    <option value="1">已发布</option>
                    <option value="0">删除</option>
                </select>
            </div>
            <div class="laydate">
                <span>发布时间：</span>
                <input id="start" class="laydate-icon">

                <span>结束时间：</span>
                <input id="end" class="laydate-icon">
                <button id="searchbtn" class="button">搜索</button>
            </div>
        </div>

        <div class="table_box table-responsive tables" id="datatable">
        </div>
        <div id="pagediv" style="text-align:center;margin: 10px auto"></div>
    </div>
</div>
</div>
<script>
    var start = {
        elem: '#start',
        format: 'YYYY/MM/DD',
        min: laydate.now(),
        max: '2099-06-16',
        istime: true,
        istoday: false,
        choose: function (datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end',
        format: 'YYYY/MM/DD',
        min: laydate.now(),
        max: '2099-06-16',
        istime: true,
        istoday: false,
        choose: function (datas) {
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);
</script>
<script src="/adminasset/vendor/laypage/laypage.js"></script>
<script src="/adminasset/vendor/laytpl.js"></script>
<script src="/adminasset/js/layer/layer.js"></script>
<script id="catelist" type="text/html">
        <option value=''>无分类</option>
        {{# for(var i = 0, len = d.data.length; i < len; i++){ }}
            <option value='{{d.data[i].id}}'>{{ d.data[i].title }}</option>
        {{# } }}
</script>
<script id="demo" type="text/html">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <td>标题</td>
            <td>分类</td>
            <td>描述</td>
            <td>发布时间</td>
            <td>状态</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        {{# for(var i = 0, len = d.data.length; i < len; i++){ }}
        <tr>
            <td>{{ d.data[i].name }}</td>
            <td>{{ d.data[i].catetitle }}</td>
            <td>{{ d.data[i].description }}</td>
            <td>{{ d.data[i].logtime }}</td>
            <td>{{ d.data[i].status }}</td>
            <td>
                <a class="button" href="/b_product_articleedit.html?id={{d.data[i].id}}">编辑</a>
                <a class="button" href="/b_product_articleedit.html?id={{d.data[i].id}}">浏览</a>
                <a class="button deleteArticle" data="{{d.data[i].id}}" href="javascript:void(0)" >删除</a>
            </td>
        </tr>
        {{# } }}
        </tbody>
    </table>
</script>
<script>
    function getcategory() {
        $.post('/hzzadmin/product/categorys', {
            },
            function (res) {
                var gettpl = document.getElementById('catelist').innerHTML;
                laytpl(gettpl).render(res, function (html) {
                    document.getElementById('cate').innerHTML = html;
                });
            }, 'json');
    }
    getcategory();
    function demo(curr){
        $.post('/hzzadmin/product/products', {
            page: curr || 1, //向服务端传的参数，此处只是演示
            title: $('#title').val(),
            cate: $('#cate').val(),
            status: $('#status').val(),
            start: $('#start').val(),
            end: $('#end').val()
        }, function(res){
            if (res.status !='false'){
                var gettpl = document.getElementById('demo').innerHTML;
                laytpl(gettpl).render(res, function(html){
                    document.getElementById('datatable').innerHTML = html;
                });
                //显示分页
                laypage({
                    cont: 'pagediv', //容器。值支持id名、原生dom对象，jquery对象。【如该容器为】：<div id="page1"></div>
                    pages: res.page, //通过后台拿到的总页数
                    curr: curr || 1, //当前页
                    jump: function(obj, first){ //触发分页后的回调
                        history.replaceState({page: curr}, '', '?page='+curr);
                        if(!first){ //点击跳页触发函数自身，并传递当前页：obj.curr
                            demo(obj.curr);
                        }
                    }
                });
            } else {
                html = '查询无数据';
                document.getElementById('datatable').innerHTML = html;
                document.getElementById('pagediv').innerHTML = '';
            }
        }, 'json');
    };
    $page = getParam('page');
    demo($page);

    $('#searchbtn').bind('click', function(){
        demo();
    })

    $(document).on("click", ".deleteArticle", function () {
        $id = $(this).attr('data');
        layer.msg('你确定删除该文章？', {
            time: 0 //不自动关闭
            ,btn: ['确定删除', '取消']
            ,yes: function(index){
                $.post('/hzzadmin/cms/deleteArticle', {
                    id: $id
                }, function(res){
                    if (res.status == 'true')
                    {
                        window.location.reload();
                    } else {
                        layer.msg('删除失败');
                    }
                }, 'json');
            }
        });
    });

</script>
