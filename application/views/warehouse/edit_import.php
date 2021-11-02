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
    						<div class="row">
    							<div class="col-xl-12">
    								<table class="table table-bordered m-table">
    									<thead>
    										<tr>
                          <th><?=$this->langs->code_of_product; ?></th>
    											<th><?=$this->langs->product_name; ?></th>
                          <th><?=$this->langs->count; ?></th>
  												<th><?=$this->langs->measurement; ?></th>
                          <th><?=$this->langs->import_price; ?></th>
                          <th><?=$this->langs->export_price; ?></th>
  												<th><?=$this->langs->expiration_date; ?></th>
                          <th><?=$this->langs->edit2; ?></th>
                          <th><?=$this->langs->delete; ?></th>
    										</tr>
    									</thead>
    									<tbody>
                        <?php foreach ($products as $row): ?>
                          <tr>
                            <td><?=$row->sku; ?></td>
                            <td><?=$row->product_name; ?></td>
                            <td>
															<span class="edit_close" name="count_span"><?=$row->count; ?></span>
															<input type="number" class="form-control edit_open" name="count" value="<?=$row->count; ?>">
														</td>
                            <td><?=$row->measure; ?></td>
                            <td>
															<span class="edit_close" name="im_price_span"><?=$row->im_price; ?> ₼</span>
															<input type="number" class="form-control edit_open" name="im_price" value="<?=$row->im_price; ?>">
														</td>
                            <td><?=$row->ex_price; ?> ₼</td>
                            <td>
															<span class="edit_close" name="expiration_date_span"><?=$row->expiration_date; ?></span>
															<input type="text" class="form-control edit_open date_time_picker" name="expiration_date" value="<?=$row->expiration_date; ?>">
														</td>
                            <td>
                              <button type="button" class="edit btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only" name="<?=$row->id; ?>" can_change="<?=$row->can_change; ?>" <?=$row->can_change?'':'disabled'; ?>>
          											<i class="fa fa-pencil-alt"></i>
          										</button>
                            </td>
                            <td>
                              <button type="button" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete2" name="<?=$row->id; ?>" can_change="<?=$row->can_change; ?>" <?=$row->can_change?'':'disabled'; ?>>
          											<i class="fa fa-trash"></i>
          										</button>
                            </td>
                          </tr>
                        <?php endforeach; ?>
    									</tbody>
    								</table>
    							</div>
    						</div>
                <br><br>
                <hr style="height:2px;border-width:0;color:#f4f5f8;background-color:#f4f5f8">
                <br>
								<form action="/warehouse/save_edit_all_import" method="post">
									<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	                <div class="row">
	  								<div class="col-lg-3 col-md-4">
	  									<label><?=$this->langs->warehouse; ?></label>
	  									<select class="form-control" name="warehouse" required>
	  										<option value=""></option>
	  										<?php foreach($warehouses as $row): ?>
	  											<option <?=$products[0]->warehouse_id == $row->warehouse_id?'selected':''; ?> value="<?=$row->warehouse_id; ?>"><?=$row->name; ?></option>
	  										<?php endforeach; ?>
	  									</select>
	  								</div>
	  								<div class="col-lg-3 col-md-4">
	  									<label><?=$this->langs->import_type; ?></label>
	  									<select class="form-control" name="import_type" required>
	  										<option value=""></option>
	  										<?php foreach($import_type as $row): ?>
	  											<option <?=$products[0]->entry_name_id == $row->entry_name_id?'selected':''; ?> value="<?=$row->entry_name_id; ?>"><?=$row->entry_name; ?></option>
	  										<?php endforeach; ?>
	  									</select>
	  								</div>
	  								<div class="col-lg-3 col-md-4">
	  									<label><?=$this->langs->provider; ?></label>
	  									<select class="form-control" name="provider" required>
	  										<option value=""></option>
	  										<?php foreach($providers as $row): ?>
	  											<option <?=$products[0]->provider_id == $row->id?'selected':''; ?> value="<?=$row->id; ?>"><?=$row->fullname; ?></option>
	  										<?php endforeach; ?>
	  									</select>
	  								</div>
	  								<div class="col-lg-3 col-md-4">
	  									<label><?=$this->langs->contract_number; ?></label>
	  									<select class="form-control" name="contract_number" required>
	  										<option value=""></option>
	                      <?php foreach ($import_contracts as $row): ?>
	                        <option <?=$products[0]->contract_number == $row->id?'selected':''; ?> value="<?=$row->id; ?>"><?=$row->contract_number; ?></option>
	                      <?php endforeach; ?>
	  									</select>
	  								</div>
	  								<div class="col-lg-3 col-md-4">
	  									<label><?=$this->langs->entry_date; ?></label>
	  									<input type="text" name="import_date" class="form-control m-input date_time_picker" value="<?=$products[0]->date_time; ?>" required>
	  								</div>
										<input type="hidden" name="order_number" value="<?=$products[0]->check_number; ?>">
	  								<div class="col-lg-3 col-md-4">
	  									<label>&nbsp;</label>
	  									<br>
	  									<button type="submit" class="btn btn-success" id="save_import" <?=$products[0]->can_change?'':'disabled'; ?>>
	  										<i class="fa fa-save" aria-hidden="true"></i>
	  										<?=$this->langs->save2; ?>
	  									</button>
	  								</div>
	  							</div>
								</form>
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
<script src="/assets/demo/default/custom/crud/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/easyui.css">
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript" src="/js/jquery.easyui.min.js"></script>

<style media="screen">

.edit_open{
	display: none;
}

</style>

<script type="text/javascript">

var lang = $('#language2').text();
var token = $('#token').val();

/*------ BRING IMPORT CONTRACTS ------*/

$(document).on('change', 'select[name="provider"]', function(){
  var provider_id = $(this).val();
  var salesman_select = $(this);
  $(this).closest('.row').find('select[name="contract_number"]').prop('disabled', true);
  $.ajax({
    url: '/warehouse/get_import_contracts',
    type: 'POST',
    data: {provider_id: provider_id, tezbazar: token},
    success: function(data){
      var ic = $.parseJSON(data);
      var html = '<option value=""></option>';
      for (var i = 0; i < ic.length; i++)
        html = html + '<option value="' + ic[i].id + '">' + ic[i].contract_number + '</option>';

      salesman_select.closest('.row').find('select[name="contract_number"]').html(html);
      salesman_select.closest('.row').find('select[name="contract_number"]').prop('disabled', false);
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

var cannot_change = [];
cannot_change['az'] = 'Bu məlumatı dəyişə bilməzsiniz';
cannot_change['ru'] = 'Вы не можете поменять эту информацию';
cannot_change['en'] = 'You cannot change this information';
cannot_change['tr'] = 'Bu alanı değiştire bilmezisiniz';

let searchParams = new URLSearchParams(window.location.search)
if(searchParams.has('msg'))
{
  let msg = searchParams.get('msg');

  if(msg==1)
    toastr.success(successfully_added[lang], success[lang]);
  else
    toastr.error(error_msg[lang], error[lang]);
}

/*----- EDIT CUSTOMER INFORMATION -----*/

  $(document).on('click', '.edit', function(){
		var can_change = $(this).attr('can_change');
		if (can_change > 0) {
			$(this).closest('tr').find('.edit_open').show();
			$(this).closest('tr').find('.edit_close').hide();
			$(this).closest('td').html('<button class="save btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only" name="'+ $(this).attr('name') +'"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>');
		} else {
			toastr.info(cannot_change[lang], 'Info');
		}
  });

  $(document).on('click', '.save', function(){
    var thiss = $(this);
    var closest = $(this).closest('tr');
    $.ajax({
      url: '/warehouse/save_edit_import',
      type: 'POST',
      data: { tezbazar: token,
              id: thiss.attr('name'),
              im_price: closest.find('input[name="im_price"]').val(),
							expiration_date: closest.find('input[name="expiration_date"]').val(),
							count: closest.find('input[name="count"]').val()
      },
      success: function(data){
        var res = $.parseJSON(data);
        token = res.tezbazar;
        if (res.status == 'success')
        {
          closest.find('span[name="im_price_span"]').text(closest.find('input[name="im_price"]').val());
					closest.find('span[name="count_span"]').text(closest.find('input[name="count"]').val());
					closest.find('span[name="expiration_date_span"]').text(closest.find('input[name="expiration_date"]').val());

          closest.find('.edit_open').hide();
          closest.find('.edit_close').show();
          thiss.closest('td').html('<button class="edit btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only" name="'+ thiss.attr('name') +'"><i class="fa fa-pencil-alt"></i></button>');

          toastr.success(res.msg, success[lang]);
        } else
          toastr.error(res.msg, error[lang]);
      },
      error: function(){
        toastr.error(error_msg[lang], error[lang]);
      }
    });
  });

	/*------ DELETE ------*/

	var delete_text = [];
	delete_text['az'] = 'Silmək istədiyinizə əminsiniz?';
	delete_text['tr'] = 'Silmek istediyinize eminsinizmi?';
	delete_text['en'] = 'Are you sure to delete?';
	delete_text['ru'] = 'Вы уверены, что хотите удалить?';

	var delete_len = [];
	delete_len['az'] = 'Sonuncunu silmək üçün bütün mədaxili silin';
	delete_len['tr'] = 'Sonuncunu silmek için ithalatı siliniz';
	delete_len['en'] = 'Delete import to delete the latest one';
	delete_len['ru'] = 'Удалите весь импорт, чтобы удалить последнюю';

	$('.delete2').click(function(){
		if (confirm(delete_text[lang]))
		{
			var can_change = $(this).attr('can_change');
			if (can_change > 0) {
				var delete_length = $('.delete2').length;
				if(delete_length > 1)
				{
					var thiss = $(this);
					var id = $(this).attr('name');
					$.ajax({
						url: '/warehouse/delete_import_id',
						type: 'POST',
						data: {tezbazar: token, id: id},
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
					toastr.error(delete_len[lang], error[lang]);
			} else {
				toastr.info(cannot_change[lang], 'Info');
			}
		}
	});

/*------ EDIT IMPORT ------*/

var error_all_fields = [];
error_all_fields['az'] = 'Bütün xanaları doldurun';
error_all_fields['tr'] = 'Tüm haneleri doldurunuz';
error_all_fields['en'] = 'Fill all fields';
error_all_fields['ru'] = 'Заполните все поля';

$('#save_import').click(function(){
	event.preventDefault();
	var warehouse = $('select[name="warehouse"]').val();
	var import_type = $('select[name="import_type"]').val();
	var provider = $('select[name="provider"]').val();
	var contract_number = $('select[name="contract_number"]').val();
	var import_date = $('input[name="import_date"]').val();
	var order_number = $('input[name="order_number"]').val();

	if (warehouse && import_type && provider && contract_number && import_date)
	{
		$.ajax({
			url: '/warehouse/save_edit_all_import',
			type: 'POST',
			data: { tezbazar: token,
						  warehouse: warehouse,
							import_type: import_type,
							provider: provider,
							contract_number: contract_number,
							import_date: import_date,
							order_number: order_number
					 	},
			success: function(data){
				var res = $.parseJSON(data);
				token = res.tezbazar;
				if(res.status == 'success')
					toastr.success(res.msg, success[lang]);
				else
					toastr.error(res.msg, error[lang]);
			},
			error: function(){
				toastr.error(error_msg[lang], error[lang]);
			}
		});
	}
	else
		toastr.error(error_all_fields[lang], error[lang]);
});

</script>
