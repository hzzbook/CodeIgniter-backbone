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
    <h4 class="cont_title"><span>编辑内容片段 <a href="javascript:void(0)" id="backbtn" class="button">返回</a></span></h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">标题：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="title" name="title" placeholder="标题">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">标识：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="key" name="sn" placeholder="分类标识">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">关键字：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="keyword" name="keyword" placeholder="关键字">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">描述：</label>
                <div class="col-sm-10">
                    <textarea class="form-textarea" name="description" id="description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">内容：</label>
                <div class="col-sm-10">
                    <textarea class="form-textarea" id="content" name="content"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a id="save" class="btn btn-default" href="javascript:void(0)">保存</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="/adminasset/js/layer/layer.js"></script>
<script>

    function article() {
        $.post('/hzzadmin/cms/singlepage', {
                id: $('#id').val()
            },
            function (res) {
                if (res.status != 'false') {
                    $('#title').val(res.data.title);
                    $('#key').val(res.data.key);
                    $('#keyword').val(res.data.keyword);
                    $('#description').html(res.data.description);
                    editor.html(res.data.content);
                }
            }, 'json');
    }
    article();
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            allowFileManager : true,
            width : '90%',
            height: '500px'
        });
    });
    $('#save').bind('click', function(){
        $('#content').val(editor.html());
        $.ajax({
            url:"/hzzadmin/cms/contentUpdate",
            data:$("#datares").serialize(),
            type:"post",
            success:function(data){//ajax返回的数据
                if (data.status=='false')
                {
                    if (data.code == '869'){
                        $('#token').val(data.token);
                    }
                } else  {
                    layer.msg('文章修改成功');
                    window.history.back(-1);
                }
            }
        });
    })
    $('#backbtn').bind('click', function(){
        window.history.back(-1);
    })
</script>

