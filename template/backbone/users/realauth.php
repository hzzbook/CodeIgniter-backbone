<link rel="stylesheet" href="/asset/adminasset/css/user_return.css">
<script src="/asset/adminasset/js/laydate/laydate.js"></script>
<div class="mainWrap">
    <h4 class="cont_title"><span>用户列表</span></h4>

    <div class="return_box">
        <div class="search_box">
            <div class="text_inputs">
                <span>用户名：</span>
                <input type="text" id="username" placeholder="用户名">
                <span>真实姓名：</span>
                <input type="text" id="truename" placeholder="真实姓名">
            </div>
            <div class="laydate">
                <span>申请时间：</span>
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
    laydate(end);
</script>
<script src="/asset/adminasset/vendor/laypage/laypage.js"></script>
<script src="/asset/adminasset/vendor/laytpl.js"></script>
<script id="demo" type="text/html">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>客户名</td>
            <td>客服名</td>
            <td>回访结果</td>
            <td>回访时间</td>
            <td>回访内容</td>
        </tr>
        </thead>
        <tbody>
        {{# for(var i = 0, len = d.list.length; i < len; i++){ }}
        <tr>
            <td>姓名：{{ d.list[i].name }}</td>
            <td>城市：{{ d.list[i].city }}</td>
            <td>城市：{{ d.list[i].city }}</td>
            <td>城市：{{ d.list[i].city }}</td>
            <td>城市：{{ d.list[i].city }}</td>
        </tr>
        {{# } }}
        </tbody>
    </table>
</script>
<script>
    function demo(curr){
        $.getJSON('/hzzadmin/cms/banners', {
            page: curr || 1, //向服务端传的参数，此处只是演示
            username: $('#username').val(),
            truename: $('#truename').val(),
            start: $('#start').val(),
            end: $('#end').val()
        }, function(res){
            var gettpl = document.getElementById('demo').innerHTML;
            laytpl(gettpl).render(res, function(html){
                document.getElementById('datatable').innerHTML = html;
            });
            //显示分页
            laypage({
                cont: 'pagediv', //容器。值支持id名、原生dom对象，jquery对象。【如该容器为】：<div id="page1"></div>
                pages: res.pages, //通过后台拿到的总页数
                curr: curr || 1, //当前页
                jump: function(obj, first){ //触发分页后的回调
                    if(!first){ //点击跳页触发函数自身，并传递当前页：obj.curr
                        demo(obj.curr);
                    }
                }
            });
        });
    };
    demo();
    $('#searchbtn').bind('click', function(){
        demo();
    })
</script>
