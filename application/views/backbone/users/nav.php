<link rel="stylesheet" href="/adminasset/css/users.css">
<div class="sidebar_2">
    <div class="sidebar_2_box">
        <h4>用户管理</h4>
        <ul>
            <li class="midsidebar_list <?php if(!isset($nav_tag) || $nav_tag == 'index') echo "on"; ?>"><a href="/b_users_index.html">用户列表</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'info') echo "on"; ?>"><a href="/b_users_info.html">用户信息</a></li>
            <li class="midsidebar_list  <?php if(isset($nav_tag) && $nav_tag == 'realauth') echo "on"; ?>"><a href="/b_users_realauth.html">实名认证审核</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'bankcard') echo "on"; ?>"><a href="/b_users_bankcard.html">银行卡审核</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'blacklist') echo "on"; ?>"><a href="/b_users_blacklist.html">小黑屋</a></li>
        </ul>
    </div>
    <div class="switchIcon"><i class="fa fa-angle-double-left"></i></div>
    <div class="switchIcon2"><i class="fa fa-angle-double-right"></i></div>
</div>