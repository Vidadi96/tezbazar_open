<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Slides extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("SlidesModel");
	}

  function get_view_main()
  {
		$active_passive = $time = 0;
    $data['slides'] = $this->SlidesModel->get_view_main('slide1', '100x50');
		$array = $this->SlidesModel->get_slide_settings('slide1');
		if(count($array)>0)
		{
			foreach($array as $row)
			{
				$active_passive = $row->active_passive;
				$time = $row->time;
			}
		}

		$data['active_passive'] = $active_passive;
		$data['time'] = $time;
    $this->home('slide/main_slide', $data);
  }

	function get_view_brands()
  {
		$active_passive = $time = 0;
    $data['slides'] = $this->SlidesModel->get_view_main('brands_slide', '60x30');
		$array = $this->SlidesModel->get_slide_settings('brands_slide');
		if(count($array)>0)
		{
			foreach($array as $row)
			{
				$active_passive = $row->active_passive;
				$time = $row->time;
			}
		}

		$data['active_passive'] = $active_passive;
		$data['time'] = $time;
    $this->home('slide/brands_slide', $data);
  }

	function partners_slide()
  {
		$active_passive = $time = 0;
    $data['slides'] = $this->SlidesModel->get_view_main('partners_slide', '60x30');
		$array = $this->SlidesModel->get_slide_settings('partners_slide');
		if(count($array)>0)
		{
			foreach($array as $row)
			{
				$active_passive = $row->active_passive;
				$time = $row->time;
			}
		}

		$data['active_passive'] = $active_passive;
		$data['time'] = $time;
    $this->home('slide/partners_slide', $data);
  }

	function img_upload_main()
	{
		$error = "";
		$msg = "";
		$name = "";
		$link = "";
		if($this->input->post())
		{
			$postData = $this->input->post();
			$filteredPostData = $this->filter_data($postData);
			$link = $filteredPostData['link'];
		}

		if(empty($_FILES['image_upload']['tmp_name']) || $_FILES['image_upload']['tmp_name'] == 'none')
		{
			$error = 'Yüklənəcək Şəkil tapılmadı..';
		}
		else
		{
			$name = $this->input->post('slide_name');
			$img = $this->do_upload("image_upload", $this->config->item('server_root').'/img/slides/', 20000, '', 'jpg|png|JPEG|jpeg');
			if(@$img["error"]==TRUE)
			{
				$error = $img["error"];
			}
			else
			{
				$this->load->library('resize');
				$this->resize->getFileInfo($img['full_path']);
				if($name == 'slide1')
				{
					$this->resize->resizeImage(100, 50, 'auto');
					$this->resize->saveImage($this->config->item('server_root').'/img/slides/100x50/'.$img["file_name"], 75);
					$this->resize->resizeImage(1000, 500, 'auto');
					$this->resize->saveImage($this->config->item('server_root').'/img/slides/1000x500/'.$img["file_name"], 75);
					unlink($img['full_path']);
					$msg = $img["file_name"];
					$this->SlidesModel->img_upload_main('/img/slides/100x50/'.$img["file_name"], '/img/slides/1000x500/'.$img["file_name"], $img["file_name"], $name, '100x50', '1000x500', $link);
				}
				else if($name == 'brands_slide' || $name == 'partners_slide')
				{
					$this->resize->resizeImage(60, 30, 'auto');
					$this->resize->saveImage($this->config->item('server_root').'/img/slides/60x30/'.$img["file_name"], 75);
					$this->resize->resizeImage(90, 90, 'auto');
					$this->resize->saveImage($this->config->item('server_root').'/img/slides/90x90/'.$img["file_name"], 75);
					unlink($img['full_path']);
					$msg = $img["file_name"];
					$this->SlidesModel->img_upload_main('/img/slides/60x30/'.$img["file_name"], '/img/slides/90x90/'.$img["file_name"], $img["file_name"], $name, '60x30', '90x90', $link);
				}
			}
		}
		if($name == "slide1")
			redirect('/slides/get_view_main?error='.$error.'&img_name='.$msg);
		else if($name == "brands_slide")
			redirect('/slides/get_view_brands?error='.$error.'&img_name='.$msg);
		else if($name == "partners_slide")
			redirect('/slides/partners_slide?error='.$error.'&img_name='.$msg);
	}

	function delete_slide_main()
	{
			$image_name = '';
			$id = (int)$this->input->post("id");
			if($id)
			{
				$response = $this->SlidesModel->get_image_name_main($id);
				foreach($response as $row)
				{
					$image_name = $row->image_name;
				}

				$destination = [];
				if($image_name)
					$destination = $this->SlidesModel->get_destination_main($image_name);

				if(count($destination)>0)
				{
					foreach($destination as $row)
					{
						unlink($_SERVER['DOCUMENT_ROOT'].$row->destination);
					}
				}

				$this->SlidesModel->delete_slide_main($image_name);
			}
			echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
	}

	function save_settings_main()
	{
		$response = false;
		if($this->input->post())
		{
			$time = 0;
			$time = (int)$this->input->post('change_time');
			$active = (int)$this->input->post('active');
			$name = $this->input->post('slide_name');

			$response = $this->SlidesModel->save_settings($name, $time, $active);
		}

		if($response)
		{
			if($name == "slide1")
				redirect('/slides/get_view_main?message=saved');
			else if($name == "brands_slide")
				redirect('/slides/get_view_brands?message=saved');
			else if($name == "partners_slide")
				redirect('/slides/partners_slide?message=saved');
			else if($name == "daily_products")
				redirect('/slides/daily_products?message=saved');
		}	else {
			if($name == "slide1")
				redirect('/slides/get_view_main?message=error');
			else if($name == "brands_slide")
				redirect('/slides/get_view_brands?message=error');
			else if($name == "partners_slide")
				redirect('/slides/partners_slide?message=error');
			else if($name == "daily_products")
				redirect('/slides/daily_products?message=error');
		}
	}

	function daily_products()
  {
		$active_passive = $time = 0;
		$array = $this->SlidesModel->get_slide_settings('daily_products');
		if(count($array)>0)
		{
			foreach($array as $row)
			{
				$active_passive = $row->active_passive;
				$time = $row->time;
			}
		}

		$data['active_passive'] = $active_passive;
		$data['time'] = $time;
    $this->home('slide/daily_products', $data);
  }
}
