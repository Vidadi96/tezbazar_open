<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class warehouse extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("warehouse_model");
	}

	/*****WAREHOUSE START******/
	public function warehouses()
	{
		$data = array();
		$data["filter"] = $this->filter_data($this->input->get());
		$data["filter"]["end"]=20;
		$data["filter"]["from"]=0;
		if($this->input->get("page"))
		$data["filter"]["from"] = (int)$this->input->get("page");
		$data["list"] = $this->warehouse_model->warehouses($data["filter"]);

		$this->home('warehouse/warehouses', $data);
	}

	public function add_warehouse()
	{
		$data["langs"] = $this->adm_model->langs();
		if($this->input->post())
		{
			$langs = $this->cache->model("adm_model", "langs");
			$vars = $this->filter_data($this->input->post());
			$array=array();
			$warehouse_id_vars = array("active"=>$vars["active"],"order_by"=>1);
			$warehouse_id = $this->universal_model->add_item($warehouse_id_vars, "warehouses_id");
			unset($vars["active"]);
			if($warehouse_id)
			{
				foreach ($data["langs"] as $lang) {
					$warehouse_name="";
					foreach ($vars as $key => $value) {
						$name = explode("-", $key);
						if($lang->lang_id==@$name[1])
						{
							if($name[0]=="name")
							$warehouse_name=$value;
						}
					}
					$array[] = array("name"=>$warehouse_name, "warehouse_id"=>$warehouse_id, "lang_id"=>$lang->lang_id);
				}

				$result = $this->universal_model->add_more_item($array, "warehouses");
				$data["status"] = array("status"=>"success", "msg"=>"Yeni Anbar adı uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
			} else {
				$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$this->home('warehouse/add_warehouse', $data);
	}

	public function edit_warehouse($warehouse_id)
	{
		$warehouse_id = (int)$warehouse_id;
		$data["langs"] = $this->adm_model->langs();
		if($this->input->post())
		{
			$langs = $this->cache->model("adm_model", "langs");
			$vars = $this->filter_data($this->input->post());
			$array=array();
			$warehouse_id_vars = array("active"=>$vars["active"]);
			$result = $this->universal_model->item_edit_save_where($warehouse_id_vars, array("warehouse_id"=>$warehouse_id), "warehouses_id");
			unset($vars["active"]);
			if($warehouse_id)
			{
				$array = array();
				foreach ($data["langs"] as $lang) {
					$warehouse_name="";
					foreach ($vars as $key => $value) {
						$name = explode("-", $key);
						if($lang->lang_id==@$name[1])
						{
							if($name[0]=="name")
							$warehouse_name=$value;
						}
					}
					$warehouse_var =  array("name"=>$warehouse_name, "warehouse_id"=>$warehouse_id, "lang_id"=>$lang->lang_id);
					$result = $this->universal_model->item_edit_save("warehouses", array("warehouse_id"=>$warehouse_id, "lang_id"=>$lang->lang_id), $warehouse_var);
					if(!$result)
					{
						$result = $this->universal_model->add_item($warehouse_var, "warehouses");
					}
				}
				$data["status"] = array("status"=>"success", "msg"=>"Anbar adı uğurla yeniləndi.", "title"=>"Success!", "icon"=>"check-circle");
			}else {
				$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$data["items"]= $this->warehouse_model->edit_warehouse($warehouse_id);
		$this->home('warehouse/edit_warehouse', $data);
	}

	public function delete_warehouse()
	{
		if($this->input->post("id"))
		{
			$this->universal_model->item_edit_save_where(array("deleted"=>1), array("warehouse_id"=>$this->input->post("id")), "warehouses_id");
			echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
		}else {
			echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
		}
	}

	public function warehouse_set_active_passive()
	{
		if($this->input->post("id"))
		{
			$result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("warehouse_id"=>(int)$this->input->post("id")), "warehouses_id");

			if($result)
				echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
	}
	/*****WAREHOUSE END******/

	public function entry_name_lists()
	{
		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$entry_name[] = $filtered_post['entry_name_1'];
			$entry_name[] = $filtered_post['entry_name_2'];
			$entry_name[] = $filtered_post['entry_name_3'];
			$entry_name[] = $filtered_post['entry_name_4'];

			$result = $this->warehouse_model->add_entry_name($entry_name);

			if($result)
        $data["status"] = array("status"=>"success","title"=>$this->langs->success_title, "icon"=>"check-circle", "msg"=>$this->langs->item_added_successfully);
      else
        $data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->error_title);
		}

		$data['entry_type_list'] = $this->warehouse_model->entry_type_list($this->session->userdata('lang_id'));

		$this->home('warehouse/entry_name_lists', $data);
	}

	public function delete_entry_name()
	{
		$id = (int)$this->input->post("id");

		$using = $this->warehouse_model->check_entry_name($id);

		if(!$using)
		{
			$result = $this->warehouse_model->delete_entry_name($id);

			if($result)
				echo '{"msg":"'.$this->langs->success_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
		else
			echo '{"msg":"'.$this->langs->this_import_type_is_used.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
	}

	public function export_name_lists()
	{
		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$export_name[] = $filtered_post['export_name_1'];
			$export_name[] = $filtered_post['export_name_2'];
			$export_name[] = $filtered_post['export_name_3'];
			$export_name[] = $filtered_post['export_name_4'];
			$buyer_id = (int) $filtered_post['buyer_id'];
			$contract_number = (int) $filtered_post['contract_number'];

			$result = $this->warehouse_model->add_export_name($export_name, $buyer_id, $contract_number);

			if($result)
        $data["status"] = array("status"=>"success","title"=>$this->langs->success_title, "icon"=>"check-circle", "msg"=>$this->langs->item_added_successfully);
      else
        $data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->error_title);
		}

		$data['export_type_list'] = $this->warehouse_model->export_type_list($this->session->userdata('lang_id'));

		$this->home('warehouse/export_name_lists', $data);
	}

	public function delete_export_name()
	{
		$id = (int)$this->input->post("id");

		$using = $this->warehouse_model->check_export_name($id);

		if(!$using)
		{
			$result = $this->warehouse_model->delete_export_name($id);

			if($result)
				echo '{"msg":"'.$this->langs->success_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
		else
			echo '{"msg":"'.$this->langs->this_export_type_is_used.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
	}

	public function salesman_list()
	{
		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$array = array(
				'fullname' => $filtered_post['fullname'],
				'corporate_name' => $filtered_post['corporate_name'],
				'phone' => $filtered_post['phone']
 			);

			$result = $this->warehouse_model->insert_item($array, 'salesmen');

			if($result)
        $data["status"] = array("status"=>"success","title"=>$this->langs->success_title, "icon"=>"check-circle", "msg"=>$this->langs->item_added_successfully);
      else
        $data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->error_title);
		}

		$data['salesman_list'] = $this->warehouse_model->salesman_list();
		$this->home('warehouse/salesman_list', $data);
	}

	public function delete_salesman()
	{
		$id = (int)$this->input->post("id");

		$result1 = $this->warehouse_model->check_salesman($id);

		if(!$result1)
		{
	    $result = $this->warehouse_model->delete_item(array('id' => $id), 'salesmen');

	    if($result)
	      echo '{"msg":"'.$this->langs->success_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
	    else
	      echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
		else
			echo '{"msg":"'.$this->langs->this_salesman_is_used_in_the_contract.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
	}

	public function import_contracts_list()
	{
		if ($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$max_number = $this->warehouse_model->get_max_id('import_contracts');

			if(empty($_FILES['pdf_upload']['tmp_name']) || $_FILES['pdf_upload']['tmp_name'] == 'none')
				echo 'Yüklənəcək Şəkil tapılmadı..';
			else
				$img = $this->do_upload("pdf_upload", $this->config->item('server_root').'/img/import_pdf/', 20000, 'pdf', 'pdf');

			if(@$img["error"] == TRUE)
			{
				$error = $img["error"];
				$data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->wrong_file_format);
			}
			else
			{
				$array = array(
					'id' => $max_number,
					'contract_number' => $max_number,
					'deliveryman' => $filtered_post['deliveryman'],
					'voen' => $filtered_post['voen'],
					'address' => $filtered_post['address'],
					'description' => $filtered_post['description'],
					'salesman_id' => (int)$filtered_post['salesman'],
					'created' => date("Y-m-d H:i:s"),
					'pdf_path' => '/img/import_pdf/'.$img['file_name']
	 			);

				$result = $this->warehouse_model->insert_unique_item($array, 'import_contracts');

				if($result)
	        $data["status"] = array("status"=>"success","title"=>$this->langs->success_title, "icon"=>"check-circle", "msg"=>$this->langs->item_added_successfully);
	      else
	        $data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->contract_number_must_be_unique);
			}
		}

		$from=0;
		$end = 20;

		if ($this->input->get('page')) {
			$filtered_get = $this->filter_data($this->input->get());
			$from = (int)$filtered_get['page'];
		}

		$data['contract_number'] = $this->warehouse_model->get_max_id('import_contracts');
		$data['salesmen'] = $this->warehouse_model->get_salesmen();
		$data['import_contracts_list'] = $this->warehouse_model->import_contracts_list($from, $end);

		$base_url = "/warehouse/import_contracts_list";
		$total = $this->warehouse_model->import_contracts_list_rows();

		if($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);

		$this->home('warehouse/import_contracts_list', $data);
	}

	public function delete_import_contract()
	{
		$id = (int)$this->input->post("id");

		$result1 = $this->warehouse_model->check_import_contract($id);

		if(!$result1)
		{
			$result = $this->warehouse_model->delete_item(array('id' => $id), 'import_contracts');

			if($result)
				echo '{"msg":"'.$this->langs->success_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
		else
		 	echo '{"msg":"'.$this->langs->you_cannot_delete_the_used_contract.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
	}

	public function delete_export_contract()
	{
		$id = (int)$this->input->post("id");

		$result1 = $this->warehouse_model->check_export_contract($id);

		if(!$result1)
		{
			$result = $this->warehouse_model->delete_item(array('id' => $id), 'export_contracts');

			if($result)
				echo '{"msg":"'.$this->langs->success_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
		else
		 	echo '{"msg":"'.$this->langs->you_cannot_delete_the_used_contract.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
	}

	public function export_contracts_list()
	{
		if ($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$max_number = $this->warehouse_model->get_max_id('export_contracts');

			if(empty($_FILES['pdf_upload']['tmp_name']) || $_FILES['pdf_upload']['tmp_name'] == 'none')
				echo 'Yüklənəcək Şəkil tapılmadı..';
			else
				$img = $this->do_upload("pdf_upload", $this->config->item('server_root').'/img/export_pdf/', 20000, 'pdf', 'pdf');

			if(@$img["error"] == TRUE)
			{
				$error = $img["error"];
				$data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->wrong_file_format);
			}
			else
			{
				$array = array(
					'id' => $max_number,
					'contract_number' => $max_number,
					'deliveryman' => $filtered_post['deliveryman'],
					'voen' => $filtered_post['voen'],
					'address' => $filtered_post['address'],
					'description' => $filtered_post['description'],
					'buyer_id' => (int)$filtered_post['buyer'],
					'created' => date("Y-m-d H:i:s"),
					'pdf_path' => '/img/export_pdf/'.$img['file_name']
	 			);

				$result = $this->warehouse_model->insert_unique_item($array, 'export_contracts');

				if ($result)
	        $data["status"] = array("status"=>"success","title"=>$this->langs->success_title, "icon"=>"check-circle", "msg"=>$this->langs->item_added_successfully);
	      else
	        $data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->contract_number_must_be_unique);
			}
		}

		$from=0;
		$end = 20;

		if ($this->input->get('page')) {
			$filtered_get = $this->filter_data($this->input->get());
			$from = (int)$filtered_get['page'];
		}

		$data['buyers'] = $this->warehouse_model->get_buyers();
		$data['contract_number'] = $this->warehouse_model->get_max_id('export_contracts');
		$data['export_contracts_list'] = $this->warehouse_model->export_contracts_list($from, $end);

		$base_url = "/warehouse/export_contracts_list";
		$total = $this->warehouse_model->export_contracts_list_rows();

		if($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);


		$this->home('warehouse/export_contracts_list', $data);
	}

	public function export()
	{
		$data["products"] = $this->warehouse_model->get_products($this->session->userdata('lang_id'));
		$data["buyers"] = $this->warehouse_model->get_buyers();
		$data["export_name"] = $this->warehouse_model->get_export_name($this->session->userdata('lang_id'));

		$this->home('warehouse/export', $data);
	}

	public function do_export()
	{
		if ($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$array = $array2 = [];
			$check_number = 0;
			$product_id = $filtered_post['product_id2'];

			$vars = array(
				'order_status_id' => 25,
				'date_time' => date('Y-m-d H:i:s'),
				'user_id' => $this->session->userdata('id'),
				'contract' => (int) $filtered_post['contract_number']
			);
			$check_number = $this->warehouse_model->insert_id_item($vars, 'order_numbers');

			for($i=0; $i<count($product_id); $i++)
			{
				$im_ex_arr = explode(',', $filtered_post['im_ex_id2'][$i]);
				foreach($im_ex_arr as $row)
				{
					$arr2 = $this->warehouse_model->get_for_do_export($row, $this->session->userdata('lang_id'));
					if ((float) $filtered_post['count2'][$i] > 0)
					{
						if ((float) $filtered_post['count2'][$i] > $arr2[0]->count) {
							$countt = $arr2[0]->count;
							$filtered_post['count2'][$i] = (float) $filtered_post['count2'][$i] - $arr2[0]->count;
						} else {
							$countt = (float) $filtered_post['count2'][$i];
							$filtered_post['count2'][$i] = 0;
						}
					}
					else
						$countt = 0;

					if($countt)
					{
						$array[] = array(
							'product_id' => $filtered_post['product_id2'][$i],
							'im_price' => $arr2[0]->im_price,
							'warehouse_id' => $arr2[0]->warehouse_id,
							'count' => $countt,
							'im_ex' => 1,
							'date_time' => date('Y-m-d H:i:s', strtotime($filtered_post['date_time'])),
							'provider_id' => $filtered_post['buyer'],
							'entry_name_id' => $filtered_post['export_name'],
							'user_id' => $this->session->userdata('id'),
							'contract_number' => $filtered_post['contract_number'],
							'expiration_date' => $arr2[0]->expiration_date,
							'ex_price' => $filtered_post['ex_price2'][$i],
							'measure_id' => $arr2[0]->measure_id,
							'check_number' => $check_number
						);
						$array2[]['import_id'] = $row;
					}
				}
			}

			for($i=0; $i<count($array); $i++)
				$array2[$i]['export_id'] = $this->warehouse_model->insert_id_item($array[$i], 'products_im_ex');

			$this->warehouse_model->add_more_item($array2, 'products_im_ex_rel');

			if($array2[0]['export_id'])
			{
				for ($i=0; $i<count($array); $i++) {
					$array[$i]['im_ex_id'] = $array2[$i]['export_id'];
					$array[$i]['action_time'] = date("Y-m-d H:i:s");
					$array[$i]['action_name'] = 'Add export product';
				}

				$result2 = $this->universal_model->add_more_item($array, "products_log");

				if($result2)
					redirect('/warehouse/edit_export/'.$check_number.'?msg=1');
				else
					redirect('/warehouse/export?msg=0');
			}
			else
				redirect('/warehouse/export?msg=0');
		}
	}

	public function edit_export($check_number = 0)
	{
		if($check_number)
		{
			$check_number = (int) $check_number;
			$check = $this->warehouse_model->select_where_row('*', 'order_number = '.$check_number.' and order_status_id in (12,15,25)', 'order_numbers');

			if($check)
			{
				$data['products'] = $this->warehouse_model->get_export_products($check_number, $this->session->userdata('lang_id'));
				$data["export_type"] = $this->warehouse_model->export_type_list($this->session->userdata('lang_id'));
				$data['buyers'] = $this->warehouse_model->get_buyers();
				$data['export_contracts'] = $this->warehouse_model->get_export_contracts($data['products'][0]->provider_id);

				$this->home('warehouse/edit_export', $data);
			}
		}
	}

	public function get_import_prices()
	{
		$post = $this->input->post();
		$filtered_post = $this->filter_data($post);

		$product_id = (int)$filtered_post['product_id'];

		echo json_encode($this->warehouse_model->get_import_prices($product_id, $this->session->userdata('lang_id')));
	}

	public function get_export_contracts()
	{
		$post = $this->input->post();
		$filtered_post = $this->filter_data($post);

		$buyer_id = (int)$filtered_post['buyer_id'];

		echo json_encode($this->warehouse_model->get_export_contracts($buyer_id));
	}

	public function delete_export_product()
	{
		if($this->input->post())
		{
			$postData = $this->input->post();
			$filteredPostData = $this->filter_data($postData);

			$res = $this->warehouse_model->delete_export_log((int) $filteredPostData['id']);
			if($res)
			{
				$result = $this->warehouse_model->delete_item(array('id' => (int) $filteredPostData['id']), 'products_im_ex');

				if($result)
					$result = $this->warehouse_model->delete_item(array('export_id' => (int) $filteredPostData['id']), 'products_im_ex_rel');

				if($result)
					echo '{"msg":"'.$this->langs->successfully_deleted.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"'.$this->langs->success_title.'"}';
				else
					echo '{"msg": "'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"'.$this->langs->error_title.'"}';
			}
			else
				echo '{"msg": "'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"'.$this->langs->error_title.'"}';
		}
	}

	public function import()
	{
		$data["products"] = $this->warehouse_model->get_products($this->session->userdata('lang_id'));
		$data["warehouses"] = $this->warehouse_model->get_warehouses($this->session->userdata('lang_id'));
		$data["import_type"] = $this->warehouse_model->entry_type_list($this->session->userdata('lang_id'));
		$data['providers'] = $this->warehouse_model->get_salesmen();

		$this->home('warehouse/import', $data);
	}

	public function get_import_contracts()
	{
		$post = $this->input->post();
		$filtered_post = $this->filter_data($post);
		$provider_id = (int) $filtered_post['provider_id'];

		echo json_encode($this->warehouse_model->get_import_contracts($provider_id));
	}

	public function get_measure_price()
	{
		$post = $this->input->post();
		$filtered_post = $this->filter_data($post);
		$product_id = (int) $filtered_post['product_id'];

		echo json_encode($this->warehouse_model->get_measure_price($product_id, $this->session->userdata('lang_id')));
	}

	public function do_import()
	{
		if ($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$array = [];
			$check_number = 0;
			$product_id = $filtered_post['product_id2'];

			$vars = array(
				'order_status_id' => 20,
				'date_time' => date('Y-m-d H:i:s'),
				'user_id' => $this->session->userdata('id'),
				'contract' => $filtered_post['contract_number']
			);
			$check_number = $this->warehouse_model->insert_id_item($vars, 'order_numbers');

			for($i=0; $i<count($product_id); $i++)
			{
				$arr = [];
				$arr = $this->warehouse_model->select_where_row('price, measure_id', array('p_id' => $filtered_post['product_id2'][$i]), 'products_id');

				$array[] = array(
					'product_id' => $filtered_post['product_id2'][$i],
					'im_price' => $filtered_post['import_price2'][$i],
					'warehouse_id' => $filtered_post['warehouse'],
					'count' => $filtered_post['count2'][$i],
					'im_ex' => 0,
					'date_time' => date('Y-m-d H:i:s', strtotime($filtered_post['import_date'])),
					'provider_id' => $filtered_post['provider'],
					'entry_name_id' => $filtered_post['import_type'],
					'user_id' => $this->session->userdata('id'),
					'contract_number' => $filtered_post['contract_number'],
					'expiration_date' => date('Y-m-d H:i:s', strtotime($filtered_post['expiration_date2'][$i])),
					'ex_price' => $arr->price,
					'measure_id' => $arr->measure_id,
					'check_number' => $check_number
				);
			}

			$result1 = $this->universal_model->add_more_item($array, "products_im_ex");
			if($result1)
			{
				for ($i=0; $i<count($product_id); $i++) {
					$array[$i]['action_time'] = date("Y-m-d H:i:s");
					$array[$i]['action_name'] = 'Add new product';
				}

				$result2 = $this->universal_model->add_more_item($array, "products_log");

				if($result2)
					redirect('/warehouse/edit_import/'.$check_number.'?msg=1');
				else
					redirect('/warehouse/import?msg=0');
			}
			else
				redirect('/warehouse/import?msg=0');
		}
	}

	public function edit_import($check_number = 0)
	{
		if($check_number)
		{
			$check_number = (int) $check_number;
			$check = $this->warehouse_model->select_where_row('*', array('order_number' => $check_number, 'order_status_id' => 20), 'order_numbers');

			if($check)
			{
				$data['products'] = $this->warehouse_model->get_import_products($check_number, $this->session->userdata('lang_id'));
				$data["warehouses"] = $this->warehouse_model->get_warehouses($this->session->userdata('lang_id'));
				$data["import_type"] = $this->warehouse_model->entry_type_list($this->session->userdata('lang_id'));
				$data['providers'] = $this->warehouse_model->get_salesmen();
				$data['import_contracts'] = $this->warehouse_model->get_import_contracts($data['products'][0]->provider_id);

				$this->home('warehouse/edit_import', $data);
			}
		}
	}

	public function import_list()
	{
		// $this->output->enable_profiler(true);

		$from = $check_number = $warehouse_id = $import_type = $provider_id = $contract_number = $product_id= 0;
		$product_name = $sku = $import_date = '';
		$end = 20;

		if($this->input->get())
		{
			$get = $this->input->get();
			$filtered_get = $this->filter_data($get);

			if($this->input->get('check_number'))
				$check_number = (int) $filtered_get['check_number'];

			if($this->input->get('warehouse'))
				$warehouse_id = (int) $filtered_get['warehouse'];

			if($this->input->get('import_type'))
				$import_type = (int) $filtered_get['import_type'];

			if($this->input->get('provider'))
			{
				$provider_id = (int) $filtered_get['provider'];
				$data['contract_numbers'] = $this->warehouse_model->select_where('id, contract_number', array('salesman_id' => (int) $filtered_get['provider']), 'import_contracts');
			}

			if($this->input->get('contract_number'))
				$contract_number = (int) $filtered_get['contract_number'];

			if($this->input->get('import_date'))
				$import_date = date('Y-m-d H:i:s', strtotime($filtered_get['import_date']));

			if($this->input->get('page'))
				$from = (int) $filtered_get['page'];

			if ($this->input->get('product_id')) {
				$product_name = $filtered_get['product_name'];
				$sku = (int) $filtered_get['sku'];
				$product_id = (int) $filtered_get['product_id'];
			}
		}


		$data['import_list'] = $this->warehouse_model->import_list($from, $end, $check_number, $warehouse_id, $import_type, $provider_id, $contract_number, $import_date, $product_id, $this->session->userdata('lang_id'));

		$base_url = "/warehouse/import_list";
		$total = $this->warehouse_model->import_list_rows($check_number, $warehouse_id, $import_type, $provider_id, $contract_number, $import_date, $product_id);

		if($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);

		$data["warehouses"] = $this->warehouse_model->get_warehouses($this->session->userdata('lang_id'));
		$data["import_type"] = $this->warehouse_model->entry_type_list($this->session->userdata('lang_id'));
		$data['providers'] = $this->warehouse_model->get_salesmen();
		$data["products"] = $this->warehouse_model->get_products($this->session->userdata('lang_id'));
		$data['check_number'] = $check_number;
		$data['warehouse_id'] = $warehouse_id;
		$data['import_type2'] = $import_type;
		$data['provider_id'] = $provider_id;
		$data['contract_number'] = $contract_number;
		$data['import_date'] = $import_date;
		$data['product_name'] = $product_name;
		$data['sku'] = $sku;
		$data['product_id'] = $product_id;

		$this->home('warehouse/import_list', $data);
	}

	public function import_product_list()
	{
		// $this->output->enable_profiler(true);

		$from = $check_number = $import_type = $provider_id = $contract_number = $product_id= 0;
		$product_name = $sku = $import_date = '';
		$end = 20;

		if($this->input->get())
		{
			$get = $this->input->get();
			$filtered_get = $this->filter_data($get);

			if ($this->input->get('check_number'))
				$check_number = (int) $filtered_get['check_number'];

			if ($this->input->get('import_type'))
				$import_type = (int) $filtered_get['import_type'];

			if ($this->input->get('provider'))
			{
				$provider_id = (int) $filtered_get['provider'];
				$data['contract_numbers'] = $this->warehouse_model->select_where('id, contract_number', array('salesman_id' => (int) $filtered_get['provider']), 'import_contracts');
			}

			if ($this->input->get('contract_number'))
				$contract_number = (int) $filtered_get['contract_number'];

			if ($this->input->get('import_date'))
				$import_date = date('Y-m-d H:i:s', strtotime($filtered_get['import_date']));

			if ($this->input->get('page'))
				$from = (int) $filtered_get['page'];

			if ($this->input->get('product_id')) {
				$product_name = $filtered_get['product_name'];
				$sku = (int) $filtered_get['sku'];
				$product_id = (int) $filtered_get['product_id'];
			}
		}


		$data['import_product_list'] = $this->warehouse_model->import_product_list($from, $end, $check_number, $import_type, $provider_id, $contract_number, $import_date, $product_id, $this->session->userdata('lang_id'));

		$base_url = "/warehouse/import_product_list";
		$total = $this->warehouse_model->import_product_list_rows($check_number, $import_type, $provider_id, $contract_number, $import_date, $product_id);

		if ($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);

		$data["import_type"] = $this->warehouse_model->entry_type_list($this->session->userdata('lang_id'));
		$data['providers'] = $this->warehouse_model->get_salesmen();
		$data["products"] = $this->warehouse_model->get_products($this->session->userdata('lang_id'));
		$data['check_number'] = $check_number;
		$data['import_type2'] = $import_type;
		$data['provider_id'] = $provider_id;
		$data['contract_number'] = $contract_number;
		$data['import_date'] = $import_date;
		$data['product_name'] = $product_name;
		$data['sku'] = $sku;
		$data['product_id'] = $product_id;

		$this->home('warehouse/import_product_list', $data);
	}

	public function export_list()
	{
		// $this->output->enable_profiler(true);

		$from = $check_number = $warehouse_id = $export_type = $buyer = $contract_number = $product_id = 0;
		$product_name = $sku = $export_date = '';
		$end = 20;

		if($this->input->get())
		{
			$get = $this->input->get();
			$filtered_get = $this->filter_data($get);

			if($this->input->get('check_number'))
				$check_number = (int) $filtered_get['check_number'];

			if($this->input->get('warehouse'))
				$warehouse_id = (int) $filtered_get['warehouse'];

			if($this->input->get('export_type'))
				$export_type = (int) $filtered_get['export_type'];

			if($this->input->get('buyer'))
			{
				$buyer = (int) $filtered_get['buyer'];
				$data['contract_numbers'] = $this->warehouse_model->select_where('id, contract_number', array('buyer_id' => (int) $filtered_get['buyer']), 'export_contracts');
			}

			if($this->input->get('contract_number'))
				$contract_number = (int) $filtered_get['contract_number'];

			if($this->input->get('export_date'))
				$export_date = date('Y-m-d H:i:s', strtotime($filtered_get['export_date']));

			if($this->input->get('page'))
				$from = (int) $filtered_get['page'];

			if ($this->input->get('product_id')) {
				$product_name = $filtered_get['product_name'];
				$sku = (int) $filtered_get['sku'];
				$product_id = (int) $filtered_get['product_id'];
			}
		}

		$data['export_list'] = $this->warehouse_model->export_list($from, $end, $check_number, $warehouse_id, $export_type, $buyer, $contract_number, $export_date, $product_id, $this->session->userdata('lang_id'));

		$base_url = "/warehouse/export_list";
		$total = $this->warehouse_model->export_list_rows($check_number, $warehouse_id, $export_type, $buyer, $contract_number, $export_date, $product_id);

		if($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);

		$data["warehouses"] = $this->warehouse_model->get_warehouses($this->session->userdata('lang_id'));
		$data["export_type"] = $this->warehouse_model->export_type_list($this->session->userdata('lang_id'));
		$data['buyers'] = $this->warehouse_model->get_buyers();
		$data["products"] = $this->warehouse_model->get_products($this->session->userdata('lang_id'));
		$data['check_number'] = $check_number;
		$data['warehouse_id'] = $warehouse_id;
		$data['export_type2'] = $export_type;
		$data['buyer'] = $buyer;
		$data['contract_number'] = $contract_number;
		$data['export_date'] = $export_date;
		$data['product_name'] = $product_name;
		$data['sku'] = $sku;
		$data['product_id'] = $product_id;

		$this->home('warehouse/export_list', $data);
	}

	public function delete_import()
	{
		$order_number = (int) $this->input->post("order_number");
		$can_delete = (int) $this->input->post('can_delete');

		if ($can_delete)
		{
			$result1 = $this->warehouse_model->delete_item(array('order_number' => $order_number), 'order_numbers');
			$result2 = $this->warehouse_model->insert_log($order_number, 'Edit delete product');
			$result3 = $this->warehouse_model->delete_item(array('check_number' => $order_number), 'products_im_ex');

			if ($result1 && $result2 && $result3)
				echo '{"msg":"'.$this->langs->successfully_deleted2.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		}
	}

	public function delete_export()
	{
		$order_number = (int) $this->input->post("order_number");
		$can_delete = (int) $this->input->post('can_delete');

		$check = $this->warehouse_model->select_where('id', array('check_number' => $order_number), 'products_im_ex_total');

		if ($can_delete)
		{
			if(!$check)
			{
				$result1 = $this->warehouse_model->delete_item(array('order_number' => $order_number), 'order_numbers');
				$result2 = $this->warehouse_model->insert_log($order_number, 'Edit delete product');
				$result3 = $this->warehouse_model->delete_item(array('check_number' => $order_number), 'products_im_ex');

				if ($result1 && $result2 && $result3)
					echo '{"msg":"'.$this->langs->successfully_deleted2.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
				else
					echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
			}
			else
				echo 'Go to hell!';
		}
	}

	public function save_edit_import()
	{
		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$id = (int) $filtered_post['id'];

			$check = $this->warehouse_model->select_where_row('id', array('id' => $id), 'products_im_ex_total');

			if (!$check)
			{
				$count = (int) $filtered_post['count'];
				$im_price = (float) $filtered_post['im_price'];
				$expiration_date = date('Y-m-d H:i:s', strtotime($filtered_post['expiration_date']));

				$result1 = $this->warehouse_model->update_table('products_im_ex', array('id' => $id), array('im_price' => $im_price, 'count' => $count, 'expiration_date' => $expiration_date));
				$result2 = $this->warehouse_model->insert_log_with_id($id, 'Update income product');

				if ($result1 && $result2)
					echo '{"msg":"'.$this->langs->successfully_edited.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
				else
					echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
			} else
				echo 'Go to hell!';
		}
	}

	public function save_edit_export()
	{
		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$id = (int) $filtered_post['id'];

			$check = $this->warehouse_model->select_where_row('id', array('id' => $id), 'products_im_ex_total');
			$max_count = $this->warehouse_model->get_max_count($id)->max_count;
			$count = (int) $filtered_post['count'];

			if (!$check)
			{
				if($count > 0 && $count <= $max_count)
				{
					$result1 = $this->warehouse_model->update_table('products_im_ex', array('id' => $id), array('count' => $count));
					$result2 = $this->warehouse_model->insert_log_with_id($id, 'Update export product');

					if ($result1 && $result2)
						echo '{"msg":"'.$this->langs->successfully_edited.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
					else
						echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
				}
				else
					echo 'Go to hell with your count!';
			} else
				echo 'Go to hell!';
		}
	}

	public function delete_import_id()
	{
		$id = (int) $this->input->post("id");
		$check = $this->warehouse_model->select_where_row('id', array('id' => $id), 'products_im_ex_total');

		if (!$check)
		{
			$result1 = $this->warehouse_model->insert_log_with_id($id, 'Edit delete product');
			$result2 = $this->warehouse_model->delete_item(array('id' => $id), 'products_im_ex');

			if ($result1 && $result2)
				echo '{"msg":"'.$this->langs->successfully_deleted2.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		} else
			echo 'Go to hell!';
	}

	public function delete_export_id()
	{
		$id = (int) $this->input->post("id");
		$check = $this->warehouse_model->select_where_row('id', array('id' => $id), 'products_im_ex_total');

		if (!$check)
		{
			$result1 = $this->warehouse_model->insert_log_with_id($id, 'Edit delete product');
			$result2 = $this->warehouse_model->delete_item(array('id' => $id), 'products_im_ex');

			if ($result1 && $result2)
				echo '{"msg":"'.$this->langs->successfully_deleted2.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
			else
				echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
		} else
			echo 'Go to hell!';
	}

	public function save_edit_all_import()
	{
		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$order_number = (int) $filtered_post['order_number'];
			$warehouse = (int) $filtered_post['warehouse'];
			$import_type = (int) $filtered_post['import_type'];
			$provider = (int) $filtered_post['provider'];
			$contract_number = (int) $filtered_post['contract_number'];
			$import_date = date('Y-m-d H:i:s', strtotime($filtered_post['import_date']));

			$check = $this->warehouse_model->select_where('id', array('check_number' => $order_number), 'products_im_ex_total');

			if (!$check)
			{
				if ($order_number && $warehouse && $import_type && $provider && $contract_number && $import_date)
				{
					$result1 = $this->warehouse_model->update_table('order_numbers', array('order_number' => $order_number), array('date_time' => $import_date, 'contract' => $contract_number));
					$result2 = $this->warehouse_model->update_table('products_im_ex', array('check_number' => $order_number), array('warehouse_id' => $warehouse, 'entry_name_id' => $import_type, 'provider_id' => $provider, 'contract_number' => $contract_number, 'date_time' => $import_date));
					$result3 = $this->warehouse_model->insert_log($order_number, 'Update income product');

					if ($result1 && $result2 && $result3)
						echo '{"msg":"'.$this->langs->successfully_edited.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
					else
						echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
				}
			} else
				echo 'Go to hell!';
		}
	}

	public function save_edit_all_export()
	{
		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$order_number = (int) $filtered_post['order_number'];
			$export_type = (int) $filtered_post['export_type'];
			$buyer = (int) $filtered_post['buyer'];
			$contract_number = (int) $filtered_post['contract_number'];
			$export_date = date('Y-m-d H:i:s', strtotime($filtered_post['export_date']));

			$check = $this->warehouse_model->select_where('id', array('check_number' => $order_number), 'products_im_ex_total');

			if (!$check)
			{
				if ($order_number && $export_type && $buyer && $contract_number && $export_date)
				{
					$result1 = $this->warehouse_model->update_table('order_numbers', array('order_number' => $order_number), array('date_time' => $export_date, 'contract' => $contract_number));
					$result2 = $this->warehouse_model->update_table('products_im_ex', array('check_number' => $order_number), array('entry_name_id' => $export_type, 'provider_id' => $buyer, 'contract_number' => $contract_number, 'date_time' => $export_date));
					$result3 = $this->warehouse_model->insert_log($order_number, 'Update export product');

					if ($result1 && $result2 && $result3)
						echo '{"msg":"'.$this->langs->successfully_edited.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
					else
						echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
				}
			} else
				echo 'Go to hell!';
		}
	}

	public function expiration_date()
	{
		$from=0;
		$end = 20;
		$expiration_date = '';

		if ($this->input->get()) {
			$filtered_get = $this->filter_data($this->input->get());

			if ($this->input->get('page'))
				$from = (int)$filtered_get['page'];

			if ($this->input->get('expiration_date'))
				$expiration_date = date('Y-m-d H:i:s', strtotime($filtered_get['expiration_date']));
		}

		$data['expiration_date'] = $expiration_date;
		$data['expiration_date_list'] = $this->warehouse_model->expiration_date_list($from, $end, $expiration_date, $this->session->userdata('lang_id'));

		$base_url = "/warehouse/expiration_date";
		$total = $this->warehouse_model->expiration_date_list_rows($expiration_date);

		if ($total->count >= 1) {
			$data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);
			$data["row_count"] = $total->count;
		}

		$this->home('warehouse/expiration_date', $data);
	}
}
