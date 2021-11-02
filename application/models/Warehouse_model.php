<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Warehouse_model extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }
  /*****warehouses Start******/
	function warehouses($filter)
	{
		$param = "";
		$prefix = $this->db->dbprefix;

		if(isset($filter["name"]) && @$filter["name"]==TRUE)
		{
			$param = " AND warehouse.name like '%".$filter["name"]."%' ";
		}

		$sql ="SELECT * FROM(SELECT b.name, b.lang_id, b_id.warehouse_id, b_id.order_by, b_id.active from ".$prefix."warehouses_id as b_id LEFT JOIN(select * from ".$prefix."warehouses as b where b.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."warehouses as b1 where b1.lang_id=1 AND b1.warehouse_id not in(select warehouse_id from ".$prefix."warehouses as b3 where b3.lang_id=".$this->session->userdata("lang_id").")) as b on b.warehouse_id=b_id.warehouse_id where b_id.deleted=0) as warehouse WHERE 1=1 ".$param;

		$total = $this->db->query("SELECT count(*) as count_rows FROM (".$sql.") as t")->row();
		$data["total_row"] = $total->count_rows;

		$sql = $sql." ORDER BY warehouse.name ASC LIMIT ".$filter["from"].", ".$filter["end"];

		$data["list"] = $this->db->query($sql)->result();
		return $data;
	}
	function edit_warehouse($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT b.*, b_id.active from ".$prefix."warehouses as b LEFT JOIN ".$prefix."warehouses_id as b_id on b_id.warehouse_id=b.warehouse_id where b_id.deleted=0 and b_id.warehouse_id=".$id)->result_array();
	}
	/*****warehouses End******/
  function warehouse_id()
  {
    $param = "";
    $prefix = $this->db->dbprefix;
    return $this->db->query("SELECT warehouses.*, w_id.active from ".$prefix."warehouses_id as w_id LEFT JOIN(select * from ".$prefix."warehouses as w where w.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."warehouses as w1 where w1.lang_id=1 AND w1.warehouse_id not in(select warehouse_id from ".$prefix."warehouses as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as warehouses on warehouses.warehouse_id=w_id.warehouse_id where w_id.deleted=0 and w_id.active=1")->result();
  }

	function add_entry_name($entry_name)
	{
		$prefix = $this->db->dbprefix;
		$result = false;
		$id = $this->db->query('SELECT if(isnull(MAX(entry_name_id)), 1, MAX(entry_name_id) + 1) AS "id" FROM '.$prefix.'entry_name')->row()->id;

		for($i=0; $i<count($entry_name); $i++)
		{
			$query = 'INSERT INTO '.$prefix.'entry_name (entry_name, lang_id, entry_name_id) VALUES ("'.$entry_name[$i].'", '.($i+1).', '.$id.')';

			if($this->db->query($query))
				$result = true;
			else
				$result = false;
		}

		return $result;
	}

	function entry_type_list($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT * FROM '.$prefix.'entry_name WHERE lang_id = '.$lang;

		return $this->db->query($query)->result();
	}

	function delete_entry_name($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'DELETE FROM '.$prefix.'entry_name WHERE entry_name_id = '.$id;

		if($this->db->query($query))
			return true;
		else
			return false;
	}

	function add_export_name($export_name, $buyer_id, $contract_number)
	{
		$prefix = $this->db->dbprefix;
		$result = false;
		$id = $this->db->query('SELECT if(isnull(MAX(export_name_id)), 1, MAX(export_name_id) + 1) AS "id" FROM '.$prefix.'export_name')->row()->id;

		for($i=0; $i<count($export_name); $i++)
		{
			$query = 'INSERT INTO '.$prefix.'export_name (export_name, lang_id, export_name_id, buyer_id, contract_number) VALUES ("'.$export_name[$i].'", '.($i+1).', '.$id.', '.$buyer_id.', '.$contract_number.')';

			if($this->db->query($query))
				$result = true;
			else
				$result = false;
		}

		return $result;
	}

	function export_type_list($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT * FROM '.$prefix.'export_name WHERE lang_id = '.$lang;

		return $this->db->query($query)->result();
	}

	function delete_export_name($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'DELETE FROM '.$prefix.'export_name WHERE export_name_id = '.$id;

		if($this->db->query($query))
			return true;
		else
			return false;
	}

	function salesman_list()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT * FROM '.$prefix.'salesmen';

		return $this->db->query($query)->result();
	}

	function insert_item($vars, $table_name)
	{
		if ($this->db->insert($table_name, $vars))
			return true;
		else
			return false;
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

	function delete_item($where, $table_name)
	{
		$this->db->where($where);
		return $this->db->delete($table_name);
	}

	function import_contracts_list($from, $count)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT ic.*, s.fullname FROM '.$prefix.'import_contracts AS ic
							LEFT JOIN (SELECT id, fullname FROM '.$prefix.'salesmen) as s on s.id=ic.salesman_id
							LIMIT '.$from.', '.$count;

		return $this->db->query($query)->result();
	}

	function import_contracts_list_rows()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT count(*) as "count" FROM '.$prefix.'import_contracts';

		return $this->db->query($query)->row();
	}

	function get_salesmen()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT id, fullname FROM '.$prefix.'salesmen';

		return $this->db->query($query)->result();
	}

	function get_buyers()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT user_id, company_name FROM '.$prefix.'site_users WHERE status = 1';

		return $this->db->query($query)->result();
	}

	function insert_unique_item($vars, $table_name)
	{
		$this->db->db_debug = false;
		if(!$this->db->insert($table_name, $vars))
		{
		   $error = $this->db->error();
		   if($error['code'] == 1062)
		   	return false;
		} else {
			return true;
		}
		$this->db->db_debug = true;
	}

	function check_import_contract($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT id FROM '.$prefix.'products_im_ex WHERE im_ex = 0 and contract_number="'.$id.'"';

		return $this->db->query($query)->result();
	}

	function check_export_contract($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT id FROM '.$prefix.'products_im_ex WHERE im_ex = 1 and contract_number="'.$id.'"';

		return $this->db->query($query)->result();
	}

	function check_salesman($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT id FROM '.$prefix.'import_contracts WHERE salesman_id ='.$id;

		return $this->db->query($query)->result();
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

	function select_where($select, $where, $table_name, $order_by = false)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->from($table_name);

		if($order_by)
			$this->db->order_by($order_by[0], $order_by[1]);

		return $this->db->get()->result();
	}

	function get_measure_price($product_id, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT p_id.price, m.title as "measure" FROM '.$prefix.'products_id as p_id
							LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
												 WHERE lang_id = '.$lang.') as m on m.measure_id = p_id.measure_id
							WHERE p_id.p_id = '.$product_id;

		return $this->db->query($query)->result();
	}

	function get_import_contracts($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT id, contract_number FROM '.$prefix.'import_contracts WHERE salesman_id ='.$id;

		return $this->db->query($query)->result();
	}

	function check_export_name($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT id FROM '.$prefix.'products_im_ex WHERE im_ex = 1 and entry_name_id ='.$id;

		return $this->db->query($query)->result();
	}

	function check_entry_name($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT id FROM '.$prefix.'products_im_ex WHERE im_ex = 0 and entry_name_id ='.$id;

		return $this->db->query($query)->result();
	}

	function export_contracts_list($from, $count)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT ec.*, u.lastname, u.company_name FROM '.$prefix.'export_contracts AS ec
							LEFT JOIN (SELECT user_id, lastname, company_name FROM '.$prefix.'site_users) as u on u.user_id=ec.buyer_id
							LIMIT '.$from.', '.$count;

		return $this->db->query($query)->result();
	}

	function export_contracts_list_rows()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT count(*) as "count" FROM '.$prefix.'export_contracts';

		return $this->db->query($query)->row();
	}

	// function export_list($from, $count, $lang)
	// {
	// 	$prefix = $this->db->dbprefix;
	//
	// 	$query = 'SELECT ec.contract_number as "contr_number", pl.*, CONCAT(p.title, " - ", p.description) AS "product_name", w.name AS "warehouse", u.lastname AS "buyer", en.export_name, m.title FROM '.$prefix.'products_im_ex AS pl
	// 						LEFT JOIN (SELECT id, contract_number FROM '.$prefix.'export_contracts) as ec on ec.id = pl.contract_number
	// 						LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
	// 											 WHERE lang_id = '.$lang.') as p on p.p_id = pl.product_id
	// 					  LEFT JOIN (SELECT warehouse_id, name FROM '.$prefix.'warehouses
	// 											 WHERE lang_id = '.$lang.') as w on w.warehouse_id = pl.warehouse_id
	// 						LEFT JOIN (SELECT user_id, lastname FROM '.$prefix.'site_users) as u on u.user_id = pl.provider_id
	// 						LEFT JOIN (SELECT export_name_id, export_name FROM '.$prefix.'export_name
	// 											 WHERE lang_id = '.$lang.') as en on en.export_name_id = pl.entry_name_id
	// 						LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
	// 											 WHERE lang_id = '.$lang.') as m on m.measure_id = pl.measure_id
	// 						WHERE im_ex = 1
	// 						LIMIT '.$from.', '.$count;
	//
	// 	return $this->db->query($query)->result();
	// }
	//
	// function export_list_rows()
	// {
	// 	$prefix = $this->db->dbprefix;
	// 	$query = 'SELECT count(*) as "count" FROM '.$prefix.'products_im_ex WHERE im_ex = 1';
	//
	// 	return $this->db->query($query)->row();
	// }

	function get_warehouses($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT wi.warehouse_id, w.name FROM '.$prefix.'warehouses_id as wi
							LEFT JOIN (SELECT warehouse_id, name FROM '.$prefix.'warehouses
												 WHERE lang_id='.$lang.') as w on w.warehouse_id = wi.warehouse_id
							WHERE active=1 and deleted=0';

		return $this->db->query($query)->result();
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

	function get_export_name($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT export_name, export_name_id, buyer_id, contract_number FROM '.$prefix.'export_name WHERE lang_id = '.$lang;

		return $this->db->query($query)->result();
	}

	function get_import_prices($product_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", im_ex.id, im_ex.im_price, p_id.price as "ex_price", im_ex.measure_id, m.title, im_ex.expiration_date FROM '.$prefix.'products_im_ex as im_ex
							LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures WHERE lang_id = '.$lang.') as m on m.measure_id = im_ex.measure_id
							LEFT JOIN (SELECT p_id, price FROM '.$prefix.'products_id) as p_id on p_id.p_id = im_ex.product_id
							LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
												 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
							WHERE im_ex.im_ex = 0 and im_ex.product_id = '.$product_id.'
							GROUP BY im_ex.id';

		return $this->db->query($query)->result();
	}

	function get_for_do_export($im_ex_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", im_ex.id, im_ex.im_price, p_id.price as "ex_price", im_ex.measure_id, im_ex.warehouse_id, im_ex.expiration_date FROM '.$prefix.'products_im_ex as im_ex
							LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
												 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
							LEFT JOIN (SELECT p_id, price FROM '.$prefix.'products_id) as p_id on p_id.p_id = im_ex.product_id
							WHERE im_ex.im_ex = 0 and im_ex.id = '.$im_ex_id.'
							GROUP BY im_ex.id';

		return $this->db->query($query)->result();
	}

	function get_export_contracts($buyer_id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT id, contract_number FROM '.$prefix.'export_contracts WHERE buyer_id = '.$buyer_id;

		return $this->db->query($query)->result();
	}

	function update($table_name, $array, $where)
  {
    $this->db->where($where);
    if ($this->db->update($table_name, $array))
      return true;
    else
      return false;
  }

	function update_table($table_name, $where, $vars)
	{
		$this->db->where($where);
		return $this->db->update($table_name, $vars);
	}

	function update_export($id)
	{
		$prefix = $this->db->dbprefix;

		$query = 'INSERT INTO '.$prefix.'products_log (im_ex_id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, action_time, action_name)
							SELECT id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, "'.date("Y-m-d H:i:s").'", "Update export product" FROM '.$prefix.'products_im_ex WHERE id='.$id;

		return $this->db->query($query);
	}

	function delete_export_log($id)
	{
		$prefix = $this->db->dbprefix;

		$query = 'INSERT INTO '.$prefix.'products_log (im_ex_id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, action_time, action_name)
							SELECT id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, "'.date("Y-m-d H:i:s").'", "Delete export product" FROM '.$prefix.'products_im_ex WHERE id='.$id;

		return $this->db->query($query);
	}

	function check_count($im_ex_id)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count" FROM '.$prefix.'products_im_ex as im_ex
							LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
												 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
							WHERE im_ex.id = '.$im_ex_id.'
							GROUP BY im_ex.id';

		return $this->db->query($query)->row();
	}

	function get_import_products($check_number, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT p_id.sku, concat(p.title, " - ", p.description) as "product_name", m.title as "measure", im_ex.* FROM
								(SELECT im_ex_tot.*, 0 as "can_change" FROM '.$prefix.'products_im_ex_total as im_ex_tot
								 UNION
								 SELECT im_ex.*, 1 as "can_change" FROM '.$prefix.'products_im_ex as im_ex
								 WHERE im_ex.id > (SELECT MAX(id) FROM '.$prefix.'products_im_ex_total)) AS im_ex
							LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) AS p_id ON p_id.p_id = im_ex.product_id
							LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
												 WHERE lang_id = '.$lang.') AS p ON p.p_id = im_ex.product_id
							LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
												 WHERE lang_id = '.$lang.') AS m ON m.measure_id = im_ex.measure_id
							WHERE im_ex.check_number = '.$check_number.' and im_ex = 0';

		return $this->db->query($query)->result();
	}

	function get_export_products($check_number, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT (mc.count + im_ex.count) as "max_count", p_id.sku, concat(p.title, " - ", p.description) as "product_name", m.title as "measure", im_ex.* FROM
								(SELECT im_ex_tot.*, 0 as "can_change" FROM '.$prefix.'products_im_ex_total as im_ex_tot
								 UNION
								 SELECT im_ex.*, 1 as "can_change" FROM '.$prefix.'products_im_ex as im_ex
								 WHERE im_ex.id > (SELECT MAX(id) FROM '.$prefix.'products_im_ex_total)) AS im_ex
							LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) AS p_id ON p_id.p_id = im_ex.product_id
							LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
												 WHERE lang_id = '.$lang.') AS p ON p.p_id = im_ex.product_id
							LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
												 WHERE lang_id = '.$lang.') AS m ON m.measure_id = im_ex.measure_id
							LEFT JOIN (SELECT ms.count, pr1.export_id FROM '.$prefix.'products_im_ex_rel as pr1
												 LEFT JOIN (SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", im_ex.id FROM '.$prefix.'products_im_ex as im_ex
					 												 LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
					 																	  LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id
					 																	 ) as pr on pr.import_id = im_ex.id
					 												 WHERE im_ex.im_ex = 0
					 												 GROUP BY im_ex.id) AS ms on ms.id = pr1.import_id
												) as mc on mc.export_id = im_ex.id
							WHERE im_ex.check_number = '.$check_number.' and im_ex = 1';

		return $this->db->query($query)->result();
	}

	function get_max_count($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT (mc.count + im_ex.count) as "max_count" FROM
								(SELECT im_ex_tot.*, 0 as "can_change" FROM '.$prefix.'products_im_ex_total as im_ex_tot
								 UNION
								 SELECT im_ex.*, 1 as "can_change" FROM '.$prefix.'products_im_ex as im_ex
								 WHERE im_ex.id > (SELECT MAX(id) FROM '.$prefix.'products_im_ex_total)
							 	) AS im_ex
							LEFT JOIN (SELECT ms.count, pr1.export_id FROM '.$prefix.'products_im_ex_rel as pr1
 												 LEFT JOIN (SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", im_ex.id FROM '.$prefix.'products_im_ex as im_ex
 																	  LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
 																		  				 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id
 																			  			) as pr on pr.import_id = im_ex.id
 																	  WHERE im_ex.im_ex = 0
 																		GROUP BY im_ex.id) AS ms on ms.id = pr1.import_id
 											  ) as mc on mc.export_id = im_ex.id
							WHERE im_ex.id = '.$id;

		return $this->db->query($query)->row();
	}

	function import_list($from, $end, $check_number, $warehouse_id, $import_type, $provider_id, $contract_number, $import_date, $product_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		$where .= $check_number?' and onum.order_number = '.$check_number:'';
		$where .= $warehouse_id?' and im_ex.warehouse_id = '.$warehouse_id:'';
		$where .= $import_type?' and im_ex.entry_name_id = '.$import_type:'';
		$where .= $provider_id?' and im_ex.provider_id = '.$provider_id:'';
		$where .= $contract_number?' and onum.contract = '.$contract_number:'';
		$where .= $import_date?' and onum.date_time = "'.$import_date.'"':'';
		$where .= $product_id?' and im_ex.product_id = '.$product_id:'';

		$query = 'SELECT w.name as "warehouse", e.entry_name, p.fullname as "provider", onum.order_number, onum.date_time, c.contract_number, im_ex.can_delete FROM
								(SELECT check_number, product_id, warehouse_id, entry_name_id, provider_id, contract_number, 0 as "can_delete" FROM '.$prefix.'products_im_ex_total
								 UNION
								 SELECT check_number, product_id, warehouse_id, entry_name_id, provider_id, contract_number, 1 as "can_delete" FROM '.$prefix.'products_im_ex as im_ex
								 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								 WHERE t.id is null) as im_ex
							LEFT JOIN(SELECT order_status_id, order_number, date_time, contract FROM '.$prefix.'order_numbers) AS onum on onum.order_number = im_ex.check_number
							LEFT JOIN (SELECT warehouse_id, name FROM '.$prefix.'warehouses
												 WHERE lang_id = '.$lang.') as w on w.warehouse_id = im_ex.warehouse_id
						  LEFT JOIN (SELECT entry_name, entry_name_id FROM '.$prefix.'entry_name
												 WHERE lang_id = '.$lang.') as e on e.entry_name_id = im_ex.entry_name_id
						  LEFT JOIN (SELECT id, fullname FROM '.$prefix.'salesmen) as p on p.id = im_ex.provider_id
							LEFT JOIN (SELECT id, contract_number FROM '.$prefix.'import_contracts) as c on c.id = im_ex.contract_number
							WHERE onum.order_status_id = 20'.$where.'
							GROUP BY im_ex.check_number
							ORDER BY onum.order_number DESC
							LIMIT '.$from.', '.$end;

		return $this->db->query($query)->result();
	}

	function export_list($from, $end, $check_number, $warehouse_id, $export_type, $buyer, $contract_number, $export_date, $product_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if($check_number)
			$where .= ' and onum.order_number = '.$check_number;
		if($warehouse_id)
			$where .= ' and im_ex.warehouse_id = '.$warehouse_id;
		if($export_type)
			$where .= ' and im_ex.entry_name_id = '.$export_type;
		if($buyer)
			$where .= ' and im_ex.provider_id = '.$buyer;
		if($contract_number)
			$where .= ' and onum.contract = '.$contract_number;
		if($export_date)
			$where .= ' and onum.date_time = "'.$export_date.'"';
		$where .= $product_id?' and im_ex.product_id = '.$product_id:'';

		$query = 'SELECT w.name as "warehouse", e.export_name, p.company_name as "provider", onum.order_number, onum.date_time, c.contract_number, im_ex.can_delete FROM
								(SELECT check_number, product_id, warehouse_id, entry_name_id, provider_id, contract_number, 0 as "can_delete" FROM '.$prefix.'products_im_ex_total
								 UNION
								 SELECT check_number, product_id, warehouse_id, entry_name_id, provider_id, contract_number, 1 as "can_delete" FROM '.$prefix.'products_im_ex as im_ex
								 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								 WHERE t.id is null) as im_ex
							LEFT JOIN(SELECT order_status_id, order_number, date_time, contract FROM '.$prefix.'order_numbers) AS onum on onum.order_number = im_ex.check_number
							LEFT JOIN (SELECT warehouse_id, name FROM '.$prefix.'warehouses
												 WHERE lang_id = '.$lang.') as w on w.warehouse_id = im_ex.warehouse_id
						  LEFT JOIN (SELECT export_name, export_name_id FROM '.$prefix.'export_name
												 WHERE lang_id = '.$lang.') as e on e.export_name_id = im_ex.entry_name_id
						  LEFT JOIN (SELECT user_id, company_name FROM '.$prefix.'site_users) as p on p.user_id = im_ex.provider_id
							LEFT JOIN (SELECT id, contract_number FROM '.$prefix.'export_contracts) as c on c.id = im_ex.contract_number
							WHERE onum.order_status_id in (12,15,25)'.$where.'
							GROUP BY im_ex.check_number
							ORDER BY onum.order_number DESC
							LIMIT '.$from.', '.$end;

		return $this->db->query($query)->result();
	}

	function import_list_rows($check_number, $warehouse_id, $import_type, $provider_id, $contract_number, $import_date, $product_id)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if($check_number)
			$where .= ' and onum.order_number = '.$check_number;
		if($warehouse_id)
			$where .= ' and im_ex.warehouse_id = '.$warehouse_id;
		if($import_type)
			$where .= ' and im_ex.entry_name_id = '.$import_type;
		if($provider_id)
			$where .= ' and im_ex.provider_id = '.$provider_id;
		if($contract_number)
			$where .= ' and onum.contract = '.$contract_number;
		if($import_date)
			$where .= ' and onum.date_time = "'.$import_date.'"';
		$where .= $product_id?' and im_ex.product_id = '.$product_id:'';

		$query = 'SELECT count(*) as "count" FROM '.$prefix.'order_numbers AS onum
							LEFT JOIN (SELECT check_number, product_id, warehouse_id, entry_name_id, provider_id FROM '.$prefix.'products_im_ex
												 LIMIT 1) as im_ex ON im_ex.check_number = onum.order_number
							WHERE order_status_id = 20'.$where;

		return $this->db->query($query)->row();
	}

	function export_list_rows($check_number, $warehouse_id, $export_type, $buyer, $contract_number, $export_date, $product_id)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if($check_number)
			$where .= ' and onum.order_number = '.$check_number;
		if($warehouse_id)
			$where .= ' and im_ex.warehouse_id = '.$warehouse_id;
		if($export_type)
			$where .= ' and im_ex.entry_name_id = '.$export_type;
		if($buyer)
			$where .= ' and im_ex.provider_id = '.$buyer;
		if($contract_number)
			$where .= ' and onum.contract = '.$contract_number;
		if($export_date)
			$where .= ' and onum.date_time = "'.$export_date.'"';
		$where .= $product_id?' and im_ex.product_id = '.$product_id:'';

		$query = 'SELECT count(*) as "count" FROM '.$prefix.'order_numbers AS onum
							LEFT JOIN (SELECT check_number, product_id, warehouse_id, entry_name_id, provider_id FROM '.$prefix.'products_im_ex
												 LIMIT 1) as im_ex ON im_ex.check_number = onum.order_number
							WHERE order_status_id in (12,15,25)'.$where;

		return $this->db->query($query)->row();
	}

	function insert_log($order_number, $action_name)
	{
		$prefix = $this->db->dbprefix;
		$query = 'INSERT INTO '.$prefix.'products_log (im_ex_id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, contract_number, check_number, expiration_date, action_time, action_name)
							SELECT id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, contract_number, check_number, expiration_date, "'.date("Y-m-d H:i:s").'", "'.$action_name.'" FROM '.$prefix.'products_im_ex WHERE check_number='.$order_number;

		return $this->db->query($query);
	}

	function insert_log_with_id($id, $action_name)
	{
		$prefix = $this->db->dbprefix;
		$query = 'INSERT INTO '.$prefix.'products_log (im_ex_id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, contract_number, check_number, expiration_date, action_time, action_name)
							SELECT id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, contract_number, check_number, expiration_date, "'.date("Y-m-d H:i:s").'", "'.$action_name.'" FROM '.$prefix.'products_im_ex WHERE id='.$id;

		return $this->db->query($query);
	}

	function expiration_date_list($from, $end, $expiration_date, $lang)
	{
		$prefix = $this->db->dbprefix;
		$where = '';
		if ($expiration_date)
			$where .= ' and im_ex.expiration_date < "'.$expiration_date.'"';

		$query = 'SELECT s.fullname as "provider", en.entry_name, p_id.sku, concat(p.title, " - ", p.description) as "product_name", m.title as "measure", im_ex.count, im_ex.im_price, im_ex.ex_price, im_ex.expiration_date FROM '.$prefix.'products_im_ex as im_ex
							LEFT JOIN (SELECT p_id, sku FROM '.$prefix.'products_id) AS p_id ON p_id.p_id = im_ex.product_id
							LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
												 WHERE lang_id = '.$lang.') AS p ON p.p_id = im_ex.product_id
							LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
												 WHERE lang_id = '.$lang.') AS m ON m.measure_id = im_ex.measure_id
							LEFT JOIN (SELECT id, fullname FROM '.$prefix.'salesmen) as s on s.id = im_ex.provider_id
							LEFT JOIN (SELECT entry_name_id, entry_name FROM '.$prefix.'entry_name
												 WHERE lang_id = '.$lang.') as en on en.entry_name_id = im_ex.entry_name_id
							WHERE im_ex = 0'.$where.'
							ORDER BY im_ex.expiration_date desc
							LIMIT '.$from.', '.$end;

		return $this->db->query($query)->result();
	}

	function expiration_date_list_rows($expiration_date)
	{
		$prefix = $this->db->dbprefix;
		$where = '';
		if ($expiration_date)
			$where .= ' and im_ex.expiration_date < "'.$expiration_date.'"';

		$query = 'SELECT count(*) as "count" FROM '.$prefix.'products_im_ex as im_ex
							WHERE im_ex = 0'.$where;

		return $this->db->query($query)->row();
	}

	function get_max_id($table_name)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT (MAX(id)+1) as "id" FROM '.$prefix.$table_name;

		return $this->db->query($query)->row()->id;
	}

	function monthly_change_table_query()
	{
		$query = 'INSERT INTO ali_products_im_ex_total
							SELECT * FROM ali_products_im_ex AS im_ex
							WHERE  im_ex.id > (SELECT MAX(id) FROM ali_products_im_ex_total);

			INSERT INTO ali_products_im_ex_tmp
			SELECT lst.* FROM
				 (SELECT im_ex.id, im_ex.product_id, im_ex.color_id, im_ex.mn_id, im_ex.im_price, im_ex.ex_price, im_ex.warehouse_id,
					 			(im_ex.count - if(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", im_ex.measure_id,
								im_ex.im_ex, im_ex.date_time, im_ex.provider_id, im_ex.entry_name_id, im_ex.user_id, im_ex.contract_number, im_ex.check_number, im_ex.expiration_date
				 FROM ali_products_im_ex AS im_ex
				 LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM ali_products_im_ex_rel as pr
				 					  LEFT JOIN (SELECT id, count FROM ali_products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
				 WHERE im_ex.im_ex = 0
				 GROUP BY im_ex.id) AS lst
			WHERE lst.count != 0;

			DELETE FROM ali_products_im_ex;

			INSERT INTO ali_products_im_ex
			SELECT * FROM ali_products_im_ex_tmp;

			UPDATE ali_products_id AS p_id
			LEFT JOIN (SELECT DISTINCT(product_id) FROM ali_products_im_ex) AS im_ex on im_ex.product_id = p_id.p_id
			SET p_id.deleted = 1
			WHERE im_ex.product_id is null;

			DELETE FROM ali_products_im_ex_tmp;';

		$query2 = 'SELECT CONCAT(p.title, " - ", p.description) as "name", p_id.sku, tot.id, tot.im_price, tot.ex_price, tot.count FROM
								 (SELECT id, product_id, im_price, ex_price, count, im_ex, date_time, entry_name_id FROM ali_products_im_ex_total
								  UNION
								  SELECT im_ex.id, im_ex.product_id, im_ex.im_price, im_ex.ex_price, im_ex.count, im_ex.im_ex, im_ex.date_time, im_ex.entry_name_id FROM ali_products_im_ex as im_ex
								  LEFT JOIN (SELECT id FROM ali_products_im_ex_total) as t on t.id = im_ex.id
								  WHERE t.id is null) as tot
							 LEFT JOIN (SELECT p_id, sku FROM ali_products_id) as p_id on p_id.p_id = tot.product_id
							 LEFT JOIN (SELECT p_id, title, description FROM ali_products
								 					WHERE lang_id = 2) as p on p.p_id = tot.product_id
							 WHERE tot.im_ex = 0
							 ORDER BY tot.product_id asc';

		$query3 = 'SELECT rel.import_id, tot.* FROM
								 (SELECT id, im_price, ex_price, count, im_ex, date_time, entry_name_id FROM ali_products_im_ex_total
                  UNION
                  SELECT im_ex.id, im_ex.im_price, im_ex.ex_price, im_ex.count, im_ex.im_ex, im_ex.date_time, im_ex.entry_name_id FROM ali_products_im_ex as im_ex
                  LEFT JOIN (SELECT id FROM ali_products_im_ex_total) as t on t.id = im_ex.id
                  WHERE t.id is null) as tot
							 LEFT JOIN (SELECT import_id, export_id FROM ali_products_im_ex_rel) as rel on rel.export_id = tot.id
							 WHERE tot.im_ex = 1';

		$query4 = 'SELECT r.row_count, tot.product_id, tot.im_price, tot.count, tot.date_time, p_id.sku, CONCAT(p.title, " - ", p.description) as "p_name", m.title as "measure", s.fullname as "provider" FROM
								(SELECT id, product_id, im_price, count, im_ex, date_time, provider_id, measure_id FROM ali_products_im_ex_total
								 UNION
								 SELECT im_ex.id, im_ex.product_id, im_ex.im_price, im_ex.count, im_ex.im_ex, im_ex.date_time, im_ex.provider_id, im_ex.measure_id FROM ali_products_im_ex as im_ex
								 LEFT JOIN (SELECT id FROM ali_products_im_ex_total) as t on t.id = im_ex.id
								 WHERE t.id is null) as tot
							 LEFT JOIN (SELECT p_id, sku FROM ali_products_id) as p_id on p_id.p_id = tot.product_id
							 LEFT JOIN (SELECT p_id, title, description FROM ali_products
								 					WHERE lang_id = 2) as p on p.p_id = tot.product_id
							 LEFT JOIN (SELECT measure_id, title FROM ali_measures
							 						WHERE lang_id = 2) as m on m.measure_id = tot.measure_id
							 LEFT JOIN (SELECT id, fullname FROM ali_salesmen) as s on s.id = tot.provider_id
							 LEFT JOIN (SELECT count(tot.product_id) as row_count, tot.id FROM
														(SELECT id, product_id, im_ex, date_time FROM ali_products_im_ex_total
														 UNION
														 SELECT im_ex.id, im_ex.product_id, im_ex.im_ex, im_ex.date_time FROM ali_products_im_ex as im_ex
														 LEFT JOIN (SELECT id FROM ali_products_im_ex_total) as t on t.id = im_ex.id
														 WHERE t.id is null) as tot
													WHERE tot.im_ex = 0
													GROUP BY tot.product_id) as r on r.id = tot.id
							 WHERE tot.im_ex = 0
							 ORDER BY tot.product_id asc';
	}

	function import_product_list($from, $end, $check_number, $import_type, $provider_id, $contract_number, $import_date, $product_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		$where .= $check_number?' and onum.order_number = '.$check_number:'';
		$where .= $import_type?' and im_ex.entry_name_id = '.$import_type:'';
		$where .= $provider_id?' and im_ex.provider_id = '.$provider_id:'';
		$where .= $contract_number?' and onum.contract = '.$contract_number:'';
		$where .= $import_date?' and onum.date_time = "'.$import_date.'"':'';
		$where .= $product_id?' and im_ex.product_id = '.$product_id:'';

		$query = 'SELECT concat(pr.title, if(isnull(pr.description) or pr.description = "", "", concat(" - ", pr.description))) as "product_name", e.entry_name, p.fullname as "provider", onum.order_number, onum.date_time, c.contract_number, im_ex.can_delete FROM
								(SELECT check_number, product_id, date_time, warehouse_id, entry_name_id, provider_id, contract_number, 0 as "can_delete" FROM '.$prefix.'products_im_ex_total
								 UNION
								 SELECT check_number, product_id, date_time, warehouse_id, entry_name_id, provider_id, contract_number, 1 as "can_delete" FROM '.$prefix.'products_im_ex as im_ex
								 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								 WHERE t.id is null) as im_ex
							LEFT JOIN (SELECT p_id, title, description FROM '.$prefix.'products
												 WHERE lang_id = '.$lang.') as pr on pr.p_id = im_ex.product_id
							LEFT JOIN (SELECT order_status_id, order_number, date_time, contract FROM '.$prefix.'order_numbers) AS onum on onum.order_number = im_ex.check_number
						  LEFT JOIN (SELECT entry_name, entry_name_id FROM '.$prefix.'entry_name
												 WHERE lang_id = '.$lang.') as e on e.entry_name_id = im_ex.entry_name_id
						  LEFT JOIN (SELECT id, fullname FROM '.$prefix.'salesmen) as p on p.id = im_ex.provider_id
							LEFT JOIN (SELECT id, contract_number FROM '.$prefix.'import_contracts) as c on c.id = im_ex.contract_number
							WHERE onum.order_status_id = 20'.$where.'
							ORDER BY im_ex.product_id asc, im_ex.date_time desc
							LIMIT '.$from.', '.$end;

		return $this->db->query($query)->result();
	}

	function import_product_list_rows($check_number, $import_type, $provider_id, $contract_number, $import_date, $product_id)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if($check_number)
			$where .= ' and onum.order_number = '.$check_number;
		if($import_type)
			$where .= ' and im_ex.entry_name_id = '.$import_type;
		if($provider_id)
			$where .= ' and im_ex.provider_id = '.$provider_id;
		if($contract_number)
			$where .= ' and onum.contract = '.$contract_number;
		if($import_date)
			$where .= ' and onum.date_time = "'.$import_date.'"';
		$where .= $product_id?' and im_ex.product_id = '.$product_id:'';

		$query = 'SELECT count(*) as "count" FROM
								(SELECT check_number, product_id, entry_name_id, provider_id FROM '.$prefix.'products_im_ex_total
								 UNION
								 SELECT check_number, product_id, entry_name_id, provider_id FROM '.$prefix.'products_im_ex as im_ex
								 LEFT JOIN (SELECT id FROM '.$prefix.'products_im_ex_total) as t on t.id = im_ex.id
								 WHERE t.id is null) as im_ex
							LEFT JOIN (SELECT order_status_id, order_number, date_time, contract FROM '.$prefix.'order_numbers) AS onum on onum.order_number = im_ex.check_number
							WHERE onum.order_status_id = 20'.$where;

		return $this->db->query($query)->row();
	}
}
