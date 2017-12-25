<?php


?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>起始</title>
    </head>
<body>
品牌：<a href="/start?brand=nick">耐克</a>
<a href="/start?brand=real">real</a>
<a href="/start?brand=nb">nb</a>
<a href="/start?brand=234">安踏</a>
<hr>
价格：<a href="/start?price=type1">100-400</a>
<a href="/start?price=type2">400-800</a>
<a href="/start?price=type3">800-2500</a>
<a href="/start?price=type4">>2500</a>
<hr>
<?php
    if ($pro_lists['status'] != 'false'){
        foreach ($pro_lists['data'] as $key => $value) {
            ?>
            <li>
        <?php echo $value['title']; ?>
        <?php echo $value['price']; ?>
        <?php echo $value['brand']; ?>
        <?php echo $value['logtime']; ?>
        </li>
<?php
        }
    }
?>


<?php echo $pagestring; ?>
</body>
</html>