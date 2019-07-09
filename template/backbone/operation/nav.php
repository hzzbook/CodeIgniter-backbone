<link rel="stylesheet" href="/asset/adminasset/css/users.css">
<div class="sidebar_2">
    <div class="sidebar_2_box">
        <h4>运营管理</h4>
        <ul>
            <li class="midsidebar_list <?php if(!isset($nav_tag) || $nav_tag == 'index') echo "on"; ?>"><a href="/b_operation_index.html">用户列表</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'sms') echo "on"; ?>"><a href="/b_operation_sms.html">短信验证码</a></li>
            <li class="midsidebar_list  <?php if(isset($nav_tag) && $nav_tag == 'postemail') echo "on"; ?>"><a href="/b_operation_postemail.html">邮件推送</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'postmsg') echo "on"; ?>"><a href="/b_operation_postmsg.html">信息推送</a></li>
        </ul>
    </div>
    <div class="switchIcon"><i class="fa fa-angle-double-left"></i></div>
    <div class="switchIcon2"><i class="fa fa-angle-double-right"></i></div>
</div>