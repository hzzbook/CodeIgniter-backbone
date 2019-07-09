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
    <h4 class="cont_title"><span>编辑分类 <a href="javascript:void(0)" id="backbtn" class="button">返回</a></span></h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">分类标题：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="title" name="title" placeholder="标题">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">上级分类：</label>
                <div class="col-sm-10">
                    <select class="form-select" id="cate" name="fid">
                        <option value="0">无上级分类</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">关键字：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="keyword" name="keyword" placeholder="关键字">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">描述：</label>
                <div class="col-sm-10">
                    <textarea class="form-textarea" name="description" id="description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">封面图片：</label>
                <div class="col-sm-10">
                    <input id="file_upload" name="file_upload" type="file" multiple="true">
                    <input type="hidden" name="cover" id="headimg" value="">
                    <img width="200" height="200" src="" id="imghead" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">分类内容：</label>
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
<script src="/asset/adminasset/vendor/laytpl.js"></script>
<script src="/asset/adminasset/js/layer/layer.js"></script>
<script id="catelist" type="text/html">
    <option  value='0'>无父级分类</option>
    {{# for(var i = 0, len = d.data.length; i < len; i++){ }}

    {{# if (d.cateid == d.data[i].id) { }}
    <option selected="selected" value='{{d.data[i].id}}'>{{ d.data[i].title }}</option>
    {{# } else { }}
    <option value='{{d.data[i].id}}'>{{ d.data[i].title }}</option>
    {{# } }}
    {{# } }}
</script>
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            allowFileManager : true,
            width : '90%',
            height: '500px'
        });
    });
    function getcategory(cateid) {
        $.post('/hzzadmin/cms/categorys', {
            },
            function (res) {
                res.cateid = cateid;
                console.log(res.cateid);
                var gettpl = document.getElementById('catelist').innerHTML;
                laytpl(gettpl).render(res, function (html) {
                    document.getElementById('cate').innerHTML = html;
                });
            }, 'json');
    }
    function article() {
        $.post('/hzzadmin/cms/category', {
                id: $('#id').val()
            },
            function (res) {
                if (res.status != 'false') {
                    $('#title').val(res.data.title);
                    $('#keyword').val(res.data.keyword);
                    $('#description').val(res.data.description);
                    $('#headimg').val(res.data.cover);
                    $('#imghead').val(res.data.cover);
                    editor.html(res.data.content);
                    getcategory(res.data.fid);
                }
            }, 'json');
    }
    article();
    $('#save').bind('click', function(){
        $('#content').val(editor.html());
        $.ajax({
            url:"/hzzadmin/cms/categoryUpdate",
            data:$("#datares").serialize(),
            type:"post",
            dataType: 'json',
            success:function(data){//ajax返回的数据
                if (data.status=='false')
                {
                    if (data.code == '869'){
                        $('#token').val(data.token);
                    }
                    layer.msg(data.info);
                } else  {
                    layer.msg('修改成功');
                    window.history.back(-1);
                }
            }
        });
    })
    $('#backbtn').bind('click', function(){
        window.history.back(-1);
    })
</script>


