<style>
    #datatable {
        min-height:400px;
    }

    .spinner {
        margin: 100px auto;
        width: 50px;
        height: 60px;
        text-align: center;
        font-size: 10px;
    }

    .spinner > div {
        background-color: #67CF22;
        height: 100%;
        width: 6px;
        display: inline-block;

        -webkit-animation: stretchdelay 1.2s infinite ease-in-out;
        animation: stretchdelay 1.2s infinite ease-in-out;
    }

    .spinner .rect2 {
        -webkit-animation-delay: -1.1s;
        animation-delay: -1.1s;
    }

    .spinner .rect3 {
        -webkit-animation-delay: -1.0s;
        animation-delay: -1.0s;
    }

    .spinner .rect4 {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .spinner .rect5 {
        -webkit-animation-delay: -0.8s;
        animation-delay: -0.8s;
    }

    @-webkit-keyframes stretchdelay {
        0%, 40%, 100% { -webkit-transform: scaleY(0.4) }
        20% { -webkit-transform: scaleY(1.0) }
    }

    @keyframes stretchdelay {
        0%, 40%, 100% {
            transform: scaleY(0.4);
            -webkit-transform: scaleY(0.4);
        }  20% {
               transform: scaleY(1.0);
               -webkit-transform: scaleY(1.0);
           }
    }
</style>
<div class="mainWrap">
    <h4 class="cont_title"><span>列表</span></h4>
    <div style="margin-top:20px;">
        <a href="/b_frame_tempAddPage.html" class="button" >添加文章</a>
    </div>
    <div class="return_box">

        <div class="search_box">
            <div class="text_inputs">

                <span>标题：</span>
                <input type="text" id="title" placeholder="标题">
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
                <button id="exportbtn" class="button" style="margin-left:40px;">导出</button>
            </div>

        </div>
        <div class="table_box table-responsive tables" id="datatable">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
        <div class="row"><div class="col-sm-3" style="padding-left:40px;"><button class="button" id="deleteAll">批量删除</button></div><div id="pagediv" class="col-sm-9"></div></div>
    </div>
</div>
</div>
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
            <td><input type="checkbox" name="selectAll" id="selectAll"></td>
            <td>标题</td>
            <td>分类</td>
            <td>描述</td>
            <td>发布时间</td>
            <td width="240">操作</td>
        </tr>
        </thead>
        <tbody id="datalist">
        {{# for(var i = 0, len = d.data.length; i < len; i++){ }}
        <tr>
            <td><input type="checkbox" name="selected[]" value="{{ d.data[i].id }}"</td>
            <td>{{ d.data[i].title }}</td>
            <td>{{ d.data[i].catename }}</td>
            <td>{{ d.data[i].summary }}</td>
            <td>{{ d.data[i].logtime }}</td>
            <td>
                <a class="button" href="/b_frame_tempUpdatePage.html?id={{d.data[i].id}}">编辑</a>
                <a class="button deleteArticle" data="{{d.data[i].id}}" href="javascript:void(0)" style="margin-left:20px;">删除</a>
            </td>
        </tr>
        {{# } }}
        </tbody>
    </table>
</script>
<script>
    function getcategory() {
        $.post('/hzzadmin/cms/categorys', {},
            function (res) {
                var gettpl = document.getElementById('catelist').innerHTML;
                laytpl(gettpl).render(res, function (html) {
                    document.getElementById('cate').innerHTML = html;
                });
            }, 'json');
    }
    getcategory();
    function demo(curr) {
        $.post('/hzzadmin/cms/articles', {
            page: curr || 1, //向服务端传的参数，此处只是演示
            title: $('#title').val(),
            cate: $('#cate').val(),
            status: $('#status').val(),
            start: $('#start').val(),
            end: $('#end').val()
        }, function (res) {
            if (res.status != 'false') {
                var gettpl = document.getElementById('demo').innerHTML;
                laytpl(gettpl).render(res, function (html) {
                    document.getElementById('datatable').innerHTML = html;
                });
                //显示分页
                laypage({
                    cont: 'pagediv', //容器。值支持id名、原生dom对象，jquery对象。【如该容器为】：<div id="page1"></div>
                    pages: res.page, //通过后台拿到的总页数
                    curr: curr || 1, //当前页
                    jump: function (obj, first) { //触发分页后的回调
                        history.replaceState({page: curr}, '', '?page=' + curr);
                        if (!first) { //点击跳页触发函数自身，并传递当前页：obj.curr
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
    }
    ;
    $page = getParam('page');
    demo($page);

    $('#searchbtn').bind('click', function () {
        demo(1);
    })

    $(document).on("click", ".deleteArticle", function () {
        $id = $(this).attr('data');
        layer.msg('你确定删除该记录？', {
            time: 0 //不自动关闭
            , btn: ['确定删除', '取消']
            , yes: function (index) {
                $.post('/hzzadmin/cms/articleDelete', {
                    id: $id
                }, function (res) {
                    if (res.status == 'true') {
                        window.location.reload();
                    } else {
                        layer.msg('删除失败');
                    }
                }, 'json');
            }
        });
    });

    $(document).on("click", "#selectAll", function () {
        $child = $(this).parent().parent().parent().next();
        if($(this).attr("checked")){    //删除
            $child.find('input').each(function(){
                $(this).attr('checked',false);
            })
            $(this).attr('checked',false);
        } else {    //选中
            $child.find('input').each(function(){
                $(this).prop('checked',true);
                //$(this).attr('checked',true);
            })
            $(this).attr('checked',true);
        }
    });

    $(document).on("click", "#deleteAll", function () {
        $child = $(this).parent().parent().parent().next();
        if($(this).attr("checked")){    //删除
            $child.find('input').each(function(){
                $(this).attr('checked',false);
            })
            $(this).attr('checked',false);
        } else {    //选中
            $child.find('input').each(function(){
                $(this).prop('checked',true);
                //$(this).attr('checked',true);
            })
            $(this).attr('checked',true);
        }
    });

</script>
