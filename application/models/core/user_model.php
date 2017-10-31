<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/10/31
 * 
 */
class user_model extends Temp_model
{
    var $table = 'users';

    var $itemKey = array(
        'id' => array(
            'filed' => 'id'
        ),
        'username' => array(
            'filed' => 'username'
        ),
        'email' => array(
            'filed' => 'email'
        ),
        'mobile' => array(
            'filed' => 'mobile'
        ),
        'idcard' => array(
            'filed' => 'idcard'
        ),
    );

    #注册加密密码
    public function encrypt($password, $salt)
    {
        return md5(md5($password . $salt).'I~@j');
    }

    public function checkPassword($password, $userInfo)
    {
        $check = $this->encrypt($password, $userInfo['salt']);

        if ($check == $userInfo['password'])
        {
            return TRUE;    #通过验证
        } else {
            return FALSE;   #未通过验证
        }
    }

    #用户登录
    public function login($userid, $loginData)
    {
        $loginData['logtime'] = date('Y-m-d H:i:s');   #最近登录时间
        return $this->updateuser($userid, $loginData);
    }

    #用户注册
    public function register($input)
    {
        $input['salt'] = $this->getSalt();
        $input['regtime'] = date('Y-m-d H:i:s'); #注册时间
        $input['password'] = $this->encrypt($input['password'], $input['salt']);
        return $this->itemAdd($input);
    }

    protected function getSalt($length = 4){
        $str = '';
        $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($string)-1;

        for($i=0;$i<$length;$i++){
            $str.=$string[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }



}