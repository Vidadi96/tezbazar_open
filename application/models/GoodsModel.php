<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class GoodsModel extends CI_Model
{
	function __construct()
  {
      parent::__construct();
  }

	function get_categories($lang)
	{
		$this->db->select("c_id.parent_id, c_id.icon, c_id.on_menu, c_id.deleted, c_id.order_by, c_id.discount_id, c_id.active,  c.*");
		$this->db->from("cats_id as c_id");
		$this->db->join('cats as c', 'c.cat_id = c_id.cat_id', 'left');
		$this->db->where("c_id.deleted", 0);
		$this->db->where("c_id.on_menu", 1);
		$this->db->where("c_id.active", 1);
		$this->db->where("c.lang_id", $lang);
		$this->db->order_by("c_id.order_by", "ASC");
		return $this->db->get()->result();
	}

  function product($id, $lang)
	{
		$prefix = $this->db->dbprefix;

		return $this->db->query("select p.* FROM ( SELECT b.name as brand_name, rr.cat_id,  p_id.*, p.description, p.content, p.title, im_ex.ex_price, p_img.img, u.full_name FROM `".$prefix."products_id` as p_id
			LEFT JOIN (SELECT * FROM ".$prefix."products as p where p.lang_id=".$lang."
								 union
								 SELECT * FROM ".$prefix."products as p2
								 where p2.lang_id=1 AND p_id not in(SELECT p_id FROM ".$prefix."products as p
								 																		where p.lang_id=".$lang.")) as p on p.p_id=p_id.p_id
			LEFT JOIN (SELECT * FROM ".$prefix."brands as b
								 where b.lang_id=".$lang."
								 union
								 SELECT * FROM ".$prefix."brands as b2
								 where b2.lang_id=1 AND brand_id not in(SELECT brand_id FROM ".$prefix."brands as b where b.lang_id=".$lang.")) as b on b.brand_id=p_id.brand_id
			LEFT JOIN (SELECT r.item_id as p_id, r.rel_item_id as cat_id FROM ".$prefix."relations as r
								 WHERE r.item_id=".$id." and r.rel_type_id=2 order by id DESC limit 0, 1) as rr on rr.p_id=p_id.p_id
			LEFT JOIN (SELECT ex_price, product_id FROM ".$prefix."products_im_ex
								 where `im_ex` is true and product_id=".$id." limit 1) as im_ex on im_ex.product_id = p_id.p_id
			LEFT JOIN (SELECT tbl.* FROM ".$prefix."products_img tbl
								 LEFT JOIN (SELECT p_id, MIN(`index`) as min_index FROM ".$prefix."products_img
								 						GROUP BY p_id ) tbl1 ON tbl1.p_id = tbl.p_id
								 WHERE tbl1.min_index = tbl.index) as p_img on p_img.p_id=p_id.p_id
			LEFT JOIN ".$prefix."users as u on u.id=p_id.user_id) as p
			WHERE p.deleted=0 AND p.active=1 AND p.parent_id=0 and p_id=".$id)->row();
	}

  function get_more_item($table_name, $where, $isarray=0, $order_by=false)
	{
		$this->db->select("*");
		$this->db->from($table_name);
		if($where)
		$this->db->where($where);

		if($order_by)
		$this->db->order_by($order_by[0], $order_by[1]);

		if($isarray)
			return $this->db->get()->result_array();
		else
			return $this->db->get()->result();
	}

  // function get_product_colors($product_id, $lang)
	// {
	// 	$prefix = $this->db->dbprefix;
	// 	return $this->db->query("
  //     SELECT im_ex.*, sum(im_ex.count) as counts, c_id.color_name, c_id.color_code FROM ".$prefix."products_im_ex as im_ex
	//
  //     LEFT JOIN (SELECT colors.*, c_id.color_code, c_id.active from ".$prefix."colors_id as c_id
  //     	LEFT JOIN(select * from ".$prefix."colors as b where b.lang_id=".$lang."
  //     	Union select * from ".$prefix."colors as w1 where w1.lang_id=1 AND w1.color_id not in(select color_id from ".$prefix."colors as m3 where m3.lang_id=".$lang.")) as colors on colors.color_id=c_id.color_id where c_id.deleted=0 and c_id.active=1) as c_id on c_id.color_id=im_ex.color_id
  //     where im_ex.product_id=".$product_id." GROUP BY im_ex.color_id  ORDER by im_ex.id DESC
	// 		 ")->result();
	// }

	function get_product_count($product_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT sum(prod.count) as "count", prod.measure FROM
								(SELECT (im_ex.count - IF(ISNULL(SUM(pr.count)), 0, SUM(pr.count))) AS "count", m.title as "measure", im_ex.product_id FROM '.$prefix.'products_im_ex as im_ex
								LEFT JOIN (SELECT measure_id, title FROM '.$prefix.'measures WHERE lang_id = '.$lang.') as m on m.measure_id = im_ex.measure_id
								LEFT JOIN (SELECT pie.count, pr.import_id, pr.export_id FROM '.$prefix.'products_im_ex_rel as pr
													 LEFT JOIN (SELECT id, count FROM '.$prefix.'products_im_ex) as pie on pie.id = pr.export_id) as pr on pr.import_id = im_ex.id
								WHERE im_ex.im_ex = 0 and im_ex.product_id = '.$product_id.'
								GROUP BY im_ex.id) as prod
							GROUP BY prod.product_id';

		return $this->db->query($query)->row();
	}

	function get_ordered_count($id, $user_id)
	{
		$prefix = $this->db->dbprefix;
		$user_id_where = $this->session->userdata('user_id')?' and onum.user_id = '.$this->session->userdata('user_id'):' and onum.tmp_user_id = "'.$this->session->userdata('tmp_user').'"';

		$query = 'SELECT sum(count) as "count" FROM '.$prefix.'orders as o
							LEFT JOIN (SELECT order_number, order_status_id, user_id, tmp_user_id FROM '.$prefix.'order_numbers) as onum on onum.order_number = o.order_number
							WHERE o.product_id = '.$id.' and onum.order_status_id in (8,10,16)'.$user_id_where.'
							GROUP BY o.product_id';

		return $this->db->query($query)->row();
	}

	function get_product_param($product_id, $lang)
	{
			$prefix = $this->db->dbprefix;
			return $this->db->query("SELECT pr.*,  params.param_title, sub_params.sub_param_title, p_id.param_group_id  FROM ".$prefix."prarm_rel_id as pr
			LEFT JOIN ".$prefix."params_id as p_id on p_id.param_id=pr.param_id

			LEFT JOIN (SELECT * FROM ".$prefix."params as p where p.lang_id=".$lang." UNION SELECT * FROM ".$prefix."params as p2 where p2.lang_id=1 AND param_id not in(SELECT param_id FROM ".$prefix."params as p where p.lang_id=".$lang.")) as params on params.param_id=p_id.param_id

			LEFT JOIN (SELECT * FROM ".$prefix."sub_params as p where p.lang_id=".$lang." UNION SELECT * FROM ".$prefix."sub_params as p2 where p2.lang_id=1 AND sub_param_id not in(SELECT sub_param_id FROM ".$prefix."sub_params as p where p.lang_id=".$lang.")) as sub_params on sub_params.sub_param_id=pr.param_value

			where pr.product_id=".$product_id)->result();
	}

	function get_product_colors2($id)
	{
		$prefix = $this->db->dbprefix;
		$query="select im_ex.color_id, color.color_code FROM ".$prefix."products_im_ex as im_ex
						LEFT JOIN ".$prefix."colors_id as color on color.color_id=im_ex.color_id
						WHERE product_id=".$id." group by color_id";

		return $this->db->query($query)->result();
	}

	function get_product_sizes($product_id, $color_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = "select mn.mn_id, if(isnull(mn.title), '', mn.title) as title, im_ex.ex_price, p.discount FROM ".$prefix."products_im_ex as im_ex
							left join (select * from ".$prefix."measure_names as mn where mn.lang_id=".$lang.") as mn on mn.mn_id=im_ex.mn_id
							left join (select p.discount, p.p_id from ".$prefix."products_id as p) as p on im_ex.product_id=p.p_id
							where im_ex.product_id=".$product_id." and im_ex.color_id=".$color_id;

		return $this->db->query($query)->result();
	}

	function get_category($cat_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select cat_id, name FROM '.$prefix.'cats WHERE cat_id = '.$cat_id.' and lang_id='.$lang;

		return $this->db->query($query)->result();
	}

	function get_similar_posts($product_id, $lang)
	{
		$prefix = $this->db->dbprefix;

		$id_array = [];
		$query = 'SELECT * FROM(
								select c.cat_id FROM '.$prefix.'relations as rel
								LEFT JOIN (select c.cat_id from '.$prefix.'cats_id as c where c.deleted=0) as c on rel.rel_item_id=c.cat_id
							  WHERE item_id='.$product_id.') as ec
							WHERE ec.cat_id is not null';
		$id_array = $this->db->query($query)->result();

		if($id_array)
		{
			$text = "rel_item_id=".$id_array[0]->cat_id;
			if(count($id_array)>1)
			{
				for ($i=1; $i < count($id_array); $i++) {
					$text = $text." or rel_item_id=".$id_array[$i]->cat_id;
				}
			}

			$query2 =  'SELECT item_id, p_id.* FROM '.$prefix.'relations as rel

									LEFT JOIN (SELECT im_ex.im_price, p.description, im_ex.ex_price, im_ex.mn_id, im_ex.color_id, p_img.img, p.title, p_id.p_id, p_id.discount, p_id.as_new, p_id.as_new_start_date, p_id.as_new_end_date FROM '.$prefix.'products_id as p_id
									           LEFT JOIN (SELECT p.p_id, p.title, p.description FROM '.$prefix.'products as p
									                      WHERE lang_id='.$lang.') as p on p.p_id = p_id.p_id
									           LEFT JOIN (select im_ex.id, im_ex.product_id, im_ex.im_price, im_ex.ex_price, im_ex.mn_id, im_ex.color_id FROM '.$prefix.'products_im_ex as im_ex
																				WHERE im_ex.id = (SELECT MIN(m.id) FROM '.$prefix.'products_im_ex as m
																																WHERE m.product_id = im_ex.product_id)) as im_ex on im_ex.product_id = p_id.p_id
									           LEFT JOIN (SELECT p_img.p_id, p_img.img FROM '.$prefix.'products_img as p_img
									                      WHERE p_img.index = (SELECT MIN(p.index) FROM '.$prefix.'products_img as p where p.p_id = p_img.p_id) and p_img.active=1) as p_img on p_img.p_id = p_id.p_id
									           WHERE p_id.active=1 and p_id.deleted=0 and im_ex.id is not null) AS p_id on p_id.p_id=rel.item_id

									WHERE ('.$text.') and rel_type_id=2 and item_id!='.$product_id.' and p_id is not null
									group by item_id
									limit 10';

			return $this->db->query($query2)->result();
		}
		else
		{
			return 0;
		}
	}

	function get_default_price($id)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select im_ex.im_price, im_ex.color_id, im_ex.mn_id, ex_price as price, p.discount FROM '.$prefix.'products_im_ex as im_ex
							LEFT JOIN '.$prefix.'products_id as p on p.p_id=im_ex.product_id
							WHERE product_id='.$id.'
							order by id limit 1';

		return $this->db->query($query)->result();
	}

	function get_category_products($from, $count, $cat_id, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT item_id, p_id.* FROM '.$prefix.'relations as rel
							LEFT JOIN (SELECT p.description, im_ex.im_price, im_ex.color_id, im_ex.mn_id, p_img.img, p.title, p_id.p_id, p_id.discount, p_id.price as "ex_price", p_id.as_new, p_id.as_new_start_date, p_id.as_new_end_date FROM '.$prefix.'products_id as p_id
							           LEFT JOIN (SELECT p.p_id, p.title, p.description FROM '.$prefix.'products as p
							                      WHERE lang_id='.$lang.') as p on p.p_id = p_id.p_id
							           LEFT JOIN (select im_ex.product_id, im_ex.im_price, im_ex.color_id, im_ex.mn_id, im_ex.ex_price FROM '.$prefix.'products_im_ex as im_ex
							                      WHERE im_ex.color_id = (SELECT MIN(m.color_id) FROM '.$prefix.'products_im_ex as m where m.product_id = im_ex.product_id)) as im_ex on im_ex.product_id = p_id.p_id
							           LEFT JOIN (SELECT p_img.p_id, p_img.img FROM '.$prefix.'products_img as p_img
							                      WHERE p_img.index = (SELECT MIN(p.index) FROM '.$prefix.'products_img as p where p.p_id = p_img.p_id) and p_img.active=1) as p_img on p_img.p_id = p_id.p_id
							           WHERE p_id.active=1 and p_id.deleted=0 and im_ex.product_id is not null) AS p_id on p_id.p_id=rel.item_id
							WHERE rel_item_id='.$cat_id.' and rel_type_id=2 and p_id is not null
							group by item_id
							LIMIT '.$from.', '.$count;

		return $this->db->query($query)->result();
	}

	function get_category_products_row($cat_id, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT count(*) as "count" FROM '.$prefix.'relations as rel
							LEFT JOIN (SELECT p.title, p_id.p_id FROM '.$prefix.'products_id as p_id
							           LEFT JOIN (SELECT p.p_id, p.title FROM '.$prefix.'products as p
							                      WHERE lang_id='.$lang.') as p on p.p_id = p_id.p_id
												 LEFT JOIN (select product_id FROM '.$prefix.'products_im_ex LIMIT 1) as im_ex on im_ex.product_id = p_id.p_id
							           WHERE p_id.active=1 and p_id.deleted=0 and im_ex.product_id is not null) AS p_id on p_id.p_id=rel.item_id
							WHERE rel_item_id='.$cat_id.' and rel_type_id=2 and p_id is not null';

		return $this->db->query($query)->row();
	}

	function get_all_products($from, $count, $lang)
	{
		$prefix = $this->db->dbprefix;

		$query = ' SELECT im_ex.im_price, im_ex.ex_price, im_ex.color_id, im_ex.mn_id, p_img.img, p.title, p.description, p_id.p_id, p_id.discount, p_id.as_new, p_id.as_new_start_date, p_id.as_new_end_date FROM '.$prefix.'products_id as p_id
		           LEFT JOIN (SELECT p.p_id, p.title, p.description FROM '.$prefix.'products as p
		                      WHERE lang_id='.$lang.') as p on p.p_id = p_id.p_id
		           LEFT JOIN (select im_ex.product_id, im_ex.im_price, im_ex.color_id, im_ex.mn_id, im_ex.ex_price FROM '.$prefix.'products_im_ex as im_ex
		                      WHERE im_ex.color_id = (SELECT MIN(m.color_id) FROM '.$prefix.'products_im_ex as m where m.product_id = im_ex.product_id)) as im_ex on im_ex.product_id = p_id.p_id
		           LEFT JOIN (SELECT p_img.p_id, p_img.img FROM '.$prefix.'products_img as p_img
		                      WHERE p_img.index = (SELECT MIN(p.index) FROM '.$prefix.'products_img as p where p.p_id = p_img.p_id) and p_img.active=1) as p_img on p_img.p_id = p_id.p_id
		           WHERE p_id.active=1 and p_id.deleted=0 and im_ex.product_id is not null
							 GROUP BY p_id.p_id
							 LIMIT '.$from.', '.$count;

		return $this->db->query($query)->result();
	}

	function get_all_products_row($lang)
	{
		$prefix = $this->db->dbprefix;

		$query = 'SELECT count(*) as "count" FROM '.$prefix.'products_id as p_id
							LEFT JOIN (SELECT product_id FROM '.$prefix.'products_im_ex LIMIT 1) as im_ex on im_ex.product_id = p_id.p_id
							WHERE p_id.active = 1 and p_id.deleted = 0 and im_ex.product_id is not null';

		return $this->db->query($query)->row();
	}

	function get_category_title($cat_id, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'select cat_id, name FROM '.$prefix.'cats WHERE cat_id ='.$cat_id.' and lang_id='.$lang;
		return $this->db->query($query)->result();
	}

	function basket_count()
	{
		$prefix = $this->db->dbprefix;
		$a = 0;
		$a = @$this->session->userdata('user_id');

		if($a)
		{
			$query = 'SELECT COUNT(*) as "count" FROM '.$prefix.'orders AS o
			 					LEFT JOIN (select onum.order_number from '.$prefix.'order_numbers as onum
													 WHERE onum.order_status_id=8) as onum on onum.order_number = o.order_number
								WHERE onum.order_number is not null and o.user_id='.$this->session->userdata('user_id');
		}
		else
		{
			$query = 'SELECT COUNT(*) as "count" FROM '.$prefix.'orders AS o
			 					LEFT JOIN (select onum.order_number from '.$prefix.'order_numbers as onum
													 WHERE onum.order_status_id=8) as onum on onum.order_number = o.order_number
								WHERE onum.order_number is not null and o.tmp_user_id="'.$this->session->userdata('tmp_user').'"';
		}

		return $this->db->query($query)->result();
	}

	function default_id($from, $count, $lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT c_id.cat_id, c.name FROM '.$prefix.'cats_id as c_id
		 					LEFT JOIN (SELECT cat_id, name FROM '.$prefix.'cats
												 WHERE lang_id='.$lang.') as c ON c.cat_id=c_id.cat_id
							WHERE c_id.deleted=0 and c_id.active=1 and c.name is not null and c.name!="" and c_id.cat_id not in (SELECT parent_id FROM '.$prefix.'cats_id
																	 			WHERE parent_id!=0 group by parent_id)
							LIMIT '.$from.','.$count;

		return $this->db->query($query)->result();
	}

	function get_lang()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT lang_id, name, thumb FROM '.$prefix.'langs WHERE lang_id='.$this->session->userdata('lang_id').'
							UNION
							SELECT lang_id, name, thumb FROM '.$prefix.'langs WHERE lang_id!='.$this->session->userdata('lang_id');

		return $this->db->query($query)->result();
	}

	public function get_socials()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT * FROM '.$prefix.'social_icons WHERE active=1 ORDER BY order_by asc';

		return $this->db->query($query)->result();
	}

	public function get_contact($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT title FROM '.$prefix.'map WHERE lang_id='.$lang;

		return $this->db->query($query)->result();
	}

	public function get_phone()
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT p.number FROM '.$prefix.'phone as p WHERE id=1';

		return $this->db->query($query)->row();
	}

	public function get_footer_category($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT c_id.cat_id, c.name FROM '.$prefix.'cats_id as c_id
		 					LEFT JOIN (SELECT cat_id, name FROM '.$prefix.'cats
												 WHERE lang_id='.$lang.') as c ON c.cat_id=c_id.cat_id
							WHERE c_id.show_unshow=1 and c_id.deleted=0 and c_id.active=1 and c.name is not null and c.name!="" and c_id.cat_id not in (SELECT parent_id FROM '.$prefix.'cats_id
																	 			WHERE parent_id!=0 group by parent_id)';

		return $this->db->query($query)->result();
	}

	public function get_description($lang)
	{
		$prefix = $this->db->dbprefix;
		$query = 'SELECT description FROM '.$prefix.'description WHERE lang_id='.$lang;

		return $this->db->query($query)->row();
	}
}
