<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax_model extends CI_Model
{
	function __construct()
  {
    parent::__construct();
  }
	function get_product_name($lang_id, $query)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT p.p_id as data, p.title as value FROM ".$prefix."products as p LEFT JOIN  ".$prefix."products_id as p_id on p.p_id=p_id.p_id WHERE p_id.deleted=0 AND p.lang_id=".$lang_id." AND p.title like '%".$query."%' ORDER by p_id.p_id DESC LIMIT 0, 50")->result_array();
	}
    public function get_params($param_group_id)
    {
        $param = "";
        $prefix = $this->db->dbprefix;
        return $this->db->query("SELECT pt.param_type_id, pt.param_type_title, pg.param_group_title, p_id.param_id, p_id.order_by, p_id.active, p.param_title, p.lang_id from ".$prefix."params_id as p_id LEFT JOIN
		(select * from ".$prefix."params as p where p.lang_id=".$this->session->userdata("lang_id")."
		Union select * from ".$prefix."params as p1 where p1.lang_id=1 AND p1.param_id not in(select param_id from ".$prefix."params as p3 where p3.lang_id=".$this->session->userdata("lang_id").")) as p on p.param_id=p_id.param_id
		LEFT JOIN (SELECT * from ".$prefix."param_groups as pg where pg.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."param_groups as pg1 where pg1.lang_id=1 AND pg1.param_group_id not in(select param_group_id from ".$prefix."param_groups as pg3 where pg3.lang_id=".$this->session->userdata("lang_id").")) as pg on pg.param_group_id = p_id.param_group_id LEFT JOIN ".$prefix."param_types as pt on pt.param_type_id=p_id.param_type_id  where p_id.deleted=0 AND p_id.active=1 AND p_id.param_group_id=".$param_group_id)->result();
    }
    public function get_sub_params($param_id)
    {
        $param = "";
        $prefix = $this->db->dbprefix;
        return $this->db->query("SELECT p_id.sub_param_id, p_id.active, p.sub_param_title, p.lang_id from ".$prefix."sub_params_id as p_id LEFT JOIN
		(select * from ".$prefix."sub_params as p where p.lang_id=".$this->session->userdata("lang_id")."
		Union select * from ".$prefix."sub_params as p1 where p1.lang_id=1 AND p1.sub_param_id not in(select sub_param_id from ".$prefix."sub_params as p3 where p3.lang_id=".$this->session->userdata("lang_id").")) as p on p.sub_param_id=p_id.sub_param_id  where p_id.deleted=0 AND p_id.active=1 AND p_id.param_id=".$param_id)->result();
    }
  function get_categories($parent_id)
  {
    $type_column = "";
    if(!$parent_id)
    $type_column=", 'root' as type";
    $prefix = $this->db->dbprefix;
    //c_id.parent_id, IF(c_id2.cat_id IS NULL,'open','closed') as state,  IF(c_id2.cat_id IS NULL, false, true) as children".$type_column."
    return $this->db->query("SELECT IF(c_id2.cat_id IS NULL,'open','closed') as state, cats.cat_id as id,  cats.name as text from ".$prefix."cats_id as c_id LEFT JOIN (select * from ".$prefix."cats as c where c.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."cats as c1 where c1.lang_id=1 AND cat_id not in(select cat_id from ".$prefix."cats as c where c.lang_id=".$this->session->userdata("lang_id").")) as cats on cats.cat_id=c_id.cat_id LEFT JOIN ".$prefix."cats_id as c_id2 on c_id2.parent_id=c_id.cat_id AND c_id2.deleted=0 AND c_id2.active=1 WHERE c_id.deleted=0 AND c_id.active=1  AND c_id.parent_id=".$parent_id." GROUP BY cats.cat_id ORDER by c_id.parent_id ASC")->result();
    //{"id":"1","text":"Node 1","state":"closed"}
  }
  function get_brands()
  {
    //$type_column = "";
    $type_column=", 'root' as type";
    $prefix = $this->db->dbprefix;
    //b_id.parent_id, IF(b_id2.brand_id IS NULL,'open','closed') as state,  IF(b_id2.brand_id IS NULL, false, true) as children".$type_column."
    return $this->db->query("SELECT 'closed' as state, brands.brand_id as id,  brands.name as text from ".$prefix."brands_id as b_id LEFT JOIN (select * from ".$prefix."brands as c where c.lang_id=".$this->session->userdata("lang_id")." Union select * from ".$prefix."brands as c1 where c1.lang_id=1 AND brand_id not in(select brand_id from ".$prefix."brands as c where c.lang_id=".$this->session->userdata("lang_id").")) as brands on brands.brand_id=b_id.brand_id GROUP BY brands.brand_id ORDER by brands.name ASC")->result();
    //{"id":"1","text":"Node 1","state":"closed"}
  }
	function get_roles()
  {
    $type_column=", 'root' as type";
    $prefix = $this->db->dbprefix;

		return $this->db->query("SELECT 'closed' as state, id, name from ".$prefix."users_role WHERE active = 1 and deleted = 0")->result();
  }










}
