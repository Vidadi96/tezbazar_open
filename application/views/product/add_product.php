<?php echo $tinymce;

function return_selected($vars, $id)
{
    if ($vars) {
      foreach ($vars as $key => $value) {
        if($value==$id)
            return "selected";
      }
      return "";
    }
    else
      return "";
}
?>
<link href="/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="/css/jquery.fileuploader-theme-gallery.css" media="all" rel="stylesheet">
<script src="/dist/jquery.fileuploader.js?v=1" type="text/javascript"></script>
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="/adm/index/" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
            </ul>
            <h3 class="m-subheader__title m-subheader__title--separator">
                <?=$page_title;?>
            </h3>
        </div>
    </div>
</div>
<!-- END: Subheader -->
<div class="m-content">
    <!--begin::Form-->
    <form method="POST" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">

        <div class="row">
            <div class="col-lg-9">
                <!--begin::Portlet-->
                <?php if(isset($status)): ?>
                    <div class="m-alert m-alert--icon m-alert--outline alert alert-<?=$status['status'];?> alert-dismissible fade show" role="alert">
                        <div class="m-alert__icon">
                            <i class="fa fa-<?=$status['icon'];?>"></i>
                        </div>
                        <div class="m-alert__text">
                            <strong><?=$status['title'];?> </strong> <?=$status['msg'];?>
                        </div>
                        <div class="m-alert__close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif;?>
                <ul class="nav nav-tabs" role="tablist" style="margin-bottom: -1px;">
                    <?php $active="active"; foreach ($langs as $lang) {
                        echo '<li class="nav-item">
                  	<a class="nav-link '.$active.'" data-toggle="tab" href="#" data-target="#tabs_'.$lang->lang_id.'">
                  		'.$lang->name.' <img style="max-width: 20px" src="/img/langs/'.$lang->thumb.'" style="margin-right: 5px" />
                  	</a>
                  </li>';
                        $active="";
                    }
                    ?>
                </ul>
                <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
                    <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <?php $active="active"; foreach ($langs as $lang) {
                                echo'
                        <div class="tab-pane '.$active.'" id="tabs_'.$lang->lang_id.'" role="tabpanel">
                        <div class="form-group m-form__group row">
                        	<div class="col-lg-12 validated">
                        		<label>'.$this->langs->product_name.' *</label>
                        		<textarea rows="1" name="title-'.$lang->lang_id.'" class="form-control m-input" placeholder="">'.$this->input->post("title-".$lang->lang_id).'</textarea>
                        		'.(form_error('title-'.$lang->lang_id, '<div class="invalid-feedback">', '</div>')).'
                        	</div>

                        	<div class="col-lg-12">
                        	<br />
                        		<label>'.$this->langs->short_product_description.'</label>
                        		<textarea rows="3" name="description-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder="">'.$this->input->post("description-".$lang->lang_id).'</textarea>
                        	</div>
                        	<div style="display: none;" class="col-lg-12">
                        	    <br />
                        		<label>Məhsul haqqında tam məlumat</label>
                        		<textarea rows="12" name="content-'.$lang->lang_id.'" value="" class="form-control m-input tinymce" placeholder="">'.$this->input->post("content-".$lang->lang_id).'</textarea>
                        	</div>
                        </div>
                        <div class="form-group m-form__group row">
                          <div class="col-lg-12">
                            <h3 class="m-section__title">SEO:</h3>
                          </div>
                        	<div class="col-lg-12">
                        	    <br />
                        		<label>SEO <span style="text-transform: lowercase">'.$this->langs->header.'</span></label>
                        		<textarea rows="1" name="seo_title-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder="">'.$this->input->post("seo_title-".$lang->lang_id).'</textarea>
                        	</div>
                        	<br />
                        	<br />
                        	<div class="col-lg-12">
                        	    <br />
                        		<label>SEO URL</label>
                        		<textarea rows="1" name="seo_url-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder="">'.$this->input->post("seo_url-".$lang->lang_id).'</textarea>
                        	</div>
                        	<br />
                        	<br />
                        	<div class="col-lg-12">
                        	    <br />
                        		<label>SEO '.$this->langs->key_words.'</label>
                        		<textarea rows="2" name="seo_keywords-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder="">'.$this->input->post("seo_keywords-".$lang->lang_id).'</textarea>
                        	</div>
                        	<br />
                        	<br />
                        	<div class="col-lg-12">
                        	    <br />
                        		<label>SEO '.$this->langs->about.'</label>
                        		<textarea rows="3" name="seo_description-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder="">'.$this->input->post("seo_description-".$lang->lang_id).'</textarea>
                        	</div>
                        </div>
                        <div class="form-group m-form__group row">
                        </div>







                        </div>

                        ';
                                $active ="";
                            }?>


<?php $i_want2 = 0; if ($i_want2):  ?>
                            <div class="form-group m-form__group" style="margin-top: -50px;">
                                <div class="col-md-12">
                                    <h3 class="m-section__title"><?=$this->langs->price_warehouse_count; ?></h3>
                                    <br />

                                </div>
                                <div class="clearfix"></div>
                                <div class="color_container">
                                  <?php $i=0; if(isset($filter["color_id"])){ foreach ($filter["color_id"] as $color){ ?>
                                    <div class="color_item row">
                                        <div class="col-lg-11">
                                            <div class="row">
                                              <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="color_id[]">
                                                            <option value="0">Rəng yoxdur</option>
                                                            <?php foreach ($color_id as $cl)
                                                                    echo '<option '.(($filter["color_id"][$i]==$cl->color_id)?'selected':'').' value="'.$color->color_id.'">'.$cl->color_name.'</option>';
                                                            ?>
                                                        </select>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="mn_id[]" title="Ölçü">
                                                            <option value="0">Ölçü yoxdur</option>
                                                            <?php foreach ($mn_id as $mn) {
                                                                echo '<option '.(($filter["mn_id"][$i]==$mn->mn_id)?'selected':'').' value="'.$mn->mn_id.'">'.$mn->title.'</option>';
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>

                                                    <div class="col-md-4">
                                                        <select class="form-control" name="warehouse_id[]" title="Anbar">
                                                            <?php foreach ($warehouse_id as $warehouse) {
                                                                echo '<option '.(($filter["warehouse_id"][$i]==$warehouse->warehouse_id)?'selected':'').' value="'.$warehouse->warehouse_id.'">'.$warehouse->name.'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-6">
                                                  <div class="row">
                                                    <div class="col-md-3">
                                                      <input type="text" value="<?=$filter["count"][$i];?>"  class="form-control" name="count[]" placeholder="<?=$this->langs->count; ?>" title="<?=$this->langs->count; ?>">
                                                    </div>
                                                    <div class="col-md-3">
                                                      <select class="form-control" name="measure_id[]" title="<?=$this->langs->measurement; ?>">
                                                          <?php foreach ($measures as $measure)
                                                              echo '<option '.(($filter["measure_id"][$i]==$measure->measure_id)?'selected':'').' value="'.$measure->measure_id.'">'.$measure->title.'</option>';
                                                          ?>
                                                      </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" name="im_price[]" value="<?=$filter["im_price"][$i];?>" class="form-control m-input" placeholder="<?=$this->langs->import_price; ?>" title="<?=$this->langs->import_price; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" name="ex_price[]" value="<?=$filter["ex_price"][$i];?>" class="form-control m-input" placeholder="<?=$this->langs->price; ?>" title="<?=$this->langs->price; ?>">
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m--align-right">
                                            <a style="padding-left: 5px; padding-right: 5px;" href="javascript:;" data-repeater-delete="" class="btn btn-danger remove_color_item btn-icon">
                                                <i class="la la-remove"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <?php $i++; } } if(!$i){ ?>
                                        <div class="color_item row">
                                            <div class="col-lg-11">
                                                <div class="row">
                                                  <div class="col-md-8">
                                                    <div class="row">
                                                      <div style="display: none" class="col-md-3">
                                                        <select class="form-control" name="color_id[]" title="Rəng">
                                                          <option value="0">Rəng yoxdur</option>
                                                          <?php
                                                            foreach ($color_id as $color)
                                                              echo '<option value="'.$color->color_id.'">'.$color->color_name.'</option>';
                                                          ?>
                                                        </select>
                                                      </div>
                                                      <div style="display: none" class="col-md-3">
                                                        <select class="form-control" name="mn_id[]" title="Ölçü">
                                                            <option value="0">Ölçü yoxdur</option>
                                                            <?php foreach ($mn_id as $mn) {
                                                                echo '<option value="'.$mn->mn_id.'">'.$mn->title.'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                      </div>
                                                      <div class="col-md-2">
                                                        <select class="form-control" name="warehouse_id[]" title="<?=$this->langs->warehouse; ?>">
                                                          <?php foreach ($warehouse_id as $warehouse)
                                                            echo '<option value="'.$warehouse->warehouse_id.'">'.$warehouse->name.'</option>';
                                                          ?>
                                                        </select>
                                                      </div>
                                                      <div class="col-md-2">
                                                        <select class="form-control" name="entry_name_id[]" title="<?=$this->langs->import_type; ?>">
                                                          <?php foreach ($entry_type_list as $row)
                                                                  echo '<option value="'.$row->entry_name_id.'">'.$row->entry_name.'</option>';
                                                          ?>
                                                        </select>
                                                      </div>
                                                      <div class="col-md-2">
                                                        <select class="form-control" name="provider_id[]" title="<?=$this->langs->salesman; ?>">
                                                          <option value="0"></option>
                                                          <?php foreach ($salesmen as $row)
                                                                  echo '<option value="'.$row->id.'">'.$row->fullname.'</option>';
                                                          ?>
                                                        </select>
                                                      </div>
                                                      <div class="col-md-2">
                                                        <select class="form-control" name="contract_number[]" title="<?=$this->langs->contract_number; ?>">
                                                          <option value="0"></option>
                                                        </select>
                                                      </div>
                                                      <div class="col-md-2">
                                                        <input type="text" value="" class="form-control" name="check_number[]" placeholder="<?=$this->langs->check_number; ?>" title="<?=$this->langs->check_number; ?>">
                                                      </div>
                                                      <div class="col-md-2">
                                                        <input type="text" value=""  class="form-control date_time_picker" name="entry_date[]" placeholder="<?=$this->langs->entry_date; ?>" title="<?=$this->langs->entry_date; ?>">
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="row">
                                                      <div class="col-md-3">
                                                        <input type="text" value=""  class="form-control" name="count[]" placeholder="<?=$this->langs->count; ?>" title="<?=$this->langs->count; ?>">
                                                      </div>
                                                      <div class="col-md-3">
                                                        <select class="form-control" name="measure_id[]" title="<?=$this->langs->measurement; ?>">
                                                            <?php foreach ($measures as $measure)
                                                                echo '<option '.(($filter["measure_id"][$i]==$measure->measure_id)?'selected':'').' value="'.$measure->measure_id.'">'.$measure->title.'</option>';
                                                            ?>
                                                        </select>
                                                      </div>
                                                      <div class="col-md-3">
                                                        <div class="form-group">
                                                          <input type="text" name="im_price[]" value="" class="form-control m-input" placeholder="<?=$this->langs->import_price; ?>" title="<?=$this->langs->import_price; ?>">
                                                        </div>
                                                      </div>
                                                      <div class="col-md-3">
                                                        <div class="form-group">
                                                          <input type="text" name="ex_price[]" value="" class="form-control m-input" placeholder="<?=$this->langs->price; ?>" title="<?=$this->langs->price; ?>">
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 m--align-right">
                                                <a style="padding-left: 5px;
padding-right: 5px;" href="javascript:;" data-repeater-delete="" class="btn btn-danger remove_color_item btn-icon">
                                                    <i class="la la-remove"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row" style="">
                                    <div class="col-lg-12 m--align-right">
                                        <a href="javascript:;" style="padding-left: 5px;
padding-right: 5px;" data-repeater-create="" class="btn btn add_color_item btn-warning">
                                            <i class="la la-plus"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
<?php endif; ?>


                            <div class="form-group m-form__group row">
                                <div class="col-md-12">
                                    <h3 class="m-section__title"><?=$this->langs->photos; ?></h3>
                                    <div class="clearfix"></div>
                                    <div class="form">
                                        <!-- file input -->
                                        <input type="file" name="files" class="gallery_media">
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
            <!--Sidebar Start-->
            <div class="col-lg-3">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                        </span>
                                <h3 class="m-portlet__head-text">
                                    <?=$this->langs->product_option; ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <br />
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label><?=$this->langs->category; ?></label>
                                <input name="cat_id[]" class="easyui-combotree" data-options="url:'/ajax/get_categories/', method:'get',multiple:true,value:[<?=@implode(",",@$filter["cat_id"]);?>]" style="width:100%">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label><?=$this->langs->brand; ?></label>
                                <select class="form-control m-select2 m_select2_1" name="brand_id">
                                    <option value="0"><?=$this->langs->select_brand;?></option>
                                    <?php
                                    foreach ($brand_id as $d) {
                                        echo '<option '.return_selected(@$filter["brand_id"], $d->brand_id).' value="'.$d->brand_id.'">'.$d->name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                      <?php $i_want = false; if($i_want): ?>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label><?=$this->langs->discount_percentage; ?></label>
                                <select class="form-control m-select2" id="m_select2_1" name="discount_id">
                                    <option value="0"><?=$this->langs->select_discount_percentage; ?></option>
                                    <?php
                                    foreach ($discount_id as $d) {
                                        echo '<option '.return_selected(@$filter["discount_id"], $d->discount_id).' value="'.$d->discount_id.'">'.$d->discount_title.'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="form-group form-group-marginless">
                                    <div class="input-group">
                                        <input type="number" name="discount" value="<?=@$filter["discount"];?>" class="form-control m-input" placeholder="<?=$this->langs->or_special_discount_percentage; ?>" aria-describedby="basic-addon2">
                                        <div class="input-group-append"><span class="input-group-text" id="basic-addon2">%</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <?php endif; ?>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>SKU</label>
                                <input type="text" value="<?=$sku; ?>" class="form-control m-input" placeholder="" disabled>
                                <input type="hidden" name="sku" value="<?=$sku; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label><?=$this->langs->export_price; ?></label>
                                <input type="number" step="0.01" name="ex_price"  class="form-control m-input" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label><?=$this->langs->measurement; ?></label>
                                <select name="measure" class="form-control" required>
                                  <option value=""></option>
                                  <?php foreach($measures as $row): ?>
                                    <option value="<?=$row->measure_id; ?>"><?=$row->title; ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <div class="col-lg-12">
                                <label><?//=$this->langs->promotion; ?></label>
                                <div class="m-checkbox-list">
                                    <label class="m-checkbox">
                                        <input type="checkbox" <?//=(@$filter["action"]==1)?"checked":"";?> class="" name="action" value="1">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <br />

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label><?=$this->langs->active_passive;?></label>
                                <div class="m-radio-inline">
                                    <label class="m-radio m-radio--solid">
                                        <input type="radio" name="active" value="1" checked>
                                        <?=$this->langs->active;?>
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--solid">
                                        <input type="radio" name="active" value="0">
                                        <?=$this->langs->passive;?>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="borders_tree">
                            <div class="form-group row  advanced-setting parent-setting parent-setting-advanced opened">
                                <div class="col-md-12 advanced-setting-last parent_settings_t">
                                    <label><?=$this->langs->mark_az_new;?></label>
                                    <div class="m-checkbox-list">
                                        <label class="m-checkbox">
                                            <input type="checkbox" <?=(@$filter["as_new"]==1)?"checked":"";?> class="borders_tree_checkbox" name="as_new" <?=(@$filter["as_new"])?"checked":"";?> value="1">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="form-group row advanced-setting sub_border">
                                <div class="col-lg-12 parent_settings_p">
                                    <input type="text" class="form-control date_time_picker" name="as_new_start_date" value="<?=@$filter["as_new_start_date"];?>" placeholder="<?=$this->langs->as_new_start_date;?>"/>
                                </div>
                            </div>
                            <div class="form-group row advanced-setting advanced-setting-last sub_border">
                                <div class="col-lg-12 parent_settings_p">
                                    <input type="text" class="form-control date_time_picker" name="as_new_end_date" value="<?=@$filter["as_new_end_date"];?>"  placeholder="<?=$this->langs->as_new_end_date;?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="display: none">
                            <div class="col-lg-12">
                                <label>Admin qeyd</label>
                                <textarea rows="3" maxlength="550" name="admin_note" class="form-control set_max_length m-input" ><?=@$filter["admin_note"];?></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus"></i> <?=$this->langs->submit; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
            <!--Sidebar End-->
        </div>
    </form>
    <!--end::Form-->
</div>
</div>
<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<script src="/assets/demo/default/custom/crud/forms/widgets/select2.js" type="text/javascript"></script>
<script src="/assets/demo/default/custom/crud/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/easyui.css">
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        // $(".add_color_item").click(function () {
        //     $(".color_container").append($(".color_container .color_item:first-child").clone());
        // });
        //
        // $(document).on('click', '.remove_color_item', function (evt) {
        //     if($(".color_item").length>1)
        //       $(this).closest(".color_item").slideUp(300, function(){
        //           $(this).remove();
        //       })
        //       else
        //         toastr.warning("Təəssüf edirik, sonuncunu silə bilməzsiniz", "Xəbərdarlıq");
        // });




        var product_id = 0;
        $.get('/product/add_product/?type=preload&id=0&product_id='+product_id, function(result) {
            var preloaded = [];

            try {
                // preload the files
                preloaded = JSON.parse(result);
            } catch(e) {}

            $(document).on('click', '.fileuploader-action-asmain', function (evt) {
                $('.fileuploader-action-asmain').removeClass("selected_img");
                $(this).addClass("selected_img");
                var li = $(this).closest("li");
                $(this).closest("li").fadeOut(300, function(){

                    $("ul.fileuploader-items-list li:eq(0)").after(li);
                    li.fadeIn(300);
                    var i=0;
                    var list = [];
                    $("ul.fileuploader-items-list li").each(function(){
                        if(i!=0)
                        {
                            var img_id = $(this).find("img").attr("id");
                            list.push({
                                name: "",
                                id: img_id,
                                index: i
                            });
                        }
                        i++;
                    });
                    $.post('/product/add_product/?type=sort&product_id=0', {
                        list: JSON.stringify(list),
                        tezbazar: $("input[name=tezbazar]").val()

                    });
                    /*// prepare the sorted list
                    api.getFiles().forEach(function(item) {
                      if (item.data.listProps)
                        list.push({
                          name: item.name,
                          id: item.data.listProps.id,
                          index: item.index
                        });
                    });

                    // send request
                    $.post('/product/add_product/?type=sort&product_id='+product_id, {
                      list: JSON.stringify(list),
                      tim: $("input[name=tim]").val()
                    });*/


                });
            })
            $('input.gallery_media').fileuploader({
                limit: 25,
                fileMaxSize: 20,
                extensions: ['image/*'], /*['video/*', 'audio/*']*/
                changeInput: ' ',
                theme: 'gallery',
                enableApi: true,
                files: preloaded,
                thumbnails: {
                    box: '<div class="fileuploader-items">' +
                        '<ul class="fileuploader-items-list">' +
                        '<li class="fileuploader-input"><div class="fileuploader-input-inner"><div class="fa fa-cloud-upload-alt"></div> <span>${captions.feedback}</span></div></li>' +
                        '</ul>' +
                        '</div>',
                    item: '<li class="fileuploader-item file-has-popup">' +
                        '<div class="fileuploader-item-inner">' +
                        '<div class="actions-holder">' +
                        '<a class="fileuploader-action fileuploader-action-sort is-hidden" title="${captions.sort}"><i class="fa fa-arrows"></i></a>' +

                        '<a class="fileuploader-action fileuploader-action-popup fileuploader-action-settings is-hidden" title="${captions.edit}"><i class="fa fa-pencil-alt"></i></a>' +
                        '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="fa fa-trash"></i></a>' +

                        '</div>' +
                        '<div class="thumbnail-holder" style="">' +
                        '${image}' +
                        '<span class="fileuploader-action-popup"></span>' +
                        '<div class="progress-holder"><span></span>${progressBar}</div>' +
                        '</div>' +
                        '</div>' +
                        '<a class="fileuploader-action-asmain" title="">${captions.setting_asMain}</a>' +
                        '</li>',
                    item2: '<li class="fileuploader-item file-has-popup file-main-${data.isMain}">' +
                        '<div class="fileuploader-item-inner">' +
                        '<div class="actions-holder">' +
                        '<a class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i class="fa fa-arrows-alt"></i></a>' +

                        '<a class="fileuploader-action fileuploader-action-popup fileuploader-action-settings" title="${captions.edit}"><i class="fa fa-pencil-alt"></i></a>' +
                        '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="fa fa-trash"></i></a>' +

                        '</div>' +
                        '<div class="thumbnail-holder" style="">' +
                        '${image}' +
                        '<span class="fileuploader-action-popup"></span>' +
                        '</div>' +
                        '</div>' +
                        '<a class="fileuploader-action-asmain" title="">${captions.setting_asMain}</a>' +
                        '</li>',
                    itemPrepend: false,
                    startImageRenderer: true,
                    canvasImage: false,
                    onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
                        var api = $.fileuploader.getInstance(inputEl),
                            color = api.assets.textToColor(item.format),
                            $plusInput = listEl.find('.fileuploader-input'),
                            $progressBar = item.html.find('.progress-holder');

                        // put input first in the list
                        $plusInput.prependTo(listEl);

                        // color the icon and the progressbar with the format color
                        item.html.find('.type-holder .fileuploader-item-icon')[api.assets.isBrightColor(color) ? 'addClass' : 'removeClass']('is-bright-color').css('backgroundColor', color);
                        $progressBar.css('backgroundColor', color);
                    },
                    onImageLoaded: function(item, listEl, parentEl, newInputEl, inputEl) {
                        var api = $.fileuploader.getInstance(inputEl);

                        // check the image size
                        if (item.format == 'image' && item.upload && !item.imU) {
                            if (item.reader.node && (item.reader.width < 100 || item.reader.height < 100)) {
                                alert(api.assets.textParse(api.getOptions().captions.imageSizeError, item));
                                return item.remove();
                            }

                            item.image.hide();
                            item.reader.done = true;
                            item.upload.send();
                        }

                    },
                    onItemRemove: function(html) {
                        html.fadeOut(250);
                    }
                },
                dragDrop: {
                    container: '.fileuploader-theme-gallery .fileuploader-input'
                },
                upload: {
                    url: '/product/add_product/?type=upload&product_id='+product_id,
                    data: null,
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    start: true,
                    synchron: true,
                    beforeSend: function(item) {
                        item.upload.data.tezbazar = $("input[name=tezbazar]").val();
                        // check the image size first (onImageLoaded)
                        if (item.format == 'image' && !item.reader.done)
                            return false;

                        // add editor to upload data after editing
                        if (item.editor && (typeof item.editor.rotation != "undefined" || item.editor.crop)) {
                            item.imU = true;
                            item.upload.data.file = item.name;
                            item.upload.data.id = item.data.listProps.id;
                            item.upload.data._editorr = JSON.stringify(item.editor);
                        }

                        item.html.find('.fileuploader-action-success').removeClass('fileuploader-action-success');
                    },
                    onSuccess: function(result, item) {
                        var data = {};

                        try {
                            data = JSON.parse(result);
                        } catch (e) {
                            data.hasWarnings = true;
                        }

                        // if success update the information
                        if (data.isSuccess && data.files.length) {
                            if (!item.data.listProps)
                                item.data.listProps = {};
                            //item.title = data.files[0].title;
                            item.name = data.files[0].name;
                            item.size = data.files[0].size;
                            item.size2 = data.files[0].size2;
                            item.data.url = data.files[0].url;
                            item.data.listProps.id = data.files[0].id;

                            //item.html.find('.content-holder h5').attr('title', item.name).text(item.name);
                            //item.html.find('.content-holder span').text(item.size2);
                            item.html.find('.gallery-item-dropdown [download]').attr('href', item.data.url);
                        }

                        // if warnings
                        if (data.hasWarnings) {
                            for (var warning in data.warnings) {
                                alert(data.warnings[warning]);
                            }

                            item.html.removeClass('upload-successful').addClass('upload-failed');
                            return this.onError ? this.onError(item) : null;
                        }

                        delete item.imU;
                        item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');

                        setTimeout(function() {
                            item.html.find('.progress-holder').hide();

                            item.html.find('.fileuploader-action-popup, .fileuploader-item-image').show();
                            item.html.find('.fileuploader-action-sort').removeClass('is-hidden');
                            item.html.find('.fileuploader-action-settings').removeClass('is-hidden');
                        }, 400);
                    },
                    onError: function(item) {
                        item.html.find('.progress-holder, .fileuploader-action-popup, .fileuploader-item-image').hide();

                        // add retry button
                        item.upload.status != 'cancelled' && !item.imU && !item.html.find('.fileuploader-action-retry').length ? item.html.find('.actions-holder').prepend(
                            '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                        ) : null;
                    },
                    onProgress: function(data, item) {
                        var $progressBar = item.html.find('.progress-holder');

                        if ($progressBar.length) {
                            $progressBar.show();
                            $progressBar.find('span').text(data.percentage + '%');
                            $progressBar.find('.fileuploader-progressbar .bar').height(data.percentage + '%');
                        }

                        item.html.find('.fileuploader-action-popup, .fileuploader-item-image').hide();
                    }
                },
                editor: {
                    cropper: {
                        showGrid: true,
                        minWidth: 100,
                        minHeight: 100
                    },
                    onSave: function(dataURL, item) {
                        // if no editor
                        if (!item.editor || !item.reader.width)
                            return;

                        // if uploaded
                        // resend upload
                        if (item.upload && item.upload.resend)
                            item.upload.resend();

                        // if preloaded
                        // send request
                        if (item.appended && item.data.listProps) {
                            // hide current thumbnail
                            item.imU = true;
                            item.image.addClass('fileuploader-loading').find('img, canvas').hide();
                            item.html.find('.fileuploader-action-popup').hide();

                            $.post('/product/add_product/?type=resize&product_id='+product_id, {tezbazar: $("input[name=tezbazar]").val(), name: item.name, id: item.data.listProps.id, _editor: JSON.stringify(item.editor)}, function() {
                                // update the image
                                item.reader.read(function() {
                                    delete item.imU;

                                    item.image.removeClass('fileuploader-loading').find('img, canvas').show();
                                    item.html.find('.fileuploader-action-popup').show();
                                    item.editor.rotation = item.editor.crop = null;
                                    item.popup = {open: item.popup.open};
                                }, null, true);
                            });
                        }
                    }
                },
                sorter: {
                    onSort: function(list, listEl, parentEl, newInputEl, inputEl) {
                        var i=0;
                        var list = [];
                        $("ul.fileuploader-items-list li").each(function(){
                            if(i!=0)
                            {
                                var img_id = $(this).find("img").attr("id");
                                list.push({
                                    name: "",
                                    id: img_id,
                                    index: i
                                });
                            }
                            i++;
                        });
                        $.post('/product/add_product/?type=sort&product_id=0', {
                            list: JSON.stringify(list),
                            tezbazar: $("input[name=tezbazar]").val()
                        });

                    }
                },
                afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                    var api = $.fileuploader.getInstance(inputEl),
                        $plusInput = listEl.find('.fileuploader-input');

                    // bind input click
                    $plusInput.on('click', function() {
                        api.open();
                    });

                    // bind dropdown buttons
                    $('body').on('click', function(e) {

                        var $target = $(e.target),
                            $item = $target.closest('.fileuploader-item'),
                            item = api.findFile($item);
                        $('.gallery-item-dropdown').hide();
                        if ($target.is('.fileuploader-action-settings') || $target.parent().is('.fileuploader-action-settings')) {
                            $item.find('.gallery-item-dropdown').show(150);
                        }

                        // rename
                        if ($target.is('.gallery-action-rename')) {
                            var x = prompt(api.getOptions().captions.rename, item.title);

                            if (x && item.data.listProps) {
                                $.post('/product/add_product/?type=rename&product_id='+product_id, {name: item.name, id: item.data.listProps.id, title: x, tezbazar: $("input[name=tezbazar]").val()}, function(result) {
                                    try {
                                        var j = JSON.parse(result);

                                        // update the file name and url
                                        if (j.title) {
                                            item.title = j.title;
                                            item.name = item.title + (item.extension.length ? '.' + item.extension : '');
                                            //$item.find('.content-holder h5').attr('title', item.name).html(item.name);
                                            $item.find('.gallery-item-dropdown [download]').attr('href', item.data.url);

                                            if (item.popup.html)
                                                item.popup.html.find('h5:eq(0)').text(item.name);

                                            if (j.url)
                                                item.data.url = j.url;
                                            if (item.appended && j.file)
                                                item.file = j.file;

                                            api.updateFileList();
                                        }

                                    } catch(e) {
                                        alert(api.getOptions().captions.renameError);
                                    }
                                });
                            }
                        }
                    });


                },
                onRemove: function(item) {
                    // send request
                    if (item.data.listProps)
                        $.post('/product/add_product/?type=remove&product_id='+product_id, {
                            name: item.name,
                            id: item.data.listProps.id,
                            tezbazar : $("input[name=tezbazar]").val()
                        });
                },
                captions: {
                    feedback: feedback[lang],
                    setting_asMain: setting_asMain[lang],
                    setting_download: setting_download[lang],
                    setting_edit: setting_edit[lang],
                    setting_rename: setting_rename[lang],
                    rename: rename[lang],
                    renameError: renameError[lang],
                    imageSizeError: imageSizeError[lang],
                    errors: {
                        filesLimit: filesLimit[lang],
                        filesType: filesType[lang],
                        fileSize: '${name} is too large! Please choose a file up to ${fileMaxSize}MB.',
                        filesSizeAll: 'Files that you chose are too large! Please upload files up to ${maxSize} MB.',
                        fileName: 'File with the name ${name} is already selected.',
                        folderUpload: 'You are not allowed to upload folders.'
                    }

                }
            });
        });

        var lang = $('#language2').text();

        var feedback = [];
        feedback['az'] = 'Şəkil yükləyin';
        feedback['tr'] = 'Resmi indir';
        feedback['en'] = 'Download photo';
        feedback['ru'] = 'Скачать картинку';

        var setting_asMain = [];
        setting_asMain['az'] = 'Əsas şəkil et';
        setting_asMain['tr'] = 'Ana fotoğrafı yap';
        setting_asMain['en'] = 'Set as main photo';
        setting_asMain['ru'] = 'Сделать главным фото';

        var setting_download = [];
        setting_download['az'] = 'Endir';
        setting_download['tr'] = 'İndir';
        setting_download['en'] = 'Download';
        setting_download['ru'] = 'Скачать';

        var setting_edit = [];
        setting_edit['az'] = 'Redaktə';
        setting_edit['tr'] = 'Düzenle';
        setting_edit['en'] = 'Edit';
        setting_edit['ru'] = 'Редактировать';

        var setting_rename = [];
        setting_rename['az'] = 'Ad dəyişdir';
        setting_rename['tr'] = 'Ad deyiştir';
        setting_rename['en'] = 'Change name';
        setting_rename['ru'] = 'Изменить название';

        var rename = [];
        rename['az'] = 'Faylın yeni adını daxil edin:';
        rename['tr'] = 'Yeni dosya adı ekle:';
        rename['en'] = 'Add new file name:';
        rename['ru'] = 'Добавьте новое имя папки:';

        var renameError = [];
        renameError['az'] = 'Zəhmət olmasa başqa ad yazın.';
        renameError['tr'] = 'Başqa bir isim yazınız.';
        renameError['en'] = 'Write another name.';
        renameError['ru'] = 'Введите другое имя.';

        var imageSizeError = [];
        imageSizeError['az'] = 'Şəklin ${name} həcmi çox kiçikdir.';
        imageSizeError['tr'] = 'Resmin ${name} hacmi çok kiçik.';
        imageSizeError['en'] = 'İmage ${name} size is very small.';
        imageSizeError['ru'] = 'Объем фото ${name} слишком маленький.';

        var filesLimit = [];
        filesLimit['az'] = 'Yalnız ${limit} şəkil yükləməyə icazə verilir.';
        filesLimit['tr'] = 'Yalnız ${limit} resim indirmeye izin veriliyor.';
        filesLimit['en'] = 'Only ${limit} photos download is permitted.';
        filesLimit['ru'] = 'Только ${limit} фото разрешено скачать.';

        var filesType = [];
        filesType['az'] = 'Yalnız Şəkil formatlarına icazə verilir.';
        filesType['tr'] = 'Yalnız Resim biçimlerine izin veriliyor.';
        filesType['en'] = 'Only İmage format is permitted.';
        filesType['ru'] = 'Только формат картинок разрешено.';

        function getChecked(){
            var nodes = $('.easyui-combotree').tree('getChecked');
            var s = '';
            for(var i=0; i<nodes.length; i++){
                if (s != '') s += ',';
                s += nodes[i].text;
            }
            //console.log(s);
        }
        $(".easyui-combotree").tree({
            "onCheck": function(){
                getChecked();
            }
        })


        <?php foreach($langs as $lang):?>
        $('input[name=title-<?=$lang->lang_id;?>]').autocomplete({
            type: "GET",
            serviceUrl: '/ajax/get_product_name/'+<?=$lang->lang_id;?>,
            onSelect: function (suggestion) {
                product_id = suggestion.data;
            }
        })
        <?php endforeach;?>


        $("input[name=discount]").keyup(function() {
           if($(this).val().length>0)
           {
               $("select[name=discount_id]").val(0).trigger('change.select2');
               $("select[name=discount_id]").prop('disabled', 'disabled');
           }else
           {
               $("select[name=discount_id]").prop('disabled', false);
           }
        });

        var token = $('#token').val();
        $(document).on('change', 'select[name="provider_id[]"]', function(){
          var salesman_id = $(this).val();
          var salesman_select = $(this);
          $(this).closest('.row').find('select[name="contract_number[]"]').prop('disabled', true);
          $.ajax({
            url: '/product/get_import_contracts',
            type: 'POST',
            data: {salesman_id: salesman_id, tezbazar: token},
            success: function(data){
              var ic = $.parseJSON(data);
              var html = '<option value="0"></option>';
              for (var i = 0; i < ic.length; i++)
                html = html + '<option value="' + ic[i].id + '">' + ic[i].contract_number + '</option>';

              salesman_select.closest('.row').find('select[name="contract_number[]"]').html(html);
              salesman_select.closest('.row').find('select[name="contract_number[]"]').prop('disabled', false);
            }
          });
        });

    });

</script>
<style type="text/css">
    .param_group_container
    {
        margin-top: 20px;
    }
    .m-form.m-form--fit .m-form__content, .m-form.m-form--fit .m-form__group, .m-form.m-form--fit .m-form__heading {
        padding-left: 0px;
        padding-right: 0px;
    }
    .m-option h4
    {
        margin-top: 0;
        border-bottom: 2px solid #91dd71;
        display: inline-block;
        padding-bottom: 5px;
    }
    .m-option
    {
        border: 1px solid #91dd71;
        margin-top: 10px;
    }

    .m-option .col-md-4
    {
        padding-top: 20px;
    }
</style>
