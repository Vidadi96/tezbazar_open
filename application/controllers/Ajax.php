<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax extends CI_Controller {
	public $category;
	public $sub_category;
	function __construct()
	{
		parent::__construct();
		$this->load->model("ajax_model");
		$this->load->model("office_model");
		$this->load->model("adm_model");
		$this->load->library("template");
		$this->langs = (object)$this->template->labels;
		//$this->output->enable_profiler(TRUE);
	}

	public function filter_products()
	{
		$filter = json_decode($this->input->post("data"));
		$order_by = $filter->orderby;
		if($order_by==0 || $order_by==15)
		{
			$order_by = 4;
		}else if($order_by==10)
		{
			$order_by = 3;
		}
		$min_price = $filter->priceRangeFilterModel7Spikes->MinPrice;
		$max_price = @$filter->priceRangeFilterModel7Spikes->SelectedPriceRange->To?$filter->priceRangeFilterModel7Spikes->SelectedPriceRange->To:$filter->priceRangeFilterModel7Spikes->MaxPrice;

		$where = " AND (price BETWEEN ".$min_price." AND ".$max_price.") ";
		$end = $filter->pagesize;
		$data = array();
		$result = $this->office_model->get_products_by_category_id($filter->categoryId, $order_by, $where, 0, $end, 1, 1);
    $data["list"] = $result["list"];
		$this->load->view("site/category_products", $data);
	}

	/*public function test_send()
	{
			$to = "izzetliv@mail.ru";
			$message = "test msg";
			$subject = "test mail";
			$this->load->library('email');
			$config = array(
				 'protocol' => 'mail',
					'smtp_host' => "mail.stdc.az",
				 'smtp_port' => "587", //465
				 'smtp_crypto'   => 'tls',
					'smtp_user' => "shirazi@stdc.az",
					'smtp_pass' => "@Pass2015",
					'mailtype'  => 'html',
					'charset'   => 'UTF-8'
			);
			$this->email->initialize($config);
			$this->email->from("shirazi@stdc.az", "Shirazi");
			$this->email->to($to);
			//$this->email->cc($cc);
			$this->email->subject($subject);
			$this->email->message($message);
			$result = $this->email->send();
			print_r($result);
		}*/

    public function get_parameters($param_group)
    {
        $data = [];
        $param_group = (int)$param_group;
        $data["param_id"] = $this->ajax_model->get_params($param_group);
        echo '<div data-id="'.$param_group.'" class="params m-option"><h4 class="m-section__title">'.$data["param_id"][0]->param_group_title.'</h4><div class="row">';
        foreach ($data["param_id"] as $item)
        {

            if($item->param_type_id==6){ // Combobox
                $sub_params = $this->ajax_model->get_sub_params($item->param_id);
                echo '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label><select class="form-control" name="sub_param_'.$item->param_id.'">';

                foreach ($sub_params as $sub){
                    echo '<option value="'.$sub->sub_param_id.'">'.$sub->sub_param_title.'</option>';
                }
                echo '</select></div>';
            }else if($item->param_type_id==3){ // Date
                echo '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label>
                        <input type="text" class="form-control date_time_picker" name="sub_param_'.$item->param_id.'" readonly="" placeholder="'.$item->param_title.'" />
                        </div>';
            }
            else if($item->param_type_id==4)// Radio
            {
                $sub_params = $this->ajax_model->get_sub_params($item->param_id);
                echo '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label><div class="m-radio-inline">';

                    foreach ($sub_params as $sub){
                        echo '<label class="m-radio m-radio--solid">
                            <input type="radio" name="sub_param_'.$item->param_id.'" value="'.$sub->sub_param_id.'">
                            '.$sub->sub_param_title.'
                            <span></span>
                        </label>';
                    }
                echo '</div></div>';

            }else if($item->param_type_id==5)// checkbox
            {
                $sub_params = $this->ajax_model->get_sub_params($item->param_id);
                echo '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label><div class="m-checkbox-inline">';

                    foreach ($sub_params as $sub){
                        echo '<label class="m-checkbox m-checkbox--solid">
                            <input type="checkbox" name="sub_param_'.$item->param_id.'[]" value="'.$sub->sub_param_id.'">
                            '.$sub->sub_param_title.'
                            <span></span>
                        </label>';
                    }
                echo '</div></div>';

            }




        }
        echo '</div></div>';
        /*echo '</div></div><pre>',
        print_r($data["param_id"]),
        '</pre>';*/

       /* $data["langs"] = $this->adm_model->langs();
        $data["param_types"] = $this->universal_model->get_more_item("param_types", array("deleted"=>0));

        $data["params"] = $this->universal_model->get_more_item("params", array("param_id"=>$param_id), 1);
        $data["sub_params"] = $this->product_model->get_sub_params($param_id);
        $data["sub_params_id"] = $this->product_model->get_sub_params_id($param_id);*/
    }
	public function get_product_name($lang)
	{
		$lang = (int) $lang;
		$q = $this->filter_data($this->input->get());
		$result = $this->ajax_model->get_product_name($lang, $q["query"]);
		//print_r($result);
		$new_array["suggestions"] = $result;
		echo json_encode($new_array);
	}
	public function empty_delete()
	{
		echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
	}
	public function get_sub_param_add($param_type_id)
	{
		$param_type_id = (int) $param_type_id;
		$langs = $this->adm_model->langs();
		$i = 1;
		echo '<tr>';
		if($param_type_id==4 || $param_type_id==5 || $param_type_id==6)
		{
			foreach($langs as $lang){
				echo '<td><textarea name="sub_param_title-'.$lang->lang_id.'[]" class="form-contrl param_txt" ></textarea></td>';
			}
		}
		echo '<td><a href="javascript:;" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel=""><i class="fa fa-trash"></i></a></td></tr>';
	}
	public function get_sub_param_add_edit($param_type_id)
	{
		$param_type_id = (int) $param_type_id;
		$langs = $this->adm_model->langs();
		$i = 1;
		echo '<tr>';
		if($param_type_id==4 || $param_type_id==5 || $param_type_id==6)
		{
			foreach($langs as $lang){
				echo '<td><textarea name="sub_param_title-'.$lang->lang_id.'-[0][]" class="form-contrl param_txt" ></textarea></td>';
			}
		}
		echo '<td><a href="javascript:;" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel=""><i class="fa fa-trash"></i></a></td></tr>';
	}
	public function get_param_add($param_type_id)
	{
		$param_type_id = (int) $param_type_id;
		$langs = $this->adm_model->langs();
		$i = 1;
		if($param_type_id==4 || $param_type_id==5 || $param_type_id==6)
		{
			echo '<table delete_url="/ajax/empty_delete/" class="table table-sm m-table m-table--head-bg-light table-bordered">
				<thead class="thead-inverse">
					<tr>';
					$thead = '';
					$tbody = '';
			foreach($langs as $lang){

							$thead = $thead.'<th>
								<img alt="'.$lang->name.'" style="max-width: 20px" src="/img/langs/'.$lang->thumb.'" style="margin-right: 5px" /> Sub parametrin adı
							</th>';
							$tbody = $tbody.'<td>
							<textarea name="sub_param_title-'.$lang->lang_id.'[]" class="form-contrl param_txt" ></textarea>
							</td>';
			}
			echo $thead.'<th style="position:relative;"> Sil
			<a style="position: absolute; top:-24px; right: 0px;" href="javascript:;" class="btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only add_sub_param" rel="'.$param_type_id.'" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="Yeni sub parametr">
				<i class="fa fa-plus"></i>
			</a>
			</th></tr>
		</thead>
		<tbody>
			<tr>'.$tbody.'<td>
			<a href="javascript:;" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="">
				<i class="fa fa-trash"></i>
			</a>
			</td></tr>
		</tbody>
	</table>';

			/*foreach($langs as $lang){
				echo '<div class="col-lg-3">
					<div class="form-group">
						<label>Parametrin adı (<?=$lang->name;?>) <img style="max-width: 20px" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" /></label>
						<input type="text" name="param_title-<?=$lang->lang_id;?>" class="form-control" id="param_title" value="" />
					</div>
				</div>';
				if($i==4)
				{
					$i=1;
					echo '</div><div class="form-group m-form__group row">';
				}

				$i++;
			}*/
		}

	}
	public function get_param_add_edit($param_type_id)
	{
		$param_type_id = (int) $param_type_id;
		$langs = $this->adm_model->langs();
		$i = 1;
		if($param_type_id==4 || $param_type_id==5 || $param_type_id==6)
		{
			echo '<table delete_url="/ajax/empty_delete/" class="table table-sm m-table m-table--head-bg-light table-bordered">
				<thead class="thead-inverse">
					<tr>';
					$thead = '';
					$tbody = '';
			foreach($langs as $lang){

							$thead = $thead.'<th>
								<img alt="'.$lang->name.'" style="max-width: 20px" src="/img/langs/'.$lang->thumb.'" style="margin-right: 5px" /> Sub parametrin adı
							</th>';
							$tbody = $tbody.'<td>
							<textarea name="sub_param_title-'.$lang->lang_id.'-[0][]" class="form-contrl param_txt" ></textarea>
							</td>';
			}
			echo $thead.'<th style="position:relative;"> Sil
			<a style="position: absolute; top:-24px; right: 0px;" href="javascript:;" class="btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only add_sub_param" rel="'.$param_type_id.'" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="Yeni sub parametr">
				<i class="fa fa-plus"></i>
			</a>
			</th></tr>
		</thead>
		<tbody>
			<tr>'.$tbody.'<td>
			<a href="javascript:;" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="">
				<i class="fa fa-trash"></i>
			</a>
			</td></tr>
		</tbody>
	</table>';

			/*foreach($langs as $lang){
				echo '<div class="col-lg-3">
					<div class="form-group">
						<label>Parametrin adı (<?=$lang->name;?>) <img style="max-width: 20px" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" /></label>
						<input type="text" name="param_title-<?=$lang->lang_id;?>" class="form-control" id="param_title" value="" />
					</div>
				</div>';
				if($i==4)
				{
					$i=1;
					echo '</div><div class="form-group m-form__group row">';
				}

				$i++;
			}*/
		}

	}
	public function create_tree($categories, $parent)
	{
		$i=0;

		foreach ($categories as $category) {
			if($category->parent_id==$parent)
			{
				$this->category[$i]["id"]=$category->id;
				$this->category[$i]["text"]=$category->text;
				$this->category[$i]["children"]= $this->create_tree($categories,$category->id);
				print_r($this->category[$i]["children"]);
				$i++;
			}
		}
	}
	function buildTree(array $elements, $parentId = 0) {
    $branch = array();
    foreach ($elements as $element) {
      if ($element["parent_id"] == $parentId) {
        $children = $this->buildTree($elements, $element["id"]);
        if ($children) {
            $element["children"] = $children;
        }
        $branch[] = $element;
      }
    }
    return $branch;
	}
	public function get_categories()
	{
		$parent_id = (int)$this->input->get("id");
		$categories = $this->ajax_model->get_categories($parent_id);
		echo json_encode($categories);
	}
	public function get_roles()
	{
		$roles = $this->ajax_model->get_roles();
		echo json_encode($roles);
	}
	public function get_brands()
	{
		$brands = $this->ajax_model->get_brands();
		echo json_encode($brands);
	}
	function filter_data($array)
	{
		$data = array();
		foreach ($array as $key => $value) {
			if(is_array($value))
				$data[$key]= $value;
			else
				$data[$key]= filter_var(str_replace(array("'", '"',"`", ')', '(', "-"), array("","","","","",""), $this->security->xss_clean(strip_tags(rawurldecode($value)))), FILTER_SANITIZE_STRING);
		}
		return $data;
	}















}
