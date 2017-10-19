<link rel="stylesheet" href="/adminasset/css/user_return.css">

<div class="mainWrap">
    <h4 class="cont_title"><span>授权页面<a href="javascript:void(0)" id="backbtn" class="button">返回</a></span></h4>

    <div class="return_box">
        <form id="datares" method="post">
            <input type="hidden" name="id" value="<?php echo $id;?>" />
        <table class="table table-bordered">
            <tr><th width="150">主菜单</th><th>结点</th></tr>
            <?php

                foreach ($nodelist as $key=> $value) {
                    if ($value['p_id'] == 0) {
                        ?>
                        <tr>
                            <td class="main"><input class="mainbtn" type="checkbox" <?php if(in_array($value['id'], $roleNode)){ echo 'checked="checked"';} ?> name="node[]" value="<?php echo $value['id']; ?>"><label><?php echo $value['node_name']; ?></label></td><td class="second">
                            <?php
                                if (isset($value['submenu']) && $value['submenu'] !='') {
                                    foreach ($value['submenu'] as $k => $v) {
                                        if(in_array($v['id'], $roleNode)) {
                                            echo "<input class='childbtn' type='checkbox' checked='checked' name='node[]' value='{$v['id']}'><label>{$v['node_name']}</label>&nbsp;&nbsp;&nbsp;&nbsp;";
                                        } else {
                                            echo "<input class='childbtn' type='checkbox' name='node[]' value='{$v['id']}'><label>{$v['node_name']}</label>&nbsp;&nbsp;&nbsp;&nbsp;";
                                        }
                                    }
                                }
                            ?>
                            </td>
                        </tr>
                    <?php
                    }
                }
            ?>
        </table>
            <input type="submit" id="save" value="修改">
        </form>
    </div>
</div>
</div>
<script src="/adminasset/vendor/laypage/laypage.js"></script>
<script src="/adminasset/vendor/laytpl.js"></script>
<script src="/adminasset/js/layer/layer.js"></script>
<script>
    $('#save').bind('click', function(){

        $.ajax({
            url:"/hzzadmin/permission/authorize",
            data:$("#datares").serialize(),
            type:"post",
            success:function(data){//ajax返回的数据
                if (data.status !='false')
                {
                    layer.msg('修改成功');
                    window.history.back(-1);
                }
            }
        });
    })


    /*$("input.mainbtn").bind("click", function(){
        $child = $(this).parent().next();
        if($(this).attr("checked")){    //删除
            console.log('取消');
            $child.find('input').each(function(){
                $(this).attr('checked',false);
            })
            $(this).attr('checked',false);
        } else {    //选中
            console.log('选中');
            $child.find('input').each(function(){
                $(this).prop('checked',true);
                //$(this).attr('checked',true);
            })
            $(this).attr('checked',true);
        }

    });

    //判断父节点是否选中
    function isPchecked($this){
        $pnode = $this.parent().prev().find('input');
        if($pnode.attr('checked'))
            return true;
        else
            return false;
    }
    //判读兄弟结点是否选中
    function isAllchecked($this){
        $key = false;
        $this.siblings('input').each(function(){
            if($(this).attr('checked')){
                $key = true;
            }
        })
        return $key;
    }

    //判读自己是否选中
    function ischecked($this){
        if($this.attr('checked')){
            return true;
        }
        else
            return false;
    }

    $('input.childbtn').bind('click',function(){
        $pnode = $(this).parent().prev().find('input');

        if(isAllchecked($(this)) || ischecked($(this)) ){
            console.log('取消');
            if(!isPchecked($(this))){
                $pnode.attr('checked',true);
            }
        } else {
            if(isPchecked($(this))){
                console.log('选中');
                $pnode.attr('checked',false);
            }
        }
    });*/



    $('#backbtn').bind('click', function(){
        window.history.back(-1);
    })
</script>
