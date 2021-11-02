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
									<form action="/reports/import_excel" method="POST">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
										<input type="hidden" name="category_id" value="<?=$category_id; ?>">
										<input type="hidden" name="product_id" value="<?=$product_id; ?>">
										<input type="hidden" name="date_start" value="<?=$date_start; ?>">
										<input type="hidden" name="date_end" value="<?=$date_end; ?>">
										<input type="hidden" name="provider_id" value="<?=$provider_id; ?>">
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
								<form action="/reports/import_report" method="POST">
									<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									<div class="form-group m-form__group row">
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
                    <div class="col-lg-3">
											<label><?=$this->langs->provider; ?></label>
                      <select class="form-control" name="salesman">
												<option value=""></option>
												<?php foreach($salesmen as $row): ?>
                          <option <?=$row->id==$provider_id?'selected':''; ?> value="<?=$row->id; ?>"><?=$row->fullname; ?></option>
												<?php endforeach; ?>
                      </select>
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
								<table class="table table-bordered m-table">
									<thead>
										<tr>
											<th><?=$this->langs->code_of_product; ?></th>
											<th><?=$this->langs->product_name; ?></th>
											<th><?=$this->langs->date; ?></th>
											<th><?=$this->langs->provider; ?></th>
											<th><?=$this->langs->measurement; ?></th>
											<th><?=$this->langs->count; ?></th>
											<th><?=$this->langs->price; ?></th>
											<th><?=$this->langs->summary; ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($import_list as $row): ?>
	                    <tr>
												<?php if($row->row_count): ?>
		                      <td rowspan="<?=$row->row_count; ?>"><?='#'.$row->sku; ?></td>
		                      <td rowspan="<?=$row->row_count; ?>"><?=$row->p_name; ?></td>
												<?php endif; ?>
												<td><?=$row->date_time; ?></td>
	                      <td><?=$row->provider; ?></td>
	                      <td><?=$row->measure; ?></td>
	                      <td><?=$row->count; ?></td>
												<td><?=$row->im_price; ?> ₼</td>
												<td><?=$row->count*$row->im_price; ?> ₼</td>
	                    </tr>
										<?php endforeach; ?>
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
    url:'/reports/import_excel',
    data: {category_id: $('input[name="category_id"]').val(),
					 product_id: $('input[name="product_id"]').val(),
					 date_start: $('input[name="date_start"]').val(),
					 date_end: $('input[name="date_end"]').val(),
					 provider_id: $('input[name="provider_id"]').val(),
					 tezbazar: $('#token').val()
				 	},
    dataType:'json'
  }).done(function(data){
      var $a = $("<a>");
      $a.attr("href", data.file);
      $("body").append($a);
      $a.attr("download","Import.xls");
      $a[0].click();
      $a.remove();
  });
});

</script>
