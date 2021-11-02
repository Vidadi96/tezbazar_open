<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vacancy extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("vacancy_model");
	}

	public function edit_vacancy($vacancy_id)
	{
		$data=[];
		$this->load->helper("form");
		$data["langs"] = $this->adm_model->langs();
		if($this->input->post())
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('date_time', "Vakansiyanın bitmə tarixi", 'trim|required');
			$this->form_validation->set_rules('active', "Aktiv/Passiv", 'trim');
			if($this->form_validation->run() == TRUE)
			{
				$vars = $_POST;
				$array = array();
				$thumb="";
				//echo $vars["date_time"];
				$vacancy_id_vars = array("date_time"=>date("Y-m-d H:i", strtotime($vars["date_time"])), "active"=>$vars["active"]);
				unset($vars["active"]);
				unset($vars["date_time"]);

				$img="";
				if(empty($_FILES['thumb']['tmp_name']) || $_FILES['thumb']['tmp_name'] == 'none')
				{

				}else
				{
					$img_name = "vacancy";
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
						$vacancy_id_vars["thumb"] = $img["file_name"];
						unset($vars["selected_thumb"]);
					}

				}
				if(@$vars["selected_thumb"])
				$vacancy_id_vars["thumb"] = $vars["selected_thumb"];

				$this->universal_model->item_edit_save_where($vacancy_id_vars, array("vacancy_id"=>$vacancy_id), "vacancy_id");

				$vacancy_vars = array();
				foreach ($data["langs"] as $lang) {
						$vacancy_vars[] = [
								"lang_id" => $lang->lang_id,
								"vacancy_id" => $vacancy_id,
								"title" => $vars["title-" . $lang->lang_id],
								"content" => $vars["content-" . $lang->lang_id]
						];
				}
				$this->universal_model->delete_item_where(array("vacancy_id"=>$vacancy_id), "vacancy");
				$result = $this->universal_model->add_more_item($vacancy_vars, "vacancy");

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
		//$data["thumbs"] = $this->vacancy_model->get_thumbs(0);
		$data["post"] = $this->vacancy_model->vacancy_item($vacancy_id);
		$data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
		$this->home("vacancy/edit_vacancy", $data);
	}
	public function add_new_vacancy()
	{
		$data=[];
		$data["langs"] = $this->adm_model->langs();
		$this->load->helper("form");
		if($this->input->post())
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('date_time', "Bitiş tarixi", 'trim|required');
			$this->form_validation->set_rules('active', "Aktiv/Passiv", 'trim');

			if($this->form_validation->run() == TRUE)
			{
				$vars = $this->input->post();
				$array = array();
				$thumb="";
				$vacancy_id_vars = array("date_time"=>date("Y-m-d H:i", strtotime($vars["date_time"])), "active"=>$vars["active"]);
				unset($vars["active"]);
				unset($vars["date_time"]);

				$img="";
				if(empty($_FILES['thumb']['tmp_name']) || $_FILES['thumb']['tmp_name'] == 'none')
				{

				}else
				{
					$img_name = "vacancy";
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
						$vacancy_id_vars["thumb"] = $img["file_name"];
						unset($vars["selected_thumb"]);
					}
					//print_r($img);

				}
				if(@$vars["selected_thumb"])
				$vacancy_id_vars["thumb"] = $vars["selected_thumb"];

				$vacancy_id = $this->universal_model->add_item($vacancy_id_vars, "vacancy_id");

				$vacancy_vars = array();
				foreach ($data["langs"] as $lang) {
						$vacancy_vars[] = [
								"lang_id" => $lang->lang_id,
								"vacancy_id" => $vacancy_id,
								"title" => $vars["title-" . $lang->lang_id],
								"content" => $vars["content-" . $lang->lang_id]
						];
				}
				$result = $this->universal_model->add_more_item($vacancy_vars, "vacancy");

				if($result)
				{
					redirect("vacancy/edit_vacancy/".$vacancy_id."/TRUE/");
				}else{
					$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi, təkrar cəhd edin!");
				}


			}else
			{
				$data["status"] = array("status"=>"danger", "msg"=>"Zəhmət olmasa məcburi xanalrı dodlurun!");
			}

		}
		$data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
		$this->home("vacancy/add_new_vacancy", $data);
	}
	public function vacancy_list()
	{
		$end =30;
		$data["pagination"] = "";
		$data["set_vars"]="";
		$base_url = "/vacancy/vacancy_list/";
		$data["list"] = $this->vacancy_model->vacancy_list();
		$this->home("vacancy/vacancy_list", $data);
	}





	public function delete_vacancy()
	{
			$id = (int)$this->input->post("id");
			if($id)
			{
				$this->universal_model->delete_item_where(array("vacancy_id"=>$id), "vacancy");
				$this->universal_model->delete_item_where(array("vacancy_id"=>$id), "vacancy_id");

			}
			echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
	}
	public function vacancy_set_active_passive()
	{
			if($this->input->post("id"))
			{
					$result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("vacancy_id"=>(int)$this->input->post("id")), "vacancy_id");
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
	function file_upload()
	{
		$error = "";
		$msg = "";
		//$this->load->library('doc_to_pdf/bootstrap.php');

		if(empty($_FILES['file_upload']['tmp_name']) || $_FILES['file_upload']['tmp_name'] == 'none')
		{
			$error = 'Yüklənəcək fayl tapılmadı.';
		}else
		{
			//$img_name = $this->convert_str($this->input->get("full_name_az"));
			$img = $this->do_upload("file_upload", $this->config->item('server_root').'/uploads/', 1500000);
			if(@$img["error"]==TRUE)
			{
				$error = $img["error"];
			}else{

				$msg = $img["file_name"];
			}
		}
			echo "{";
			echo				"error: '" . $error . "',\n";
			echo				"file_name: '" . $msg . "'\n";
			echo "}";
	}
	public	function img_upload()
	{
		$error = "";
		$msg = "";
		if(empty($_FILES['file_upload']['tmp_name']) || $_FILES['file_upload']['tmp_name'] == 'none')
		{
			$error = 'Yüklənəcək Şəkil tapılmadı..';
		}else
		{
			$img = $this->do_upload("file_upload", $this->config->item('server_root').'/img/blogs/', 150000);
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
				$msg = $img["file_name"];
			}
		}
			echo "{";
			echo				"error: '" . $error . "',\n";
			echo				"img_name: '" . $msg . "',\n";
			echo "}";
	}










}
