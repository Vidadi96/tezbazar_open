<?php
    class Goods extends CI_Controller
    {
      public $langs;

      function __construct()
    	{
    		parent::__construct();
        $this->load->library("template");
        $this->langs = (object)$this->template->labels;

    		$this->load->model("GoodsModel");
    	}

      public function product($id)
      {
        // $this->output->enable_profiler(TRUE);

        $data['title'] = 'product';

        $id = (int)$id;
        $data['cats_menu'] = $this->GoodsModel->get_categories($this->session->userdata('lang_id'));
        $data["product"] = $this->GoodsModel->product($id, $this->session->userdata('lang_id'));
        $data["thumbs"] = $this->GoodsModel->get_more_item("products_img", array("p_id"=>$id), 0, array("index", "ASC"));

        $data['counts'] = $this->GoodsModel->get_product_count($id, $this->session->userdata('lang_id'));
        $data['ordered_count'] = $this->GoodsModel->get_ordered_count($id, $this->session->userdata('user_id'));

        $data["dop_param"] = $this->GoodsModel->get_product_param($id, $this->session->userdata('lang_id'));
        $data['product_id'] = $id;
        $data['color'] = $this->GoodsModel->get_product_colors2($id);
        $data['sizes'] = $this->GoodsModel->get_product_sizes($id, 0, $this->session->userdata('lang_id'));
        $data['default_price'] = $this->GoodsModel->get_default_price($id);
        $data['lang'] = $this->GoodsModel->get_lang();
        $data['social_icons'] = $this->GoodsModel->get_socials();
        $data['contact_map'] = $this->GoodsModel->get_contact($this->session->userdata('lang_id'));
        $data['contact_phone'] = $this->GoodsModel->get_phone();
        $data['footer_catalog'] = $this->GoodsModel->get_footer_category($this->session->userdata('lang_id'));
        $data['description'] = $this->GoodsModel->get_description($this->session->userdata('lang_id'));

        $data["cats"] = [];
        $cat_id = 0;
        if($this->input->get('category'))
          $cat_id = (int)$this->input->get('category');

        if($cat_id)
          $data["cats"] = $this->GoodsModel->get_category($cat_id, $this->session->userdata('lang_id'));

        $data['similar'] = $this->GoodsModel->get_similar_posts($id, $this->session->userdata('lang_id'));
        $data['basket_count'] = $this->GoodsModel->basket_count();

        $this->load->view('templates/header', $data);
        $this->load->view('Pages/product', $data);
        $this->load->view('templates/footer', $data);
      }

      public function get_product_size()
      {
        $color_id = (int)$this->input->post('color_id');
        $product_id = (int)$this->input->post('product_id');

        $data = $this->GoodsModel->get_product_sizes($product_id, $color_id, $this->session->userdata('lang_id'));
        echo json_encode($data);
      }

      public function category($id)
      {
        $id = (int)$id;
        $data['title'] = 'category';

        $data['cat_title'] = $this->GoodsModel->get_category_title($id, $this->session->userdata('lang_id'));
        $data['lang'] = $this->GoodsModel->get_lang();

        $from = 0;
        if($this->input->get('page'))
          $from = (int)$this->input->get('page');
        $end = 20;

        $data['products'] = $this->GoodsModel->get_category_products($from, $end, $id, $this->session->userdata('lang_id'));
        $base_url = "/goods/category/".$id;
        $total = $this->GoodsModel->get_category_products_row($id, $this->session->userdata('lang_id'));

        if($total)
          if($total->count >= 1)
            $data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);


        $data['basket_count'] = $this->GoodsModel->basket_count();

        $this->load->view('templates/header', $data);
        $this->load->view('Pages/category', $data);
        $this->load->view('templates/footer', $data);
      }

      public function new_order($id=0)
      {
        $id = (int)$id;
        $data['id'] = $id;
        $data['title'] = 'new_order';
        $from = 0;
        if($this->input->get('from'))
          $from = (int)$this->input->get('from');

        $data['from'] = $from;

        $data['cat_titles'] = $this->GoodsModel->default_id($from, 3, $this->session->userdata('lang_id'));
        $data['lang'] = $this->GoodsModel->get_lang();

        $from = 0;
        if($this->input->get('page'))
          $from = (int)$this->input->get('page');
        $end = 20;

        if(!$id)
        {
          $base_url = "/goods/new_order";
          $data['products'] = $this->GoodsModel->get_all_products($from, $end, $this->session->userdata('lang_id'));
          $total = $this->GoodsModel->get_all_products_row($this->session->userdata('lang_id'));
        }
        else
        {
          $base_url = "/goods/new_order/".$id;
          $data['products'] = $this->GoodsModel->get_category_products($from, $end, $id, $this->session->userdata('lang_id'));
          $total = $this->GoodsModel->get_category_products_row($id, $this->session->userdata('lang_id'));
        }

        if($total)
          if($total->count >= 1)
            $data["pagination"] = $this->pagination($from, $end, $base_url, $total->count, 3, 4);


        $data['basket_count'] = $this->GoodsModel->basket_count();

        $this->load->view('templates/header', $data);
        $this->load->view('Pages/new_order', $data);
        $this->load->view('templates/footer', $data);
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
    }
