<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	}
	public function index($msg="")
	{
		$data = array();
		$ip = md5($_SERVER['REMOTE_ADDR']);
		$v = $this->cache->get($ip.'_ip_address');
		$wrong_number = $this->cache->get($ip.'_ip_address');
		if($this->cache->get($ip.'_ip_address'))
		{
			if(@$wrong_number["wrong_number"]>2)
			{
				$data["captcha"]=1;
			}
		}
		if($msg=="wrong_login")
		$data["status"]=array("status"=>"danger", "msg" => "The username or password you entered is incorrect!");
		else if($msg=="user_profile")
		$data["status"]=array("status"=>"warning", "msg" => "Şəxsi məlumatlarınız dəyişdiyi üçün təkrar giriş etməyiniz lazımdır!");

		if($this->input->post())
		{
			$name = trim($this->input->post("user_name"));
			$pass = trim($this->input->post("user_pass"));
			$ip = md5($_SERVER['REMOTE_ADDR']);
			$number ="";

			if($name && $pass)
			{
				if($this->cache->get($ip.'_ip_address'))
				{
					if(@$wrong_number["wrong_number"]>2)
					{
						if($this->session->userdata("captcha")==TRUE && (strtolower(trim($this->input->post("captcha")))==$this->session->userdata("captcha")))
						{
							$this->check_function();
						}else
						{
							$data["status"]=array("status"=>"danger", "msg" => "The CAPTCHA code you entered was incorrect!");
							$number = $wrong_number["wrong_number"]+1;
							$this->cache->write(array("wrong_number"=>$number), $ip.'_ip_address');
						}
					}else
					{
						$this->check_function();
					}
				}else
				{
					$this->check_function();
				}
			}else
			{

				if($this->cache->get($ip.'_ip_address'))
				{
					$wrong_number = $this->cache->get($ip.'_ip_address');
					$number = $wrong_number["wrong_number"]+1;
					$this->cache->write(array("wrong_number"=>$number), $ip.'_ip_address');
				}else
					$this->cache->write(array("wrong_number"=>$number), $ip.'_ip_address');
				$data["status"]=array("status"=>"danger", "msg" => "Please fill in <strong>all</strong> fields!");
			}
		}
		$this->load->view('admin/login', $data);
	}


	public function captcha()
	{
		require('php-captcha.inc.php');
		$aFonts = array('system/fonts/comicbd.ttf', 'system/fonts/comic.ttf', 'system/fonts/comic.ttf');
		$oVisualCaptcha = new PhpCaptcha($aFonts, 120, 32);
		$oVisualCaptcha->iNumLines = FALSE;
		$oVisualCaptcha->iMaxFontSize = 12;
		$oVisualCaptcha->iMinFontSize = 12;
		$oVisualCaptcha->UseColour(TRUE);
		$random = strtolower(substr(md5(date("Y-m-d H:i:s:U")),0,4));
		$this->session->set_userdata(array("captcha"=>$random));
		$oVisualCaptcha->sCode = $random;
		$oVisualCaptcha->Create();
	}
	private function check_function()
	{
		$name = trim($this->input->post("user_name"));
		$pass = trim($this->input->post("user_pass"));
		$ip = md5($_SERVER['REMOTE_ADDR']);
		$number = 1;
		$result = $this->auth_model->check_login($name, $pass);
		if($result)
		{
				$data = array(
					'name' 		=> trim($result->name),
					'full_name' 	=> trim($result->full_name),
					'id'				=> trim($result->id),
					'email'		=> trim($result->email),
					'gender_id'		=> trim($result->gender_id),
					'role_id'		=> trim($result->role_id),
					'thumb'		=> trim($result->thumb)
				);
				$this->session->set_userdata($data);
				$this->cache->delete($ip.'_ip_address');
				$this->cache->delete($data["name"].'_exit');
				redirect('/adm/index/');
		}
		else
		{

			if($this->cache->get($ip.'_ip_address'))
			{
				$wrong_number = $this->cache->get($ip.'_ip_address');
				$number = $wrong_number["wrong_number"]+1;
				$this->cache->write(array("wrong_number"=>$number), $ip.'_ip_address');
			}else
				$this->cache->write(array("wrong_number"=>$number), $ip.'_ip_address');

			$this->session->set_userdata(array("captcha"=>rand(1,99999)));
			redirect("/auth/index/wrong_login");
		}


	}
	function logout($msg = FALSE)
	{
		$this->cache->delete($this->session->userdata('name').'_exit');
		$this->cache->delete_group("_adm_menu_");
		$this->session->sess_destroy();
		redirect("/auth/index/".$msg);
	}

















}
