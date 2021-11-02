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

		<div class="row">
			<div class="col-lg-12">
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
          <form method="POST" class="" enctype="multipart/form-data">


            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="m-portlet__body">
							<div class="tab-content">
                <div class="form-group m-form__group row">
                  <div class="col-lg-3">
                    <label>Slayın linki</label>
                    <input class="form-control" value="<?=$slide[0]["slide_link"];?>" type="text" name="slide_link" />
  								</div>
                  <div class="col-lg-3">
  									<label>Aktiv/Passiv</label>
  									<div class="m-radio-inline">
  										<label class="m-radio m-radio--solid">
  											<input type="radio" name="active" <?=$slide[0]["active"]?'checked':'';?> value="1">
  											Aktiv
  											<span></span>
  										</label>
  										<label class="m-radio m-radio--solid">
  											<input type="radio" name="active" <?=$slide[0]["active"]?'':'checked';?> value="0">
  											Passiv
  											<span></span>
  										</label>
  									</div>
  								</div>


                  <div class="col-lg-6">
                    <label>&nbsp;</label></br>
  									<button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Yadda saxla</button>

  								</div>
  							</div>



							<?php $active="active"; foreach ($langs as $lang) {
								echo'
								<div class="tab-pane '.$active.'" id="tabs_'.$lang->lang_id.'" role="tabpanel">
								<div class="form-group m-form__group row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="">Şəkli</label><br>
                      <input value="" type="file" name="thumb-'.$lang->lang_id.'" class="" id="image-'.$lang->lang_id.'">';
                       if($slide[0]["image"]){?>
												<span class="main_thumb">
							  						<img class="news_img" id="/img/slides/95x95/<?=@$slide[(array_search($lang->lang_id, array_column($slide, 'lang_id')))]["image"];?>" style="height:30px !important; border:1px solid #DDD; border-radius: 2px; margin-right: 5px; float: left;" src="/img/slides/95x95/<?=@$slide[(array_search($lang->lang_id, array_column($slide, 'lang_id')))]["image"];?>"/>
							  						<img class="remove_thumb_main" src="/img/icons/16x16/close.png" /><input type="hidden" name="selected_thumb-<?=$lang->lang_id;?>" value="<?=@$slide[(array_search($lang->lang_id, array_column($slide, 'lang_id')))]["image"];?>" />
							  					</span>
											<?php }else{ echo '<span class="main_thumb"></span>';}
                    echo '</div>
                  </div>
								</div>
								</div>
								';
								$active ="";
							}
							?>


							</div>
						</div>
          </form>
          <!--end::Form-->
				</div>

				<!--end::Portlet-->
			</div>


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
