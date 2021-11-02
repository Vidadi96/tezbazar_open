<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Provider extends MY_Controller
{
  function __construct()
	{
		parent::__construct();
		$this->load->model("provider_model");
	}

  function add_provider()
  {
    $data = [];
    if($this->input->post())
    {
      $phone = '';
      $filtered_post = $this->filter_data($this->input->post());

      $full_name = $filtered_post['full_name'];
      $corporate_name = $filtered_post['corporate_name'];
      $phone = $filtered_post['phone'];

      $result = $this->provider_model->add_provider($full_name, $corporate_name, $phone);

      if($result)
        $data["status"] = array("status"=>"success","title"=>$this->langs->success_title, "icon"=>"check-circle", "msg"=>$this->langs->item_added_successfully);
      else
        $data["status"] = array("status"=>"danger","title"=>$this->langs->error_title, "icon"=>"exclamation-triangle",  "msg"=>$this->langs->error_title);
    }

    $this->home("provider/add_provider", $data);
  }

  function provider_list()
  {
    $data['providers_list'] = $this->provider_model->providers_list();

    $this->home("provider/provider_list", $data);
  }

  function delete_provider()
  {
    $id = (int)$this->input->post("id");
    $result = $this->provider_model->delete_provider($id);

    if($result)
      echo '{"msg":"'.$this->langs->success_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
    else
      echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
  }

  function active_passive()
	{
		$id = (int)$this->input->post('id');
		$active_passive = (int)$this->input->post('active_passive');
		$result = $this->provider_model->active_passive($id, $active_passive);

    if($result)
      echo '{"msg":"'.$this->langs->success_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
    else
      echo '{"msg":"'.$this->langs->error_title.'", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
	}

}
