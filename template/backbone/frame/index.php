<link rel="stylesheet" href="/asset/adminasset/css/user_return.css">
<link rel="stylesheet" href="/asset/bootstrap-table/bootstrap-table.css">
<script src="/asset/bootstrap-table/bootstrap-table.js"></script>
<script src="/asset/bootstrap-table/locale/bootstrap-table-zh-CN.js"></script>
<script src="/asset/tableExport/libs/FileSaver/FileSaver.min.js"></script>
<script type="text/javascript" src="/asset/tableExport/tableExport.js"></script>
<script type="text/javascript" src="/asset/tableExport/jquery.base64.js"></script>
<script src="/asset/bootstrap-table/extensions/export/bootstrap-table-export.js"></script>
<script src="/asset/bootstrap-table/extensions/editable/bootstrap-table-editable.js"></script>

<div class="mainWrap">
    <h4 class="cont_title"><span>文章列表</span></h4>

    <div class="return_box">
        <div class="search_box">
            <form id="search_form">
            <div class="text_inputs">
                <span>标题：</span>
                <input type="text" name="title" id="title" placeholder="文章标题">
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
                <input id="public_date" name="public_date" class="laydate-icon" style="min-width:210px;">
                <button id="btn_query" type="button" class="button">搜索</button>
                <button id="btn_reset" type="button" class="button">重置</button>
            </div>
            </form>
        </div>
        <div id="toolbar" class="btn-group">
            <button id="btn_add" type="button" class="btn btn-default">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>新增
            </button>
            <button id="btn_delete" type="button" class="btn btn-default">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>删除
            </button>
        </div>
        <table id="ArbetTable"></table>
    </div>
</div>

<div id="pagediv" style="text-align:center;margin: 10px auto"></div>
    </div>
</div>
</div>
<script src="/asset/laypage/laypage.js"></script>
<script src="/asset/laytpl.js"></script>
<script src="/asset/layer/layer.js"></script>
<script src="/asset/laydate/laydate.js"></script>
<script src="/asset/jquery.serializejson.min.js"></script>
<script>
       laydate.render({
            elem: '#public_date'
            ,format: 'yyyy-MM-dd'
            ,range: true
        });
    $(function() {
        //1.初始化Table
        var oTable = new TableInit();
        oTable.Init();
        //2.初始化Button的点击事件
        var oButtonInit = new ButtonInit();
        oButtonInit.Init();
    });

    var TableInit = function() {
        var oTableInit = new Object();
        //初始化Table
        oTableInit.Init = function() {
            $('#ArbetTable').bootstrapTable({
                url: '/hzzadmin/frame/demos', //请求后台的URL（*）
                method: 'get', //请求方式（*）
                toolbar: '#toolbar', //工具按钮用哪个容器
                showExport: true,//显示导出按钮
                exportDataType: "all",//导出类型
                exportTypes:['excel'],
                striped: true, //是否显示行间隔色
                cache: false, //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
                pagination: true, //是否显示分页（*）
                sortable: false, //是否启用排序
                sortOrder: "asc", //排序方式
                queryParams: oTableInit.queryParams, //传递参数（*）
                sidePagination: "server", //分页方式：client客户端分页，server服务端分页（*）
                pageNumber: 1, //初始化加载第一页，默认第一页
                pageSize: 8, //每页的记录行数（*）
                pageList: [8, 15, 30, 50, 100], //可供选择的每页的行数（*）
                //search: true, //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
                //strictSearch: true,
                showColumns: true, //是否显示所有的列
                showRefresh: true, //是否显示刷新按钮
                minimumCountColumns: 2, //最少允许的列数
                clickToSelect: true, //是否启用点击选中行
                height: 580, //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
                uniqueId: "ID", //每一行的唯一标识，一般为主键列
                showToggle: true, //是否显示详细视图和列表视图的切换按钮
                cardView: false, //是否显示详细视图
                detailView: false, //是否显示父子表
                exportOptions:{
                    ignoreColumn: [0,1,-1],  //忽略某一列的索引
                    fileName: '总台帐报表',  //文件名称设置
                    worksheetName: 'sheet1',  //表格工作区名称
                    tableName: '总台帐报表',
                    excelstyles: ['background-color', 'color', 'font-size', 'font-weight']

                },
                formatLoadingMessage: function () {
                    return "请稍等，正在加载中...";
                },
                formatNoMatches: function () {  //没有匹配的结果
                    return '无符合条件的记录';
                },
                columns: [{
                    checkbox: true
                }, {
                    field: 'id',
                    title: 'ID',
                    width: '20px'
                }, {
                    field: 'title',
                    title: '标题'
                }, {
                    field: 'logtime',
                    title: '发布时间',
                    formatter: timeFormatter
                }, {
                    field: 'operate',
                    title: '操作',
                    width: '140px',
                    events: operateEvents1,
                    formatter: operateFormatter
                } ]
            });
        };


        window.operateEvents1 = {
            'click .edit': function(e, value, row, index) {
                layer.open({
                    type: 2,
                    title: '修改页面',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['700px', '90%'],
                    content: '/hzzadmin/frame/demoEditPage?id='+row.id
                });
            },
            'click .delete': function(e, value, row, index) {
                $id = row.id;
                layer.confirm('确定删除该记录？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.post('/hzzadmin/cms/articleDelete', {
                        id: $id
                    }, function(res){
                        if (res.status == 'true')
                        {
                            layer.msg('操作成功', {icon: 1});
                            $('#ArbetTable').bootstrapTable('refresh', '');
                        } else {
                            layer.msg('操作失败');
                        }
                    }, 'json');
                }, function(){

                });
            }
        };

        function timeFormatter(value, row, index) {
            var date = new Date(value);
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
    	}

        function imageFormatter(value, row, index) {
            return [
                '<img src="'+row.src+'" width="60"/>'
            ].join('');
        }

        function operateFormatter(value, row, index) {
            return [
                '<button id="btn_detail" type="button" class="edit btn btn-primary bt-select">编辑</button>',
                '<button id="btn_detail" type="button" class="delete btn btn-primary bt-select" style="margin-left:2px;">删除</button>',
            ].join('');
        }

        //得到查询的参数
        oTableInit.queryParams = function(params) {
            var temp = { //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
                limit: params.limit, //页面大小
                offset: params.offset //页码
            };
            var search_data = $('#search_form').serializeJSON();
            var params = $.extend({}, temp, search_data);
            return params;
        };
        return oTableInit;
    };

    $("#btn_query").click(function () {
        //点击查询是 使用刷新 处理刷新参数
        var opt = {
            url: "/hzzadmin/frame/demos",
            silent: true,
            query: $('#search_form').serializeJSON()
        };
        $('#ArbetTable').bootstrapTable('refresh', opt);
    });

       $("#btn_reset").click(function () {
           //点击查询是 使用刷新 处理刷新参数
           document.getElementById("search_form").reset();
           $('#btn_query').click();
       });

    $('#btn_add').click(function(){
        layer.open({
            type: 2,
            title: '添加页面',
            shadeClose: true,
            shade: 0.8,
            area: ['700px', '90%'],
            content: '/hzzadmin/frame/demoAddPage'
        });
    })

    $("#btn_delete").click(function () {
        if (confirm("确认要删除吗？")) {
            var idlist = "";
            $("input[name='btSelectItem']:checked").each(function () {
                idlist += $(this).parents("tr").attr("data-uniqueid") + ",";
            })
            alert("删除的列表为" + idlist);

        }
    });

    var ButtonInit = function () {
        var oInit = new Object();
        var postdata = {};

        oInit.Init = function () {
            //初始化页面上面的按钮事件
        };

        return oInit;
    };


</script>