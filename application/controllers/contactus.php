<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus extends CI_Controller {
	function __construct()
	{
		parent::__construct();
    $this->load->library("template");
    $this->langs = (object)$this->template->labels;
	}
	function index()
	{
    $data =[];
		$this->template->home("site/contactus", $data);
	}



}
