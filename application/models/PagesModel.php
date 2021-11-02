<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PagesModel extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }

  function get_main_slide_images($name, $size)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select destination, link from '.$prefix.'slide_new where name = "'.$name.'" and image_size = "'.$size.'"';

		return $this->db->query($query)->result();
	}

	function get_slide_settings($name)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select time, active_passive from '.$prefix.'slide_settings where name = "'.$name.'"';

		return $this->db->query($query)->result();
	}

	public function get_categories($lang)
	{
		$this->db->select("c_id.parent_id, c_id.icon, c_id.on_menu, c_id.deleted, c_id.order_by, c_id.discount_id, c_id.active,  c.*");
		$this->db->from("cats_id as c_id");
		$this->db->join('cats as c', 'c.cat_id = c_id.cat_id', 'left');
		$this->db->where("c_id.deleted", 0);
		$this->db->where("c_id.on_menu", 1);
		$this->db->where("c_id.active", 1);
		$this->db->where("c.lang_id", $lang);
		$this->db->order_by("c_id.order_by", "ASC");
		return $this->db->get()->result();
	}

	public function kolleksiyalar($lang)
	{
		$query = 'call kolleksiyalar('.$lang.')';
		return $this->db->query($query)->result();
	}

	public function main_page_products($lang, $table_name)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select p.title, p.description, p_img.img, p_im_ex.color_id, p_im_ex.mn_id, p_id.price as "ex_price", p_id.as_new, p_id.as_new_start_date, p_id.as_new_end_date, p_id.discount, sh.p_id FROM '.$prefix.$table_name.' as sh
							LEFT JOIN (SELECT p.p_id, p.title, p.description FROM '.$prefix.'products as p
							           WHERE p.lang_id='.$lang.') as p on p.p_id=sh.p_id
							LEFT JOIN (SELECT p_id.p_id, p_id.discount, p_id.price, p_id.as_new, p_id.as_new_start_date, p_id.as_new_end_date FROM '.$prefix.'products_id as p_id
							           WHERE p_id.active=1 and p_id.deleted=0) as p_id on p_id.p_id=sh.p_id
							LEFT JOIN (SELECT p_im_ex.product_id, p_im_ex.ex_price, p_im_ex.color_id, p_im_ex.mn_id FROM '.$prefix.'products_im_ex as p_im_ex
							           WHERE p_im_ex.id = (SELECT MIN(pp_im_ex.id) FROM '.$prefix.'products_im_ex as pp_im_ex
							                               WHERE pp_im_ex.product_id = p_im_ex.product_id)) as p_im_ex on p_im_ex.product_id = sh.p_id
							LEFT JOIN (SELECT p_img.p_id, p_img.img FROM '.$prefix.'products_img as p_img
							          WHERE p_img.index = (SELECT MIN(p.index) FROM '.$prefix.'products_img as p where p.p_id = p_img.p_id and p.active=1) and p_img.active=1) as p_img on p_img.p_id = sh.p_id
							WHERE p_id.p_id is not null';

		return $this->db->query($query)->result();
	}

	public function basket_count()
	{
		$prefix = $this->db->dbprefix;
		$a = 0;
		$a = @$this->session->userdata('user_id');

		if($a)
		{
			$query = 'SELECT COUNT(*) as "count" FROM '.$prefix.'orders AS o
			 					LEFT JOIN (select onum.order_number from '.$prefix.'order_numbers as onum
													 WHERE onum.order_status_id=8) as onum on onum.order_number = o.order_number
								WHERE onum.order_number is not null and o.user_id='.$this->session->userdata('user_id');
		}
		else
		{
			$query = 'SELECT COUNT(*) as "count" FROM '.$prefix.'orders AS o
			 					LEFT JOIN (select onum.order_number from '.$prefix.'order_numbers as onum
													 WHERE onum.order_status_id=8) as onum on onum.order_number = o.order_number
								WHERE onum.order_number is not null and o.tmp_user_id="'.$this->session->userdata('tmp_user').'"';
		}

		return $this->db->query($query)->result();
	}

	public function basket_data($order_status_id=8, $lang)
	{
		$prefix = $this->db->dbprefix;

		$where = "";
		if($this->session->userdata("user_id"))
			$where = " o.user_id=".$this->session->userdata("user_id");
		if($this->session->userdata("user_id") && $this->session->userdata("tmp_user"))
			$where = $where." or o.tmp_user_id='".$this->session->userdata("tmp_user")."' ";
		if(!$this->session->userdata("user_id") && $this->session->userdata("tmp_user"))
			$where = " o.tmp_user_id='".$this->session->userdata("tmp_user")."' ";

		$query ="SELECT * FROM (
			SELECT o.*, p_id.`sku`, m.title as 'mn_title', p.description, p.title as product_title, orn.order_status_id, p_img.img as thumb  FROM ".$prefix."orders as o
			LEFT JOIN ".$prefix."products_im_ex as im_ex  on im_ex.id=o.product_id
			LEFT JOIN ".$prefix."products_id as p_id  on p_id.p_id=o.product_id
			LEFT JOIN ".$prefix."order_numbers as orn  on orn.order_number=o.order_number
			LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$lang.") as p on p.p_id=o.product_id
		  LEFT JOIN (SELECT m.measure_id, m.title FROM ".$prefix."measures as m
		 						 WHERE lang_id=".$lang.") as m on m.measure_id=o.measure_id
			LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl
								 LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img GROUP BY p_id) tbl1 ON tbl1.p_id = tbl.p_id
								 WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=o.product_id
			WHERE (".$where.")  AND orn.order_status_id=".$order_status_id.") as b";

		return $this->db->query($query)->result();
	}

	public function get_measure($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select title from '.$prefix.'measures where measure_id=1 and lang_id ='.$lang;

		$data = $this->db->query($query)->result();
		return $data[0]->title;
	}

	public function get_orders($from, $count, $status_id, $search, $date_start, $date_end)
	{
		$where_search = $search?' and onum.order_number in ('.$search.')':'';
		$where_date_start = $date_start?' and onum.date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and onum.date_time<"'.$date_end.'"':'';

		$count = 20;
		$prefix = $this->db->dbprefix;
		$query = 'SELECT o2.qiymet_teklifi, o.count, onum.delivery_time, onum.order_status_id, onum.order_number, onum.date_time, onum.contract, onum.delivery_date, ec.pdf_path FROM '.$prefix.'order_numbers as onum
							LEFT JOIN (SELECT count(*) as "count", o.order_number FROM '.$prefix.'orders as o group by o.order_number) as o on o.order_number=onum.order_number
							LEFT JOIN (SELECT o2.order_number, if(isnull(o2.qiymet_teklifi), 1, o2.qiymet_teklifi) as "qiymet_teklifi" FROM '.$prefix.'orders as o2
												 WHERE o2.qiymet_teklifi is null) as o2 on o2.order_number=onum.order_number
							LEFT JOIN (SELECT id, pdf_path FROM '.$prefix.'export_contracts) as ec on ec.id = onum.contract
							WHERE onum.user_id = '.$this->session->userdata('user_id').' and onum.order_status_id in ('.$status_id.') '.$where_search.$where_date_start.$where_date_end.'
							GROUP BY onum.order_number
							ORDER BY onum.order_number desc
							LIMIT '.$from.', '.$count;

		return $this->db->query($query)->result();
	}

	public function get_orders_rows($status_id, $search, $date_start, $date_end)
	{
		$where_search = $search?' and onum.order_number in ('.$search.')':'';
		$where_date_start = $date_start?' and onum.date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and onum.date_time<"'.$date_end.'"':'';

		$prefix = $this->db->dbprefix;
		$query = 'SELECT count(*) as "count" FROM '.$prefix.'order_numbers as onum
							WHERE onum.user_id = '.$this->session->userdata('user_id').' and onum.order_status_id in ('.$status_id.')'.$where_search.$where_date_start.$where_date_end;

		return $this->db->query($query)->row();
	}

	public function pdf_list($id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT if(isnull(c.color_name), "Rəng yoxdur", c.color_name) as "color_name", p.description, if(isnull(mn.title), "Ölçü yoxdur", mn.title) as "mn_title", p.title,
              o.discount, o.ex_price, o.count, o.qiymet_teklifi FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT p.p_id, p.title, p.description FROM '.$prefix.'products as p
												 WHERE p.lang_id='.$lang.') as p on p.p_id=o.product_id
						  LEFT JOIN (SELECT mn.mn_id, mn.title FROM '.$prefix.'measure_names as mn
												 WHERE mn.lang_id='.$lang.') as mn on mn.mn_id=o.mn_id
						  LEFT JOIN (SELECT c.color_id, c.color_name FROM '.$prefix.'colors as c
												 WHERE c.lang_id='.$lang.') as c on c.color_id=o.color_id
							WHERE o.order_number = '.$id;

		return $this->db->query($query)->result();
	}

	public function get_cheque_opening_list($order_number, $date_start, $date_end, $admin, $buyer, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT m.title as "measure", p_img.img, o.count, o.ex_price, concat(p.title, " - ", p.description) as "product_name" FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
												 WHERE lang_id = '.$lang.') as p on p.p_id = o.product_id
							LEFT JOIN (SELECT i.p_id, i.img FROM ali_products_img as i
                         WHERE i.index = (SELECT MIN(p.index) FROM ali_products_img as p where p.p_id = i.p_id)
												 ) as p_img on p_img.p_id = o.product_id
							LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
												 WHERE lang_id = '.$lang.') as m on m.measure_id = o.measure_id
							WHERE o.order_number = '.$order_number;

		return $this->db->query($query)->result();
	}

	public function get_user($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT u.firstname, u.lastname, u.middlename, u.company_name, onum.order_number, onum.date_time, onum.discount FROM '.$prefix.'order_numbers as onum
							LEFT JOIN (SELECT u.user_id, u.firstname, u.lastname, u.middlename, u.company_name FROM '.$prefix.'site_users as u) as u on u.user_id=onum.user_id
							WHERE onum.order_number = '.$id;

		return $this->db->query($query)->row();
	}

	public function get_comment($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT onum.comment2 FROM '.$prefix.'order_numbers as onum	WHERE onum.order_number = '.$id;

		return $this->db->query($query)->row();
	}

	public function add_comment($id, $text)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'order_numbers SET comment2="'.$text.'"	WHERE order_number = '.$id;

		if($this->db->query($query))
			return true;
		else
			return false;
	}

	public function order_again($id)
	{
		$prefix = $this->db->dbprefix;

		$query1 = 'SELECT * FROM '.$prefix.'order_numbers WHERE order_number='.$id;
		$data = $this->db->query($query1)->row();

		if($data)
		{
			$this->db->insert($prefix.'order_numbers', array("order_status_id"=> 10, "date_time"=> date("Y-m-d H:i:s"), "region_id"=> 0, "address_id"=>$data->address_id, "user_id"=>$data->user_id));
			$new_id = $this->db->insert_id();

			if($new_id)
			{
				$query = "INSERT INTO ".$prefix."orders
									(order_number, product_id, title, img, color_id, mn_id, im_price, discount, ex_price, warehouse_id, count, measure_id, date_time, user_id, tmp_user_id)
									SELECT ".$new_id.", o2.product_id, o2.title, o2.img, o2.color_id, o2.mn_id, o2.im_price, o2.discount, o2.ex_price, o2.warehouse_id, o2.count, measure_id, '".date("Y-m-d H:i:s")."', o2.user_id, o2.tmp_user_id FROM ".$prefix."orders as o2
									WHERE o2.order_number=".$id;
				if($this->db->query($query))
					return true;
				else
					return false;
			}
			else
				return false;
		}
		else
			return false;
	}

	public function get_statistics_data1($lang, $date_start, $date_end, $admin=false, $buyer = 0)
	{
		$where_date_start = $date_start?' and onum.date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and onum.date_time<"'.$date_end.'"':'';
		$where_user_id = $admin?'':'onum.user_id = '.$this->session->userdata('user_id').' and';
		$where_buyer = $buyer?' and onum.user_id = '.$buyer:'';

		$prefix = $this->db->dbprefix;
		$query = 'SELECT if(isnull(c.name), "Kateqoriya yoxdur", c.name) as "name", onum.order_number, SUM(round((100 - o.discount)/100*o.ex_price, 2)) as "price", o.cat_id, o.product_id FROM '.$prefix.'order_numbers as onum
							LEFT JOIN (SELECT order_number, discount, ex_price, cat_id, product_id FROM '.$prefix.'orders) as o on o.order_number=onum.order_number
							LEFT JOIN (SELECT cat_id, name FROM '.$prefix.'cats WHERE lang_id='.$lang.') as c on c.cat_id=o.cat_id
							WHERE '.$where_user_id.' onum.order_status_id=15'.$where_date_start.$where_date_end.$where_buyer.'
							GROUP BY name';

		return $this->db->query($query)->result();
	}

	public function get_statistics_data2($date_start, $date_end, $admin=false, $buyer = 0)
	{
		$where_date_start = $date_start?' and onum.date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and onum.date_time<"'.$date_end.'"':'';
		$where_user_id = $admin?'':'onum.user_id = '.$this->session->userdata('user_id').' and';
		$where_buyer = $buyer?' and onum.user_id = '.$buyer:'';

		$prefix = $this->db->dbprefix;
		$query = 'SELECT MONTHNAME(date_time) as "date_time", price FROM (
								SELECT onum.date_time, SUM(round((100 - o.discount)/100*o.ex_price, 2)) as "price" FROM '.$prefix.'order_numbers as onum
								LEFT JOIN (SELECT order_number, discount, ex_price, cat_id, product_id FROM '.$prefix.'orders) as o on o.order_number=onum.order_number
								WHERE '.$where_user_id.' onum.order_status_id=15'.$where_date_start.$where_date_end.$where_buyer.'
								GROUP BY MONTH(onum.date_time)
								ORDER BY onum.date_time desc
								LIMIT 12
							) as sub
							ORDER BY date_time ASC';

		return $this->db->query($query)->result();
	}

	public function get_order_count($status_id, $date_start, $date_end, $admin = false, $buyer = 0)
	{
		$where_date_start = $date_start?' and date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and date_time<"'.$date_end.'"':'';
		$where_user_id = $admin?'':'user_id = '.$this->session->userdata('user_id').' and';
		$where_buyer = $buyer?' and user_id = '.$buyer:'';

		$prefix = $this->db->dbprefix;
		$query = 'SELECT count(*) as "count" FROM '.$prefix.'order_numbers WHERE '.$where_user_id.' order_status_id in ('.$status_id.')'.$where_date_start.$where_date_end.$where_buyer;

		return $this->db->query($query)->row()->count;
	}

	public function get_user_mail()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT email FROM '.$prefix.'site_users WHERE user_id='.$this->session->userdata('user_id');
		return $this->db->query($query)->row()->email;
	}

	public function get_lang()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT lang_id, name, thumb FROM '.$prefix.'langs WHERE lang_id='.$this->session->userdata('lang_id').' and lang_id != 4
							UNION
							SELECT lang_id, name, thumb FROM '.$prefix.'langs WHERE lang_id!='.$this->session->userdata('lang_id').' and lang_id != 4';

		return $this->db->query($query)->result();
	}

	public function get_socials()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT * FROM '.$prefix.'social_icons WHERE active=1 ORDER BY order_by asc';

		return $this->db->query($query)->result();
	}

	public function get_contact($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT title FROM '.$prefix.'map WHERE lang_id='.$lang;

		return $this->db->query($query)->result();
	}

	public function get_phone()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT p.number FROM '.$prefix.'phone as p WHERE id=1';

		return $this->db->query($query)->row();
	}

	public function get_footer_category($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT c_id.cat_id, c.name FROM '.$prefix.'cats_id as c_id
		 					LEFT JOIN (SELECT cat_id, name FROM '.$prefix.'cats
												 WHERE lang_id='.$lang.') as c ON c.cat_id=c_id.cat_id
							WHERE c_id.show_unshow=1 and c_id.deleted=0 and c_id.active=1 and c.name is not null and c.name!="" and c_id.cat_id not in (SELECT parent_id FROM '.$prefix.'cats_id
																	 			WHERE parent_id!=0 group by parent_id)';

		return $this->db->query($query)->result();
	}

	public function get_description($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT description FROM '.$prefix.'description WHERE lang_id='.$lang;

		return $this->db->query($query)->row();
	}

	public function get_pd_list()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT * FROM '.$prefix.'site_users
							WHERE user_id='.$this->session->userdata('user_id');

		return $this->db->query($query)->row();
	}

	public function change_password($last, $new)
	{
		$prefix = $this->db->dbprefix;
		$query1 = 'SELECT user_id FROM '.$prefix.'site_users
							 WHERE user_id='.$this->session->userdata('user_id').' and password="'.$last.'"';

		if($this->db->query($query1)->row())
		{
			$query = 'UPDATE '.$prefix.'site_users SET password="'.md5($new).'"
			WHERE password="'.$last.'" and user_id='.$this->session->userdata('user_id');

			if($this->db->query($query))
				return true;
			else
				return false;
		}
		else
			return false;
	}

	public function change_password2($last, $new, $mail)
	{
		$prefix = $this->db->dbprefix;

		$query = 'UPDATE '.$prefix.'site_users SET password="'.md5($new).'"
							WHERE password="'.$last.'" and email="'.$mail.'"';

		if($this->db->query($query))
			return true;
		else
			return false;
	}

	function search_result($from, $count, $param, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = ' SELECT im_ex.im_price, im_ex.ex_price, im_ex.color_id, im_ex.mn_id, p_img.img, p.title, p.description, p_id.p_id, p_id.discount, p_id.as_new, p_id.as_new_start_date, p_id.as_new_end_date FROM '.$prefix.'products_id as p_id
		           LEFT JOIN (SELECT p.p_id, p.title, p.description FROM '.$prefix.'products as p
		                      WHERE lang_id='.$lang.') as p on p.p_id = p_id.p_id
		           LEFT JOIN (select im_ex.product_id, im_ex.im_price, im_ex.color_id, im_ex.mn_id, im_ex.ex_price FROM '.$prefix.'products_im_ex as im_ex
		                      WHERE im_ex.color_id = (SELECT MIN(m.color_id) FROM '.$prefix.'products_im_ex as m where m.product_id = im_ex.product_id)) as im_ex on im_ex.product_id = p_id.p_id
		           LEFT JOIN (SELECT p_img.p_id, p_img.img FROM '.$prefix.'products_img as p_img
		                      WHERE p_img.index = (SELECT MIN(p.index) FROM '.$prefix.'products_img as p where p.p_id = p_img.p_id) and p_img.active=1) as p_img on p_img.p_id = p_id.p_id
		           WHERE (im_ex.ex_price = "'.$param.'" or p.title like "%'.$param.'%" or p.description like "%'.$param.'%" or p_id.p_id = "'.$param.'") and p_id.active=1 and p_id.deleted=0
							 GROUP BY p_id.p_id
							 LIMIT '.$from.', '.$count;

		return $this->db->query($query)->result();
	}

	function search_result_rows($param, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = ' SELECT count(*) as "count" FROM '.$prefix.'products_id as p_id
		           LEFT JOIN (SELECT p.p_id, p.title, p.description FROM '.$prefix.'products as p
		                      WHERE lang_id='.$lang.') as p on p.p_id = p_id.p_id
		           LEFT JOIN (select im_ex.product_id, im_ex.im_price, im_ex.color_id, im_ex.mn_id, im_ex.ex_price FROM '.$prefix.'products_im_ex as im_ex
		                      WHERE im_ex.color_id = (SELECT MIN(m.color_id) FROM '.$prefix.'products_im_ex as m where m.product_id = im_ex.product_id)) as im_ex on im_ex.product_id = p_id.p_id
		           LEFT JOIN (SELECT p_img.p_id, p_img.img FROM '.$prefix.'products_img as p_img
		                      WHERE p_img.index = (SELECT MIN(p.index) FROM '.$prefix.'products_img as p where p.p_id = p_img.p_id) and p_img.active=1) as p_img on p_img.p_id = p_id.p_id
		           WHERE (im_ex.ex_price = "'.$param.'" or p.title like "%'.$param.'%" or p.description like "%'.$param.'%" or p_id.p_id = "'.$param.'") and p_id.active=1 and p_id.deleted=0
							 GROUP BY p_id.p_id';

		return $this->db->query($query)->row();
	}

	function check_mail_list($mail)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT email, password FROM '.$prefix.'site_users WHERE email="'.$mail.'"';

		return $this->db->query($query)->row();
	}

	function get_statistics_products($lang, $from, $end, $date_start, $date_end, $ord_type, $ord_name, $admin = false, $buyer = 0)
	{
		$prefix = $this->db->dbprefix;
		$where_date_start = $date_start?' and o.date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and o.date_time<"'.$date_end.'"':'';

		$mail_upgrade = ($from==0 && $end==0)?'':' LIMIT '.$from.', '.$end;

		if($ord_name=="num")
			$ord_name = 'o.product_id';

		if($ord_name=="title")
			$ord_name = 'p.title';

		$where_user_id = '';
		if(!$admin)
			$where_user_id = 'o.user_id = '.$this->session->userdata('user_id').' and';
		$buyer_where = $buyer?(' and o.user_id = '.$buyer):'';

		$query = 'SELECT p.title, p.description, count(o.product_id) as "count", sum(o.count) as "sum_count", o.product_id, o.img, round(sum(o.ex_price*o.count), 2) as "price" FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
												 WHERE lang_id='.$lang.') as p on p.p_id = o.product_id
							LEFT JOIN (SELECT order_number, order_status_id FROM '.$prefix.'order_numbers) as onum on onum.order_number = o.order_number
							WHERE '.$where_user_id.' onum.order_status_id in (12,15) '.$where_date_start.$where_date_end.$buyer_where.'
							GROUP BY o.product_id
							ORDER BY '.$ord_name.' '.$ord_type.$mail_upgrade;

		return $this->db->query($query)->result();
	}

	function get_statistics_products_rows($date_start, $date_end, $admin = false, $buyer = 0)
	{
		$prefix = $this->db->dbprefix;
		$where_date_start = $date_start?' and o.date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and o.date_time<"'.$date_end.'"':'';

		$where_user_id = '';
		if(!$admin)
			$where_user_id = 'o.user_id = '.$this->session->userdata('user_id').' and';
		$buyer_where = $buyer?(' and o.user_id = '.$buyer):'';

		$query = 'SELECT count(*) as "count" FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT order_number, order_status_id FROM '.$prefix.'order_numbers) as onum on onum.order_number = o.order_number
							WHERE '.$where_user_id.' onum.order_status_id in (12,15) '.$where_date_start.$where_date_end.$buyer_where.'
							GROUP BY o.product_id';

		return $this->db->query($query)->row();
	}

	function get_statistics_checks($from, $end, $date_start, $date_end, $ord_type, $ord_name, $admin = false, $buyer = 0)
	{
		$prefix = $this->db->dbprefix;
		$where_date_start = $date_start?' and onum.date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and onum.date_time<"'.$date_end.'"':'';

		$mail_upgrade = ($from==0 && $end==0)?'':' LIMIT '.$from.', '.$end;

		if($ord_name=="num")
			$ord_name = 'onum.order_number';

		if($ord_name=="date_time")
			$ord_name = 'onum.date_time';

		if($ord_name=="price")
			$ord_name = 'o.price';

		$user_id_where = '';
		if(!$admin)
			$user_id_where = 'onum.user_id = '.$this->session->userdata('user_id').' and';
		$buyer_where = $buyer?(' and onum.user_id = '.$buyer):'';

		$query = 'SELECT ec.id as "contract_number", ec.pdf_path, o.price, onum.order_number, onum.date_time FROM '.$prefix.'order_numbers as onum
							LEFT JOIN (SELECT order_number, round(sum(ex_price*count),2) as "price" FROM '.$prefix.'orders
												 GROUP BY order_number) as o on o.order_number=onum.order_number
							LEFT JOIN (SELECT id, pdf_path FROM '.$prefix.'export_contracts) as ec on ec.id = onum.contract
							WHERE '.$user_id_where.' onum.order_status_id in (12,15) '.$where_date_start.$where_date_end.$buyer_where.'
							ORDER BY '.$ord_name.' '.$ord_type.$mail_upgrade;

		return $this->db->query($query)->result();
	}

	function get_statistics_checks_rows($date_start, $date_end, $admin = false, $buyer = 0)
	{
		$prefix = $this->db->dbprefix;
		$where_date_start = $date_start?' and onum.date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and onum.date_time<"'.$date_end.'"':'';

		$user_id_where = '';
		if(!$admin)
			$user_id_where = 'onum.user_id = '.$this->session->userdata('user_id').' and';
		$buyer_where = $buyer?(' and onum.user_id = '.$buyer):'';

		$query = 'SELECT count(*) as "count" FROM '.$prefix.'order_numbers as onum
							WHERE '.$user_id_where.' onum.order_status_id in (12,15) '.$where_date_start.$where_date_end.$buyer_where;

		return $this->db->query($query)->row();
	}

	function get_opening_list($id, $date_start, $date_end, $admin = false)
	{
		$prefix = $this->db->dbprefix;
		$lang = $this->session->userdata('lang_id');
		$where_date_start = $date_start?' and o.date_time>"'.$date_start.'"':'';
		$where_date_end = $date_end?' and o.date_time<"'.$date_end.'"':'';

		$where_user_id = '';
		if(!$admin)
			$where_user_id = 'o.user_id = '.$this->session->userdata('user_id').' and';

		$query = 'SELECT onum.order_number, o.product_id, o.img, o.ex_price, o.count, o.date_time FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT order_number, order_status_id FROM '.$prefix.'order_numbers) as onum on onum.order_number = o.order_number
							WHERE '.$where_user_id.' onum.order_status_id in (12,15) and o.product_id='.$id.$where_date_start.$where_date_end;

		return $this->db->query($query)->result();
	}

	function select_where($select, $where, $table_name, $order_by = false)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->from($table_name);

		if($order_by)
			$this->db->order_by($order_by[0], $order_by[1]);

		return $this->db->get()->result();
	}

	function select_where_row($select, $where, $table_name, $order_by = false)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->from($table_name);

		if($order_by)
			$this->db->order_by($order_by[0], $order_by[1]);

		return $this->db->get()->row();
	}

	function edit_products($order_number, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT o.id, m.title as "measure", CONCAT(p.title, " - ", p.description) as "p_name", o.count, o.ex_price FROM ali_orders as o
							LEFT JOIN (SELECT p_id, title, description FROM ali_products
												 WHERE lang_id = '.$lang.') as p on p.p_id = o.product_id
							LEFT JOIN (SELECT measure_id, title FROM ali_measures
												 WHERE lang_id = '.$lang.') as m on m.measure_id = o.measure_id
							WHERE o.order_number = '.$order_number;

		return $this->db->query($query)->result();
	}

	function delete_item($where, $table_name)
	{
		$this->db->where($where);
		return $this->db->delete($table_name);
	}

	function update_table($table_name, $where, $vars)
	{
		$this->db->where($where);
		return $this->db->update($table_name, $vars);
	}

	function warehouse_monthly()
	{
		$prefix = $this->db->dbprefix;
		$query1 = 'INSERT INTO '.$prefix.'products_im_ex_total
							 SELECT * FROM '.$prefix.'products_im_ex AS im_ex
							 WHERE  im_ex.id > (SELECT MAX(id) FROM '.$prefix.'products_im_ex_total)';

		$query2 = 'INSERT INTO '.$prefix.'products_im_ex_tmp
								SELECT lst.* FROM
									 (SELECT im_ex.id, im_ex.product_id, im_ex.color_id, im_ex.mn_id, im_ex.im_price, im_ex.ex_price, im_ex.warehouse_id,
										 			(im_ex.count - if(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", im_ex.measure_id,
													im_ex.im_ex, im_ex.date_time, im_ex.provider_id, im_ex.entry_name_id, im_ex.user_id, im_ex.contract_number, im_ex.check_number, im_ex.expiration_date
									 FROM '.$prefix.'products_im_ex AS im_ex
									 LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
									 					  LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
									 WHERE im_ex.im_ex = 0
									 GROUP BY im_ex.id) AS lst
								WHERE lst.count != 0';

		$query3 = 'DELETE FROM '.$prefix.'products_im_ex';

		$query4 = 'INSERT INTO '.$prefix.'products_im_ex
							 SELECT * FROM '.$prefix.'products_im_ex_tmp';

		$query5 = 'DELETE FROM '.$prefix.'products_im_ex_tmp';

		$result1 = $this->db->query($query1);
		$result2 = $this->db->query($query2);
		$result3 = $this->db->query($query3);
		$result4 = $this->db->query($query4);
		$result5 = $this->db->query($query5);

		if($result1 && $result2 && $result3 && $result4 && $result5)
			return true;
		else
			return false;
	}

	function get_product_count($product_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT sum(prod.count) as "count", prod.measure FROM
								(SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", m.title as "measure", im_ex.product_id FROM '.$prefix.'products_im_ex as im_ex
								LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures WHERE lang_id = '.$lang.') as m on m.measure_id = im_ex.measure_id
								LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
													 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
								WHERE im_ex.im_ex = 0 and im_ex.product_id = '.$product_id.'
								GROUP BY im_ex.id) as prod
							GROUP BY prod.product_id';

		return $this->db->query($query)->row();
	}

	function get_ordered_count($id, $user_id)
	{
		$prefix = $this->db->dbprefix;
		$user_id_where = $this->session->userdata('user_id')?' and onum.user_id = '.$this->session->userdata('user_id'):' and onum.tmp_user_id = "'.$this->session->userdata('tmp_user').'"';

		$query = 'SELECT sum(count) as "count" FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT order_number, order_status_id, user_id, tmp_user_id FROM '.$prefix.'order_numbers) as onum on onum.order_number = o.order_number
							WHERE o.product_id = '.$id.' and onum.order_status_id in (8,10,16)'.$user_id_where.'
							GROUP BY o.product_id';

		return $this->db->query($query)->row();
	}
}
