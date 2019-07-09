<link rel="stylesheet" href="/asset/adminasset/css/user_return.css">
<script src="/asset/adminasset/js/laydate/laydate.js"></script>
<div class="mainWrap">
    <h4 class="cont_title"><span>图片列表</span></h4>

    <div class="return_box">
        <div class="search_box">
            <div class="text_inputs">
                <a href="/b_cms_imageAddPage.html" class="button" style="background: #ffcc33">添加图片</a>
               <!-- <span>标题：</span>
                <input type="text" id="title" placeholder="标题">
                <span>真实姓名：</span>
                <input type="text" id="truename" placeholder="真实姓名">-->
            </div>
            <div class="laydate">
                <!--<span>申请时间：</span>
                <input id="start" class="laydate-icon">

                <span>结束时间：</span>
                <input id="end" class="laydate-icon">
                <button id="searchbtn" class="button">搜索</button>-->
            </div>
        </div>

        <div class="table_box table-responsive tables" id="datatable">
        </div>
        <div id="pagediv" style="text-align:center;margin: 10px auto"></div>
    </div>
</div>
</div>
<script>
   /* var start = {
        elem: '#start',
        format: 'YYYY/MM/DD hh:mm:ss',
        min: laydate.now(),
        max: '2099-06-16 23:59:59',
        istime: true,
        istoday: false,
        choose: function (datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end',
        format: 'YYYY/MM/DD hh:mm:ss',
        min: laydate.now(),
        max: '2099-06-16 23:59:59',
        istime: true,
        istoday: false,
        choose: function (datas) {
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);*/
</script>
<script src="/asset/adminasset/vendor/laypage/laypage.js"></script>
<script src="/asset/adminasset/vendor/laytpl.js"></script>
<script src="/asset/adminasset/js/layer/layer.js"></script>
<script id="demo" type="text/html">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <td>标题</td>
            <td>分类</td>
            <td>描述</td>
            <td>url</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        {{# for(var i = 0, len = d.data.length; i < len; i++){ }}
        <tr>
            <td>{{ d.data[i].title }}</td>
            <td>{{ d.data[i].sn }}</td>
            <td>{{ d.data[i].description }}</td>
            <td><img width="100" src="{{ d.data[i].url }}" /></td>
            <td>
                <a class="button" href="/b_cms_imageUpdatePage.html?id={{d.data[i].id}}">编辑</a>
                <!--<a class="button" href="/b_cms_imagesedit.html?id={{d.data[i].id}}">浏览</a>-->
                <a class="button deleteArticle" data="{{d.data[i].id}}" href="javascript:void(0)" >删除</a>
            </td>
        </tr>
        {{# } }}
        </tbody>
    </table>
</script>
<script>
    function demo(curr){
        $.post('/hzzadmin/cms/images', {
            page: curr || 1, //向服务端传的参数，此处只是演示
            title: $('#title').val()
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
    demo();
    $('#searchbtn').bind('click', function(){
        demo();
    })

    $(document).on("click", ".deleteArticle", function () {
        $id = $(this).attr('data');
        layer.msg('你确定删除？', {
            time: 0 //不自动关闭
            ,btn: ['确定删除', '取消']
            ,yes: function(index){
                $.post('/hzzadmin/cms/imageDelete', {
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
