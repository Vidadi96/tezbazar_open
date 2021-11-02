<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders_model extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }
	/******ORDERS*****/
	function orders($filter, $from, $end)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		$sql ="

		SELECT u.lastname as 'fullname', o.id,o.user_id, o.tmp_user_id, o.order_status_id,  sum(o.`count`) as product_count, sum(o.ex_price) as product_price, o.date_time, os.order_status_title  FROM ".$prefix."orders as o
		LEFT JOIN (select * from ".$prefix."order_status where lang_id=".$this->session->userdata("lang_id").") as os on os.order_status_id=o.order_status_id
		LEFT JOIN ".$prefix."site_users as u on u.user_id=o.user_id
		LEFT JOIN ".$prefix."order_status_id as os_id on os_id.order_status_id=o.order_status_id
		Group by o.tmp_user_id, o.user_id, o.order_status_id";


		/*SELECT o.* FROM ".$prefix."orders as o
		LEFT JOIN ".$prefix."order_status_id as os on os.order_status_id=o.order_status_id
		LEFT JOIN (Select * from ".$prefix."products where lang_id=".$this->session->userdata("lang_id").") as p on p.p_id=o.product_id
		LEFT JOIN ".$prefix."products_im_ex as im_ex on im_ex.product_id = o.product_id and im_ex.color_id = o.color_id and
		im_ex.mn_id=o.mn_id*/

		$total = $this->db->query("SELECT count(*) as count_rows FROM (".$sql.") as t")->row();
		$data["total_row"] = $total->count_rows;
		$data["sql"] = $sql;

		$sql = $sql." order by o.id DESC  LIMIT ".$from.", ".$end;

		$data["list"] = $this->db->query($sql)->result();
		return $data;
	}
	/******END ORDERS*****/
	/*****Order status Start******/
	function order_status()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT o_s.order_status_title, o_s.lang_id, o_s_id.order_status_id, o_s_id.order_by, o_s_id.active from ".$prefix."order_status_id as o_s_id LEFT JOIN(select * from ".$prefix."order_status as c where c.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."order_status as c1 where c1.lang_id=1 AND c1.order_status_id not in(select order_status_id from ".$prefix."order_status as c3 where c3.lang_id=".$this->session->userdata("lang_id").")) as o_s on o_s.order_status_id=o_s_id.order_status_id where o_s_id.deleted=0 order by o_s_id.order_by ASC")->result();
	}
	function edit_order_status($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT os.*, o_s_id.order_by, o_s_id.active from ".$prefix."order_status as os LEFT JOIN ".$prefix."order_status_id as o_s_id on o_s_id.order_status_id=os.order_status_id where o_s_id.deleted=0 and o_s_id.order_status_id=".$id)->result_array();
	}
	/*****Order status End******/
	function order_list_10($start, $count, $status_id)
	{
		if($status_id==10)
			$comment = 'comment';
		else
			$comment = 'comment2';

		$prefix = $this->db->dbprefix;
		$query = 'SELECT o.count, onum.address, u.company_name, u.user_id, u.firstname, u.lastname, u.middlename, onum.order_number, onum.contract, onum.date_time, if(isnull(onum.'.$comment.'), "yoxdur", onum.'.$comment.') as "comment" FROM '.$prefix.'order_numbers AS onum
							LEFT JOIN (SELECT u.company_name, u.user_id, u.firstname, u.lastname, u.middlename FROM '.$prefix.'site_users as u) as u on u.user_id=onum.user_id
							LEFT JOIN (SELECT count(*) as "count", o.order_number FROM '.$prefix.'orders as o group by o.order_number) as o on o.order_number=onum.order_number
							WHERE onum.order_status_id in ('.$status_id.')
							LIMIT '.$start.', '.$count;

		return $this->db->query($query)->result();
	}

	function get_order_list_row_10($status_id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT count(*) as "count" FROM '.$prefix.'order_numbers AS onum
							LEFT JOIN (SELECT u.user_id, u.firstname, u.lastname, u.middlename FROM '.$prefix.'site_users as u) as u on u.user_id=onum.user_id
							LEFT JOIN '.$prefix.'addresses as a on a.user_id = onum.user_id
							LEFT JOIN (SELECT count(*) as "count", o.order_number FROM '.$prefix.'orders as o group by o.order_number) as o on o.order_number=onum.order_number
							WHERE onum.order_status_id in ('.$status_id.')';

		return $this->db->query($query)->result();
	}

	function get_product_list_row_10($id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT count(*) as "count" FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT p.p_id, p.title FROM '.$prefix.'products as p
												 WHERE p.lang_id='.$lang.') as p on p.p_id=o.product_id
						  LEFT JOIN (SELECT mn.mn_id, mn.title FROM '.$prefix.'measure_names as mn
												 WHERE mn.lang_id='.$lang.') as mn on mn.mn_id=o.mn_id
						  LEFT JOIN (SELECT c.color_id, c.color_name FROM '.$prefix.'colors as c
												 WHERE c.lang_id='.$lang.') as c on c.color_id=o.color_id
							WHERE o.order_number = '.$id;

		return $this->db->query($query)->result();
	}

	function get_product_list_10($start, $count, $id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT if(isnull(c.color_name), "Rəng yoxdur", c.color_name) as "color_name", if(isnull(mn.title), "Ölçü yoxdur", mn.title) as "mn_title", p.title, o.discount, o.ex_price, o.count, o.id,
										 if(isnull(o.qiymet_teklifi), 0, o.qiymet_teklifi) as "qiymet_teklifi", o.comment FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT p.p_id, p.title FROM '.$prefix.'products as p
												 WHERE p.lang_id='.$lang.') as p on p.p_id=o.product_id
						  LEFT JOIN (SELECT mn.mn_id, mn.title FROM '.$prefix.'measure_names as mn
												 WHERE mn.lang_id='.$lang.') as mn on mn.mn_id=o.mn_id
						  LEFT JOIN (SELECT c.color_id, c.color_name FROM '.$prefix.'colors as c
												 WHERE c.lang_id='.$lang.') as c on c.color_id=o.color_id
							WHERE o.order_number = '.$id.'
							LIMIT '.$start.', '.$count;

		return $this->db->query($query)->result();
	}

	// function get_all_proposal_10($id)
	// {
	// 	$prefix = $this->db->dbprefix;
	// 	$query = 'SELECT if(isnull(qiymet_teklifi), -1, qiymet_teklifi) as "qiymet_teklifi" FROM '.$prefix.'orders WHERE order_number='.$id;
	//
	// 	return $this->db->query($query)->result();
	// }

	function get_all_proposal_with_order_id_10($order_id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT if(isnull(qiymet_teklifi), -1, qiymet_teklifi) as "qiymet_teklifi" FROM '.$prefix.'orders
							WHERE order_number=(SELECT order_number FROM '.$prefix.'orders WHERE id='.$order_id.')';

		return $this->db->query($query)->result();
	}

	function change_proposal($id, $teklif)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'orders SET qiymet_teklifi='.$teklif.' WHERE id='.$id;

		if($this->db->query($query))
			return true;
		else
			return false;
	}

	function add_contract_number($id, $delivery_date, $status_id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'order_numbers SET order_status_id='.$status_id.', delivery_date ="'.$delivery_date.'" WHERE order_number='.$id;

		return $this->db->query($query);
	}

	function change_status_proposal($id, $status_id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'order_numbers SET order_status_id='.$status_id.', date_time="'.date("Y-m-d H:i:s").'" WHERE order_number='.$id;

		return $this->db->query($query);
	}

	function change_proposal_where_absent($id)
	{
		$prefix = $this->db->dbprefix;

		$query = 'UPDATE '.$prefix.'orders SET qiymet_teklifi=((100-discount)/100*count*ex_price) WHERE qiymet_teklifi is null and order_number='.$id;

		if($this->db->query($query))
			return true;
		else
			return false;
	}

	function mail_order_list($id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT p.description, mn.title as "mn_title", o.product_id as "p_id", o.img, o.title, o.discount, o.ex_price as "price", o.count, o.qiymet_teklifi FROM '.$prefix.'orders AS o
							LEFT JOIN (SELECT mn_id, title FROM '.$prefix.'measure_names as mn WHERE mn.lang_id='.$lang.') as mn on mn.mn_id = o.mn_id
							LEFT JOIN (SELECT p_id, description FROM '.$prefix.'products WHERE lang_id='.$lang.') as p on p.p_id=o.product_id
							WHERE o.order_number='.$id;

		return $this->db->query($query)->result_array();
	}

	function mail_user($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT firstname, lastname, middlename, email FROM '.$prefix.'site_users
							WHERE user_id=(SELECT user_id FROM '.$prefix.'order_numbers WHERE order_number='.$id.')';

		return $this->db->query($query)->row();
	}

	function mail_address($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT phone, address FROM '.$prefix.'addresses
							WHERE user_id=(SELECT user_id FROM '.$prefix.'order_numbers WHERE order_number='.$id.')';

		return $this->db->query($query)->row();
	}

	function update_discount($id, $discount, $delivery_time)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'order_numbers SET discount='.$discount.', delivery_time="'.$delivery_time.'" WHERE order_number='.$id;

		if($this->db->query($query))
			return true;
		else
			return false;
	}

	function update_table($table_name, $where, $vars)
	{
		$this->db->where($where);
		return $this->db->update($table_name, $vars);
	}

	function select_function($select, $table_name, $order_by = false)
	{
		$this->db->select($select);
		$this->db->from($table_name);

		if($order_by)
			$this->db->order_by($order_by[0], $order_by[1]);

		return $this->db->get()->result();
	}

	function update_reject_period($reject_period)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'reject_period SET reject_period = "'.$reject_period.'" WHERE id=1';

		return $this->db->query($query);
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

	function get_product_list($order_number, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT o.comment, o.id, o.product_id, o.count, m.title as "measure", CONCAT(p.title, " - ", p.description) as "name" FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT p.p_id, p.title, p.description FROM '.$prefix.'products as p
												 WHERE p.lang_id='.$lang.') as p on p.p_id=o.product_id
						  LEFT JOIN (SELECT m.measure_id, m.title FROM '.$prefix.'measures as m
												 WHERE m.lang_id='.$lang.') as m on m.measure_id = o.measure_id
							WHERE o.order_number = '.$order_number;

		return $this->db->query($query)->result();
	}

	function update_count($id, $count)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'orders SET count = '.$count.' WHERE id = '.$id;

		return $this->db->query($query);
	}

	function get_products_count($order_number)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT sum(prod.count) as "count", o.count as "count2", prod.product_id FROM
								(SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", im_ex.product_id FROM '.$prefix.'products_im_ex as im_ex
								LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
													 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
								WHERE im_ex.im_ex = 0
								GROUP BY im_ex.id) as prod
							LEFT JOIN (SELECT product_id, count FROM '.$prefix.'orders
												 WHERE order_number = '.$order_number.') as o on o.product_id = prod.product_id
							WHERE o.product_id is not null
							GROUP BY prod.product_id';

		return $this->db->query($query)->result();
	}

	function get_im_ex($product_id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT id FROM '.$prefix.'products_im_ex WHERE im_ex = 0 and product_id = '.$product_id;

		return $this->db->query($query)->result();
	}

	function get_for_do_export($im_ex_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", im_ex.id, im_ex.im_price, im_ex.ex_price, im_ex.measure_id, im_ex.warehouse_id, im_ex.expiration_date FROM '.$prefix.'products_im_ex as im_ex
							LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
												 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
							WHERE im_ex.im_ex = 0 and im_ex.id = '.$im_ex_id.'
							GROUP BY im_ex.id';

		return $this->db->query($query)->result();
	}

	function insert_id_item($vars, $table_name)
	{
		if ($this->db->insert($table_name, $vars))
			return $this->db->insert_id();
		else
			return false;
	}

	function add_more_item($vars, $table_name)
	{
		return $this->db->insert_batch($table_name, $vars);
	}
}
