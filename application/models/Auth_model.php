<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
    function check_login($username, $password)
		{
			$key = $this->config->item('encryption_key');
			$salt1 = hash('sha512', $key.$password);
			$salt2 = hash('sha512', $password.$key);
			$hashed_password = md5(hash('sha512', $salt1.$password.$salt2));

			$this->db->select('*');
			$this->db->where('name', $username);
			$this->db->where('pass', $hashed_password);
			$this->db->where('active', 1);
			$this->db->where('deleted', 0);
			$this->db->from('users');
			return $this->db->get()->row();
		}








































}
