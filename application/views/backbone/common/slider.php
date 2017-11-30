<div class="mainBody clearfix">

    <div class="sidebar fl clearfix">
        <div class="sidebarIcon"><i class="fa fa-plus"></i></div>
    <div class="mainSidebar">
    <ul>
        <li class="sidebar_list">
            <a href="#" class="list_title"><i class="fa fa-caret-down"></i> <span>后台管理</span></a>
            <ul class="secondNav">
                <?php
                    foreach ($sliderAuth as $key => $value) {
                        if ($value['cont'] == $slider_tag) {
                            if (isset($value['submenu'])) {
                                $submenu = $value['submenu'];
                                $slidername = $value['node_name'];
                            }
                           echo ' <li class="sidebar_list_2 on">
                            <a href="/',$value['node_url'],'"><i class="fa fa-',$value['node_icon'],'"></i> <span>',$value['node_name'],'</span></a></li>';
                        } else {
                            echo '<li class="sidebar_list_2 ">
                            <a href="/',$value['node_url'],'"><i class="fa fa-',$value['node_icon'],'"></i> <span>',$value['node_name'],'</span></a></li>';
                        }
                        ?>
                    <?php
                    }
                ?>
            </ul>
        </li>
    </ul>
    </div>
    </div>
    <?php
    if (isset($submenu) && $submenu !='') {
        ?>
    <div class="sidebar_2">
        <div class="sidebar_2_box">
            <h4><?php echo $slidername; ?></h4>
            <ul>
                    <?php
                    foreach ($submenu as $key => $value) {
                        if ($value['func'] == $nav_tag) {

                            echo '<li class="midsidebar_list on"><a href="/'.$value['node_url'].'">
                                    <span>'.$value['node_name'].'</span></a></li>';
                        } else {
                            echo '<li class="midsidebar_list"><a href="/'.$value['node_url'].'">
                                    <span>'.$value['node_name'].'</span></a></li>';
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