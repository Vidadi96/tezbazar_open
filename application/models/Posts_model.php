<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Posts_model extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }
	function cargo_list()
	{
		return $this->db->query("WITH RECURSIVE regions AS
		(
		  SELECT cc.region_id, cc.name, cc.price, cc.active, cc.parent_id, 1 AS depth, cc.name AS path
		    FROM (SELECT ci.*, c.name from ali_regions_id as ci LEFT JOIN ali_regions as c on c.region_id=ci.region_id where c.lang_id=2) as cc
		    WHERE cc.active=1
		  UNION ALL
		  SELECT c.region_id, c.name, c.price, c.active, c.parent_id, sc.depth + 1, CONCAT(sc.path, ' >> ', c.name)
		    FROM regions AS sc
		      JOIN (SELECT ci.*, c.name from ali_regions_id as ci LEFT JOIN ali_regions as c on c.region_id=ci.region_id where c.lang_id=2) AS c ON sc.region_id = c.parent_id WHERE c.active=1
		)
		SELECT * FROM regions where parent_id=0 or depth>1 order by path asc")->result();
	}
	public function get_markers()
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("Select m_id.*, m.title from ".$prefix."map_id as m_id left join (select * from ".$prefix."map as m where m.lang_id=".$this->session->userdata("lang_id").") as m on m.map_id=m_id.map_id")->result();
	}
	/*****Add new post******/
  function get_categories()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT cats.post_cat_title, cats.lang_id, c_id.post_cat_id, c_id.order_by, c_id.active from ".$prefix."post_cats_id as c_id LEFT JOIN(select * from ".$prefix."post_cats as c where c.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."post_cats as c1 where c1.lang_id=1 AND c1.post_cat_id not in(select post_cat_id from ".$prefix."post_cats as c3 where c3.lang_id=".$this->session->userdata("lang_id").")) as cats on cats.post_cat_id=c_id.post_cat_id where c_id.deleted=0")->result();
	}
	/*****Add new post End******/

	function get_cargo($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT r.*, r_id.parent_id, r_id.price, r_id.active from ".$prefix."regions as r LEFT JOIN ".$prefix."regions_id as r_id on r_id.region_id=r.region_id where r_id.region_id=".$id)->result_array();
	}
	function post_item($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT p.*, p_id.thumb, p_id.date_time, p_id.active from ".$prefix."posts as p LEFT JOIN ".$prefix."posts_id as p_id on p_id.post_id=p.post_id where p_id.deleted=0 and p_id.post_id=".$id)->result_array();
	}
	function slides()
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT s_id.*, s.image from ".$prefix."slide_id as s_id LEFT JOIN (SELECT * FROM ".$prefix."slide where lang_id=".$this->session->userdata("lang_id").") as s on s.slide_id=s_id.slide_id")->result();
	}
	function get_slide($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT s_id.*, s.image, s.lang_id from ".$prefix."slide_id as s_id LEFT JOIN ".$prefix."slide as s on s.slide_id=s_id.slide_id")->result_array();
	}
	function post_list($array, $start, $end)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		if(isset($array["title"]))
		{
			$param = " AND (p.title like '%".strip_tags($array["title"])."%' OR p.description like '%".strip_tags($array["description"])."%' ) ";
		}
		if(isset($array["active"]) && @$array["active"])
		{
			$array["active"] = (int)($array["active"]==2?0:$array["active"]);
			$param = " AND (p.active= ".$array["active"].")";
		}
		if(isset($array["date_time"]) && @$array["date_time"]==TRUE)
		{
			$date = explode("-", $array["date_time"]);
			$param = $param." AND p_id.date_time <='".$date[0]."' AND p_id.date_time >='".$date[1]."' ";
		}

		$sql ="SELECT group_concat(`cat_name` separator ', ') as cats_name, p.* FROM ( SELECT c.post_cat_title as cat_name, p_id.*, p.description, p.title, u.full_name FROM ".$prefix."posts_id as p_id
		LEFT JOIN (SELECT * FROM ".$prefix."posts as p where p.lang_id=".$this->session->userdata("lang_id").") as p on p.post_id=p_id.post_id

		LEFT JOIN (SELECT r.item_id as post_id, r.rel_item_id as cat_id FROM ".$prefix."relations as r WHERE r.rel_type_id=4) as rr on rr.post_id=p_id.post_id

		LEFT JOIN ".$prefix."post_cats_id as c_id on c_id.post_cat_id=rr.cat_id

		LEFT JOIN (select * from ".$prefix."post_cats as c where c.lang_id=".$this->session->userdata("lang_id").") as c  on c.post_cat_id = c_id.post_cat_id

		LEFT JOIN ".$prefix."users as u on u.id=p_id.user_id) as p
        WHERE p.deleted=0 ".$param;

		$total = $this->db->query("SELECT count(*) as count_rows FROM (".$sql." GROUP by post_id ) as t")->row();
		$data["total_row"] = $total->count_rows;

		$sql = $sql." GROUP by post_id  ORDER BY post_id DESC LIMIT ".$start.", ".$end;


		//echo $sql;
		$data["list"] = $this->db->query($sql)->result();
		return $data;
	}

	function get_numbers()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT * FROM '.$prefix.'phone WHERE id=1';

		return $this->db->query($query)->row();
	}

	function get_admin_mail()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT * FROM '.$prefix.'admin_mails WHERE id=1';

		return $this->db->query($query)->row();
	}

	function update_number($number)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'phone SET number = "'.$number.'" WHERE id=1';

		if($this->db->query($query))
			return true;
		else
			return false;
	}

	function update_admin_mail($mail)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'admin_mails SET to_mail = "'.$mail.'" WHERE id=1';

		if($this->db->query($query))
			return true;
		else
			return false;
	}

	function get_description()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT * FROM '.$prefix.'description';

		return $this->db->query($query)->result();
	}

	function update_description($description_az, $description_ru, $description_en, $description_tr)
	{
		$prefix = $this->db->dbprefix;
		$query = 'UPDATE '.$prefix.'description SET description = "'.$description_en.'" WHERE id=1';
		$query1 = 'UPDATE '.$prefix.'description SET description = "'.$description_az.'" WHERE id=2';
		$query2 = 'UPDATE '.$prefix.'description SET description = "'.$description_ru.'" WHERE id=3';
		$query3 = 'UPDATE '.$prefix.'description SET description = "'.$description_tr.'" WHERE id=4';

		if($this->db->query($query))
		{
			if($this->db->query($query1))
			{
				if($this->db->query($query2))
				{
					if($this->db->query($query3))
					return true;
					else
					return false;
				}else
				return false;
			}else
			return false;
		}else
		return false;
	}

}
