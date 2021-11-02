<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Office extends CI_Controller {
  public $langs;
	function __construct()
	{
		parent::__construct();
    $this->load->library("template");
    $this->langs = (object)$this->template->labels;
		$this->load->model("office_model");
		$this->load->model("blog_model");
    if($this->session->userdata('name')=="admin")
    {
      //$this->output->enable_profiler(TRUE);
    }
    //echo Transliterator::create("tr-Upper")->transliterate('əğöüşç.ç');
    //echo Transliterator::create("tr-Lower")->transliterate('KHJKHDDOPWQÖĞÖŞŞÇ');
	}
  public function carier()
  {
    $data=[];
    $data["list"] = $this->office_model->get_vacancies();
    $this->template->home("site/carier", $data);
  }
  public function vacancy($id)
  {
    $data=[];
    $id = (int)$id;
		$data["blog"] = $this->office_model->get_vacancy($id);
    $this->template->home("site/vacancy", $data);
  }
  function term_conditions()
  {
    echo $this->blog_model->get_blog_item(15)->content;
  }
  function add_to_basket()
  {

  }
  public function quickview()
  {


    $id = (int)json_decode($this->input->get("json"))->productID;
    $product["product"] = $this->office_model->product($id);
    $product["thumbs"] = $this->universal_model->get_more_item("products_img", array("p_id"=>$id), 0, array("index", "ASC"));
    $product["colors"] = $this->office_model->get_product_colors($id);
    $product["sizes"] = $this->office_model->get_product_sizes($id);
    $product["warehouse_in"] = $this->office_model->get_product_warehouse_in($id);
    $data["product_details"] = $this->load->view("site/product_details_item", $product);
    /*echo '


    <input id="add-to-cart-details" type="hidden"
           data-productid="10231"
           data-url="/addproducttocart/details/10231/1" />

    <div class="product-essential">
    <form action="/%D0%91%D0%A0%D0%9E%D0%88%D0%90%D0%A7-%D0%97%D0%90-%D0%9F%D0%90%D0%A0%D0%98-%D0%9D%D0%A6-520-%D0%9E%D0%9B%D0%98%D0%9C%D0%9F%D0%98%D0%88%D0%90-947730520" id="product-details-form" method="post">        <div class="popup-header">
                <h1 class="product-name">
                    Бројач За Пари Нц 520 Олимпија-947730520
                </h1>
            </div>
            <div class="product-content">
                <div class="gallery">
                    <!--product pictures-->


        <script>
        $(document).ready(function() {
                CloudZoom.quickStart();
            });
        </script>
        <div class="picture">
            <a href="https://www.officeplus.mk/content/images/thumbs/0026548_broa-za-pari-nc-520-olimpia-947730520.jpeg">
                <img class="cloudzoom" src="https://www.officeplus.mk/content/images/thumbs/0026548_broa-za-pari-nc-520-olimpia-947730520_250.jpeg" data-cloudzoom="appendSelector: &#39;.quickViewWindow .gallery .picture&#39;, zoomPosition: &#39;inside&#39;, zoomOffsetX: 0, easing: 3, zoomFlyOut: false, disableZoom: &#39;auto&#39;"
                     alt="Слика на Бројач За Пари Нц 520 Олимпија-947730520" id="quick-view-zoom" />
            </a>
        </div>

    <input type="hidden" class="quickViewAdjustPictureOnProductAttributeValueChange"
           data-productId="10231"
           data-isCloudZoomAvailable="true" />

                    <div class="links-panel">
                        <a href="/%D0%91%D0%A0%D0%9E%D0%88%D0%90%D0%A7-%D0%97%D0%90-%D0%9F%D0%90%D0%A0%D0%98-%D0%9D%D0%A6-520-%D0%9E%D0%9B%D0%98%D0%9C%D0%9F%D0%98%D0%88%D0%90-947730520" class="link-to-product-page">Одете на страната на производот</a>
                    </div>
                </div>
                <div class="overview">
                    <div id="accordion">
                        <h3>Детали</h3>
                        <div class="product-details">
                            <div class="left">
                                <!--product SKU, manufacturer part number, stock info-->

    <div class="additional-details">

            <div class="sku" >
                <span class="label">SKU:</span>
                <span class="value" itemprop="sku" id="sku-10231">132290</span>
            </div>
                </div>

                                <!--delivery-->


                                <!--availability-->
                                    <div class="availability">
                <div class="stock">
                    <span class="label">Достапност:</span>
                    <span class="value" id="stock-availability-value-10231">има на залиха</span>
                </div>

        </div>





        <div class="warehouses_availability">

            <ul class="warehouses_list">
                <li id="showOrHideWA">
                    Производот е достапен во:
                    <div class="plus-button close"></div>
                </li>
                    <li class="warehouse_name">
                        Скопје - City Mall
                    </li>
                    <li class="warehouse_name">
                        Скопје - Главен магацин
                    </li>
                    <li class="warehouse_name">
                        Скопје - ГТЦ
                    </li>
                    <li class="warehouse_name">
                        Скопје - Рузвелтова
                    </li>
            </ul>
        </div>

    <script>
        $(document).ready(function () {

            var len = $("ul.warehouses_list li").length;

            var win_size = $(document).width();

            if (win_size > 951) {
                if (len <= 6) {
                    $("ul.warehouses_list").css("width", "initial");
                    $("ul.warehouses_list li").css({ "width": "initial", "float": "initial" });
                }
                else if (len <= 12) {
                    $("ul.warehouses_list").css("width", "100%");
                    $("ul.warehouses_list li").css({ "width": "50%", "float": "left" });
                }
            }

            $(window).resize(function () {
                var win_size = $(document).width();
                if (win_size > 1263) {
                    if (len <= 6) {
                        $("ul.warehouses_list").css("width", "initial");
                        $("ul.warehouses_list li").css({ "width": "initial", "float": "initial" });
                    }
                    else if (len <= 12) {
                        $("ul.warehouses_list").css("width", "100%");
                        $("ul.warehouses_list li").css({ "width": "50%", "float": "left" });
                    }
                    else if (len <= 18) {
                        $("ul.warehouses_list").css("width", "100%");
                        $("ul.warehouses_list li").css({ "width": "33.33%", "float": "left" });
                    }
                }
                else if (win_size > 983) {
                    if (len <= 6) {
                        $("ul.warehouses_list").css("width", "initial");
                        $("ul.warehouses_list li").css({ "width": "initial", "float": "initial" });
                    }
                    else if (len <= 12) {
                        $("ul.warehouses_list").css("width", "100%");
                        $("ul.warehouses_list li").css({ "width": "50%", "float": "left" });
                    }
                    else if (len <= 18) {
                        $("ul.warehouses_list").css("width", "100%");
                        $("ul.warehouses_list li").css({ "width": "50%", "float": "left" });
                    }

                }
                else {
                    $("ul.warehouses_list").css("width", "100%");
                    $("ul.warehouses_list li").css({ "width": "100%", "float": "left" });
                }
            });

            $("#showOrHideWA").click(function () {

                var x = $("ul.warehouses_list li.warehouse_name").css("display");

                if (x == "none") {
                    $("ul.warehouses_list li.warehouse_name").css("display", "list-item");
                    $("ul.warehouses_list").css("background-color", "#f6f6f6");
                }
                else {
                    $("ul.warehouses_list li.warehouse_name").css("display", "none");
                    $("ul.warehouses_list").css("background-color", "initial");
                }

            });

            $("#showOrHideWA .plus-button").click(function () {

                var x = $("ul.warehouses_list li.warehouse_name").css("display");

                if (x == "none") {
                    $("ul.warehouses_list li.warehouse_name").css("display", "list-item");
                    $("ul.warehouses_list").css("background-color", "#f6f6f6");
                }
                else {
                    $("ul.warehouses_list li.warehouse_name").css("display", "none");
                    $("ul.warehouses_list").css("background-color", "initial");
                }

            });

        });
    </script>

                                <!--product manufacturers-->
                                    <div class="manufacturers">
                <span class="label">Производител:</span>
            <span class="value">
                    <a href="/olympia">Olympia</a>
            </span>
        </div>


                                <!--sample download-->

                            </div>
                            <div class="right">

        <div class="compare-products">
            <input type="button" value="Додади во споредувачката листа" class="button-2 add-to-compare-list-button" onclick="AjaxCart.addproducttocomparelist(\'/compareproducts/add/10231\');return false;" />
        </div>
                            </div>







                            <!--product tier prices-->



                            <div class="purchase-area">

    	<div class="prices" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    	        <div class="					product-price
    ">


    				<span   itemprop="price" content="19995.00" class="price-value-10231"  >
    	                19.995,00 ден
    	            </span>
    	        </div>
    	            <meta itemprop="priceCurrency" content="MKD" />
    	</div>


        <div class="add-to-cart">
                        <div class="add-to-cart-panel">
                    <label class="qty-label" for="addtocart_10231_EnteredQuantity">Кол.:</label>
    <input class="qty-input" data-val="true" data-val-number="The field Кол. must be a number." id="addtocart_10231_EnteredQuantity" name="addtocart_10231.EnteredQuantity" type="text" value="1" />                    <script type="text/javascript">
                            $(document).ready(function () {
                                $("#addtocart_10231_EnteredQuantity").keydown(function (event) {
                                    if (event.keyCode == 13) {
                                        $("#add-to-cart-button-10231").click();
                                        return false;
                                    }
                                });
                            });
                        </script>
                                        <input type="button" id="add-to-cart-button-10231" class="button-1 add-to-cart-button" value="+ Додади во кошничка" data-productid="10231" onclick="AjaxCart.addproducttocart_details(\'/addproducttocart/details/10231/1\', \'#product-details-form\');return false;" />

                </div>

        </div>

                            </div>
                        </div>




                    </div>
                </div>
            </div>
    </form></div>
    ';*/
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
  public function search()
  {
    $get = $this->filter_data($this->input->get());
    $cat_id = 7;
    $data = [];
    $end = 16;

    $base_url = "/office/search/";
    $from=0;
    if($this->input->get("page"))
        $from = (int)$this->input->get("page");
    $data["cat"] = $this->office_model->get_category($cat_id);
    $result = $this->office_model->get_products_by_search($get["q"], 4, " ", $from, $end, 1, 0);

    $data["list"] = $result["list"];

    if($result["total_row"]->total_row)
				$data["pagination"] = $this->pagination_get($from, $end, $base_url, $result["total_row"]->total_row, 3, 5);

    $data["search"] = $get["q"];
    $this->template->home("site/search", $data);
  }
/*

SELECT p.* FROM ( SELECT im_ex.sold, im_ex.ex_price, im_ex.mn_id, im_ex.color_id, d.percent as discount_left, bb.name as brand_name, c.name as cat_name, p_id.*, p.description, p.content, p.title, p_img.img, u.full_name FROM `ali_products_id` as p_id LEFT JOIN (SELECT product_id, sum(`count`) as sold, ex_price, mn_id, color_id FROM `ali_products_im_ex` where `im_ex` is false GROUP by `product_id`) as im_ex on im_ex.product_id = p_id.p_id LEFT JOIN ali_discount_id as d on d.discount_id = p_id.discount_id LEFT JOIN (SELECT * FROM ali_products as p where p.lang_id=2 UNION SELECT * FROM ali_products as p2 where p2.lang_id=1 AND p_id not in(SELECT p_id FROM ali_products as p where p.lang_id=2)) as p on p.p_id=p_id.p_id LEFT JOIN (SELECT tbl.* FROM ali_products_img tbl LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ali_products_img GROUP BY p_id ) tbl1 ON tbl1.p_id = tbl.p_id WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=p_id.p_id LEFT JOIN (SELECT r.item_id as p_id, r.rel_item_id as cat_id FROM ali_relations as r WHERE r.rel_type_id=2 ) as rr on rr.p_id=p_id.p_id LEFT JOIN ali_cats_id as c_id on c_id.cat_id=rr.cat_id LEFT JOIN (select * from ali_cats as c where c.lang_id=2 Union select * from ali_cats as c1 where c1.lang_id=1 AND cat_id not in(select cat_id from ali_cats as c where c.lang_id=2)) as c on c.cat_id = c_id.cat_id LEFT JOIN ali_users as u on u.id=p_id.user_id LEFT JOIN ali_brands_id as b_id on b_id.brand_id=p_id.brand_id LEFT JOIN (select * from ali_brands as b where b.lang_id=2) as bb on bb.brand_id = b_id.brand_id ) as p WHERE p.deleted=0 AND p.active=1 AND p.parent_id=0 and p.p_id in(SELECT item_id as p_id FROM ali_relations where rel_type_id=2 and rel_item_id in( WITH RECURSIVE product_cats AS(SELECT cc.cat_id FROM (SELECT ci.*, c.name from ali_cats_id as ci LEFT JOIN ali_cats as c on c.cat_id=ci.cat_id where c.lang_id=2) as cc WHERE cc.active=1 and cc.deleted=0 UNION ALL SELECT c.cat_id FROM product_cats AS sc JOIN (SELECT ci.*, c.name from ali_cats_id as ci LEFT JOIN ali_cats as c on c.cat_id=ci.cat_id where c.lang_id=2) AS c ON sc.cat_id = c.parent_id WHERE c.active=1 and c.deleted=0) SELECT * FROM product_cats) GROUP by p_id) GROUP by p_id limit 0, 12
*/



  public function index()
  {
    $data = array();
    $data["actions"] = $this->office_model->get_products_by_category_id(0, 2, " ", 0, 10)["list"];
    //print_r($data["actions"]);
    $data["best_sellers"] = $this->office_model->get_products_by_category_id(0, " ORDER by sold DESC ", " ", 0, 12)["list"];
    $data["categories_for_home"] = $this->office_model->categories_for_home();
    $data["slides"] = $this->office_model->get_slides();
    $this->load->model("blog_model");
    $data["blog_posts"] = $this->blog_model->get_news(0, 5, 1)["list"];
    //print_r($data["actions"]);
    $this->template->home("site/default_content", $data);
  }
  public function category($cat_id)
  {
    $cat_id = (int)$cat_id;
    $data = [];
    $end = 16;

    $base_url = "/office/category/".$cat_id."/";
    $from=0;
    if($this->input->get("page"))
        $from = (int)$this->input->get("page");
    $data["cat"] = $this->office_model->get_category($cat_id);
    $result = $this->office_model->get_products_by_category_id($cat_id, 4, " ", $from, $end, 1, 1);




    $data["brands"] = $this->office_model->get_products_by_category_id($cat_id, 0, " ", 0, 0, 0, 0, ' GROUP by brand_id ');
    $data["list"] = $result["list"];
    $data["min"] = $result["min"]->min;
    $data["max"] = $result["max"]->max;
    $cat_details = [];
    $cat_details["last_bread"]=$data["cat"]->cat_name;
    $cat_details["cats"]=$this->office_model->breadcrumb_category($cat_id);

    //print_r($cats);
    $data["breadcrumb"] = "";
    if($cat_details["cats"])
    $data["breadcrumb"]= $this->load->view("site/breadcrumb", $cat_details, TRUE);


    if($result["total_row"]->total_row)
				$data["pagination"] = $this->pagination_get($from, $end, $base_url, $result["total_row"]->total_row, 3, 5);


    $this->template->home("site/category", $data);
  }
  public function brands()
  {
    $data = [];
    $data["brands"]=$this->office_model->get_all_brands();
    $this->template->home("site/brands", $data);
  }
  public function brand($id)
  {
    $id = (int) $id;
    $data = [];

  //  $data["brand"]=$this->office_model->get_brand();
    $this->template->home("site/brand", $data);
  }
  
  public function product($id)
  {
    $id = (int)$id;
    $product["product"] = $this->office_model->product($id);
    $product["thumbs"] = $this->universal_model->get_more_item("products_img", array("p_id"=>$id), 0, array("index", "ASC"));
    //echo $data["product"]->cat_id;
    $data["cats"] = [];
    if($product["product"]->cat_id)
    $data["cats"] = $this->office_model->breadcrumb_category($product["product"]->cat_id);
    $data["breadcrumb"] = "";
    if($data["cats"])
    $data["breadcrumb"]= $this->load->view("site/breadcrumb", array("last_bread"=>$product["product"]->title), TRUE);


    $product["colors"] = $this->office_model->get_product_colors($id);
    $product["sizes"] = $this->office_model->get_product_sizes($id);
    $product["warehouse_in"] = $this->office_model->get_product_warehouse_in($id);
    $data["product_details"] = $this->load->view("site/product_details_item", $product, TRUE);
    $data["similar_products"] = $this->office_model->get_products_by_category_id(end($data["cats"])->cat_id, 4, " and p_id != ".$id, 0, 5)["list"];
    //print_r($data["colors"]);
    $data["next_prev"] = $this->office_model->next_prev($id, $product["product"]->cat_id);
    $this->template->home("site/product", $data);
  }

  public function get_im_ex_price()
  {
    if($this->input->post("product_id")){
      $vars = [
        "product_id"=>(int)$this->input->post("product_id"),
        "color_id"=>($this->input->post("color_id")?(int)$this->input->post("color_id"):0),
        "mn_id"=>($this->input->post("mn_id")?(int)$this->input->post("mn_id"):0)];
      $result = $this->office_model->get_product_price($vars);
      echo json_encode($result);
    }else {
      // code...
    }


  }
  public function get_products($product_id)
  {
    $data = array();
    $product_id = (int)$product_id;
    $id = (int)$this->input->post("id");
    $data["list"] = $this->office_model->get_products_by_category_id($product_id, $id, "", 0, 5)["list"];

    $this->load->view("site/products", $data);
  }
  public function ajax_cart_buttons()
  {
    echo '

        <div class="ajax-cart-button-wrapper" data-productid="3923" data-isproductpage="false">
                        <input id="productQuantity3923" type="text" class="productQuantityTextBox" value="1" />
                <button type="button" class="button-2 product-box-add-to-cart-button nopAjaxCartProductListAddToCartButton" data-productid="3923"><span>+ Додади во кошничка</span></button>


        </div>
        <div class="ajax-cart-button-wrapper" data-productid="8539" data-isproductpage="false">
                        <input id="productQuantity8539" type="text" class="productQuantityTextBox" value="1" />
                <button type="button" class="button-2 product-box-add-to-cart-button nopAjaxCartProductListAddToCartButton" data-productid="8539"><span>+ Додади во кошничка</span></button>


        </div>
        <div class="ajax-cart-button-wrapper" data-productid="3928" data-isproductpage="false">
                        <input id="productQuantity3928" type="text" class="productQuantityTextBox" value="1" />
                <button type="button" class="button-2 product-box-add-to-cart-button nopAjaxCartProductListAddToCartButton" data-productid="3928"><span>+ Додади во кошничка</span></button>


        </div>
        <div class="ajax-cart-button-wrapper" data-productid="3924" data-isproductpage="false">
                        <input id="productQuantity3924" type="text" class="productQuantityTextBox" value="1" />
                <button type="button" class="button-2 product-box-add-to-cart-button nopAjaxCartProductListAddToCartButton" data-productid="3924"><span>+ Додади во кошничка</span></button>


        </div>
        <div class="ajax-cart-button-wrapper" data-productid="3925" data-isproductpage="false">
                        <input id="productQuantity3925" type="text" class="productQuantityTextBox" value="1" />
                <button type="button" class="button-2 product-box-add-to-cart-button nopAjaxCartProductListAddToCartButton" data-productid="3925"><span>+ Додади во кошничка</span></button>


        </div>';
  }
  public function retrieve_product_ribbons()
  {
    echo "";
  }
  public function retrieve_color_squares()
  {
    echo "";
  }

  function pagination_get($from=0,$perPage=100,$baseUrl, $totalRow, $uriSegment=4, $numLinks = 5)
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
    $config['num_tag_open'] = '<li class="individual-page">';
    $config['num_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li class="individual-page">';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li class="individual-page">';
    $config['prev_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li class="individual-page">';
    $config['last_tag_close'] = '</li>';
    $config['first_tag_open'] = '<li class="individual-page">';
    $config['first_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="current-page"><span>';
    $config['cur_tag_close'] = '</span></li>';
    $config['uri_segment'] = $uriSegment;
    $this-> pagination->initialize($config);
    return $this->pagination->create_links();
  }












}
