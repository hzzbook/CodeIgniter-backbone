<!DOCTYPE HTML>
<html>
<head>
    <title>登录</title>
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=XXXX" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="1014415012" data-redirecturi="http://www.v4.com/" charset="utf-8"></script>
</head>
<body>
<div>
<form action="/welcome/loginDo" method="POST">
    <label>用户名：</label><input name="username" type="text"><br/>
    <label>密码：</label><input name="password" type="password"> <br/>
    <input  type="submit" value="登录"> <br/>
    <div id="wb_connect_btn"></div> <span id="qqLoginBtn"></span>
    <script>
        WB2.anyWhere(function (W) {
            W.widget.connectButton({
                id: "wb_connect_btn",
                type: '3,2',
                callback: {
                    login: function (o) { //登录后的回调函数
                        alert("login: " + o.screen_name)
                    },
                    logout: function () { //退出后的回调函数
                        alert('logout');
                    }
                }
            });
        });
        QC.Login({
            btnId:"qqLoginBtn"    //插入按钮的节点id
        });
    </script>

</form>
</div>
</body>
</html>