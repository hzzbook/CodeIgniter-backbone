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
    <h4 class="cont_title"><span>修改友情链接<a href="javascript:void(0)" id="backbtn" class="button">返回</a></span></h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">名称：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="name" name="name" placeholder="标题">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">分类标识：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="sn" name="sn" placeholder="分类标记">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">url：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="url" name="url" placeholder="分类标记">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">图片：</label>
                <div class="col-sm-10">
                    <input id="file_upload" name="file_upload" type="file" multiple="true">
                    <input type="hidden" name="imglink" id="headimg" value="">
                    <img width="200" height="200" src="" id="imghead" />
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
<script src="/asset/adminasset/js/layer/layer.js"></script>
<script type="text/javascript">
    <?php $timestamp = time();?>
    $(function() {
        $('#file_upload').uploadify({
            'fileSizeLimit' : '1MB',
            'fileTypeExts' : '*.gif; *.jpg; *.png',
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
            },
            'swf'      : '/adminasset/uploadify/uploadify.swf',
            'uploader' : '/adminasset/uploadify/uploadify.php',
            'width' : 200,
            'queueproess'    : false,
            'onUploadSuccess' : function(file, data, response){
                $('#headimg').val(data);
                $('#imghead').attr('src',data);
            }
        });
    });
</script>
<script>
    function article() {
        $.post('/hzzadmin/cms/friendlink', {
                id: $('#id').val()
            },
            function (res) {
                if (res.status != 'false') {
                    $('#name').val(res.data.name);
                    $('#sn').val(res.data.sn);
                    $('#url').val(res.data.url);
                    $('#imglink').val(res.data.imglink);
                    $('#imghead').attr('src', res.data.imglink);
                }
            }, 'json');
    }
    article();
    $('#save').bind('click', function(){

        $.ajax({
            url:"/hzzadmin/cms/friendlinkUpdate",
            data:$("#datares").serialize(),
            type:"post",
            dataType: 'json',
            success:function(data){//ajax返回的数据
                if (data.status=='false')
                {
                    if (data.code == '869'){
                        $('#token').val(data.token);
                    }
                } else  {
                    layer.msg('修改成功');
                    window.history.back(-1);
                }
            }
        });
    })
</script>

