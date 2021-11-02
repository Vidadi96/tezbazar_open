<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
	function __construct()
	{
		parent::__construct();
    $this->load->library("template");
    $this->load->model("blog_model");
    $this->langs = (object)$this->template->labels;
		//$this->output->enable_profiler(TRUE);
	}

	function index($from=0)
	{
    $data =[];
		$result = $this->blog_model->get_news($from, 20, 1);
		$data["list"] = $result["list"];
		//print_r($data["list"]);
		//echo $this->template->encrypt(55);
		$this->template->home("site/blog", $data);
	}
	function blog($id)
	{
		$data=[];
		$id = (int)$id;
		$data["blog"]=$this->blog_model->get_blog_item($id);
		//print_r($data["blog"]);
		//echo 5555555555;
		$this->template->home("site/blog_single", $data);
	}



}
