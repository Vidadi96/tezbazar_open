
	<div class="m-content">
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
				<div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Yeni
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-angle-down"></i>
									</a>
								</li>
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-expand"></i>
									</a>
								</li>

							</ul>
						</div>
					</div>
					<!--begin::Form-->
					<form method="get" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
						<div class="m-portlet__body">
							<div class="form-group m-form__group row">
								<div class="col-lg-4">
									<label>Kateqoriyası</label>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									<input id="cc" name="category_id[]" class="easyui-combotree" data-options="url:'/ajax/get_categories/', method:'get',multiple:true,value:[<?=@implode(",",$filter["category_id"]);?>]" style="width:100%">
								</div>
								<?php $i=1; foreach($langs as $lang):?>
								<div class="col-lg-4">
									<div class="form-group">
										<label>Məhsulun adı (<?=$lang->name;?>) <img style="max-width: 20px" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" /></label>
										<input rel="<?=$lang->lang_id;?>" type="text" name="title-<?=$lang->lang_id;?>" class="form-control autocomplete" id="name" value="" />
									</div>
								</div>
								<?php
								if($i==2)
								{
									$i=-1;
									echo '</div><div class="form-group m-form__group row">';
								}

								$i++; endforeach;?>
							</div>
							<div class="form-group m-form__group row">
								<div class="col-lg-3">
									<label>SKU</label>
									<input type="text" name="sku" value="<?=@$filter["sku"];?>" class="form-control m-input" placeholder="">
								</div>
								<div class="col-lg-3">
									<label>Anbarda var :</label>
									<div class="input-group my-group">
										<span class="input-group-btn">
											<select class="form-control" name="measure_id">
												<?php foreach ($measures as $item) {
													echo '<option value="'.$item->measure_id.'">'.$item->title.'</option>';
												}
												?>
											</select>
						        </span>
				            <input type="text" class="form-control" name="measure_value" placeholder="Value">
				        </div>
				        <!-- /input-group -->
								</div>
								<div class="col-lg-3">
									<label>Qiymət</label>
									<input type="text" name="price" value="" class="form-control m-input" placeholder="">
								</div>
								<div class="col-lg-3">
									<label>Endirim faizi</label>
									<input type="text" name="discount" value="0" class="form-control m-input" placeholder="">
								</div>
							</div>

							<div class="form-group m-form__group row">

								<div class="col-lg-3">
									<label>Aktiv/Passiv</label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=(@$filter["active"])?"":"checked";?> value="1">
											Aktiv
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=(@$filter["active"]==1)?"checked":"";?> value="0">
											Passiv
											<span></span>
										</label>
									</div>
								</div>
								<div class="col-lg-4">
									<label>Parametr qrupu</label>
								</div>
							</div>
						</div>
						<!--begin:: Portlet footer-->
						<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
							<div class="m-form__actions m-form__actions--solid">
								<div class="row">
									<div class="col-lg-12 m--align-right">
										<button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Axtarış</button>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Portlet footer-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Portlet-->
			</div>
		</div>

	</div>

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
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
