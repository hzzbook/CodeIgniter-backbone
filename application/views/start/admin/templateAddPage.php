<script src="/adminasset/js/jquery-1.11.3.min.js"></script>
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
<link rel="stylesheet" type="text/css" href="/adminasset/uploadify/uploadify.css">
<script charset="utf-8" src="/asset/ked/kindeditor.js"></script>
<script charset="utf-8" src="/adminasset/uploadify/jquery.js"></script>
<script src="/adminasset/uploadify/jquery.uploadify.js" type="text/javascript"></script>
<div class="mainWrap">
    <h4 class="cont_title">
        <span>添加页面    <a href="javascript:void(0)" id="backbtn" class="button">返回</a></span>

    </h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">文本：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="inputEmail3" placeholder="文本" name="name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">长文本：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="linkman" name="linkman"  placeholder="长文本" >
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">图片：</label>
                <div class="col-sm-10">
                    <input id="file_upload" name="file_upload" type="file" multiple="true">
                    <input type="hidden" name="cover" id="headimg" value="">
                    <img width="200" height="200" src="" id="headimg2" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">图片组：</label>
                <div class="col-sm-10">
                    <input id="file_upload2" name="file_upload2" type="file" multiple="true">
                    <input type="hidden" name="cover_group" id="imghead" value="">
                    <img width="200" height="200" src="" id="imghead2" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">标签：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="mobile" name="tag"  placeholder="联系电话">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">下拉单选：</label>
                <div class="col-sm-10">
                    <select class="form-select" name="cateid" id="cate">
                        <option value="0">无</option>
                        <option value="1">选择1</option>
                        <option value="2">选择2</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">下拉多选：</label>
                <div class="col-sm-10">
                    <select class="form-select" >

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">单选：</label>
                <div class="col-sm-10">
                    <div><input type="radio" name="choose_single" value="s1">单选1</div>
                    <div><input type="radio" name="choose_single" value="s2">单选2</div>
                    <div><input type="radio" name="choose_single" value="s3">单选3</div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">多选：</label>
                <div class="col-sm-10">
                    <div><input type="checkbox" name="choose_multi[]" value="m1">多选1</div>
                    <div><input type="checkbox" name="choose_multi[]" value="m2">多选2</div>
                    <div><input type="checkbox" name="choose_multi[]" value="m3">多选3</div>
                    <div><input type="checkbox" name="choose_multi[]" value="m4">多选4</div>
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">富文本：</label>
                <div class="col-sm-10">
                    <textarea class="form-textarea" name="content" id="content"></textarea>
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
<script>
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
                $('#headimg2').attr('src',data);
            }
        });
    });

    $(function() {
        $('#file_upload2').uploadify({
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
                $('#imghead').val(data);
                $('#imghead2').attr('src',data);
            }
        });
    });

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
            url:"/start/templateAdd",
            data:$("#datares").serialize(),
            type:"post",
            dataType: 'json',
            success:function(data){//ajax返回的权限结点
                if (data.status == 'true') {
                    layer.msg('添加成功');
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

