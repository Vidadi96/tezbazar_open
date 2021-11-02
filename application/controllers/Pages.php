<?php
    class Pages extends CI_Controller
    {
      function __construct()
    	{
    		parent::__construct();
    		$this->load->model("PagesModel");
        $this->load->library("template");
        $this->langs = (object)$this->template->labels;
    	}

      public function test()
      {
        echo date();
      }

      public function index($pg = 'main-page')
      {
        // $this->output->enable_profiler(TRUE);

        $tmp_user = md5(strtotime("now"));

        if(!$this->session->userdata('tmp_user'))
          $this->session->set_userdata('tmp_user', $tmp_user);

        if(!$this->session->userdata('lang_id'))
          $this->session->set_userdata('lang_id', 2);

        $data['title'] = $pg;
        $data['cats_menu'] = $this->PagesModel->get_categories($this->session->userdata('lang_id'));
        $data['basket_count'] = $this->PagesModel->basket_count();
        $data['lang'] = $this->PagesModel->get_lang();
        $data['social_icons'] = $this->PagesModel->get_socials();
        $data['contact_map'] = $this->PagesModel->get_contact($this->session->userdata('lang_id'));
        $data['contact_phone'] = $this->PagesModel->get_phone();
        $data['footer_catalog'] = $this->PagesModel->get_footer_category($this->session->userdata('lang_id'));
        $data['description'] = $this->PagesModel->get_description($this->session->userdata('lang_id'));

        if(@$_SESSION['user_logged'])
        {
          if($pg == 'orders' || $pg == 'documents' || $pg == 'order-history')
          {
            $from=0;
            $search = $date_start = $date_end = '';

            $get_data = $this->input->get();
            $filtered_get = $this->filter_data($get_data);

            if($this->input->get('page'))
              $from = $filtered_get['page'];
            if($this->input->get('search'))
              $search = $filtered_get['search'];
            if($this->input->get('date_start'))
              $date_start = $filtered_get['date_start'];
            if($this->input->get('date_end'))
              $date_end = $filtered_get['date_end'];

            $data['search_params'] = array('search'=> $search, 'date_start'=> $date_start, 'date_end'=> $date_end);
            $end = 20;

            $base_url = "/pages/index/".$pg;
            if ($pg == 'orders')
              $nums_string = '10,11,12,13,14,15,16,17';
            else if ($pg == 'documents')
              $nums_string = '10,12,14,15,16,17';
            else if ($pg == 'order-history')
              $nums_string = '14,15,17';

            $total = $this->PagesModel->get_orders_rows($nums_string, $search, $date_start, $date_end);

            if($total->count >= 1)
              $data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);
          }
        }


        if($pg=='main-page')
        {
          $active_passive1 = $time1 = $active_passive2 = $time2 = $active_passive3 = $time3 = 0;

          $data['main_page_products'] = $this->PagesModel->main_page_products($this->session->userdata('lang_id'), 'show_in_main_page');
          $data['main_page_daily_products'] = $this->PagesModel->main_page_products($this->session->userdata('lang_id'), 'gunun_mehsullari');
          $data['main_slide'] = $this->PagesModel->get_main_slide_images('slide1', '1000x500');
          $array1 = $this->PagesModel->get_slide_settings('slide1');
          if(count($array1)>0)
      		{
      			foreach($array1 as $row)
      			{
      				$active_passive1 = $row->active_passive;
      				$time1 = $row->time;
      			}
      		}

          $data['brands_slide'] = $this->PagesModel->get_main_slide_images('brands_slide', '90x90');
          $data['partners_slide'] = $this->PagesModel->get_main_slide_images('partners_slide', '90x90');

          $array2 = $this->PagesModel->get_slide_settings('brands_slide');
          if(count($array2)>0)
      		{
      			foreach($array2 as $row)
      			{
      				$active_passive2 = $row->active_passive;
      				$time2 = $row->time;
      			}
      		}

          $array3 = $this->PagesModel->get_slide_settings('partners_slide');
          if(count($array3)>0)
      		{
      			foreach($array3 as $row)
      			{
      				$active_passive3 = $row->active_passive;
      				$time3 = $row->time;
      			}
      		}

          $array4 = $this->PagesModel->get_slide_settings('daily_products');
          if(count($array4)>0)
      		{
      			foreach($array4 as $row)
      			{
      				$active_passive4 = $row->active_passive;
      				$time4 = $row->time;
      			}
      		}

          $data['time1'] = $time1;
          $data['active_passive1'] = $active_passive1;
          $data['time2'] = $time2;
          $data['active_passive2'] = $active_passive2;
          $data['time3'] = $time3;
          $data['active_passive3'] = $active_passive3;
          $data['time4'] = $time4;
          $data['active_passive4'] = $active_passive4;
          $data['kolleksiyalar'] = $this->PagesModel->kolleksiyalar($this->session->userdata('lang_id'));


          $this->load->view('templates/header', $data);
          $this->load->view('Pages/'.$pg, $data);
          $this->load->view('templates/footer', $data);
        }
        else if($pg=='product' || $pg == 'korzina2')
        {
          $this->load->view('templates/header', $data);
          $this->load->view('Pages/'.$pg);
          $this->load->view('templates/footer', $data);
        }
        else if($pg=='recovery_pass')
        {
          $rec_pass = 0;
          if($this->input->get('rec_pass'))
          {
            $get_data = $this->input->get();
            $filtered_get = $this->filter_data($get_data);
            $rec_pass = $filtered_get['rec_pass'];
            $mail = $filtered_get['mail'];
          }

          if($rec_pass)
          {
            $data['rec_pass'] = $rec_pass;
            $data['mail'] = $mail;
          }
          else
            $data['rec_pass'] = 0;

          $this->load->view('templates/header', $data);
          $this->load->view('Pages/'.$pg);
          $this->load->view('templates/footer', $data);
        }
        else if($pg=='search')
        {
          if($this->input->get('search'))
          {
            $get_data = $this->input->get();
            $filtered_get = $this->filter_data($get_data);
            $seacrh_param = $filtered_get['search'];
            $from=0;
            $end = 20;

            $base_url = "/pages/index/".$pg;
            $total = $this->PagesModel->search_result_rows($seacrh_param, $this->session->userdata('lang_id'));
            $data['products'] = $this->PagesModel->search_result((int)$from, (int)$end, $seacrh_param, $this->session->userdata('lang_id'));

            if($total)
            if($total->count >= 1)
              $data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);

            $this->load->view('templates/header', $data);
            $this->load->view('Pages/'.$pg, $data);
            $this->load->view('templates/footer', $data);
          }
        }
        else if($pg == 'korzina1')
        {
          $data['basket_data'] = $this->PagesModel->basket_data(8, $this->session->userdata('lang_id'));
          $data['default_measure'] = $this->PagesModel->get_measure($this->session->userdata('lang_id'));

          $this->load->view('templates/header', $data);
          $this->load->view('Pages/'.$pg);
          $this->load->view('templates/footer', $data);
        }
        else if($pg == 'statistics')
        {
          $roles = $this->PagesModel->select_where('item_id', 'rel_type_id = 1 and rel_item_id = 160', 'relations');
          $access = false;
          $role_id = $this->session->userdata('role_id');

          foreach ($roles as $row):
            if (isset($role_id) && $this->session->userdata('role_id') == $row->item_id)
                $access = true;
          endforeach;

          if($access && (int) $this->input->get('admin') == 1)
          {
            $from = $buyer = 0;
            $data['date_start'] = $data['date_end'] = $type = $date_start = $date_end = '';
            $data['type'] = 2;
            $data['ord_type'] = $ord_type = 'asc';
            $data['ord_name'] = $ord_name = 'num';

            $get_data = $this->input->get();
            $filtered_get = $this->filter_data($get_data);

            if($this->input->get('page'))
              $from = (int)$filtered_get['page'];

            if($this->input->get('date_start'))
            {
              $date_start = $filtered_get['date_start'];
              $data['date_start'] = $date_start;
            }
            if($this->input->get('date_end'))
            {
              $date_end = $filtered_get['date_end'];
              $data['date_end'] = $date_end;
            }
            if($this->input->get('type'))
            {
              $type = (int)$filtered_get['type'];
              $data['type'] = (int)$filtered_get['type'];
            }
            if($this->input->get('buyer'))
            {
              $buyer = (int)$filtered_get['buyer'];
              $data['buyer'] = (int)$filtered_get['buyer'];
            }
            if($this->input->get('ord_type'))
            {
              $ord_type = $filtered_get['ord_type'];
              $data['ord_type'] = $filtered_get['ord_type'];
            }
            if($this->input->get('ord_name'))
            {
              $ord_name = $filtered_get['ord_name'];
              $data['ord_name'] = $filtered_get['ord_name'];
            }

            $end = 20;

            if($type == 1)
            {
              $data['statistic_type'] = 'check';
              $data['statistic_checks'] = $this->PagesModel->get_statistics_checks($from, $end, $date_start, $date_end, $ord_type, $ord_name, true, $buyer);
              $total = $this->PagesModel->get_statistics_checks_rows($date_start, $date_end, true, $buyer);
            } else {
              $data['statistic_type'] = 'product';
              $data['statistic_products'] = $this->PagesModel->get_statistics_products($this->session->userdata('lang_id'), $from, $end, $date_start, $date_end, $ord_type, $ord_name, true, $buyer);
              $total = $this->PagesModel->get_statistics_products_rows($date_start, $date_end, true, $buyer);
            }

            $base_url = "/pages/index/".$pg;

            if($total)
            if($total->count >= 1)
            $data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);
            $data["admin"] = 1;
            $data['site_users'] = $this->PagesModel->select_where('user_id, company_name', 'status=1', 'site_users');

            $this->load->view('templates/header', $data);
            $this->load->view('Pages/'.$pg, $data);
            $this->load->view('templates/footer', $data);
          }
          else
          {
            if(@$_SESSION['user_logged'])
            {
              $from=0;
              $data['date_start'] = $data['date_end'] = $type = $date_start = $date_end = '';
              $data['type'] = 2;
              $data['ord_type'] = $ord_type = 'asc';
              $data['ord_name'] = $ord_name = 'num';

              $get_data = $this->input->get();
              $filtered_get = $this->filter_data($get_data);

              if($this->input->get('page'))
                $from = (int)$filtered_get['page'];
              if($this->input->get('date_start'))
              {
                $date_start = $filtered_get['date_start'];
                $data['date_start'] = $date_start;
              }
              if($this->input->get('date_end'))
              {
                $date_end = $filtered_get['date_end'];
                $data['date_end'] = $date_end;
              }
              if($this->input->get('type'))
              {
                $type = (int)$filtered_get['type'];
                $data['type'] = (int)$filtered_get['type'];
              }
              if($this->input->get('ord_type'))
              {
                $ord_type = $filtered_get['ord_type'];
                $data['ord_type'] = $filtered_get['ord_type'];
              }
              if($this->input->get('ord_name'))
              {
                $ord_name = $filtered_get['ord_name'];
                $data['ord_name'] = $filtered_get['ord_name'];
              }

              $end = 20;

              if($type == 1)
              {
                $data['statistic_type'] = 'check';
                $data['statistic_checks'] = $this->PagesModel->get_statistics_checks($from, $end, $date_start, $date_end, $ord_type, $ord_name, false);
                $total = $this->PagesModel->get_statistics_checks_rows($date_start, $date_end, false);
              } else {
                $data['statistic_type'] = 'product';
                $data['statistic_products'] = $this->PagesModel->get_statistics_products($this->session->userdata('lang_id'), $from, $end, $date_start, $date_end, $ord_type, $ord_name, false);
                $total = $this->PagesModel->get_statistics_products_rows($date_start, $date_end, false);
              }
              $data["admin"] = 0;

              $base_url = "/pages/index/".$pg;

              if($total)
                if($total->count >= 1)
                  $data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);

              $this->load->view('templates/header', $data);
              $this->load->view('Pages/'.$pg, $data);
              $this->load->view('templates/footer', $data);
            }
            else
              redirect('/pages/index/main-page');
          }
        }
        else if($pg == 'statistika')
        {
          $roles = $this->PagesModel->select_where('item_id', 'rel_type_id = 1 and rel_item_id = 160', 'relations');
          $access = false;
          $role_id = $this->session->userdata('role_id');

          foreach ($roles as $row):
            if (isset($role_id) && $this->session->userdata('role_id') == $row->item_id)
                $access = true;
          endforeach;

          if($access && (int) $this->input->get('admin') == 1)
          {
            $data['admin'] = 1;
            $data['site_users'] = $this->PagesModel->select_where('user_id, company_name', 'status=1', 'site_users');

            $this->load->view('templates/header', $data);
            $this->load->view('Pages/'.$pg, $data);
            $this->load->view('templates/footer', $data);
          }
          else
          {
            if(@$_SESSION['user_logged'])
            {
              $admin = 0;
              $data['admin'] = $admin;

              $this->load->view('templates/header', $data);
              $this->load->view('Pages/'.$pg, $data);
              $this->load->view('templates/footer', $data);
            }
            else
              redirect('/pages/index/main-page');
          }
        }
        else
        {
          if(@$_SESSION['user_logged'])
          {
            if($pg == 'orders')
            {
              $data['orders_list'] = $this->PagesModel->get_orders((int)$from, (int)$end, '10, 11, 12, 13, 14, 15, 16, 17', $search, $date_start, $date_end);
              $data['orders'] = $this->load->view('Pages/orders', $data, TRUE);

              $this->load->view('templates/header', $data);
              $this->load->view('Pages/personal-area');
              $this->load->view('templates/footer', $data);
            }
            else if($pg == 'documents')
            {
              $data['orders_list'] = $this->PagesModel->get_orders((int)$from, (int)$end, '10, 12, 14, 15, 16, 17', $search, $date_start, $date_end);
              $data['reject_period'] = $this->PagesModel->select_where_row('reject_period', 'id=1', 'reject_period')->reject_period;
              $data['documents'] = $this->load->view('Pages/documents', $data, TRUE);

              $this->load->view('templates/header', $data);
              $this->load->view('Pages/personal-area');
              $this->load->view('templates/footer', $data);
            }
            else if($pg == 'personal_data')
            {
              $data['pd_list'] = $this->PagesModel->get_pd_list();

              $this->load->view('templates/header', $data);
              $this->load->view('Pages/'.$pg, $data);
              $this->load->view('templates/footer', $data);
            }
            else if($pg == 'order-history')
            {
              $data['history_list'] = $this->PagesModel->get_orders((int)$from, (int)$end, '14, 15, 17', $search, $date_start, $date_end);
              $data['orderHistory'] = $this->load->view('Pages/order-history', $data, TRUE);

              $this->load->view('templates/header', $data);
              $this->load->view('Pages/personal-area');
              $this->load->view('templates/footer', $data);
            }
            else if($pg == 'edit_order')
            {
              $status = $user_id = 0;
              $order_number = (int) $this->uri->segment(4);
              $arr = $this->PagesModel->select_where_row('order_status_id, user_id', array('order_number' => $order_number), 'order_numbers');
              if ($arr) {
                $status = $arr->order_status_id;
                $user_id = $arr->user_id;
              }

              if ($status == 10 && $user_id == $this->session->userdata('user_id'))
                $data['edit_products'] = $this->PagesModel->edit_products($order_number, $this->session->userdata('lang_id'));

              $this->load->view('templates/header', $data);
              $this->load->view('Pages/'.$pg);
              $this->load->view('templates/footer', $data);
            }
            else
            {
              $this->load->view('templates/header', $data);
              $this->load->view('Pages/'.$pg);
              $this->load->view('templates/footer', $data);
            }
          }
          else
            redirect('/pages/index/main-page');
        }
      }

      public function edit_order()
      {
        if($this->input->post())
        {
          $id = (int) $this->input->post('id');
          $count = (float) $this->input->post('count');

          if($count > 0)
          {
            $result = $this->PagesModel->update_table('orders', array('id' => $id), array('count' => $count));

            if($result)
              echo '{"msg":"'.$this->langs->changed2.'", "tezbazar":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"'.$this->langs->success_title2.'"}';
            else
              echo '{"msg":"'.$this->langs->error_title2.'", "tezbazar":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"'.$this->langs->error_title2.'"}';
          }
          else
            echo '{"msg":"'.$this->langs->count_bigger_than2.'", "tezbazar":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"'.$this->langs->error_title2.'"}';
        }
      }

      public function delete_order_product()
      {
        if($this->input->post())
        {
          $id = (int) $this->input->post('id');
          $result = $this->PagesModel->delete_item(array('id' => $id), 'orders');

          if($result)
            echo '{"msg":"'.$this->langs->successfully_deleted2.'", "tezbazar":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"'.$this->langs->success_title2.'"}';
          else
            echo '{"msg":"'.$this->langs->error_title2.'", "tezbazar":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"'.$this->langs->error_title2.'"}';
        }
      }

      public function update_basket_count()
      {
        echo json_encode($this->PagesModel->basket_count());
      }

      public function change_password()
      {
        if($this->input->post())
        {
          $this->form_validation->set_rules('last_password', 'Last Password', 'required|min_length[5]');
          $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[5]');
          $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

          if($this->form_validation->run() == TRUE)
          {
            $postData = $this->input->post();
            $filteredPostData = $this->filter_data($postData);

            $last = md5($filteredPostData['last_password']);
            $new = $filteredPostData['new_password'];

            $result = $this->PagesModel->change_password($last, $new);

            if($result)
              redirect('/pages/index/personal_data?pd=1');
            else
              redirect('/pages/index/personal_data?pd=0');
          }
          else
          {
            $arr = array('pd'=> validation_errors());
            $res = http_build_query($arr);
            redirect('/pages/index/personal_data?'.$res);
          }
        }
      }

      public function rec_pass()
      {
        if($this->input->post())
        {
          $this->form_validation->set_rules('rec_mail', 'Mail address', 'required|valid_email');

          if($this->form_validation->run() == TRUE)
          {
            $postData = $this->input->post();
            $filteredPostData = $this->filter_data($postData);

            $mail = $filteredPostData['rec_mail'];

            $result = $this->PagesModel->check_mail_list($mail);

            if($result)
            {
              $arr2 = array('rec_pass'=> $result->password, 'mail'=> $result->email);
              $res2 = http_build_query($arr2);
              $msg = '<h3>Recovery link: </h3><a href="'.base_url().'/pages/index/recovery_pass?'.$res2.'">Click to here</a>';
              $ress = $this->template->send_mail("Recovery password link: ", $msg, $result->email);

              if($ress)
              {
                $arr = array('succ_msg'=> 'Recovery password link sended to your mail');
                $res = http_build_query($arr);
                redirect('/pages/index/recovery_pass?'.$res);
              }
              else
              {
                $arr = array('err_msg'=> 'Something went wrong');
                $res = http_build_query($arr);
                redirect('/pages/index/recovery_pass?'.$res);
              }
            }
            else
            {
              $arr = array('err_msg'=> 'Such mail not found');
              $res = http_build_query($arr);
              redirect('/pages/index/recovery_pass?'.$res);
            }
          }
          else
          {
            $arr = array('err_msg'=> validation_errors());
            $res = http_build_query($arr);
            redirect('/pages/index/recovery_pass?'.$res);
          }
        }
      }

      public function cng_pass()
      {
        if($this->input->post())
        {
          $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[5]');
          $this->form_validation->set_rules('confirm_new_password', 'Confirm Password', 'required|matches[new_password]');

          if($this->form_validation->run() == TRUE)
          {
            $postData = $this->input->post();
            $filteredPostData = $this->filter_data($postData);

            $mail = $filteredPostData['mail'];
            $last = $filteredPostData['lp'];
            $new = $filteredPostData['new_password'];

            $result = $this->PagesModel->change_password2($last, $new, $mail);

            if($result)
            {
              $arr = array('succ_msg'=> 'Password successfully changed');
              $res = http_build_query($arr);
              redirect("/pages/index/main-page?".$res);
            }
            else
            {
              $arr = array('err_msg'=> 'Something went wrong');
              $res = http_build_query($arr);
              redirect("/pages/index/main-page?".$res);
            }
          }
          else
          {
            $arr = array('err_msg'=> validation_errors());
            $res = http_build_query($arr);
            redirect("/pages/index/main-page?".$res);
          }
        }
      }

      public function delete_item($id)
      {
        $this->load->model('universal_model');
        $remove_item = (int)$id;
        $order_number_array = $this->universal_model->get_item_where("orders", array("id"=> $remove_item), "order_number");
        $order_number = $order_number_array->order_number;

        if($this->session->userdata("user_id"))
          $where = array("id"=>$remove_item, "user_id"=>$this->session->userdata("user_id"));
        else
          $where = array("id"=>$remove_item, "tmp_user_id"=>$this->session->userdata("tmp_user"));

        $this->universal_model->delete_item_where($where, "orders");
        $order_number_exist = $this->universal_model->get_item_where("orders", array("order_number"=> $order_number), "*");

        if(!$order_number_exist)
          $this->universal_model->delete_item_where(array('order_number'=>$order_number, 'order_status_id'=>8), "order_numbers");

        redirect('/pages/index/korzina1');
      }

      public function done_basket()
      {
        $data['title'] = 'korzina2';
        $data['cats_menu'] = $this->PagesModel->get_categories($this->session->userdata('lang_id'));
        $data['basket_count'] = $this->PagesModel->basket_count();
        $data['lang'] = $this->PagesModel->get_lang();

        if($this->input->post())
        {
          $postData = $this->input->post();
          $array = $this->filter_data($postData);

          for($i=0; $i<count($array['img']); $i++)
          {
            $arrayData[$i]['img'] = $array['img'][$i];
            $arrayData[$i]['title'] = $array['title'][$i];
            $arrayData[$i]['count'] = $array['count'][$i];
            $arrayData[$i]['mn_title'] = $array['mn_title'][$i];
            $arrayData[$i]['tsena'] = $array['tsena'][$i];
            $arrayData[$i]['id'] = $array['id'][$i];
            $arrayData[$i]['p_id'] = $array['product_id'][$i];
            $arrayData[$i]['description'] = $array['description'][$i];
            $arrayData[$i]['summ'] = $array['summ'][$i];
          }

          foreach($arrayData as $row)
          {
            if($this->input->post(md5($row['id'])))
              $data['verify_basket'][] = $row;
          }
          $this->load->view('templates/header', $data);
          $this->load->view('Pages/korzina2', $data);
          $this->load->view('templates/footer', $data);
        }
        else
          redirect('/pages/index/korzina1?msg=0');
      }

      public function order()
      {
        $data['title'] = 'orders';
        $data['basket_count'] = $this->PagesModel->basket_count();

        if($this->input->post())
        {
          $postData = $this->input->post();
          $array = $this->filter_data($postData);

          for($i=0; $i<count($array['id']); $i++)
          {
            $arrayData[$i]['id'] = (int)$array['id'][$i];
            $arrayData[$i]['count'] = (float)$array['count'][$i];
            $arrayData[$i]['comment'] = $array['comment'][$i];
            $arrayData[$i]['p_id'] = (int)$array['p_id'][$i];
            $arrayData[$i]['img'] = $array['img'][$i];
            $arrayData[$i]['title'] = $array['title'][$i];
            $arrayData[$i]['mn_title'] = $array['mn_title'][$i];
            $arrayData[$i]['price'] = (float)$array['price'][$i];
            $arrayData[$i]['description'] = $this->universal_model->get_item_where("products", array("p_id"=>(int)$array['p_id'][$i], 'lang_id' => $this->session->userdata('lang_id')), "description")->description;
            $arrayData[$i]['discount'] = $this->universal_model->get_item_where("orders", array("id"=>(int)$array['id'][$i]), "discount")->discount;
          }

          $total_comment = $array['total_comment'];
          $total_address = $array['address'];

          $this->load->model('universal_model');
          $address = $this->universal_model->get_item_where("addresses", array("user_id"=>$this->session->userdata('user_id')), "address_id");
          $order_number = $this->universal_model->add_item(array("user_id"=> $this->session->userdata('user_id'),
                                                                 "order_status_id"=> 10,
                                                                 "date_time"=> date("Y-m-d H:i:s"),
                                                                 "region_id"=> 0,
                                                                 "comment"=> $total_comment,
                                                                 "address"=> $total_address), "order_numbers");

          if($order_number)
          {
            foreach($arrayData as $row)
            {
              $this->universal_model->item_edit_save_where(array('order_number'=> $order_number,
                                                                 'count'=> (float)$row['count'],
                                                                 'date_time'=> date("Y-m-d H:i:s"),
                                                                 'comment'=> $row['comment']), array('id'=> (int)$row['id']), "orders");
            }

            $data['use_other_side'] = false;
            $data['orders'] = $arrayData;
            $data['user'] = $this->universal_model->get_item_where('site_users', array('user_id'), '*');
            $data['address'] = $this->universal_model->get_item_where("addresses", array("user_id"=>$this->session->userdata('user_id')), "*");
            $data['order_number'] = $order_number;
            $data['qiymet_teklifi'] = 0;
            $msg = $this->load->view("site/for_email", $data, TRUE);

            if($this->session->userdata['lang_id']==2) {
    					$header = "Yeni sifariş";
              $new_order = 'Yeni sifariş uğurla əlavə edildi';
              $error = 'Xəta baş verdi';
    				} else if ($this->session->userdata['lang_id']==4) {
    					$header = "Yeni sipariş";
              $new_order = 'Yeni sipariş başarıyla eklendi';
              $error = 'Hata';
    				} else if ($this->session->userdata['lang_id']==1) {
    					$header = "New order";
              $new_order = 'New order successfully added';
              $error = 'Error';
    				} else if ($this->session->userdata['lang_id']==3) {
    					$header = "Новый заказ";
              $new_order = 'Новый заказ успешно добавлен';
              $error = 'Произошла ошибка';
    				}

        		$result = $this->template->send_mail($header.": ", $msg);
            if($result)
              $this->session->set_flashdata("success", $new_order);
            else
              $this->session->set_flashdata("error", $error);
          }
        }

        redirect('/pages/index/orders');
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

      function pdf($id=0)
      {
        $id = (int)$id;
        $this->load->helper('pdf_helper');

        $data['pdf_list'] = $this->PagesModel->pdf_list($id, $this->session->userdata('lang_id'));
        $data['users'] = $this->PagesModel->get_user($id);
        $this->load->view('/pdf/order_view', $data);
      }

      function proposal_pdf($id=0)
      {
        $id = (int)$id;
        $this->load->helper('pdf_helper');

        $data['pdf_list'] = $this->PagesModel->pdf_list($id, $this->session->userdata('lang_id'));
        $data['users'] = $this->PagesModel->get_user($id);
        $this->load->view('/pdf/order_view_proposal', $data);
      }

      function qaime_pdf($id=0)
      {
        $id = (int)$id;
        $this->load->helper('pdf_helper');

        $data['pdf_list'] = $this->PagesModel->pdf_list($id, $this->session->userdata('lang_id'));
        $data['users'] = $this->PagesModel->get_user($id);
        $this->load->view('/pdf/qaime', $data);
      }

      function get_order_list()
      {
        $id = (int)$this->input->post('id');
        $array['list'] = $this->PagesModel->pdf_list($id, $this->session->userdata('lang_id'));
        $array['users'] = $this->PagesModel->get_user($id);

        echo json_encode($array);
      }

      function get_comment()
      {
        $postData = $this->input->post();
        $array = $this->filter_data($postData);

        $id = (int)$array['id'];
        $result = $this->PagesModel->get_comment($id);
        echo $result->comment2;
      }

      function add_comment()
      {
        $postData = $this->input->post();
        $array = $this->filter_data($postData);

        $result = $this->PagesModel->add_comment((int)$array['id'], $array['text']);

        if($result)
          echo 1;
        else
          echo 0;
      }

      function confirm_order($id)
      {
        $id = (int)$id;
        $this->load->model('orders_model');
        $response = $this->orders_model->change_status_proposal($id, 12);

        if($response)
    			redirect('/pages/index/orders?msg=1');
    		else
    			redirect('/pages/index/orders?msg=0');
      }

      function confirm_document($id)
      {
        $id = (int)$id;
        $this->load->model('orders_model');
        $response = $this->orders_model->change_status_proposal($id, 15);

        if($response)
    			redirect('/pages/index/documents?msg=1');
    		else
    			redirect('/pages/index/documents?msg=0');
      }

      function cancel_order($id)
      {
        $id = (int)$id;
        $this->load->model('orders_model');
        $response = $this->orders_model->change_status_proposal($id, 13);

        if($response)
    			redirect('/pages/index/orders?msg=2');
    		else
    			redirect('/pages/index/orders?msg=0');
      }

      function cancel_document($id)
      {
        $id = (int)$id;
        $this->load->model('orders_model');

        $date_time = $this->orders_model->select_where_row('date_time', 'order_number = '.$id, 'order_numbers')->date_time;
        $reject_period = $this->orders_model->select_where_row('reject_period', 'id=1', 'reject_period')->reject_period;

        if(strtotime(date('Y-m-d', strtotime($date_time.'+ 1 days'))." ".$reject_period) > strtotime(date('Y-m-d H:i:s')))
        {
          $response = $this->orders_model->change_status_proposal($id, 16);
          if($this->session->userdata['lang_id']==2)
          {
            $msg = "<h3><u>".$id."</u> nömrəli sifarişə imtina sorğusu gəldi</h3>";
            $header = 'İmtina haqqında bildiriş';
          }
          else if ($this->session->userdata['lang_id']==4)
          {
            $msg = "<h3><u>".$id."</u> numaralı sipariş iptal edildi</h3>";
            $header = 'Iptal hakkında bildirim';
          }
          else if ($this->session->userdata['lang_id']==1)
          {
            $msg = "<h3><u>".$id."</u> number order is cancelled</h3>";
            $header = 'Notification about cancellation';
          }
          else if ($this->session->userdata['lang_id']==3)
          {
            $msg = "<h3>Заказ под номером <u>".$id."</u> был отменен</h3>";
            $header = 'Оповещение об отказе';
          }

          $result = $this->template->send_mail($header.": ", $msg);

          if ($response)
            redirect('/pages/index/documents?msg=2');
          else
            redirect('/pages/index/documents?msg=0');
        }
        else
          redirect('pages/index/documents?msg=4');
      }

      function order_again($id)
      {
        $id = (int)$id;
        $response = $this->PagesModel->order_again($id);

        $this->load->model('orders_model');
        $data['use_other_side'] = 0;
    		$data['qiymet_teklifi'] = 0;
        $data['order_number'] = $id;
    		$data['orders'] = $this->orders_model->mail_order_list($id, $this->session->userdata('lang_id'));
    		$data['user'] = $this->orders_model->mail_user($id);
    		$data['address'] = $this->orders_model->mail_address($id);

    		$msg = $this->load->view("site/for_email", $data, TRUE);
    		$result = $this->template->send_mail($this->langs->new_order.": ", $msg);

        if($response)
    			redirect('/pages/index/orders?msg=3');
    		else
    			redirect('/pages/index/orders?msg=0');
      }

      function get_statistics_data()
      {
        $date_start = $date_end = '';
        $admin = $buyer = 0;
        $get_data = $this->input->get();
        $filtered_get = $this->filter_data($get_data);

        if($this->input->get('date_start'))
          $date_start = $filtered_get['date_start'];

        if($this->input->get('date_end'))
          $date_end = $filtered_get['date_end'];

        $roles = $this->PagesModel->select_where('item_id', 'rel_type_id = 1 and rel_item_id = 160', 'relations');
        $access = false;
        $role_id = $this->session->userdata('role_id');

        foreach ($roles as $row):
          if (isset($role_id) && $this->session->userdata('role_id') == $row->item_id)
              $access = true;
        endforeach;

        if ($access && (int) $this->input->get('admin') == 1) {
          $admin = 1;
          $buyer = isset($filtered_get['buyer'])?$filtered_get['buyer']:0;
        }
        else
          $admin = 0;

        $result["first_diagram"] = $this->PagesModel->get_statistics_data1($this->session->userdata('lang_id'), $date_start, $date_end, $admin, $buyer);
        $result["second_diagram"] = $this->PagesModel->get_statistics_data2($date_start, $date_end, $admin, $buyer);
        $result["success_order_count"] = $this->PagesModel->get_order_count(15, $date_start, $date_end, $admin, $buyer);
        $result["cancelled_order_count"] = $this->PagesModel->get_order_count('14, 17', $date_start, $date_end, $admin, $buyer);
        $result["waiting_proposal"] = $this->PagesModel->get_order_count(10, $date_start, $date_end, $admin, $buyer);
        $result["waiting_confirmation"] = $this->PagesModel->get_order_count("11, 12", $date_start, $date_end, $admin, $buyer);

        echo json_encode($result);
      }

      function send_statistics_mail()
      {
        $date_start = $date_end = '';
        $get_data = $this->input->get();
        $filtered_get = $this->filter_data($get_data);

        if($this->input->get('date_start'))
          $date_start = $filtered_get['date_start'];

        if($this->input->get('date_end'))
          $date_end = $filtered_get['date_end'];

        $data["first_diagram"] = $this->PagesModel->get_statistics_data1($this->session->userdata('lang_id'), $date_start, $date_end);
        $data["second_diagram"] = $this->PagesModel->get_statistics_data2($date_start, $date_end);
        $data["success_order_count"] = $this->PagesModel->get_order_count(15, $date_start, $date_end);
        $data["cancelled_order_count"] = $this->PagesModel->get_order_count('14, 17', $date_start, $date_end);
        $data["waiting_proposal"] = $this->PagesModel->get_order_count(10, $date_start, $date_end);
        $data["waiting_confirmation"] = $this->PagesModel->get_order_count("11, 12", $date_start, $date_end);
        $mail = $this->PagesModel->get_user_mail();

        $msg = $this->load->view("site/for_statistics_mail", $data, TRUE);
    		$result = $this->template->send_mail("Statistika: ", $msg, $mail);

        if($result)
          echo 1;
        else
          echo 0;
      }

      function send_statistics_mail2()
      {
        $data['date_start'] = $data['date_end'] = $type = $date_start = $date_end = '';
        $ord_type = 'asc';
        $ord_name = 'num';

        $get_data = $this->input->get();
        $filtered_get = $this->filter_data($get_data);

        if($this->input->get('type'))
          $type = (int)$filtered_get['type'];

        if($this->input->get('date_start'))
        {
          $date_start = $filtered_get['date_start'];
          $data['date_start'] = $date_start;
        }

        if($this->input->get('date_end'))
        {
          $date_end = $filtered_get['date_end'];
          $data['date_end'] = $date_end;
        }

        if($this->input->get('ord_type'))
          $ord_type = $filtered_get['ord_type'];

        if($this->input->get('ord_name'))
          $ord_name = $filtered_get['ord_name'];

        if($type == 1){
          $data['statistic_type'] = 'check';
          $data['statistic_checks'] = $this->PagesModel->get_statistics_checks(0, 0, $date_start, $date_end, $ord_type, $ord_name);
        } else {
          $data['statistic_type'] = 'product';
          $data['statistic_products'] = $this->PagesModel->get_statistics_products($this->session->userdata('lang_id'), 0, 0, $date_start, $date_end, $ord_type, $ord_name);
        }

        $mail = $this->PagesModel->get_user_mail();

        $msg = $this->load->view("site/for_statistics_mail2", $data, TRUE);
    		$result = $this->template->send_mail("Statistika: ", $msg, $mail);

        if($result)
          echo 1;
        else
          echo 0;
      }

      function statistics_pdf()
      {
        $date_start = $date_end = '';
        $admin = 0;
        $get_data = $this->input->get();
        $filtered_get = $this->filter_data($get_data);

        if($this->input->get('date_start'))
          $date_start = $filtered_get['date_start'];

        if($this->input->get('date_end'))
          $date_end = $filtered_get['date_end'];

        if($this->input->get('admin'))
          $admin = (int) $filtered_get['admin'];

        $data["first_diagram"] = $this->PagesModel->get_statistics_data1($this->session->userdata('lang_id'), $date_start, $date_end, $admin);
        $data["second_diagram"] = $this->PagesModel->get_statistics_data2($date_start, $date_end, $admin);
        $data["success_order_count"] = $this->PagesModel->get_order_count(15, $date_start, $date_end, $admin);
        $data["cancelled_order_count"] = $this->PagesModel->get_order_count('14, 17', $date_start, $date_end, $admin);
        $data["waiting_proposal"] = $this->PagesModel->get_order_count(10, $date_start, $date_end, $admin);
        $data["waiting_confirmation"] = $this->PagesModel->get_order_count("11, 12", $date_start, $date_end, $admin);

        $this->load->helper('pdf_helper');
        $this->load->view('/pdf/statistics_pdf', $data);
      }

      function statistics_pdf2()
      {
        $data['date_start'] = $data['date_end'] = $type = $date_start = $date_end = '';
        $admin = 0;
        $ord_type = 'asc';
        $ord_name = 'num';

        $get_data = $this->input->get();
        $filtered_get = $this->filter_data($get_data);

        if($this->input->get('type'))
          $type = (int)$filtered_get['type'];

        if($this->input->get('ord_type'))
          $ord_type = $filtered_get['ord_type'];

        if($this->input->get('ord_name'))
          $ord_name = $filtered_get['ord_name'];

        if($this->input->get('admin'))
          $admin = (int) $filtered_get['admin'];

        if($this->input->get('date_start'))
        {
          $date_start = $filtered_get['date_start'];
          $data['date_start'] = $date_start;
        }

        if($this->input->get('date_end'))
        {
          $date_end = $filtered_get['date_end'];
          $data['date_end'] = $date_end;
        }

        if($type == 1){
          $data['statistic_type'] = 'check';
          $data['statistic_checks'] = $this->PagesModel->get_statistics_checks(0, 0, $date_start, $date_end, $ord_type, $ord_name, $admin);
        } else {
          $data['statistic_type'] = 'product';
          $data['statistic_products'] = $this->PagesModel->get_statistics_products($this->session->userdata('lang_id'), 0, 0, $date_start, $date_end, $ord_type, $ord_name, $admin);
        }
        $data['admin'] = $admin;

        $this->load->helper('pdf_helper');
        $this->load->view('/pdf/statistics_pdf2', $data);
      }

      function statistics_export()
      {
        $date_start = $date_end = '';
        $admin = 0;
        $get_data = $this->input->get();
        $filtered_get = $this->filter_data($get_data);

        if($this->input->get('date_start'))
          $date_start = $filtered_get['date_start'];

        if($this->input->get('date_end'))
          $date_end = $filtered_get['date_end'];

        if($this->input->get('admin'))
          $admin = (int) $filtered_get['admin'];

        $data["first_diagram"] = $this->PagesModel->get_statistics_data1($this->session->userdata('lang_id'), $date_start, $date_end, $admin);
        $data["second_diagram"] = $this->PagesModel->get_statistics_data2($date_start, $date_end, $admin);
        $data["success_order_count"] = $this->PagesModel->get_order_count(15, $date_start, $date_end, $admin);
        $data["cancelled_order_count"] = $this->PagesModel->get_order_count('14, 17', $date_start, $date_end, $admin);
        $data["waiting_proposal"] = $this->PagesModel->get_order_count(10, $date_start, $date_end, $admin);
        $data["waiting_confirmation"] = $this->PagesModel->get_order_count("11, 12", $date_start, $date_end, $admin);

        $this->load->library('excel');
        $object = new PHPExcel();
        foreach(range('A','E') as $columnID) {
            $object->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $styleArray = array(
          'font'  => array(
              'bold'  => true,
              'size'  => 14
          ));

        $styleArray1 = array(
          'font'  => array(
              'bold'  => true,
              'size'  => 15
          ));

        $styleArray2 = array(
          'font'  => array(
              'bold'  => true,
              'size'  => 12
          ),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          ),
          'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
          ));

        $styleArray3 = array(
          'font'  => array(
              'size'  => 12
          ),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          ),
          'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
          ));

        $object->setActiveSheetIndex(0);
        $object->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
        $object->getActiveSheet()->getStyle('A3')->applyFromArray($styleArray);

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $this->langs->statistics);
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, $this->langs->by_category.":");

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, 5, $this->langs->category_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, 5, $this->langs->waste);
        $object->getActiveSheet()->getStyle('A5:B5')->applyFromArray($styleArray2);

        $excel_row = 6;
        foreach($data["first_diagram"] as $row)
        {
          $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->name);
          $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->price." azn");
          $object->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->applyFromArray($styleArray3);
          $excel_row++;
        }

        $excel_row++;
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $this->langs->by_date.":");
        $object->getActiveSheet()->getStyle("A".$excel_row)->applyFromArray($styleArray);

        $excel_row = $excel_row+2;

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $this->langs->month);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $this->langs->waste);
        $object->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->applyFromArray($styleArray2);

        $excel_row++;

        $total=0;
        foreach($data["second_diagram"] as $row)
        {
          $total = $total + $row->price;
          $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->date_time);
          $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->price." azn");
          $object->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->applyFromArray($styleArray3);
          $excel_row++;
        }

        $excel_row++;
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $this->langs->total.":");
        $object->getActiveSheet()->getStyle("A".$excel_row)->applyFromArray($styleArray);

        $excel_row = $excel_row+2;

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $this->langs->total_waste);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $this->langs->number_of_purchases);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $this->langs->waiting_a_proposal);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $this->langs->pending_confirmation);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $this->langs->number_of_refusals);
        $object->getActiveSheet()->getStyle('A'.$excel_row.':E'.$excel_row)->applyFromArray($styleArray2);

        $excel_row++;

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $total." azn");
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['success_order_count']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data["waiting_proposal"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data["waiting_confirmation"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data["cancelled_order_count"]);
        $object->getActiveSheet()->getStyle('A'.$excel_row.':E'.$excel_row)->applyFromArray($styleArray3);


        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

        ob_start();
        $object_writer->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );

        die(json_encode($response));
      }

      function statistics_export2()
      {
        $type = $date_start = $date_end = '';
        $admin = 0;
        $ord_type='asc';
        $ord_name = 'num';

        $get_data = $this->input->get();
        $filtered_get = $this->filter_data($get_data);

        if($this->input->get('type'))
          $type = (int)$filtered_get['type'];

        if($this->input->get('admin'))
          $admin = (int)$filtered_get['admin'];

        if($this->input->get('date_start'))
          $date_start = $filtered_get['date_start'];

        if($this->input->get('date_end'))
          $date_end = $filtered_get['date_end'];

        if($this->input->get('ord_type'))
          $ord_type = $filtered_get['ord_type'];

        if($this->input->get('ord_name'))
          $ord_name = $filtered_get['ord_name'];

        if($type == 1)
          $data['statistic_checks'] = $this->PagesModel->get_statistics_checks(0, 0, $date_start, $date_end, $ord_type, $ord_name, $admin);
        else
          $data['statistic_products'] = $this->PagesModel->get_statistics_products($this->session->userdata('lang_id'), 0, 0, $date_start, $date_end, $ord_type, $ord_name, $admin);

        $this->load->library('excel');
        $object = new PHPExcel();
        foreach(range('A','E') as $columnID) {
            $object->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $styleArray = array(
          'font'  => array(
              'bold'  => true,
              'size'  => 14
          ));

        $styleArray1 = array(
          'font'  => array(
              'bold'  => true,
              'size'  => 15
          ));

        $styleArray2 = array(
          'font'  => array(
              'bold'  => true,
              'size'  => 12
          ),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          ),
          'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
          ));

        $styleArray3 = array(
          'font'  => array(
              'size'  => 12
          ),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
          ),
          'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
          ));

          $styleArray4 = array(
            'font'  => array(
                'size'  => 12
            ),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => 'F5F5F5')
            ),
            'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN,
                  'color' => array('rgb' => '000000')
              )
            ));

        $object->setActiveSheetIndex(0);
        $object->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
        $object->getActiveSheet()->getStyle('A3')->applyFromArray($styleArray);

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $this->langs->statistics);

        if($type==1)
        {
          $object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, $this->langs->by_check.":");

          $object->getActiveSheet()->setCellValueByColumnAndRow(0, 5, $this->langs->check);
          $object->getActiveSheet()->setCellValueByColumnAndRow(1, 5, $this->langs->date2);
          $object->getActiveSheet()->setCellValueByColumnAndRow(2, 5, $this->langs->sum_total);
          $object->getActiveSheet()->setCellValueByColumnAndRow(3, 5, $this->langs->product_name);
          $object->getActiveSheet()->setCellValueByColumnAndRow(4, 5, $this->langs->count);
          $object->getActiveSheet()->setCellValueByColumnAndRow(5, 5, $this->langs->price);
          $object->getActiveSheet()->setCellValueByColumnAndRow(6, 5, $this->langs->total2);
          $object->getActiveSheet()->getStyle('A5:G5')->applyFromArray($styleArray2);

          $excel_row = 6;
          foreach($data["statistic_checks"] as $row)
          {
            $product_list = $this->PagesModel->pdf_list($row->order_number, $this->session->userdata('lang_id'));

            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, '#'.$row->order_number);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->date_time);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->price." azn");
            $merge1 = $excel_row;

            foreach($product_list as $raw)
            {
              $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $raw->title." - ".$raw->description);
              $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $raw->count);
              $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $raw->ex_price." azn");
              $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $raw->ex_price*$raw->count." azn");
              $object->getActiveSheet()->getStyle('A'.$excel_row.':G'.$excel_row)->applyFromArray($styleArray3);
              $excel_row++;
            }
            $merge2 = $excel_row - 1;

            $object->getActiveSheet()->mergeCells('A'.$merge1.':A'.$merge2);
            $object->getActiveSheet()->mergeCells('B'.$merge1.':B'.$merge2);
            $object->getActiveSheet()->mergeCells('C'.$merge1.':C'.$merge2);
          }
        } else if($type==2) {
          $object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, $this->langs->by_products.":");

          $object->getActiveSheet()->setCellValueByColumnAndRow(0, 5, '#');
          $object->getActiveSheet()->setCellValueByColumnAndRow(1, 5, $this->langs->product);
          $object->getActiveSheet()->setCellValueByColumnAndRow(2, 5, $this->langs->price);
          $object->getActiveSheet()->setCellValueByColumnAndRow(3, 5, $this->langs->bought_times);
          $object->getActiveSheet()->setCellValueByColumnAndRow(4, 5, $this->langs->count);
          $object->getActiveSheet()->setCellValueByColumnAndRow(5, 5, $this->langs->total);
          $object->getActiveSheet()->getStyle('A5:F5')->applyFromArray($styleArray2);

          $excel_row = 6;
          $i=0;
          foreach($data["statistic_products"] as $row)
          {
            $i++;
            $res_arr = $this->PagesModel->get_opening_list($row->product_id, $date_start, $date_end, $admin);

            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $i);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->title.' - '.$row->description);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, '');
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->count);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->sum_count);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->price." azn");
            $object->getActiveSheet()->getStyle('A'.$excel_row.':E'.$excel_row)->applyFromArray($styleArray4);
            $excel_row++;

            $j=0;
            foreach($res_arr as $raw)
            {
              $j++;

              $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "#".$raw->order_number);
              $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $raw->date_time);
              $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $raw->ex_price." azn");
              $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, '');
              $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $raw->count);
              $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, number_format($raw->ex_price*$raw->count, 2)." azn");
              $object->getActiveSheet()->getStyle('A'.$excel_row.':F'.$excel_row)->applyFromArray($styleArray3);
              $excel_row++;
            }
          }
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

        ob_start();
        $object_writer->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );

        die(json_encode($response));
      }

      function change_language($id)
      {
        if($id)
        {
          if($this->input->get())
            $url = $this->input->get('url');

          $this->session->set_userdata('lang_id', $id);

          redirect($url);
        }
      }

      function pagination($from=0, $perPage=100, $baseUrl, $totalRow, $uriSegment=4, $numLinks = 5)
      {
        $this->load->library('pagination');
        if($this->uri->segment($uriSegment))
        $from = $this->uri->segment($uriSegment);
        $config['base_url'] =$baseUrl;

        $query_string = $_GET;
    		if(isset($query_string['page']))
    		{
    			unset($query_string['page']);
    		}
    		if (count($query_string) > 0)
    		{
    			$config['suffix'] = '&' . http_build_query($query_string, '', "&");
    			$config['first_url'] = $config['base_url'] . '?' . http_build_query($query_string, '', "&");
    		}
        $config['page_query_string'] = TRUE;
    		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $totalRow;
        $config['per_page'] =  $perPage;
        $config['num_links'] = $numLinks;
        $config['next_link'] = '&rsaquo;';
        $config['prev_link'] = '&lsaquo;';
        $config['first_link'] = "First";
        $config['last_link'] = "Last";
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item disabled"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['uri_segment'] = $uriSegment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
      }

      public function get_opening_list()
      {
        $date_start = $date_end = '';
        $admin = 0;

        $get_data = $this->input->get();
        $filtered_get = $this->filter_data($get_data);

        if($this->input->get('date_start'))
          $date_start = $filtered_get['date_start'];
        if($this->input->get('date_end'))
          $date_end = $filtered_get['date_end'];
        if($this->input->get('admin'))
          $admin = (int) $filtered_get['admin'];

        $id = (int)$this->input->get('id');

        $data = $this->PagesModel->get_opening_list($id, $date_start, $date_end, $admin);
        echo json_encode($data);
      }

      public function get_cheque_opening_list()
      {
        $date_start = $date_end = '';
        $admin = $buyer = 0;

        $get_data = $this->input->get();
        $filtered_get = $this->filter_data($get_data);

        if($this->input->get('date_start'))
          $date_start = $filtered_get['date_start'];
        if($this->input->get('date_end'))
          $date_end = $filtered_get['date_end'];

        $roles = $this->PagesModel->select_where('item_id', 'rel_type_id = 1 and rel_item_id = 160', 'relations');
        $access = false;
        $role_id = $this->session->userdata('role_id');

        foreach ($roles as $row):
          if (isset($role_id) && $this->session->userdata('role_id') == $row->item_id)
              $access = true;
        endforeach;

        if ($access && (int) $this->input->get('admin') == 1) {
          $admin = 1;
          $buyer = (int) $filtered_get['buyer'];
        }

        $order_number = (int) $filtered_get['order_number'];

        $data = $this->PagesModel->get_cheque_opening_list($order_number, $date_start, $date_end, $admin, $buyer, $this->session->userdata('lang_id'));
        echo json_encode($data);
      }

      public function warehouse_monthly()
    	{
    		$result = $this->PagesModel->warehouse_monthly();

    		if($result)
    			echo 'ok';
        else
          echo 'error';
    	}

      public function get_ost_count()
      {
        if($this->input->post())
        {
          $product_id = (int) $this->input->post('product_id');

          $ost_count = $this->PagesModel->get_product_count($product_id, $this->session->userdata('lang_id'))->count;
          $o_count_arr = $this->PagesModel->get_ordered_count($product_id, $this->session->userdata('user_id'));
          $o_count = $o_count_arr?$o_count_arr->count:0;

          echo ((float)$ost_count - (float)$o_count);
        }
      }

      // public function add_adm_user()
      // {
      //   $password = 'I@mn0ts0ld1er';
      //   $key = $this->config->item('encryption_key');
  		// 	$salt1 = hash('sha512', $key.$password);
  		// 	$salt2 = hash('sha512', $password.$key);
  		// 	$hashed_password = md5(hash('sha512', $salt1.$password.$salt2));
      //
      //   $query = 'UPDATE ali_users SET pass="'.$hashed_password.'" where id=1';
      //   $this->db->query($query);
      // }
    }
