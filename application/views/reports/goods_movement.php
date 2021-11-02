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
								<div class="absolute_right">
									<form action="/reports/goods_movement_excel" method="POST">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
										<input type="hidden" name="category_id" value="<?=$category_id; ?>">
										<input type="hidden" name="product_id" value="<?=$product_id; ?>">
										<input type="hidden" name="date_start" value="<?=$date_start; ?>">
										<input type="hidden" name="date_end" value="<?=$date_end; ?>">
										<button type="submit" class="btn btn-success excel_click">
											<i class="fa fa-file-excel"></i> Export
										</button>
									</form>
								</div>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">


							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

								<!--begin: Search Form -->
								<form action="/reports/goods_movement" method="POST">
									<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									<div class="form-group m-form__group row">
										<div class="col-lg-10">
										  <div class="row">
												<div class="col-lg-3">
													<label><?=$this->langs->category; ?></label>
													<input id="cc" name="category_id[]" class="easyui-combotree" data-options="url:'/ajax/get_categories/', method:'get',multiple:true,value:[<?=@$category_id; ?>]" style="width:100%">
												</div>
												<div class="col-lg-3">
													<label for="product_search"><?=$this->langs->product_name; ?></label>
													<input list="product_search" class="form-control" value="<?=$product_name;?>">
													<datalist id="product_search">
														<?php foreach ($products as $row): ?>
															<option data-value="<?=$row->p_id; ?>" value="<?=$row->product_name." - #".$row->sku; ?>">
														<?php endforeach; ?>
													</datalist>
													<input type="hidden" name="product_id" value="<?=$product_id; ?>" required>
												</div>
												<div class="col-lg-3">
													<label><?=$this->langs->start_date; ?></label>
													<input type="text" name="start_date" class="form-control m-input date_time_picker" value="<?=$date_start; ?>">
												</div>
												<div class="col-lg-3">
													<label><?=$this->langs->end_date; ?></label>
													<input type="text" name="end_date" class="form-control m-input date_time_picker" value="<?=$date_end; ?>">
												</div>
											</div>
										</div>
										<div class="col-lg-2">
											<label>&nbsp;</label><br />
											<button type="submit" class="btn btn-primary"><i class="la la-plus"></i> <?=$this->langs->display; ?></i></button>
										</div>
									</div>

								</form>
								<!--end: Search Form -->


								<div class="row">
									<div class="col-xl-12">
										<table class="table table-bordered m-table" active_passive_url="/product/show_unshow2/">
											<thead>
												<tr>
													<th><?=$this->langs->code_of_product; ?></th>
													<th><?=$this->langs->product_name; ?></th>
													<th><?=$this->langs->import_price; ?></th>
													<th><?=$this->langs->export_price; ?></th>
													<th><?=$this->langs->import; ?></th>
													<?php foreach ($export_name as $row): ?>
														<th><?=$row->export_name; ?></th>
													<?php endforeach; ?>
													<th><?=$this->langs->balance; ?></th>
												</tr>
											</thead>
											<tbody>
												<?php $previousVal = '';
													$p_id = 0;
													$tot_im_count = 0;
													$tot_ex_count = [];
													$tot_count = 0;
													$row_count = 0;
													foreach ($export_name as $riw)
														$tot_ex_count[] = 0;

													for ($i = 0; $i < count($goods_movement_list); $i++):
														$row = $goods_movement_list[$i];
														$p_id = $row->product_id;
														if ($row->row_count)
															$row_count = $row_count + $row->row_count;
												?>
			                    <tr>
														<?php if($row->row_count):
																if ($row_count > 15)
																	$row->row_count = $row->row_count - ($row_count - 15);
															?>
				                      <td rowspan="<?=$row->row_count; ?>"><?='#'.$row->sku; ?></td>
				                      <td rowspan="<?=$row->row_count; ?>"><?=$row->name; ?></td>
														<?php endif; ?>
			                      <td><?=$row->im_price; ?> ₼</td>
			                      <td><?=$row->ex_price; ?> ₼</td>
			                      <td><?=$row->count; ?></td>
														<?php $j = 0; $b = 0; foreach ($export_name as $ruw): ?>
															<td>
																<?php
																	$a = 0;
																	foreach($goods_movement_list_inside as $raw):
																		if ($raw->import_id == $row->id):
																			if ($raw->entry_name_id == $ruw->export_name_id):
																				$a = $a + $raw->count;
																				$b = $b + $raw->count;
																			endif;
																		endif;
																	endforeach;
																	echo $a;
																	$tot_ex_count[$j] = $tot_ex_count[$j] + $a;
																?>
															</td>
														<?php $j++; endforeach; ?>
														<td><?=$row->count - $b; ?></td>
			                    </tr>
												<?php
													$tot_im_count = $tot_im_count + $row->count;
													$tot_count = $tot_count + $row->count - $b;
													if ($i == (count($goods_movement_list) - 1) || $p_id != $goods_movement_list[$i + 1]->product_id ) {
														echo '<tr class="total_tr">
							                      <td colspan="4">'.$this->langs->total2.'</td>
							                      <td>'.$tot_im_count.'</td>';
														foreach ($tot_ex_count as $raw) {
															echo '<td>'.$raw.'</td>';
														}
														echo '<td>'.$tot_count.'</td></tr>';

														$tot_im_count = 0;
														$tot_count = 0;
														for ($e = 0; $e < count($tot_ex_count); $e++) {
															$tot_ex_count[$e] = 0;
														}
													}

													endfor;
												?>
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
							<?=@$pagination;?>
					 </ul>
				</div>
			</div>
		</div>
	</div>

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/easyui.css">
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
<script src="/assets/demo/default/custom/crud/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>

<style media="screen">
	.absolute_right{
		position: absolute;
		float: left;
		width: calc(100% - 32px);
		display: flex;
		justify-content: flex-end;
	}
	.total_tr{
		font-weight: 600;
		background: #2c2e3e0d;
	}
</style>
<script type="text/javascript">

$(document).on('input', 'input[list="product_search"]', function(){
	$('input[name="product_id"]').val('');

	var input = $(this).val();
	$('datalist option').each(function(i) {
		if($(this).val() == input) {
			var product_id = $(this).attr('data-value');
			$('input[name="product_id"]').val(product_id);
		}
	});
});

$('.excel_click').click(function(){
	event.preventDefault();
	$.ajax({
    type:'GET',
    url:'/reports/goods_movement_excel',
    data: {category_id: $('input[name="category_id"]').val(),
					 product_id: $('input[name="product_id"]').val(),
					 date_start: $('input[name="date_start"]').val(),
					 date_end: $('input[name="date_end"]').val(),
					 tezbazar: $('#token').val()
				 	},
    dataType:'json'
  }).done(function(data){
      var $a = $("<a>");
      $a.attr("href", data.file);
      $("body").append($a);
      $a.attr("download","Goods_movement.xls");
      $a[0].click();
      $a.remove();
  });
});

</script>
