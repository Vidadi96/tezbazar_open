<?php

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if($_SESSION['user_logged'] == FALSE)
    {
      $this->session->set_flashdata("error", "Please login first to view this page!");
      redirect("/login-page");
    }
  }

  public function profile()
  {
    if($_SESSION['user_logged'] == FALSE)
    {
      $this->session->set_flashdata("error", "Please login first to view this page!");
      redirect("/login-page");
    }

    $this->load->view('Templates/header');
    $this->load->view('Pages/profile');
    $this->load->view('Templates/footer');
  }
}

 ?>
