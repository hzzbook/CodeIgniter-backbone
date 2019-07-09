<html>
<head>
    <title>上传图片</title>
    <link href="/asset/uploadify/uploadify.css" type="text/css" rel="stylesheet">
    <script src="/asset/jquery.min.js" type="text/javascript"></script>
    <script src="/asset/uploadify/jquery.uploadify.js" type="text/javascript"></script>
</head>

<style>
    .uploadify-button {
        cursor: pointer;
        background: url(/asset/uploadify/add_platform.png);
        background-position: center top;
        background-repeat: no-repeat;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 0px;
        border: 0px solid #808080;
        color: #FFF;
        font: bold 12px Arial, Helvetica, sans-serif;
        text-align: center;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
        width: 100%;

    }
    .uploadify-queue {
        display: none;
    }
    .zhezhao {
        background: #000;
        opacity: 0.6;
        position: absolute;
        height: 120px;
        width: 120px;
        top: 0;
        z-index: 999;
        display: none;
        cursor: pointer;
    }
    .pull-right {
        float: right!important;
    }
    img {
        vertical-align: middle;
    }
</style>
<body>
<div class="pic-area">
    <input type="file" name="userfile"  class="form-control" id="tutorHeadPortrait"/>
</div>

<script>
    var eObj = {jqObj:"",url:""};
    $("#tutorHeadPortrait").uploadify({
        height:100,
        uploader: '/tutorial/upload/uploader',
        swf: '/asset/uploadify/uploadify.swf',
        width:100,
        cancelImg:'/asset/uploadify/uploadify-cancel.png',
        buttonText: '',
        fileTypeExts: '*.jpg;*.png',
        'fileSizeLimit': '3000KB',
        uploadLimit: 0,
        requeueErrors : true,
        removeTimeout: 1,

        onUploadSuccess: function (file, data, response) {//上传完成时触发（每个文件触发一次）
            var json = JSON.parse(data);
            if (json.code == 1) {
                // alert(json);
                eObj.jqObj = $("#tutorHeadPortrait");
                eObj.url = json.src;
                //console.log(eObj.url);
                $("#tutorHeadPortrait").val(eObj.url);
                setTimeout("showImg(eObj)", 1000);
                // $("#previewEImage").attr("src", data.url).hide().fadeIn(2000);
            }else {
                alert(data.info);
            }
        },
        'onUploadError': function (file, errorCode, errorMsg, errorString) {//当单个文件上传出错时触发
            alert('文件：' + file.name + ' 上传失败: ' + errorString);
        }
    });
    //显示图片
    function showImg(obj){
        obj.jqObj.children().hide();
        var $icon = $("<img src="+obj.url+" class='pic'>");
        $icon.attr({style: "width:120px; height:120px;"});
        obj.jqObj.parents(".pic-area").append("<div class=zhezhao><a class=\"pull-right delete-pic\"><img src=\"/asset/uploadify/close_u.png\"/>"+"</a></div>");
        obj.jqObj.parents(".pic-area").hover(function(){
            $(this).children(".zhezhao").fadeIn();
        },function(){
            $(this).children(".zhezhao").fadeOut();
        });
        obj.jqObj.append($icon);
    }

    //点击照片删除照片重新上传
    $(".pic-area").on("click",".delete-pic",function(){
        ;
        var $parents=$(this).parents(".pic-area");
        $parents.children(":eq(0)").find("img.pic").remove();
        $parents.children(".zhezhao").remove();
        $parents.children().children().show();

    });
</script>

</body>
</html>