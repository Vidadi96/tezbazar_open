<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports_model extends CI_Model
{
	function __construct()
  {
    parent::__construct();
  }

	function get_products($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT pid.p_id, pid.sku, CONCAT(p.title, " - ", p.description) AS "product_name" FROM '.$prefix.'products_id as pid
							LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
												 WHERE lang_id='.$lang.') as p on p.p_id = pid.p_id
							WHERE active=1 and deleted=0';

		return $this->db->query($query)->result();
	}

	function select_function($select, $table_name, $order_by = false)
	{
		$this->db->select($select);
		$this->db->from($table_name);

		if($order_by)
			$this->db->order_by($order_by[0], $order_by[1]);

		return $this->db->get()->result();
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

	function select_where_array($select, $where, $table_name, $order_by = false)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->from($table_name);

		if($order_by)
			$this->db->order_by($order_by[0], $order_by[1]);

		return $this->db->get()->result_array();
	}

	function import_list($from, $count, $product_id, $start_date, $end_date, $category_id, $salesman, $lang, $im_ex)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		$price = $im_ex?'ex_price':'im_price';
		$provider = $im_ex?'LEFT JOIN (SELECT user_id, lastname FROM '.$prefix.'site_users) as s on s.user_id = tot.provider_id':'LEFT JOIN (SELECT id, fullname FROM '.$prefix.'salesmen) as s on s.id = tot.provider_id';
		$provider_name = $im_ex?'s.lastname':'s.fullname';

		if($product_id)
			$where .= ' and tot.product_id='.$product_id;
		if($start_date)
			$where .= ' and tot.date_time > "'.$start_date.'"';
		if($end_date)
			$where .= ' and tot.date_time < "'.$end_date.'"';
		if($category_id)
			$where .= ' and tot.product_id in (SELECT item_id FROM ali_relations WHERE rel_type_id = 2 and rel_item_id in ('.$category_id.'))';
		if($salesman)
			$where .= ' and tot.provider_id = '.$salesman;

		$query = ' SELECT r.row_count, tot.product_id, tot.'.$price.', tot.count, tot.date_time, p_id.sku, CONCAT(p.title, " - ", p.description) as "p_name", m.title as "measure", '.$provider_name.' as "provider" FROM
								(SELECT id, product_id, '.$price.', count, im_ex, date_time, provider_id, measure_id FROM '.$prefix.'products_im_ex_total
								 UNION
								 SELECT im_ex.id, im_ex.product_id, im_ex.'.$price.', im_ex.count, im_ex.im_ex, im_ex.date_time, im_ex.provider_id, im_ex.measure_id FROM '.$prefix.'products_im_ex as im_ex
								 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								 WHERE t.id is null) as tot
							 LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) as p_id on p_id.p_id = tot.product_id
							 LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
								 					WHERE lang_id = '.$lang.') as p on p.p_id = tot.product_id
							 LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
							 						WHERE lang_id = '.$lang.') as m on m.measure_id = tot.measure_id
							 '.$provider.'
							 LEFT JOIN (SELECT count(tot.product_id) as row_count, tot.id FROM
														(SELECT id, product_id, im_ex, date_time, provider_id FROM '.$prefix.'products_im_ex_total
														 UNION
														 SELECT im_ex.id, im_ex.product_id, im_ex.im_ex, im_ex.date_time, im_ex.provider_id FROM '.$prefix.'products_im_ex as im_ex
														 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
														 WHERE t.id is null) as tot
													WHERE tot.im_ex = '.(int) $im_ex.$where.'
													GROUP BY tot.product_id) as r on r.id = tot.id
							 WHERE tot.im_ex = '.(int) $im_ex.$where.'
							 ORDER BY tot.product_id asc, r.row_count desc
							 LIMIT '.$from.', '.$count;

		return $this->db->query($query)->result();
	}

	function import_list_all($product_id, $start_date, $end_date, $category_id, $salesman, $lang, $im_ex)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		$price = $im_ex?'ex_price':'im_price';
		$provider = $im_ex?'LEFT JOIN (SELECT user_id, lastname FROM '.$prefix.'site_users) as s on s.user_id = tot.provider_id':'LEFT JOIN (SELECT id, fullname FROM '.$prefix.'salesmen) as s on s.id = tot.provider_id';
		$provider_name = $im_ex?'s.lastname':'s.fullname';

		if($product_id)
			$where .= ' and tot.product_id='.$product_id;
		if($start_date)
			$where .= ' and tot.date_time > "'.$start_date.'"';
		if($end_date)
			$where .= ' and tot.date_time < "'.$end_date.'"';
		if($category_id)
			$where .= ' and tot.product_id in (SELECT item_id FROM ali_relations WHERE rel_type_id = 2 and rel_item_id in ('.$category_id.'))';
		if($salesman)
			$where .= ' and tot.provider_id = '.$salesman;

		$query = ' SELECT r.row_count, tot.product_id, tot.'.$price.', tot.count, tot.date_time, p_id.sku, CONCAT(p.title, " - ", p.description) as "p_name", m.title as "measure", '.$provider_name.' as "provider" FROM
								(SELECT id, product_id, '.$price.', count, im_ex, date_time, provider_id, measure_id FROM '.$prefix.'products_im_ex_total
								 UNION
								 SELECT im_ex.id, im_ex.product_id, im_ex.'.$price.', im_ex.count, im_ex.im_ex, im_ex.date_time, im_ex.provider_id, im_ex.measure_id FROM '.$prefix.'products_im_ex as im_ex
								 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								 WHERE t.id is null) as tot
							 LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) as p_id on p_id.p_id = tot.product_id
							 LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
								 					WHERE lang_id = '.$lang.') as p on p.p_id = tot.product_id
							 LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
							 						WHERE lang_id = '.$lang.') as m on m.measure_id = tot.measure_id
							 '.$provider.'
							 LEFT JOIN (SELECT count(tot.product_id) as row_count, tot.id FROM
														(SELECT id, product_id, im_ex, date_time, provider_id FROM '.$prefix.'products_im_ex_total
														 UNION
														 SELECT im_ex.id, im_ex.product_id, im_ex.im_ex, im_ex.date_time, im_ex.provider_id FROM '.$prefix.'products_im_ex as im_ex
														 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
														 WHERE t.id is null) as tot
													WHERE tot.im_ex = '.(int) $im_ex.$where.'
													GROUP BY tot.product_id) as r on r.id = tot.id
							 WHERE tot.im_ex = '.(int) $im_ex.$where.'
							 ORDER BY tot.product_id asc';

		return $this->db->query($query)->result();
	}

	function import_list_rows($product_id, $start_date, $end_date, $category_id, $salesman, $im_ex)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if($product_id)
			$where .= ' and tot.product_id='.$product_id;
		if($start_date)
			$where .= ' and tot.date_time > "'.$start_date.'"';
		if($end_date)
			$where .= ' and tot.date_time < "'.$end_date.'"';
		if($category_id)
			$where .= ' and tot.product_id in (SELECT item_id FROM '.$prefix.'relations WHERE rel_type_id = 2 and rel_item_id in ('.$category_id.'))';
		if($salesman)
			$where .= ' and tot.provider_id = '.$salesman;

		$query = 'SELECT count(*) as "count" FROM
								 (SELECT id, product_id, im_ex, date_time, provider_id FROM '.$prefix.'products_im_ex_total
								  UNION
								  SELECT im_ex.id, im_ex.product_id, im_ex.im_ex, im_ex.date_time, im_ex.provider_id FROM '.$prefix.'products_im_ex as im_ex
								  LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								  WHERE t.id is null) as tot
							 LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) as p_id on p_id.p_id = tot.product_id
							 WHERE tot.im_ex = '.(int) $im_ex.$where;

		return $this->db->query($query)->row();
	}

	function goods_movement_list($from, $count, $product_id, $start_date, $end_date, $category_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if ($product_id)
			$where .= ' and tot.product_id='.$product_id;
		if ($start_date)
			$where .= ' and tot.date_time > "'.$start_date.'"';
		if ($end_date)
			$where .= ' and tot.date_time < "'.$end_date.'"';
		if ($category_id)
			$where .= ' and tot.product_id in (SELECT item_id FROM ali_relations WHERE rel_type_id = 2 and rel_item_id in ('.$category_id.'))';

		$query = ' SELECT r.row_count, tot.product_id, CONCAT(p.title, " ", p.description) as "name", p_id.sku, tot.id, tot.im_price, tot.ex_price, tot.count FROM
								 (SELECT id, product_id, im_price, ex_price, count, im_ex, date_time, entry_name_id FROM '.$prefix.'products_im_ex_total
								  UNION
								  SELECT im_ex.id, im_ex.product_id, im_ex.im_price, im_ex.ex_price, im_ex.count, im_ex.im_ex, im_ex.date_time, im_ex.entry_name_id FROM '.$prefix.'products_im_ex as im_ex
								  LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								  WHERE t.id is null) as tot
							 LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) as p_id on p_id.p_id = tot.product_id
							 LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
								 					WHERE lang_id = '.$lang.') as p on p.p_id = tot.product_id
							 LEFT JOIN (SELECT count(tot.product_id) as row_count, tot.id FROM
														(SELECT id, product_id, im_ex, date_time FROM '.$prefix.'products_im_ex_total
														 UNION
														 SELECT im_ex.id, im_ex.product_id, im_ex.im_ex, im_ex.date_time FROM '.$prefix.'products_im_ex as im_ex
														 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
														 WHERE t.id is null) as tot
													WHERE tot.im_ex = 0
													GROUP BY tot.product_id) as r on r.id = tot.id
							 WHERE tot.im_ex = 0'.$where.'
							 ORDER BY tot.product_id desc
							 LIMIT '.$from.', '.$count;

		return $this->db->query($query)->result();
	}

	function goods_movement_list_all($product_id, $start_date, $end_date, $category_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if($product_id)
			$where .= ' and tot.product_id='.$product_id;
		if($start_date)
			$where .= ' and tot.date_time > "'.$start_date.'"';
		if($end_date)
			$where .= ' and tot.date_time < "'.$end_date.'"';
		if($category_id)
			$where .= ' and tot.product_id in (SELECT item_id FROM ali_relations WHERE rel_type_id = 2 and rel_item_id in ('.$category_id.'))';

		$query = ' SELECT r.row_count, CONCAT(p.title, " - ", p.description) as "name", p_id.sku, tot.id, tot.im_price, tot.ex_price, tot.count FROM
								 (SELECT id, product_id, im_price, ex_price, count, im_ex, date_time, entry_name_id FROM '.$prefix.'products_im_ex_total
								  UNION
								  SELECT im_ex.id, im_ex.product_id, im_ex.im_price, im_ex.ex_price, im_ex.count, im_ex.im_ex, im_ex.date_time, im_ex.entry_name_id FROM '.$prefix.'products_im_ex as im_ex
								  LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								  WHERE t.id is null) as tot
							 LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) as p_id on p_id.p_id = tot.product_id
							 LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
								 					WHERE lang_id = '.$lang.') as p on p.p_id = tot.product_id
							 LEFT JOIN (SELECT count(tot.product_id) as row_count, tot.id FROM
														(SELECT id, product_id, im_ex, date_time FROM '.$prefix.'products_im_ex_total
														 UNION
														 SELECT im_ex.id, im_ex.product_id, im_ex.im_ex, im_ex.date_time FROM '.$prefix.'products_im_ex as im_ex
														 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
														 WHERE t.id is null) as tot
													WHERE tot.im_ex = 0
													GROUP BY tot.product_id) as r on r.id = tot.id
							 WHERE tot.im_ex = 0'.$where.'
							 ORDER BY tot.product_id asc';

		return $this->db->query($query)->result();
	}

	function goods_movement_list_rows($product_id, $start_date, $end_date, $category_id)
	{
		$prefix = $this->db->dbprefix;

		$where = '';

		if($product_id)
			$where .= ' and tot.product_id='.$product_id;
		if($start_date)
			$where .= ' and tot.date_time > "'.$start_date.'"';
		if($end_date)
			$where .= ' and tot.date_time < "'.$end_date.'"';
		if($category_id)
			$where .= ' and tot.product_id in (SELECT item_id FROM ali_relations WHERE rel_type_id = 2 and rel_item_id in ('.$category_id.'))';

		$query = 'SELECT count(*) as "count" FROM
								 (SELECT id, product_id, im_ex, date_time FROM '.$prefix.'products_im_ex_total
								  UNION
								  SELECT im_ex.id, im_ex.product_id, im_ex.im_ex, im_ex.date_time FROM '.$prefix.'products_im_ex as im_ex
								  LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								  WHERE t.id is null) as tot
							 LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) as p_id on p_id.p_id = tot.product_id
							 WHERE tot.im_ex = 0'.$where;

		return $this->db->query($query)->row();
	}

	function goods_movement_list_inside($product_id, $start_date, $end_date, $category_id)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if($product_id)
			$where .= ' and tot.product_id='.$product_id;
		if($start_date)
			$where .= ' and tot.date_time > "'.$start_date.'"';
		if($end_date)
			$where .= ' and tot.date_time < "'.$end_date.'"';
		if($category_id)
			$where .= ' and tot.product_id in (SELECT item_id FROM ali_relations WHERE rel_type_id = 2 and rel_item_id in ('.$category_id.'))';

		$query = 'SELECT rel.import_id, tot.count, tot.entry_name_id FROM
								(SELECT id, product_id, count, im_ex, date_time, entry_name_id FROM '.$prefix.'products_im_ex_total
                 UNION
                 SELECT im_ex.id, im_ex.product_id, im_ex.count, im_ex.im_ex, im_ex.date_time, im_ex.entry_name_id FROM '.$prefix.'products_im_ex as im_ex
                 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
                 WHERE t.id is null) as tot
							LEFT JOIN (SELECT import_id, export_id FROM '.$prefix.'products_im_ex_rel) as rel on rel.export_id = tot.id
							WHERE tot.im_ex = 1'.$where;

		return $this->db->query($query)->result();
	}

	function action_records($from, $count, $product_id, $start_date, $end_date, $category_id, $user_name, $action_name, $lang)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if ($product_id)
			$where .= ' and iel.product_id='.$product_id;
		if ($start_date)
			$where .= ' and iel.date_time > "'.$start_date.'"';
		if ($end_date)
			$where .= ' and iel.date_time < "'.$end_date.'"';
		if ($category_id)
			$where .= ' and iel.product_id in (SELECT item_id FROM ali_relations WHERE rel_type_id = 2 and rel_item_id in ('.$category_id.'))';
		if ($user_name)
			$where .= ' and iel.user_id = '.$user_name;
		if ($action_name)
			$where .= ' and iel.action_name = "'.$action_name.'"';

		$query = 'SELECT iel.im_ex, us.name as "user", e.entry_name, ex.export_name, u.lastname as "buyer", s.fullname as "salesman",
										 m.title as "measure", w.name as "warehouse", p_id.sku, CONCAT(p.title, " - ", p.description) as "product_name",
										 iel.im_price, iel.ex_price, iel.count, iel.date_time, iel.contract_number, iel.check_number, iel.action_time, iel.action_name FROM '.$prefix.'products_log as iel
							LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) as p_id on p_id.p_id = iel.product_id
							LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
												 WHERE lang_id = '.$lang.') as p on p.p_id = iel.product_id
							LEFT JOIN (SELECT warehouse_id, name FROM '.$prefix.'warehouses
												 WHERE lang_id = '.$lang.') as w on w.warehouse_id = iel.warehouse_id
							LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
												 WHERE lang_id = '.$lang.') as m on m.measure_id = iel.measure_id
							LEFT JOIN (SELECT id, fullname FROM '.$prefix.'salesmen) as s on s.id = iel.provider_id
							LEFT JOIN (SELECT user_id, lastname FROM '.$prefix.'site_users) as u on u.user_id = iel.provider_id
							LEFT JOIN (SELECT entry_name_id, entry_name FROM '.$prefix.'entry_name
												 WHERE lang_id = '.$lang.') as e on e.entry_name_id = iel.entry_name_id
						  LEFT JOIN (SELECT export_name_id, export_name FROM '.$prefix.'export_name
												 WHERE lang_id = '.$lang.') as ex on ex.export_name_id = iel.entry_name_id
							LEFT JOIN (SELECT id, name FROM '.$prefix.'users) as us on us.id = iel.user_id
							WHERE 1'.$where.'
							LIMIT '.$from.', '.$count;

		return $this->db->query($query)->result();
	}

	function action_records_rows($product_id, $start_date, $end_date, $category_id, $user_name, $action_name)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if ($product_id)
			$where .= ' and iel.product_id='.$product_id;
		if ($start_date)
			$where .= ' and iel.date_time > "'.$start_date.'"';
		if ($end_date)
			$where .= ' and iel.date_time < "'.$end_date.'"';
		if ($category_id)
			$where .= ' and iel.product_id in (SELECT item_id FROM ali_relations WHERE rel_type_id = 2 and rel_item_id in ('.$category_id.'))';
		if ($user_name)
			$where .= ' and iel.user_id = '.$user_name;
		if ($action_name)
			$where .= ' and iel.action_name = "'.$action_name.'"';

		$query = 'SELECT count(*) as "count" FROM '.$prefix.'products_log as iel
							WHERE 1'.$where;

		return $this->db->query($query)->row();
	}

	function get_inventory($p_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$where = $p_id?' and im_ex.product_id in ('.$p_id.')':'';

		$query = 'SELECT yek.sku, yek.product_name, SUM(yek.count) as "count" FROM
								(SELECT im_ex.product_id, p_id.sku, concat(p.title, " - ", p.description) as "product_name", (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count" FROM '.$prefix.'products_im_ex as im_ex
								LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
													 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
								LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) as p_id on p_id.p_id = im_ex.product_id
	 							LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
	 												 WHERE lang_id = '.$lang.') as p on p.p_id = im_ex.product_id
								WHERE im_ex.im_ex = 0'.$where.'
								GROUP BY im_ex.id) as yek
							GROUP BY yek.product_id';

		return $this->db->query($query)->result();
	}
}
