<link rel="stylesheet" href="/adminasset/css/user_return.css">

<div class="mainWrap">
    <h4 class="cont_title"><span>角色列表</span></h4>

    <div class="return_box">
        <div class="search_box">
            <div class="text_inputs">
                <a href="/b_permission_roleAddPage.html" class="button" style="background: #ffcc33">添加角色</a>

            </div>
            <div class="laydate">

            </div>
        </div>

        <div class="table_box table-responsive tables" id="datatable">
        </div>
        <div id="pagediv" style="text-align:center;margin: 10px auto"></div>
    </div>
</div>
</div>
<script src="/adminasset/js/laydate/laydate.js"></script>
<script>
    var start = {
        elem: '#start',
        format: 'YYYY/MM/DD',
        //min: laydate.now(),
        max: laydate.now(),
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
        //min: laydate.now(),
        max: laydate.now(),
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
            <td>角色名称</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        {{# for(var i = 0, len = d.data.length; i < len; i++){ }}
        <tr>
            <td>{{ d.data[i].rolename }}</td>

            <td>
                {{# if(d.data[i].id != 1){ }}
                <a class="button" href="/b_<?php echo $slider_tag;?>_roleUpdatePage.html?id={{d.data[i].id}}">编辑</a>
                <a class="button" href="/b_<?php echo $slider_tag;?>_authorizePage.html?id={{d.data[i].id}}">授权</a>
                <a class="button deleteArticle" data="{{d.data[i].id}}" href="javascript:void(0)" >删除</a>
                {{# }}}
            </td>
        </tr>
        {{# } }}
        </tbody>
    </table>
</script>
<script>
    /*function getcategory() {
        $.post('/hzzadmin/cms/categorys', {
            },
            function (res) {
                var gettpl = document.getElementById('catelist').innerHTML;
                laytpl(gettpl).render(res, function (html) {
                    document.getElementById('cate').innerHTML = html;
                });
            }, 'json');
    }
    getcategory();*/
    function demo(curr){
        $.post('/hzzadmin/<?php echo $slider_tag;?>/roles', {
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
                        if(!first){ //点击跳页触发函数自身，并传递当前页：obj.curr
                            demo(obj.curr);
                        }
                    }
                });
            } else {
                html = '查询无角色';
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
        layer.msg('你确定删除该角色？', {
            time: 0 //不自动关闭
            ,btn: ['确定删除', '取消']
            ,yes: function(index){
                $.post('/hzzadmin/permission/roleDelete', {
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
