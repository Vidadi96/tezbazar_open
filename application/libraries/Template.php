<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template {
	public $top_menu;
	public $cats_menu;
	public $footer_menu;
	public $left_menu;
	public $lang;
	public $flags;
	//public $settings;
	public $labels;
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('office_model');
		$this->CI->load->model('universal_model');
		$this->CI->load->model('profile_model');

		/*---------Get language labels from DB---------*/
		$this->flags = $this->CI->office_model->flags();
		if($this->CI->input->get("lang"))
		{
			$lang = (int)$this->CI->input->get("lang");
			$this->CI->session->set_userdata(array("lang_id"=>$lang));
		}
		if(!$this->CI->session->userdata("lang_id"))
		{
			$this->CI->session->set_userdata(array("lang_id"=>$this->flags[0]->lang_id));
		}


		$this->lang =  $this->CI->session->userdata("lang_id");

		$langmeta =  $this->CI->office_model->get_langmeta($this->lang);
		foreach($langmeta as $item)
			$this->labels[$item->meta_key] = $item->meta_value;

			if(!$this->CI->session->userdata("user_id"))
			{

				if(!$this->CI->session->userdata("tmp_user"))
				{
					///echo 2;
					$tmp_user = md5(date("d-m-Y H:i:s"));
					//$this->CI->cache->write(array(), $tmp_user);
					$tmp = $this->CI->session->userdata();
					$tmp["tmp_user"] = $tmp_user;
					$this->CI->session->set_userdata($tmp);
				}
			}
			//print_r($this->CI->cache->get($this->CI->session->userdata('tmp_user')));
			//phpinfo();

			//echo $this->CI->encryption->encrypt(55);
			//echo $this->CI->encryption->decrypt('f679ab72e0a7552ac605fa217ee7556678ecea6dad731b3b216779d0a9737a164fb37df1b4b09936f09c3c22f0347e565e29df37f2d415879bea0cb34a7a6f97bbGLuIdB5GuTcm2UmA3m1+n2');
	}

	function send_mail($subject, $msg, $to_mail="")
	{
			$this->CI->load->library('email');
			$mail = $this->CI->universal_model->get_item("smtp_settings", array("id"=>1));
			$admin_mail = $this->CI->universal_model->get_item("admin_mails", array("id"=>1));
			$config = Array(
				'protocol' => 'smtp',
				'smtp_crypto' => 'ssl',
				'smtp_host' => 'smtp.hostinger.com',
				'smtp_port' => '465',
				'smtp_user' => 'info@tez-bazar.com',
				'smtp_pass' => 'Tezb@z@r2020',
				'mailtype'  => 'html',
				'smtp_timeout' => 5,
				'charset'   => 'UTF-8'
			);
			$this->CI->email->initialize($config);
			$this->CI->email->from($mail->smtp_user);
			if(!$to_mail)
				$to_mail = $admin_mail->to_mail;

			$this->CI->email->to(explode(";",$to_mail));
			//$this->CI->email->set_header("Read-Receipt-To", "shirazi@stdc.az");
			//$this->CI->email->set_header("X-Confirm-reading-to", "shirazi@stdc.az");
			//$this->CI->email->cc("shiraziismailov@gmail.com");
			$this->CI->email->subject($subject);
			$this->CI->email->message($msg);

			//$file_name = $this->create_doc_document($data["ch_id"]);
			//$this->CI->email->attach($_SERVER['DOCUMENT_ROOT']."/reports/".$file_name);
			$result = @$this->CI->email->send();
			return $result;
		}


	public function encrypt($data){
		$this->CI->load->library('encryption');
		$this->CI->encryption->initialize(
						array(
										'cipher' => 'aes-256',
										'mode' => 'ctr',
										'key' => $this->CI->config->config['encryption_key']
						)
		);
		return $this->CI->encryption->encrypt($data);
	}
	public function decrypt($data){
		$this->CI->load->library('encryption');
		$this->CI->encryption->initialize(
						array(
										'cipher' => 'aes-256',
										'mode' => 'ctr',
										'key' => $this->CI->config->config['encryption_key']
						)
		);
		return $this->CI->encryption->decrypt($data);
	}
	private function filter_data($array)
	{
		$data = array();
		foreach ($array as $key => $value) {
			if(is_array($value))
				$data[$key]= $value;
			else
				$data[$key]= filter_var(str_replace(array("'", '"',"`", ')', '('), array("","","","",""), $this->CI->security->xss_clean(strip_tags(rawurldecode($value)))), FILTER_SANITIZE_STRING);
		}
		return $data;
	}
	public function home($content="", $content_data="")
	{
		$from_cache=array();
		if($this->CI->session->userdata('tmp_user'))
		$from_cache = $this->CI->cache->get($this->CI->session->userdata('tmp_user'));

		if(empty($content))
		{
			$content="site/default_content";
		}
		$get = $this->filter_data(array("q"=>$this->CI->input->get("q")));
		$header = array();
		$header["top_menus"]="";
		$header["search"]=@$get["q"];
		$header["title"]=@$content_data["title"];
		$header["flags"] = $this->flags;
		//print_r($header["flags"]);

		if($this->CI->cache->get("top_menu_".$this->lang))
			$header["top_menus"] = $this->CI->cache->get("top_menu_".$this->lang);
		else
		{
			$header["top_menus"] = $this->get_menus($this->lang, "top_menu");
			$this->CI->cache->write($header["top_menus"], "top_menu_".$this->lang);
		}

		$basket=[];
		$basket["in_basket"] =  $this->CI->profile_model->get_in_basket();
		$header["whishlist"] =  $this->CI->profile_model->get_in_wishlist();
		//print_r($basket["in_basket"]);
		$header["basket"] = $this->CI->load->view("site/basket", $basket, true);

		$header["cats_menu"] = $this->CI->office_model->get_categories($this->lang);
		$footer=array();

		$header["social_icons"] = $this->CI->office_model->social_icons();
		$footer["social_icons"] = @$header["social_icons"];

		$data["container"] = $this->CI->load->view($content, $content_data, TRUE);
		$data["header"]= $this->CI->load->view('site/header', $header, TRUE);
		$data["footer"] = $this->CI->load->view('site/footer', $footer, TRUE);
		$this->CI->load->view('site/index', $data);
	}
	private function get_menus($lang, $menu_container)
	{
		$menus = $this->CI->office_model->get_menus($lang);
		//print_r($menus);
		$side = array();
		$pagename = array();
		$menu_id = array();
		$sub_id = "";
		$parent_id = array();
		$page_url = array();
		$sub_category = array();
		if($menus)
		{

			foreach($menus as $row)
			{
				$pagename[(string)$row['menu_id']] = $row['title'];
				$side[(string)$row['menu_id']] = 1;
				$menu_id[(string)$row['menu_id']] = $row['menu_id'];
				$sub_id =$row['parent_id'];
				$parent_id[(string)$row['menu_id']] = $row['parent_id'];
				$page_url[(string)$row['menu_id']] = $row['url'];
				$sub_id = (string)$sub_id;
				if(!array_key_exists($sub_id, $sub_category))
					$sub_category[$sub_id] = array();
				$sub_category[$sub_id][] = (string)$row['menu_id'];
			}
			$first_ul =1;
			$this->menu_tree('0',$pagename, $sub_category, $first_ul, $page_url, $parent_id, $menu_id, $side);
			return $this->{$menu_container};
		}else
		{
			return "";
		}

	}
	private function get_cats_menu($lang, $cats_menu)
	{
		$cats = $this->CI->office_model->get_categories($lang);
		$cat_name = array();
		$cat_id = array();
		$sub_id = "";
		$parent_id = array();
		$page_url = array();
		$sub_category = array();
		if($cats)
		{
			foreach($cats as $row)
			{
				$cat_name[(string)$row['cat_id']] = $row['name'];
				$cat_id[(string)$row['cat_id']] = $row['cat_id'];
				$sub_id =$row['parent_id'];
				$parent_id[(string)$row['cat_id']] = $row['parent_id'];
				$page_url[(string)$row['cat_id']] = "/office/category/".$row['cat_id'];
				$sub_id = (string)$sub_id;
				if(!array_key_exists($sub_id, $sub_category))
					$sub_category[$sub_id] = array();
				$sub_category[$sub_id][] = (string)$row['cat_id'];
			}
			$first_ul =1;
			$this->cats_tree('0',$cat_name, $sub_category, $first_ul, $page_url, $parent_id, $cat_id);
			return $this->{$cats_menu};
		}else
		{
			return "";
		}

	}
	function cat_tree($parent = "0", $cat_name, $sub_category,  $first_ul, $page_url, $parent_id, $cat_id)
	{
		$img = "";
		$url = @$page_url[$parent];
	    if($parent != "0")
			{
				$this->cats_menu =  $this->cats_menu.'<li class=""><a href="'.$url.'">'.nl2br($cat_name[$parent]).'</a>';
			}
	    $children = @$sub_category[$parent];
	    if(isset($children) && (count($children) !="0")){
			if($first_ul==1)
			{
				$this->cats_menu =  '<ul class="nav navbar-nav navbar-right">';
			}else
			{
				$this->cats_menu =  $this->cats_menu.'<ul class="dropdown-menu start-left" role="menu">';
			}

	      foreach($children as $child)
					$this->menu_tree($child, $cat_name, $sub_category, 0, $page_url, $parent_id, $cat_id);
				$this->cats_menu =  $this->cats_menu."</ul>";

	    }
	    if($parent != "0")
	    {
			$this->cats_menu =  $this->cats_menu.'</li>';
		}

	}
	function menu_tree($parent = "0", $pagename, $sub_category,  $first_ul, $page_url, $parent_id, $menu_id, $side)
	{
		$img = "";
		$url = @$page_url[$parent];
		if($parent==48)
		$url = "#";
	    if($parent != "0")
			{

				$this->top_menu =  $this->top_menu.'<li class=""><a href="'.$url.'">'.nl2br($pagename[$parent]).'</a>';
			}
	    $children = @$sub_category[$parent];
	    if(isset($children) && (count($children) !="0")){
			if($first_ul==1)
			{
				$this->top_menu =  '<ul class="nav navbar-nav navbar-right">';
			}else
			{
				$this->top_menu =  $this->top_menu.'<ul class="dropdown-menu start-left" role="menu">';
			}

	      foreach($children as $child)
					$this->menu_tree($child, $pagename, $sub_category, 0, $page_url, $parent_id, $menu_id, $side);
				$this->top_menu =  $this->top_menu."</ul>";

	    }
	    if($parent != "0")
	    {
			$this->top_menu =  $this->top_menu.'</li>';
		}

	}
	function convert_url($str)
	{
		$search_tr = array('à','è','ı', 'İ', 'Ğ', 'ğ', 'Ü', 'ü', 'Ş', 'ş', 'Ö', 'ö', 'Ç', 'ç', 'Ə','ə','*','!','`','~','@','"','#','$','%','^','&','?',',','|','\\','/','.',']','[','+','-',')','(',';',"'", ' ', '&nbsp;','“','”','№');
		$replace_tr = array('','','i', 'I', 'G', 'g', 'U', 'u', 'S', 's', 'O', 'o', 'C', 'c','E','e','','','','','','','','','','','','','','','','','','','','','','','','',"", '-', '-','','','');
		$str = str_replace($search_tr, $replace_tr, $str);
		$str = strip_tags($str);
		return $str;
	}








}
