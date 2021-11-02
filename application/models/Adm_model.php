<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Adm_model extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }
	function orders($filter, $from, $end)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		$sql ="

		SELECT concat_ws(' ', u.lastname, u.firstname, u.middlename) as full_name, o.id,o.user_id, o.order_number, o.tmp_user_id, orn.address_id, orn.order_status_id,  sum(o.`count`) as product_count, sum(o.ex_price) as product_price, o.date_time, os.order_status_title  FROM ".$prefix."order_numbers as orn

		LEFT JOIN ".$prefix."orders as o on orn.order_number=o.order_number
		LEFT JOIN (select * from ".$prefix."order_status where lang_id=".$this->session->userdata("lang_id").") as os on os.order_status_id=orn.order_status_id
		LEFT JOIN ".$prefix."site_users as u on u.user_id=o.user_id
		LEFT JOIN ".$prefix."order_status_id as os_id on os_id.order_status_id=orn.order_status_id WHERE orn.order_status_id not in(8,9)
		Group by o.order_number";


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
  function admin_menu($role_id)
	{
		$prefix = $this->db->dbprefix;
		$query = "SELECT menus.*, am_id.parent_id, am_id.icon, am_id.link FROM
								(SELECT am.*  FROM ".$prefix."admin_menus as am
								 WHERE am.lang_id = ".$this->session->userdata("lang_id")."
								 UNION
								 SELECT am2.*  FROM ".$prefix."admin_menus as am2
								 WHERE am2.lang_id = 1 and am2.menu_id not in
								 		(SELECT menu_id FROM ".$prefix."admin_menus as am3
										 WHERE am3.lang_id = ".$this->session->userdata("lang_id").")
								) as menus
							LEFT JOIN ".$prefix."admin_menus_id as am_id on am_id.menu_id=menus.menu_id
							LEFT JOIN ".$prefix."relations as rel on rel.rel_item_id=am_id.menu_id
							WHERE am_id.active=1 AND am_id.deleted=0 AND rel.rel_type_id=1 AND am_id.menu_type_id=1 AND rel.item_id=".$role_id."
							ORDER BY am_id.order_by ASC";
		return $this->db->query($query)->result();
	}

	function just_test_and_nothing_else()
	{
		$querish = 'SELECT menus.*, am_id.parent_id, am_id.icon, am_id.link FROM
									(SELECT am.*  FROM ali_admin_menus as am
									 WHERE am.lang_id = 2
									 UNION
									 SELECT am2.* FROM ali_admin_menus as am2
									 WHERE am2.lang_id = 1 and am2.menu_id not in (SELECT menu_id FROM ali_admin_menus as am3 WHERE am3.lang_id = 2)
								 	) as menus
								LEFT JOIN ali_admin_menus_id as am_id on am_id.menu_id=menus.menu_id
								LEFT JOIN ali_relations as rel on rel.rel_item_id=am_id.menu_id
								WHERE am_id.active=1 and am_id.deleted=0 and rel.rel_type_id=1 and am_id.menu_type_id=1 and rel.item_id=1
								ORDER BY am_id.order_by ASC';
	}

	function insert_item($vars, $table_name)
	{
		return $this->db->insert($table_name, $vars);
	}

	function translation_update($meta_key, $meta_value, $lang)
	{
		$this->db->select('*');
		$this->db->from('langmeta');
		$this->db->where("meta_key", $meta_key);
		$this->db->where("lang_id", $lang);
		$result = $this->db->get()->row();
		if($result)
		{
			$this->db->where("meta_key", $meta_key);
			$this->db->where("lang_id", $lang);
			return $this->db->update("langmeta", array("meta_value"=>$meta_value));
		}else {
			$this->db->insert('langmeta', array("meta_value"=>$meta_value, "meta_key"=>$meta_key, "lang_id"=>$lang));
			return $this->db->insert_id();
		}
	}
	function update_item($case, $data, $table)
	{
		$this->db->from($table);
		$this->db->where($case);
		return $this->db->update($table, $data);
	}
	function get_page_title()
	{
		$prefix = $this->db->dbprefix;
		$link =  $this->uri->segment("1").$this->uri->segment("2");
		return $this->db->query("SELECT menus.*, am_id.parent_id, am_id.icon, am_id.link  FROM (SELECT am.*  FROM ".$prefix."admin_menus as am  where am.lang_id = ".$this->session->userdata("lang_id")." union SELECT am2.*  FROM ".$prefix."admin_menus as am2 where am2.lang_id = 1  and am2.menu_id not in(SELECT menu_id FROM ".$prefix."admin_menus as am3 where am3.lang_id = ".$this->session->userdata("lang_id").")) as menus LEFT JOIN ".$prefix."admin_menus_id as am_id on am_id.menu_id=menus.menu_id LEFT JOIN ".$prefix."relations as rel on rel.rel_item_id=am_id.menu_id where am_id.active=1 AND am_id.deleted=0 AND rel.rel_type_id=1 AND REPLACE(am_id.link, '/','')='".$link."'")->row();

	}
	function product_list($array, $start, $end)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		//print_r($array);
		if(isset($array["full_name"]) && @$array["full_name"]==TRUE)
		{
			$param = " AND (full_name like '%".strip_tags($array["full_name"])."%') ";
		}
		if(isset($array["subject"]) && @$array["subject"]==TRUE)
		{
			$param = " AND (subject like '%".strip_tags($array["subject"])."%') ";
		}
		if(isset($array["msg"]) && @$array["msg"]==TRUE)
		{
			$param = " AND (msg like '%".strip_tags($array["msg"])."%') ";
		}
		if(isset($array["date_time"]) && @$array["date_time"]==TRUE)
		{
			$date = explode("-", $array["date_time"]);
			$param = $param." AND date_time <='".$date[0]."' AND date_time >='".$date[1]."' ";
		}
		$sql ="SELECT c.name as cat_name, p_id.*, p.description, p.aditional_desc, p.title, p_img.img, concat_ws(' ', u.lastname, u.firstname, u.middlename) as full_name FROM `ali_products_id` as p_id

		LEFT JOIN (SELECT * FROM ali_products as p where p.lang_id=".$this->session->userdata("lang_id")." UNION SELECT * FROM ali_products as p2 where p2.lang_id=1 AND p_id not in(SELECT p_id FROM ali_products as p where p.lang_id=".$this->session->userdata("lang_id").")) as p on p.p_id=p_id.p_id

		LEFT JOIN ali_products_img as p_img on p_img.p_id=p_id.p_id

		LEFT JOIN ali_cats_id as c_id on c_id.cat_id=p_id.cat_id

		LEFT JOIN (select * from ali_cats as c where c.lang_id=".$this->session->userdata("lang_id")." Union select * from ali_cats as c1 where c1.lang_id=1 AND cat_id not in(select cat_id from ali_cats as c where c.lang_id=".$this->session->userdata("lang_id").")) as c  on c.cat_id = c_id.cat_id

		LEFT JOIN ali_users as u on u.id=p_id.user_id
		WHERE c_id.deleted=0 AND p_id.deleted=0 ".$param;

		$total = $this->db->query("SELECT count(*) as count_rows FROM (".$sql.") as t")->row();
		$data["total_row"] = $total->count_rows;

		$sql = $sql." ORDER BY date_time DESC LIMIT ".$start.", ".$end;
		$data["list"] = $this->db->query($sql)->result();
		return $data;
	}
	function get_langmeta($lang)
	{
		$prefix = $this->db->dbprefix;
		$sql = "SELECT langs.* FROM (SELECT lm.*  FROM ".$prefix."langmeta as lm  where lm.lang_id = ".$lang." union SELECT lm2.*  FROM ".$prefix."langmeta as lm2 where lm2.lang_id = 1  and lm2.meta_key not in(SELECT meta_key FROM ".$prefix."langmeta as lm3 where lm3.lang_id =".$lang." )) as langs LEFT JOIN ".$prefix."langs as l_id on l_id.lang_id=langs.lang_id where l_id.deleted=0  order by langs.meta_value ASC";
		//echo $sql;
		return 	$this->db->query($sql)->result();
	}
	function call_langs()
	{
		$result = $this->db->query("call call_langs()");
		$res = $result->result();
		$result->next_result();
		$result->free_result();
		return $res;
	}
    function get_all_admin_menus()
	{
		$this->db->select('am.id, am.parent_id, am.name, am.link, am.icon, am.menu_type_id');
		$this->db->from('admin_menus as am');
		$this->db->where('am.deleted', 0);
		$this->db->order_by("order_by", "asc");
		return $this->db->get()->result();
	}
	function get_user($user_id)
	{
		$this->db->select("*");
		$this->db->from("users");
		$this->db->where("id", $user_id);
		$this->db->where("deleted", 0);
		return $this->db->get()->row();
	}
    function check_email($email, $user_id=FALSE)
	{
		$this->db->select("id");
		$this->db->from("users");
		$this->db->where("email", $email);
		if($user_id)
		$this->db->where_not_in("id", intval($user_id));
		return $this->db->get()->num_rows();
	}
	function update_user($var, $user_id)
	{
		$this->db->where("id", $user_id);
		return $this->db->update("users", $var);
	}
  function get_role_list()
	{
		$this->db->select("*");
		$this->db->from("users_role");
		$this->db->where("active", 1);
		$this->db->where("deleted", 0);
		return $this->db->get()->result();
	}
  function check_role($url)
	{
		$prefix = $this->db->dbprefix;
		$sql = "SELECT menus.*, am_id.parent_id, am_id.icon, am_id.link  FROM (SELECT am.*  FROM ".$prefix."admin_menus as am  where am.lang_id = ".$this->session->userdata("lang_id")." union SELECT am2.*  FROM ".$prefix."admin_menus as am2 where am2.lang_id = 1  and am2.menu_id not in(SELECT menu_id FROM ".$prefix."admin_menus as am3 where am3.lang_id = ".$this->session->userdata("lang_id").")) as menus LEFT JOIN ".$prefix."admin_menus_id as am_id on am_id.menu_id=menus.menu_id LEFT JOIN ".$prefix."relations as rel on rel.rel_item_id=am_id.menu_id where am_id.active=1 AND am_id.deleted=0 AND rel.rel_type_id=1 AND rel.item_id=".$this->session->role_id." AND REPLACE(am_id.link, '/','')='".$url."'";
		//echo $sql;
		return $this->db->query($sql)->row();
	}
	public function langs()
  {
		$this->db->select("*");
		$this->db->from("langs");
		$this->db->where("deleted", 0);
		$this->db->order_by("order_by", "ASC");
		return $this->db->get()->result();
	}
	function check_method($id)
	{
		$this->db->select('am.id, am.parent_id, am.name, am.link, am.icon, am.menu_type_id');
		$this->db->order_by("order_by", "asc");
		$this->db->from('relations as rel');
		$this->db->join('admin_menus as am', 'am.id = rel.rel_item_id', 'left');
		$this->db->where('am.status_id', 1);
		$this->db->where('rel.type', 1);//Type Number of Relations table for Admin Menus
		$this->db->where('rel.item_id', $this->session->userdata("role_id"));
		$this->db->where('am.id', $id);
		return $this->db->get()->row();
	}


	public function order_status_id()
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("Select or_id.*, ors.order_status_title from ".$prefix."order_status_id as or_id left join (select * from ".$prefix."order_status as ors where ors.lang_id=".$this->session->userdata("lang_id").") as ors on ors.order_status_id=or_id.order_status_id where or_id.order_status_id not in(8,9)")->result();
	}
  function add_user($var)
	{
		$this->db->select("id");
		$this->db->from("users");
		$this->db->where("name", $var['name']);
		$result = $this->db->get()->row_array();
		if(@$result['id']>0)
		{
			return FALSE;
		}else
		{
			$this->db->insert('users', $var);
			return $this->db->insert_id();
		}
	}
    function user_list($vars, $from, $end)
	{

		$param = "";
		if(isset($vars["job"]))
			$param = " AND u.job like '%".strip_tags($vars["job"])."%' ";
		if(isset($vars["email"]))
			$param = " AND u.email like '%".strip_tags($vars["email"])."%' ";
		if(isset($vars["full_name"]))
			$param = " AND u.full_name like '%".strip_tags($vars["full_name"])."%' ";
		if(isset($vars["address"]))
			$param = " AND u.address like '%".$vars["address"]."%' ";
		if(@$vars["gender_id"])
			$param = " AND u.gender_id=".$vars["gender_id"]." ";
		if(@$vars["status_id"])
			$param = " AND u.status_id=".$vars["status_id"]." ";
		if(@$vars["role_id"])
			$param = " AND u.role_id=".$vars["role_id"]." ";


		if(isset($array["date_time"]) && @$array["date_time"]==TRUE)
		{
			$date = explode("-", $array["date_time"]);
			$param = $param." AND u.register_date <='".$date[0]."' AND u.register_date >='".$date[1]."' ";
		}

		$sql= "SELECT u.*, s.status_name, g.gender_name, r.name as role_name FROM ".$this->db->dbprefix."users as u LEFT JOIN ".$this->db->dbprefix."users_role as r on r.id=u.role_id LEFT JOIN ".$this->db->dbprefix."genders as g on g.id=u.gender_id LEFT JOIN ".$this->db->dbprefix."status as s on s.id=u.status_id WHERE u.deleted=0 ".$param;

		$total = $this->db->query("SELECT count(*) as count_rows FROM (".$sql.") as t")->row();
		$data["total_row"] = $total->count_rows;

		$sql = $sql." ORDER BY u.register_date DESC LIMIT ".$from.", ".$end;

		$data["list"] = $this->db->query($sql)->result();

		return $data;

	}
    public function get_menu_list($role_id)
    {
			$prefix = $this->db->dbprefix;
		/*$this->db->select("am.*, ifnull(rel.id,0) as rel_id, mt.menu_type_name, s.status_name");
		$this->db->from("admin_menus as am");
		$this->db->join('relations as rel', 'rel.rel_item_id = am.id', 'left');
		$this->db->join('menu_types as mt', 'mt.id = am.menu_type_id', 'left');
		$this->db->join('status as s', 's.id = am.status_id', 'left');
		$this->db->WHERE("am.deleted", 0);
		$this->db->WHERE("rel.item_id", $role_id);
		$this->db->or_where("COALESCE(rel.item_id,0)", 0);
		return $this->db->get()->result();*/
		/*return $this->db->query("SELECT menus.*,  ifnull(menus2.menu_id, 0) as rel_id FROM
		(SELECT am.*, 0 as rel_id, mt.menu_type_name FROM ".$this->db->dbprefix."admin_menus_id as am_id
		left join ".$this->db->dbprefix."admin_menus as am on am.menu_id = am_id.menu_id
		LEFT JOIN ".$this->db->dbprefix."menu_types as mt ON mt.menu_type_id = am_id.menu_type_id
		WHERE am_id.deleted =0 ORDER by am_id.order_by ASC) as menus
		LEFT JOIN (SELECT am_id.menu_id, am_id.order_by, rel.rel_item_id, rel.id FROM
		".$this->db->dbprefix."admin_menus_id as am_id
		LEFT join ".$this->db->dbprefix."admin_menus as am on am.menu_id = am_id.menu_id
		LEFT JOIN ".$this->db->dbprefix."relations as rel ON rel.rel_item_id = am_id.menu_id
		WHERE am_id.deleted =0 AND rel.item_id = '".$role_id."') as menus2 on menus2.rel_item_id=menus.menu_id")->result();*/
		return $this->db->query("SELECT am_id.*, am.full_name, mt.menu_type_name, r.id as permission FROM `".$prefix."admin_menus_id` as am_id
														 LEFT JOIN (SELECT am.*  FROM ".$prefix."admin_menus as am
															 					WHERE am.lang_id = ".$this->session->userdata("lang_id")."
																				UNION
																				SELECT am2.*  FROM ".$prefix."admin_menus as am2
																				WHERE am2.lang_id = 1 and am2.menu_id not in (SELECT menu_id FROM ".$prefix."admin_menus as am3 where am3.lang_id = ".$this->session->userdata("lang_id").")
																			 ) as am on am.menu_id = am_id.menu_id
														 LEFT JOIN ".$prefix."menu_types as mt on mt.menu_type_id=am_id.menu_type_id
														 LEFT JOIN ".$prefix."relations as r on r.rel_item_id=am_id.menu_id and r.rel_type_id=1 and r.item_id=".$role_id."
														 WHERE am_id.deleted=0 and r.id is not null")->result_array();
	}
	public function select_where_row($select, $where, $table_name, $order_by = false)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->from($table_name);

		if($order_by)
			$this->db->order_by($order_by[0], $order_by[1]);

		return $this->db->get()->row();
	}
	public function select_where($select, $where, $table_name, $order_by = false)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->from($table_name);

		if($order_by)
			$this->db->order_by($order_by[0], $order_by[1]);

		return $this->db->get()->result();
	}

	public function get_admin_users()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT u.id, u.name, u.email, u.gender, u.full_name, u.register_date, u.active, ur.name as "role" FROM '.$prefix.'users as u
							LEFT JOIN (SELECT id, name FROM '.$prefix.'users_role
												 WHERE active = 1 and deleted = 0) as ur on ur.id = u.role_id
							WHERE u.deleted = 0';

		return $this->db->query($query)->result();
	}

	public function get_menu_item($menu_id)
	{
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT am_id.*, am.full_name, am.lang_id FROM `".$prefix."admin_menus` as am
			LEFT JOIN `".$prefix."admin_menus_id` as am_id on am.menu_id = am_id.menu_id WHERE am_id.menu_id=".$menu_id)->result_array();
	}
  public function get_all_menus()
  {
			$prefix = $this->db->dbprefix;
			return $this->db->query("SELECT am_id.*, am.full_name FROM `".$prefix."admin_menus_id` as am_id
LEFT JOIN (SELECT am.*  FROM ".$prefix."admin_menus as am  where am.lang_id = ".$this->session->userdata("lang_id")." union SELECT am2.*  FROM ".$prefix."admin_menus as am2 where am2.lang_id = 1  and am2.menu_id not in(SELECT menu_id FROM ".$prefix."admin_menus as am3 where am3.lang_id = ".$this->session->userdata("lang_id").")) as am on am.menu_id = am_id.menu_id WHERE am_id.deleted=0 and am_id.menu_type_id=1 and am_id.parent_id=0")->result_array();
	}
    public function update_menu_permissions($menus_id, $role_id)
    {
		$this->db->where("item_id", $role_id);
		$this->db->where("type", 1);
		$result =  $this->db->delete("relations");
		if($result)
		{
			foreach($menus_id as $key=>$value)
			$data[] = array("rel_item_id"=>$value, "item_id"=>$role_id, "type"=>1);
			return $this->db->insert_batch('relations', $data);
		}else
		{
			return false;
		}
	}

    public function save_menu_order($vars)
    {
		$result = "";
		foreach($vars as $menu)
		{
			$parent_id = @$menu["parentId"]?$menu["parentId"]:0;
			$menus =  array(
			"parent_id"=>$parent_id,
			"order_by" => $menu["order"]
			);

			$this->db->where("id", $menu["id"]);
			$result = $this->db->update("admin_menus", $menus);
		}
		return $result;
	}
    public function delete_menu($vars)
    {

		$this->db->where("id", $vars["id"]);
		$result = $this->db->update("admin_menus", $vars);
		return $result;
	}
    public function get_statuses()
    {
		return $this->db->get("status")->result();
	}
    public function menu_types()
    {
		return $this->db->get("menu_types")->result();
	}
    function add_menu($vars)
	{

		$this->db->insert('admin_menus', $vars);
		$id = $this->db->insert_id();
		if($id)
		$this->db->insert('admin_menus', array("rel_item_id"=>$id, "item_id"=>1, "type"=>1));
		return $id;

	}
    public function get_menu($menu_id)
    {
		$this->db->select("*");
		$this->db->where("id", $menu_id);
		$this->db->from("admin_menus");
		return $this->db->get()->row();
	}
    public function update_menu($vars, $menu_id)
    {
		unset($vars[$this->security->get_csrf_token_name()]);
		$this->db->where("id", $menu_id);
		return $this->db->update("admin_menus", $vars);
	}



























	function update_settings($vars)
	{
		$this->db->where("id", 1);
		return $this->db->update("settings", $vars);
	}
	function get_settings()
	{
		$this->db->select("*");
		$this->db->from('settings');
		$this->db->where("id", 1);
		$query = $this->db->get();
		return 	$query->row();
	}

	function get_translations()
	{
		$this->db->select("*");
		$this->db->from('langmeta');
		$query = $this->db->get();
		return 	$query->result();
	}
	// function translation_update($meta_key, $meta_value, $lang)
	// {
	// 	$this->db->where("meta_key", $meta_key);
	// 	$this->db->where("lang", $lang);
	// 	return $this->db->update("langmeta", array("meta_value"=>$meta_value));
	// }




	function get_users()
	{
		$this->db->select("id, full_name");
		$this->db->from("users");
		return $this->db->get()->result();
	}
	function user_categories($user_id)
	{
		$this->db->select("*");
		$this->db->from("user_relationship");
		$this->db->where("user_id", $user_id);
		return $this->db->get()->result();
	}


	function delete_user($user_id)
	{
		return $this->db->query("users_delete @id ='".$user_id."'")->row();
	}
	function change_user_status($user_id, $user_status)
	{
		$result = $this->db->query("Update ".$this->db->dbprefix."users set active=".$user_status." WHERE id=".$user_id);
		return $result;
	}


	function check_menu_role($menu_id, $status)
	{
		$this->db->select("id");
		$this->db->from("admin_menus");
		$this->db->where("id", $menu_id);
		$this->db->where($status, 1);
		$query = $this->db->get();
		if ($query->num_rows()>0) {
	      return 1;
	    } else {
	      return 0;
	    }
	}


	function check_role_name($role_name)
	{
		if($this->db->field_exists($role_name, 'admin_menus'))
		{
			return TRUE;
		}else
		{
			return FALSE;
		}
	}
	function create_new_role($role_name)
	{
		$this->load->dbforge();
		$fields = array(
                        $role_name => array('type' => 'tinyint','constraint' => '1','default' => '0')
		);
		return $this->dbforge->add_column('admin_menus', $fields);
	}
	function delete_role($role_name)
	{
		$this->load->dbforge();
		return $this->dbforge->drop_column('admin_menus', $role_name);
	}
	function update_user_roles($menu_id_off, $menu_id_on, $status)
	{
		$result = "";
		if($menu_id_off)
		{
			//implode(',', array_map('intval', $array))
			//$this->db->query("")
			$this->db->where_in("id", explode(",", substr($menu_id_off, 0, -1)));
			$result = $this->db->update("admin_menus", array($status=>0));
		}
		if($menu_id_on)
		{
			$this->db->where_in("id",  explode(",", substr($menu_id_on, 0, -1)));
			$result = $this->db->update("admin_menus", array($status=>1));
		}
		return $result;
	}

	function site_menus()
	{
		$this->db->select("*");
		$this->db->from("menus");
		return $this->db->get()->result_array();
	}

	function get_category()
	{
		$this->db->select("full_name_az, id, parent_id");
		$this->db->from("site_menus");
		$this->db->where("type_id", 2);
		return $this->db->get()->result_array();
	}
	function get_order_details($order_number)
	{
			$prefix = $this->db->dbprefix;
			/*$where = "";
			if($this->session->userdata("user_id"))
				$where = " o.user_id=".$this->session->userdata("user_id");
			if($this->session->userdata("user_id") && $this->session->userdata("tmp_user"))
				$where = $where." OR o.tmp_user_id='".$this->session->userdata("tmp_user")."' ";
			if(!$this->session->userdata("user_id") && $this->session->userdata("tmp_user"))
				$where = " o.tmp_user_id='".$this->session->userdata("tmp_user")."' ";*/

			$sql ="SELECT * FROM (
				SELECT o.*, p_id.p_id, p_id.`sku`, p.title as product_title, c.color_name, p_img.img as thumb  FROM ".$prefix."orders as o
				LEFT JOIN ".$prefix."products_im_ex as im_ex  on im_ex.id=o.product_id
				LEFT JOIN ".$prefix."products_id as p_id  on p_id.p_id=o.product_id
				LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$this->session->userdata("lang_id").") as p on p.p_id=o.product_id
				LEFT JOIN (SELECT * FROM ".$prefix."colors as c where c.lang_id=".$this->session->userdata("lang_id").") as c on c.color_id=o.color_id
				LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl
					LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img GROUP BY p_id) tbl1 ON tbl1.p_id = tbl.p_id WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=o.product_id
				WHERE o.order_number=".$order_number.") as b";
				//echo $sql;
				return $this->db->query($sql)->result();

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
	function get_parent_menu($id)
	{
		$this->db->select("full_name_az");
		$this->db->from("site_menus");
		$this->db->where("id", $id);
		return $this->db->get()->row();
	}
	function set_post_approve($id)
	{
		$this->db->where_in("id", $id);
		return $this->db->update("news", array("approve"=>1));
	}











}
