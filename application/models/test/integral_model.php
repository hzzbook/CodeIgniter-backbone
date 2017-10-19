<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/9/27
 * 
 */
class integral_model extends Temp_model
{
    var $table = 'test_integral';

    var $where = array(
        'userid' => array(  #分类筛选
            'table' => '',
            'filed' => 'userid',
            'expression' => '='
        )
    );

    var $itemKey = array(
         'id' => array(
             'filed' => 'id'
         ),
         'userid' => array(
             'filed' => 'userid'
         ),
    );

    public function init($userid, $channel = 1)
    {
        $isOrdered = $this->item($userid, 'userid');

        if ($isOrdered['status'] == 'false' && $isOrdered['code'] == '404') {
            $addData = array(
                'userid' => $userid,
                'integral' => 0
            );
            $billData = array(
                'userid' => $userid,
                'tag' => 0,
                'integral' => 0,
                'addtime' => time(),
                'reason' => 'init',
                'remark' => '初始化积分帐号',
                'channel' => $channel
            );
            $this->itemAdd($addData);
            $this->add('test_integralbill', $billData);
            return true;
        } else {
            return false;
        }
    }

}