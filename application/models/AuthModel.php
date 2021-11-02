<?php

class AuthModel extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function addNewUser($array)
  {
    if($this->db->insert('site_users', $array))
      return true;
    else
      return false;
  }

  public function addNewUserAddress($array)
  {
    if($this->db->insert('addresses', $array))
      return true;
    else
      return false;
  }

  public function readLastUserId()
  {
    $query = 'select MAX(user_id) as id from ali_site_users';
    return $this->db->query($query)->result();
  }

  public function loginCheck($phone, $password)
  {
    $prefix = $this->db->dbprefix;
    $query = 'SELECT * FROM '.$prefix.'site_users WHERE phone="'.$phone.'" and password="'.$password.'"';

    return $this->db->query($query)->row();
  }
}
 ?>
