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
															 MAX(<span class="max_count"><?=$row->max_count;?></span>)
														</td>
                            <td><?=$row->measure; ?></td>
                            <td><?=$row->im_price; ?> ₼</td>
                            <td><?=$row->ex_price; ?> ₼</td>
                            <td>
                              <button type="button" class="edit btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only" name="<?=$row->id; ?>" <?=$row->can_change?'':'disabled'; ?>>
          											<i class="fa fa-pencil-alt"></i>
          										</button>
                            </td>
                            <td>
                              <button type="button" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete2" name="<?=$row->id; ?>" <?=$row->can_change?'':'disabled'; ?>>
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
								<form action="/warehouse/save_edit_all_export" method="post">
									<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	                <div class="row">
	  								<div class="col-lg-3 col-md-4">
	  									<label><?=$this->langs->export_type_name; ?></label>
	  									<select class="form-control" name="export_type" required>
	  										<option value=""></option>
	  										<?php foreach($export_type as $row): ?>
	  											<option <?=$products[0]->entry_name_id == $row->export_name_id?'selected':''; ?> value="<?=$row->export_name_id; ?>"><?=$row->export_name; ?></option>
	  										<?php endforeach; ?>
	  									</select>
	  								</div>
	  								<div class="col-lg-3 col-md-4">
	  									<label><?=$this->langs->buyer; ?></label>
	  									<select class="form-control" name="buyer" required>
	  										<option value=""></option>
	  										<?php foreach($buyers as $row): ?>
	  											<option <?=$products[0]->provider_id == $row->user_id?'selected':''; ?> value="<?=$row->user_id; ?>"><?=$row->company_name; ?></option>
	  										<?php endforeach; ?>
	  									</select>
	  								</div>
	  								<div class="col-lg-3 col-md-4">
	  									<label><?=$this->langs->contract_number; ?></label>
	  									<select class="form-control" name="contract_number" required>
	  										<option value=""></option>
	                      <?php foreach ($export_contracts as $row): ?>
	                        <option <?=$products[0]->contract_number == $row->id?'selected':''; ?> value="<?=$row->id; ?>"><?=$row->contract_number; ?></option>
	                      <?php endforeach; ?>
	  									</select>
	  								</div>
	  								<div class="col-lg-3 col-md-4">
	  									<label><?=$this->langs->date; ?></label>
	  									<input type="text" name="export_date" class="form-control m-input date_time_picker" value="<?=$products[0]->date_time; ?>" required>
	  								</div>
										<input type="hidden" name="order_number" value="<?=$products[0]->check_number; ?>">
	  								<div class="col-lg-3 col-md-4">
	  									<label>&nbsp;</label>
	  									<br>
	  									<button type="submit" class="btn btn-success" id="save_export" <?=$products[0]->can_change?'':'disabled'; ?>>
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

$(document).on('change', 'select[name="buyer"]', function(){
  var buyer_id = $(this).val();
  var buyer_select = $(this);
  $(this).closest('.row').find('select[name="contract_number"]').prop('disabled', true);
  $.ajax({
    url: '/warehouse/get_export_contracts',
    type: 'POST',
    data: {buyer_id: buyer_id, tezbazar: token},
    success: function(data){
      var ic = $.parseJSON(data);
      var html = '<option value=""></option>';
      for (var i = 0; i < ic.length; i++)
        html = html + '<option value="' + ic[i].id + '">' + ic[i].contract_number + '</option>';

      buyer_select.closest('.row').find('select[name="contract_number"]').html(html);
      buyer_select.closest('.row').find('select[name="contract_number"]').prop('disabled', false);
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

var max_count_text = [];
max_count_text['az'] = 'Maksimum verilmiş saydan aşağı və ya bərabər say verin';
max_count_text['ru'] = 'Введите число равное или меньшее заданного максимума';
max_count_text['en'] = 'Enter less or equal count than maximum count';
max_count_text['tr'] = 'Maksimum kayd edilmiş saydan daha kiçik və ya aynı say veriniz';

var less_than_0 = [];
less_than_0['az'] = '0-dan aşağı rəqəm yazmaq olmaz';
less_than_0['ru'] = 'Нельзя вводить отрицательное число';
less_than_0['en'] = 'You cannot enter a negative number';
less_than_0['tr'] = 'Negatif bir sayı giremezsiniz';

var add_number = [];
add_number['az'] = 'Rəqəm əlavə edin';
add_number['ru'] = 'Введите число';
add_number['en'] = 'Add a number';
add_number['tr'] = 'Say ekleyin';

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
    $(this).closest('tr').find('.edit_open').show();
    $(this).closest('tr').find('.edit_close').hide();
    $(this).closest('td').html('<button class="save btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only" name="'+ $(this).attr('name') +'"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>');
  });

  $(document).on('click', '.save', function(){
    var thiss = $(this);
    var closest = $(this).closest('tr');
		var max_count = parseInt(closest.find('.max_count').text());
		var count = closest.find('input[name="count"]').val();
		if (count > max_count)
			toastr.info(max_count_text[lang], 'Info');
		else if (count < 0)
			toastr.info(less_than_0[lang], 'Info')
		else if (count > 0) {
			$.ajax({
				url: '/warehouse/save_edit_export',
				type: 'POST',
				data: { tezbazar: token,
					id: thiss.attr('name'),
					count: count
				},
				success: function(data){
					var res = $.parseJSON(data);
					token = res.tezbazar;
					if (res.status == 'success')
					{
						closest.find('span[name="count_span"]').text(closest.find('input[name="count"]').val());

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
		} else {
			toastr.info(add_number[lang], 'Info')
		}
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
			var delete_length = $('.delete2').length;
			if(delete_length > 1)
			{
				var thiss = $(this);
				var id = $(this).attr('name');
				$.ajax({
					url: '/warehouse/delete_export_id',
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
		}
	});

/*------ EDIT EXPORT ------*/

var error_all_fields = [];
error_all_fields['az'] = 'Bütün xanaları doldurun';
error_all_fields['tr'] = 'Tüm haneleri doldurunuz';
error_all_fields['en'] = 'Fill all fields';
error_all_fields['ru'] = 'Заполните все поля';

$('#save_export').click(function(){
	event.preventDefault();
	var export_type = $('select[name="export_type"]').val();
	var buyer = $('select[name="buyer"]').val();
	var contract_number = $('select[name="contract_number"]').val();
	var export_date = $('input[name="export_date"]').val();
	var order_number = $('input[name="order_number"]').val();

	if (export_type && buyer && contract_number && export_date)
	{
		$.ajax({
			url: '/warehouse/save_edit_all_export',
			type: 'POST',
			data: { tezbazar: token,
							export_type: export_type,
							buyer: buyer,
							contract_number: contract_number,
							export_date: export_date,
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
