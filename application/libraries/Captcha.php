<?php
/**
 * 验证码类
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/8/14
 * 
 */
class Captcha
{
    private $charset = 'abcdefghijkmnprstuvwxyzABCDEFGHIJKMNPRSTUVWXYZ123456789';//随机因子
    private $code;//验证码
    private $codelen = 4;//验证码长度
    private $width = 130;//宽度
    private $height = 50;//高度
    private $img;//图形资源句柄
    private $font;//指定的字体
    private $fontsize = 20;//指定字体大小
    private $fontcolor;//指定字体颜色
    private $sence = 'de'; //图形验证码使用的场景
    //构造方法初始化
    public function __construct() {
        $this->font = dirname(__FILE__).'/fonts/arial.ttf';//注意字体路径要写对，否则显示不了图片
    }

    public function setSence($sence)
    {
        $this->sence = $sence;
    }

    public function setSite($width = 130, $height = 50)
    {
        $this->width = $width;
        $this->height = $height;
    }

    //生成随机码
    public function createCode() {
        $_len = strlen($this->charset)-1;
        for ($i=0;$i<$this->codelen;$i++) {
            $this->code .= $this->charset[mt_rand(0,$_len)];
        }
    }
    //生成背景
    private function createBg() {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
        imagefilledrectangle($this->img,0,$this->height,$this->width,0,$color);
    }
    //生成文字
    private function createFont() {
        $_x = $this->width / $this->codelen;
        for ($i=0;$i<$this->codelen;$i++) {
            $this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imagettftext($this->img,$this->fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->height / 1.4,$this->fontcolor,$this->font,$this->code[$i]);
        }
    }
    //生成线条、雪花
    private function createLine() {
        //线条
        for ($i=0;$i<6;$i++) {
            $color = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
        //雪花
        for ($i=0;$i<100;$i++) {
            $color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
            imagestring($this->img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'*',$color);
        }
    }
    //输出
    private function outPut() {
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }
    //对外生成
    public function doimg() {
        $this->createBg();
        $this->createCode();
        $this->makeSession();
        $this->createLine();
        $this->createFont();
        $this->outPut();
    }

    //获取验证码
    public function getCode() {
        return strtolower($this->code);
    }

    public function create()
    {
        $this->doimg();
    }

    public function makeSession()
    {
        $ci =& get_instance();
        $data = array(
            $this->sence.'_'.'captcha_code' => $this->getCode()
        );
        $ci->session->set_userdata( $this->sence.'_'.'captcha_code', $this->getCode());
    }

    public function checkCode($code, $sence = null)
    {
        if ($sence == '')
            $this->sence = 'de';
        else
            $this->sence = $sence;
        $ci =& get_instance();
        $cap_code = $ci->session->userdata($this->sence.'_'.'captcha_code');

        $ci->session->set_userdata($this->sence.'_'.'captcha_code', '');
        if (strtolower($code) == $cap_code) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}