<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adm extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("orders_model");
	}
	public function index($order_number=0, $address_id=0)
	{
		if($this->input->post())
		{
			$this->universal_model->item_edit_save_where(array("order_status_id"=>$this->input->post("order_status_id")), array("order_number"=>$this->input->post("order_number")), "order_numbers");
		}
		$data=[];
		if(!$order_number)
		{
			$data["filter"] = $this->input->get();
			$from = isset($data["filter"]["from"])?$data["filter"]["from"]:0;
			$end=100;
			$result = $this->adm_model->orders($data["filter"], $from, $end);
			$data["list"] = $result["list"];
			$this->home('admin/content', $data);
		}else {
			$data["order"] = $this->adm_model->get_order_details($order_number);
			$data["shipping"] = $this->adm_model->get_shipping(0);
			$data["order_status_id"] = $this->adm_model->order_status_id();
			$data["address"] = 	$this->universal_model->get_item("addresses", array("address_id"=>$address_id));
			$data["user"] = 	$this->universal_model->get_item("site_users", array("user_id"=>$data["address"]->user_id));
			$data["order_number"] = 	$this->universal_model->get_item("order_numbers", array("order_number"=>$order_number));
			//print_r($data["order"]);
			$this->home('admin/order_details', $data);
		}
	}
	public function chat()
	{
		$data=[];

		$this->home('admin/chat', $data);
	}
	public function translation_update()
	{
		$result = $this->adm_model->translation_update($this->input->post("meta_key"), $this->input->post("column_value"), $this->input->post("lang_id"));
		if($result)
		{
			echo '{"msg":"Məlumat uğurla yeniləndi", "status":"success"}';
		}
		else
		{
			echo '{"msg":"Xəta baş verdi təkrar cəhd edin.", "status":"success"}';
		}
	}
	public function languages()
	{
		if($this->input->post())
		{
			$vars = array("name"=>$this->input->post("name"), "order_by"=>(float)$this->input->post("order_by"), "active"=>(int)$this->input->post("active"));
			$img="";
			$error = false;
			if(empty($_FILES['thumb']['tmp_name']) || $_FILES['thumb']['tmp_name'] == 'none')
			{

			}else
			{
				$img = $this->do_upload("thumb", $this->config->item('server_img_root'), 150000, "lang");
				if(@$img["error"]==TRUE)
				{
					$error = $img["error"];
				}else{
					$this->resize_image($img['full_path'], $this->config->item('server_img_root').'langs', 24, 24, TRUE);
					if(file_exists($img['full_path']))
					unlink($img['full_path']);
					$vars["thumb"] = $img["file_name"];
				}

			}
			if($error)
			{
				$data["status"] = array("status"=>"danger", "msg"=>$error, "title"=>"Error!", "icon"=>"exclamation-triangle");
			}else {
				$result = $this->universal_model->add_item($vars, "langs");
				if($result)
				{
					$data["status"] = array("status"=>"success", "msg"=>"Yeni dil uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
				}else
				{
					$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
				}
			}

		}
		$data["langs"]=$this->universal_model->get_more_item("langs", array("deleted"=>0));
		$this->home('admin/languages', $data);
	}
	public function edit_lang($lang_id)
	{
		$lang_id = (int) $lang_id;
		if($this->input->post())
		{
			$vars = array("name"=>$this->input->post("name"), "order_by"=>(float)$this->input->post("order_by"), "active"=>(int)$this->input->post("active"));
			$img="";
			$error = false;
			if(empty($_FILES['thumb']['tmp_name']) || $_FILES['thumb']['tmp_name'] == 'none')
			{
				$vars["thumb"] = $this->input->post("old_thumb");
			}else
			{
				$img = $this->do_upload("thumb", $this->config->item('server_img_root'), 150000, "lang");
				if(@$img["error"]==TRUE)
				{
					$error = $img["error"];
				}else{
					$this->resize_image($img['full_path'], $this->config->item('server_img_root').'langs', 24, 24, TRUE);
					$vars["thumb"] = $img["file_name"];
					if(file_exists($img['full_path']))
					unlink($img['full_path']);
					if(file_exists($this->config->item('server_img_root').'langs/'.$this->input->post("old_thumb")))
					unlink($this->config->item('server_img_root').'langs/'.$this->input->post("old_thumb"));
				}

			}
			if($error)
			{
				$data["status"] = array("status"=>"danger", "msg"=>$error, "title"=>"Error!", "icon"=>"exclamation-triangle");
			}else {
				$result = $this->universal_model->item_edit_save_where($vars, array("lang_id"=>$lang_id), "langs");
				if($result)
				{
					$data["status"] = array("status"=>"success", "msg"=>"Dil uğurla yeniləndi.", "title"=>"Success!", "icon"=>"check-circle");
				}else
				{
					$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
				}
			}

		}
		$data["lang"]=$this->universal_model->get_item("langs", array("deleted"=>0, "lang_id"=>$lang_id));
		$this->home('admin/edit_lang', $data);
	}
	public function search_lang()
	{
		echo '{
    "meta": {
        "page": 1,
        "pages": 1,
        "perpage": -1,
        "total": 350,
        "sort": "asc",
        "field": "RecordID"
    },
    "data": [
        {
            "RecordID": 1,
            "OrderID": "61715-075",
            "Country": "China",
            "ShipCountry": "CN",
            "ShipCity": "Tieba",
            "ShipName": "Collins, Dibbert and Hoeger",
            "ShipAddress": "746 Pine View Junction",
            "CompanyEmail": "nsailor0@livejournal.com",
            "CompanyAgent": "Nixie Sailor",
            "CompanyName": "Gleichner, Ziemann and Gutkowski",
            "Currency": "CNY",
            "Notes": "imperdiet nullam orci pede venenatis non sodales sed tincidunt eu felis fusce posuere felis sed lacus morbi",
            "Department": "Outdoors",
            "Website": "irs.gov",
            "Latitude": 35.0032213,
            "Longitude": 102.913526,
            "ShipDate": "2\/12\/2018",
            "PaymentDate": "2016-04-27 23:53:15",
            "TimeZone": "Asia\/Chongqing",
            "TotalPayment": "$246154.65",
            "Status": 3,
            "Type": 2,
            "Actions": null
        }
			]
		}';
	}
	function set_active_passive_lang()
	{
		if($this->input->post("id"))
		{
			$result = $this->universal_model->item_edit_save("langs", array("lang_id"=>((int)$this->input->post("id"))), array("active"=>((int)$this->input->post("active_passive"))));
			if($result)
			{
				echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			}
			else
			{
					echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
			}
		}
	}
	function delete_lang()
	{
		if($this->input->post("id"))
		{
			$this->universal_model->item_edit_save_where(array("deleted"=>1), array("lang_id"=>(int)$this->input->post("id")), "langs");
			echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
		}
	}
	/**=====Start Translations Section======**/
	public function translations()
	{
		$data=array();
		if($this->input->post())
		{
			$vars = $this->input->post();
			$array=array();
			$meta_key = $vars["meta_key"];
			$where_for = $vars["where_for"];
			unset($vars["meta_key"]);
			unset($vars["where_for"]);
			foreach($vars as $key=>$value)
			{
				$name = explode("-", $key);
				$array[] = array("meta_key"=>$meta_key, "meta_value"=>$value, "where_for"=>$where_for, "lang_id"=>(int)@$name[1]);
			}
			$this->cache->delete_group("langs_");
			//print_r($array);
			$result = $this->universal_model->add_more_item($array, "langmeta");
			if($result)
				$data["status"] = array("status"=>"success", "msg"=>$this->langs->item_added_successfully, "title"=>$this->langs->success_title, "icon"=>"check-circle");
			else
				$data["status"] = array("status"=>"error", "msg"=>$this->langs->item_added_failed, "title"=>$this->langs->error_title, "icon"=>"check-circle");



			/*$cache_lang_name = 'langs_'.$lang_id;
			$this->cache->delete($cache_lang_name);*/
		}
		$data["langs"] = $this->adm_model->langs();
		$data["lang_meta"]= $this->adm_model->call_langs();

		$this->home('admin/translations', $data);
	}
	public function delete_meta_key()
	{
		if($this->input->post("id"))
		{
			$this->universal_model->delete_item(array("meta_key"=>$this->input->post("id")), "langmeta");
			echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
		}else {
			echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
		}
	}
	/**=====End Translations Section======**/






















	public function my_profile()
	{
		$data["user"]=$this->adm_model->get_user($this->session->userdata("id"));
		$this->home('admin/my_profile', $data);
	}
	public function edit_profile()
	{
		$this->load->helper("form");
		if($this->input->post())
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email', "E-mail", 'trim|required');
			$this->form_validation->set_rules('full_name', "Full name", 'trim|required');
			if($this->form_validation->run() == TRUE)
			{

				if($this->adm_model->check_email($this->input->post("email"), $this->session->userdata("id")))
				{
					$data["status"]= array("status"=>"danger", "msg"=>"The email address <b>".$this->input->post("email")."</b> you entered is already in use on another user. Please use a different email address.");
				}else
				{
					$var = array("gender_id"=>$this->input->post("gender_id"), "email"=>$this->input->post("email"), "full_name"=>$this->input->post("full_name"), "address"=>$this->input->post("address"), "site"=>$this->input->post("site"),"job"=>$this->input->post("job"));
					if($this->input->post("pass"))
					{
						$var['pass'] = md5($this->input->post("pass"));
					}
					$img="";
					if(!empty($_FILES['thumb']['tmp_name']))
					{
						$img = $this->do_upload("thumb", $this->config->item('upload_path').'profile/', 1600);
						if(@$img["error"]==TRUE)
						{
							$data["status"] = array("status"=>"danger", "msg"=>$img["error"]);
						}else{

							$this->load->library('resize');
							$this->resize->getFileInfo($img['full_path']);
							$this->resize->resizeImage(400, 400, 'crop');
							$this->resize->saveImage($this->config->item('upload_path').'profile/big/'.$img["file_name"], 70);
							$this->resize->resizeImage(128, 128, 'crop');
							$this->resize->saveImage($this->config->item('upload_path').'profile/small/'.$img["file_name"], 75);

							if(file_exists($img['full_path']))
							unlink($img['full_path']);
							$var["thumb"] = $img["file_name"];

							if($this->input->post("old_user_thumb") && ($this->input->post("old_user_thumb") !="default.jpg"))
							{
								@unlink($this->config->item('upload_path').'profile/big/'.$this->input->post("old_user_thumb"));
								@unlink($this->config->item('upload_path').'profile/small/'.$this->input->post("old_user_thumb"));
							}

						}
					}
					if(!isset($img["error"]))
					{
						$result = $this->adm_model->update_user($var, $this->session->userdata("id"));
						if($result)
						{
							unset($var["pass"]);
							$this->session->set_userdata($var);

							$data["status"] = array("status"=>"success", "msg"=>"Məlumatlar müvəffəqiyyətlə yeniləndi.");
						}else{
							$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi. Zəhmət olmasa təkrar cəhd edin");
						}

					}
				}



			}
		}
		//print_r($data);
		$data["user"]=$this->adm_model->get_user($this->session->userdata("id"));
		$this->home('admin/edit_profile', $data);
	}
	public function new_user()
	{
		$this->check_role();
		$this->load->helper("form");
		$data="";
		if($this->input->post())
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', "Name", 'trim|required');
			$this->form_validation->set_rules('pass', "Password", 'trim|required');
			$this->form_validation->set_rules('pass_rep', "Confirm password", 'trim|required');
			$this->form_validation->set_rules('email', "E-mail", 'trim|required|valid_email');
			$this->form_validation->set_rules('gender_id', "Gender", 'trim');
			$this->form_validation->set_rules('job', "Job", 'trim');
			$this->form_validation->set_rules('address', "Address", 'trim');
			$this->form_validation->set_rules('site', "Site", 'trim');
			$this->form_validation->set_rules('status_id', "Active/Passive", 'trim');
			$this->form_validation->set_rules('full_name', "Full name", 'trim|required');
			$this->form_validation->set_rules('role_id', "Role", 'trim|required');
			if($this->form_validation->run() == TRUE)
			{

				if($this->input->post("pass")==$this->input->post("pass_rep"))
				{

					if($this->adm_model->check_email($this->input->post("email")))
					{
						$data["status"]= array("status"=>"danger", "msg"=>"The email address <b>".$this->input->post("email")."</b> you entered is already in use on another user. Please use a different email address.");
					}else
					{
						$img="";
						if(!empty($_FILES['thumb']['tmp_name']))
						{
							$img = $this->do_upload("thumb", $this->config->item('upload_path').'profile/', 1600);
							if(@$img["error"]==TRUE)
							{
								$data["status"] = array("status"=>"danger", "msg"=>$img["error"]);
							}else{

								$this->load->library('resize');
								$this->resize->getFileInfo($img['full_path']);
								$this->resize->resizeImage(400, 400, 'crop');
								$this->resize->saveImage($this->config->item('upload_path').'profile/big/'.$img["file_name"], 70);
								$this->resize->resizeImage(128, 128, 'crop');
								$this->resize->saveImage($this->config->item('upload_path').'profile/small/'.$img["file_name"], 75);

								if(file_exists($img['full_path']))
								unlink($img['full_path']);
								$data["thumb"] = $img["file_name"];
							}
						}else
						{
							$data["thumb"] = "default.jpg";
						}
						if(!isset($img["error"]))
						{
							$vars = array("name"=>$this->input->post("name"), "pass"=>md5($this->input->post("pass")), "register_date"=>date("Y-m-d H:i:s"),"activation_key"=>md5(date("Y-m-d H:i:s")),  "gender_id"=>$this->input->post("gender_id"), "email"=>$this->input->post("email"), "full_name"=>$this->input->post("full_name"), "role_id"=>$this->input->post("role_id"), "status_id"=>$this->input->post("status_id"), "thumb"=>$data["thumb"], "address"=>$this->input->post("address"), "site"=>$this->input->post("site"),"job"=>$this->input->post("job"));
							$result = $this->adm_model->add_user($vars);
							if($result)
							{
								redirect("/adm/edit_user/".$result."/TRUE/");
							}else{

								$data["status"] = array("status"=>"danger", "msg"=>"This Username <strong>".$vars["name"]."</strong> already exists. Please use another Username.");
							}
						}

					}


				}else
				{
					$data["status"] = array("status"=>"danger", "msg"=>"Password does not match the confirm password.");
				}

			}else
			{
				$data["status"] = array("status"=>"danger", "msg"=>"Please fill out all the required fields.");
			}
		}
		$data['roles'] = $this->adm_model->get_role_list();
		$data["menu_name"] = $this->menu_name();
		$this->home('admin/new_user', $data);
	}
	public function edit_user($id)
	{
		$this->check_role();
		$this->load->helper("form");
		$data="";
		if($this->input->post())
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', "Name", 'trim|required');
			$this->form_validation->set_rules('email', "E-mail", 'trim|required|valid_email');
			$this->form_validation->set_rules('gender_id', "Gender", 'trim');
			$this->form_validation->set_rules('job', "Job", 'trim');
			$this->form_validation->set_rules('address', "Address", 'trim');
			$this->form_validation->set_rules('site', "Site", 'trim');
			$this->form_validation->set_rules('status_id', "Active/Passive", 'trim');
			$this->form_validation->set_rules('full_name', "Full name", 'trim|required');
			$this->form_validation->set_rules('role_id', "Role", 'trim|required');
			if($this->form_validation->run() == TRUE)
			{

				if($this->adm_model->check_email($this->input->post("email"), $id))
				{
					$data["status"]= array("status"=>"danger", "msg"=>"The email address <b>".$this->input->post("email")."</b> you entered is already in use on another user. Please use a different email address.");
				}else
				{
					$img="";
					$vars = array("name"=>$this->input->post("name"),  "gender_id"=>$this->input->post("gender_id"), "email"=>$this->input->post("email"), "full_name"=>$this->input->post("full_name"), "role_id"=>$this->input->post("role_id"), "status_id"=>$this->input->post("status_id"), "address"=>$this->input->post("address"), "site"=>$this->input->post("site"),"job"=>$this->input->post("job"));
					if(!empty($_FILES['thumb']['tmp_name']))
					{
						$img = $this->do_upload("thumb", $this->config->item('upload_path').'profile/', 1600);
						if(@$img["error"]==TRUE)
						{
							$data["status"] = array("status"=>"danger", "msg"=>$img["error"]);
						}else{

							$this->load->library('resize');
							$this->resize->getFileInfo($img['full_path']);
							$this->resize->resizeImage(400, 400, 'crop');
							$this->resize->saveImage($this->config->item('upload_path').'profile/big/'.$img["file_name"], 70);
							$this->resize->resizeImage(128, 128, 'crop');
							$this->resize->saveImage($this->config->item('upload_path').'profile/small/'.$img["file_name"], 75);

							if(file_exists($img['full_path']))
							unlink($img['full_path']);
							$vars["thumb"] = $img["file_name"];
						}
					}
					if(!isset($img["error"]))
					{
						if($this->input->post("pass"))
						{
							$vars['pass'] = md5($this->input->post("pass"));
						}
						$result = $this->adm_model->update_user($vars, $id);
						if($result)
						{
							$data["status"] = array("status"=>"success", "msg"=>"User updated successfully.");
						}else{

							$data["status"] = array("status"=>"danger", "msg"=>"This Username <strong>".$vars["name"]."</strong> already exists. Please use another Username.");
						}
					}

				}
			}else
			{
				$data["status"] = array("status"=>"danger", "msg"=>"Please fill out all the required fields.");
			}
		}
		$data['roles'] = $this->adm_model->get_role_list();
		$data["menu_name"] = $this->menu_name();
		$data["user"] = $this->adm_model->get_user($id);
		$this->home('admin/edit_user', $data);
	}
	public function user_list()
	{
		$q = "";
		//echo $q;
		$vars = $this->input->get();
		$from=0;
		if($this->input->get("page"))
		$from = $this->input->get("page");
		$end = 15;
		$data["pagination"] = "";


		$result = $this->adm_model->user_list($vars, $from, $end);

		$data["total_row"] = $result["total_row"];
		$data["list"] = $result["list"];
		$base_url = "/adm/user_list/";
		if($result["total_row"]>=1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $data["total_row"], 4, 5);
		$data["menu_name"] = $this->menu_name();
		$data["edit"] = $this->check_method_boolen(5);
		$data["delete"] = $this->check_method_boolen(6);
		$this->home('admin/user_list', $data);
	}
	public function delete_user()
	{
		$this->check_method(6);//id of "User Delete Menu"
		$user = $this->adm_model->get_user($this->input->post("id"));
		$result = $this->adm_model->update_item(array("id"=>$this->input->post("id")), array("deleted"=>1),"users");
		if($result)
		{

			//$this->cache->write(1, $user->name."_exit");
			$this->cache->write("1", $user->name.'_exit');
			echo '{"msg":"User successfully moved to trash.", "status":"success", "title":"Success!"}';
		}
		else
			echo '{"msg":"An error occured, please try again.", "status":"error", "title":"Error!"}';
	}
	public function menu_permissions()
	{
		// $this->output->enable_profiler(true);
		$data["langs"] = $this->universal_model->get_more_item("langs", array("deleted"=>0));
		if($this->input->post())
		{
			$vars = $this->input->post();
			$menu_id_vars = array("icon"=>$vars["icon"], "parent_id"=>$vars["parent_id"], "menu_type_id"=>$vars["menu_type_id"], "order_by"=>$vars["order_by"], "link"=>$vars["link"]);
			$menu_id = $this->universal_model->add_item($menu_id_vars, "admin_menus_id");
			$menu_vars = array();
			foreach ($data["langs"] as $lang) {
					$menu_vars[] = [
							"lang_id" => $lang->lang_id,
							"menu_id" => $menu_id,
							"full_name" => $vars["full_name-" . $lang->lang_id],
							"name" => $vars["full_name-" . $lang->lang_id]
					];
			}

			$relations=array();
			//$this->universal_model->delete_item(array("rel_type_id"=>4, "item_id"=>$post_id), "relations");
			foreach ($vars["role_id"] as $key => $value) {
				$relations[]=array("item_id"=>$value, "rel_item_id"=>$menu_id, "rel_type_id"=>1);
			}
			//$this->universal_model->delete_item_where(array("rel_type_id"=>4, "item_id"=>$post_id), "relations");
			$this->universal_model->add_more_item($relations, "relations");

			$result = $this->universal_model->add_more_item($menu_vars, "admin_menus");
			$this->cache->delete_all();
			//$data["status"] = array("status"=>"success", "msg"=>"New menu added successfully.");
			$data["status"] = array("status"=>"success","title"=>"Success", "icon"=>"check-circle", "msg"=>"New menu added successfully.");
		}
		//print_r($menu["menus"]);

		$data["roles"] = $this->adm_model->get_role_list();
		$menu["menus"] = $this->adm_model->get_menu_list($this->session->userdata('role_id'));//$data["roles"][0]->id);
		$menu["all_menus"] = $this->adm_model->get_all_menus();
		$data["menu_tbl"] = $this->load->view('admin/get_menu_permissions', $menu, TRUE);
		$data["menu_name"] = $this->menu_name();
		$this->home('admin/menu_permissions', $data);
	}
	public function edit_admin_menu($menu_id)
	{
		$data=[];
		$data["langs"]=$this->universal_model->get_more_item("langs", array("deleted"=>0));
		if($this->input->post())
		{
			$vars = $this->input->post();
			$menu_id_vars = array("icon"=>$vars["icon"], "parent_id"=>$vars["parent_id"], "menu_type_id"=>$vars["menu_type_id"], "order_by"=>$vars["order_by"], "link"=>$vars["link"]);
			$this->universal_model->item_edit_save_where($menu_id_vars, array("menu_id"=>$menu_id), "admin_menus_id");

			$menu_vars = array();
			foreach ($data["langs"] as $lang) {
					$menu_vars[] = [
							"lang_id" => $lang->lang_id,
							"menu_id" => $menu_id,
							"full_name" => $vars["full_name-" . $lang->lang_id],
							"name" => $vars["full_name-" . $lang->lang_id]
					];
			}
			$relations=array();
			$this->universal_model->delete_item(array("menu_id"=>$menu_id), "admin_menus");
			$result = $this->universal_model->add_more_item($menu_vars, "admin_menus");

			foreach ($vars["role_id"] as $key => $value) {
				$relations[]=array("item_id"=>$value, "rel_item_id"=>$menu_id, "rel_type_id"=>1);
			}
			$this->universal_model->delete_item_where(array("rel_type_id"=>1, "rel_item_id"=>$menu_id), "relations");
			$this->universal_model->add_more_item($relations, "relations");

			$this->cache->delete_all();
			$data["status"] = array("status"=>"success","title"=>"Success", "icon"=>"check-circle", "msg"=>"Menu saved successfully.");
		}
		$data["menu_name"] = $this->menu_name();
		$data["all_menus"] = $this->adm_model->get_all_menus();
		$data["menu_item"] = $this->adm_model->get_menu_item($menu_id);
		$selected_roles = $this->universal_model->get_more_item("relations", array("rel_item_id"=>$menu_id, "rel_type_id"=>1));
		foreach ($selected_roles as $value) {
			$data["selected_roles"][] = $value->item_id;
		}
		$data["selected_roles"] = implode(",", $data["selected_roles"]);
		$data["roles"] = $this->adm_model->get_role_list();
		$this->home('admin/edit_admin_menu', $data);
	}
	public function delete_admin_menu()
	{
		$this->universal_model->delete_item_where(array("rel_type_id"=>1, "rel_item_id"=>$this->input->post("id")), "relations");
		$this->universal_model->delete_item_where(array("menu_id"=>$this->input->post("id")), "admin_menus");
		$result =  $this->universal_model->delete_item_where(array("menu_id"=>$this->input->post("id")), "admin_menus_id");
		if($result)
		{
			$this->cache->delete_all();
			echo '{"msg":"Menu successfully deleted.", "status":"success", "title":"Success!"}';
		}
		else
			echo '{"msg":"An error occured, please try again.", "status":"error", "title":"Error!"}';
	}
	public function save_menu_permissions()
	{
		$this->check_method(13);
		parse_str($this->input->post("data"), $vars);

		//print_r($vars["id"]);
		$result = $this->adm_model->update_menu_permissions($vars["id"], $this->input->post("role_id"));
		if($result)
		{
			echo '{"msg":"Menu permissions successfully updated.", "status":"success", "title":"Success!"}';
		}else
		{
			echo '{"msg":"An error occured, please try again.", "status":"error", "title":"Error!"}';
		}

	}
	public function get_menu_permissions($role_id)
	{
		$this->check_method(13);
		$data["menus"] = $this->adm_model->get_menu_list($role_id);
		$this->load->view('admin/get_menu_permissions', $data);
	}
	public function menu_managment()
	{
		$this->check_role();
		if($this->input->post())
		{
			$result = $this->adm_model->add_menu($this->input->post());
			if($result)
			{
				$data["status"] = array("status"=>"success", "msg"=>"New menu added successfully.");
			}else{

				$data["status"] = array("status"=>"danger", "msg"=>"An error occured, please try again.");
			}

		}
		if($this->input->get("msg"))
		$data["status"] = array("status"=>$this->input->get("status"), "msg"=>$this->input->get("msg"));

		$data["menus"] = $this->adm_model->get_all_admin_menus();
		$data["menu_name"] = $this->menu_name();
		$data["statuses"] = $this->adm_model->get_statuses();
		$data["menu_types"] = $this->adm_model->menu_types();
		$this->home('admin/menu_managment', $data); //0502841155
	}
	public function save_menu_order()
	{
		$this->check_method(12);
		$menus = $this->input->post("data");
		$result = $this->adm_model->save_menu_order($menus);
		if($result)
		{
			echo '{"msg":"Menu order successfully updated.", "status":"success", "title":"Success!"}';
		}else
		{
			echo '{"msg":"An error occured, please try again.", "status":"error", "title":"Error!"}';
		}
	}
	public function edit_menu($menu_id)
	{
		$this->check_method(12);
		$status="";
		$msg="";
		if($this->input->post())
		{
			$result = $this->adm_model->update_menu($this->input->post(), $menu_id);
			if($result)
			{
				$msg = "Menu successfully updated!";
				$status="success";
			}else
			{
				$msg = "An error occured, please try again.";
				$status="danger";
			}

			redirect("/adm/menu_managment/?msg=".$msg."&status=".$status);

		}else
		{
			$data["menus"] = $this->adm_model->get_all_admin_menus();
			$data["statuses"] = $this->adm_model->get_statuses();
			$data["menu_types"] = $this->adm_model->menu_types();
			$data["menu"] = $this->adm_model->get_menu($menu_id);
			$this->load->view("admin/edit_menu", $data);
		}

	}
	public function delete_menu()
	{
		$this->check_method(12);

		$result = $this->adm_model->delete_menu(array("id"=>$this->input->post("id"), "deleted"=>1));
		if($result)
		{
			echo '{"msg":"Menu successfully moved to trash.", "status":"success", "title":"Success!"}';
		}
		else
			echo '{"msg":"An error occured, please try again.", "status":"error", "title":"Error!"}';
	}

	public function add_admin_user()
	{
		if($this->input->post())
		{
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[50]');
			$this->form_validation->set_rules('full_name', 'Full name', 'required|max_length[50]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('role_id', 'Role', 'required');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

			if($this->form_validation->run() == TRUE)
      {
				$post_data = $this->input->post();
        $filtered_post = $this->filter_data($post_data);

				$password = $filtered_post['password'];
        $key = $this->config->item('encryption_key');
  			$salt1 = hash('sha512', $key.$password);
  			$salt2 = hash('sha512', $password.$key);
  			$hashed_password = md5(hash('sha512', $salt1.$password.$salt2));

				$user_array = array(
					'name' => $filtered_post['name'],
					'full_name' => $filtered_post['full_name'],
					'email' => $filtered_post['email'],
					'role_id' => (int) $filtered_post['role_id'],
					'gender' => (int) $filtered_post['gender'],
					'pass' => $hashed_password,
					'active' => 1,
					'deleted' => 0
				);

				$result = $this->adm_model->insert_item($user_array, 'users');

				if($result)
	        $data["status"] = array("status"=>"success","title"=>$this->langs->success_title, "icon"=>"check-circle", "msg"=>$this->langs->item_added_successfully);
	      else
	        $data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->error_title);
			}
		}
		$data['role_list'] = $this->adm_model->select_where('id, name', 'active=1 and deleted=0 and id != 1', 'users_role');
		$data['users_list'] = $this->adm_model->get_admin_users();

		$this->home('admin/add_admin_user', $data);
	}

	public function active_passive_admin_user()
	{
		if($this->input->post("id"))
		{
			$id = (int) $this->input->post('id');
			$active = (int) $this->input->post('active_passive');

			$result = $this->adm_model->update_item('id='.$id, array('active' => $active), 'users');

			if($result)
				echo '{"msg":"'.$this->langs->changed.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
	}

	public function delete_admin_user()
	{
		if($this->input->post("id"))
		{
			$id = (int) $this->input->post('id');

			$result = $this->adm_model->update_item('id='.$id, array('deleted' => 1), 'users');

			if($result)
				echo '{"msg":"'.$this->langs->successfully_deleted.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
	}

	public function add_role()
	{
		if($this->input->post())
		{
			$post_data = $this->input->post();
      $filtered_post = $this->filter_data($post_data);

			$role_array = array(
				'name' => $filtered_post['name'],
				'active' => 1,
				'deleted' => 0
			);

			$result = $this->adm_model->insert_item($role_array, 'users_role');

			if($result)
        $data["status"] = array("status"=>"success","title"=>$this->langs->success_title, "icon"=>"check-circle", "msg"=>$this->langs->item_added_successfully);
      else
        $data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->error_title);
		}

		$data['role_list'] = $this->adm_model->select_where('id, name, active', 'deleted=0 and id!=1', 'users_role');

		$this->home('admin/add_role', $data);
	}

	public function active_passive_role()
	{
		if($this->input->post("id"))
		{
			$id = (int) $this->input->post('id');
			$active = (int) $this->input->post('active_passive');

			$result = $this->adm_model->update_item('id='.$id, array('active' => $active), 'users_role');

			if($result)
				echo '{"msg":"'.$this->langs->changed.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
	}

	public function delete_role()
	{
		if($this->input->post("id"))
		{
			$id = (int) $this->input->post('id');

			$result = $this->adm_model->update_item('id='.$id, array('deleted' => 1), 'users_role');

			if($result)
				echo '{"msg":"'.$this->langs->successfully_deleted.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
	}

}
