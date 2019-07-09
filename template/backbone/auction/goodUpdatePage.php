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
    <h4 class="cont_title"><span>编辑积分商品<a href="/b_auction_goodsPage.html" class="button">返回</a></span></h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" >
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">商品名称：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="title" name="name" placeholder="商品名称">
                </div>
            </div>
            <!--            <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">分类标识：</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-input-mid" id="sn" name="sn" placeholder="分类标记">
                            </div>
                        </div>-->
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">市场价格：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="market" name="market" >
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">价格：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="price" name="price" >
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">库存：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="stock" name="stock" >
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">积分数：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="credit" name="credit" >
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">商品类型：</label>
                <div class="col-sm-10">
                    <select name="type">
                        <option value="1">实体商品</option>
                        <option value="2">虚拟商品</option>
                        <option value="3">抽奖机会</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">描述：</label>
                <div class="col-sm-10">
                    <textarea class="form-textarea" name="descr" id="description"></textarea>
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
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            allowFileManager : true,
            width : '90%',
            height: '500px'
        });
    });
</script>
<script>
    /*   function getcategory(cateid) {
     $.post('/hzzadmin/auction/categorys', {
     },
     function (res) {
     res.cateid = cateid;
     var gettpl = document.getElementById('catelist').innerHTML;
     laytpl(gettpl).render(res, function (html) {
     document.getElementById('cate').innerHTML = html;
     });
     }, 'json');
     }*/
    function article() {
        $.post('/hzzadmin/auction/good', {
                id: $('#id').val()
            },
            function (res) {
                if (res.status != 'false') {
                    $('#title').val(res.data.name);
                    $('#market').val(res.data.market);
                    $('#price').val(res.data.price);
                    $('#stock').val(res.data.stock);
                    $('#credit').val(res.data.credit);
                    $('#headimg').val(res.data.cover);
                    $('#imghead').val(res.data.cover);
                    $('#description').html(res.data.descr);
                    editor.html(res.data.content);
                    // getcategory(res.data.cateid);
                }
            }, 'json');
    }
    article();
    $('#save').bind('click', function(){
        $('#content').val(editor.html());
        $.ajax({
            url:"/hzzadmin/auction/goodUpdate",
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
                    window.location.href = '/b_cms_index.html';
                }
            }
        });
    })

</script>
