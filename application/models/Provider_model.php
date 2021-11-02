<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Provider_model extends CI_Model
{
  public function add_provider($full_name, $corporate_name, $phone)
  {
    $prefix = $this->db->dbprefix;
    $query = 'INSERT INTO '.$prefix.'providers (full_name, corporate_name, phone) VALUES ("'.$full_name.'","'.$corporate_name.'","'.$phone.'")';

    if($this->db->query($query))
      return true;
    else
      return false;
  }

  public function providers_list()
  {
    $prefix = $this->db->dbprefix;
    $query = 'SELECT * FROM '.$prefix.'providers';

    return $this->db->query($query)->result();
  }

  public function delete_provider($id)
  {
    $prefix = $this->db->dbprefix;
    $query = 'DELETE FROM '.$prefix.'providers WHERE id='.$id;

    if($this->db->query($query))
      return true;
    else
      return false;
  }

  public function active_passive($id, $active_passive)
  {
    $prefix = $this->db->dbprefix;
    $query = 'UPDATE '.$prefix.'providers SET active_passive='.$active_passive.' WHERE id='.$id;

    if($this->db->query($query))
      return true;
    else
      return false;
  }
}
