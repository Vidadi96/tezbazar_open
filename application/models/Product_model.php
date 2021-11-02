<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_model extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }
	/*********Params Start******/
	public function get_param_groups()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT g.* from ".$prefix."param_groups_id as g_id LEFT JOIN(select * from ".$prefix."param_groups as g where g.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."param_groups as g1 where g1.lang_id=1 AND g1.param_group_id not in(select param_group_id from ".$prefix."param_groups as g3 where g3.lang_id=".$this->session->userdata("lang_id").")) as g on g.param_group_id=g_id.param_group_id where g_id.deleted=0")->result();
	}
	public function params()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT pt.param_type_title, pg.param_group_title, p_id.param_id, p_id.order_by, p_id.active, p.param_title, p.lang_id from ".$prefix."params_id as p_id LEFT JOIN(select * from ".$prefix."params as p where p.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."params as p1 where p1.lang_id=1 AND p1.param_id not in(select param_id from ".$prefix."params as p3 where p3.lang_id=".$this->session->userdata("lang_id").")) as p on p.param_id=p_id.param_id
		LEFT JOIN (SELECT * from ".$prefix."param_groups as pg where pg.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."param_groups as pg1 where pg1.lang_id=1 AND pg1.param_group_id not in(select param_group_id from ".$prefix."param_groups as pg3 where pg3.lang_id=".$this->session->userdata("lang_id").")) as pg on pg.param_group_id = p_id.param_group_id LEFT JOIN ".$prefix."param_types as pt on pt.param_type_id=p_id.param_type_id  where p_id.deleted=0")->result();
	}






	//LEFT JOIN () as p_g
	public function delete_sub_params_id($param_id)
	{
		$prefix = $this->db->dbprefix;
		$this->db->query("Delete from ".$prefix."sub_params where sub_param_id in(SELECT sub_param_id from ".$prefix."sub_params_id where param_id=".$param_id.")");
		return $this->db->query("Delete from ".$prefix."sub_params_id where param_id=".$param_id);

	}
	public function delete_sub_param_id($sub_param_id)
	{
		$prefix = $this->db->dbprefix;
		$this->db->query("Delete from ".$prefix."sub_params where sub_param_id=".$sub_param_id);
		return $this->db->query("Delete from ".$prefix."sub_params_id where sub_param_id=".$sub_param_id);
	}
	public function get_sub_params($param_id)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("Select sp.sub_param_title, sp.lang_id, sp_id.sub_param_id from ".$prefix."sub_params as sp LEFT JOIN ".$prefix."sub_params_id as sp_id  on sp.sub_param_id = sp_id.sub_param_id where sp_id.param_id=".$param_id)->result();
	}
	public function get_sub_params_id($param_id)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("Select *  from ".$prefix."sub_params_id where param_id=".$param_id)->result();
	}
	/*********Params END******/
	/*****Measures Start******/
	function measures()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT measures.*, m_id.order_by, m_id.active from ".$prefix."measures_id as m_id LEFT JOIN(select * from ".$prefix."measures as m where m.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."measures as m1 where m1.lang_id=1 AND m1.measure_id not in(select measure_id from ".$prefix."measures as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as measures on measures.measure_id=m_id.measure_id where m_id.deleted=0")->result();
	}
	function edit_measure($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT m.*, m_id.order_by, m_id.active from ".$prefix."measures as m LEFT JOIN ".$prefix."measures_id as m_id on m_id.measure_id=m.measure_id where m_id.deleted=0 and m_id.measure_id=".$id)->result_array();
	}
	/*****Measures End******/
	/*****Measure names Start******/
	function measure_names()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT mn.*, m.title as measure_name, mn_id.active, mn_id.measure_id from ".$prefix."measure_names_id as mn_id
		LEFT JOIN (select * from ".$prefix."measure_names as mn where mn.lang_id=".$this->session->userdata("lang_id").") as mn on mn.mn_id=mn_id.mn_id
		LEFT JOIN (select * from ".$prefix."measures as m where m.lang_id=".$this->session->userdata("lang_id").") as m on m.measure_id = mn_id.measure_id
		where mn_id.deleted=0")->result();
	}
	function edit_measure_name($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT mn.*, mn_id.measure_id, mn_id.active from ".$prefix."measure_names as mn LEFT JOIN ".$prefix."measure_names_id as mn_id on mn_id.mn_id=mn.mn_id where mn_id.deleted=0 and mn_id.mn_id=".$id)->result_array();
	}
	/*****Measures End******/
	/*****Warehouse Start******/
	function warehouse_id()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT warehouses.*, w_id.active from ".$prefix."warehouses_id as w_id LEFT JOIN(select * from ".$prefix."warehouses as w where w.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."warehouses as w1 where w1.lang_id=1 AND w1.warehouse_id not in(select warehouse_id from ".$prefix."warehouses as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as warehouses on warehouses.warehouse_id=w_id.warehouse_id where w_id.deleted=0 and w_id.active=1")->result();
	}






	/*****Warehouse End******/
	/*****Categories Start******/

	function categories()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT ci.show_unshow, ci.cat_id,ci.order_by, ci.active, SUBSTR(getPath(ci.cat_id, c.lang_id), 3) AS name FROM ".$prefix."cats_id as ci left join ".$prefix."cats as c on c.cat_id=ci.cat_id and c.lang_id=".$this->session->userdata("lang_id")." where ci.deleted=0 GROUP BY ci.cat_id ORDER BY name ASC")->result();
	}

	function edit_category($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT c.*, c_id.icon, c_id.discount_id, c_id.on_home, c_id.on_menu,c_id.parent_id, c_id.order_by, c_id.active from ".$prefix."cats as c LEFT JOIN ".$prefix."cats_id as c_id on c_id.cat_id=c.cat_id where c_id.deleted=0 and c_id.cat_id=".$id)->result_array();
	}
	/*****Categories End******/
	/*****Brands Start******/
	function brands($filter)
	{
		$param = "";
		$prefix = $this->db->dbprefix;

		if(isset($filter["name"]) && @$filter["name"]==TRUE)
		{
			$param = " AND brand.name like '%".$filter["name"]."%' ";
		}

		$sql ="SELECT * FROM(SELECT b.name, b.lang_id, b_id.thumb, b_id.brand_id, b_id.order_by, b_id.active from ".$prefix."brands_id as b_id LEFT JOIN(select * from ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."brands as b1 where b1.lang_id=1 AND b1.brand_id not in(select brand_id from ".$prefix."brands as b3 where b3.lang_id=".$this->session->userdata("lang_id").")) as b on b.brand_id=b_id.brand_id where b_id.deleted=0) as brand WHERE 1=1 ".$param;

		$total = $this->db->query("SELECT count(*) as count_rows FROM (".$sql.") as t")->row();
		$data["total_row"] = $total->count_rows;

		$sql = $sql." ORDER BY brand.name ASC LIMIT ".$filter["from"].", ".$filter["end"];

		$data["list"] = $this->db->query($sql)->result();
		return $data;
	}
	function edit_brand($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT b.*, b_id.thumb, b_id.discount_id, b_id.active from ".$prefix."brands as b LEFT JOIN ".$prefix."brands_id as b_id on b_id.brand_id=b.brand_id where b_id.deleted=0 and b_id.brand_id=".$id)->result_array();
	}
	/*****Brands End******/
	function product_list($array, $start, $end, $lang)
	{
		$prefix = $this->db->dbprefix;
		$where = '';

		if (isset($array['category_id']) && $array['category_id'])
			$where .= ' and main.cat_id in ('.implode(',', $array['category_id']).')';

		if (isset($array['title']) && $array['title'])
			$where .= ' and main.product_name like "%'.$array['title'].'%"';

		if (isset($array['sku']) && $array['sku'])
			$where .= ' and main.sku = "'.$array['sku'].'"';

		if (isset($array['brand_id']) && $array['brand_id'])
			$where .= ' and main.brand_id in ('.implode(',', $array['brand_id']).')';

		if (isset($array['active'])) {
			if ($array['active'] == 1)
				$where .= ' and main.active = 1';
			else if ($array['active'] == 2)
				$where .= ' and main.active = 0';
		}

		$query = 'SELECT GROUP_CONCAT(main.name) as "category", main.price, main.product_name, main.img, main.p_id, main.sku, main.active FROM
							 (SELECT rel.cat_id, IF(ISNULL(rel.name), 0, rel.name) as "name", CONCAT(p.title, " - ", p.description) AS "product_name", IF(ISNULL(p_img.img), 0, p_img.img) as "img",
							 				 p_id.p_id, p_id.sku, p_id.price, p_id.active, p_id.brand_id FROM '.$prefix.'products_id as p_id
								LEFT JOIN (SELECT p_img.p_id, p_img.img FROM '.$prefix.'products_img as p_img
													 WHERE p_img.index = (SELECT MIN(pp_img.index) FROM '.$prefix.'products_img as pp_img
																								WHERE p_img.p_id = pp_img.p_id)) as p_img on p_img.p_id = p_id.p_id
								LEFT JOIN (SELECT p.p_id, p.title, p.description FROM '.$prefix.'products as p
													 WHERE p.lang_id='.$lang.') as p on p.p_id = p_id.p_id
								LEFT JOIN (SELECT  c.cat_id, c.name, rel.item_id, rel.rel_item_id FROM '.$prefix.'relations as rel
													 LEFT JOIN (SELECT cat_id, name FROM '.$prefix.'cats
																			WHERE lang_id='.$lang.') as c on c.cat_id = rel.rel_item_id
													 WHERE rel.rel_type_id=2) as rel on rel.item_id = p_id.p_id
								WHERE p_id.deleted=0) AS main
							WHERE 1'.$where.'
							GROUP BY main.p_id
							ORDER BY main.p_id desc
							LIMIT '.$start.', '.$end;

		$query2 = 'select COUNT(*) as "count" FROM ('.substr($query, 0, strpos($query, 'LIMIT')).') as m';

		$data['list'] = $this->db->query($query)->result();
		$data['total_row'] = $this->db->query($query2)->result();

		return $data;
	}

	public function product_set_active_passive($vars)
	{
		$update_vars = array("active"=>$vars["active"]);
		$this->db->where("p_id", $vars["p_id"]);
		if($this->session->userdata("role_id")!=1)
			$this->db->where("user_id", $this->session->userdata("id"));
		return $this->db->update("products_id", $update_vars);
	}

	function get_product($product_id)
  {
    $prefix = $this->db->dbprefix;

		$query = "SELECT p_id.*, p.title, p.description, p.content, p.seo_title, p.seo_description, p.seo_keywords, p.seo_url, p.lang_id FROM ".$prefix."products as p
							LEFT JOIN ".$prefix."products_id as p_id on p_id.p_id=p.p_id
							WHERE p_id.p_id = ".$product_id;

    return $this->db->query($query)->result_array();
  }

  function get_product_colors($product_id)
  {
    $prefix = $this->db->dbprefix;
    return $this->db->query("SELECT im.*, w.name as warehouse_name, colors.color_name  FROM ".$prefix."products_im_ex as im
		LEFT JOIN(select * from ".$prefix."colors as b where b.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."colors as w1 where w1.lang_id=1 AND w1.color_id not in(select color_id from ".$prefix."colors as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as colors on colors.color_id=im.color_id

		LEFT JOIN(select * from ".$prefix."warehouses as w where w.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."warehouses as w1 where w1.lang_id=1 AND w1.warehouse_id not in(select warehouse_id from ".$prefix."warehouses as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as w on w.warehouse_id=im.warehouse_id

		where im.im_ex = 0 and im.product_id=".$product_id." ORDER by id ASC")->result_array();
  }

  function get_product_param($product_id)
  {
      $prefix = $this->db->dbprefix;
      return $this->db->query("SELECT pr.*, p_id.param_group_id  FROM ".$prefix."prarm_rel_id as pr LEFT JOIN ".$prefix."params_id as p_id on p_id.param_id=pr.param_id where pr.product_id=".$product_id)->result_array();
  }

	/******CATEGORY**********/
	function  cat_id()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		$query = "SELECT ci.cat_id, SUBSTR(getPath(ci.cat_id, c.lang_id), 3) AS name FROM ".$prefix."cats_id as ci
							LEFT JOIN ".$prefix."cats as c on c.cat_id=ci.cat_id and c.lang_id=".$this->session->userdata("lang_id")."
							WHERE ci.active=1 and ci.deleted=0
							GROUP BY ci.cat_id ORDER BY name ASC";

		return $this->db->query($query)->result();
	}
	/*function discount_id()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT d.discount_title, d.lang_id, di.discount_id from ".$prefix."discount_id as di LEFT JOIN ".$prefix."discount as d on d.discount_id=di.discount_id where di.deleted=0")->result();
	}*/




	/*****Parameters Group Start******/

	function param_groups()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT pg.param_group_title, pg.lang_id, pgi.param_group_id, pgi.order_by, pgi.active from ".$prefix."param_groups_id as pgi LEFT JOIN(select * from ".$prefix."param_groups as pg where pg.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."param_groups as pg1 where pg1.lang_id=1 AND pg1.param_group_id not in(select param_group_id from ".$prefix."param_groups as pg3 where pg3.lang_id=".$this->session->userdata("lang_id").")) as pg on pg.param_group_id=pgi.param_group_id where pgi.deleted=0")->result();
	}
	function edit_param_group($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT pg.*, pgi.order_by, pgi.active from ".$prefix."param_groups as pg LEFT JOIN ".$prefix."param_groups_id as pgi on pgi.param_group_id=pg.param_group_id where pgi.deleted=0 and pgi.param_group_id=".$id)->result_array();
	}
	/*****Parameters Group End******/

    function brand_id()
    {
        $param = "";
        $prefix = $this->db->dbprefix;
        return $this->db->query("SELECT brands.*, b_id.active from ".$prefix."brands_id as b_id LEFT JOIN(select * from ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."brands as w1 where w1.lang_id=1 AND w1.brand_id not in(select brand_id from ".$prefix."brands as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as brands on brands.brand_id=b_id.brand_id where b_id.deleted=0 and b_id.active=1")->result();
    }
    function discount_id()
    {
        $param = "";
        $prefix = $this->db->dbprefix;
        return $this->db->query("SELECT discount.*, d_id.active from ".$prefix."discount_id as d_id LEFT JOIN(select * from ".$prefix."discount as b where b.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."discount as w1 where w1.lang_id=1 AND w1.discount_id not in(select discount_id from ".$prefix."discount as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as discount on discount.discount_id=d_id.discount_id where d_id.deleted=0 and d_id.active=1")->result();
    }
    /********COLORS************/
    function edit_color($id)
    {
        $param = "";
        $prefix = $this->db->dbprefix;
        return $this->db->query("SELECT c.*, c_id.color_code, c_id.active from ".$prefix."colors as c LEFT JOIN ".$prefix."colors_id as c_id on c_id.color_id=c.color_id where c_id.deleted=0 and c_id.color_id=".$id)->result_array();
    }
    function color_id()
    {
        $param = "";
        $prefix = $this->db->dbprefix;
        return $this->db->query("SELECT colors.*, c_id.active from ".$prefix."colors_id as c_id LEFT JOIN(select * from ".$prefix."colors as b where b.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."colors as w1 where w1.lang_id=1 AND w1.color_id not in(select color_id from ".$prefix."colors as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as colors on colors.color_id=c_id.color_id where c_id.deleted=0 and c_id.active=1")->result();
    }
    function colors($filter)
    {
        $param = "";
        $prefix = $this->db->dbprefix;

        if(isset($filter["color_name"]) && @$filter["color_name"]==TRUE)
        {
            $param = " AND colors.color_name like '%".$filter["color_name"]."%' ";
        }

        $sql ="SELECT * FROM(SELECT b.color_name, b.lang_id, b_id.color_id, b_id.color_code, b_id.active from ".$prefix."colors_id as b_id LEFT JOIN(select * from ".$prefix."colors as b where b.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."colors as b1 where b1.lang_id=1 AND b1.color_id not in(select color_id from ".$prefix."colors as b3 where b3.lang_id=".$this->session->userdata("lang_id").")) as b on b.color_id=b_id.color_id where b_id.deleted=0) as colors WHERE 1=1 ".$param;

        $total = $this->db->query("SELECT count(*) as count_rows FROM (".$sql.") as t")->row();
        $data["total_row"] = $total->count_rows;

        $sql = $sql." ORDER BY colors.color_name ASC ";

        $data["list"] = $this->db->query($sql)->result();
        return $data;
    }

		function get_product_list($from, $count, $cat_id, $product_name, $sku, $lang, $table_name)
		{
			$prefix = $this->db->dbprefix;
			$data = [];
			$where='';

			if ($cat_id)
				$where .= ' and main.cat_id in ('.$cat_id.')';

			if ($product_name)
				$where .= ' and main.title = "'.$product_name.'"';

			if ($sku)
				$where .= ' and main.sku = "'.$sku.'"';

			$query = 'SELECT main.show, GROUP_CONCAT(main.name) as "category", main.ex_price, main.title, main.img, main.p_id, main.discount, main.sku FROM (
								  SELECT rel.cat_id, IF(ISNULL(sh.p_id), 0, sh.p_id) as "show", IF(ISNULL(rel.name), 0, rel.name) as "name", p_im_ex.ex_price, p.title, IF(ISNULL(p_img.img), 0, p_img.img) as "img", p_id.p_id, p_id.discount, p_id.sku FROM '.$prefix.'products_id as p_id
								  LEFT JOIN (SELECT p_img.p_id, p_img.img FROM '.$prefix.'products_img as p_img
								             WHERE p_img.index = (SELECT MIN(pp_img.index) FROM '.$prefix.'products_img as pp_img
								                                  WHERE p_img.p_id = pp_img.p_id)) as p_img on p_img.p_id = p_id.p_id
								  LEFT JOIN (SELECT p.p_id, p.title FROM '.$prefix.'products as p WHERE p.lang_id='.$lang.') as p on p.p_id = p_id.p_id
								  LEFT JOIN (SELECT p_im_ex.product_id, p_im_ex.ex_price FROM '.$prefix.'products_im_ex as p_im_ex
								             WHERE p_im_ex.id = (SELECT MIN(pp_im_ex.id) FROM '.$prefix.'products_im_ex as pp_im_ex
								                                 WHERE pp_im_ex.product_id = p_im_ex.product_id)) as p_im_ex on p_im_ex.product_id = p_id.p_id
								  LEFT JOIN (SELECT  c.cat_id, c.name, rel.item_id, rel.rel_item_id FROM '.$prefix.'relations as rel
								             LEFT JOIN (SELECT c.cat_id, c.name FROM '.$prefix.'cats as c
								                        WHERE c.lang_id='.$lang.') as c on c.cat_id = rel.rel_item_id
								             WHERE rel.rel_type_id=2) as rel on rel.item_id = p_id.p_id
								  LEFT JOIN '.$prefix.$table_name.' as sh on sh.p_id = p_id.p_id
								  WHERE p_id.active=1 and p_id.deleted=0 and p_im_ex.product_id is not null) AS main
								WHERE 1'.$where.'
								GROUP BY main.p_id
								LIMIT '.$from.', '.$count;

			$query2 = 'SELECT COUNT(*) as "count" FROM ('.substr($query, 0, strpos($query, 'LIMIT')).') as m';

			$data['main'] = $this->db->query($query)->result();
			$data['total_row'] = $this->db->query($query2)->result();

			return $data;
		}

		function show_unshow($id, $showed, $table_name)
		{
			$prefix = $this->db->dbprefix;
			if($showed)
			{
				$query = 'delete FROM '.$prefix.$table_name.' where p_id='.$id;
			}
			else
			{
				$query = 'insert into '.$prefix.$table_name.' (p_id) VALUES ('.$id.')';
			}

			if($this->db->query($query))
			{
				return true;
			}
			else
			{
				return false;
			}

		}

		function show_unshow_category($id, $showed)
		{
			$prefix = $this->db->dbprefix;
			if($showed)
				$query = 'UPDATE '.$prefix.'cats_id SET show_unshow = 0 where cat_id='.$id;
			else
				$query = 'UPDATE '.$prefix.'cats_id SET show_unshow = 1 where cat_id='.$id;

			if($this->db->query($query))
				return true;
			else
				return false;
		}

		function categories2($lang){
			$prefix = $this->db->dbprefix;
			$query = 'SELECT c_id.show_unshow, c_id.cat_id, c.name FROM '.$prefix.'cats_id as c_id
			 					LEFT JOIN (SELECT cat_id, name FROM '.$prefix.'cats
													 WHERE lang_id='.$lang.') as c ON c.cat_id=c_id.cat_id
								WHERE c_id.deleted=0 and c_id.active=1 and c.name is not null and c.name!="" and c_id.cat_id not in (SELECT parent_id FROM '.$prefix.'cats_id
																		 			WHERE parent_id!=0 group by parent_id)';

			return $this->db->query($query)->result();
		}

		function get_providers()
	  {
	    $prefix = $this->db->dbprefix;
	    $query = 'SELECT id, full_name FROM '.$prefix.'providers';

	    return $this->db->query($query)->result();
	  }

		function entry_type_list($lang)
		{
			$prefix = $this->db->dbprefix;
			$query = 'SELECT * FROM '.$prefix.'entry_name WHERE lang_id = '.$lang;

			return $this->db->query($query)->result();
		}

		function insert_delete_edit($product_id)
		{
			$prefix = $this->db->dbprefix;
			$query = 'INSERT INTO '.$prefix.'products_log (product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, action_time, action_name)
								SELECT product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, "'.date("Y-m-d H:i:s").'", "Edit delete product" FROM '.$prefix.'products_im_ex WHERE product_id='.$product_id;

			if($this->db->query($query))
				return true;
			else
				return false;
		}

		function delete_where_not_in($product_id, $not_in)
		{
			$prefix = $this->db->dbprefix;
			$query = 'DELETE FROM '.$prefix.'products_im_ex WHERE product_id='.$product_id.' and id not in ('.$not_in.')';

			if($this->db->query($query))
				return true;
			else
				return false;
		}

		function insert_where_not_in($product_id, $not_in)
		{
			$prefix = $this->db->dbprefix;
			$query = 'INSERT INTO '.$prefix.'products_log (im_ex_id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, contract_number, check_number, action_time, action_name)
								SELECT id, product_id, color_id, mn_id, measure_id, im_price, ex_price, warehouse_id, count, im_ex, date_time, provider_id, entry_name_id, user_id, contract_number, check_number, "'.date("Y-m-d H:i:s").'", "Delete income product" FROM '.$prefix.'products_im_ex WHERE product_id='.$product_id.' and id not in ('.$not_in.')';

			if($this->db->query($query))
				return true;
			else
				return false;
		}

		function get_salesmen()
	  {
	    $prefix = $this->db->dbprefix;
	    $query = 'SELECT id, fullname FROM '.$prefix.'salesmen';

	    return $this->db->query($query)->result();
	  }

		function get_import_contracts()
	  {
	    $prefix = $this->db->dbprefix;
	    $query = 'SELECT id, contract_number, salesman_id FROM '.$prefix.'import_contracts';

	    return $this->db->query($query)->result();
	  }

		function get_import_contracts_with_id($salesman_id)
		{
			$prefix = $this->db->dbprefix;
			$query = 'SELECT id, contract_number FROM '.$prefix.'import_contracts WHERE salesman_id='.$salesman_id;

			return $this->db->query($query)->result();
		}

		function get_measures($lang)
		{
			$prefix = $this->db->dbprefix;
			$query = 'SELECT m_id.measure_id, m.title FROM '.$prefix.'measures_id as m_id
								LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures
													 WHERE lang_id = '.$lang.') as m on m.measure_id = m_id.measure_id
								WHERE m_id.active = 1 and m_id.deleted = 0';

			return $this->db->query($query)->result();
		}

		function get_skus()
		{
			$prefix = $this->db->dbprefix;
			$query = 'SELECT sku FROM '.$prefix.'products_id';

			return $this->db->query($query)->result();
		}

}
