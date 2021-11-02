<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("orders_model");
		$this->load->library("template");
	}
	/*******Orders*******/
	public function order_list()
	{

		$data["filter"] = $this->filter_data($this->input->get());
		$from = isset($data["filter"]["from"])?(int)$data["filter"]["from"]:0;
		$end=100;
		$result = $this->orders_model->orders($data["filter"], $from, $end);
		$data["list"] = $result["list"];
		$data["order_status"] = $this->orders_model->order_status();

		$this->home('orders/orders', $data);
	}
	public function delete_order()
	{
		if($this->input->post("id"))
		{
			$order = 	$this->universal_model->get_item("orders", array("id"=>(int)$this->input->post("id")));
			$this->universal_model->delete_item(array("tmp_user_id"=>$order->tmp_user_id, "user_id"=>$order->user_id, "order_status_id"=>$order->order_status_id), "orders");
			echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
		}else {
			echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
		}
	}
	/*******END Orders*******/
	/*****Order status START******/
	public function order_status()
	{
		if($this->input->post())
		{
			$vars = $this->filter_data($this->input->post());
			$array=array();
			$order_status_id_vars = array("active"=>$vars["active"], "order_by"=>$vars["order_by"]);
			$order_status_id = $this->universal_model->add_item($order_status_id_vars, "order_status_id");
			unset($vars["active"]);
			unset($vars["order_by"]);
			if($order_status_id)
			{
				foreach($vars as $key=>$value)
				{
					$name = explode("-", $key);
					$array[] = array("order_status_id"=>$order_status_id, "order_status_title"=>$value, "lang_id"=>(int)@$name[1]);
				}
				$result = $this->universal_model->add_more_item($array, "order_status");
				$data["status"] = array("status"=>"success", "msg"=>"Yeni Kateqoriya uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
			}else {
				$data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
			}
		}
		$data["langs"] = $this->adm_model->langs();
		$data["list"]= $this->orders_model->order_status();
		$this->home('orders/order_status', $data);
	}
	public function edit_order_status($order_status_id)
	{
		$order_status_id = (int)$order_status_id;
		if($this->input->post())
		{
			$vars = $this->filter_data($this->input->post());
			$array=array();
			$order_status_id_vars = array("active"=>(int)$vars["active"],  "order_by"=>(int)$vars["order_by"]);
			$result = $this->universal_model->item_edit_save_where($order_status_id_vars, array("order_status_id"=>$order_status_id), "order_status_id");
			unset($vars["active"]);
			unset($vars["order_by"]);
			foreach($vars as $key=>$value)
			{
				$name = explode("-", $key);
				$cat_var = array("order_status_id"=>$order_status_id, "order_status_title"=>$value, "lang_id"=>(int)@$name[1]);

				$result = $this->universal_model->item_edit_save("order_status", array("order_status_id"=>$order_status_id, "lang_id"=>(int)@$name[1]), $cat_var);
				if(!$result)
				{
					$result = $this->universal_model->add_item($cat_var, "order_status");
				}
			}
			$data["status"] = array("status"=>"success", "msg"=>"Sifariş statusu uğurla yeniləndi.", "title"=>"Success!", "icon"=>"check-circle");
		}
		$data["langs"] = $this->adm_model->langs();
		$data["items"]= $this->orders_model->edit_order_status($order_status_id);
		$this->home('orders/edit_order_status', $data);
	}
	public function delete_order_status()
	{
		if($this->input->post("id"))
		{
			$this->universal_model->item_edit_save_where(array("deleted"=>1), array("order_status_id"=>$this->input->post("id")), "order_status_id");
			echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
		}else {
			echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
		}
	}
	public function order_status_set_active_passive()
	{
		if($this->input->post("id"))
		{
			$result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("order_status_id"=>(int)$this->input->post("id")), "order_status_id");
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
	/*****Order status END******/
	public function waiting_price_proposal()
	{
		$from=0;
		if($this->input->get('page'))
			$from = (int)$this->input->get('page');

		$end = 40;

		$data['order_list_10'] = $this->orders_model->order_list_10($from, $end, 10);

		$base_url = "/orders/waiting_price_proposal";
		$data["total"] = $this->orders_model->get_order_list_row_10(10);
		if($data["total"][0]->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $data["total"][0]->count, 3, 4);

		$data['export_contracts'] = $this->orders_model->select_function('id, contract_number, buyer_id', 'export_contracts');

		$this->home('orders/waiting_price_proposal', $data);
	}

	public function confirmed_orders()
	{
		$from=0;
		if($this->input->get('page'))
			$from = (int)$this->input->get('page');

		$end = 40;

		$data['order_list_10'] = $this->orders_model->order_list_10($from, $end, 14);

		$base_url = "/orders/confirmed_orders";
		$data["total"] = $this->orders_model->get_order_list_row_10(14);
		if($data["total"][0]->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $data["total"][0]->count, 3, 4);

		$this->home('orders/confirmed_orders', $data);
	}

	public function confirmed_documents()
	{
		$from=0;
		if($this->input->get('page'))
			$from = (int)$this->input->get('page');

		$end = 40;

		$data['order_list_10'] = $this->orders_model->order_list_10($from, $end, 12);

		$base_url = "/orders/confirmed_orders";
		$data["total"] = $this->orders_model->get_order_list_row_10(12);
		if($data["total"][0]->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $data["total"][0]->count, 3, 4);

		$data['export_contracts'] = $this->orders_model->select_function('id, contract_number, buyer_id', 'export_contracts');

		$this->home('orders/confirmed_documents', $data);
	}

	public function user_cancelled_order()
	{
		$from=0;
		if($this->input->get('page'))
			$from = (int)$this->input->get('page');

		$end = 40;

		$data['order_list_10'] = $this->orders_model->order_list_10($from, $end, 17);

		$base_url = "/orders/user_cancelled_order";
		$data["total"] = $this->orders_model->get_order_list_row_10(17);
		if($data["total"][0]->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $data["total"][0]->count, 3, 4);

		$this->home('orders/user_cancelled_order', $data);
	}

	public function user_cancelled_document()
	{
		$from=0;
		if($this->input->get('page'))
			$from = (int)$this->input->get('page');

		$end = 40;

		$data['order_list_10'] = $this->orders_model->order_list_10($from, $end, 16);

		$base_url = "/orders/user_cancelled_document";
		$data["total"] = $this->orders_model->get_order_list_row_10(16);
		if($data["total"][0]->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $data["total"][0]->count, 3, 4);

		$data['export_contracts'] = $this->orders_model->select_function('id, contract_number, buyer_id', 'export_contracts');

		$this->home('orders/user_cancelled_document', $data);
	}

	public function add_price_proposal($id)
	{
		$this->load->model('PagesModel');

		$from=0;
		if($this->input->get('page'))
			$from = (int)$this->input->get('page');

		$end = 40;
		$data['id'] = $id;
		$data["list"] = $this->orders_model->get_product_list_10($from, $end, $id, 2);

		$base_url = "/orders/add_price_proposal";
		$data["total"] = $this->orders_model->get_product_list_row_10($id, 2);
		if($data["total"][0]->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $data["total"][0]->count, 3, 4);

		$this->home('orders/add_price_proposal', $data);
	}

	public function change_proposal()
	{
		$id = $teklif = 0;
		if($this->input->post())
		{
			$filtered_array = $this->filter_data($this->input->post());
			$id = (int)$filtered_array['id'];
			$teklif = (float)$filtered_array['teklif'];

			$response = $this->orders_model->change_proposal($id, $teklif);

			if($response)
				 echo json_encode(array('msg'=>'success'));
			else
				echo json_encode(array('msg'=>'error'));
		}

	}

	public function add_contract_number()
	{
		$id = $muqavile = 0;
		if($this->input->post())
		{
			$filtered_array = $this->filter_data($this->input->post());
			$id = (int)$filtered_array['id'];
			$delivery_date = date('Y-m-d H:m:s', (strtotime($filtered_array['delivery_date'])));

			$response = $this->orders_model->add_contract_number($id, $delivery_date, 15);

			if($response)
				 echo json_encode(array('msg'=>'success'));
			else
				echo json_encode(array('msg'=>'error'));
		}

	}

	public function send_proposal($id)
	{
		$id = (int)$id;
		$response = $this->orders_model->change_status_proposal($id, 11);
		if($response)
			$result = $this->orders_model->change_proposal_where_absent($id);

		$data = [];
		$data['use_other_side'] = 0;
		$data['qiymet_teklifi'] = 1;
		$data['orders'] = $this->orders_model->mail_order_list($id, 2);
		$data['order_number'] = $id;
		$data['user'] = $this->orders_model->mail_user($id);
		$data['address'] = $this->orders_model->mail_address($id);

		$msg = $this->load->view("site/for_email", $data, TRUE);
		$result = $this->template->send_mail("Yeni təklif: ", $msg, $data['user']->email);

		if($response)
			redirect('/orders/waiting_price_proposal?msg=1');
		else
			redirect('/orders/waiting_price_proposal?msg=0');
	}

	public function cancel_order($id)
	{
		$id = (int)$id;
		$response = $this->orders_model->change_status_proposal($id, 14);

		$data = [];
		$data['use_other_side'] = 0;
		$data['cancel_order'] = 1;
		$data['order_number'] = $id;

		$data['user'] = $this->orders_model->mail_user($id);

		$msg = $this->load->view("site/for_email", $data, TRUE);
		$result = $this->template->send_mail("Sifarişiniz: ", $msg, $data['user']->email);

		if($response)
			redirect('/orders/waiting_price_proposal?msg=2');
		else
			redirect('/orders/waiting_price_proposal?msg=0');
	}

	public function cancel_order2($id)
	{
		$id = (int)$id;
		$response = $this->orders_model->change_status_proposal($id, 17);

		$data = [];
		$data['use_other_side'] = 0;
		$data['cancel_order'] = 1;
		$data['order_number'] = $id;

		$data['user'] = $this->orders_model->mail_user($id);

		$msg = $this->load->view("site/for_email", $data, TRUE);
		$result = $this->template->send_mail("Sifarişiniz: ", $msg, $data['user']->email);

		if($response)
			redirect('/orders/user_cancelled_document?msg=2');
		else
			redirect('/orders/user_cancelled_document?msg=0');
	}

	public function send_cheque()
	{
		$id = $discount = $contract_number = 0;
		$delivery_time = '';

		if($this->input->post())
		{
			$filtered_array = $this->filter_data($this->input->post());
			$id = (int)$filtered_array['id'];
			$buyer_id = (int)$filtered_array['buyer_id'];
			$current_url = $filtered_array['current_url'];
			$delivery_time = date('Y-m-d H:i:s', strtotime($filtered_array['delivery_time']));
			$contract_number = (int) $filtered_array['contract_number'];

			if($this->input->post('discount'))
				$discount = (float)$filtered_array['discount'];

			if($contract_number && $delivery_time)
			{
				$products_arr = $this->orders_model->get_products_count($id);
				$check = 1;

				foreach ($products_arr as $row) {
					if($row->count2 > $row->count)
						$check = 0;
				}

				if ($check)
				{
					$result2 = $this->do_export($products_arr, $id, $contract_number, $buyer_id, $delivery_time);
					$result = $this->orders_model->update_table('order_numbers', array('order_number' => $id), array('order_status_id' => 12, 'date_time' => date("Y-m-d H:i:s"), 'discount' => $discount, 'delivery_time' => $delivery_time, 'contract' => $contract_number));

					if($result && $result2)
						redirect($current_url.'?msg=success');
					else
						redirect($current_url.'?msg=error');
				}
				else
					redirect($current_url.'?msg=info');
			}
		}
	}

	public function do_export($products_arr, $check_number, $contract_number, $buyer_id, $delivery_time)
	{
		$array = $array2 = [];

		for($i=0; $i<count($products_arr); $i++)
		{
			$im_ex_arr = $this->orders_model->get_im_ex($products_arr[$i]->product_id);
			foreach($im_ex_arr as $row)
			{
				$arr2 = $this->orders_model->get_for_do_export($row->id, $this->session->userdata('lang_id'));
				if ((float) $products_arr[$i]->count2 > 0)
				{
					if ((float) $products_arr[$i]->count2 > $arr2[0]->count) {
						$countt = $arr2[0]->count;
						$products_arr[$i]->count2 = (float) $products_arr[$i]->count2 - $arr2[0]->count;
					} else {
						$countt = (float) $products_arr[$i]->count2;
						$products_arr[$i]->count2 = 0;
					}
				}
				else
					$countt = 0;

				if($countt)
				{
					$array[] = array(
						'product_id' => $products_arr[$i]->product_id,
						'im_price' => $arr2[0]->im_price,
						'warehouse_id' => $arr2[0]->warehouse_id,
						'count' => $countt,
						'im_ex' => 1,
						'date_time' => $delivery_time,
						'provider_id' => $buyer_id,
						'entry_name_id' => 1,
						'user_id' => $this->session->userdata('id'),
						'contract_number' => $contract_number,
						'expiration_date' => $arr2[0]->expiration_date,
						'ex_price' => $arr2[0]->ex_price,
						'measure_id' => $arr2[0]->measure_id,
						'check_number' => $check_number
					);
					$array2[]['import_id'] = $row->id;
				}
			}
		}

		for($i=0; $i<count($array); $i++)
			$array2[$i]['export_id'] = $this->orders_model->insert_id_item($array[$i], 'products_im_ex');

		$this->orders_model->add_more_item($array2, 'products_im_ex_rel');

		if($array2[0]['export_id'])
		{
			for ($i=0; $i<count($array); $i++) {
				$array[$i]['im_ex_id'] = $array2[$i]['export_id'];
				$array[$i]['action_time'] = date("Y-m-d H:i:s");
				$array[$i]['action_name'] = 'Add export product';
			}

			$result2 = $this->orders_model->add_more_item($array, "products_log");

			if($result2)
				return true;
			else
				return false;
		}
		else
			return false;
	}

	public function reject_period()
	{
		if($this->input->post())
		{
			$postData = $this->input->post();
			$array = $this->filter_data($postData);

			$reject_period = $array['reject_period'];
			$result = $this->orders_model->update_reject_period($reject_period);

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
		$data['reject_period'] = $this->orders_model->select_where_row('reject_period', 'id=1', 'reject_period')->reject_period;
		$this->home("orders/reject_period", $data);
	}

	public function edit_order_count($order_number)
	{
		// $this->output->enable_profiler(true);
		$order_number = (int) $order_number;
		$data['product_list'] = $this->orders_model->get_product_list($order_number, $this->session->userdata('lang_id'));

		$this->home("orders/edit_order_count", $data);
	}

	public function update_count()
	{
		if($this->input->post())
		{
			$id = (int) $this->input->post('id');
			$count = (float) $this->input->post('count');

			$result = $this->orders_model->update_count($id, $count);

			if ($result)
				echo '{"msg": true, "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "message":"'.$this->langs->successfully_edited.'", "title":"'.$this->langs->success_title.'"}';
			else
				echo '{"msg": false, "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "message":"'.$this->langs->successfully_edited.'", "title":"'.$this->langs->error_title.'"}';
		}
	}
}
