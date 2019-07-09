<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2018/3/22
 * 
 */
class upload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    #上传文件接口
    public function uploader()
    {
        $config['upload_path'] = './public/uploads/';   //注意：此路劲是相对于CI框架中的根目录下的目录
        $config['allowed_types'] = 'gif|jpg|png';    //设置上传的图片格式
        $config['max_size'] = '5000';              //设置上传图片的文件最大值
        $config['max_width']  = '1200';            //设置图片的最大宽度
        $config['max_height']  = '1200';
        $this->load->library('upload', $config);   //加载CI中的图片上传类，并递交设置的各参数值
        //$filename = $_POST['Filename']
        if ($this->upload->do_upload('Filedata'))
        {
            $arr = $this->upload->data();     //此函数是返回图片上传成功后的信息
            $data['code']   = 1;
            $data['src']  ="/public/uploads/".$arr['orig_name'];
        } else {
            $data = array(
                'code' => 0,
                'info' => $this->upload->display_errors()
            );
            /*$data = array(
                'status' => 'false',
                'code'   => '400',
                'info'   => '失败'
            );*/
        }
        echo json_encode($data);
    }

    #单图上传
    public function singlePic()
    {
        $this->load->view('tutorial/singlePic');
    }

    #多图上传
    public function multiPic()
    {
        $this->load->view('tutorial/multiPic');
    }

    #删除图片
    public function deletePic()
    {

    }


}