<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php if (isset($title) && $title !='')echo $title;else echo "飞年管理系统" ?></title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="/adminasset/css/bootstrap.min.css">
    <link rel="stylesheet" href="/adminasset/css/global.css">
    <link rel="stylesheet" href="/adminasset/css/index.css">
    <link rel="stylesheet" href="/adminasset/css/font-awesome.min.css">
    <link rel="stylesheet" href="/adminasset/css/user_return.css">
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

    <script src="/adminasset/js/jquery-1.11.3.min.js"></script>
    <script charset="utf-8" src="/adminasset/uploadify/jquery.js"></script>
    <script src="/adminasset/uploadify/jquery.uploadify.js" type="text/javascript"></script>
    <script src="/adminasset/js/laydate/laydate.js"></script>
    <script charset="utf-8" src="/asset/ked/kindeditor.js"></script>
    <script src="/adminasset/js/common.js"></script>
    <script src="/adminasset/vendor/laypage/laypage.js"></script>
    <script src="/adminasset/vendor/laytpl.js"></script>
    <script src="/adminasset/js/layer/layer.js"></script>
</head>

<body>
<div class="header clearfix">
    <div class="left_header fl">
        <div class="fl"><a href="/hzzadmin/backbone" class="logoIco"><i class="ico"></i></a></div>
        <div class="console fl"><a href="/hzzadmin/backbone" class="topbar_btn">管理控制台</a></div>
        <!--<div class="product fl dropdown headerNav">
            <a href="#" class="topbar_btn dropdown-toggle" data-toggle="dropdown">产品与服务 <i class="fa fa-caret-down"></i></a>
            <div class="dropdown-menu dropdown-menu-diy productBox clearfix">
                <div class="listBox clearfix fl">
                    <ul>
                        <p>项目</p>
                        <li class="dropdownNav"><a href="#">子项目1</a></li>
                        <li class="dropdownNav"><a href="#">子项目2</a></li>
                        <li class="dropdownNav"><a href="#">子项目3</a></li>
                    </ul>
                    <ul>
                        <p>项目</p>
                        <li class="dropdownNav"><a href="#">子项目1</a></li>
                        <li class="dropdownNav"><a href="#">子项目2</a></li>
                        <li class="dropdownNav"><a href="#">子项目3</a></li>
                        <li class="dropdownNav"><a href="#">子项目4</a></li>
                    </ul>
                </div>
                <div class="listBox clearfix fl">
                    <ul>
                        <p>项目</p>
                        <li class="dropdownNav"><a href="#">子项目1</a></li>
                        <li class="dropdownNav"><a href="#">子项目2</a></li>
                        <li class="dropdownNav"><a href="#">子项目3</a></li>
                        <li class="dropdownNav"><a href="#">子项目4</a></li>
                        <li class="dropdownNav"><a href="#">子项目5</a></li>
                    </ul>
                    <ul>
                        <p>项目</p>
                        <li class="dropdownNav"><a href="#">子项目1</a></li>
                        <li class="dropdownNav"><a href="#">子项目2</a></li>
                        <li class="dropdownNav"><a href="#">子项目3</a></li>

                    </ul>
                </div>
                <div class="listBox clearfix fl">
                    <ul>
                        <p>项目</p>
                        <li class="dropdownNav"><a href="#">子项目1</a></li>
                        <li class="dropdownNav"><a href="#">子项目2</a></li>
                        <li class="dropdownNav"><a href="#">子项目3</a></li>
                    </ul>
                    <ul>
                        <p>项目</p>
                        <li class="dropdownNav"><a href="#">子项目1</a></li>
                        <li class="dropdownNav"><a href="#">子项目2</a></li>
                        <li class="dropdownNav"><a href="#">子项目3</a></li>
                        <li class="dropdownNav"><a href="#">子项目4</a></li>
                    </ul>
                </div>
                <div class="listBox clearfix fl">
                    <ul>
                        <p>项目</p>
                        <li class="dropdownNav"><a href="#">子项目1</a></li>
                        <li class="dropdownNav"><a href="#">子项目2</a></li>
                        <li class="dropdownNav"><a href="#">子项目3</a></li>
                    </ul>
                    <ul>
                        <p>项目</p>
                        <li class="dropdownNav"><a href="#">子项目1</a></li>
                        <li class="dropdownNav"><a href="#">子项目2</a></li>
                    </ul>
                </div>
            </div>
        </div>-->
    </div>
    <div class="right_header fr">
        <div class="right_headerIcon"><i class="fa fa-th-large"></i></div>
        <ul class="right_headerNav disNone">
            <li class="dropdown headerNav" style="margin-right:20px">
                <a href="#" class="topbar_btn userName dropdown-toggle" data-toggle="dropdown"> <?php echo $adminInfo['nick'] ?> <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu dropdown-menu-diy">
                    <li class="dropdownNav"><a href="/backreset.html">重置密码</a></li>
                    <li class="dropdownNav"><a href="/hzzadmin/admin/logout">退出</a></li>
                </ul>
            </li>
            <li class="dropdown headerNav">
                <a href="#" class="topbar_btn dropdown-toggle" data-toggle="dropdown">帮助与文档 <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu dropdown-menu-diy">
                    <li class="dropdownNav"><a href="">帮助与文档</a></li>
                    <li class="dropdownNav"><a href="#">论坛</a></li>
                </ul>
            </li>
            <!--<li class="headerNav">
                <a href="#" class="topbar_btn">备案</a>
            </li>
            <li class="dropdown headerNav">
                <a href="#" class="topbar_btn dropdown-toggle" data-toggle="dropdown">工单服务 <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu dropdown-menu-diy">
                    <li class="dropdownNav"><a href="#">我的工单</a></li>
                    <li class="dropdownNav"><a href="#">提交工单</a></li>
                </ul>
            </li>
            <li class="headerNav">
                <a href="#" class="topbar_btn">AccessKeys</a>
            </li>
            <li class="headerNav">
                <a href="#" class="topbar_btn"><i class="fa fa-bell-o"></i> <span class="messageNum">0</span></a>
            </li>
            <li class="headerNav phone">
                <a href="#" class="topbar_btn"><i class="fa fa-mobile"></i> 手机版</a>
                <div class="QRcode"></div>
            </li>
            <li class="headerNav">
                <a href="#" class="topbar_btn"><i class="fa fa-search"></i> 搜索</a>
            </li>-->
        </ul>

    </div>
</div>