<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("UsersModel");
	}

  function all_users()
  {
		$from = 0;
		$end = 20;
		if($this->input->get('page'))
			$from = (int)$this->input->get('page');

		$base_url = "/users/all_users";
		$total = $this->UsersModel->readWaiting_rows();

		if($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);

    $data['waitingArray'] = $this->UsersModel->readWaiting($from, $end);
    $this->home('users/waiting', $data);
  }

	function changeStatus()
	{
		$id = (int)$this->input->post('id');
		$activePassive = (int)$this->input->post('active_passive');
		$this->UsersModel->changeStatus($id, $activePassive);
		echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "status":"success"}';
	}

	// function delete_user()
	// {
	// 	$id = (int)$this->input->post("id");
	// 	$this->UsersModel->delete_user($id);
	// 	echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "status":"success"}';
	// }
}
