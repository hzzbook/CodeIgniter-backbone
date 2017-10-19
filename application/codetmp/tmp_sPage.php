<div class="mainWrap">
    <h4 class="cont_title"><span>__name__列表</span></h4>

    <div class="return_box">
    <div class="search_box">
        <div class="text_inputs">
            <a href="/b___Controller_____Function__AddPage.html" class="button" style="background: #ffcc33">添加__name__</a>
        </div>
    </div>
    <div class="table_box table-responsive tables" id="datatable">
    </div>
    <div id="pagediv" style="text-align:center;margin: 10px auto"></div>
    </div>
</div>

<script src="/adminasset/vendor/laypage/laypage.js"></script>
<script src="/adminasset/vendor/laytpl.js"></script>
<script id="demo" type="text/html">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <td>商品名</td>
            <td>分类</td>
            <td>描述</td>
            <td>所需积分</td>
            <td>图片</td>
            <td>状态</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        {{# for(var i = 0, len = d.data.length; i < len; i++){ }}
            <tr>
            <td>{{ d.data[i].name }}</td>
            <td>{{ d.data[i].type }}</td>
            <td>{{ d.data[i].descr }}</td>
            <td>{{ d.data[i].credit }}</td>
            <td>{{ d.data[i].cover }}</td>
            <td>{{ d.data[i].status }}</td>
            <td>
                <a class="button" href="/b___Controller_____Function__sPage.html?id={{d.data[i].id}}">编辑</a>
                <!--<a class="button" href="/b_auction_banneredit.html?id={{d.data[i].id}}">浏览</a>-->
                <a class="button deleteArticle" data="{{d.data[i].id}}" href="javascript:void(0)" >删除</a>
            </td>
        </tr>
        {{# } }}
            </tbody>
    </table>
</script>
<script>
    function demo(curr){
        $.post('/hzzadmin/__Controller__/__Function__s', {
            page: curr || 1, //向服务端传的参数，此处只是演示
            title: $('#title').val()
        }, function(res){
            if (res.status !='false'){
                console.log(res);
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
</script>