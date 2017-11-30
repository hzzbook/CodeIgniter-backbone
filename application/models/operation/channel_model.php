<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/30
 * 
 */

class channel_model extends Temp_model
{
    var $table = 'operation_channels';

    var $itemKey = array(
        'id' => array(
            'filed' => 'id'
        ),
        'sn' => array(
            'filed' => 'sn'
        )
    );

}