<link rel="stylesheet" href="/asset/adminasset/css/users.css">
<div class="sidebar_2">
    <div class="sidebar_2_box">
        <h4>系统管理</h4>
        <ul>
            <li class="midsidebar_list <?php if(!isset($nav_tag) || $nav_tag == 'index') echo "on"; ?>"><a href="/b_systems_index.html">系统信息</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'admin') echo "on"; ?>"><a href="/b_systems_adminpage.html">管理员列表</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'service') echo "on"; ?>"><a href="/b_systems_servicePage.html">在线客服</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'pay') echo "on"; ?>"><a href="/b_systems_payPage.html">支付通道</a></li>
        </ul>
    </div>
    <div class="switchIcon"><i class="fa fa-angle-double-left"></i></div>
    <div class="switchIcon2"><i class="fa fa-angle-double-right"></i></div>
</div>