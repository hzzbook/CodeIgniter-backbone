<link rel="stylesheet" href="/adminasset/css/users.css">
<div class="sidebar_2">
    <div class="sidebar_2_box">
        <h4>权限管理</h4>
        <ul>
            <li class="midsidebar_list <?php if(!isset($nav_tag) || $nav_tag == 'index') echo "on"; ?>"><a href="/b_permission_index.html">管理主页</a></li>
<li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'rolesPage') echo "on"; ?>"><a href="/b_permission_rolesPage.html">角色管理</a></li>
<li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'nodesPage') echo "on"; ?>"><a href="/b_permission_nodesPage.html">权限结点管理</a></li>
</ul>
</div>
<div class="switchIcon"><i class="fa fa-angle-double-left"></i></div>
<div class="switchIcon2"><i class="fa fa-angle-double-right"></i></div>
</div>