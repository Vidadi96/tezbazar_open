<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SlidesModel extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }

	function img_upload_main($dest100x50, $dest1000x500, $name, $slide_name, $size1, $size2, $link)
	{
		$prefix = $this->db->dbprefix;
		$query = 'insert into '.$prefix.'slide_new (name, image_name, destination, image_size, link) VALUES ( "'.$slide_name.'", "'.$name.'", "'.$dest100x50.'", "'.$size1.'", "'.$link.'")';
		$query2 = 'insert into '.$prefix.'slide_new (name, image_name, destination, image_size, link) VALUES ( "'.$slide_name.'", "'.$name.'", "'.$dest1000x500.'", "'.$size2.'", "'.$link.'")';
		$this->db->query($query);
		$this->db->query($query2);
	}

	function get_view_main($name, $size)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select id, destination, link from '.$prefix.'slide_new where name = "'.$name.'" and image_size = "'.$size.'"';

		return $this->db->query($query)->result();
	}

	function get_image_name_main($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select image_name from '.$prefix.'slide_new where id='.$id;

		return $this->db->query($query)->result();
	}

	function delete_slide_main($image_name)
	{
		$prefix = $this->db->dbprefix;
		$query = 'delete from '.$prefix.'slide_new where image_name="'.$image_name.'"';

		$this->db->query($query);
	}

	function get_destination_main($image_name)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select destination from '.$prefix.'slide_new where image_name="'.$image_name.'"';

		return $this->db->query($query)->result();
	}

	function get_slide_settings($name)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select time, active_passive from '.$prefix.'slide_settings where name="'.$name.'"';

		return $this->db->query($query)->result();
	}

	function save_settings($name, $time, $active)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select * from '.$prefix.'slide_settings where name="'.$name.'"';

		$data = $this->db->query($query)->result();

		if(count($data)>0)
			$query2 = 'update '.$prefix.'slide_settings set time='.$time.', active_passive='.$active.' where name="'.$name.'"';
		else
			$query2 = 'insert into '.$prefix.'slide_settings (name, time, active_passive) VALUES ("'.$name.'", '.$time.','.$active.')';

		if($this->db->query($query2))
			return true;
		else
			return false;
	}
}
