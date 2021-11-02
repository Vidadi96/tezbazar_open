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
                <form action="/warehouse/export_list" method="GET">
                  <!--begin: Search Form -->
  								<div class="row">
  									<div class="col-lg-3 col-md-4">
  										<label><?=$this->langs->check_number; ?></label>
  										<input type="number" class="form-control" name="check_number" value="<?=$check_number?$check_number:''; ?>">
  									</div>
										<div class="col-lg-3 col-md-4">
											<label for="product_search"><?=$this->langs->product_name; ?></label>
											<input list="product_search" class="form-control" value="<?=$product_name?$product_name." - #".$sku:''; ?>">
											<datalist id="product_search">
												<?php foreach ($products as $row): ?>
													<option
	                          data-value="<?=$row->p_id; ?>"
	                          product_name="<?=$row->product_name; ?>"
	                          sku="<?=$row->sku; ?>"
	                          value="<?=$row->product_name." - #".$row->sku; ?>"
	                        >
												<?php endforeach; ?>
											</datalist>
											<input type="hidden" name="product_id" value="<?=$product_id; ?>" />
	                    <input type="hidden" name="product_name" value="<?=$product_name; ?>" />
	                    <input type="hidden" name="sku" value="<?=$sku; ?>"/>
										</div>
  									<div class="col-lg-3 col-md-4">
  										<label><?=$this->langs->warehouse; ?></label>
                      <select class="form-control" name="warehouse">
    										<option value=""></option>
    										<?php foreach($warehouses as $row): ?>
    											<option <?=$warehouse_id == $row->warehouse_id?'selected':''; ?> value="<?=$row->warehouse_id; ?>"><?=$row->name; ?></option>
    										<?php endforeach; ?>
    									</select>
  									</div>
                    <div class="col-lg-3 col-md-4">
                      <label><?=$this->langs->export_type_name; ?></label>
    									<select class="form-control" name="export_type">
    										<option value=""></option>
    										<?php foreach($export_type as $row): ?>
    											<option <?=$export_type2 == $row->export_name_id?'selected':''; ?> value="<?=$row->export_name_id; ?>"><?=$row->export_name; ?></option>
    										<?php endforeach; ?>
    									</select>
  									</div>
                    <div class="col-lg-3 col-md-4">
                      <label><?=$this->langs->buyer; ?></label>
    									<select class="form-control" name="buyer">
    										<option value=""></option>
    										<?php foreach($buyers as $row): ?>
    											<option <?=$buyer == $row->user_id?'selected':''; ?> value="<?=$row->user_id; ?>"><?=$row->company_name; ?></option>
    										<?php endforeach; ?>
    									</select>
  									</div>
                    <div class="col-lg-3 col-md-4">
                      <label><?=$this->langs->contract_number; ?></label>
    									<select class="form-control" name="contract_number">
    										<option value=""></option>
												<?php if(isset($contract_numbers)):
													foreach ($contract_numbers as $row): ?>
														<option <?=$contract_number == $row->id?'selected':''; ?> value="<?=$row->id; ?>"><?=$row->contract_number; ?></option>
													<?php endforeach;
												endif; ?>
                      </select>
  									</div>
  									<div class="col-lg-3 col-md-4">
                      <label><?=$this->langs->date; ?></label>
    									<input type="text" name="export_date" class="form-control m-input date_time_picker" value="<?=$export_date; ?>">
  									</div>
  									<div class="col-lg-3 col-md-4">
  										<label>&nbsp;</label>
  										<br>
  										<button type="submit" id="show" class="btn btn-primary"><i class="la la-plus"></i> <?=$this->langs->display; ?></i></button>
  									</div>
  								</div>
                  <br><br>
                </form>
								<!--end: Search Form -->

    						<div class="row">
    							<div class="col-xl-12">
                    <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    								<table class="table table-bordered m-table">
    									<thead>
    										<tr>
                          <th><?=$this->langs->check_number; ?></th>
    											<th><?=$this->langs->warehouse; ?></th>
                          <th><?=$this->langs->export_type_name; ?></th>
  												<th><?=$this->langs->buyer; ?></th>
                          <th><?=$this->langs->contract_number; ?></th>
                          <th><?=$this->langs->date; ?></th>
  												<th><?=$this->langs->edit2; ?></th>
                          <th><?=$this->langs->delete; ?></th>
    										</tr>
    									</thead>
    									<tbody>
                        <?php foreach ($export_list as $row): ?>
                          <tr>
                            <td>#<?=$row->order_number; ?></td>
                            <td><?=$row->warehouse; ?></td>
                            <td><?=$row->export_name; ?></td>
                            <td><?=$row->provider; ?></td>
                            <td><?=$row->contract_number; ?></td>
                            <td><?=$row->date_time; ?></td>
                            <td>
                              <a href="/warehouse/edit_export/<?=$row->order_number; ?>" target="_blank" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only">
          											<i class="fa fa-pencil-alt"></i>
          										</a>
                            </td>
                            <td>
                              <button type="button" name="<?=$row->order_number; ?>" can_delete="<?=$row->can_delete; ?>" <?=$row->can_delete?'':'disabled'; ?>class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete2">
          											<i class="fa fa-trash"></i>
          										</button>
                            </td>
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

<script type="text/javascript">

var token = $('#token').val();
var lang = $('#language2').text();

/*------- DATA LIST -------*/

$(document).on('input', 'input[list="product_search"]', function(){
	$('input[name="product_id"]').val('');
  $('input[name="product_name"]').val('');
  $('input[name="sku"]').val('');

	var input = $(this).val();
	$('datalist option').each(function(i) {
		if($(this).val() == input) {
			var product_id = $(this).attr('data-value');
      var product_name = $(this).attr('product_name');
      var sku = $(this).attr('sku');

      $.ajax({
        url: '/warehouse/get_measure_price',
        type: 'POST',
        data: {product_id: product_id, tezbazar: token},
        success: function(data){
          var mp = $.parseJSON(data);
          $('#measure').val(mp[0].measure);
					$('#export_price').val(mp[0].price);
        }
      });

			$('input[name="product_id"]').val(product_id);
      $('input[name="product_name"]').val(product_name);
      $('input[name="sku"]').val(sku);
		}
	});
});

/*------ BRING IMPORT CONTRACTS ------*/

$(document).on('change', 'select[name="buyer"]', function(){
  var buyer_id = $(this).val();
  $('select[name="contract_number"]').prop('disabled', true);
  $.ajax({
    url: '/warehouse/get_export_contracts',
    type: 'POST',
    data: {buyer_id: buyer_id, tezbazar: token},
    success: function(data){
      var ic = $.parseJSON(data);
      var html = '<option value=""></option>';
      for (var i = 0; i < ic.length; i++)
        html = html + '<option value="' + ic[i].id + '">' + ic[i].contract_number + '</option>';

      $('select[name="contract_number"]').html(html);
      $('select[name="contract_number"]').prop('disabled', false);
    }
  });
});


/*----- GET RESPONSE -----*/

var successfully_added = [];
successfully_added['az'] = 'Uğurla əlavə edildi';
successfully_added['tr'] = 'Başarılı eklendi';
successfully_added['en'] = 'Successfully added';
successfully_added['ru'] = 'Успешно добавлено';

var success = [];
success['az'] = 'Uğur';
success['tr'] = 'Başarılı';
success['en'] = 'Success';
success['ru'] = 'Успешно';

var error = [];
error['az'] = 'Xəta';
error['ru'] = 'Ошибка';
error['en'] = 'Error';
error['tr'] = 'Hata';

var error_msg = [];
error_msg['az'] = 'Xəta baş verdi';
error_msg['ru'] = 'Произошла ошибка';
error_msg['en'] = 'An error has occured';
error_msg['tr'] = 'Hata oluştu';

let searchParams = new URLSearchParams(window.location.search)
if(searchParams.has('msg'))
{
  let msg = searchParams.get('msg');

  if(msg==1)
    toastr.success(successfully_added[lang], success[lang]);
  else
    toastr.error(error_msg[lang], error[lang]);
}

/*------ DELETE ------*/

var delete_text = [];
delete_text['az'] = 'Silmək istədiyinizə əminsiniz?';
delete_text['tr'] = 'Silmek istediyinize eminsinizmi?';
delete_text['en'] = 'Are you sure to delete?';
delete_text['ru'] = 'Вы уверены, что хотите удалить?';

var cant_delete = [];
cant_delete['az'] = 'Keçən ay ərzində edilən mədaxilləri silə bilməzsiniz';
cant_delete['tr'] = 'Geçen ay içinde eklenen ithalatlar silinemez';
cant_delete['en'] = 'You can not delete imports, which was added last month';
cant_delete['ru'] = 'Вы не можете удалить импорты добавленные в прошлом месяце';

$('.delete2').click(function(){
	if (confirm(delete_text[lang]))
	{
		var thiss = $(this);
		var order_number = $(this).attr('name');
		var can_delete = $(this).attr('can_delete');
		if (can_delete)
		{
			$.ajax({
				url: '/warehouse/delete_export',
				type: 'POST',
				data: {tezbazar: token, order_number: order_number, can_delete: can_delete},
				success: function(data){
					var res = $.parseJSON(data);
					token = res.tezbazar;
					if(res.status == 'success')
					{
						thiss.closest('tr').remove();
						toastr.success(res.msg, success[lang]);
					}
					else
						toastr.error(res.msg, error[lang]);
				}
			});
		}
		else
			toastr.error(cant_delete[lang], error[lang]);
	}
});

</script>
