<link rel="stylesheet" href="/adminasset/css/user_return.css">
<script src="/adminasset/js/laydate/laydate.js"></script>
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
        format: 'YYYY-MM-DD',
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
        format: 'YYYY-MM-DD',
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
<script id="demo" type="text/html">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>用户名</td>
            <td>注册时间</td>
            <td>最近登录</td>
            <td>绑定状态</td>
            <td>手机号</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        {{# for(var i = 0, len = d.data.length; i < len; i++){ }}
        <tr>
            <td>{{ d.data[i].username }}</td>
            <td>{{ d.data[i].regtime }}</td>
            <td>{{ d.data[i].logtime }}</td>
            <td>{{ d.data[i].mobile }}</td>
            <td>{{ d.data[i].mobile }}</td>
            <td>
                <a class="button" href="/b_users_info.html?id={{ d.data[i].id }}">信息</a>
            </td>
        </tr>
        {{# } }}
        </tbody>
    </table>
</script>
<script>
    function demo(curr){
        $.post('/hzzadmin/users/userlist', {
            page: curr || 1, //向服务端传的参数，此处只是演示
            username: $('#username').val(),
            truename: $('#truename').val(),
            start: $('#start').val(),
            end: $('#end').val()
        }, function(res){
            var gettpl = document.getElementById('demo').innerHTML;
            console.log(res);
            if (res.status == 'true' && res.code != '400') {
                laytpl(gettpl).render(res, function (html) {
                    document.getElementById('datatable').innerHTML = html;
                });
            } else {
                $('#datatable').html('无相关数据');
            }
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
        }, 'json');
    };
    demo();
    $('#searchbtn').bind('click', function(){
        demo();
    })
</script>
