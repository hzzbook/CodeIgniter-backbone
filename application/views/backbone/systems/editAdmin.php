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

<link rel="stylesheet" type="text/css" href="/adminasset/uploadify/uploadify.css">

<script charset="utf-8" src="/adminasset/uploadify/jquery.js"></script>
<script src="/adminasset/uploadify/jquery.uploadify.js" type="text/javascript"></script>

<div class="mainWrap">
    <h4 class="cont_title"><span>编辑管理员信息</span></h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">用户名：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="username" name="username" placeholder="用户名">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">密码：</label>
                <div class="col-sm-10">
                    <input type="password" class="form-input-mid" id="password" name="password" placeholder="密码">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">昵称：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="fullname" name="fullname" placeholder="昵称">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">手机号：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="mobile" name="mobile" placeholder="手机号">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">email：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="email" name="email" placeholder="email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">角色：</label>
                <div class="col-sm-10">
                    <select name="role_id" id="role">

                    </select>
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
<script src="/adminasset/vendor/laytpl.js"></script>
<script src="/adminasset/js/layer/layer.js"></script>
<script id="catelist" type="text/html">
    {{# for(var i = 0, len = d.data.length; i < len; i++){ }}
    {{# if (d.cateid == d.data[i].id) { }}
    <option selected="selected" value='{{d.data[i].id}}'>{{ d.data[i].rolename }}</option>
    {{# } else { }}
    <option value='{{d.data[i].id}}'>{{ d.data[i].rolename }}</option>
    {{# } }}

    {{# } }}
</script>
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
    function get(cateid) {
        $.post('/hzzadmin/permission/roles', {
            },
            function (res) {
                res.cateid = cateid;
                var gettpl = document.getElementById('catelist').innerHTML;
                laytpl(gettpl).render(res, function (html) {
                    document.getElementById('role').innerHTML = html;
                });
            }, 'json');
    }
    function article() {
        $.post('/hzzadmin/systems/admin', {
                id: $('#id').val()
            },
            function (res) {
                    $('#username').val(res.username);
                    $('#fullname').val(res.fullname);
                    $('#mobile').val(res.mobile);
                    $('#email').val(res.email);
                    get(res.role_id);
            }, 'json');
    }
    article();
    $('#save').bind('click', function(){

        $.ajax({
            url:"/hzzadmin/systems/adminUpdate",
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

