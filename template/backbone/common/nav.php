<?php
if ($slidertagAuth != false) {
?>
<link rel="stylesheet" href="/asset/adminasset/css/users.css">
<div class="sidebar_2">
    <div class="sidebar_2_box">
        <h4>权限管理</h4>
        <ul>
            <?php
                foreach ($slidertagAuth as $key=>$value){
                    if (strpos($value['nodeurl'], $nav_tag) !== false){
                        echo '<li class="midsidebar_list on"><a href="/',$value['nodeurl'],'">',$value['nodename'],'</a></li>';
                    } else {
                        echo '<li class="midsidebar_list "><a href="/',$value['nodeurl'],'">',$value['nodename'],'</a></li>';
                    }
                }
            ?>
</ul>
</div>
<div class="switchIcon"><i class="fa fa-angle-double-left"></i></div>
<div class="switchIcon2"><i class="fa fa-angle-double-right"></i></div>
</div>
<?php
}
?>