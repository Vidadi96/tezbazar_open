<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UsersModel extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }

	function readWaiting($from, $count)
	{
		$prefix = $this->db->dbprefix;
		$query = "SELECT ec.*, su.user_id, su.firstname, su.lastname, su.middlename, su.company_name, su.status, su.phone, ec.pdf_path FROM ".$prefix."site_users as su
							LEFT JOIN (SELECT buyer_id, contract_number, voen, address, pdf_path FROM ".$prefix."export_contracts) as ec on ec.buyer_id = su.user_id
							LIMIT ".$from.", ".$count;
		return $this->db->query($query)->result();
	}

	function readWaiting_rows()
	{
		$prefix = $this->db->dbprefix;
		$query = "SELECT count(*) as 'count' from ".$prefix."site_users";

		return $this->db->query($query)->row();
	}

	function changeStatus($id, $activePassive)
	{
		$prefix = $this->db->dbprefix;
		$query = "update ".$prefix."site_users set status = ".$activePassive." where user_id = ".$id;
		$this->db->query($query);
	}

	function delete_user($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'delete from '.$prefix.'site_users where user_id='.$id;
		$query2 = 'delete from '.$prefix.'addresses where user_id='.$id;
		$this->db->query($query);
		$this->db->query($query2);
	}
}
