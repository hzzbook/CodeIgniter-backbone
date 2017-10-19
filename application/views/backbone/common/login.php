<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>飞年管理后台</title>
    <link rel="stylesheet" type="text/css" href="/adminasset/style2.0.css">
    <style type="text/css">
        ul li{font-size: 30px;color:#2ec0f6;}
        .tyg-div{z-index:-1000;float:left;position:absolute;left:5%;top:20%;}
        .tyg-p{
            font-size: 14px;
            font-family: 'microsoft yahei';
            position: absolute;
            top: 135px;
            left: 60px;
        }
        .tyg-div-denglv{
            z-index:1000;float:right;position:absolute;right:35%;top:10%;
        }
        .tyg-div-form{
            background-color: #23305a;
            width:300px;
            height:auto;
            margin:120px auto 0 auto;
            color:#2ec0f6;
        }
        .tyg-div-form form {padding:10px;}
        .tyg-div-form form input{
            width: 270px;
            height: 30px;
            margin: 25px 10px 0px 0px;
        }
        .tyg-div-form form a {
            display: inline-block;
            cursor: pointer;
            width: 270px;
            height: 24px;
            margin-top: 15px;
            padding-top: 10px;
            background: #2ec0f6;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
            border: 1px solid #2ec0f6;
            -moz-box-shadow:
            0 15px 30px 0 rgba(255,255,255,.25) inset,
            0 2px 7px 0 rgba(0,0,0,.2);
            -webkit-box-shadow:
            0 15px 30px 0 rgba(255,255,255,.25) inset,
            0 2px 7px 0 rgba(0,0,0,.2);
            box-shadow:
            0 15px 30px 0 rgba(255,255,255,.25) inset,
            0 2px 7px 0 rgba(0,0,0,.2);
            font-family: 'PT Sans', Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0,0,0,.1);
            -o-transition: all .2s;
            -moz-transition: all .2s;
            -webkit-transition: all .2s;
            -ms-transition: all .2s;
        }
    </style>
</head><body>
<div id="contPar" class="contPar">
    <div id="page1" style="z-index: 1; height: 943px;" class="cont_1">
        <div class="title0"></div>
        <div class="title1"></div>
    </div>
</div>
<div class="tyg-div-denglv">
    <div class="tyg-div-form">
        <form action="" id="datares">
            <input type="hidden" name="token" id="token" value="<?php echo $token;?>" >
            <h2>登录</h2><p class="tyg-p"></p>
            <div style="text-align: center;color:#FF6666"><p id="errorinfo"></p></div>
            <div style="margin:5px 0px;">
                <input type="text" name="username" placeholder="请输入账号...">
            </div>
            <div style="margin:5px 0px;">
                <input type="password" name="password" placeholder="请输入密码...">
            </div>
            <div style="margin:5px 0px;">
                <input type="text" name="captcha" style="width:150px;float: left;" placeholder="请输入验证码...">
                <!--<img src="#" id="captcha" style="vertical-align:bottom;" alt="验证码">-->
                <div id="captcha" style="float: right;margin: 25px 10px 0px 0px;"></div>
            </div>
            <a type="submit" id="login" href="javascript:void(0)" style="text-align: center">登<span style="width:20px;"></span>录</a>
        </form>
    </div>
</div>


<script type="text/javascript" src="/adminasset/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/adminasset/com.js"></script>

<script>
    function getCaptcha()
    {
        var date = new Date();
        src = '<img src="/hzzadmin/admin/makeCaptcha?v='+date.getMilliseconds()+ '" />';
        $('#captcha').html(src);
    }
    getCaptcha();
    $('#captcha').bind('click',function(){
        getCaptcha();
    })
    $('#login').bind('click', function(){
        $.ajax({
            url:"/hzzadmin/admin/loginDo",
            data:$("#datares").serialize(),
            type:"post",
            dataType: 'json',
            success:function(data){//ajax返回的数据
                if (data.status == 'true') {
                    $('#errorinfo').html('登录成功');
                    window.location.href = '/backendin.html';
                } else {
                    $('#errorinfo').html(data.info);
                    $('#token').val(data.token);
                    getCaptcha();
                }
            }
        });
    })
    $(document).keydown(function(event){
        if(event.keyCode == 13){ //绑定回车
            $('#login').click(); //自动触发登录按钮
        }
    });
</script>
</body></html>

