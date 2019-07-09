<div style="clear:both">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?php
                echo "<h3>获取轮播</h3>";
                var_dump($banner_filter);

                ?>
            </div>
            <div class="col-md-8">
                <?php
                var_dump($banner);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php
                echo "<h3>获取友情链接</h3>";
                var_dump($friendly_filter);

                ?>
            </div>
            <div class="col-md-8">
                <?php
                var_dump($friendly);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?php
                echo "<h3>两条分类id为1的两条数据</h3>";
                var_dump($cateid1_filter);

                ?>
            </div>
            <div class="col-md-8">
                <?php
                var_dump($cateid1);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?php
                echo "<h3>两条分类id为2的两条数据</h3>";
                var_dump($cateid2_filter);

                ?>
            </div>
            <div class="col-md-8">
                <?php
                var_dump($cateid2);
                ?>
            </div>
        </div>
    </div>

</div>