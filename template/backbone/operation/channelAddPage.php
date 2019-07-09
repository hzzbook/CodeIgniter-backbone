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
        <span>添加推广渠道    <a href="javascript:void(0)" id="backbtn" class="button">返回</a></span>

    </h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">权限推广渠道：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="inputEmail3" placeholder="推广渠道" name="name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">联系人：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="linkman" name="linkman"  placeholder="联系人" >
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">联系电话：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="mobile" name="mobile"  placeholder="联系电话">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">官网地址：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="url" name="url"  placeholder="官网地址">
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

<script src="/asset/adminasset/vendor/laytpl.js"></script>
<script src="/asset/adminasset/js/layer/layer.js"></script>

<script>
    $('#save').bind('click', function(){
        $.ajax({
            url:"/hzzadmin/operation/channelAdd",
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

