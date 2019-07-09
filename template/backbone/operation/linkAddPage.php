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
<link rel="stylesheet" href="/asset/ked/themes/default/default.css" />
<link rel="stylesheet" href="/asset/ked/plugins/code/prettify.css" />
<link rel="stylesheet" type="text/css" href="/asset/adminasset/uploadify/uploadify.css">
<script charset="utf-8" src="/asset/ked/kindeditor.js"></script>
<script charset="utf-8" src="/asset/adminasset/uploadify/jquery.js"></script>
<script src="/asset/adminasset/uploadify/jquery.uploadify.js" type="text/javascript"></script>

<div class="mainWrap">
    <h4 class="cont_title">
        <span>添加推广链接    <a href="javascript:void(0)" id="backbtn" class="button">返回</a></span>

    </h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">推广链接描述：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="inputEmail3" placeholder="推广链接描述" name="description">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">推广渠道：</label>
                <div class="col-sm-10">
                    <select class="form-select" name="channelid" id="cate">

                    </select>
                </div>
            </div>baby
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a id="save" class="btn btn-default" href="javascript:void(0)">保存</a>
                    <!--<a id="pubilc" class="btn btn-default">保存并发布</a>-->
                </div>
            </div>
        </form>
    </div>
</div>

<script src="/asset/adminasset/vendor/laytpl.js"></script>
<script src="/asset/adminasset/js/layer/layer.js"></script>
<script id="catelist" type="text/html">
    {{# for(var i = 0, len = d.length; i < len; i++){ }}
    <option value='{{d[i].id}}'>{{ d[i].name }}</option>
    {{# } }}
</script>
<script>
    function getcategory() {
        $.post('/hzzadmin/operation/channels', {
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
            url:"/hzzadmin/operation/linkAdd",
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

