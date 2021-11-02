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
		<a class="btn btn-success pull-right" href="/product/add_product/"><i class="fa fa-plus"></i> <?=$this->langs->new_product; ?></a>
	</div>
</div>
<!-- END: Subheader -->
	<div class="m-content">
		<div class="row">
			<div class="col-lg-12">
				<!--begin::Portlet-->
				<div class="m-portlet m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									<?=$this->langs->list; ?>
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
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

								<!--begin: Search Form -->
								<form action="" method="GET">
									<div class="form-group m-form__group row">
										<div class="col-lg-3">
											<label><?=$this->langs->product_name; ?></label>
											<input type="text" name="title" class="form-control m-input" placeholder="" value="<?=@$filter["title"];?>">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
										</div>
										<div class="col-lg-3">
											<label><?=$this->langs->category; ?></label>

											<input id="cc" name="category_id[]" class="easyui-combotree" data-options="url:'/ajax/get_categories/', method:'get',multiple:true,value:[<?=@implode(",", $filter["category_id"]); ?>]" style="width:100%">
										</div>
										<div class="col-lg-3">
											<label><?=$this->langs->brand; ?></label>
											<input id="cc" name="brand_id[]" class="easyui-combobox" data-options="url:'/ajax/get_brands/', method:'get',valueField:'id', textField:'text', multiple:true,value:[<?=@implode(",",$filter["brand_id"]);?>]" style="width:100%">
										</div>
										<div class="col-lg-3">
											<label>SKU</label>
											<input type="text" name="sku" value="<?=@$filter["sku"];?>" class="form-control m-input" placeholder="">
										</div>
										<div class="col-lg-3">
											<label><?=$this->langs->active_passive; ?></label>
											<div class="m-radio-inline">
												<label class="m-radio m-radio--solid">
													<input type="radio" name="active" <?=(@$filter["active"])?"":"checked";?> value="0">
													<?=$this->langs->all; ?>
													<span></span>
												</label>
												<label class="m-radio m-radio--solid">
													<input type="radio" name="active" <?=(@$filter["active"]==1)?"checked":"";?> value="1">
													<?=$this->langs->active; ?>
													<span></span>
												</label>
												<label class="m-radio m-radio--solid">
													<input type="radio" name="active" <?=(@$filter["active"]==2)?"checked":"";?> value="2">
													<?=$this->langs->passive; ?>
													<span></span>
												</label>
											</div>
										</div>
										<div class="col-md-3">
											<label>&nbsp;</label><br />
											<button type="submit" class="btn btn-primary"><i class="la la-search"></i> <?=$this->langs->search; ?> (<?=@$total_row; ?></i>)</button>
										</div>
									</div>

								</form>
								<!--end: Search Form -->


						<div class="row">
							<div class="col-xl-12">
								<table delete_url="/product/delete_product/" class="table table-bordered m-table" active_passive_url="/product/product_set_active_passive/">
									<thead>
										<tr>
											<th>
												<?=$this->langs->product_photo; ?>
											</th>
											<th>
												<?=$this->langs->name2; ?>
											</th>
											<th>
												<?=$this->langs->price; ?>
											</th>
											<th>
												SKU
											</th>
                      <th>
												<?=$this->langs->category; ?>
											</th>
											<th>
												<?=$this->langs->active_passive; ?>
											</th>
											<th>
												<?=$this->langs->edit; ?>
											</th>
											<th>
												<?=$this->langs->delete; ?>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($list as $item) {
											$word=$this->langs->do_passive."!"; $class="btn-success"; $active_passive=0;
											if($item->active == 0)
											{
												$word = $this->langs->do_active."!";
												$class = "btn-danger";
												$active_passive = 1;
											}
											$btn_active_passive = '<button active_passive="'.$active_passive.'" id="'.$item->p_id.'" type="button" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="'.$word.'" class="'.$class.' set_active_passive btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"></button>';

											echo '
											<tr>
												<td scope="row sm_img">
													<img src="/img/products/95x95/'.$item->img.'" width="24" />
												</td>
												<td>
													'.$item->product_name.'
												</td>
												<td>
													'.$item->price.' ₼
												</td>
												<td>
													'.$item->sku.'
												</td>
												<td>
													'.$item->category.'
												</td><td>
													'.$btn_active_passive.'
												</td>

												<td>
													<a href="/product/edit_product/'.$item->p_id.'" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only">
														<i class="fa fa-pencil-alt"></i>
													</a>
												</td>
												<td>
													<button href="#" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="'.$item->p_id.'">
														<i class="fa fa-trash"></i>
													</button>
												</td>
											</tr>
											';
										};?>

									</tbody>
								</table>
							</div>
						</div>





							</div>
						</div>
					</div>
				</div>
				<!--end::Portlet-->
				<div class="text-center">
					 <ul class="pagination pagination-lg text-center" style="display: inline-flex;">
							<?=@$pagination; ?>
					 </ul>
				</div>
			</div>
		</div>
	</div>

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/easyui.css">
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
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




});

</script>
