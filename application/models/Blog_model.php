<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Blog_model extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }
  function get_news($from, $end, $total_row=0)
  {
		$prefix = $this->db->dbprefix;
		$order=" ORDER by p_id.post_id DESC";
		$where = "";
    $data = [];
		$sql ="SELECT  p.*, p_id.thumb, p_id.date_time FROM ".$prefix."posts_id as p_id
    LEFT JOIN (SELECT * FROM ".$prefix."posts as p where p.lang_id=".$this->session->userdata("lang_id").") as p on p.post_id=p_id.post_id
		LEFT JOIN ".$prefix."relations as r on r.item_id=p_id.post_id
    WHERE p_id.deleted=0 AND r.rel_type_id=4 and r.rel_item_id=2 AND p_id.active=1 ".$where."  ";

		$data["list"]=  $this->db->query($sql.($order." limit ".$from.", ".$end))->result();
		if($total_row)
		$data["total_row"]=  $this->db->query("Select count(*) as total_row from(".$sql.") as aa")->row();

		return $data;

  }
	function get_blog_item($id)
	{
		$prefix = $this->db->dbprefix;
		$sql ="SELECT  p.*, p_id.thumb, p_id.date_time FROM ".$prefix."posts_id as p_id
    LEFT JOIN (SELECT * FROM ".$prefix."posts as p where p.post_id=".$id." AND p.lang_id=".$this->session->userdata("lang_id").") as p on p.post_id=p_id.post_id

    WHERE p_id.deleted=0  AND p_id.active=1 AND p_id.post_id=".$id;
		return $this->db->query($sql)->row();

			//$this->universal_model->delete_item_where(array("rel_type_id"=>4, "item_id"=>$post_id), "relations");

	}



}
