<?=$tinymce;?>
<?php

function return_more_selected($vars, $key, $value)
{
    if($vars)
    {
        foreach ($vars as $index) {
            if($index[$key]==$value)
                return "selected";
        }
        return "";
    }else {
        return "";
    }
}

?>
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
	<div class="m-content">
		<form method="POST" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
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

					<!--begin::Form-->
						<div class="m-portlet__body">
							<div class="tab-content">
							<?php $active="active"; foreach ($langs as $lang) {
								echo'
								<div class="tab-pane '.$active.'" id="tabs_'.$lang->lang_id.'" role="tabpanel">
								<div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>Yazının başlığı</label>
										<textarea rows="1" name="title-'.$lang->lang_id.'" class="form-control m-input" >'.@$post[(array_search($lang->lang_id, array_column($post, 'lang_id')))]["title"].'</textarea>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>Yazı haqqında</label>
										<textarea rows="3" name="description-'.$lang->lang_id.'" class="form-control m-input" >'.@$post[(array_search($lang->lang_id, array_column($post, 'lang_id')))]["description"].'</textarea>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>Yazının mətni</label>
										<textarea rows="12" name="content-'.$lang->lang_id.'" class="form-control m-input tinymce">'.@$post[(array_search($lang->lang_id, array_column($post, 'lang_id')))]["content"].'</textarea>
									</div>
								</div>
								</div>
								';
								$active ="";
							}
							?>
							</div>
						</div>
					<!--end::Form-->
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
									Yazı opisiyası
								</h3>
							</div>
						</div>
					</div>
					<!--begin::Form-->

						<div class="m-portlet__body">
							<div class="form-group m-form__group row">
								<div class="col-lg-12">
									<label>Category</label>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									<select class="form-control m-select2" id="m_select2_3" name="post_cat_id[]" multiple="multiple">
										<?php foreach ($cats as $cat) {
											echo '<option '.return_more_selected($selected_cat_id, "rel_item_id", $cat->post_cat_id).' value="'.$cat->post_cat_id.'">'.$cat->post_cat_title.'</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<div class="col-lg-12">
									<label for="">Şəkli</label><br>
									<input value="" type="file" name="thumb" class="" id="thumb">
									<?php if($post[0]["thumb"]){?>
										<span class="main_thumb">
												<img class="news_img" id="/img/blogs/95x95/<?=$post[0]["thumb"];?>" style="height:30px !important; border:1px solid #DDD; border-radius: 2px; margin-right: 5px; float: left;" src="/img/blogs/95x95/<?=$post[0]["thumb"];?>"/>
												<img class="remove_thumb_main" src="/img/icons/16x16/close.png" /><input type="hidden" name="selected_thumb" value="<?=$post[0]["thumb"];?>" />
											</span>
									<?php }else{ echo '<span class="main_thumb"></span>';} ?>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<div class="col-lg-12">
									<label>Publish date time</label>
									<input type="text" name="date_time" class="form-control date_time_picker" readonly placeholder="Select date & time" value="<?=date("d-m-Y H:i", strtotime($post[0]["date_time"]));?>"/>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<div class="col-lg-12">
									<label>Aktiv/Passiv</label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=$post[0]["active"]?"checked":"";?> value="1">
											Aktiv
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=$post[0]["active"]?"":"checked";?> value="0">
											Passiv
											<span></span>
										</label>
									</div>
								</div>
							</div>
						</div>
						<!--begin:: Portlet footer-->
						<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
							<div class="m-form__actions m-form__actions--solid">
								<div class="row">
									<div class="col-lg-12 m--align-right">
										<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Yadda saxla</button>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Portlet footer-->
					<!--end::Form-->
				</div>
				<!--end::Portlet-->
			</div>
			<!--Sidebar End-->
		</div>
		</form>
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
