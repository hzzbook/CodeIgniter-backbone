<link rel="stylesheet" href="/adminasset/css/user_return.css">
<script src="/adminasset/js/laydate/laydate.js"></script>
<div class="mainWrap">
    <h4 class="cont_title"><span>页面SEO优化列表</span></h4>

    <div class="return_box">
        <div class="search_box">
            <div class="text_inputs">
                <button id="badidubtn" class="button">提交百度</button>
            </div>
        </div>

        <div class="table_box table-responsive tables" id="datatable">
        </div>
        <div id="pagediv" style="text-align:center;margin: 10px auto"></div>
    </div>
</div>
</div>
<script src="/adminasset/vendor/laypage/laypage.js"></script>
<script src="/adminasset/vendor/laytpl.js"></script>
<script src="/adminasset/js/layer/layer.js"></script>
<script id="demo" type="text/html">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <td>标题</td>
            <td>关键字</td>
            <td >描述</td>
            <td width="100">操作</td>
        </tr>
        </thead>
        <tbody>
        {{# for(var i = 0, len = d.data.length; i < len; i++){ }}
        <tr>
            <td>{{ d.data[i].title }}</td>
            <td>{{ d.data[i].keyword }}</td>
            <td>{{ d.data[i].description }}</td>
            <td>
                <a class="button" href="/b_cms_seoedit.html?id={{d.data[i].id}}">编辑</a>
            </td>
        </tr>
        {{# } }}
        </tbody>
    </table>
</script>
<script>
    function demo(curr){
        $.post('/hzzadmin/cms/seos', {
            page: curr || 1, //向服务端传的参数，此处只是演示
            cate: $('#cate').val()
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
    $('#badidubtn').bind('click', function(){
        $.post('/hzzadmin/cms/updateBaidu', {
        }, function(res){
                layer.msg('提交成功');
        }, 'json');
    })
</script>
