<?php

class Auth2 extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('AuthModel');
  }

  public function logout()
  {
    unset($_SESSION);
    session_destroy();
    redirect("/pages/index/main-page");
  }

  public function login()
  {
    $form_response = $this->input->post('g-recaptcha-response');
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $secret = 'xxxx';
    $response = file_get_contents($url."?secret=".$secret."&response=".$form_response."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $data = json_decode($response);

    $_SESSION['username'] ="";
    $user = [];

    if(isset($data->success) && $data->success=="true")
    {
      $this->form_validation->set_rules('logPhone', 'Phone number', 'required|min_length[15]|max_length[20]');
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
      if($this->form_validation->run() == TRUE)
      {
        $postData = $this->input->post();
        $filteredPostData = $this->filter_data($postData);

        $phone = $filteredPostData['logPhone'];
        $password = md5($filteredPostData['password']);

        $user = $this->AuthModel->loginCheck($phone, $password);

        if($user)
        {
          if($user->status == 1)
          {
            $this->session->set_flashdata("success", "Hesaba uğurla daxil olundu");

            $_SESSION['user_logged'] = TRUE;
            $_SESSION['username'] = $user->firstname?$user->lastname." ".$user->firstname:$user->lastname;
            $this->session->set_userdata('user_id', $user->user_id);

            $this->load->model('universal_model');
            $this->universal_model->item_edit_save_where(array('user_id'=> $this->session->userdata('user_id')), array('tmp_user_id'=> $this->session->userdata('tmp_user')),'orders');
            $this->universal_model->item_edit_save_where(array('user_id'=> $this->session->userdata('user_id')), array('tmp_user_id'=> $this->session->userdata('tmp_user')),'order_numbers');
          }
          else if ($user->status == 0)
            $this->session->set_flashdata("error", "Sizin hesabınız təsdiq gözləyir");
          else
            $this->session->set_flashdata("error", "Sizin hesabınız admin tərəfindən silinib");
        }
        else
          $this->session->set_flashdata("error", "Belə hesab mövcud deyil");
      }
      else
        $this->session->set_flashdata("error", validation_errors());
    }
    else
      $this->session->set_flashdata("error", "Check a captcha");

    redirect("/pages/index/main-page");
  }

  public function registration()
  {
    $form_response = $this->input->post('g-recaptcha-response');
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $secret = 'xxxx';
    $response = file_get_contents($url."?secret=".$secret."&response=".$form_response."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $data = json_decode($response);
    if(isset($data->success) && $data->success=="true")
    {
      $this->form_validation->set_rules('corporateName', 'corporateName', 'max_length[50]');
      $this->form_validation->set_rules('fullname', 'fullname', 'required|max_length[100]');
      $this->form_validation->set_rules('phone', 'phone', 'required|min_length[15]|max_length[20]|is_unique[site_users.phone]');
      $this->form_validation->set_rules('password2', 'Password', 'required|min_length[6]');
      $this->form_validation->set_rules('repeatPassword', 'Repeart password', 'required|matches[password2]');

      if($this->form_validation->run() == TRUE)
      {
        $postData = $this->input->post();
        $filteredPostData = $this->filter_data($postData);
        $now = date("Y-m-d");

        $array = array(
          'lastname' => $filteredPostData['fullname'],
          'company_name' => $filteredPostData['corporateName'],
          'password' => md5($filteredPostData['password2']),
          'status' => 0,
          'registrationDate' => $now,
          'phone' => $filteredPostData['phone']
        );
        $result = $this->AuthModel->addNewUser($array);

        if($result)
          $this->session->set_flashdata("success", "New account has been added");
        else
          $this->session->set_flashdata("error", 'Database error');
      }
      else
        $this->session->set_flashdata("error", validation_errors());
    }
    else
      $this->session->set_flashdata("error", "Check a captcha!");

    redirect("/pages/index/main-page");
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

}

?>
