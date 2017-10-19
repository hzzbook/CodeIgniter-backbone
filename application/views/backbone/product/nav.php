<link rel="stylesheet" href="/adminasset/css/users.css">
<div class="sidebar_2">
    <div class="sidebar_2_box">
        <h4>产品管理</h4>
        <ul>
            <li class="midsidebar_list <?php if(!isset($nav_tag) || $nav_tag == 'index') echo "on"; ?>"><a href="/b_product_index.html">产品列表</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'cates') echo "on"; ?>"><a href="/b_product_cates.html">产品分类</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'book') echo "on"; ?>"><a href="/b_product_book.html">订单列表</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'ApiPage') echo "on"; ?>"><a href="/b_product_ApiPage.html">API列表</a></li>
        </ul>
    </div>
    <div class="switchIcon"><i class="fa fa-angle-double-left"></i></div>
    <div class="switchIcon2"><i class="fa fa-angle-double-right"></i></div>
</div>