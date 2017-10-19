<link rel="stylesheet" href="/adminasset/css/user_info.css">
<link rel="stylesheet" type="text/css" href="/adminasset/uploadify/uploadify.css">
<script charset="utf-8" src="/adminasset/uploadify/jquery.js"></script>
<script src="/adminasset/uploadify/jquery.uploadify.js" type="text/javascript"></script>
<div class="mainWrap">
    <h4 class="cont_title"><span>网站信息配置</span></h4>
    <p class="tips">网站详细信息</p>

    <div class="editor_btns">
        <div class="fr">
            <button href="#" id="save" class="Gusername button">保存</button>
            <!--<a href="#" class="Gphone button">更改手机</a>
            <a href="#" class="Gmail button">更改邮箱</a>
            <a href="#" class="Gpassward button">更改密码</a>-->
        </div>
    </div>

    <div class="tabBox">
        <ul class="hd clearfix">
            <li class="on"><a href="#">详细信息</a></li>
            <!--<li><a href="#">资产信息</a></li>
            <li><a href="#">回款及资金信息</a></li>-->
        </ul>
        <form id="datares" method="post">
        <div class="bd p20">
            <div>
                <dl class="info_list info_public">
                    <dd><i>网站名称：</i><input type="text" name="site_name" value="<?php echo $website['site_name']; ?>"></dd>
                    <dd><i>网站关键字：</i><input type="text" name="site_keyword" value="<?php echo $website['site_keyword']; ?>"></dd>
                    <dd><i>描述：</i><textarea name="site_description"><?php echo $website['site_description']; ?></textarea></dd>
                    <dd><i>网站备案号：</i><input type="text" name="site_beian" value="<?php echo $website['site_beian']; ?>" ></dd>
                    <dd><i>Email：</i><input type="text" name="site_email" value="<?php echo $website['site_email']; ?>"> </dd>
                    <dd><i>联系电话：</i><input type="text" name="site_telphone" value="<?php echo $website['site_telphone']; ?>"></dd>
                    <dd><i>400电话：</i><input type="text" name="site_400" value="<?php echo $website['site_400']; ?>"></dd>
                    <dd><i>地址：</i><input type="text" name="site_address" value="<?php echo $website['site_address']; ?>"></dd>
                    <dd><i>手机号：</i><input type="text" name="site_mobile" value="<?php echo $website['site_mobile']; ?>"></dd>
                    <dd><div style="float:left"><i>微博二维码：</i>
                            <div style="margin-left:140px">
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                            <input type="hidden" name="site_weibo" id="headimg" value="<?php echo $website['site_weibo']; ?>">
                            <img width="200" height="200" src="<?php echo $website['site_weibo']; ?>" id="imghead" />
                            </div>
                        </div>
                        <div style="float:left">
                        <i>微信服务号：</i>
                        <div style="margin-left:140px">
                            <input id="file_upload2" name="file_upload" type="file" multiple="true">
                            <input type="hidden" name="site_wechat1" id="headimg" value="<?php echo $website['site_wechat1']; ?>">
                            <img width="200" height="200" src="<?php echo $website['site_wechat1']; ?>" id="imghead" />
                        </div>
                            </div>
                        <div style="float:left">
                            <i>微信订阅号：</i>
                            <div style="margin-left:140px">
                                <input id="file_upload3" name="file_upload" type="file" multiple="true">
                                <input type="hidden" name="site_wechat2" id="headimg" value="<?php echo $website['site_wechat2']; ?>">
                                <img width="200" height="200" src="<?php echo $website['site_wechat2']; ?>" id="imghead" />
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        </dd>
                    <dd><i>网站开关：</i>
                        <input type="radio" name="site_status" value="1" <?php if ($website['site_status'] == 1) echo 'checked="checked"'; ?>/><label>开启</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="site_status" value="0" <?php if ($website['site_status'] == 0) echo 'checked="checked"'; ?>/><label>关闭</label>
                    </dd>
                    <dd>
                    </dd>
                </dl>
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
                $('#headimg').val(data);
                $('#imghead').attr('src',data);
            }
        });
    });
    $(function() {
        $('#file_upload3').uploadify({
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

    $('#save').bind('click', function(){

        $.ajax({
            url:"/hzzadmin/systems/websiteUpdate",
            data:$("#datares").serialize(),
            type:"post",
            success:function(data){//ajax返回的数据
                if (data.status=='false')
                {
                    if (data.code == '869'){
                        $('#token').val(data.token);
                    }
                } else  {
                    layer.msg('修改成功');
                }
            }
        });
    })
</script>