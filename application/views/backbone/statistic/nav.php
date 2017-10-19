<link rel="stylesheet" href="/adminasset/css/users.css">
<div class="sidebar_2">
    <div class="sidebar_2_box">
        <h4>统计分析</h4>
        <ul>
            <li class="midsidebar_list <?php if(!isset($nav_tag) || $nav_tag == 'index') echo "on"; ?>"><a href="/b_statistic_index.html">总体统计</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'user') echo "on"; ?>"><a href="/b_statistic_user.html">用户统计</a></li>
            <li class="midsidebar_list  <?php if(isset($nav_tag) && $nav_tag == 'booking') echo "on"; ?>"><a href="/b_statistic_booking.html">订单统计</a></li>
        </ul>
    </div>
    <div class="switchIcon"><i class="fa fa-angle-double-left"></i></div>
    <div class="switchIcon2"><i class="fa fa-angle-double-right"></i></div>
</div>