<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vacancy_model extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }


	function vacancy_item($id)
	{
		$param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT v.*, v_id.thumb, v_id.date_time, v_id.active from ".$prefix."vacancy as v LEFT JOIN ".$prefix."vacancy_id as v_id on v_id.vacancy_id=v.vacancy_id where v_id.deleted=0 and v_id.vacancy_id=".$id)->result_array();
	}
	function vacancy_list()
	{
    $param = "";
		$prefix = $this->db->dbprefix;
		return $this->db->query("SELECT v_id.*, u.full_name, v.title, v.content from ".$prefix."vacancy_id as v_id LEFT JOIN (SELECT * FROM ".$prefix."vacancy where lang_id=".$this->session->userdata("lang_id").") as v on v.vacancy_id=v_id.vacancy_id
		LEFT JOIN ".$prefix."users as u on u.id=v_id.user_id

		")->result();
	}





}
