<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	function __construct()
	{
		parent::__construct();
    $this->load->library("template");
    $this->langs = (object)$this->template->labels;
		//$this->load->model('profile_model');
		$this->load->model('universal_model');
		//$this->output->enable_profiler(TRUE);
	}
	function filter_data($array)
	{
		$data = array();
		foreach ($array as $key => $value) {
			if(is_array($value))
				$data[$key]= $value;
			else
				$data[$key]= filter_var(str_replace(array("'", '"',"`", ')', '(', "-"), array("","","","","",""), $this->security->xss_clean(strip_tags(rawurldecode($value)))), FILTER_SANITIZE_STRING);
		}
		return $data;
	}


	public function register($status="")
  {
    $data= [];

    if($this->input->post())
    {
			require_once ($this->config->item("server_root")."/recaptchalib.php");
	    // Register API keys at https://www.google.com/recaptcha/admin
	    $siteKey = "6Lf9kc8UAAAAAI8XNnlKiZmkzGbGKURai6SGVBvA";
	    $secret = "6Lf9kc8UAAAAANNMlJUrfPOk2JOFDN_Am7ykp_4s";
	    // reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
	    $lang = "az";
	    // The response from reCAPTCHA
	    $resp = null;
	    // The error code from reCAPTCHA, if any
	    $error = null;
	    $reCaptcha = new ReCaptcha($secret);

      $resp = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
      if ($resp != null && $resp->success) {
          $post = $this->filter_data($this->input->post());
          $key = $this->config->item('encryption_key');

    			$salt1 = hash('sha512', $key.$post["password"]);
    			$salt2 = hash('sha512', $post["password"].$key);
    			$hashed_password = md5(hash('sha512', $salt1.$post["password"].$salt2));
          $vars = [
            "gender"=>$post["gender"],
            "firstname"=>$post["firstname"],
            "lastname"=>$post["lastname"],
            "middlename"=>$post["middlename"],
            "birth_date"=>$post["year"]."-".$post["month"]."-".$post["day"],
            "email"=>$post["email"],
            "phone"=>$post["phone"],
            "company_name"=>$post["company_name"],
            "subscribe"=>$post["subscribe"],
            "password"=>$hashed_password,
          ];
          $result = $this->profile_model->registration($vars);
          if($result)
          {
						$address_vars = [
							"firstname"=>$post["firstname"],
							"lastname"=>$post["lastname"],
							"middlename"=>$post["middlename"],
							"address"=>$post["address"],
							"phone"=>$post["phone"],
							"zip_code"=>$post["zip_code"],
							"user_id"=>$result,
							"title"=>"Birinci ünvan"
						];
						$address_id = $this->universal_model->add_item($address_vars, "addresses");

						unset($vars["password"]);
						$vars["user_id"]=$result;
            $this->session->set_userdata($vars);
            $data["status"] = array("status"=>"success","title"=>"Success", "icon"=>"exclamation-triangle",  "msg"=>"Registration successful.");
          }

      }else {
        $data["status"] = array("status"=>"error","title"=>"Error", "icon"=>"exclamation-triangle",  "msg"=>"The reCAPTCHA response is invalid or malformed. Please try again.");
      }
    }
		if($status=="must_register")
		$data["status"] = array("status"=>"error","title"=>"Error", "icon"=>"exclamation-triangle",  "msg"=>"You must register first.");
		$data["register_form"] = $this->load->view("site/register_form", "", true);
    $this->template->home("site/register", $data);

  }
	public function login()
	{
		$data =[];
		if($this->input->post())
		{
			require_once ($this->config->item("server_root")."/recaptchalib.php");
	    // Register API keys at https://www.google.com/recaptcha/admin
	    $siteKey = "6Lf9kc8UAAAAAI8XNnlKiZmkzGbGKURai6SGVBvA";
	    $secret = "6Lf9kc8UAAAAANNMlJUrfPOk2JOFDN_Am7ykp_4s";
	    // reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
	    $lang = "az";
	    // The response from reCAPTCHA
	    $resp = null;
	    // The error code from reCAPTCHA, if any
	    $error = null;
	    $reCaptcha = new ReCaptcha($secret);
			$resp = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
			if ($resp != null && $resp->success) {
				if(!$this->input->post("email") || !$this->input->post("password"))
				{
					$data["status"] = array("status"=>"error","title"=>"Error", "icon"=>"exclamation-triangle",  "msg"=>"Zəhmət olmasa bütün xanaları doldurun.");
				}else {
					$result = $this->profile_model->check_login($this->input->post("email"), $this->input->post("password"));
					if($result)
					{
						unset($result["password"]);
						$this->universal_model->item_edit_save_where(array("user_id"=>$result["user_id"]), array("tmp_user_id"=>$this->session->userdata("tmp_user")), "orders");
						$this->session->set_userdata($result);

						$data["status"] = array("status"=>"success","title"=>"Uğurlu", "icon"=>"exclamation-triangle",  "msg"=>"Siz portala uğurla daxil oldunuz.");
					}
				}
			}else {
        $data["status"] = array("status"=>"error","title"=>"Error", "icon"=>"exclamation-triangle",  "msg"=>"The reCAPTCHA response is invalid or malformed. Please try again.");
      }


		}

		$data["register_form"] = $this->load->view("site/register_form", "", true);
		$this->template->home("site/login", $data);
	}
	public function wishlist($remove_item=0)
	{
		$data =[];
		$remove_item = (int)$remove_item;
		if($remove_item)
		{
			if($this->session->userdata("user_id"))
				$where = array("id"=>$remove_item, "user_id"=>$this->session->userdata("user_id"));
			else
				$where = array("id"=>$remove_item, "tmp_user_id"=>$this->session->userdata("tmp_user"));

			$this->universal_model->delete_item_where($where, "orders");
		}
		$data["wishlist"] = $this->profile_model->get_in_basket(9);
		$data["hash_user_id"] = $this->template->encrypt("Azərbaycan Respublikası");
		$this->template->home("site/wishlist", $data);
	}
	public function sharing_list($share_id)
	{
		$share_id = filter_var(str_replace(array("'", '"',"`", ')', '(', "-"), array("","","","","",""), $this->security->xss_clean(strip_tags(rawurldecode($share_id)))), FILTER_SANITIZE_STRING);
		$data["list"] = $this->profile_model->get_wishlist($share_id);
		$this->template->home("site/wishlist", $data);
	}
	public function add_wishlist($id)
	{
		if($id)
		{
			if(!$this->session->userdata("user_id"))
			{
				echo 0;
				// $vars = [
				// 	"gender"=>0,
				// 	"full_name"=>"",
				// 	"email"=>"",
				// 	"phone"=>"",
				// 	"company_name"=>"",
				// 	"subscribe"=>""
				// ];
				// $result = $this->profile_model->registration($vars);
				// $this->session->set_userdata($vars);
			}else {
				$product_id = (int)$id;
				$vars = array("product_id"=>$product_id, "share_id"=>md5($this->session->userdata("user_id")."wishlist"), "user_id"=>$this->session->userdata("user_id"));
				$id = $this->universal_model->add_item($vars, "wishlist");
				echo $id;
			}


		}
		/*echo '{"PopupTitle":null,"Status":"success","AddToCartWarnings":"","ErrorMessage":"","RedirectUrl":"","ProductAddedToCartWindow":"\r\n\r\n\r\n\r\n\u003cdiv class=\"productAddedToCartWindow\"\u003e\r\n    \u003cdiv class=\"productAddedToCartWindowTitle\"\u003e\r\n        ШТОТУКУ Е ДОДАДЕН ВО ВАШАТА ЖЕЛБОТЕКА\r\n    \u003c/div\u003e\r\n    \u003cdiv class=\"productAddedToCartItem\"\u003e\r\n        \u003cdiv class=\"productAddedToCartWindowImage\"\u003e\r\n            \u003ca href=\"/%D0%9A%D0%90%D0%A0%D0%A2%D0%9E%D0%9D-220-%D0%B3%D1%80-%D0%911-10070-%D0%88%D0%90%D0%9A%D0%90-%D0%91%D0%9E%D0%88%D0%90-%D0%B0%D1%80%D0%B0%D0%B3%D0%BE%D1%81%D1%82%D0%B0-%D0%9E%D0%A0%D0%90%D0%9D%D0%96\" title=\"Прикажи детали за Картон 220 Гр. Б1 100*70 Јака Боја Арагоста- Оранж\"\u003e\r\n                \u003cimg alt=\"Слика на Картон 220 Гр. Б1 100*70 Јака Боја Арагоста- Оранж\" src=\"https://www.officeplus.mk/content/images/thumbs/0040086_karton-220-gr-b1-10070-aka-boa-aragosta-oran_210.jpeg\" title=\"Прикажи детали за Картон 220 Гр. Б1 100*70 Јака Боја Арагоста- Оранж\" /\u003e\r\n            \u003c/a\u003e\r\n        \u003c/div\u003e\r\n        \u003cdiv class=\"productAddedToCartWindowDescription\"\u003e\r\n            \u003ch1\u003e\r\n                \u003ca href=\"/%D0%9A%D0%90%D0%A0%D0%A2%D0%9E%D0%9D-220-%D0%B3%D1%80-%D0%911-10070-%D0%88%D0%90%D0%9A%D0%90-%D0%91%D0%9E%D0%88%D0%90-%D0%B0%D1%80%D0%B0%D0%B3%D0%BE%D1%81%D1%82%D0%B0-%D0%9E%D0%A0%D0%90%D0%9D%D0%96\"\u003eКартон 220 Гр. Б1 100*70 Јака Боја Арагоста- Оранж\u003c/a\u003e\r\n            \u003c/h1\u003e\r\n            \u003cstrong class=\"price\"\u003e85,00 ден / по единица\u003c/strong\u003e\r\n            \u003cdiv class=\"attributeInfo\"\u003e\u003c/div\u003e\r\n            \u003cspan class=\"quantity\"\u003eКоличина : 1\u003c/span\u003e\r\n        \u003c/div\u003e\r\n    \u003c/div\u003e\r\n    \u003cdiv class=\"productAddedToCartWindowSummary\"\u003e\r\n        \u003ca class=\"continueShoppingLink\" href=\"#\"\u003eПРОДОЛЖЕТЕ СО КУПУВАЊЕ\u003c/a\u003e\r\n        \u003cdiv\u003e\r\n            \u003cinput type=\"submit\" class=\"button-1 productAddedToCartWindowCheckout\" value=\"Желботека\" onclick=\"setLocation(\u0027/wishlist\u0027);\" /\u003e\r\n        \u003c/div\u003e\r\n    \u003c/div\u003e\r\n\r\n\u003c/div\u003e"}';*/
	}

	public function add_basket()
	{
		if($this->input->post())
		{
			$this->form_validation->set_rules('product_id','Product id', 'required|max_length[10]|numeric');
			$this->form_validation->set_rules('count','Count', 'required');
			$this->form_validation->set_rules('cat_id','Category Id', 'max_length[10]|numeric');

			if($this->form_validation->run() == TRUE)
			{
				if(!$this->input->post("cat_id"))
					$cat_id = $this->profile_model->get_default_category((int)$this->input->post("product_id"));
				else
					$cat_id = (int)$this->input->post("cat_id");

				$vars = [
						"product_id" => (int) $this->input->post("product_id"),
						"cat_id" => $cat_id
					];
				$order_status_id = 8;
				$search_forbasket = $vars;
				$product =	$this->profile_model->get_product_for_basket($vars);
				if($product)
				{
					$vars["im_price"]=0;
					$vars["ex_price"]=$product->price;
					$vars["discount"]=0;
					$vars["title"]=$product->title;
					$vars["img"]=$product->img;
					$vars["count"]=(float) $this->input->post("count");
					$vars["warehouse_id"]=0;
					$vars["measure_id"]=$product->measure_id;
					$vars["date_time"]= date("Y-m-d H:i:s");
					$vars["tmp_user_id"] = $this->session->userdata('tmp_user')?$this->session->userdata("tmp_user"):0;
					$vars["user_id"]= $this->session->userdata("user_id")?$this->session->userdata("user_id"):0;
					$general_basket=[];

					$ost_count = $this->profile_model->get_product_count($vars['product_id'], $this->session->userdata('lang_id'))->count;

					if(!$this->session->userdata("user_id"))
					{
							$o_count_arr = $this->profile_model->get_ordered_count($vars['product_id'], $this->session->userdata('user_id'));
							$o_count = $o_count_arr?$o_count_arr->count:0;

							if($vars['count'] <= ($ost_count - $o_count))
							{
								$search_forbasket["tmp_user_id"] = $this->session->userdata('tmp_user');
								$order_number = $this->universal_model->get_item_where("order_numbers", array("tmp_user_id"=>$this->session->userdata('tmp_user'), "order_status_id"=>$order_status_id), "*");

								if(!$order_number)
									$order_number = $this->universal_model->add_item(array("tmp_user_id"=>$this->session->userdata('tmp_user'), "order_status_id"=>$order_status_id, "date_time"=>date("Y-m-d H:i:s"), "region_id"=>0,"address_id"=>0), "order_numbers");
								else
									$order_number = $order_number->order_number;

								$search_forbasket["order_number"] = $order_number;
								$vars["order_number"] = $order_number;
								$result["in_basket"] = $this->universal_model->get_item_where("orders", $search_forbasket, "*");
								$vars["share_id"]= md5($this->session->userdata('tmp_user')."wishlist");

								if($result["in_basket"])
									$this->universal_model->item_edit_save_where(array("count"=>($result["in_basket"]->count+$vars["count"])), $search_forbasket, "orders");
								else
									$this->universal_model->add_item($vars, "orders");

								echo json_encode(array("msg"=>$this->langs->added_to_basket, "status"=>"success", "header"=>$this->langs->success_title2));
							}
							else
								echo json_encode(array("msg"=>$this->langs->there_is_no_such_quantity_of_products_in_stock2, "status"=>"error", "header"=>$this->langs->error_title2));
					} else {
						$o_count_arr = $this->profile_model->get_ordered_count($vars['product_id'], $this->session->userdata('user_id'));
						$o_count = $o_count_arr?$o_count_arr->count:0;

						if($vars['count'] <= ($ost_count - $o_count))
						{
							$order_number = $this->universal_model->get_item_where("order_numbers", array("user_id"=>$this->session->userdata('user_id'), "order_status_id"=>$order_status_id), "*");

							if(!$order_number)
								$order_number = $this->universal_model->add_item(array("user_id"=>$this->session->userdata('user_id'), "order_status_id"=>$order_status_id, "date_time"=>date("Y-m-d H:i:s"), "region_id"=>0,"address_id"=>0), "order_numbers");
							else
								$order_number = $order_number->order_number;

							$search_forbasket["order_number"] = $order_number;
							$vars["order_number"] = $order_number;

							$search_forbasket["user_id"] = $this->session->userdata('user_id');
							$result["in_basket"] = $this->universal_model->get_item_where("orders", $search_forbasket, "*");
							$vars["share_id"]= md5($this->session->userdata('user_id')."wishlist");

							if($result["in_basket"])
								$this->universal_model->item_edit_save_where(array("count"=>($result["in_basket"]->count+$vars["count"])), $search_forbasket, "orders");
							else
								$this->universal_model->add_item($vars, "orders");

							echo json_encode(array("msg"=>$this->langs->added_to_basket, "status"=>"success", "header"=>$this->langs->success_title2));
						}
						else
							echo json_encode(array("msg"=>$this->langs->there_is_no_such_quantity_of_products_in_stock2, "status"=>"error", "header"=>$this->langs->error_title2));
					}
				}
				else
					echo json_encode(array("msg"=>$this->langs->product_not_found, "status"=>"error", "header"=>$this->langs->error_title2));
			}
			else
				echo 'validation error';
		}
	}

	public function cart($remove_item=0)
	{
		$remove_item = (int)$remove_item;
		if($remove_item)
		{
			if($this->session->userdata("user_id"))
				$where = array("id"=>$remove_item, "user_id"=>$this->session->userdata("user_id"));
			else
				$where = array("id"=>$remove_item, "tmp_user_id"=>$this->session->userdata("tmp_user"));

			$this->universal_model->delete_item_where($where, "orders");
		}
		$general_basket["in_basket"] = $this->profile_model->get_in_basket();
		//print_r($general_basket["in_basket"]);
		$this->template->home("site/cart", $general_basket);
	}
	public function checkout()
	{
		$general_basket["in_basket"] = $this->profile_model->get_in_basket();
		$general_basket["shipping"] = $this->profile_model->get_shipping(0);
		$data = array("basket"=>1, "delivery"=>1, "payment"=>0, "confirm"=>0, "complete"=>0);

		$general_basket["user"] = [];
		if($this->session->userdata("user_id"))
		{
			$general_basket["user"] = $this->universal_model->get_item("site_users", array("user_id"=>$this->session->userdata("user_id")));
			$general_basket["addresses"] = $this->universal_model->get_more_item("addresses", array("user_id"=>$this->session->userdata("user_id")), 0, array("address_id", "ASC"));
			//print_r($general_basket["addresses"]);
		}
		$general_basket["order_progress"] = $this->load->view("site/order_progress", $data, TRUE);
		$this->template->home("site/checkout",$general_basket);
	}
	public function confirm()
	{
		$data = array("basket"=>1, "delivery"=>1, "payment"=>1, "confirm"=>1, "complete"=>0);
		$general_basket["shipping"] = $this->profile_model->get_shipping(0);
		$general_basket["order_progress"] = $this->load->view("site/order_progress", $data, TRUE);
		$this->template->home("site/confirm",$general_basket);
	}
	public function complete()
	{
		$data = array("basket"=>1, "delivery"=>1, "payment"=>1, "confirm"=>1, "complete"=>1);
		$general_basket["order_progress"] = $this->load->view("site/order_progress", $data, TRUE);
		$general_basket["shipping"] = $this->profile_model->get_shipping(0);
		$where=[];
		$post = $this->filter_data($this->input->get());
		$address_id = 0;
		$selected_shipping = "";
		$order_number = 0;
		foreach ($general_basket["shipping"] as $city) {
			if($city->region_id==$post["city"])
			{
				$selected_shipping = $city->path.($city->price?' - '.$city->price.' AZN':'');
			}
		}
		if(!$this->session->userdata("user_id"))
		{
			$key = $this->config->item('encryption_key');
			$pass = "123456";
			$salt1 = hash('sha512', $key.$pass);
			$salt2 = hash('sha512', $pass.$key);
			$hashed_password = md5(hash('sha512', $salt1.$pass.$salt2));
			$vars = [
				"gender"=>0,
				"firstname"=>$post["firstname"],
				"lastname"=>$post["lastname"],
				"middlename"=>$post["middlename"],
				"birth_date"=>'',
				"email"=>$post["email"],
				"region_id"=>$post["city"],
				"address"=>$post["address"],
				"phone"=>$post["phone"],
				"zip_code"=>$post["zip_code"],
				"company_name"=>'',
				"subscribe"=>0,
				"password"=>$hashed_password,
			];
			$result = $this->profile_model->registration($vars);
			if($result)
			{
				unset($vars["password"]);
				$vars["user_id"] = $result;
				$vars["tmp_user_id"] = $this->session->userdata("tmp_user");
				$this->universal_model->item_edit_save_where(array("user_id"=>$result), array("tmp_user_id"=>$this->session->userdata("tmp_user")), "orders");
				$this->session->set_userdata($vars);

				$address_vars = [
					"firstname"=>$post["firstname"],
					"lastname"=>$post["lastname"],
					"middlename"=>$post["middlename"],
					"address"=>$post["address"],
					"phone"=>$post["phone"],
					"zip_code"=>$post["zip_code"],
					"user_id"=>$result,
					"title"=>"Birinci ünvan"
				];
				$address_id = $this->universal_model->add_item($address_vars, "addresses");
			}
		}
		if($this->session->userdata("user_id"))
		{
			$address_id = $address_id?$address_id:$this->input->get("address_id");
			$where = array("user_id"=>$this->session->userdata("user_id"));
			$address = $this->universal_model->get_item("addresses", array("user_id"=>$this->session->userdata("user_id")));
			$data["user"]=[
				"gender"=>0,
				"city"=>$selected_shipping,
				"lastname"=>$address->lastname,
				"firstname"=>$address->firstname,
				"middlename"=>$address->middlename,
				"birth_date"=>'',
				"email"=>$this->session->userdata("email"),
				"region_id"=>$post["city"],
				"address"=>$address->address,
				"phone"=>$address->phone,
				"zip_code"=>$address->zip_code
			];
		}
		else
		{
			/*$where = array("tmp_user_id"=>$this->session->userdata("tmp_user"));
			$data["user"]=[
				"gender"=>0,
				"firstname"=>$post["firstname"],
				"lastname"=>$post["lastname"],
				"middlename"=>$post["middlename"],
				"birth_date"=>'',
				"email"=>$post["email"],
				"region_id"=>$post["city"],
				"address"=>$post["address"],
				"city"=>$selected_shipping,
				"phone"=>$post["phone"],
				"zip_code"=>$post["zip_code"]
			];*/
		}
		//$where["order_status_id"] = 8;
		$order_number = $this->profile_model->get_user_order_number();
		$data["shipping"] = $this->profile_model->get_shipping(0);
		$data["orders"] = $this->profile_model->get_in_basket();

		$this->universal_model->item_edit_save_where(array("order_status_id"=>7, "region_id"=>$post["city"], "address_id"=>$address_id, "user_id"=>$this->session->userdata("user_id")), array("order_number"=>$order_number->order_number), "order_numbers");

		$data["order_number"] = $order_number->order_number;
		$msg = $this->load->view("site/for_email", $data, TRUE);
		$result = $this->template->send_mail("Yeni sifariş: ", $msg);
		$general_basket["order_number"] = $order_number->order_number;
		$this->template->home("site/complete",$general_basket);
		//info@officeplus.az;s.alirzaeva@gmail.com
	}
	/*function test_send()
	{
		$this->load->library('email');
			$config = Array(
			    'protocol' => 'smtp',
			    'smtp_host' => 'ssl://mail.gov.az',
			    'smtp_port' => 465,
			    'smtp_user' => 'nezaret@nk.gov.az',
			    'smtp_pass' => 'gO63x#!v^zX#f',
			    'mailtype'  => 'html',
			    'charset'   => 'UTF-8'
			);
			$this->email->initialize($config);
			$this->email->from("nezaret@nk.gov.az");
			$this->email->to("shiraziismailov@gmail.com");
			//$this->email->set_header("Read-Receipt-To", "shirazi@stdc.az");
			//$this->email->set_header("X-Confirm-reading-to", "shirazi@stdc.az");



			//$this->email->cc("shiraziismailov@gmail.com");
			$this->email->subject("test mövzu");
			$this->email->message('test mail');
		$result = $this->email->send();
		print_r($result);
	}*/
	public function order_details()
	{

		$general_basket = array();
		$this->template->home("site/order_details",$general_basket);
	}
	public function payment()
	{
		$general_basket["in_basket"] = $this->profile_model->get_in_basket();
		$data = array("basket"=>1, "delivery"=>1, "payment"=>1, "confirm"=>0, "complete"=>0);
		$general_basket["order_progress"] = $this->load->view("site/order_progress", $data, TRUE);
		$this->template->home("site/payment",$general_basket);
	}
	public function in_basket()
	{
		$general_basket["in_basket"] = $this->profile_model->get_in_basket();
		$this->load->view("site/basket", $general_basket);
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect("/office/index/");
	}
	public function delete_address()
	{
		$address_id = $this->input->get("addressId");
		if($address_id && $this->session->userdata("user_id"))
		{
			$this->universal_model->delete_item_where(array("user_id"=>$this->session->userdata("user_id"), "address_id"=>$address_id), "addresses");
			echo json_encode(array("status"=>"success"));
		}
	}
	public function my_profile()
	{
		$data=[];
		if($this->input->get("action")=="address_edit")
		{
			$data["address_item"] = $this->universal_model->get_item("addresses", array("address_id"=>$this->input->get("address_id")));
		}
		if($this->input->post() && $this->input->get("action")=="address_edit")
		{
			$post = $this->filter_data($this->input->post());
			$array = array(
				"firstname"=>$post["firstname"],
				"lastname"=>$post["lastname"],
				"middlename"=>$post["middlename"],
				"address"=>$post["address"],
				"zip_code"=>$post["zip_code"],
				"phone"=>$post["phone"],
				"user_id"=>$this->session->userdata("user_id"),
				"title"=>$post["title"],
			);
			$result = $this->universal_model->item_edit_save_where($array, array("address_id"=>$post["address_id"]), "addresses");
			if($result)
			redirect("/profile/my_profile/?page=3&status=success");

		}
		if($this->input->post() && $this->input->get("action")=="address_add")
		{
			$post = $this->filter_data($this->input->post());
			$array = array(
				"firstname"=>$post["firstname"],
				"lastname"=>$post["lastname"],
				"middlename"=>$post["middlename"],
				"address"=>$post["address"],
				"zip_code"=>$post["zip_code"],
				"phone"=>$post["phone"],
				"user_id"=>$this->session->userdata("user_id"),
				"title"=>$post["title"],
			);
			$id = $this->universal_model->add_item($array, "addresses");
			if($id)
			redirect("/profile/my_profile/?page=3&status=success");

		}
		$data["user"] = $this->universal_model->get_item("site_users", array("user_id"=>$this->session->userdata("user_id")));
		$data["orders"] = $this->profile_model->orders();

		$data["addresses"] = [];
		if($this->input->get("page")==3)
		$data["addresses"] = $this->universal_model->get_more_item("addresses", array("user_id"=>$this->session->userdata("user_id")), 0, array("address_id", "ASC"));

		$this->template->home("site/my_profile", $data);
	}
	public function order_list()
	{
		$order_number =(int)$this->input->get("order_number");
		$data["orders"] = $this->profile_model->get_order_list($order_number);
		$this->load->view("site/order_list", $data);
	}


}
