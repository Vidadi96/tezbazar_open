<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Brand extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("product_model");
	}
// 	<entry key='database.driver'>com.microsoft.sqlserver.jdbc.SQLServerDriver</entry>
// <entry key='database.url'>jdbc:sqlserver://172.16.3.21:1433;user=gps1;password=turan1;databaseName=gps2;</entry>
// <entry key='database.user'>gps1</entry>
// <entry key='database.password'>turan1</entry>

	/*****CATEGORIES START******/
	public function brands()
	{
		$data = array();
		$data["filter"] = $this->filter_data($this->input->get());
		$data["filter"]["end"]=20;
		$data["filter"]["from"]=0;
		if($this->input->get("page"))
		$data["filter"]["from"] = (int)$this->input->get("page");
		$data["list"] = $this->product_model->brands($data["filter"]);

		$this->home('brand/brands', $data);
	}
	public function add_brand()
	{
		$data["langs"] = $this->adm_model->langs();
		if($this->input->post())
		{
			$langs = $this->cache->model("adm_model", "langs");
			$vars = $this->filter_data($this->input->post());
			$array=array();
			$brand_id_vars = array("active"=>$vars["active"], "discount_id"=>$vars["discount_id"]);

			$img="";
			if(empty($_FILES['thumb']['tmp_name']) || $_FILES['thumb']['tmp_name'] == 'none')
			{

			}else
			{
				$img_name = "brand";
				$img = $this->do_upload("thumb", $this->config->item('server_root').'img/', 150000, $img_name);
				if(@$img["error"]==TRUE)
				{
					$error = $img["error"];
				}else{

					$this->load->library('resize');
					$this->resize->getFileInfo($img['full_path']);
					$this->resize->resizeImage(350, 210, 'crop');
					$this->resize->saveImage($this->config->item('server_root').'img/brands/'.$img["file_name"], 80);
					unlink($img['full_path']);
					$brand_id_vars["thumb"] = $img["file_name"];
				}

			}
			$brand_id = $this->universal_model->add_item($brand_id_vars, "brands_id");
			unset($vars["active"]);
			unset($vars["discount_id"]);
			if($brand_id)
			{
				foreach ($data["langs"] as $lang) {
					$brand_name=	$description= $thumb= $seo_url= $seo_title= $seo_keywords= $seo_description="";
					foreach ($vars as $key => $value) {
						$name = explode("-", $key);
						if($lang->lang_id==@$name[1])
						{
							if($name[0]=="name")
							$cat_name=$value;
							else if($name[0]=="description")
							$description=$value;
							else if($name[0]=="seo_url")
							$seo_url=$value;
							else if($name[0]=="seo_title")
							$seo_title=$value;
							else if($name[0]=="seo_keywords")
							$seo_keywords=$value;
							else if($name[0]=="seo_description")
							$seo_description=$value;
						}
					}
					$array[] = array("name"=>$cat_name, "description"=>$description, "seo_url"=>$seo_url,"seo_title"=>$seo_title, "seo_keywords"=>$seo_keywords, "seo_description"=>$seo_description, "brand_id"=>$brand_id, "lang_id"=>$lang->lang_id);
				}

				$result = $this->universal_model->add_more_item($array, "brands");
				$data["status"] = array("status"=>"success", "msg"=>"Yeni Marka uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
			}else {
				$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$data["discount_id"]= $this->product_model->discount_id();
		$data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
		$this->home('brand/add_brand', $data);
	}

	public function edit_brand($brand_id)
	{
		$brand_id = (int)$brand_id;
		$data["langs"] = $this->adm_model->langs();
		if($this->input->post())
		{
			$langs = $this->cache->model("adm_model", "langs");
			$vars = $this->filter_data($this->input->post());
			$array=array();
			$brand_id_vars = array("active"=>$vars["active"], "discount_id"=>$vars["discount_id"]);
			$img="";
			if(empty($_FILES['thumb']['tmp_name']) || $_FILES['thumb']['tmp_name'] == 'none')
			{

			}else
			{
				$img_name = "brand";
				$img = $this->do_upload("thumb", $this->config->item('server_root').'/img/', 150000, $img_name);
				if(@$img["error"]==TRUE)
				{
					$error = $img["error"];
				}else{

					$this->load->library('resize');
					$this->resize->getFileInfo($img['full_path']);
					$this->resize->resizeImage(350, 210, 'auto');
					$this->resize->saveImage($this->config->item('server_root').'/img/brands/'.$img["file_name"], 80);
					unlink($img['full_path']);
					$brand_id_vars["thumb"] = $img["file_name"];
				}
				print_r($img);

			}
			$result = $this->universal_model->item_edit_save_where($brand_id_vars, array("brand_id"=>$brand_id), "brands_id");
			unset($vars["active"]);
			unset($vars["discount_id"]);
			if($brand_id)
			{
				$array = array();
				foreach ($data["langs"] as $lang) {
					$brand_name=	$description= $thumb= $seo_url= $seo_title= $seo_keywords= $seo_description="";
					foreach ($vars as $key => $value) {
						$name = explode("-", $key);
						if($lang->lang_id==@$name[1])
						{
							if($name[0]=="title")
							$brand_name=$value;
							else if($name[0]=="description")
							$description=$value;
							else if($name[0]=="seo_url")
							$seo_url=$value;
							else if($name[0]=="seo_title")
							$seo_title=$value;
							else if($name[0]=="seo_keywords")
							$seo_keywords=$value;
							else if($name[0]=="seo_description")
							$seo_description=$value;
						}
					}
					$brand_var =  array("name"=>$brand_name, "description"=>$description, "seo_url"=>$seo_url,"seo_title"=>$seo_title, "seo_keywords"=>$seo_keywords, "seo_description"=>$seo_description, "brand_id"=>$brand_id, "lang_id"=>$lang->lang_id);

					$result = $this->universal_model->item_edit_save("brands", array("brand_id"=>$brand_id, "lang_id"=>$lang->lang_id), $brand_var);
					if(!$result)
					{
						$result = $this->universal_model->add_item($brand_var, "brands");
					}
				}

				//$result = $this->universal_model->add_more_item($array, "brands");
				$data["status"] = array("status"=>"success", "msg"=>"Marka uğurla yeniləndi.", "title"=>"Success!", "icon"=>"check-circle");
			}else {
				$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$data["discount_id"]= $this->product_model->discount_id();
		$data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
		$data["items"]= $this->product_model->edit_brand($brand_id);
		//print_r($data["items"]);
		$this->home('brand/edit_brand', $data);
	}
	public function delete_category()
	{
		if($this->input->post("id"))
		{
			$this->universal_model->item_edit_save_where(array("deleted"=>1), array("brand_id"=>$this->input->post("id")), "brands_id");
			echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
		}else {
			echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
		}
	}
	public function category_set_active_passive()
	{
		if($this->input->post("id"))
		{
			$result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("brand_id"=>(int)$this->input->post("id")), "brands_id");
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
	/*****CATEGORIES END******/














}
