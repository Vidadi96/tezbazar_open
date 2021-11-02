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
				<?=$page_title; ?>
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
							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

								<!--begin: Search Form -->
								<div class="row">
									<div class="col-lg-3 col-md-4">
										<label for="product_search"><?=$this->langs->product_name; ?></label>
										<input list="product_search" class="form-control">
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
										<input type="hidden" name="product_id" />
                    <input type="hidden" name="product_name" />
                    <input type="hidden" name="sku" />
									</div>
									<div class="col-lg-3 col-md-4">
										<label><?=$this->langs->count; ?></label>
										<input type="number" name="count" class="form-control m-input">
									</div>
                  <div class="col-lg-3 col-md-4">
										<label><?=$this->langs->measurement; ?></label>
										<input type="text" id="measure" class="form-control m-input" disabled>
									</div>
                  <div class="col-lg-3 col-md-4">
										<label><?=$this->langs->import_price; ?></label>
										<input type="number" name="import_price" class="form-control m-input">
									</div>
                  <div class="col-lg-3 col-md-4">
										<label><?=$this->langs->export_price; ?></label>
										<input type="number" id="export_price" class="form-control m-input" disabled>
									</div>
									<div class="col-lg-3 col-md-4">
										<label><?=$this->langs->expiration_date; ?></label>
										<input type="text" name="expiration_date" class="form-control m-input date_picker" id="m_datepicker_1">
									</div>
									<div class="col-lg-3 col-md-4">
										<label>&nbsp;</label>
										<br>
										<button type="submit" id="add" class="btn btn-primary"><i class="la la-plus"></i> <?=$this->langs->add; ?></i></button>
									</div>
								</div>
                <br><br>
								<!--end: Search Form -->


            <form action="/warehouse/do_import" method="POST">
              <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
  						<div class="row">
  							<div class="col-xl-12" style="overflow: auto;">
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
                        <th><?=$this->langs->delete; ?></th>
  										</tr>
  									</thead>
  									<tbody class="add_row">
  									</tbody>
  								</table>
  							</div>
  						</div>
              <br><br>
							<hr style="height:2px;border-width:0;color:#f4f5f8;background-color:#f4f5f8">
							<br>
							<div class="row">
								<div class="col-lg-3 col-md-4">
									<label><?=$this->langs->warehouse; ?></label>
									<select class="form-control" name="warehouse" required>
										<option value=""></option>
										<?php $i = 0; foreach($warehouses as $row): ?>
											<option value="<?=$row->warehouse_id; ?>" <?=$i==0?'selected':''; ?>><?=$row->name; ?></option>
										<?php $i++; endforeach; ?>
									</select>
								</div>
								<div class="col-lg-3 col-md-4">
									<label><?=$this->langs->import_type; ?></label>
									<select class="form-control" name="import_type" required>
										<option value=""></option>
										<?php foreach($import_type as $row): ?>
											<option value="<?=$row->entry_name_id; ?>"><?=$row->entry_name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-lg-3 col-md-4">
									<label><?=$this->langs->provider; ?></label>
									<select class="form-control" name="provider" required>
										<option value=""></option>
										<?php foreach($providers as $row): ?>
											<option value="<?=$row->id; ?>"><?=$row->fullname; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-lg-3 col-md-4">
									<label><?=$this->langs->contract_number; ?></label>
									<select class="form-control" name="contract_number" required>
										<option value=""></option>
									</select>
								</div>
								<div class="col-lg-3 col-md-4">
									<label><?=$this->langs->entry_date; ?></label>
									<input type="text" name="import_date" class="form-control m-input date_picker" id="m_datepicker_1" required>
								</div>
								<div class="col-lg-3 col-md-4">
									<label>&nbsp;</label>
									<br>
									<button type="submit" id="calculate" class="btn btn-success" disabled>
										<i class="la la-plus" aria-hidden="true"></i>
										<?=$this->langs->do_import; ?>
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
<link rel="stylesheet" type="text/css" href="/css/easyui.css">
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
<script src="/assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js" type="text/javascript"></script>

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
var token = $('#token').val();

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

/*------- ADD ROW -------*/

$(document).on('click', '#add', function(){
  var product_id = '';
	var sku = '';
  var product_name = '';
  var count = '';
	var measure = '';
	var import_price = '';
	var export_price = '';
	var expiration_date = '';

  product_id = $('input[name="product_id"]').val();
  product_name = $('input[name="product_name"]').val();
  sku = $('input[name="sku"]').val();
	count = $('input[name="count"]').val();
	measure = $('input#measure').val();
	import_price = $('input[name="import_price"]').val();
	export_price = $('input#export_price').val();
	expiration_date = $('input[name="expiration_date"]').val();

  if (product_id && product_name && sku && count && import_price && expiration_date) {
    var html = `<tr>
                  <td>#` + sku + `</td>
                  <td>` + product_name + `</td>
                  <td>
                    ` + count + `
										<input type="hidden" name="product_name2[]" value="` + product_name + `">
										<input type="hidden" name="sku2[]" value="` + sku + `">
                    <input type="hidden" name="product_id2[]" value="` + product_id + `">
										<input type="hidden" name="count2[]" value="` + count + `">
										<input type="hidden" name="import_price2[]" value="` + import_price + `">
										<input type="hidden" name="expiration_date2[]" value="` + expiration_date + `">
                  </td>
									<td>` + measure + `</td>
									<td>` + import_price + ` ₼</td>
									<td>` + export_price + ` ₼</td>
									<td>` + expiration_date + `</td>
                  <td>
                    <button type="button" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete2">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>`;

    $('datalist option[data-value="'+ product_id +'"]').remove();
    $('.add_row').append(html);

    $('input[name="product_id"]').val('');
    $('input[name="product_name"]').val('');
    $('input[name="sku"]').val('');
		$('input[name="count"]').val('');
		$('input#measure').val('');
		$('input[name="import_price"]').val('');
		$('input#export_price').val('');
		$('input[name="expiration_date"]').val('');
    $('input[list="product_search"]').val('');

    if ($('.add_row tr').length > 0)
      $('#calculate').prop('disabled', false);

    toastr["success"]('Successfully added', 'Success');
  }
  else
    toastr["error"]('Fill all fields', 'Error');
});

/*------- DELETE ROW -------*/

$(document).on('click', '.delete2', function(){
	if(confirm('Are you sure?'))
	{
		var p_id = $(this).closest('tr').find('input[name="product_id2[]"]').val();
		var sku = $(this).closest('tr').find('input[name="sku2[]"]').val();
		var product_name = $(this).closest('tr').find('input[name="product_name2[]"]').val();

		$(this).closest('tr').remove();

		var html = '<option data-value="'+ p_id +'" product_name="'+ product_name +'" sku="'+ sku +'" value="'+ product_name +' - #'+ sku +'">';
		$('datalist').append(html);

		if ($('.add_row tr').length == 0)
		$('#calculate').prop('disabled', true);
		toastr["success"]('Successfully deleted', 'Success');
	}
});

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

var lang = $('#language2').text();

let searchParams = new URLSearchParams(window.location.search)
if(searchParams.has('msg'))
{
  let msg = searchParams.get('msg');

  if(msg==0)
    toastr.error(error_msg[lang], error[lang]);
}

</script>
