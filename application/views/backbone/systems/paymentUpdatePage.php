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
    <h4 class="cont_title"><span>编辑支付方式</span></h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">支付名称：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="name" name="name" placeholder="支付名称">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">code：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="code" name="code" placeholder="code">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">帐号：</label>
                <div class="col-sm-10">
                    <input type="text" lass="form-input-mid" id="account" name="account" placeholder="帐号">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">密码：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="password" name="password" placeholder="密码">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">加密字符（备用）：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="salt" name="salt" placeholder="加密字符">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">渠道：</label>
                <div class="col-sm-10">
                    <select name="channel">
                        <option value="1">PC</option>
                        <option value="2">移动端</option>
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
<script src="/adminasset/js/layer/layer.js"></script>
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
        $.post('/hzzadmin/systems/pay', {
                id: $('#id').val()
            },
            function (res) {
                if (res.status != 'false') {
                    $('#name').val(res.data.name);
                    $('#code').val(res.data.code);
                    $('#logo').val(res.data.logo);
                    $('#account').val(res.data.account);
                    $('#password').val(res.data.passwrd);
                    $('#channel').val(res.data.channel);
                }
            }, 'json');
    }
    article();
    $('#save').bind('click', function(){

        $.ajax({
            url:"/hzzadmin/cms/peymentUpdate",
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
                    layer.msg('支付方式修改成功');
                    //window.location.href = '/b_cms_imagepage.html';
                }
            }
        });
    })
</script>

