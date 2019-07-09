<section style="clear:both;margin-top: 50px">
    <div>
        <ul>
            <li><a href="/aboutus.html" <?php if(!isset($aboutus_key) || $aboutus_key =='' || $aboutus_key=='index') echo ' class="act"';?>>公司简介</a></li>
            <li><a href="/aboutus_index_product.html" <?php if(isset($aboutus_key) && $aboutus_key =='product') echo ' class="act"';?>>联系方式</a></li>
            <li><a href="/aboutus_index_aboutus.html" <?php if(isset($aboutus_key) && $aboutus_key =='aboutus' ) echo ' class="act"';?>>招贤纳士</a></li>
        </ul>
    </div>
</section>