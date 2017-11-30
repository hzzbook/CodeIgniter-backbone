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
    <h4 class="cont_title"><span>编辑数据<a href="/b_cms_index.html" class="button">返回</a></span></h4>
    <div class="row" style="margin-top:20px;padding-bottom: 40px">
        <form id="datares" method="post" class="form-horizontal">
            <input type="hidden" name="token" value="<?php echo $token; ?>" >
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" >
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">权限结点名称：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="node_name" placeholder="名称" name="node_name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">父结点：</label>
                <div class="col-sm-10">
                    <select class="form-select" name="p_id" id="cate">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">结点类型：</label>
                <div class="col-sm-10">
                    <select class="form-select" name="node_type" id="node_type">
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">结点图标：</label>
                <div class="col-sm-10">
                    <select class="form-select" name="node_icon" id="icon">
                        <option value="tag">tag</option>
                        <option value="space-shuttle">space-shuttle</option>
                        <option value="support">support</option>
                        <option value="tasks">tasks</option>
                        <option value="tachometer">tachometer</option>
                        <option value="trophy">trophy</option>
                        <option value="tree">tree</option>
                        <option value="empire">empire</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">结点排序：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="ordernum" name="ordernum"  placeholder="结点排序" value="50">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">结点地址：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="node_url" name="node_url"  placeholder="结点地址">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">控制器名：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="cont" name="cont"  placeholder="控制器名">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">方法名：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-large" id="func" name="func"  placeholder="方法名">
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
<script id="catelist" type="text/html">
    {{# for(var i = 0, len = d.length; i < len; i++){ }}
    {{# if (d.cateid == d[i].id) { }}
    <option selected="selected" value='{{d[i].id}}'>{{ d[i].node_name }}</option>
    {{# } else { }}
    <option value='{{d[i].id}}'>{{ d[i].node_name }}</option>
    {{# } }}

    {{# } }}
</script>
<script>
    function getcategory(cateid) {
        $.post('/hzzadmin/<?php echo $slider_tag;?>/nodeLevel', {
            },
            function (res) {
                res.cateid = cateid;
                var gettpl = document.getElementById('catelist').innerHTML;
                laytpl(gettpl).render(res, function (html) {
                    document.getElementById('cate').innerHTML = html;
                });
            }, 'json');
    }
    function gettype($id) {
        var jsonObj = {data:[{id:'1', name: '菜单'}, {id:'2', name: '动作'}, {id:'3', name: '页面'}, {id:'9', name: '其他'}]};
        html = '';
        for (var i=0; i < jsonObj.data.length; i++) {
            if ($id == jsonObj.data[i].id) {
                html += '<option value="'+jsonObj.data[i].id+'" selected="selected">'+jsonObj.data[i].name+'</option>';
            } else {
                html += '<option value="' + jsonObj.data[i].id + '">' + jsonObj.data[i].name + '</option>';
            }
        }
        $('#node_type').html(html);
    }
    function article() {
        $.post('/hzzadmin/<?echo $slider_tag;?>/node', {
                id: $('#id').val()
            },
            function (res) {
                if (res.status != 'false') {
                    $('#node_name').val(res.data.node_name);
                    $('#node_url').val(res.data.node_url);
                    $('#cont').val(res.data.cont);
                    $('#func').val(res.data.func);
                    $('#ordernum').val(res.data.ordernum);
                    getcategory(res.data.p_id);
                    gettype(res.data.node_type);
                }
            }, 'json');
    }
    article();
    $('#save').bind('click', function(){
        $.ajax({
            url:"/hzzadmin/<?echo $slider_tag;?>/nodeUpdate",
            data:$("#datares").serialize(),
            type:"post",
            success:function(data){//ajax返回的数据
                if (data.status=='false')
                {
                    if (data.code == '869'){
                        $('#token').val(data.token);
                    }
                } else  {
                    layer.msg('数据修改成功');
                    window.location.href = '/b_<?echo $slider_tag;?>_nodesPage.html';
                }
            }
        });
    })

</script>

