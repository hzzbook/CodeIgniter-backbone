<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php if (isset($title) && $title !='')echo $title;else echo "后台管理系统" ?></title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="/asset/adminasset/css/bootstrap.min.css">
    <link rel="stylesheet" href="/asset/adminasset/css/global.css">
    <link rel="stylesheet" href="/asset/adminasset/css/index.css">
    <link rel="stylesheet" href="/asset/adminasset/css/font-awesome.min.css">
    <script src="/asset/adminasset/js/jquery-1.11.3.min.js"></script>
</head>

<body>
<div class="header clearfix">
    <div class="left_header fl">
        <div class="fl"><a href="/hzzadmin/backbone" class="logoIco"><i class="ico"></i></a></div>
        <div class="console fl"><a href="/hzzadmin/backbone" class="topbar_btn">管理控制台</a></div>
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
            <li class="headerNav">
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
            </li>
        </ul>
    </div>
</div>