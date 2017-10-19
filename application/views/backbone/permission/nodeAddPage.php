<style>
    .form-input-mid{
        width: 250px;
        height: 30px;
        margin: 0 5px;
        text-indent: 5px;
    }
    .form-input-large{
        width: 80%;
        max-width:650px;
        height: 30px;
        margin: 0 5px;
        text-indent: 5px;
    }
    .form-input-file {
        text-indent: 5px;
    }
    .form-select {
        width: 80%;
        max-width:250px;
        height: 30px;
        margin: 0 5px;
        text-indent: 5px;
    }
    .form-textarea {
        width: 80%;
        max-width:650px;
        height: 80px;
        margin: 0 5px;
        text-indent: 5px;
    }
</style>
<link rel="stylesheet" href="/ked/themes/default/default.css" />
<link rel="stylesheet" href="/ked/plugins/code/prettify.css" />
<link rel="stylesheet" type="text/css" href="/adminasset/uploadify/uploadify.css">
<script charset="utf-8" src="/ked/kindeditor.js"></script>
<script charset="utf-8" src="/adminasset/uploadify/jquery.js"></script>
<script src="/adminasset/uploadify/jquery.uploadify.js" type="text/javascript"></script>

<div class="mainWrap">
    <h4 class="cont_title">
        <span>添加权限结点    <a href="javascript:void(0)" id="backbtn" class="button">返回</a></span>

    </h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">权限结点名称：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="inputEmail3" placeholder="名称" name="node_name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">父结点：</label>
                <div class="col-sm-10">
                    <select class="form-select" name="p_id" id="cate">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">结点类型：</label>
                <div class="col-sm-10">
                    <select class="form-select" name="node_type" id="node_type">
                        <option value="1">菜单</option>
                        <option value="2">动作</option>
                        <option value="3">页面</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">结点图标：</label>
                <div class="col-sm-10">
                    <select class="form-select" name="node_icon" id="icon">
                        <option value="tag">tag</option>
                        <option value="space-shuttle">space-shuttle</option>
                        <option value="support">support</option>
                        <option value="tasks">tasks</option>
                        <option value="tachometer">tachometer</option>
                        <option value="trophy">trophy</option>
                        <option value="tree">tree</option>
                        <option value="empire">empire</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">结点排序：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="ordernum" name="ordernum"  placeholder="结点排序" value="50">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">结点地址：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="nodeurl" name="node_url"  placeholder="结点地址">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">控制器名：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="cont" name="cont"  placeholder="控制器名">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">方法名：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="func" name="func"  placeholder="方法名">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a id="save" class="btn btn-default" href="javascript:void(0)">保存</a>
                    <!--<a id="pubilc" class="btn btn-default">保存并发布</a>-->
                </div>
            </div>
        </form>
    </div>
</div>

<script src="/adminasset/vendor/laytpl.js"></script>
<script src="/adminasset/js/layer/layer.js"></script>
<script id="catelist" type="text/html">
    {{# for(var i = 0, len = d.length; i < len; i++){ }}
    <option value='{{d[i].id}}'>{{ d[i].node_name }}</option>
    {{# } }}
</script>
<script>
    function getcategory() {
        $.post('/hzzadmin/permission/nodeLevel', {
            },
            function (res) {

                    var gettpl = document.getElementById('catelist').innerHTML;
                    laytpl(gettpl).render(res, function (html) {
                        document.getElementById('cate').innerHTML = html;
                    });

            }, 'json');
    }
    getcategory();
    $('#save').bind('click', function(){
        $.ajax({
            url:"/hzzadmin/permission/nodeAdd",
            data:$("#datares").serialize(),
            type:"post",
            dataType: 'json',
            success:function(data){//ajax返回的权限结点
                if (data.status == 'true') {
                    layer.msg('权限结点添加成功');
                    window.history.back(-1);
                } else {
                    $('#token').val(data.token);
                    layer.msg(data.info);
                }
            }
        });
    })
    $('#backbtn').bind('click', function(){
        window.history.back(-1);
    })
</script>

