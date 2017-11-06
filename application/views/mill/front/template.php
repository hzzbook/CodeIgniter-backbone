
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>basic-demo</title>
    <script src="/asset/template-web.js"></script>
    <script src="/asset/laytpl.js"></script>
</head>

<body>
<div id="content"></div>
<div id="view"></div>
<script id="test" type="text/html">
    {{if isAdmin}}

    <h1>{{title}}</h1>
    <ul>
        {{each list value i}}
        <li>索引 {{i + 1}} ：{{value}}</li>
        {{/each}}
    </ul>

    {{/if}}
    {{$data}}
</script>
<script id="test2" type="text/html">
    <h3>{{ d.title }}</h3>
    <ul>
        {{#  for(var i = 0, len = d.list.length; i < len; i++){ }}
        <li>
            <span>{{ d.list[i].modname }}</span>
            <span>{{ d.list[i].alias }}：</span>
            <span>{{ d.list[i].site || '' }}</span>
        </li>
        {{#  } }}

        {{#  if(d.list.length === 0){ }}
        无数据
        {{#  } }}
    </ul>
</script>
<script src="/asset/jquery.min.js" type="javascript"></script>
<script>
    var data = {
        title: '基本例子',
        isAdmin: true,
        list: ['文艺', '博客', '摄影', '电影', '民谣', '旅行', '吉他']
    };
    var data2 = {
        "title": "Layui常用模块"
        ,"list": [
            {
                "modname": "弹层"
                ,"alias": "layer"
                ,"site": "layer.layui.com"
            }
            ,{
                "modname": "表单"
                ,"alias": "form"
            }
            ,{
                "modname": "分页"
                ,"alias": "laypage"
            }
            ,{
                "modname": "日期"
                ,"alias": "laydate"
            }
            ,{
                "modname": "上传"
                ,"alias": "upload"
            }
        ]
    }

    var html = template('test', data);
    document.getElementById('content').innerHTML = html;

    var tpl = document.getElementById('test2').innerHTML; //读取模版
    //方式一：异步渲染（推荐）
    laytpl(tpl).render(data2, function(render){
        document.getElementById('view').innerHTML = render;
    });
    //方式二：同步渲染：
   /* var render = laytpl(tpl).render(data);
    document.getElementById('view').innerHTML = render;*/
</script>
</body>
</html>