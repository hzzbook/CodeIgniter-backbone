<?php


class MY_Controller extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
        /*$this->load->service('common/helper_service', NULL, 'helper');
        //下面这段为关闭CI超级对象中的数据库对象和数据库链接，db的对象Codeigniter.php中会关闭
        register_shutdown_function(function(){
            foreach(get_object_vars($this) as $key => $val) {
                if(substr($key, 0, 3) == 'db_' && is_object($this->{$key}) && method_exists($this->{$key}, 'close')) {
                    $this->{$key}->close();
                }
                if(substr($key, 0, 5) == 'conn_'  && is_resource($this->{$key})) {
                    $this->db->_close($val);
                    unset($this->{$key});
                }
            }
        });*/
        $this->is_install();
	}
	
	/**
	 * 
	 * 系统安装
	 * 
	 */
	public function is_install() {
		/*
		 *  判断是否存在安装目录及安装锁定文件
		 */
        $lockFile = FCPATH;
        if (!file_exists($lockFile.'/Install/install.lock')) {
            $url = 'http://'.$_SERVER['HTTP_HOST'];
            $content = file_get_contents(APPPATH.'/config/config.php');
            $content2 = str_replace('__URL__', $url, $content);
            file_put_contents(APPPATH.'/config/config.php', $content2);
			redirect($url.'/Install');
        }
	}
	
	public function display($view, $data) {
		
		$this->load->view('common/header', $data);
		$this->load->view($view, $data);
		$this->load->view('common/footer', $data);
	}
	
	private function getUrl() {
		$str = explode('?', $_SERVER["REQUEST_URI"]);
		return 'http://'.$_SERVER['SERVER_NAME'].$str[0];
	}
	
	public function getPageStr(){
		$get = $this->input->get();
		if (isset($get['page']))
			unset($get['page']);
		$arr = array();
		if ($get != false) {
			foreach ($get as $key=>$value) {
				$arr[] = $key.'='.$value;
			}
				
		}
	
		$str = $this->getUrl().'?'.implode($arr, '&');
		return $str;
	}

    protected function checkVar($input, $pattern)
    {
        $res  = false;
        if (!is_array($pattern)) {
            $res =  true;
        }
        else
        {
            foreach ($pattern as $key => $value)
            {
                if (!isset($input[$key]) || $input[$key] == '') {
                    $res =  false;
                }
            }
            if ($res != false)
                $res = true;
        }
        if ($res == false) {
            $back = array(
                'status' => 'false',
                'code' => '0005',
                'info' => urlencode("缺少必要参数数据")
            );
            echo urldecode(json_encode($back));
            exit;
        }
    }
	
}

class frontbase extends MY_Controller
{
    var $website;
    public function __construct()
    {
        parent::__construct();
        $this->website = $this->on_off();
    }

    /**
     * 网站维护开关
     */
    public function on_off() {
        /*
         * 判断系统数据库设置
         *
         * 维修期间，根据session['offid'] 如果存在
         */
        //$this->load->model('systems_model', 'sysmodel');
        $website = $this->website();

        if ($website['site_status'] == 0) {
            die('正在维护中。。。');
        } else {
            return $website;
        }
    }

    public function display($view, $data)
    {
        $website = $this->on_off();
        $data = array_merge($data, $website);
        $data['category'] = $this->category();
        $data['friend'] = $this->friend();
        $data['about'] = $this->about();
        if (!isset($data['title']) || $data['title'] == '')
            $data['title'] = $data['site_name'];
        else
            $data['title'] = $data['title'] .'|'. $data['site_name'];
        if (!isset($data['keyword']) || $data['keyword'] == '')
            $data['keyword'] = $data['site_keyword'];

        if (!isset($data['description']) || $data['description'] == '')
            $data['description'] = $data['site_description'];
        $this->load->library('parser');
        /*$this->load->view('pcweb/common/header', $data);
        $this->load->view($view, $data);
        $this->load->view('pcweb/common/footer', $data);*/
        $this->parser->parse('pcweb/common/header', $data);
        $this->parser->parse($view, $data);
        $this->parser->parse('pcweb/common/footer', $data);
    }

    public function website()
    {
        $this->load->model('cms_model', 'model2');
        $res = $this->model2->website();
        $data = array();
        foreach ($res as $key=> $value)
        {
            $data[$value['var']] = $value['val'];
        }
        return $data;
    }

    public function about()
    {
        $this->load->model('cms_model', 'model2');
        $res = $this->model2->content(3);
        return $res;
    }

    public function category()
    {
        $this->load->model('cms_model', 'model2');
        $data = array();
        $res = $this->model2->categorys($data);
        return $res;
    }

    public function friend()
    {
        $this->load->model('cms_model', 'model2');
        $data = array();
        $res = $this->model2->friendlinks($data);
        return $res;
    }


}


class Admin_Controller extends CI_Controller
{
    public function __constrcut()
    {
        parent::__construct();
    }

    public function getUrls()
    {
        $url = 'http://www.rrcareer.cn/';
        $urls = array(
            $url.'index.html',
            $url.'xjybasic.html',
            $url.'xjycombat.html',
            $url.'xjybusiness.html',
            $url.'leading.html',
            $url.'reading.html',
            $url.'talent.html',
            $url.'supervise.html',
            $url.'internal.html',
            $url.'ecosystem.html',
            $url.'demos.html',
            $url.'elements.html',
            $url.'products.html',
            $url.'news.html',
            $url.'aboutus.html',
            $url.'joinus.html',
            $url.'cases.html',
            $url.'team.html',
            $url.'activity.html',
            $url.'mbti.html',
            $url.'holland.html',
        );
        return $urls;
    }

    public function urlsPHP($id, $type = 'news')
    {
        $url = base_url();
        $urls = array(
            $url.$type.'-'.$id.'.html'
        );
        $api = "http://data.zz.baidu.com/urls?site=$url&token=2EdJCfpFLQHEYZtK";
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        //echo $result;
    }

    public function updateOnePHP($id, $type = 'news')
    {
        $url = base_url();
        $urls = array(
            $url.$type.'-'.$id.'.html'
        );
        $api = "http://data.zz.baidu.com/update?site=$url&token=2EdJCfpFLQHEYZtK";
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        //echo $result;
    }

    public function updatePHP()
    {
        $urls = $this->getUrls();
        $api = "http://data.zz.baidu.com/update?site=$url&token=2EdJCfpFLQHEYZtK";
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        //echo $result;
    }

    public function auth()
    {
        $this->load->library('rbac');
        $admin = $this->rbac->auth();

        if ($admin['status'] == 'false') {
            if ($this->input->is_ajax_request())
            {
                echo json_encode($admin);die();
            } else {
                //echo "没有权限<a href='/backendlogin.html'>登录 </a>";exit;
                redirect(base_url('/backendlogin.html'));
            }
        }
        return $admin;
    }

    public function display($view, $data)
    {
        $data['adminInfo'] = $this->auth();
        $this->load->view('backbone/common/header', $data);
        $this->displaySlider($data);
        $this->load->view($view, $data);
        $this->load->view('backbone/common/footer', $data);
    }

    protected function displaySlider($data)
    {
        $data['sliderAuth'] = $data['adminInfo']['menu'];
        $this->load->view('backbone/common/slider', $data);
    }

    public function backconfig()
    {
        $backtrace = debug_backtrace();
        if(isset($backtrace[1]))
        {
            $temp = $backtrace[1];
            $back = array(
                'function' => $temp['function'],
                'class' => $temp['class']
            );
            return $back;
        }
        return $backtrace;
    }



}