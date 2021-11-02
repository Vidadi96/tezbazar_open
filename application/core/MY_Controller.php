<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	public $adm_menu;
	public $langs;
	function __construct()
	{
		parent::__construct();
		// $this->output->enable_profiler(TRUE);
		$this->is_logged_in();
		$this->load->model('adm_model');
		$this->load->model('universal_model');
		$this->get_language_variables();
		$this->check_role();
		if($this->session->userdata('status_id')==1)
		{
			if($this->cache->get($this->session->userdata('name').'enable_profiler'))
			{
				//$this->output->enable_profiler(TRUE);
			}
		}
		if($this->cache->get($this->session->userdata('name').'_exit'))
		{
			redirect("auth");
		}
//$this->output->enable_profiler(TRUE);
	}
	function check_role()
	{
		$link =  $this->uri->segment("1").$this->uri->segment("2");
		$result = $this->adm_model->check_role($link);
		if(!$result & !$this->input->post())
		{
			$this->home("errors/inaccessible", "", TRUE);
			$this->CI =& get_instance();
			$this->CI->output->_display();
			die();
		}else if(!$result & ($this->input->post("method")=="ajax"))
		{
			echo '{"msg":"You are not authorized to perform this operation!", "status":"error", "title":"Error!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'"}';
			//$this->output->enable_profiler(TRUE);
			die();
		}
	}
	function is_logged_in()
	{
		$user_name = $this->session->userdata('name');
		if(!$user_name)
		{
			redirect("auth");
		}
	}

	public function home($content="", $content_data=array(), $page_title="")
	{
		// $this->output->enable_profiler(true);
		// print_r($this->session->userdata());
		$footer=array();
		$menus=array();
		if(!$page_title)
		{
			@$content_data["page_title"] = @$this->adm_model->get_page_title()->name;
		}
		// $cache_menu_name = $this->session->role_id.'_adm_menu_'.$this->session->userdata("lang");
		// if($this->cache->get($cache_menu_name))
		// 	$menus['left_menu'] = $this->cache->get($cache_menu_name);
		// else
		// {
			$mylink = '/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/';
			$left_menu = $this->get_adm_menu($mylink);
			// $this->cache->write($left_menu, $cache_menu_name);
			$menus['left_menu'] = $left_menu;
		// }
		$header["langs"] = $this->cache->model("adm_model", "langs");
		$header["title"] = $content;
		$footer["title"] = $content;
		//$content_data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
		$data= array(
				"header"		=> $this->load->view('admin/header', $header, TRUE),
				"left_side"		=> $this->load->view('admin/left_side', $menus, TRUE),
				"content"		=> $this->load->view($content, $content_data, TRUE),
				"footer"		=> $this->load->view('admin/footer',$footer, TRUE)
		);
		$this->load->view('admin/index', $data);
	}

	function get_adm_menu($mylink)
	{
		$menus = $this->adm_model->admin_menu($this->session->userdata('role_id'));
		$count_wpp = $this->adm_model->select_where_row('count(*) as "count"', 'order_status_id = 10', 'order_numbers')->count;
		$count_co = $this->adm_model->select_where_row('count(*) as "count"', 'order_status_id = 14', 'order_numbers')->count;
		$count_cd = $this->adm_model->select_where_row('count(*) as "count"', 'order_status_id = 12', 'order_numbers')->count;
		$count_uco = $this->adm_model->select_where_row('count(*) as "count"', 'order_status_id = 17', 'order_numbers')->count;
		$count_ucd = $this->adm_model->select_where_row('count(*) as "count"', 'order_status_id = 16', 'order_numbers')->count;
		$opened_parent = $this->adm_model->select_where_row('parent_id', array('link' => $mylink), 'admin_menus_id')->parent_id;

		$count_array = array(
			array(
				'url' => '/orders/waiting_price_proposal/',
				'count' => $count_wpp
			),
			array(
				'url' => '/orders/confirmed_orders/',
				'count' => $count_co
			),
			array(
				'url' => '/orders/user_cancelled_order/',
				'count' => $count_uco
			),
			array(
				'url' => '/orders/confirmed_documents/',
				'count' => $count_cd
			),
			array(
				'url' => '/orders/user_cancelled_document/',
				'count' => $count_ucd
			)
		);

		$menus_id = array();
		$sub_category = array();
		$menu_name = array();
		$menu_url = array();
		$menu_icon = array();
		$parent_id = array();
		foreach($menus as $row)
		{
			$menu_name[(string)$row->menu_id] = $row->name;
			$sub_id =$row->parent_id;
			$parent_id[(string)$row->menu_id] = $row->parent_id;
			$menu_url[(string)$row->menu_id] = $row->link;
			$menu_icon[(string)$row->menu_id] = $row->icon;
			$sub_id = (string)$sub_id;
			if(!array_key_exists($sub_id, $sub_category))
			$sub_category[$sub_id] = array();
			$sub_category[$sub_id][] = (string)$row->menu_id;
		}
		$first_ul = 1;
		$this->tree_menu('0',$menu_name, $sub_category, $first_ul, $menu_url, $menu_icon, $parent_id, $count_array, $mylink, $opened_parent);
		return $this->adm_menu;
	}

	function tree_menu($parent = "0", $menu_name, $sub_category,  $first_ul, $menu_url, $menu_icon, $parent_id, $count_array = [], $mylink='', $opened_parent = '')
	{
		//m-menu__item--open
		$img = "";
	  if($parent != "0")
		{
			if($menu_icon[$parent])
				$img = '<i class="m-menu__link-icon fa '.$menu_icon[$parent].' "></i> ';
			$url = "#";
			if(!empty($menu_url[$parent]) && $menu_url[$parent]!="#")
				$url = $menu_url[$parent];

			$menu_count = '';
			foreach($count_array as $row):
				if($url == $row['url'])
					$menu_count = '<span class="m-count">'.$row['count'].'</span>';
			endforeach;

			$opened = ($parent==$opened_parent)?'m-menu__item--open':'';
			$activee = ($url == $mylink)?'m-menu__item--active':'';

			$this->adm_menu =  $this->adm_menu.'
			<li class="m-menu__item  m-menu__item--submenu '.$opened.' '.$activee.'" aria-haspopup="true"  m-menu-submenu-toggle="hover"><a href="'.$url.'" class="m-menu__link m-menu__toggle">'.$img.'<span class="m-menu__link-text">'.$menu_name[$parent].'</span>'.$menu_count.'</a>';
			$img = "";

		}
    $children = @$sub_category[$parent];
    if(@count($children) != "0")
		{
			if($first_ul==1)
				$this->adm_menu = $this->adm_menu;
			else
		   $this->adm_menu = $this->adm_menu.'<div class="m-menu__submenu ">
				 <span class="m-menu__arrow"></span>
				 <ul class="m-menu__subnav">';

			foreach($children as $child)
				$this->tree_menu($child, $menu_name, $sub_category, 0, $menu_url, $menu_icon, $parent_id, $count_array, $mylink, $opened_parent);

	    $this->adm_menu =  $this->adm_menu."</ul></div>";
    }
    if($parent != "0") $this->adm_menu =  $this->adm_menu."</li>";
	}
	function check_method($id)
	{
		$result = $this->adm_model->check_method($id);
		if($result)
			return TRUE;
		else
		{
			echo '{"msg":"You are not authorized to perform this operation!", "status":"error", "title":"Error!"}';
			die();
		}
	}
	function check_method_boolen($id)
	{
		$result = $this->adm_model->check_method($id);
		if($result)
			return TRUE;
		else
			return FALSE;

	}
	function pagination($from=0, $perPage=100, $baseUrl, $totalRow, $uriSegment=4, $numLinks = 5)
  {
    $this->load->library('pagination');
    if($this->uri->segment($uriSegment))
    $from = $this->uri->segment($uriSegment);
    $config['base_url'] =$baseUrl;

    $query_string = $_GET;
		if(isset($query_string['page']))
		{
			unset($query_string['page']);
		}
		if (count($query_string) > 0)
		{
			$config['suffix'] = '&' . http_build_query($query_string, '', "&");
			$config['first_url'] = $config['base_url'] . '?' . http_build_query($query_string, '', "&");
		}
    $config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
    $config['total_rows'] = $totalRow;
    $config['per_page'] =  $perPage;
    $config['num_links'] = $numLinks;
    $config['next_link'] = '&rsaquo;';
    $config['prev_link'] = '&lsaquo;';
    $config['first_link'] = "First";
    $config['last_link'] = "Last";
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item disabled"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['uri_segment'] = $uriSegment;
    $this->pagination->initialize($config);
    return $this->pagination->create_links();
  }
	function search($array, $key, $value)
	{
		$results = array();
		if (is_array($array))
		{
		    if (isset($array[$key]) && $array[$key] == $value)
		        $results[] = $array;
		    foreach ($array as $subarray)
		        $results = array_merge($results, $this->search($subarray, $key, $value));
		}
		return $results;
	}
  function do_upload($inputname, $upload_path, $file_size=20000, $img_name="", $types='txt|gif|jpg|png|TIF|TIFF|pdf|JPEG|jpeg|doc|docx|xls|xlsx|ppt|pptx')
  {
	 	$data = array();
		$config['upload_path'] = $upload_path;
		$config['overwrite'] = 1;
		$config['allowed_types'] = $types;
		$config["max_size"] = $file_size;
		$config['file_name'] = $img_name."_".strtotime(date("Y-m-d H:i:s"));
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($inputname))
		{
			$data = array('error' => $this->upload->display_errors());
		}
		else
		{
			$data = $this->upload->data();
		}
    return $data;
  }

	function upload_files($path, $files, $file_size=20000, $types='txt|gif|jpg|png|TIF|TIFF|pdf|JPEG|jpeg|doc|docx|xls|xlsx|ppt|pptx' )
	{
    $config = array(
        'upload_path'   => $path,
        'allowed_types' => $types,
        'overwrite'     => 1,
    );
		$img_name="";
    $this->load->library('upload', $config);

    $images = array();


		$data["langs"] = $this->adm_model->langs();
		foreach ($data["langs"] as $lang)
		{
			if(isset($files["thumb-".$lang->lang_id]['name']))
			{
				$img_name = "slide_".$lang->lang_id;

				$_FILES['images[]']['name']= $files["thumb-".$lang->lang_id]['name'];
				$_FILES['images[]']['type']= $files["thumb-".$lang->lang_id]['type'];
				$_FILES['images[]']['tmp_name']= $files["thumb-".$lang->lang_id]['tmp_name'];
				$_FILES['images[]']['error']= $files["thumb-".$lang->lang_id]['error'];
				$_FILES['images[]']['size']= $files["thumb-".$lang->lang_id]['size'];

				$fileName = $img_name."_".strtotime(date("Y-m-d H:i:s"));

				$config['file_name'] = $fileName;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('images[]')) {
					$data = $this->upload->data();
					$images[$lang->lang_id] = $data["file_name"];
				} else {
					return false;
				}

			}


		}
		//print_r($images);
		return $images;
		// $img = [];
		// //$img = $this->do_upload("thumb-".$lang->lang_id, $this->config->item('server_root').'/img/', 150000, $img_name);
		//
		//
		//
    // foreach ($files['name'] as $key => $image) {
		//
    //     $_FILES['images[]']['name']= $files['name'][$key];
    //     $_FILES['images[]']['type']= $files['type'][$key];
    //     $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
    //     $_FILES['images[]']['error']= $files['error'][$key];
    //     $_FILES['images[]']['size']= $files['size'][$key];
		//
    //     $fileName = $title .'_'. $image;
		//
    //     $images[] = $fileName;
		//
    //     $config['file_name'] = $fileName;
		//
    //     $this->upload->initialize($config);
		//
    //     if ($this->upload->do_upload('images[]')) {
    //         $this->upload->data();
    //     } else {
    //         return false;
    //     }
    // }
		//
    // return $images;
}




	function resize_image($image_path=null, $resizeDirName="certificate", $width=null, $height=null, $maintain_ratio=FALSE,$if_width_max=FALSE, $attributes=null, $return_direct_link=false)
	{
		$CI =& get_instance();
		$path_parts = pathinfo($image_path);
		$image_name = $path_parts['filename'];
		@$image_thumb = $resizeDirName.'/'.$image_name.'.'.$path_parts['extension'];
		$config="";
		$img_width = "";
		$CI->load->library('image_lib');
		//$CI->image_lib->clear();
		if(!file_exists($image_thumb))
		{
			$config['image_library'] = 'GD2';
			$config['source_image'] = $image_path;
			$config['new_image'] = $image_thumb;
			$config['maintain_ratio'] = $maintain_ratio;

			if($if_width_max==TRUE)
			{
				list($img_width, $img_height) = getimagesize($image_path);
				if($img_width > $width)
				{
					$config['height'] = $height;
					$config['width'] = $width;
				}
			}else
			{
				$config['height'] = $height;
				$config['width'] = $width;
			}
			$CI->image_lib->initialize($config);
			if(!$CI->image_lib->resize())
			{
				return $CI->image_lib->display_errors();
			}
			$CI->image_lib->clear();
		}
	}
	public function menu_name()
	{
		$link =  $this->uri->segment("1").$this->uri->segment("2");
		$result = $this->adm_model->check_role($link);
		return $result->name;
	}
	function convert_str($str)
	{
	    $search_tr = array('ı', 'İ', 'Ğ', 'ğ', 'Ü', 'ü', 'Ş', 'ş', 'Ö', 'ö', 'Ç', 'ç', 'Ə','ə','*','!','`','~','@','"','#','$','%','^','&','?',',','|','\\','/','.',']','[','+','-',')','(',';',"'", ' ', '&nbsp;','“','”','№');
	    $replace_tr = array('i', 'I', 'G', 'g', 'U', 'u', 'S', 's', 'O', 'o', 'C', 'c','E','e','','','','','','','','','','','','','','','','','','','','','','','','',"", '-', '-','','','');
	    $str = str_replace($search_tr, $replace_tr, $str);
	    $str = strip_tags($str);
		return $str;
	}
	function filter_data($array)
	{
		$data = array();
		foreach ($array as $key => $value) {
			if(is_array($value))
				$data[$key]= $value;
			else
				$data[$key]= filter_var(str_replace(array("'", '"',"`", ')', '('), array("","","","",""), $this->security->xss_clean(strip_tags(rawurldecode($value)))), FILTER_SANITIZE_STRING);
		}
		return $data;
	}
	function get_language_variables()
	{
		$lang =(int)$this->input->get("lang");

		/*---------Get language labels from DB---------*/
		if($lang)
		{
			$this->session->set_userdata(array("lang_id"=>$lang));
			$this->session->set_userdata(array("lang"=>$lang));
		}else
		{
			if(!$this->session->userdata("lang_id"))
			{
				$this->session->set_userdata(array("lang_id"=>2));
				$this->session->set_userdata(array("lang"=>2));
			}
			//
		}
		//echo $this->session->userdata("lang_id");
		$cache_lang_name = 'langs_'.$this->session->userdata("lang_id");
		if($this->cache->get($cache_lang_name))
		{
		 	$this->langs = $this->cache->get($cache_lang_name);
		}else
		{
			$langmeta =  $this->adm_model->get_langmeta($this->session->userdata("lang_id"));

			$labels["lang"]=$lang;
			foreach($langmeta as $item)
				$labels[$item->meta_key] = $item->meta_value;
			$this->langs = (object)$labels;
			$this->cache->write($this->langs, $cache_lang_name);
		}
	}



    /***********GALLERY**************/
    private function resize_all_image($full_path, $img_name)
    {
        if(!file_exists($this->config->item('server_root').'/img/products/95x95/'.$img_name))
        {
            $this->load->library('resize');
            $this->resize->getFileInfo($full_path);
            $this->resize->resizeImage(95, 95, 'crop');
            $this->resize->saveImage($this->config->item('server_root').'/img/products/95x95/'.$img_name, 75);
            $this->resize->resizeImage(415, 415, 'crop');
            $this->resize->saveImage($this->config->item('server_root').'/img/products/415x415/'.$img_name, 80);
            $this->resize->resizeImage(1920, 840, 'auto');
            $this->resize->saveImage($this->config->item('server_root').'/img/products/auto/'.$img_name, 80);
						$this->resize->resizeImage(415, 415, 'auto');
            $this->resize->saveImage($this->config->item('server_root').'/img/products/415xauto/'.$img_name, 80);

            /*$imgConfig = array();
            $imgConfig['image_library'] = 'GD2';
            $imgConfig['source_image']  = $this->config->item('server_root').'/images/estate/370x320/'.$img_name;
            $imgConfig['wm_type']       = 'overlay';
            $imgConfig['wm_overlay_path'] = $this->config->item('server_root').'/images/logo_medium.png';
            $imgConfig['wm_vrt_alignment'] = 'middle';
            $imgConfig['wm_hor_alignment'] = 'center';
            $this->load->library('image_lib', $imgConfig);
            $this->image_lib->initialize($imgConfig);
            $this->image_lib->watermark();

            $imgConfig = array();
            $imgConfig['image_library'] = 'GD2';
            $imgConfig['source_image']  = $this->config->item('server_root').'/images/estate/auto/'.$img_name;
            $imgConfig['wm_type']       = 'overlay';
            list($width, $height) = getimagesize($imgConfig['source_image']);
            if($width>450)
                $imgConfig['wm_overlay_path'] = $this->config->item('server_root').'/images/logo_big.png';
            else
                $imgConfig['wm_overlay_path'] = $this->config->item('server_root').'/images/logo_medium.png';
            $imgConfig['wm_vrt_alignment'] = 'middle';
            $imgConfig['wm_hor_alignment'] = 'center';
            $this->load->library('image_lib', $imgConfig);
            $this->image_lib->initialize($imgConfig);
            $this->image_lib->watermark();*/


            /*$img_base_name = explode(".", $img_name);
            $img_name = md5("or".$img_base_name[0]).".".$img_base_name[1];
            if(!file_exists($this->config->item('server_root').'/images/estate/orj/'.$img_name))
            {
                $this->resize->resizeImage(1920, 840, 'auto');
                $this->resize->saveImage($this->config->item('server_root').'/images/estate/orj/'.$img_name, 80);
            }*/
        }

    }
    function getRealFile($file) {
        $uploadDir ="/img/products/";
        $realUploadDir = $this->config->item("server_root").'/img/products/';

        return str_replace($uploadDir, $realUploadDir, $file);
    }
    function ajax()
    {
        //echo 555;
        //$this->output->enable_profiler(TRUE);
        //include('class.fileuploader.php');
        require($this->config->item("server_root").'/class.fileuploader.php');
        // mysqli connection
        //$DB = mysqli_connect('localhost', 'emlak_emlak', 'ratop18', 'emlak_emlak');

        $uploadDir = '/img/products/';
        $realUploadDir = $this->config->item("server_root").'/img/products/';
        $_action = isset($_GET['type']) ? $_GET['type'] : '';


        // upload
        if ($_action == 'upload') {
            $id = false;
            $title = 'auto';

            // if after editing
            if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['editorr'])) {
                $_id = (int)$_POST['id'];
                $query = $this->universal_model->get_item("products_img", array("id"=>$_id));
                if ($query) {
                    $id = $_id;
                    $pathinfo = pathinfo($this->config->item("server_root")."/img/products/95x95/".$query->thumb);
                    $realUploadDir = $this->getRealFile($pathinfo['dirname'] . '/');
                    $title = $pathinfo['filename'];
                } else {
                    exit;
                }
            }

            // initialize FileUploader
            $FileUploader = new FileUploader('files', array(
                'limit' => 1,
                'fileMaxSize' => 20,
                'extensions' => array('image/*'),
                'uploadDir' => $realUploadDir,

                'required' => true,
                'title' => $title,
                'replace' => $id,
                'editor' => array(
                    'maxWidth' => 1980,
                    'maxHeight' => 1980,
                    'crop' => false,
                    'quality' => 90
                )
            ));

            $upload = $FileUploader->upload();

            if (count($upload['files']) == 1) {
                $item = $upload['files'][0];
                //print_r($item);
                $title = $item['name'];
                $thumb = "/img/products/95x95/".$title;
                $type = $item['type'];
                $size = $item['size'];
                $product_id = (int) $this->input->get("product_id");
                $file = $uploadDir.$item['name'];
                $query="";

                if (!$id)
                {
                    $query = $this->universal_model->run_insert_query("INSERT INTO ".$this->db->dbprefix."products_img(`img`, `user_id`, p_id, `index`) VALUES('$title', ".$this->session->userdata("id").", '$product_id', 1 + (SELECT IFNULL((SELECT MAX(`index`) FROM ".$this->db->dbprefix."products_img g where p_id=".$product_id." AND user_id=".$this->session->userdata("id")."), +1)))");
                }
                $tmp = explode(".", $title);
                /*print_r($tmp);*/
                $img_ext = end($tmp);
                $id = $id ? $id : $query;
                $img_name = "thumb".$id.".".$img_ext;
                $this->resize_all_image($this->config->item("server_root").'/img/products/'.$title, $img_name);
                $this->universal_model->item_edit_save_where(array("img"=>$img_name), array("id"=>$id), "products_img");

                if(file_exists($this->config->item("server_root").'/img/products/'.$title))
                    @unlink($this->config->item("server_root").'/img/products/'.$title);
                if ($id || $query) {
                    $upload['files'][0] = array(
                        'title' => $item['title'],
                        'thumb'=> "/img/products/95x95/".$img_name,
                        'name' => $item['name'],
                        'size' => $item['size'],
                        'size2' => $item['size2'],
                        'url' => $file,
                        'id' => $id ? $id : $query
                    );
                } else {
                    unset($upload['files'][0]);
                    $upload['hasWarnings'] = true;
                    $upload['warnings'][] = 'An error occured.';
                }
            }

            echo json_encode($upload);
            exit;
        }

        // preload
        if ($_action == 'preload') {
            $preloadedFiles = array();

            $user_id=$this->session->userdata("id");

            $get = $this->input->get("product_id")?array("p_id"=>(int)$this->input->get("product_id")):array("p_id"=>0, "user_id"=>$user_id);
            $query = $this->universal_model->get_more_item("products_img", $get, 0, array("index", "ASC"));
            if ($query) {
                foreach($query  as $row) {
                    $preloadedFiles[] = array(
                        'name' => $row->img,
                        'type' => getimagesize($this->config->item("server_root")."/img/products/415x415/".$row->img)['mime'],
                        'size' => filesize($this->config->item("server_root")."/img/products/auto/".$row->img),
                        'file' => "/img/products/415x415/".$row->img,
                        'data' => array(
                            'readerForce' => true,
                            'url' => "/img/products/415x415/".$row->img,
                            'listProps' => array(
                                'id' => $row->id,
                            )
                        ),
                    );
                }
                echo json_encode($preloadedFiles);
            }else{
                echo "[]";
            }


            exit;
        }

        // resize
        if ($_action == 'resize') {
            if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['_editor'])) {
                $id = $DB->real_escape_string($_POST['id']);
                $editor = json_decode($_POST['_editor'], true);

                $query = $DB->query("SELECT file, title FROM products_img WHERE id = '$id'");
                if ($query && $query->num_rows == 1) {
                    $row = $query->fetch_assoc();
                    $file = $this->getRealFile($row['file']);
                    $title = $row['title'];

                    if (is_file($file)) {
                        $info = Fileuploader::resize($file, null, null, null, (isset($editor['crop']) ? $editor['crop'] : null), 100, (isset($editor['rotation']) ? $editor['rotation'] : null));

                        Fileuploader::resize($this->config->item("server_root").'/uploads/gallery/'.$title, null, null, null, null, 100, (isset($editor['rotation']) ? $editor['rotation'] : null));



                        $size = filesize($file);
                        $DB->query("UPDATE products_img SET `size` = '$size' WHERE id = '$id'");
                    }
                }
            }
            exit;
        }

        // sort
        if ($_action == 'sort') {
            $id = 0;
            $first_id = 0;
            if (isset($_POST['list'])) {
                $list = json_decode($_POST['list'], true);
                foreach($list as $val) {


                    if (!isset($val['id']) || !isset($val['index']))
                        break;
                    $index = (int)$val["index"];
                    $id = (int)$val['id'];
                    $result = $this->universal_model->item_edit_save_where(array("index"=>$index), array("id"=>$id), "products_img");
                    //print_r(array("index"=>$index));

                }
                if($id)
                {
                    //$estate = $this->universal_model->get_item("products_img", "id", $id);


                    //$this->output->enable_profiler(TRUE);
                    $estate = $this->universal_model->get_item_where("products_img", array("id"=>$list[0]["id"]), "*", array("index", "ASC"));

                    if(@$estate->product_id)
                        $this->universal_model->item_edit_save_where(array("image"=>$estate->thumb, "site"=>0),  array("id"=>$estate->product_id), "estate");
                }


            }
            exit;
        }

        // rename
        /*if ($_action == 'rename') {
            if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['title'])) {
                $id = $DB->real_escape_string($_POST['id']);
                $title = substr(FileUploader::filterFilename($_POST['title']), 0, 200);

                $query = $DB->query("SELECT file FROM agro_gallery WHERE id = '$id'");
                if ($query && $query->num_rows == 1) {
                    $row = $query->fetch_assoc();
                    $file = $row['file'];

                    $pathinfo = pathinfo($file);
                    $newName = $title . (isset($pathinfo['extension']) ? '.' . $pathinfo['extension'] : '');
                    $newFile = $pathinfo['dirname'] . '/' . $newName;

                    $realFile = str_replace($uploadDir, $realUploadDir, $file);
                    $newRealFile = str_replace($uploadDir, $realUploadDir, $newFile);

                    if (!file_exists($newRealFile) && rename($realFile, $newRealFile)) {
                        $query = $DB->query("UPDATE agro_gallery SET `title` = '".$DB->real_escape_string($newName)."', `file` = '".$DB->real_escape_string($newFile)."' WHERE id = '$id'");
                        if ($query) {
                            echo json_encode([
                                'title' => $title,
                                'file' => $newFile,
                                'url' => $newFile
                            ]);
                        }
                    }

                }
            }
            exit;
        }*/

        // asmain
        if ($_action == 'asmain') {
            /*if (isset($_POST['id']) && isset($_POST['name'])) {
                $id = $DB->real_escape_string($_POST['id']);

                $this->universal_model->item_edit_save_where(array("image"=>$estate->thumb), array("id"=>$estate->product_id), "estate");
                $query = $DB->query("UPDATE agro_gallery SET is_main = 0");
                $query = $DB->query("UPDATE agro_gallery SET is_main = 1 WHERE id = '$id'");
            }
            exit;*/
        }

        // remove
        if ($_action == 'remove') {
            if (isset($_POST['id']) && isset($_POST['name'])) {
                $id = $this->input->post('id');

                $img = $_POST['name'];
                /*name: thumb7438179.jpeg
    id: 7438179
    tim: b6c152bb6c9387a537804bc47918aaa4*/


                $this->universal_model->delete_item_where(array("id"=>$id), "products_img");

                if(file_exists($this->config->item('server_root')."/images/estate/95x95/".$img))
                    @unlink($this->config->item("server_root")."/images/estate/95x95/".$img);
                if(file_exists($this->config->item('server_root')."/images/estate/370x320/".$img))
                    @unlink($this->config->item("server_root")."/images/estate/370x320/".$img);
                if(file_exists($this->config->item('server_root')."/images/estate/auto/".$img))
                    @unlink($this->config->item("server_root")."/images/estate/auto/".$img);
                $img_base_name = explode(".", $img);
                $img_name = md5("or".@$img_base_name[0]).".".@$img_base_name[1];
                if(file_exists($this->config->item('server_root')."/images/estate/orj/".$img_name))
                    @unlink($this->config->item('server_root')."/images/estate/orj/".$img_name);
            }
            exit;
        }

    }




































}
