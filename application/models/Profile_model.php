<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile_model extends CI_Model
{
	function __construct()
  {
    parent::__construct();
  }
  function registration($vars)
	{
		$this->db->insert("site_users", $vars);
		return $this->db->insert_id();
	}

  function get_shipping($parent_id=0)
	{
		return $this->db->query("WITH RECURSIVE regions AS
		(
		  SELECT cc.region_id, cc.name, cc.price, cc.active, cc.parent_id, 1 AS depth, cc.name AS path
		    FROM (SELECT ci.*, c.name from ali_regions_id as ci LEFT JOIN ali_regions as c on c.region_id=ci.region_id where c.lang_id=".$this->session->userdata("lang_id").") as cc
		    WHERE cc.active=1
		  UNION ALL
		  SELECT c.region_id, c.name, c.price, c.active, c.parent_id, sc.depth + 1, CONCAT(sc.path, ' → ', c.name)
		    FROM regions AS sc
		      JOIN (SELECT ci.*, c.name from ali_regions_id as ci LEFT JOIN ali_regions as c on c.region_id=ci.region_id where c.lang_id=".$this->session->userdata("lang_id").") AS c ON sc.region_id = c.parent_id WHERE c.active=1
		)
		SELECT * FROM regions where parent_id=0 or depth>1 order by path asc")->result();
		/*$prefix = $this->db->dbprefix;
		$sql ="
			SELECT r_id.*, r.name FROM ".$prefix."regions_id as r_id
			LEFT JOIN (SELECT * FROM ".$prefix."regions as r where r.lang_id=".$this->session->userdata("lang_id").") as r on r.region_id=r_id.region_id
			WHERE r_id.parent_id=".$parent_id." and r_id.active=1";
			return $this->db->query($sql)->result(); */
	}
	function get_wishlist($share_id)
	{
		$prefix = $this->db->dbprefix;
		$sql ="select * FROM (
			SELECT w.*, p.title, im_ex.ex_price, c.color_name  FROM ".$prefix."wishlist as w
			LEFT JOIN ".$prefix."products_im_ex as im_ex  on im_ex.id=w.product_id
			LEFT JOIN ".$prefix."products_id as p_id  on p_id.p_id=im_ex.product_id
			LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id").") as p on p.p_id=p_id.p_id
			LEFT JOIN (SELECT * FROM ".$prefix."colors as c where c.lang_id=".$this->session->userdata("lang_id").") as c on c.color_id=im_ex.color_id
			WHERE w.share_id=".$share_id;
	}
	function get_in_basket($order_status_id=8)
	{
		$prefix = $this->db->dbprefix;
		$where = "";
		if($this->session->userdata("user_id"))
			$where = " o.user_id=".$this->session->userdata("user_id");
		if($this->session->userdata("user_id") && $this->session->userdata("tmp_user"))
			$where = $where." OR o.tmp_user_id='".$this->session->userdata("tmp_user")."' ";
		if(!$this->session->userdata("user_id") && $this->session->userdata("tmp_user"))
			$where = " o.tmp_user_id='".$this->session->userdata("tmp_user")."' ";

		$sql ="SELECT * FROM (
			SELECT o.*, p_id.`sku`, p.title as product_title, orn.order_status_id, c.color_name, p_img.img as thumb  FROM ".$prefix."orders as o
			LEFT JOIN ".$prefix."products_im_ex as im_ex  on im_ex.id=o.product_id
			LEFT JOIN ".$prefix."products_id as p_id  on p_id.p_id=o.product_id
			LEFT JOIN ".$prefix."order_numbers as orn  on orn.order_number=o.order_number
			LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id").") as p on p.p_id=o.product_id
			LEFT JOIN (SELECT * FROM ".$prefix."colors as c where c.lang_id=".$this->session->userdata("lang_id").") as c on c.color_id=o.color_id
			LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl
				LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img GROUP BY p_id) tbl1 ON tbl1.p_id = tbl.p_id WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=o.product_id
			WHERE (".$where.")  AND orn.order_status_id=".$order_status_id.") as b";
			//echo $sql;
			return $this->db->query($sql)->result_array();
	}
	function get_order_list($order_number)
	{
		$prefix = $this->db->dbprefix;
		$where = "";
		if($this->session->userdata("user_id"))
			$where = " o.user_id=".$this->session->userdata("user_id");
		if($this->session->userdata("user_id") && $this->session->userdata("tmp_user"))
			$where = $where." OR o.tmp_user_id='".$this->session->userdata("tmp_user")."' ";
		if(!$this->session->userdata("user_id") && $this->session->userdata("tmp_user"))
			$where = " o.tmp_user_id='".$this->session->userdata("tmp_user")."' ";

		$sql ="SELECT * FROM (
			SELECT o.*, p_id.`sku`, p.title as product_title, c.color_name, p_img.img as thumb  FROM ".$prefix."orders as o
			LEFT JOIN ".$prefix."products_im_ex as im_ex  on im_ex.id=o.product_id
			LEFT JOIN ".$prefix."products_id as p_id  on p_id.p_id=o.product_id
			LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id").") as p on p.p_id=o.product_id
			LEFT JOIN (SELECT * FROM ".$prefix."colors as c where c.lang_id=".$this->session->userdata("lang_id").") as c on c.color_id=o.color_id
			LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl
				LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img GROUP BY p_id) tbl1 ON tbl1.p_id = tbl.p_id WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=o.product_id
			WHERE (".$where.")  AND o.order_number=".$order_number.") as b";
			//echo $sql;
			return $this->db->query($sql)->result_array();
	}
	function orders()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		$sql ="

		SELECT  concat_ws(' ', u.lastname, u.firstname, u.middlename) as full_name, orn.order_number, o.id,o.user_id, o.tmp_user_id, orn.order_status_id,  sum(o.`count`) as product_count, sum(o.ex_price) as product_price, o.date_time, os.order_status_title  FROM ".$prefix."orders as o
		LEFT JOIN ".$prefix."order_numbers as orn  on orn.order_number=o.order_number
		LEFT JOIN (select * from ".$prefix."order_status where lang_id=".$this->session->userdata("lang_id").") as os on os.order_status_id=orn.order_status_id
		LEFT JOIN ".$prefix."site_users as u on u.user_id=o.user_id
		LEFT JOIN ".$prefix."order_status_id as os_id on os_id.order_status_id=orn.order_status_id
		WHERE (o.user_id=".($this->session->userdata("user_id")?$this->session->userdata("user_id"):0)." OR o.tmp_user_id='".$this->session->userdata("tmp_user")."') AND orn.order_status_id not in(8,9)
		Group by o.order_number ";

		$data["sql"] = $sql;

		$sql = $sql." order by o.id DESC ";

		return $this->db->query($sql)->result();

	}
	function get_in_wishlist()
	{
		$prefix = $this->db->dbprefix;
		$where = "";
		if($this->session->userdata("user_id"))
			$where = " o.user_id=".$this->session->userdata("user_id");
		else
			$where = " o.tmp_user_id='".$this->session->userdata("tmp_user")."' ";

		$sql ="SELECT * FROM (
			SELECT o.*, orn.order_status_id, p_id.`sku`, p.title as product_title, c.color_name, p_img.img as thumb  FROM ".$prefix."orders as o
			LEFT JOIN ".$prefix."products_im_ex as im_ex  on im_ex.id=o.product_id
			LEFT JOIN ".$prefix."products_id as p_id  on p_id.p_id=o.product_id
			LEFT JOIN ".$prefix."order_numbers as orn  on orn.order_number=o.order_number
			LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id").") as p on p.p_id=o.product_id
			LEFT JOIN (SELECT * FROM ".$prefix."colors as c where c.lang_id=".$this->session->userdata("lang_id").") as c on c.color_id=o.color_id
			LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl
				LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img GROUP BY p_id) tbl1 ON tbl1.p_id = tbl.p_id WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=o.product_id
			WHERE ".$where."  AND orn.order_status_id=9) as b";
			//echo $sql;
			return $this->db->query($sql)->result_array();
	}
	function get_user_order_number()
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("Select * from ".$prefix."order_numbers where (user_id = ".$this->session->userdata("user_id")." OR tmp_user_id='".$this->session->userdata("tmp_user_id")."') and order_status_id=8")->row();
	}

	function get_product_for_basket($vars)
	{
		$prefix = $this->db->dbprefix;
		$sql = 'SELECT p_id.price, p_id.measure_id, p.title, p_img.img FROM '.$prefix.'products_id as p_id
						LEFT JOIN (SELECT p_id, title FROM '.$prefix.'products WHERE lang_id = 2) as p on p.p_id = p_id.p_id
						LEFT JOIN (SELECT p_img.p_id, p_img.img FROM '.$prefix.'products_img as p_img
											 WHERE p_img.index = (SELECT MIN(p.index) FROM '.$prefix.'products_img as p where p.p_id = p_img.p_id and p.active=1) and p_img.active=1
											) as p_img on p_img.p_id = p_id.p_id
						WHERE p_id.p_id = '.$vars['product_id'];

		return $this->db->query($sql)->row();
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

	function get_product_count($product_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT sum(prod.count) as "count" FROM
								(SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", im_ex.product_id FROM '.$prefix.'products_im_ex as im_ex
								LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
													 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
								WHERE im_ex.im_ex = 0 and im_ex.product_id = '.$product_id.'
								GROUP BY im_ex.id) as prod
							GROUP BY prod.product_id';

		return $this->db->query($query)->row();
	}

	function check_login($email, $pass)
	{
		$key = $this->config->item('encryption_key');
		$salt1 = hash('sha512', $key.$pass);
		$salt2 = hash('sha512', $pass.$key);
		$hashed_password = md5(hash('sha512', $salt1.$pass.$salt2));

		$where = array("email"=>$email, "password"=>$hashed_password);
		$this->db->select("*");
		$this->db->from("site_users");
		$this->db->where($where);
		return $this->db->get()->row_array();
	}

	function get_default_category($id)
	{
		$prefix = $this->db->dbprefix;
		$query = "SELECT rel.rel_item_id FROM ".$prefix."relations as rel
							LEFT JOIN (SELECT cat_id FROM ".$prefix."cats_id
												 WHERE active=1 and deleted=0) as c_id on c_id.cat_id=rel.rel_item_id
							WHERE c_id.cat_id is not null and rel.rel_type_id=2 and rel.item_id=".$id."
							LIMIT 1";

		if($this->db->query($query)->row())
		  return $this->db->query($query)->row()->rel_item_id;
		else
			return 0;
	}



}
