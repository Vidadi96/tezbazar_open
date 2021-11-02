<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model("product_model");
        $this->load->model("ajax_model");
        //$this->output->enable_profiler(TRUE);
    }

    public function add_product()
    {
        if($this->input->get("type"))
        {
            $this->ajax();
        }
        else
        {
            $data=array();
            $data["filter"] = [];
            $data["group_items"] = "";
            $data["langs"] = $this->adm_model->langs();
            $product_id = 0;
            $this->load->helper("form");
            if($this->input->post()) {

                $this->load->library('form_validation');
                $this->form_validation->set_rules('title-2', "Məhsulun adı", 'trim|required');
                if ($this->form_validation->run() == TRUE)
                {
                    $all_vars = $this->input->post();
                    $data["filter"] = $this->filter_data($all_vars);
                    $products_id_vars = [
                        "user_id" => $this->session->userdata("id"),
                        "parent_id" => ($this->input->post("parent_id") ? $this->input->post("parent_id") : 0),
                        "active" => ($this->input->post("active")?$this->input->post("active"):0),
                        "action" => ($this->input->post("action")?$this->input->post("action"):0),
                        "deleted" => 0,
                        "sku" => $this->input->post("sku"),
                        "brand_id" => ($this->input->post("brand_id")?$this->input->post("brand_id"):0),
                        "as_new" => ($this->input->post("as_new") ? 1 : 0),
                        "admin_note" => $this->input->post("admin_note"),
                        "as_new_start_date" => ($this->input->post("as_new_start_date") ? date("Y-m-d", strtotime($this->input->post("as_new_start_date"))) : ''),
                        "as_new_end_date" => ($this->input->post("as_new_end_date") ? date("Y-m-d", strtotime($this->input->post("as_new_end_date"))) : ''),
                        "discount" => ($this->input->post("discount") ? $this->input->post("discount") : 0),
                        "discount_id" => ($this->input->post("discount") ? 0 : ($this->input->post("discount_id")?$this->input->post("discount_id"):0)),
                        "price" => (float) $this->input->post('ex_price'),
                        "measure_id" => (int) $this->input->post('measure')
                    ];
                    /*`measure_id`=[value-8], `color_id`=[value-10]*/


                    $product_id = $this->universal_model->add_item($products_id_vars, "products_id");

                    $this->universal_model->item_edit_save("products_img", array("p_id" => 0, "user_id" => $this->session->userdata("id")), array("p_id" => $product_id));

                    // /*Sub Parameters*/
                    // $param_id = $this->input->post("param_id[]");
                    // unset($all_vars["param_id"]);
                    // unset($all_vars["param_group_id"]);
                    //
                    // $param_vars = [];
                    // if ($param_id) {
                    //     foreach ($param_id as $value) {
                    //         $sub_values = [];
                    //         if (isset($_POST["sub_param_" . $value . "[]"])) {
                    //             foreach ($this->input->post("sub_param_" . $value . "[]") as $key => $index) {
                    //                 $sub_values[] = $index;
                    //             }
                    //         } else
                    //             $sub_values[] = $this->input->post("sub_param_" . $value);
                    //         foreach ($sub_values as $key => $index) {
                    //             if (is_array($index)) {
                    //                 foreach ($index as $sub_index) {
                    //                     $param_vars[] = ["param_id" => $value, "product_id" => $product_id, "param_value" => $sub_index];
                    //                 }
                    //             } else {
                    //                 $param_vars[] = ["param_id" => $value, "product_id" => $product_id, "param_value" => $index];
                    //             }
                    //
                    //         }
                    //         unset($all_vars["sub_param_" . $value]);
                    //
                    //     }
                    // }

                    unset($all_vars["fileuploader-list-files"]);
                    unset($all_vars["files"]);
                    /****** Product category relations *******/
                    $cat_vars = [];
                    if (@$all_vars["cat_id"]) {
                        foreach ($all_vars["cat_id"] as $key => $index) {
                            $cat_vars[] = [
                                "rel_type_id" => 2,
                                "item_id" => $product_id,
                                "rel_item_id" => $index
                            ];
                        }
                    }
                    if ($cat_vars)
                        $cat_result = $this->universal_model->add_more_item($cat_vars, "relations");

                    $product_vars = array();
                    foreach ($data["langs"] as $lang) {
                        $product_vars[] = [
                            "lang_id" => $lang->lang_id,
                            "p_id" => $product_id,
                            "seo_title" => $all_vars["seo_title-" . $lang->lang_id],
                            "seo_url" => $all_vars["seo_url-" . $lang->lang_id],
                            "title" => $all_vars["title-" . $lang->lang_id],
                            "content" => $all_vars["content-" . $lang->lang_id],
                            "seo_keywords" => $all_vars["seo_keywords-" . $lang->lang_id],
                            "seo_description" => $all_vars["seo_description-" . $lang->lang_id],
                            "description" => $all_vars["description-" . $lang->lang_id],
                        ];
                    }

                    if ($param_vars)
                        $param_result = $this->universal_model->add_more_item($param_vars, "prarm_rel_id");
                    if ($product_vars)
                        $product_result = $this->universal_model->add_more_item($product_vars, "products");

                    if (isset($data["filter"]['param_group_id'])) {
                      foreach ($data["filter"]['param_group_id'] as $group_item)
                        $data["group_items"] .= $this->get_parameters($group_item);
                    }
                    $data["status"] = array("status"=>"success","title"=>"Success", "icon"=>"check-circle", "msg"=>"Product added successfully.");
                    redirect("/product/edit_product/".$product_id."/TRUE/");
                }
                else
                {
                  $data["status"] = array("status"=>"danger", "title"=>"Error", "icon"=>"exclamation-triangle",  "msg"=>"Please fill out all the required fields.");
                }
            }

            // $data["providers"] = $this->product_model->get_providers();
            $data["warehouse_id"] = $this->product_model->warehouse_id();
            $data["measures"] = $this->product_model->get_measures($this->session->userdata('lang_id'));
            $data['salesmen'] = $this->product_model->get_salesmen();
            $data['import_contracts'] = $this->product_model->get_import_contracts();
            $data["entry_type_list"] = $this->product_model->entry_type_list($this->session->userdata('lang_id'));
            $data["brand_id"]=$this->product_model->brand_id();
            $data["discount_id"]=$this->product_model->discount_id();
            $data["color_id"]=$this->product_model->color_id();
            $data["sizes"]=$this->universal_model->get_more_item("sizing", array("deleted"=>0));
            $data['sku'] = $this->generate_sku();

            $data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
            // $data["param_groups_id"] = $this->product_model->get_param_groups();
            $data["mn_id"] = $this->product_model->measure_names();
            $this->home("product/add_product", $data);
        }
    }

    public function generate_sku()
    {
      $val = rand(0, 9999999999);
      $check = false;
      $array = $this->product_model->get_skus();
      foreach ($array as $row)
      {
        if ($row->pincode == $val)
          $check = true;
      }

      if ($check)
        $this->generate_sku();
      else
        return $val;
    }

    public function edit_product($product_id, $added=FALSE)
    {
        $product_id = (int)$product_id;
        // $this->output->enable_profiler(TRUE);

        if($this->input->get("type"))
        {
            $this->ajax();
        }
        else
        {
            $data = array();
            $data["langs"] = $this->adm_model->langs();
            $this->load->helper("form");
            if($this->input->post())
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title-2', "Məhsulun adı", 'trim|required');
                if ($this->form_validation->run() == TRUE)
                {
                    $all_vars = $this->input->post();
                    $data["filter"] = $this->filter_data($all_vars);
                    $products_id_vars = [
                      "user_id" => $this->session->userdata("id"),
                      "active" => $this->input->post("active"),
                      "action" => ($this->input->post("action")?$this->input->post("action"):0),
                      "deleted" => 0,
                      "sku" => $this->input->post("sku"),
                      "brand_id" => ($this->input->post("brand_id")?$this->input->post("brand_id"):0),
                      "as_new" => ($this->input->post("as_new") ? 1 : 0),
                      "admin_note" => $this->input->post("admin_note"),
                      "as_new_start_date" => ($this->input->post("as_new_start_date") ? date("Y-m-d", strtotime($this->input->post("as_new_start_date"))) : NULL),
                      "as_new_end_date" => ($this->input->post("as_new_end_date") ? date("Y-m-d", strtotime($this->input->post("as_new_end_date"))) : NULL),
                      "discount" => ($this->input->post("discount") ? $this->input->post("discount") : 0),
                      "discount_id" => ($this->input->post("discount") ? 0 : ($this->input->post("discount_id")?$this->input->post("discount_id"):0)),
                      "price" => (float) $this->input->post('ex_price'),
                      "measure_id" => (int) $this->input->post('measure')
                    ];
                    /*`measure_id`=[value-8], `color_id`=[value-10]*/

                    $this->universal_model->item_edit_save_where($products_id_vars, array("p_id"=>$product_id), "products_id");

                    /*Sub Parameters*/
                    $param_id = $this->input->post("param_id[]");
                    unset($all_vars["param_id"]);
                    unset($all_vars["param_group_id"]);

                    $param_vars = [];
                    if($param_id)
                    {
                      foreach($param_id as $value)
                      {
                        $sub_values = [];
                        if(isset($_POST["sub_param_".$value."[]"]))
                        {
                          foreach ($this->input->post("sub_param_".$value."[]") as $key => $index)
                          {
                            $sub_values[] = $index;
                          }
                        }
                        else
                        {
                          $sub_values[] = $this->input->post("sub_param_".$value);
                        }

                        foreach($sub_values as $key => $index)
                        {
                          if(is_array($index))
                          {
                            foreach ($index as $sub_index)
                            {
                              $param_vars[] = ["param_id" => $value, "product_id" => $product_id, "param_value" => $sub_index];
                            }
                          }
                          else
                          {
                            $param_vars[] = ["param_id" => $value, "product_id" => $product_id, "param_value" => $index];
                          }
                        }
                        unset($all_vars["sub_param_" . $value]);
                      }
                    }

                    unset($all_vars["fileuploader-list-files"]);
                    unset($all_vars["files"]);
                    /****** Product category relations *******/
                    $cat_vars = [];
                    if (@$all_vars["cat_id"]) {
                      foreach ($all_vars["cat_id"] as $key => $index) {
                        $cat_vars[] = [
                            "rel_type_id" => 2,
                            "item_id" => $product_id,
                            "rel_item_id" => $index
                        ];
                      }
                    }
                    $this->universal_model->delete_item_where(array("rel_type_id"=>2, "item_id"=>$product_id), "relations");
                    if ($cat_vars)
                      $cat_result = $this->universal_model->add_more_item($cat_vars, "relations");

                    $product_vars = array();
                    foreach ($data["langs"] as $lang) {
                      $product_vars[] = [
                          "lang_id" => $lang->lang_id,
                          "p_id" => $product_id,
                          "seo_title" => $all_vars["seo_title-" . $lang->lang_id],
                          "seo_url" => $all_vars["seo_url-" . $lang->lang_id],
                          "title" => $all_vars["title-" . $lang->lang_id],
                          "content" => $all_vars["content-" . $lang->lang_id],
                          "seo_keywords" => $all_vars["seo_keywords-" . $lang->lang_id],
                          "seo_description" => $all_vars["seo_description-" . $lang->lang_id],
                          "description" => $all_vars["description-" . $lang->lang_id],
                      ];
                    }

                    $this->universal_model->delete_item_where(array("product_id" => $product_id), "prarm_rel_id");
                    if ($param_vars)
                      $param_result = $this->universal_model->add_more_item($param_vars, "prarm_rel_id");

                    if ($product_vars)
                    {
                      $this->universal_model->delete_item_where(array("p_id" => $product_id), "products");
                      $product_result = $this->universal_model->add_more_item($product_vars, "products");
                    }
                    /****** Product import count *******/
                    // $products_im_ex_vars = [];
                    // $im_ex_id = [];
                    // $im_ex_result = "";
                    // $i = 0;
                    //
                    // // $this->product_model->insert_delete_edit($product_id);
                    // // $this->universal_model->delete_item_where(array("product_id" => $product_id), "products_im_ex");
                    // $not_in = '';
                    // $j = 0;
                    // foreach ($all_vars["im_ex_id"] as $row)
                    // {
                    //   if ($j > 0) {
                    //     if ($row > 0)
                    //       $not_in .= ','.$row;
                    //   } else {
                    //     if ($row > 0)
                    //       $not_in = $row;
                    //   }
                    //
                    //   $j++;
                    // }
                    //
                    // $this->product_model->insert_where_not_in($product_id, $not_in);
                    // $this->product_model->delete_where_not_in($product_id, $not_in);
                    //
                    // foreach ($all_vars["color_id"] as $color) {
                    //   $products_im_ex_vars[$i] = [
                    //       "product_id" => $product_id,
                    //       "im_price" => $all_vars["im_price"][$i],
                    //       "ex_price" => $all_vars["ex_price"][$i],
                    //       "warehouse_id" => $all_vars["warehouse_id"][$i],
                    //       "provider_id" => $all_vars["provider_id"][$i],
                    //       "entry_name_id" => $all_vars["entry_name_id"][$i],
                    //       "contract_number" => $all_vars["contract_number"][$i] == ""?"0":$all_vars["contract_number"][$i],
                    //       "check_number" => $all_vars["check_number"][$i]==""?"0":$all_vars["check_number"][$i],
                    //       "date_time" => date("Y-m-d H:i:s", strtotime($all_vars["entry_date"][$i])),
                    //       "count" => $all_vars["count"][$i],
                    //       "color_id" => $all_vars["color_id"][$i],
                    //       "mn_id" => $all_vars["mn_id"][$i],
                    //       "measure_id" => $all_vars["measure_id"][$i],
                    //       "user_id" => $this->session->userdata("id")
                    //   ];
                    //
                    //   if ($all_vars["im_ex_id"][$i]>0) {
                    //     $this->universal_model->update_table('products_im_ex', array('id'=>$all_vars["im_ex_id"][$i]), $products_im_ex_vars[$i]);
                    //     if ($all_vars["upd"][$i] == 1) {
                    //       $products_im_ex_vars[$i]['im_ex_id'] = $all_vars["im_ex_id"][$i];
                    //       $products_im_ex_vars[$i]['action_time'] = date("Y-m-d H:i:s");
                    //       $products_im_ex_vars[$i]['action_name'] = 'Update income product';
                    //       $im_ex_result = $this->universal_model->add_item($products_im_ex_vars[$i], "products_log");
                    //     }
                    //   } else {
                    //     $this->universal_model->add_item($products_im_ex_vars[$i], "products_im_ex");
                    //     $products_im_ex_vars[$i]['im_ex_id'] = $all_vars["im_ex_id"][$i];
                    //     $products_im_ex_vars[$i]['action_time'] = date("Y-m-d H:i:s");
                    //     $products_im_ex_vars[$i]['action_name'] = 'New income product';
                    //     $im_ex_result = $this->universal_model->add_item($products_im_ex_vars[$i], "products_log");
                    //   }
                    //   $i++;
                    // }

                    $data["status"] = array("status"=>"success","title"=>"Success", "icon"=>"check-circle", "msg"=>"Product saved successfully.");
                }
                else
                {
                  $data["status"] = array("status"=>"danger","title"=>"Error", "icon"=>"exclamation-triangle",  "msg"=>"Please fill out all the required fields.");
                }
            }
            if($added)
              $data["status"] = array("status"=>"success","title"=>"Success", "icon"=>"check-circle", "msg"=>"Current product saved successfully.");

            $data["product"] = $this->product_model->get_product($product_id);
            $data["product_colors"] = $this->product_model->get_product_colors($product_id);
            $data["prarm_rel"] = $this->product_model->get_product_param($product_id);
            $data["filter"] = [];
            $data["group_items"] = "";
            $groups = array();

            foreach ($data["prarm_rel"] as $group_item)
              $groups[$group_item["param_group_id"]] = $group_item["param_group_id"];

            foreach ($groups as $key=>$value)
              $data["group_items"] .= $this->get_parameters_for_edit($value, $data["prarm_rel"]);

            // $data["providers"] = $this->product_model->get_providers();
            $data["warehouse_id"]=$this->product_model->warehouse_id();
            $data["measures"] = $this->product_model->get_measures($this->session->userdata('lang_id'));
            $data['salesmen'] = $this->product_model->get_salesmen();
            $data['import_contracts'] = $this->product_model->get_import_contracts();
            $data["entry_type_list"] = $this->product_model->entry_type_list($this->session->userdata('lang_id'));
            $data["brand_id"]=$this->product_model->brand_id();
            $data["discount_id"]=$this->product_model->discount_id();
            $data["color_id"]=$this->product_model->color_id();
            $data["sizes"]=$this->universal_model->get_more_item("sizing", array("deleted"=>0));
            $data["selected_cat_id"]=$this->universal_model->get_more_item("relations", array("rel_type_id"=>2, "item_id"=>$product_id),1);
            $data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
            $data["param_groups_id"] = $this->product_model->get_param_groups();
            $data["mn_id"] = $this->product_model->measure_names();
            $this->home("product/edit_product", $data);
        }
    }

    public function delete_product()
    {
        $p_id = (int)$this->input->post("id");
        if($p_id)
        {
          $this->universal_model->delete_item_where(array("product_id" => $p_id), "products_im_ex");
          $this->universal_model->delete_item_where(array("p_id" => $p_id), "products");
          $this->universal_model->delete_item_where(array("p_id" => $p_id), "products_id");
          $this->universal_model->delete_item_where(array("rel_type_id"=>2, "item_id"=>$p_id), "relations");
          $this->universal_model->delete_item_where(array("product_id" => $p_id), "prarm_rel_id");
        }
        echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
    }

    public function get_parameters($param_group)
    {
        $data = [];
        $group = "";
        $param_group = (int)$param_group;
        $data["param_id"] = $this->ajax_model->get_params($param_group);
        $group .= '<div data-id="'.$param_group.'" class="params m-option"><h4 class="m-section__title">'.$data["param_id"][0]->param_group_title.'</h4><div class="row">';
        foreach ($data["param_id"] as $item)
        {
            if($item->param_type_id==6){ // Combobox
                $sub_params = $this->ajax_model->get_sub_params($item->param_id);
                $group .= '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label><select class="form-control" name="sub_param_'.$item->param_id.'">';

                foreach ($sub_params as $sub){
                    $group .= '<option '.(($this->input->post("sub_param_".$item->param_id)==$sub->sub_param_id)?'selected':'').' value="'.$sub->sub_param_id.'">'.$sub->sub_param_title.'</option>';
                }
                $group .= '</select></div>';
            }else if($item->param_type_id==3){ // Date
                $group .= '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label>
                        <input type="text" value="'.$this->input->post("sub_param_".$item->param_id).'" class="form-control date_time_picker" name="sub_param_'.$item->param_id.'" readonly="" placeholder="'.$item->param_title.'" />
                        </div>';
            }
            else if($item->param_type_id==4)// Radio
            {
                $sub_params = $this->ajax_model->get_sub_params($item->param_id);
                $group .= '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label><div class="m-radio-inline">';

                foreach ($sub_params as $sub){
                    $group .= '<label class="m-radio m-radio--solid">
                            <input '.(($this->input->post("sub_param_".$item->param_id)==$sub->sub_param_id)?'checked':'').' type="radio" name="sub_param_'.$item->param_id.'" value="'.$sub->sub_param_id.'">
                            '.$sub->sub_param_title.'
                            <span></span>
                        </label>';
                }
                $group .= '</div></div>';

            }else if($item->param_type_id==5)// checkbox
            {
                $sub_params = $this->ajax_model->get_sub_params($item->param_id);
                $group .= '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label><div class="m-checkbox-inline">';
                $bb = 0;
                foreach ($sub_params as $sub){
                    $group .= '<label class="m-checkbox m-checkbox--solid">
                            <input '.((@$this->input->post("sub_param_".$item->param_id)[$bb]==$sub->sub_param_id)?'checked':'').' type="checkbox" name="sub_param_'.$item->param_id.'[]" value="'.$sub->sub_param_id.'">
                            '.$sub->sub_param_title.'
                            <span></span>
                        </label>';
                    $bb++;
                }
                $group .= '</div></div>';

            }




        }
        $group = $group.'</div></div>';

        return $group;
    }

    function return_more_selected($vars, $key, $value)
    {
        if($vars)
        {
            foreach ($vars as $index) {
                if(($index[$key[0]]==$value[0]) && ($index[$key[1]]==$value[1]))
                    return $index;
            }
            return "";
        }else {
            return "";
        }
    }

    function return_more_selected_one($vars, $key, $value)
    {
        if($vars)
        {
            foreach ($vars as $index) {
                if(($index[$key]==$value))
                    return $index;
            }
            return "";
        }
        else
        {
          return "";
        }
    }

    public function get_parameters_for_edit($param_group, $param_values)
    {
        $data = [];
        $group = "";
        $param_group = (int)$param_group;
        $data["param_id"] = $this->ajax_model->get_params($param_group);
        $group .= '<div data-id="'.$param_group.'" class="params m-option"><h4 class="m-section__title">'.$data["param_id"][0]->param_group_title.'</h4><div class="row">';
        foreach ($data["param_id"] as $item)
        {
            if($item->param_type_id==6){ // Combobox
                $sub_params = $this->ajax_model->get_sub_params($item->param_id);
                $group .= '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label><select class="form-control" name="sub_param_'.$item->param_id.'">';

                foreach ($sub_params as $sub){
                    $group .= '<option '.(($this->return_more_selected($param_values, array("param_value", "param_id"), array($sub->sub_param_id, $item->param_id)))?'selected':'').' value="'.$sub->sub_param_id.'">'.$sub->sub_param_title.'</option>';
                }
                $group .= '</select></div>';
            }else if($item->param_type_id==3){ // Date
                $group .= '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label>
                        <input type="text" value="'.$this->return_more_selected_one($param_values, "param_id", $item->param_id)["param_value"].'" class="form-control date_time_picker" name="sub_param_'.$item->param_id.'" readonly="" placeholder="'.$item->param_title.'" />
                        </div>';
            }
            else if($item->param_type_id==4)// Radio
            {
                $sub_params = $this->ajax_model->get_sub_params($item->param_id);
                $group .= '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label><div class="m-radio-inline">';

                foreach ($sub_params as $sub){
                    $group .= '<label class="m-radio m-radio--solid">
                            <input '.(($this->return_more_selected($param_values, array("param_value", "param_id"), array($sub->sub_param_id, $item->param_id)))?'checked':'').' type="radio" name="sub_param_'.$item->param_id.'" value="'.$sub->sub_param_id.'">
                            '.$sub->sub_param_title.'
                            <span></span>
                        </label>';
                }
                $group .= '</div></div>';
            }else if($item->param_type_id==5)// checkbox
            {
                $sub_params = $this->ajax_model->get_sub_params($item->param_id);
                $group .= '<div class="col-md-4">
                        <input type="hidden" name="param_id[]" value="'.$item->param_id.'" />
                        <label>'.$item->param_title.'</label><div class="m-checkbox-inline">';
                $bb = 0;
                foreach ($sub_params as $sub){
                    $group .= '<label class="m-checkbox m-checkbox--solid">
                            <input '.(($this->return_more_selected($param_values, array("param_value", "param_id"), array($sub->sub_param_id, $item->param_id)))?'checked':'').' type="checkbox" name="sub_param_'.$item->param_id.'[]" value="'.$sub->sub_param_id.'">
                            '.$sub->sub_param_title.'
                            <span></span>
                        </label>';
                    $bb++;
                }
                $group .= '</div></div>';

            }




        }
        $group = $group.'</div></div>';

        return $group;
    }

    public function product_list()
    {
      // $this->output->enable_profiler(true);
        $end = 30;
        $from=0;
        $base_url = "/product/product_list";
        $filtered_get = $this->filter_data($this->input->get());

        if($this->input->get("page"))
            $from = (int) $filtered_get['page'];

        $result = $this->product_model->product_list($filtered_get, $from, $end, $this->session->userdata['lang_id']);

        $data["total_row"] = $result["total_row"][0]->count;
        $data["list"] = $result["list"];
        $data["filter"] = $filtered_get;

      if ($data["total_row"] >= 1)
        $data["pagination"] = $this->pagination($from, $end, $base_url, $data["total_row"], 3, 5);

        $this->home("product/product_list", $data);
    }

    public function product_set_active_passive()
    {
        if($this->input->post("id"))
        {
            //array("lang_id"=>((int)$this->input->post("id"))), array("active"=>((int)$this->input->post("active_passive")))
            $vars = array("p_id"=>(int)$this->input->post("id"), "active"=>(int)$this->input->post("active_passive"));
            $result = $this->product_model->product_set_active_passive($vars);
            if($result)
            {
                echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
            }
            else
            {
                echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
            }
        }
    }
    /*****Params START******/

    public function params()
    {
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $sub_array=array();
            $param_id_vars = array("active"=>$vars["active"], "order_by"=>$vars["order_by"], "required"=>$vars["required"], "param_group_id"=>$vars["param_group_id"], "param_type_id"=>$vars["param_type_id"]);
            $param_id = $this->universal_model->add_item($param_id_vars, "params_id");
            unset($vars["active"]);
            unset($vars["order_by"]);
            unset($vars["required"]);
            unset($vars["param_group_id"]);
            unset($vars["param_type_id"]);
            if($param_id)
            {
                //print_r($vars);
                $sub_param_id = array();
                $sub_params = false;
                foreach($vars as $key=>$value)
                {
                    $name = explode("-", $key);
                    if(!is_array($value))
                    {
                        unset($vars[$key]);
                        $array[] = array("param_id"=>$param_id, "param_title"=>$value, "lang_id"=>(int)@$name[1]);
                    }else {
                        $i=0;
                        foreach($value as $key=>$index)
                        {
                            if(!$sub_params)
                            {
                                $sub_param_id[] = $this->universal_model->add_item(array("active"=>1, "param_id"=>$param_id), "sub_params_id");
                            }
                            $sub_array[]= array("sub_param_id"=>$sub_param_id[$i], "sub_param_title"=>$index, "lang_id"=>(int)@$name[1]);
                            $i++;
                        }
                        $sub_params = true;

                    }
                }
                if($sub_array)
                $result = $this->universal_model->add_more_item($sub_array, "sub_params");
                //print_r($vars);
                if($array)
                $result = $this->universal_model->add_more_item($array, "params");
                $result = true;
                $data["status"] = array("status"=>"success", "msg"=>"Yeni parametr uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
            }else {
                $data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
            }
        }
        $data["langs"] = $this->adm_model->langs();
        $data["param_types"] = $this->universal_model->get_more_item("param_types", array("deleted"=>0));
        $data["param_groups"] = $this->product_model->get_param_groups();
        $data["list"]= $this->product_model->params();


        $this->home('product/params', $data);
    }

    public function edit_param($param_id)
    {
        $param_id = (int)$param_id;
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $sub_array=array();
            $param_id_vars = array("active"=>$vars["active"], "order_by"=>$vars["order_by"], "required"=>$vars["required"], "param_group_id"=>$vars["param_group_id"], "param_type_id"=>$vars["param_type_id"]);
            $this->universal_model->item_edit_save("params_id", array("param_id"=>$param_id), $param_id_vars);

            $param_type_id = $vars["param_type_id"];
            unset($vars["active"]);
            unset($vars["order_by"]);
            unset($vars["required"]);
            unset($vars["param_group_id"]);
            unset($vars["param_type_id"]);

            $sub_param_id = array();
            $sub_params = false;
            //print_r($vars);
            foreach($vars as $key=>$value)
            {
                $name = explode("-", $key);
                if(!is_array($value))
                {
                    unset($vars[$key]);
                    $array[] = array("param_id"=>$param_id, "param_title"=>$value, "lang_id"=>(int)@$name[1]);
                }else {
                    $i=0;
                    //print_r($value);
                    foreach($value as $key=>$index)
                    {
                        //echo $key; print_r($index); echo "<br />";
                        foreach ($index as $sub_key => $sub_value) {
                            if(!$sub_params)
                            {
                                if(!((int)$key))
                                    $sub_param_id[] = $this->universal_model->add_item(array("active"=>1, "param_id"=>$param_id), "sub_params_id");
                                else
                                    $sub_param_id[] = (int)$key;
                            }
                            $sub_array[]= array("sub_param_id"=>$sub_param_id[$i], "sub_param_title"=>$sub_value, "lang_id"=>(int)@$name[1]);
                            $i++;
                        }


                    }
                    $sub_params = true;

                }
            }

            if($param_type_id<4 || $param_type_id>6){
                $this->product_model->delete_sub_params_id($param_id);
            }else {
                //print_r($sub_array);
                foreach ($sub_array as $key => $value) {
                    $result = $this->universal_model->item_edit_save("sub_params", array("sub_param_id"=>$value["sub_param_id"], "lang_id"=>$value["lang_id"]), $value);
                    if(!$result)
                        $result = $this->universal_model->add_item($value, "sub_params");
                }
            }
            //print_r($array);
            foreach ($array as $key => $value) {
                $result = $this->universal_model->item_edit_save("params", array("param_id"=>$param_id, "lang_id"=>$value["lang_id"]), $value);
                if(!$result)
                {
                    $result = $this->universal_model->add_item($value, "params");
                }
            }



            $result = true;
            $data["status"] = array("status"=>"success", "msg"=>"Parametrlər uğurla yeniləndi", "title"=>"Success!", "icon"=>"check-circle");

        }
        $data["langs"] = $this->adm_model->langs();
        $data["param_types"] = $this->universal_model->get_more_item("param_types", array("deleted"=>0));
        $data["param_groups"] = $this->product_model->get_param_groups();
        $data["param_id"] = $this->universal_model->get_item("params_id", array("param_id"=>$param_id));
        $data["params"] = $this->universal_model->get_more_item("params", array("param_id"=>$param_id), 1);
        $data["sub_params"] = $this->product_model->get_sub_params($param_id);
        $data["sub_params_id"] = $this->product_model->get_sub_params_id($param_id);
        $this->home('product/edit_param', $data);
    }

    public function get_sub_params($param_type_id)
    {
        $param_type_id = (int) $param_type_id;
        $langs = $this->adm_model->langs();
        $i = 1;
        if($param_type_id==4 || $param_type_id==5 || $param_type_id==6)
        {
            $tbl= '<table delete_url="/ajax/empty_delete/" class="table table-sm m-table m-table--head-bg-light table-bordered">
				<thead class="thead-inverse">
					<tr>';
            $thead = '';
            $tbody = '';
            foreach($langs as $lang){

                $tbl = $tbl.'<th>
								<img alt="'.$lang->name.'" style="max-width: 20px" src="/img/langs/'.$lang->thumb.'" style="margin-right: 5px" /> Sub parametrin adı
							</th>';
                $tbody = $tbody.'<td>
							<textarea name="sub_param_title-'.$lang->lang_id.'[]" class="form-contrl param_txt" ></textarea>
							</td>';
            }
            $tbl = $tbl.'<th style="position:relative;"> Sil
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
            return $tbl;
        }else {
            return "";
        }

    }

    public function delete_sub_param_id()
    {
        $sub_param_id = (int)$this->input->post("id");
        if($sub_param_id)
            $this->product_model->delete_sub_param_id($sub_param_id);
        echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
    }

    public function delete_param()
    {
        $param_id = (int)$this->input->post("id");
        if($param_id)
        {

            $this->universal_model->delete_item(array("param_id"=>$param_id), "params_id");
            $this->universal_model->delete_item(array("param_id"=>$param_id), "params");
            $this->product_model->delete_sub_params_id($param_id);

            echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
        }else {
            echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
        }
    }

    public function param_set_active_passive()
    {
        if($this->input->post("id"))
        {
            $result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("param_id"=>(int)$this->input->post("id")), "params_id");
            if($result)
            {
                echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
            }
            else
            {
                echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
            }
        }
    }
    /*****Params END******/
    /*****MEASURES START******/

    public function measures()
    {
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $measure_id_vars = array("active"=>$vars["active"], "order_by"=>$vars["order_by"]);
            $measure_id = $this->universal_model->add_item($measure_id_vars, "measures_id");
            unset($vars["active"]);
            unset($vars["order_by"]);
            if($measure_id)
            {
                foreach($vars as $key=>$value)
                {
                    $name = explode("-", $key);
                    $array[] = array("measure_id"=>$measure_id, "title"=>$value, "lang_id"=>(int)@$name[1]);
                }
                $result = $this->universal_model->add_more_item($array, "measures");
                $data["status"] = array("status"=>"success", "msg"=>"Yeni Ölçü vahidi uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
            }else {
                $data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
            }
        }
        $data["langs"] = $this->adm_model->langs();
        $data["list"]= $this->product_model->measures();

        $this->home('product/measures', $data);
    }

    public function edit_measure($measure_id)
    {
        $measure_id = (int)$measure_id;
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $measure_id_vars = array("active"=>(int)$vars["active"], "order_by"=>(int)$vars["order_by"]);
            $result = $this->universal_model->item_edit_save_where($measure_id_vars, array("measure_id"=>$measure_id), "measures_id");
            unset($vars["active"]);
            unset($vars["order_by"]);
            $this->universal_model->delete_item(array("measure_id"=>$measure_id), "measures");
            foreach($vars as $key=>$value)
            {
                $name = explode("-", $key);
                $array[] = array("measure_id"=>$measure_id, "title"=>$value, "lang_id"=>(int)@$name[1]);
            }
            $result = $this->universal_model->add_more_item($array, "measures");
            $data["status"] = array("status"=>"success", "msg"=>"Ölçü vahidi uğurla yeniləndi.", "title"=>"Success!", "icon"=>"check-circle");
        }
        $data["langs"] = $this->adm_model->langs();
        $data["list"]= $this->product_model->edit_measure($measure_id);
        $this->home('product/edit_measure', $data);
    }

    public function delete_measure()
    {
        if($this->input->post("id"))
        {
            $this->universal_model->item_edit_save_where(array("deleted"=>1), array("measure_id"=>$this->input->post("id")), "measures_id");
            echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
        }else {
            echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
        }
    }

    public function measure_set_active_passive()
    {
        if($this->input->post("id"))
        {
            $result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("measure_id"=>(int)$this->input->post("id")), "measures_id");
            if($result)
            {
                echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
            }
            else
            {
                echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
            }
        }
    }
    /*****MEASURES END******/
    /*****MEASURE Names******/

    public function measure_names()
    {
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $measure_names_id_vars = array("active"=>$vars["active"], "measure_id"=>$vars["measure_id"]);
            $mn_id = $this->universal_model->add_item($measure_names_id_vars, "measure_names_id");
            unset($vars["active"]);
            unset($vars["measure_id"]);
            if($mn_id)
            {
                foreach($vars as $key=>$value)
                {
                    $name = explode("-", $key);
                    $array[] = array("mn_id"=>$mn_id, "title"=>$value, "lang_id"=>(int)@$name[1]);
                }
                $result = $this->universal_model->add_more_item($array, "measure_names");
                $data["status"] = array("status"=>"success", "msg"=>"Yeni Ölçü uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
            }else {
                $data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
            }
        }
        $data["langs"] = $this->adm_model->langs();
        $data["list"]= $this->product_model->measure_names();
        $data["measure_id"]= $this->product_model->measures();
        $this->home('product/measure_names', $data);
    }

    public function edit_measure_names($mn_id)
    {
        $mn_id = (int)$mn_id;
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $mn_id_vars = array("active"=>(int)$vars["active"], "measure_id"=>(int)$vars["measure_id"]);
            $result = $this->universal_model->item_edit_save_where($mn_id_vars, array("mn_id"=>$mn_id), "measure_names_id");
            unset($vars["active"]);
            unset($vars["measure_id"]);
            $this->universal_model->delete_item(array("mn_id"=>$mn_id), "measure_names");
            foreach($vars as $key=>$value)
            {
                $name = explode("-", $key);
                $array[] = array("mn_id"=>$mn_id, "title"=>$value, "lang_id"=>(int)@$name[1]);
            }
            $result = $this->universal_model->add_more_item($array, "measure_names");
            $data["status"] = array("status"=>"success", "msg"=>"Ölçü uğurla yeniləndi.", "title"=>"Success!", "icon"=>"check-circle");
        }
        $data["langs"] = $this->adm_model->langs();
        $data["item"]= $this->product_model->edit_measure_name($mn_id);
        $data["measure_id"]= $this->product_model->measures();
        $this->home('product/edit_measure_names', $data);
    }

    public function delete_measure_names()
    {
        if($this->input->post("id"))
        {
            $this->universal_model->item_edit_save_where(array("deleted"=>1), array("measure_id"=>$this->input->post("id")), "measures_id");
            echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
        }else {
            echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
        }
    }

    public function measure_name_set_active_passive()
    {
        if($this->input->post("id"))
        {
            $result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("measure_id"=>(int)$this->input->post("id")), "measures_id");
            if($result)
            {
                echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
            }
            else
            {
                echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
            }
        }
    }
    /*****MEASURES END******/
    /*****CATEGORIES START******/

    public function categories()
    {
        $data["list"]= $this->product_model->categories();
        $this->home('product/categories', $data);
    }

    public function add_category()
    {
        $data["langs"] = $this->adm_model->langs();
        if($this->input->post())
        {
            $langs = $this->cache->model("adm_model", "langs");
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $cat_id_vars = array("active"=>$vars["active"], "parent_id"=>$vars["parent_id"], "discount_id"=>$vars["discount_id"], "on_home"=>$vars["on_home"], "on_menu"=>$vars["on_menu"], "order_by"=>$vars["order_by"]);

            $img="";
    				if(empty($_FILES['icon']['tmp_name']) || $_FILES['icon']['tmp_name'] == 'none')
    				{

    				}
            else
    				{
    					$img_name = "blog";
              $error=[];
    					$img = $this->do_upload("icon", $this->config->item('server_root').'/img/', 150000, $img_name);
    					if(@$img["error"]==TRUE)
    					{
    						$error = $img["error"];
    					}
              else
              {
    						$this->load->library('resize');
    						$this->resize->getFileInfo($img['full_path']);
    						$this->resize->resizeImage(90, 90, 'auto');
    						$this->resize->saveImage($this->config->item('server_root').'/img/icons/90x90/'.$img["file_name"], 95);

    						unlink($img['full_path']);
    						$cat_id_vars["icon"] = $img["file_name"];
    					}
    				}

            if(!isset($cat_id_vars["icon"]))
    				    $cat_id_vars["icon"] = "";

            $cat_id = $this->universal_model->add_item($cat_id_vars, "cats_id");
            unset($vars["active"]);
            unset($vars["order_by"]);
            unset($vars["parent_id"]);
            unset($vars["discount_id"]);
            unset($vars["on_home"]);
            unset($vars["on_menu"]);
            if($cat_id)
            {
                $array = array();
                foreach ($data["langs"] as $lang) {
                    $cat_name=	$description= $thumb= $seo_url= $seo_title= $seo_keywords= $seo_description="";
                    foreach ($vars as $key => $value) {
                        $name = explode("-", $key);
                        if($lang->lang_id==@$name[1])
                        {
                            if($name[0]=="title")
                                $cat_name=$value;
                            else if($name[0]=="description")
                                $description=$value;
                            else if($name[0]=="seo_url")
                                $seo_url=$value;
                            else if($name[0]=="seo_title")
                                $seo_title=$value;
                            else if($name[0]=="seo_keywords")
                                $seo_keywords=$value;
                            else if($name[0]=="seo_description")
                                $seo_description=$value;
                        }
                    }
                    $array[] = array("name"=>$cat_name, "description"=>$description, "seo_url"=>$seo_url,"seo_title"=>$seo_title, "seo_keywords"=>$seo_keywords, "seo_description"=>$seo_description, "cat_id"=>$cat_id, "lang_id"=>$lang->lang_id);
                }

                $result = $this->universal_model->add_more_item($array, "cats");
                $data["status"] = array("status"=>"success", "msg"=>"Yeni Kateqoriya uğurla əlavə edildi.", "title"=>"Success!", "icon"=>"check-circle");
            }else {
                $data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
            }
        }
        $data["param_groups_id"]= $this->product_model->param_groups();
        $data["discount_id"]= $this->product_model->discount_id();
        $data["cat_id"] = $this->product_model->cat_id();
        $data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
        $this->home('product/add_category', $data);
    }

    public function edit_category($cat_id)
    {
        $cat_id = (int)$cat_id;
        $data["langs"] = $this->adm_model->langs();
        if($this->input->post())
        {
            $langs = $this->cache->model("adm_model", "langs");
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $cat_id_vars = array("active"=>$vars["active"], "parent_id"=>$vars["parent_id"], "discount_id"=>$vars["discount_id"], "on_home"=>$vars["on_home"], "on_menu"=>$vars["on_menu"], "order_by"=>$vars["order_by"]);

            $img="";
    				if(empty($_FILES['icon']['tmp_name']) || $_FILES['icon']['tmp_name'] == 'none')
    				{

    				}
            else
    				{
    					$img_name = "blog";
              $error=[];
    					$img = $this->do_upload("icon", $this->config->item('server_root').'/img/', 150000, $img_name);
    					if(@$img["error"]==TRUE)
    					{
    						$error = $img["error"];
    					}
              else
              {
    						$this->load->library('resize');
    						$this->resize->getFileInfo($img['full_path']);
    						$this->resize->resizeImage(90, 90, 'auto');
    						$this->resize->saveImage($this->config->item('server_root').'/img/icons/90x90/'.$img["file_name"], 95);

    						unlink($img['full_path']);
    						$cat_id_vars["icon"] = $img["file_name"];
                if(isset($vars["selected_thumb"]))
                {
                  @unlink($_SERVER['DOCUMENT_ROOT'].'/img/icons/90x90/'.$vars["selected_thumb"]);
                }
    						unset($vars["selected_thumb"]);
    					}
              //print_r($img);

    				}
    				if(!isset($cat_id_vars["icon"]))
    				$cat_id_vars["icon"] = @$vars["selected_thumb"]?$vars["selected_thumb"]:"";

            $result = $this->universal_model->item_edit_save_where($cat_id_vars, array("cat_id"=>$cat_id), "cats_id");
            unset($vars["active"]);
            unset($vars["order_by"]);
            unset($vars["parent_id"]);
            unset($vars["selected_thumb"]);
            unset($vars["discount_id"]);
            unset($vars["on_home"]);
            unset($vars["on_menu"]);
            if($cat_id)
            {
                $array = array();
                foreach ($data["langs"] as $lang) {
                    $cat_name=	$description= $thumb= $seo_url= $seo_title= $seo_keywords= $seo_description="";
                    foreach ($vars as $key => $value) {
                        $name = explode("-", $key);
                        if($lang->lang_id==@$name[1])
                        {
                            if($name[0]=="title")
                                $cat_name=$value;
                            else if($name[0]=="description")
                                $description=$value;
                            else if($name[0]=="seo_url")
                                $seo_url=$value;
                            else if($name[0]=="seo_title")
                                $seo_title=$value;
                            else if($name[0]=="seo_keywords")
                                $seo_keywords=$value;
                            else if($name[0]=="seo_description")
                                $seo_description=$value;
                        }
                    }
                    $cat_var =  array("name"=>$cat_name, "description"=>$description, "seo_url"=>$seo_url,"seo_title"=>$seo_title, "seo_keywords"=>$seo_keywords, "seo_description"=>$seo_description, "cat_id"=>$cat_id, "lang_id"=>$lang->lang_id);


                    $result = $this->universal_model->item_edit_save("cats", array("cat_id"=>$cat_id, "lang_id"=>$lang->lang_id), $cat_var);
                    if(!$result)
                    {
                      $result = $this->universal_model->add_item($cat_var, "cats");
                    }
                }

                //$result = $this->universal_model->add_more_item($array, "cats");
                $data["status"] = array("status"=>"success", "msg"=>"Kateqoriya uğurla yeniləndi.", "title"=>"Success!", "icon"=>"check-circle");
            }else {
                $data["status"] = array("status"=>"danger", "msg"=>"Xəta baş verdi təkrar cəhd edin!", "title"=>"Error!", "icon"=>"exclamation-triangle");
            }
        }

        $data["param_groups_id"]= $this->product_model->param_groups();
        $data["relations"] = $this->universal_model->get_more_item("relations", array("rel_type_id"=>3, "item_id"=>$cat_id),1);
        $data["discount_id"]= $this->product_model->discount_id();
        $data["cat_id"] = $this->product_model->cat_id();
        $data["tinymce"] = $this->load->view("admin/tinymce", "", TRUE);
        $data["items"]= $this->product_model->edit_category($cat_id);
        //print_r($data["items"]);
        $this->home('product/edit_category', $data);
    }

    public function delete_category()
    {
      if($this->input->post("id"))
      {
        $this->universal_model->item_edit_save_where(array("deleted"=>1), array("cat_id"=>$this->input->post("id")), "cats_id");
        $this->universal_model->delete_relations($this->input->post("id"));
        echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
      }
      else
      {
        echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
      }
    }

    public function category_set_active_passive()
    {
        if($this->input->post("id"))
        {
            $result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("cat_id"=>(int)$this->input->post("id")), "cats_id");
            if($result)
            {
                echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
            }
            else
            {
                echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
            }
        }
    }
    /*****CATEGORIES END******/
    /*****Prameter groups START******/

    public function param_groups()
    {
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $param_group_id_vars = array("active"=>$vars["active"], "order_by"=>$vars["order_by"]);
            $param_group_id = $this->universal_model->add_item($param_group_id_vars, "param_groups_id");
            unset($vars["active"]);
            unset($vars["order_by"]);
            if($param_group_id)
            {
                foreach($vars as $key=>$value)
                {
                    $name = explode("-", $key);
                    $array[] = array("param_group_id"=>$param_group_id, "param_group_title"=>$value, "lang_id"=>(int)@$name[1]);
                }
                $result = $this->universal_model->add_more_item($array, "param_groups");
                $data["status"] = array("status"=>"success", "msg"=>$this->langs->item_added_successfully, "title"=>$this->langs->success_title, "icon"=>"check-circle");
            }else {
                $data["status"] = array("status"=>"danger", "msg"=>$this->langs->item_added_failed, "title"=>$this->langs->error_title, "icon"=>"exclamation-triangle");
            }
        }
        $data["langs"] = $this->adm_model->langs();
        $data["list"]= $this->product_model->param_groups();

        $this->home('product/param_groups', $data);
    }

    public function edit_param_group($param_group_id)
    {
        $param_group_id = (int)$param_group_id;
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $param_group_id_vars = array("active"=>(int)$vars["active"], "order_by"=>(int)$vars["order_by"]);
            $result = $this->universal_model->item_edit_save_where($param_group_id_vars, array("param_group_id"=>$param_group_id), "param_groups_id");
            unset($vars["active"]);
            unset($vars["order_by"]);
            foreach($vars as $key=>$value)
            {
                $name = explode("-", $key);
                $group_vars = array("param_group_id"=>$param_group_id, "param_group_title"=>$value, "lang_id"=>(int)@$name[1]);

                $result = $this->universal_model->item_edit_save("param_groups", array("param_group_id"=>$param_group_id, "lang_id"=>(int)@$name[1]), $group_vars);
                if(!$result)
                {
                    $result = $this->universal_model->add_item($group_vars, "param_groups");
                }
            }
            $data["status"] = array("status"=>"success", "msg"=>$this->langs->item_save_successfully, "title"=>$this->langs->success_title, "icon"=>"check-circle");
        }
        $data["langs"] = $this->adm_model->langs();
        $data["items"]= $this->product_model->edit_param_group($param_group_id);
        $this->home('product/edit_param_group', $data);
    }

    public function delete_param_group()
    {
        if($this->input->post("id"))
        {
            $this->universal_model->item_edit_save_where(array("deleted"=>1), array("param_group_id"=>$this->input->post("id")), "param_groups_id");
            echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
        }else {
            echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
        }
    }

    public function param_group_set_active_passive()
    {
        if($this->input->post("id"))
        {
            $result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("param_group_id"=>(int)$this->input->post("id")), "param_groups_id");
            if($result)
            {
                echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
            }
            else
            {
                echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
            }
        }
    }
    /*****Prameter groups END******/
    /*****Colors START******/

    public function colors()
    {
        $data = [];
        $data["langs"] = $this->adm_model->langs();
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $color_id_vars = array("active"=>$vars["active"], "color_code"=>$vars["color_code"]);
            $color_id = $this->universal_model->add_item($color_id_vars, "colors_id");
            if($color_id)
            {


                foreach ($data["langs"] as $lang) {
                    $array[] = [
                        "lang_id" => $lang->lang_id,
                        "color_name" => $vars["color_name-" . $lang->lang_id],
                        "color_id"=>$color_id
                    ];
                }
                $result = $this->universal_model->add_more_item($array, "colors");
                $data["status"] = array("status"=>"success", "msg"=>$this->langs->item_added_successfully, "title"=>$this->langs->success_title, "icon"=>"check-circle");
            }else {
                $data["status"] = array("status"=>"danger", "msg"=>$this->langs->item_added_failed, "title"=>$this->langs->error_title, "icon"=>"exclamation-triangle");
            }
        }

        $data["list"]= $this->product_model->colors($this->input->get());

        $this->home('product/colors', $data);
    }

    public function edit_color($color_id)
    {
        $color_id = (int)$color_id;
        $data["langs"] = $this->adm_model->langs();
        if($this->input->post())
        {
            $vars = $this->filter_data($this->input->post());
            $array=array();
            $color_id_vars = array("active"=>(int)$vars["active"], "color_code"=>$vars["color_code"]);
            $result = $this->universal_model->item_edit_save_where($color_id_vars, array("color_id"=>$color_id), "colors_id");


            foreach ($data["langs"] as $lang) {
                $array = [
                    "color_name" => $vars["color_name-" . $lang->lang_id],
                    "color_id"=>$color_id
                ];
                $result = $this->universal_model->item_edit_save("colors", array("color_id"=>$color_id, "lang_id"=>$lang->lang_id), $array);
                if(!$result)
                {
                    $result = $this->universal_model->add_more_item($array, "colors");
                }
            }
            $data["status"] = array("status"=>"success", "msg"=>$this->langs->item_save_successfully, "title"=>$this->langs->success_title, "icon"=>"check-circle");
        }
        $data["langs"] = $this->adm_model->langs();
        $data["items"]= $this->product_model->edit_color($color_id);
        $this->home('product/edit_color', $data);
    }

    public function delete_color()
    {
        if($this->input->post("id"))
        {
            $this->universal_model->item_edit_save_where(array("deleted"=>1), array("color_id"=>(int)$this->input->post("id")), "colors_id");
            echo '{"msg":"Əməliyyat uğurla baş tutdu. Silindi!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success", "header":"Uğurlu!"}';
        }else {
            echo '{"msg":"Zəhmət olmasa silmək istədiyiniz məlumatı seçin!", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error", "header":"Xəta!"}';
        }
    }

    public function color_set_active_passive()
    {
      if($this->input->post("id"))
      {
        $result = $this->universal_model->item_edit_save_where(array( "active"=>(int)$this->input->post("active_passive")), array("color_id"=>(int)$this->input->post("id")), "colors_id");
        if($result)
          echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
        else
          echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
      }
    }
    /*****Colors END******/

    public function show_in_main_page($array=[])
    {
      // $this->output->enable_profiler(TRUE);
      $from = 0;
      $result = $cat_id2 = [];
      $product_name = $sku = $cat_id = '';

      if($array)
        $data = $array;

      $filtered_post = $this->filter_data($this->input->post());

      if($this->input->POST('title'))
        $product_name = $filtered_post['title'];

      if($this->input->POST('sku'))
        $sku = $filtered_post['sku'];

      if($this->input->POST('category_id'))
        $cat_id2 = $filtered_post['category_id'];

      if($this->input->get('page'))
        $from = (int) $filtered_post['page'];

      $cat_id = implode(',', $cat_id2);
      $end = 20;

      $result = $this->product_model->get_product_list($from, $end, $cat_id, $product_name, $sku, $this->session->userdata('lang_id'), 'show_in_main_page');
      $data['list'] = $result['main'];
      $data['total'] = $result['total_row'];

      $base_url = "/product/show_in_main_page";
      if($data["total"][0]->count >= 1)
        $data["pagination"] = $this->pagination($from, $end, $base_url, $data["total"][0]->count, 3, 4);

      $this->home('product/show_in_main_page', $data);
    }

    public function show_unshow()
    {
      if($this->input->post("id"))
      {
        $response = false;
        $id = (int)$this->input->post('id');
        $showed = !(int)$this->input->post('active_passive');

        $response = $this->product_model->show_unshow($id, $showed, 'show_in_main_page');

        if($response)
          echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
        else
          echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
      }

    }

    public function show_unshow_category()
    {
      if($this->input->post("id"))
      {
        $id = (int)$this->input->post('id');
        $showed = !(int)$this->input->post('active_passive');

        $response = $this->product_model->show_unshow_category($id, $showed);

        if($response)
          echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.","'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
        else
          echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
      }

    }

    public function gunun_mehsuli()
    {
      $from = 0;
      $result = $cat_id2 = [];
      $product_name = $sku = $cat_id = '';

      if($this->input->POST('title'))
        $product_name = $this->input->POST('title');

      if($this->input->POST('sku'))
        $sku = $this->input->POST('sku');

      if($this->input->POST('category_id'))
        $cat_id2 = (int)$this->input->POST('category_id');

      if($this->input->get('page'))
        $from = (int)$this->input->get('page');

      $cat_id = implode(',', $cat_id2);
      $end = 40;

      $result = $this->product_model->get_product_list($from, $end, $cat_id, $product_name, $sku, $this->session->userdata('lang_id'), 'gunun_mehsullari');
      $data['list'] = $result['main'];
      $data['total'] = $result['total_row'];

      $base_url = "/product/gunun_mehsuli";
      if($data["total"][0]->count >= 1)
        $data["pagination"] = $this->pagination($from, $end, $base_url, $data["total"][0]->count, 3, 4);

      $this->home('product/gunun_mehsullari', $data);
    }

    public function show_unshow2()
    {
      if($this->input->post("id"))
      {
        $response = false;
        $id = (int)$this->input->post('id');
        $showed = !(int)$this->input->post('active_passive');

        $response = $this->product_model->show_unshow($id, $showed, 'gunun_mehsullari');

        if($response)
          echo '{"msg":"Status müvəffəqiyyətlə dəyişdirildi.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"success"}';
        else
          echo '{"msg":"Xəta baş verdi, təkrar cəhd edin.", "'.($this->security->get_csrf_token_name()).'":"'.($this->security->get_csrf_hash()).'", "status":"error"}';
      }

    }

    public function show_in_footer()
    {
      $data["list"]= $this->product_model->categories2($this->session->userdata('lang_id'));
      $this->home('product/show_in_footer', $data);
    }

  	public function get_import_contracts()
  	{
  		$post = $this->input->post();
  		$filtered_post = $this->filter_data($post);

  		$salesman_id = (int)$filtered_post['salesman_id'];

  		echo json_encode($this->product_model->get_import_contracts_with_id($salesman_id));
  	}









}
