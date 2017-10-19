<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo $title;?></title>
    <meta charset="utf-8" >
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="description" content="<?php echo $description; ?>">
    <link href="/asset/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<style>

    .act {
        font-size: 16px;
        color:#f00;
    }
    header ul{
        list-style: none;
    }
    header ul li{
        float:left;
        display: inline-block;
        margin: 10px;
        padding: 5px;
    }
</style>
<header style="margin-bottom: 50px;">
    <div>
    <ul>
        <li><a href="/" <?php if(!isset($nav_key) || $nav_key =='' || $nav_key=='index') echo ' class="act"';?>>首页</a></li>
        <li><a href="/products.html" <?php if(isset($nav_key) && $nav_key =='product') echo ' class="act"';?>>产品页</a></li>
        <li><a href="/aboutus.html" <?php if(isset($nav_key) && $nav_key =='aboutus' ) echo ' class="act"';?>>关于我们</a></li>
        <li><a href="/news.html" <?php if(isset($nav_key) && $nav_key =='news' ) echo ' class="act"';?>>新闻动态</a></li>
    </ul>
    </div>
</header>