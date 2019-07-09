<link rel="stylesheet" href="/asset/adminasset/css/users.css">
<div class="sidebar_2">
    <div class="sidebar_2_box">
        <h4>内容管理</h4>
        <ul>
            <li class="midsidebar_list <?php if(!isset($nav_tag) || $nav_tag == 'index') echo "on"; ?>"><a href="/b_cms_index.html">文章列表</a></li>
           <!-- <li class="midsidebar_list <?php /*if(isset($nav_tag) && $nav_tag == 'add') echo "on"; */?>"><a href="/b_cms_add.html">添加文章</a></li>-->
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'category') echo "on"; ?>"><a href="/b_cms_categorypage.html">文章分类</a></li>
            <!--<li class="midsidebar_list <?php /*if(isset($nav_tag) && $nav_tag == 'addcategory') echo "on"; */?>"><a href="/b_cms_addcategory.html">添加文章分类</a></li>-->
            <li class="midsidebar_list  <?php if(isset($nav_tag) && $nav_tag == 'images') echo "on"; ?>"><a href="/b_cms_imagespage.html">图片管理</a></li>
            <!--<li class="midsidebar_list  <?php /*if(isset($nav_tag) && $nav_tag == 'addimage') echo "on"; */?>"><a href="/b_cms_addimage.html">添加图片</a></li>
         -->   <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'content') echo "on"; ?>"><a href="/b_cms_contentpage.html">内容片段</a></li>
            <!--<li class="midsidebar_list <?php /*if(isset($nav_tag) && $nav_tag == 'addcontent') echo "on"; */?>"><a href="/b_cms_addcontent.html">添加内容片段</a></li>
           --> <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'banner') echo "on"; ?>"><a href="/b_cms_bannerpage.html">轮播</a></li>
            <li class="midsidebar_list <?php if(isset($nav_tag) && $nav_tag == 'friendlink') echo "on"; ?>"><a href="/b_cms_friendlinkpage.html">友情链接</a></li>
           <!-- <li class="midsidebar_list <?php /*if(isset($nav_tag) && $nav_tag == 'addbanner') echo "on"; */?>"><a href="/b_cms_addbanner.html">添加轮播</a></li>
    -->    </ul>
    </div>
    <div class="switchIcon"><i class="fa fa-angle-double-left"></i></div>
    <div class="switchIcon2"><i class="fa fa-angle-double-right"></i></div>
</div>