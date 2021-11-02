<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Office_model extends CI_Model
{
	function __construct()
  {
    parent::__construct();
  }
  public function get_langmeta($lang)
	{
    $prefix = $this->db->dbprefix;
		return $this->db->query("SELECT * FROM ".$prefix."langmeta where lang_id=".$lang." and where_for is true")->result();
	}
	function categories_for_home()
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT c_id.*, c.name, c.description, c.seo_url FROM ".$prefix."cats_id as c_id LEFT JOIN ".$prefix."cats as c on c.cat_id=c_id.cat_id  where c.lang_id=".$this->session->userdata("lang_id")." and c_id.active is true and c_id.deleted is false and c_id.on_home is true order by c_id.order_by ASC")->result();
	}
	function get_slides()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT s_id.*, s.image from ".$prefix."slide_id as s_id LEFT JOIN (SELECT * FROM ".$prefix."slide where lang_id=".$this->session->userdata("lang_id").") as s on s.slide_id=s_id.slide_id where s_id.active=1 order by s_id.slide_id desc limit 0,7")->result();
	}
	function get_category($cat_id)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT c_id.*, c.name as cat_name, c.description, c.seo_url FROM ".$prefix."cats_id as c_id LEFT JOIN ".$prefix."cats as c on c.cat_id=c_id.cat_id  where c.lang_id=".$this->session->userdata("lang_id")." and c_id.active is true and c_id.cat_id = ".$cat_id." and  c_id.deleted is false order by c_id.order_by ASC")->row();
	}
  public function flags()
	{
		$this->db->select("*");
		$this->db->from("langs");
		$this->db->where("active", 1);
		$this->db->order_by("order_by", "ASC");
	  return $this->db->get()->result();
	}
	function product($id)
	{
		$prefix = $this->db->dbprefix;

		return $this->db->query("SELECT  p.* FROM ( SELECT b.name as brand_name, rr.cat_id,  p_id.*, p.description, p.content, p.title, im_ex.ex_price, p_img.img, u.full_name FROM `".$prefix."products_id` as p_id
			LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id")." UNION SELECT * FROM ".$prefix."products as p2 where p2.lang_id=1 AND p_id not in(SELECT p_id FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id").")) as p on p.p_id=p_id.p_id
			LEFT JOIN (SELECT * FROM ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id")." UNION SELECT * FROM ".$prefix."brands as b2 where b2.lang_id=1 AND brand_id not in(SELECT brand_id FROM ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id").")) as b on b.brand_id=p_id.brand_id
			LEFT JOIN (SELECT r.item_id as p_id, r.rel_item_id as cat_id FROM ".$prefix."relations as r WHERE r.item_id=".$id." and r.rel_type_id=2 order by id DESC limit 0, 1) as rr on rr.p_id=p_id.p_id
			LEFT JOIN (SELECT ex_price, product_id FROM ".$prefix."products_im_ex where `im_ex` is true and product_id=".$id." limit 1) as im_ex on im_ex.product_id = p_id.p_id
			LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img GROUP BY p_id ) tbl1 ON tbl1.p_id = tbl.p_id WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=p_id.p_id
			LEFT JOIN ".$prefix."users as u on u.id=p_id.user_id) as p
			WHERE p.deleted=0 AND p.active=1 AND p.parent_id=0 and p_id=".$id)->row();
	}

	function get_markers()
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("Select m_id.*, m.content, m.title from ".$prefix."map_id as m_id left join (select * from ".$prefix."map as m where m.lang_id=".$this->session->userdata("lang_id").") as m on m.map_id=m_id.map_id")->result();
	}

	function get_products_by_search($search, $param_order, $where_param, $start, $end, $total_row=0, $min_max=0, $group = ' GROUP by p_id ')
	{
		$prefix = $this->db->dbprefix;
		$where = " AND p.title like '%".$search."%' ";
		$order = " ORDER by p_id DESC";

		$sql ="SELECT  p.* FROM ( SELECT im_ex.sold, im_ex.ex_price, im_ex.mn_id, im_ex.color_id, d.percent as discount_left, bb.name as brand_name, c.name as cat_name, p_id.*, p.description, p.content, p.title, p_img.img, u.full_name FROM `".$prefix."products_id` as p_id
			LEFT JOIN (SELECT product_id, sum(`count`) as sold, ex_price, mn_id, color_id FROM `".$prefix."products_im_ex` where `im_ex` is false GROUP by `product_id`) as im_ex on im_ex.product_id = p_id.p_id
			LEFT JOIN ".$prefix."discount_id as d on d.discount_id = p_id.discount_id



	LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id")." UNION SELECT * FROM ".$prefix."products as p2 where p2.lang_id=1 AND p_id not in(SELECT p_id FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id").")) as p on p.p_id=p_id.p_id LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img GROUP BY p_id ) tbl1 ON tbl1.p_id = tbl.p_id WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=p_id.p_id

	LEFT JOIN (SELECT r.item_id as p_id, r.rel_item_id as cat_id FROM ".$prefix."relations as r WHERE r.rel_type_id=2 ) as rr on rr.p_id=p_id.p_id LEFT JOIN ".$prefix."cats_id as c_id on c_id.cat_id=rr.cat_id LEFT JOIN (select * from ".$prefix."cats as c where c.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."cats as c1 where c1.lang_id=1 AND cat_id not in(select cat_id from ".$prefix."cats as c where c.lang_id=".$this->session->userdata("lang_id").")) as c  on c.cat_id = c_id.cat_id LEFT JOIN ".$prefix."users as u on u.id=p_id.user_id


	LEFT JOIN ".$prefix."brands_id as b_id on b_id.brand_id=p_id.brand_id
	LEFT JOIN (select * from ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id")."
	Union select * from ".$prefix."brands as c1 where c1.lang_id=1 AND c1.brand_id not in(select brand_id from ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id").")) as bb  on bb.brand_id = b_id.brand_id



	) as p WHERE  p.deleted=0 AND p.active=1 AND p.parent_id=0 and p.p_id in(SELECT item_id as p_id FROM ".$prefix."relations where rel_type_id=2 and rel_item_id in(
	WITH RECURSIVE product_cats AS(SELECT cc.cat_id
				FROM (SELECT ci.*, c.name from ".$prefix."cats_id as ci LEFT JOIN ".$prefix."cats as c on c.cat_id=ci.cat_id where c.lang_id=".$this->session->userdata("lang_id").") as cc
				WHERE cc.active=1 and cc.deleted=0
			UNION ALL
			SELECT c.cat_id
				FROM product_cats AS sc
					JOIN (SELECT ci.*, c.name from ".$prefix."cats_id as ci LEFT JOIN ".$prefix."cats as c on c.cat_id=ci.cat_id where c.lang_id=".$this->session->userdata("lang_id").") AS c ON sc.cat_id = c.parent_id WHERE c.active=1 and c.deleted=0)
				SELECT * FROM product_cats) GROUP by p_id) ".$where.$where_param."  ".$group;


				$data["list"]=  $this->db->query($sql.($order." limit ".$start.", ".$end))->result();
				if($total_row)
				$data["total_row"]=  $this->db->query("Select count(*) as total_row from(".$sql.") as aa")->row();


				if($min_max)
				{
					$data["min"]=  $this->db->query("Select min(price) as `min` from(".$sql.") as aa")->row();
					$data["max"]=  $this->db->query("Select max(price) as `max` from(".$sql.") as aa")->row();
				}
				return $data;


	}
	function get_products_by_category_id($cat_id, $param_order, $where_param, $start, $end, $total_row=0, $min_max=0, $group = ' GROUP by p_id ')
	{
		$prefix = $this->db->dbprefix;
		$order="";
		$where = "";
		if($param_order==4)
		{
			$order = " ORDER by p_id DESC";
		}
		if($param_order==1)
		{
			$order = " ORDER by sold DESC";
		}
		if($param_order==3)
		{
			$order = " ORDER by price ASC";
		}
		if($param_order==11)
		{
			$order = " ORDER by price DESC";
		}
		if($param_order==5)
		{
			$order = " ORDER by title ASC";
		}
		if($param_order==6)
		{
			$order = " ORDER by title DESC";
		}
		if($param_order==2)
		{
			$where = " AND p.action is true ";
			$order = " ORDER by p_id DESC";
		}

		$cat_where = "";
		if($cat_id)
		{
			$cat_where = " AND cc.cat_id = ".$cat_id." ";
		}
		$sql ="SELECT  p.* FROM ( SELECT im_ex.sold, im_ex.ex_price, im_ex.mn_id, im_ex.color_id, d.percent as discount_left, bb.name as brand_name, c.name as cat_name, p_id.*, p.description, p.content, p.title, p_img.img, u.full_name FROM `".$prefix."products_id` as p_id
			LEFT JOIN (SELECT product_id, sum(`count`) as sold, ex_price, mn_id, color_id FROM `".$prefix."products_im_ex` where `im_ex` is false GROUP by `product_id`) as im_ex on im_ex.product_id = p_id.p_id
			LEFT JOIN ".$prefix."discount_id as d on d.discount_id = p_id.discount_id



LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id")." UNION SELECT * FROM ".$prefix."products as p2 where p2.lang_id=1 AND p_id not in(SELECT p_id FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id").")) as p on p.p_id=p_id.p_id LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img GROUP BY p_id ) tbl1 ON tbl1.p_id = tbl.p_id WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=p_id.p_id

LEFT JOIN (SELECT r.item_id as p_id, r.rel_item_id as cat_id FROM ".$prefix."relations as r WHERE r.rel_type_id=2 ) as rr on rr.p_id=p_id.p_id LEFT JOIN ".$prefix."cats_id as c_id on c_id.cat_id=rr.cat_id LEFT JOIN (select * from ".$prefix."cats as c where c.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."cats as c1 where c1.lang_id=1 AND cat_id not in(select cat_id from ".$prefix."cats as c where c.lang_id=".$this->session->userdata("lang_id").")) as c  on c.cat_id = c_id.cat_id LEFT JOIN ".$prefix."users as u on u.id=p_id.user_id


LEFT JOIN ".$prefix."brands_id as b_id on b_id.brand_id=p_id.brand_id
LEFT JOIN (select * from ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id")."
Union select * from ".$prefix."brands as c1 where c1.lang_id=1 AND c1.brand_id not in(select brand_id from ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id").")) as bb  on bb.brand_id = b_id.brand_id



) as p WHERE  p.deleted=0 AND p.active=1 AND p.parent_id=0 and p.p_id in(SELECT item_id as p_id FROM ".$prefix."relations where rel_type_id=2 and rel_item_id in(
WITH RECURSIVE product_cats AS(SELECT cc.cat_id
		    FROM (SELECT ci.*, c.name from ".$prefix."cats_id as ci LEFT JOIN ".$prefix."cats as c on c.cat_id=ci.cat_id where c.lang_id=".$this->session->userdata("lang_id").") as cc
		    WHERE cc.active=1 and cc.deleted=0 ".$cat_where."
		  UNION ALL
		  SELECT c.cat_id
		    FROM product_cats AS sc
		      JOIN (SELECT ci.*, c.name from ".$prefix."cats_id as ci LEFT JOIN ".$prefix."cats as c on c.cat_id=ci.cat_id where c.lang_id=".$this->session->userdata("lang_id").") AS c ON sc.cat_id = c.parent_id WHERE c.active=1 and c.deleted=0)
				SELECT * FROM product_cats) GROUP by p_id) ".$where.$where_param."  ".$group;

			if($group==" GROUP by brand_id ")
			{
				$data = $this->db->query($sql)->result();
				return $data;
			}else{
				$data["list"]=  $this->db->query($sql.($order." limit ".$start.", ".$end))->result();
				if($total_row)
				$data["total_row"]=  $this->db->query("Select count(*) as total_row from(".$sql.") as aa")->row();


				if($min_max)
				{
					$data["min"]=  $this->db->query("Select min(price) as `min` from(".$sql.") as aa")->row();
					$data["max"]=  $this->db->query("Select max(price) as `max` from(".$sql.") as aa")->row();
				}
				//print_r($data);
				return $data;
			}


	}
	function get_vacancies()
  {
		$prefix = $this->db->dbprefix;
		$sql ="SELECT  v.*, v_id.thumb, v_id.date_time FROM ".$prefix."vacancy_id as v_id
    LEFT JOIN (SELECT * FROM ".$prefix."vacancy as v where v.lang_id=".$this->session->userdata("lang_id").") as v on v.vacancy_id=v_id.vacancy_id
    WHERE v_id.deleted=0 AND v_id.date_time>'".date("Y-m-d")."' AND v_id.active=1 ORDER by v_id.vacancy_id DESC";
		return  $this->db->query($sql)->result();

  }
	function get_vacancy($id)
  {
		$prefix = $this->db->dbprefix;
		$sql ="SELECT  v.*, v_id.thumb, v_id.date_time FROM ".$prefix."vacancy_id as v_id
    LEFT JOIN (SELECT * FROM ".$prefix."vacancy as v where v.vacancy_id=".$id." AND v.lang_id=".$this->session->userdata("lang_id").") as v on v.vacancy_id=v_id.vacancy_id

    WHERE v_id.deleted=0 AND v_id.date_time>'".date("Y-m-d")."'  AND v_id.active=1 AND v_id.vacancy_id=".$id;
		return $this->db->query($sql)->row();

  }
	function get_all_brands()
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT b.name, b_id.* FROM ".$prefix."brands_id as b_id
		LEFT JOIN (select * from ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id")."
		Union select * from ".$prefix."brands as c1 where c1.lang_id=1 AND c1.brand_id not in(select brand_id from ".$prefix."brands as b where b.lang_id=".$this->session->userdata("lang_id").")) as b  on b.brand_id = b_id.brand_id WHERE b_id.active=1 AND b_id.deleted=0")->result();
	}
	function breadcrumb_category($category)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("WITH RECURSIVE product_category AS
		(
		  SELECT cc.cat_id, cc.name, cc.parent_id, 1 AS depth, cc.name AS path
		    FROM (SELECT ci.*, c.name from ".$prefix."cats_id as ci LEFT JOIN ".$prefix."cats as c on c.cat_id=ci.cat_id where c.lang_id=".$this->session->userdata("lang_id").") as cc
		    WHERE cc.cat_id = ".$category." and cc.active=1 and cc.deleted=0
		  UNION ALL
		  SELECT c.cat_id, c.name, c.parent_id, sc.depth + 1, CONCAT(sc.path, ' > ', c.name)
		    FROM product_category AS sc
		      JOIN (SELECT ci.*, c.name from ".$prefix."cats_id as ci LEFT JOIN ".$prefix."cats as c on c.cat_id=ci.cat_id where c.lang_id=".$this->session->userdata("lang_id").") AS c ON sc.parent_id = c.cat_id WHERE c.active=1 and c.deleted=0
		)
		SELECT * FROM product_category order by depth DESC")->result();
	}
	function next_prev($product_id, $cat_id)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("select * from (
			SELECT p_id
			, (lag(p_id) over(order by p_id asc)) as prev
			, (lead(p_id) over(order by p_id asc)) as next
			FROM ".$prefix."products_id
			) as a
			WHERE a.p_id = ".$product_id)->row();
	}
	function get_product_colors($product_id)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("
SELECT im_ex.*, sum(im_ex.count) as counts, c_id.color_name, c_id.color_code FROM ".$prefix."products_im_ex as im_ex

LEFT JOIN (SELECT colors.*, c_id.color_code, c_id.active from ".$prefix."colors_id as c_id
	LEFT JOIN(select * from ".$prefix."colors as b where b.lang_id=".$this->session->userdata("lang_id")."
	Union select * from ".$prefix."colors as w1 where w1.lang_id=1 AND w1.color_id not in(select color_id from ".$prefix."colors as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as colors on colors.color_id=c_id.color_id where c_id.deleted=0 and c_id.active=1) as c_id on c_id.color_id=im_ex.color_id
where im_ex.product_id=".$product_id." GROUP BY im_ex.color_id  ORDER by im_ex.id DESC
			 ")->result();
	}
	function get_product_sizes($product_id)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query(
			`SELECT * FROM (SELECT im_ex.*, sum(im_ex.count) as counts, mn.title FROM ".$prefix."products_im_ex as im_ex
											LEFT JOIN (SELECT mn.* from `.$prefix.`measure_names as mn
																 where mn.lang_id=`.$this->session->userdata("lang_id").`)
																 as mn on mn.mn_id=im_ex.mn_id
											where im_ex.product_id=`.$product_id.`
											GROUP BY im_ex.mn_id
											ORDER by im_ex.id DESC) as a
			where a.mn_id!=0`
		)->result();
	}
	function get_product_price($vars)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT im_ex.ex_price, sum(im_ex.`count`) as sums, im_ex.mn_id, im_ex.color_id  FROM ".$prefix."products_im_ex as im_ex where product_id=".$vars["product_id"]." and mn_id=".$vars["mn_id"]." and color_id=".$vars["color_id"]." GROUP BY mn_id, color_id")->row();
	}
	function get_product_warehouse_in($product_id)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("
SELECT im_ex.*, sum(im_ex.count) as counts, w_id.name FROM ".$prefix."products_im_ex as im_ex

LEFT JOIN (SELECT warehouse.*, w_id.active from ".$prefix."warehouses_id as w_id
	LEFT JOIN(select * from ".$prefix."warehouses as b where b.lang_id=".$this->session->userdata("lang_id")."
	Union select * from ".$prefix."warehouses as w1 where w1.lang_id=1 AND w1.warehouse_id not in(select warehouse_id from ".$prefix."warehouses as m3 where m3.lang_id=".$this->session->userdata("lang_id").")) as warehouse on warehouse.warehouse_id=w_id.warehouse_id where w_id.deleted=0 and w_id.active=1) as w_id on w_id.warehouse_id=im_ex.warehouse_id
where im_ex.product_id=".$product_id." GROUP BY im_ex.warehouse_id  ORDER by im_ex.id DESC
			 ")->result();
	}
  public function get_menus($lang)
	{
		$this->db->from("site_menus_id as m_id");
		$this->db->join('site_menus as menus', 'menus.menu_id = m_id.menu_id', 'left');
		$this->db->where("m_id.deleted", 0);
		$this->db->where("menus.lang_id", $lang);
		$this->db->order_by("order_by", "ASC");
		return $this->db->get()->result_array();
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
  public function social_icons()
	{
    $prefix = $this->db->dbprefix;
		return $this->db->query("SELECT * FROM ".$prefix."social_icons where active=1 order by order_by ASC")->result();
	}

    function get_products_in_where($limit, $param)
    {
        $prefix = $this->db->dbprefix;
        $sql ="SELECT group_concat(`cat_name` separator ', ') as cats_name, p.* FROM ( SELECT c.name as cat_name, p_id.*, p.description, p.content, p.title, p_img.img, u.full_name FROM `".$prefix."products_id` as p_id
		LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id")." UNION SELECT * FROM ".$prefix."products as p2 where p2.lang_id=1 AND p_id not in(SELECT p_id FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id").")) as p on p.p_id=p_id.p_id LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img GROUP BY p_id ) tbl1 ON tbl1.p_id = tbl.p_id WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=p_id.p_id LEFT JOIN (SELECT r.item_id as p_id, r.rel_item_id as cat_id FROM ".$prefix."relations as r WHERE r.rel_type_id=2) as rr on rr.p_id=p_id.p_id LEFT JOIN ".$prefix."cats_id as c_id on c_id.cat_id=rr.cat_id LEFT JOIN (select * from ".$prefix."cats as c where c.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."cats as c1 where c1.lang_id=1 AND cat_id not in(select cat_id from ".$prefix."cats as c where c.lang_id=".$this->session->userdata("lang_id").")) as c  on c.cat_id = c_id.cat_id LEFT JOIN ".$prefix."users as u on u.id=p_id.user_id) as p WHERE p.deleted=0 AND p.active=1 AND p.parent_id=0 ".$param;

        $sql = $sql." GROUP by p.p_id  ORDER BY p_id DESC LIMIT 0, ".$limit;
        $data= $this->db->query($sql)->result();
        return $data;
    }






}
