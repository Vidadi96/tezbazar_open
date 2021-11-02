<?=$tinymce;?>
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
		<form method="POST" class="" enctype="multipart/form-data">
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



            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="m-portlet__body">
							<div class="tab-content">
							<?php $active="active"; foreach ($langs as $lang) {
								echo'
								<div class="tab-pane '.$active.'" id="tabs_'.$lang->lang_id.'" role="tabpanel">
								<div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>'.$this->langs->category_header.'</label>
										<textarea rows="1" type="text" name="title-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder=""></textarea>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>'.$this->langs->about_category.'</label>
										<textarea rows="3" type="text" name="description-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder=""></textarea>
									</div>
								</div>
								<div class="form-group m-form__group row" style="display: none;">
									<div class="col-lg-12">
										<label>Kateqoriyanın mətni</label>
										<textarea rows="12" type="text" name="content-'.$lang->lang_id.'" value="" class="form-control m-input tinymce" placeholder=""></textarea>
									</div>
								</div>
                <div class="form-group m-form__group row">
                  <div class="col-lg-12">
                    <h3 class="kt-section__title kt-section__title-lg">SEO:</h3>
                  </div>
                </div>
                <div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>SEO <span style="text-transform: lowercase">'.$this->langs->header.'</span></label>
										<textarea rows="1" type="text" name="seo_title-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder=""></textarea>
									</div>
								</div>
                <div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>SEO URL</label>
										<textarea rows="1" type="text" name="seo_url-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder=""></textarea>
									</div>
								</div>
                <div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>SEO '.$this->langs->key_words.'</label>
										<textarea rows="2" type="text" name="seo_keywords-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder=""></textarea>
									</div>
								</div>
                <div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>SEO '.$this->langs->about.'</label>
										<textarea rows="3" type="text" name="seo_description-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder=""></textarea>
									</div>
								</div>







								</div>
								';
								$active ="";
							}
							?>


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
									<?=$this->langs->category_option; ?>
								</h3>
							</div>
						</div>
					</div>
						<div class="m-portlet__body">
							<div class="form-group m-form__group row">
								<div class="col-lg-12">
                  <label><?=$this->langs->category; ?></label>
                  <select class="form-control" id="" name="parent_id">
                    <option value="0"><?=$this->langs->main_category; ?></option>
                    <?php
                      foreach ($cat_id as $cat) {
                        echo '<option value="'.$cat->cat_id.'">'.$cat->name.'</option>';
                      }
                    ?>
                  </select>
								</div>
							</div>
							<div style="display: none" class="form-group m-form__group row">
								<div class="col-lg-12">
                  <label><?=$this->langs->discount_percentage; ?></label>
                  <select class="form-control m-select2" id="m_select2_1" name="discount_id">
                    <option value="0"><?=$this->langs->select_discount_percentage; ?></option>
                    <?php
                      foreach ($discount_id as $d) {
                        echo '<option value="'.$d->discount_id.'">'.$cat->discount_name.'</option>';
                      }
                    ?>
                  </select>
								</div>
							</div>




							<div class="form-group m-form__group row">
								<div class="col-lg-12">
                  <label><?=$this->langs->row_number; ?></label>
                  <input type="text" name="order_by" value="" class="form-control m-input" placeholder="">
								</div>
							</div>

							<div class="form-group m-form__group row">
								<div class="col-lg-12">
									<label for=""><?=$this->langs->icon; ?></label><br>
									<input value="" type="file" name="icon" class="" id="icon">
								</div>
							</div>


							<div class="form-group m-form__group row" style="display: none;">
								<div class="col-lg-12">
									<label><?=$this->langs->on_menu; ?></label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="on_menu" <?=(@$filter["on_menu"])?"":"checked";?> value="1">
											<?=$this->langs->display; ?>
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="on_menu" <?=(@$filter["on_menu"]==1)?"checked":"";?> value="0">
											<?=$this->langs->unshow; ?>
											<span></span>
										</label>
									</div>
								</div>
							</div>
							<div class="form-group m-form__group row" style="display: none;">
								<div class="col-lg-12">
									<label>Əsas səhifədə</label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="on_home" <?=(@$filter["on_home"])?"":"checked";?> value="1">
											Görünsün
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="on_home" <?=(@$filter["on_home"]==1)?"checked":"";?> value="0">
											Görünməsin
											<span></span>
										</label>
									</div>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<div class="col-lg-12">
									<label><?=$this->langs->active_passive; ?></label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=(@$filter["active"])?"":"checked";?> value="1">
											<?=$this->langs->active; ?>
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=(@$filter["active"]==1)?"checked":"";?> value="0">
											<?=$this->langs->passive; ?>
											<span></span>
										</label>
									</div>
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


	function getChecked(){
      var nodes = $('.easyui-combotree').tree('getChecked');
      var s = '';
      for(var i=0; i<nodes.length; i++){
          if (s != '') s += ',';
          s += nodes[i].text;
      }
      console.log(s);
  }
	$(".easyui-combotree").tree({
		"onCheck": function(){
			getChecked();
		}
	})



	// $(".m_tree").jstree({
	// 					core: {
	// 							themes: {
	// 									responsive: !1
	// 							},
	// 							check_callback: !0,
	// 							data: {
	// 									url: function(e) {
	// 											return "/ajax/get_categories/"
	// 									},
	// 									data: function(e) {
	// 											return {
	// 													parent: e.id
	// 											}
	// 									}
	// 							}
	// 					},
	// 					types: {
	// 							default: {
	// 									icon: "fa fa-folder m--font-brand"
	// 							},
	// 							file: {
	// 									icon: "fa fa-file  m--font-brand"
	// 							}
	// 					},
	// 					state: {
	// 							key: "demo3"
	// 					},
	// 					plugins: ["dnd", "state", "types"]
	// 			});
	<?php foreach($langs as $lang):?>
	$('input[name=title-<?=$lang->lang_id;?>]').autocomplete({
			type: "GET",
			serviceUrl: '/ajax/get_product_name/'+<?=$lang->lang_id;?>,
			onSelect: function (suggestion) {
				product_id = suggestion.data;
			}
	})
	<?php endforeach;?>


});

</script>
