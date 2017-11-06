<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo $title; ?></title>
</head>
<body>
<ul>
<?php
    foreach ($lists as $key => $value) {
        ?>
        <li>
            <dt><label>标题：</label><?php echo $value['title']; ?></dt>
            <dd><label>价格：</label><?php echo $value['price']; ?></dd>
        </li>
    <?php
    }
?>
</ul>
</body>
</html>