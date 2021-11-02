<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Posts extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("posts_model");
	}

	public function communication_number()
	{
		if($this->input->post())
		{
			$postData = $this->input->post();
			$array = $this->filter_data($postData);

			$number = $array['number'];
			$result = $this->posts_model->update_number($number);

			$success_msg['1'] = 'Changes successfully saved';
			$success_msg['2'] = 'Dəyişikliklər uğurla yadda saxlanıldı';
			$success_msg['3'] = 'Изменения успешно сохранены';
			$success_msg['4'] = 'Deyişiklikler başarıyla kayd edildi';

			$error_msg['1'] = 'Something went wrong';
			$error_msg['2'] = 'Xəta baş verdi, təkrar cəhd edin';
			$error_msg['3'] = 'Что-то пошло не так';
			$error_msg['4'] = 'Hata baş verdi';

			if($result)
				$data["status"] = array("status"=>"success", "msg"=>$success_msg[$this->session->userdata('lang_id')], "title"=>"Success!", "icon"=>"check-circle");
			else
				$data["status"] = array("status"=>"error", "msg"=>$error_msg[$this->session->userdata('lang_id')], "title"=>"Error!", "icon"=>"exclamation-triangle");
		}
		$data['number'] = $this->posts_model->get_numbers();
		$this->home("posts/communication_number", $data);
	}

	public function admin_mail()
	{
		if($this->input->post())
		{
			$postData = $this->input->post();
			$array = $this->filter_data($postData);

			$mail = $array['mail'];
			$result = $this->posts_model->update_admin_mail($mail);

			$success_msg['1'] = 'Changes successfully saved';
			$success_msg['2'] = 'Dəyişikliklər uğurla yadda saxlanıldı';
			$success_msg['3'] = 'Изменения успешно сохранены';
			$success_msg['4'] = 'Deyişiklikler başarıyla kayd edildi';

			$error_msg['1'] = 'Something went wrong';
			$error_msg['2'] = 'Xəta baş verdi, təkrar cəhd edin';
			$error_msg['3'] = 'Что-то пошло не так';
			$error_msg['4'] = 'Hata baş verdi';

			if($result)
				$data["status"] = array("status"=>"success", "msg"=>$success_msg[$this->session->userdata('lang_id')], "title"=>"Success!", "icon"=>"check-circle");
			else
				$data["status"] = array("status"=>"error", "msg"=>$error_msg[$this->session->userdata('lang_id')], "title"=>"Error!", "icon"=>"exclamation-triangle");
		}
		$data['mail'] = $this->posts_model->get_admin_mail();
		$this->home("posts/admin_mail", $data);
	}

	public function site_description()
	{
		if($this->input->post())
		{
			$postData = $this->input->post();
			$array = $this->filter_data($postData);

			if(strlen($array['description_en'])>255 || strlen($array['description_az'])>255 || strlen($array['description_ru'])>255 || strlen($array['description_tr'])>255)
				$data["status"] = array("status"=>"error", "msg"=>"Text legth must be less than 256 simbols", "title"=>"Error!", "icon"=>"exclamation-triangle");
			else
			{
				$description_az = $array['description_az'];
				$description_en = $array['description_en'];
				$description_ru = $array['description_ru'];
				$description_tr = $array['description_tr'];
				$result = $this->posts_model->update_description($description_az, $description_ru, $description_en, $description_tr);

				$success_msg['1'] = 'Changes successfully saved';
				$success_msg['2'] = 'Dəyişikliklər uğurla yadda saxlanıldı';
				$success_msg['3'] = 'Изменения успешно сохранены';
				$success_msg['4'] = 'Deyişiklikler başarıyla kayd edildi';

				$error_msg['1'] = 'Something went wrong';
				$error_msg['2'] = 'Xəta baş verdi, təkrar cəhd edin';
				$error_msg['3'] = 'Что-то пошло не так';
				$error_msg['4'] = 'Hata baş verdi';

				if($result)
					$data["status"] = array("status"=>"success", "msg"=>$success_msg[$this->session->userdata('lang_id')], "title"=>"Success!", "icon"=>"check-circle");
				else
					$data["status"] = array("status"=>"error", "msg"=>$error_msg[$this->session->userdata('lang_id')], "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$data['description'] = $this->posts_model->get_description();
		$this->home("posts/site_description", $data);
	}

	public function maps()
	{
		$data = [];
		$data["langs"] = $this->adm_model->langs();
		if($this->input->get("map_id"))
		{

			$post = $this->universal_model->get_more_item("map", array("map_id"=>$this->input->get("map_id")), $isarray=1);

			//get_more_item_where($where, $table_name)
			//print_r($post);
			echo'<br /><div class="col-lg-12"><br />
			<h3>Redaktə</h3><br />
			<input type="hidden" name="lat" value="" />
			<input type="hidden" name="lng" value="" />
			<input type="hidden" name="map_id" value="" />
			</div>';
			foreach ($data["langs"] as $lang)
			{
				//$lang->lang_id
				echo '
				<div class="col-lg-3">
					<label>Ünvan <img style="max-width: 20px" src="/img/langs/'.$lang->thumb.'" style="margin-right: 5px" /></label>
					<input name="title-'.$lang->lang_id.'" class="form-control m-input" value="'.@$post[(array_search($lang->lang_id, array_column($post, 'lang_id')))]["title"].'" />
				</div>
				';
			}
			echo '<div class="col-lg-12">
				<label>	&nbsp;</label>
				<button rel="'.$this->input->get("map_id").'" type="button" class="btn btn-danger delete_marker float-right" style="margin-left: 30px;"><i class="fa fa-trash"></i> Ünvanı sil</button>
				<button type="button" class="btn btn-success save_marker float-right"><i class="fa fa-save"></i> Yadda saxla</button>

				<br /><br /><br />
			</div>';

		}else if($this->input->get("action")=="add_new")
		{
			parse_str($this->input->post("data"), $vars);
			$map_id= $this->universal_model->add_item(array("lat"=>$vars["lat"], "lng"=>$vars["lng"]), "map_id");
			if($map_id)
			{
				$array=[];
				foreach ($data["langs"] as $lang) {
						$array[] = [
								"lang_id" => $lang->lang_id,
								"map_id" => $map_id,
								"title" => @$vars["title-" . $lang->lang_id],
						];
				}
				$result = $this->universal_model->add_more_item($array, "map");

			}
			echo ($map_id?$map_id:"0");
		}else if($this->input->get("action")=="delete_marker")
		{
			$marker_id = $this->input->post("map_id");
			$this->universal_model->delete_item(array("map_id"=>$marker_id), "map");
			$this->universal_model->delete_item(array("map_id"=>$marker_id), "map_id");
			echo 1;
		}else if($this->input->get("action")=="save_marker")
		{
			parse_str($this->input->post("data"), $vars);
			$map_id= $this->universal_model->item_edit_save("map_id", array("map_id"=>$vars["map_id"]), array("lat"=>$vars["lat"], "lng"=>$vars["lng"]));
			$this->universal_model->delete_item(array("map_id"=>$vars["map_id"]), "map");

			$array=[];
			foreach ($data["langs"] as $lang) {
					$array[] = [
							"lang_id" => $lang->lang_id,
							"map_id" => $vars["map_id"],
							"title" => @$vars["title-" . $lang->lang_id],
					];
			}
			$result = $this->universal_model->add_more_item($array, "map");
			echo 1;
		}



		else {

			$data["markers"] = $this->posts_model->get_markers();
			$this->home("posts/maps", $data);
		}

	}
	public function social_icons()
	{
		$data = [];
		$data["list"] = $this->universal_model->get_all_item("social_icons");
		//print_r($data["list"]);
		$this->home("posts/social_icons", $data);
	}
	public function edit_social($id)
	{
		$data = [];

		if($this->input->post())
		{
			$vars = $this->input->post();
			$result = $this->universal_model->item_edit_save_where($vars, array("id"=>$id), "social_icons");
			if($result)
			{
				$data["status"] = array("status"=>"success", "msg"=>"Dəyişikliklər uğurla yadda saxlanıldı.", "title"=>"Success!", "icon"=>"check-circle");
			}else {
				$data["status"] = array("status"=>"error", "msg"=>"Xəta baş verdi, təkrar cəhd edin.", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$data["item"] = $this->universal_model->get_item("social_icons", array("id"=>$id));
		$this->home("posts/edit_social", $data);
	}
	public function delete_social()
	{
		$id = (int)$this->input->post("id");
		if($id)
		{
			$this->universal_model->delete_item_where(array("id"=>$id), "social_icons");
		}
		echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
	}
	public function social_set_active_passive()
	{
		if($this->input->post("id"))
		{
				//array("lang_id"=>((int)$this->input->post("id"))), array("active"=>((int)$this->input->post("active_passive")))
				$vars = array("active"=>(int)$this->input->post("active_passive"));
				$result = $this->universal_model->item_edit_save_where($vars, array("id"=>(int)$this->input->post("id")), "social_icons");
				if($result)
				{
						echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
				}else
				{
						echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
				}
		}
	}

	/*****Start Slides******/
	public function add_new_slide()
	{
		$data["langs"] = $this->adm_model->langs();
		if($this->input->post())
		{
			$langs = $this->cache->model("adm_model", "langs");
			$vars = $this->filter_data($this->input->post());
			$array=array();
			$slide_id_vars = array("active"=>$vars["active"], "slide_link"=>$vars["slide_link"]);
			$slide_id = $this->universal_model->add_item($slide_id_vars, "slide_id");
			$images = $this->upload_files($this->config->item('server_root').'/img/', $_FILES);
			foreach ($data["langs"] as $lang)
			{
				//echo $lang->lang_id."<br />";
				if(!isset($images[$lang->lang_id]))
				$vars["image-" . $lang->lang_id] = $vars["selected_thumb-" . $lang->lang_id];
				else {

						$full_path = $this->config->item('server_root')."/img/".$images[$lang->lang_id];
						$this->load->library('resize');
						$this->resize->getFileInfo($full_path);
						$this->resize->resizeImage(95, 95, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/slides/95x95/'.$images[$lang->lang_id], 80);
						$this->resize->resizeImage(900, 380, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/slides/'.$images[$lang->lang_id], 100);
						unlink($full_path);
						$vars["image-" . $lang->lang_id] = $images[$lang->lang_id];
					}
			}



			//print_r($vars);
			if($slide_id)
			{
				foreach ($data["langs"] as $lang) {
						$array[] = [
								"lang_id" => $lang->lang_id,
								"slide_id" => $slide_id,
								"image" => @$vars["image-" . $lang->lang_id],
						];
				}

				$result = $this->universal_model->add_more_item($array, "slide");
				$data["status"] = array("status"=>"success", "msg"=>"Yeni Slayd uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
			}else {
				$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$this->home("posts/add_new_slide", $data);
	}
	public function edit_slide($id)
	{
		$data["langs"] = $this->adm_model->langs();
		if($this->input->post())
		{
			$langs = $this->cache->model("adm_model", "langs");
			$vars = $this->filter_data($this->input->post());
			$array=array();
			$slide_id_vars = array("active"=>$vars["active"], "slide_link"=>$vars["slide_link"]);
			$this->universal_model->item_edit_save("slide_id", array("slide_id"=>$id), $slide_id_vars);
			$images = $this->upload_files($this->config->item('server_root').'/img/', $_FILES);
			//print_r($images);
			foreach ($data["langs"] as $lang)
			{
				//echo $lang->lang_id."<br />";
				if(!isset($images[$lang->lang_id]))
				$vars["image-" . $lang->lang_id] = @$vars["selected_thumb-" . $lang->lang_id];
				else {

						$full_path = $this->config->item('server_root')."/img/".$images[$lang->lang_id];
						$this->load->library('resize');
						$this->resize->getFileInfo($full_path);
						$this->resize->resizeImage(95, 95, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/slides/95x95/'.$images[$lang->lang_id], 80);
						$this->resize->resizeImage(900, 380, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/slides/'.$images[$lang->lang_id], 100);
						unlink($full_path);
						$vars["image-" . $lang->lang_id] = $images[$lang->lang_id];
					}
			}
			//print_r($vars);
			if($id)
			{
				$this->universal_model->delete_item_where(array("slide_id"=>$id), "slide");
				foreach ($data["langs"] as $lang) {
						$array[] = [
								"lang_id" => $lang->lang_id,
								"slide_id" => $id,
								"image" => @$vars["image-" . $lang->lang_id],
						];
				}

				$result = $this->universal_model->add_more_item($array, "slide");
				$data["status"] = array("status"=>"success", "msg"=>"Slayd uğurla yeniləndi.", "title"=>"Success!", "icon"=>"check-circle");
			}else {
				$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}



		}
		$data["slide"] = $this->posts_model->get_slide($id);
		$this->home("posts/edit_slide", $data);
	}
	private function do_upload2($file, $name, $targetFilePath)
	{
		$error ="";
		$msg = "";
		$allowTypes = array('gif','jpg','png','TIF','JPG','TIFF','JPEG','jpeg');

		if(empty($file['tmp_name']) || $file['tmp_name'] == 'none')
		{
			$error = 'Yüklənəcək fayl tapılmadı.';
		}else
		{
			// $images_arr = array();
			$image_name = $file['name'];
			$tmp_name   = $file['tmp_name'];
			$size       = $file['size'];
			$type       = $file['type'];
			$error      = $file['error'];

			$fileName = $name.strtotime(date("Y-m-d H:i:s"))."_".basename($file['name']);
			$targetFilePath = $targetFilePath.$fileName;

			$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			if(in_array($fileType, $allowTypes)){
					// Store new_img_slide on the server
					if(move_uploaded_file($file['tmp_name'],$targetFilePath)){
						return array("full_path"=>$targetFilePath, "file_name"=>$fileName);
					}
			}
		}
	}
	public function slide_set_active_passive()
	{

	}
	public function delete_slide()
	{
		$id = (int)$this->input->post("id");
		if($id)
		{
			$this->universal_model->delete_item_where(array("slide_id"=>$id), "slide_id");
			$this->universal_model->delete_item_where(array("slide_id"=>$id), "slide");
		}
		echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
	}
	public function slides()
	{
		$data["list"]=$this->posts_model->slides();
		$this->home("posts/slides", $data);
	}
	/*****End Slides******/
	/*****Order status START******/
	public function edit_post($post_id)
	{
		$data=[];
		$this->load->helper("form");
		$data["langs"] = $this->adm_model->langs();
		if($this->input->post())
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('date_time', "Yayımlanma tarixi", 'trim|required');
			$this->form_validation->set_rules('active', "Aktiv/Passiv", 'trim');

			$news_category_id = $this->input->post("post_cat_id");

			if($this->form_validation->run() == TRUE)
			{
				$vars = $this->input->post();
				$array = array();
				$thumb="";
				//echo $vars["date_time"];
				$post_id_vars = array("date_time"=>date("Y-m-d H:i", strtotime($vars["date_time"])), "active"=>$vars["active"]);
				unset($vars["active"]);
				unset($vars["date_time"]);

				$img="";
				if(empty($_FILES['thumb']['tmp_name']) || $_FILES['thumb']['tmp_name'] == 'none')
				{

				}else
				{
					$img_name = "blog";
					$img = $this->do_upload("thumb", $this->config->item('server_root').'/img/', 150000, $img_name);
					if(@$img["error"]==TRUE)
					{
						$error = $img["error"];
					}else{

						$this->load->library('resize');
						$this->resize->getFileInfo($img['full_path']);
						$this->resize->resizeImage(95, 95, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/blogs/95x95/'.$img["file_name"], 75);
						$this->resize->resizeImage(1200, 650, 'auto');
						$this->resize->saveImage($this->config->item('server_root').'/img/blogs/auto/'.$img["file_name"], 75);
						$this->resize->resizeImage(810, 550, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/blogs/810x550/'.$img["file_name"], 85);
						$this->resize->resizeImage(400, 270, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/blogs/400x270/'.$img["file_name"], 85);
						unlink($img['full_path']);
						$post_id_vars["thumb"] = $img["file_name"];
						unset($vars["selected_thumb"]);
					}

				}
				if(!isset($post_id_vars["thumb"]))
				$post_id_vars["thumb"] = @$vars["selected_thumb"]?$vars["selected_thumb"]:"";

				$this->universal_model->item_edit_save_where($post_id_vars, array("post_id"=>$post_id), "posts_id");
				$relations=array();
				//$this->universal_model->delete_item(array("rel_type_id"=>4, "item_id"=>$post_id), "relations");
				foreach ($vars["post_cat_id"] as $key => $value) {
					$relations[]=array("item_id"=>$post_id, "rel_item_id"=>$value, "rel_type_id"=>4);
				}
				$this->universal_model->delete_item_where(array("rel_type_id"=>4, "item_id"=>$post_id), "relations");
				$this->universal_model->add_more_item($relations, "relations");

				$post_vars = array();
				foreach ($data["langs"] as $lang) {
						$post_vars[] = [
								"lang_id" => $lang->lang_id,
								"post_id" => $post_id,
								"title" => $vars["title-" . $lang->lang_id],
								"description" => $vars["description-" . $lang->lang_id],
								"content" => $vars["content-" . $lang->lang_id]
						];
				}
				$this->universal_model->delete_item_where(array("post_id"=>$post_id), "posts");
				$result = $this->universal_model->add_more_item($post_vars, "posts");

				if($result)
				{
					$data["status"] = array("status"=>"success","title"=>"Success", "icon"=>"check-circle", "msg"=>'Yazı uğurla yeniləndi.');
				}else{

					$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi, təkrar cəhd edin!");
				}


			}else
			{
				$data["status"] = array("status"=>"danger", "msg"=>"Zəhmət olmasa məcburi xanalrı dodlurun!");
			}

		}
		//$data["thumbs"] = $this->posts_model->get_thumbs(0);
		$data["post"] = $this->posts_model->post_item($post_id);
		//print_r($data["post"]);
		$data["selected_cat_id"]=$this->universal_model->get_more_item("relations", array("rel_type_id"=>4, "item_id"=>$post_id),1);
		$data["cats"] = $this->posts_model->get_categories();
		$data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
		$this->home("posts/edit_post", $data);
	}
	public function add_new_post()
	{
		$data=[];
		$data["langs"] = $this->adm_model->langs();
		$this->load->helper("form");
		if($this->input->post())
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('date_time', "Yayımlanma tarixi", 'trim|required');
			$this->form_validation->set_rules('active', "Aktiv/Passiv", 'trim');

			$news_category_id = $this->input->post("news_category_id");

			if($this->form_validation->run() == TRUE)
			{
				$vars = $this->input->post();
				$array = array();
				$thumb="";
				$post_id_vars = array("date_time"=>date("Y-m-d H:i", strtotime($vars["date_time"])), "active"=>$vars["active"]);
				unset($vars["active"]);
				unset($vars["date_time"]);

				$img="";
				if(empty($_FILES['thumb']['tmp_name']) || $_FILES['thumb']['tmp_name'] == 'none')
				{

				}else
				{
					$img_name = "blog";
					$img = $this->do_upload("thumb", $this->config->item('server_root').'/img/', 150000, $img_name);
					if(@$img["error"]==TRUE)
					{
						$error = $img["error"];
					}else{

						$this->load->library('resize');
						$this->resize->getFileInfo($img['full_path']);
						$this->resize->resizeImage(95, 95, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/blogs/95x95/'.$img["file_name"], 75);
						$this->resize->resizeImage(1200, 650, 'auto');
						$this->resize->saveImage($this->config->item('server_root').'/img/blogs/auto/'.$img["file_name"], 75);
						$this->resize->resizeImage(810, 550, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/blogs/810x550/'.$img["file_name"], 85);
						$this->resize->resizeImage(400, 270, 'crop');
						$this->resize->saveImage($this->config->item('server_root').'/img/blogs/400x270/'.$img["file_name"], 85);
						unlink($img['full_path']);
						$post_id_vars["thumb"] = $img["file_name"];
						unset($vars["selected_thumb"]);
					}
					print_r($img);

				}
				if(@$vars["selected_thumb"])
				$post_id_vars["thumb"] = $vars["selected_thumb"];

				$post_id = $this->universal_model->add_item($post_id_vars, "posts_id");
				$relations=array();
				//$this->universal_model->delete_item(array("rel_type_id"=>4, "item_id"=>$post_id), "relations");
				foreach ($vars["post_cat_id"] as $key => $value) {
					$relations[]=array("item_id"=>$post_id, "rel_item_id"=>$value, "rel_type_id"=>4);
				}
				$this->universal_model->add_more_item($relations, "relations");
				unset($vars["post_cat_id"]);


				$post_vars = array();
				foreach ($data["langs"] as $lang) {
						$post_vars[] = [
								"lang_id" => $lang->lang_id,
								"post_id" => $post_id,
								"title" => $vars["title-" . $lang->lang_id],
								"description" => $vars["description-" . $lang->lang_id],
								"content" => $vars["content-" . $lang->lang_id]
						];
				}
				$result = $this->universal_model->add_more_item($post_vars, "posts");

				if($result)
				{
					/*if(!$category_id)
					$category_id = array(0=>2);*/
					//$this->posts_model->update_thumb_post_id($result);
					//$this->posts_model->update_news_category($result, $category_id);
					//$data["status"] = array("status"=>"success", "msg"=>'Yeni yazı uğurla əlavə edildi. Əlavə edilmiş yazını bu <a href="/posts/edit_news/'.$result.'">linkdən</a> redaktə edə bilərsiniz.');
					redirect("posts/edit_post/".$post_id."/TRUE/");
				}else{

					$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi, təkrar cəhd edin!");
				}


			}else
			{
				$data["status"] = array("status"=>"danger", "msg"=>"Zəhmət olmasa məcburi xanalrı dodlurun!");
			}

		}
		//$data["thumbs"] = $this->posts_model->get_thumbs(0);
		$data["cats"] = $this->posts_model->get_categories();
		$data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
		$this->home("posts/add_new_post", $data);
	}
	public function post_list()
	{
		$end =30;
		$data["pagination"] = "";
		$data["set_vars"]="";
		$base_url = "/posts/post_list/";
		$from=0;
		if($this->input->get("page"))
				$from = (int)str_replace(array("'", '"',"`"), array("","",""), $this->security->xss_clean(strip_tags($this->input->get("page"))));
		$data["filter"] = $this->filter_data($this->input->get());
		$result = $this->posts_model->post_list($data["filter"], $from, $end);
		$data["total_row"] = $result["total_row"];
		$data["list"] = $result["list"];
		if($data["total_row"]>=1)
				$data["pagination"] = $this->pagination($from, $end, $base_url, $data["total_row"], 3, 5);

		$this->home("posts/post_list", $data);
	}





	public function delete_post()
	{
			$id = (int)$this->input->post("id");
			if($id)
			{
				$this->universal_model->delete_item_where(array("rel_type_id"=>4, "item_id"=>$id), "relations");
				$this->universal_model->delete_item_where(array("post_id"=>$id), "posts");
				$this->universal_model->delete_item_where(array("post_id"=>$id), "posts_id");

			}
			echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
	}

	public function cargo()
	{
		$data = [];
		if($this->input->post())
		{
			$vars = $this->filter_data($this->input->post());
			$array=array();
			$region_id_vars = array("active"=>$vars["active"], "parent_id"=>$vars["parent_id"], "price"=>$vars["price"]);
			$region_id = $this->universal_model->add_item($region_id_vars, "regions_id");
			$data["langs"] = $this->adm_model->langs();
			if($region_id)
			{

				foreach ($data["langs"] as $lang) {
						$array[] = [
								"lang_id" => $lang->lang_id,
								"name" => $vars["name-" . $lang->lang_id],
								"region_id"=>$region_id
						];
				}
				$result = $this->universal_model->add_more_item($array, "regions");
				$data["status"] = array("status"=>"success", "msg"=>"Yeni məlumat uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
			}else {
				$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$data["list"] = $this->posts_model->cargo_list();
		$this->home("posts/cargo", $data);
	}
	public function edit_cargo($region_id)
	{
		$data = [];
		if($this->input->post())
		{
			$vars = $this->input->post();
			$array=array();
			$region_id_vars = array("active"=>$vars["active"], "parent_id"=>$vars["parent_id"], "price"=>$vars["price"]);
			$this->universal_model->item_edit_save_where($region_id_vars, array("region_id"=>$region_id), "regions_id");
			$this->universal_model->delete_item(array("region_id"=>$region_id), "regions");
			$data["langs"] = $this->adm_model->langs();
			if($region_id)
			{

				foreach ($data["langs"] as $lang) {
						$array[] = [
								"lang_id" => $lang->lang_id,
								"name" => $vars["name-" . $lang->lang_id],
								"region_id"=>$region_id
						];
				}
				$result = $this->universal_model->add_more_item($array, "regions");
				$data["status"] = array("status"=>"success", "msg"=>"Yeni məlumat uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
			}else {
				$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$data["item"] = $this->posts_model->get_cargo($region_id);
		$data["list"] = $this->posts_model->cargo_list();
		$this->home("posts/edit_cargo", $data);
	}
	function delete_cargo()
	{
		$id = (int)$this->input->post("id");
		if($id)
		{
			$this->universal_model->delete_item(array("region_id"=>$id), "regions");
			$this->universal_model->delete_item(array("region_id"=>$id), "regions_id");
		}
		echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
	}
	public function cargo_set_active_passive()
	{
		if($this->input->post("id"))
		{
				//array("lang_id"=>((int)$this->input->post("id"))), array("active"=>((int)$this->input->post("active_passive")))
				$vars = array("active"=>(int)$this->input->post("active_passive"));
				$result = $this->universal_model->item_edit_save_where($vars, array("region_id"=>(int)$this->input->post("id")), "regions_id");

				if($result)
				{
						echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
				}else
				{
						echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
				}
		}
	}
	function file_upload()
	{
		$error = "";
		$msg = "";
		//$this->load->library('doc_to_pdf/bootstrap.php');

		if(empty($_FILES['file_upload']['tmp_name']) || $_FILES['file_upload']['tmp_name'] == 'none')
		{
			$error = 'Yüklənəcək fayl tapılmadı.';
		}
		else
		{
			//$img_name = $this->convert_str($this->input->get("full_name_az"));
			$img = $this->do_upload("file_upload", $this->config->item('server_root').'/uploads/', 1500000);
			if(@$img["error"]==TRUE)
			{
				$error = $img["error"];
			}
			else
			{
				$msg = $img["file_name"];
			}
		}
			echo "{";
			echo				"error: '" . $error . "',\n";
			echo				"file_name: '" . $msg . "'\n";
			echo "}";
	}
	public function img_upload()
	{
		$error = "";
		$msg = "";
		if(empty($_FILES['image_upload']['tmp_name']) || $_FILES['image_upload']['tmp_name'] == 'none')
		{
			$error = 'Yüklənəcək Şəkil tapılmadı..';
		}
		else
		{
			$img = $this->do_upload("image_upload", $this->config->item('server_root').'/img/blogs/', 150000);
			if(@$img["error"]==TRUE)
			{
				$error = $img["error"];
			}
			else
			{
				$this->load->library('resize');
				$this->resize->getFileInfo($img['full_path']);
				$this->resize->resizeImage(95, 95, 'crop');
				$this->resize->saveImage($this->config->item('server_root').'/img/blogs/95x95/'.$img["file_name"], 75);
				$this->resize->resizeImage(1200, 650, 'auto');
				$this->resize->saveImage($this->config->item('server_root').'/img/blogs/auto/'.$img["file_name"], 75);
				$this->resize->resizeImage(810, 550, 'crop');
				$this->resize->saveImage($this->config->item('server_root').'/img/blogs/810x550/'.$img["file_name"], 85);
				$this->resize->resizeImage(400, 270, 'crop');
				$this->resize->saveImage($this->config->item('server_root').'/img/blogs/400x270/'.$img["file_name"], 85);
				unlink($img['full_path']);
				$msg = $img["file_name"];
			}
		}
			echo "{";
			echo				"error: '" . $error . "',\n";
			echo				"img_name: '" . $msg . "',\n";
			echo "}";
	}









}
