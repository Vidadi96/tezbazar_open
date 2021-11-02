<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="/slides/get_view_main/" class="m-nav__link m-nav__link--icon">
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
				<!--begin::Portlet-->
				<div class="m-portlet m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									<?=$this->langs->new_export; ?>
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

                  <div class="form-group m-form__group row">

                    <div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label for="product_search"><?=$this->langs->product_name; ?></label>
												<input list="product_search" class="form-control">
												<datalist id="product_search">
													<?php foreach ($products as $row): ?>
														<option
															data-value="<?=$row->p_id; ?>"
															product_name="<?=$row->product_name; ?>"
		                          sku="<?=$row->sku; ?>"
															value="<?=$row->product_name." - #".$row->sku; ?>">
													<?php endforeach; ?>
												</datalist>
												<input type="hidden" name="product_id">
		                    <input type="hidden" name="product_name" />
		                    <input type="hidden" name="sku" />
                      </div>
                    </div>

										<div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label for="im_price"><?=$this->langs->import_price; ?></label>
												<select name="im_ex_id[]" id="selectpicker" class="form-control" multiple data-live-search="false" disabled>
												  <option value=""></option>
												</select>
                        <!-- <select id="im_price" name="im_price" class="form-control">
													<option value=""></option>
												</select> -->
												<input type="hidden" name="im_price2">
                      </div>
                    </div>

                    <div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label><?=$this->langs->export_price; ?></label>
												<input type="text" class="form-control" name="ex_price"/>
                      </div>
                    </div>

                    <div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label for="count"><?=$this->langs->count; ?></label>
      									<input type="number" min="0" max="0" id="count" name="count" class="form-control m-input" placeholder=""/>
												<input type="hidden" name="max_count"/>
                      </div>
                    </div>

										<div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label><?=$this->langs->measurement; ?></label>
												<input type="text" name="measure_disabled" class="form-control" disabled />
												<input type="hidden" name="measure" />
                      </div>
                    </div>

										<div class="col-lg-3 col-md-4">
											<label>&nbsp;</label>
											<br>
											<button type="submit" id="add" class="btn btn-primary"><i class="la la-plus"></i> <?=$this->langs->add; ?></i></button>
										</div>
                  </div>

									<br><br>
									<form action="/warehouse/do_export" method="POST">
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

											<div class="col-md-4 col-lg-3">
                        <label for="export_name"><?=$this->langs->export_type_name; ?></label>
												<select id="export_name" name="export_name" class="form-control" required>
													<option buyer_id="-1" contract_number="-1" value=""></option>
													<?php foreach ($export_name as $row): ?>
														<option buyer_id="<?=$row->buyer_id; ?>" contract_number="<?=$row->contract_number; ?>" value="<?=$row->export_name_id; ?>"><?=$row->export_name; ?></option>
													<?php endforeach; ?>>
												</select>
	                    </div>

											<div class="col-md-4 col-lg-3">
	                      <div class="form-group">
	                        <label for="buyer"><?=$this->langs->buyer; ?></label>
													<select id="buyer" name="buyer" class="form-control" required>
														<option value="0"></option>
														<?php foreach ($buyers as $row): ?>
															<option value="<?=$row->user_id; ?>"><?=$row->company_name; ?></option>
														<?php endforeach; ?>
													</select>
	                      </div>
	                    </div>

	                    <div class="col-md-4 col-lg-3">
	                      <div class="form-group">
	                        <label for="contract_number"><?=$this->langs->contract_number; ?></label>
													<select id="contract_number" name="contract_number" class="form-control">
														<option value="0"></option>
													</select>
	                      </div>
	                    </div>

											<div class="col-md-4 col-lg-3">
	                      <div class="form-group">
	                        <label for="date_time"><?=$this->langs->date2; ?></label>
	      									<input id="m_datepicker_1" name="date_time" class="form-control m-input date_picker" placeholder="" required/>
	                      </div>
	                    </div>

											<div class="col-lg-3 col-md-4">
												<label>&nbsp;</label>
												<br>
												<button type="submit" id="calculate" class="btn btn-success" disabled>
													<i class="la la-plus" aria-hidden="true"></i>
													<?=$this->langs->do_export; ?>
												</button>
											</div>

										</div>
			            </form>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
    <div class="row">
      <div class="col-lg-12">
        <div class="text-center">
           <ul class="pagination pagination-lg text-center" style="display: inline-flex;">
              <?=@$pagination; ?>
           </ul>
        </div>
      </div>
    </div>
	</div>

<!-- <script src="/assets/demo/default/custom/crud/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script> -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="/assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js" type="text/javascript"></script>

<script type="text/javascript">

$('#selectpicker').selectpicker();

var token = $('#token').val();
var im_price;

$(document).on('input', 'input[list="product_search"]', function(){
	$('input[name="product_id"]').val('');
	$('input[name="product_name"]').val('');
  $('input[name="sku"]').val('');
  $('input[name="ex_price"]').val('');
  $('#count').attr('max', 0);
  $('#count').val('');
	$("#selectpicker option").remove();
	$("#selectpicker").attr('disabled',true);
	$("#selectpicker").selectpicker("refresh");
	$('input[name="measure"]').val('');
	$('input[name="measure_disabled"]').val('');
	$('input[name="im_ex_id"]').val('');
	$('input[name="im_price2"]').val('');
	$('input[name="max_count"]').val('');
  if($('label[for="count"]').text().indexOf('(') > -1)
    $('label[for="count"]').text($('label[for="count"]').text().substr(0, $('label[for="count"]').text().indexOf('(')));

	var input = $(this).val();
	$('datalist option').each(function(i){
		if($(this).val() == input)
		{
			var product_id = $(this).attr('data-value');
			var product_name = $(this).attr('product_name');
      var sku = $(this).attr('sku');
			$('input[name="product_id"]').val(product_id);
			$('input[name="product_name"]').val(product_name);
      $('input[name="sku"]').val(sku);

			$.ajax({
			  url: '/warehouse/get_import_prices',
			  type: 'POST',
			  data: {product_id: product_id, tezbazar: token},
			  success: function(data){
			    im_price = $.parseJSON(data);
			    var html = '<option value="0"></option>';
			    for (var i = 0; i < im_price.length; i++)
					{
						if(im_price[i].count == 0)
							$('#selectpicker').append('<option disabled im_price="'+ im_price[i].im_price +'" value="' + im_price[i].id + '">' + im_price[i].im_price + ' azn : Qalıq ' + im_price[i].count + '</option>');
						else
							$('#selectpicker').append('<option im_price="'+ im_price[i].im_price +'" value="' + im_price[i].id + '">' + im_price[i].im_price + ' azn : Qalıq ' + im_price[i].count + '</option>');
					}

					$("#selectpicker").attr('disabled', false);
					$("#selectpicker").selectpicker("refresh");
			  }
			});
		}
	});
});

var im_price_id = [];
var im_price2 = '';

$(document).on('changed.bs.select', '#selectpicker', function(){
  im_price_id = $(this).val();
  $('#count').val('');
	im_price2 = '';
	$(this).find('option:selected').each(function(){
		im_price2 = im_price2 + $(this).attr('im_price') + ', ';
	});
	im_price2 = im_price2.substr(0, im_price2.length - 2);

  if (im_price_id.length > 0)
  {
		var countt = 0;
    for (var i = 0; i < im_price.length; i++) {
			for (var j = 0; j < im_price_id.length; j++) {
	      if(im_price_id[j] == im_price[i].id)
	        countt = countt + parseFloat(im_price[i].count);
			}
    }
		if($('label[for="count"]').text().indexOf('(') > -1)
			$('label[for="count"]').text($('label[for="count"]').text().substr(0, $('label[for="count"]').text().indexOf('(')));
		$('label[for="count"]').text($('label[for="count"]').text() + ' (MAX ' + countt + ')');
		$('#count').attr('max', countt);
		$('input[name="ex_price"]').val(im_price[0].ex_price);
		$('input[name="measure_disabled"]').val(im_price[0].title);
		$('input[name="measure"]').val(im_price[0].measure_id);
		$('input[name="im_price2"]').val(im_price[0].im_price);
		$('input[name="max_count"]').val(im_price[0].count);
  }
  else
  {
    if($('label[for="count"]').text().indexOf('(') > -1)
      $('label[for="count"]').text($('label[for="count"]').text().substr(0, $('label[for="count"]').text().indexOf('(')));
    $('#count').attr('max', 0);
		$('input[name="ex_price"]').val('');
		$('input[name="measure"]').val('');
		$('input[name="measure_disabled"]').val('');
		$('input[name="im_price2"]').val('');
		$('input[name="max_count"]').val('');
  }
});


$(document).on('change', 'select[name="export_name"]', function(){
	var buyer_id = $(this).find('option:selected').attr('buyer_id');
	var contract_number = $(this).find('option:selected').attr('contract_number');

	if(buyer_id == 0)
		$('select[name="buyer"]').prop('disabled', true);
	else
		$('select[name="buyer"]').prop('disabled', false);

	if(contract_number == 0)
		$('select[name="contract_number"]').prop('disabled', true);
	else
		$('select[name="contract_number"]').prop('disabled', false);
});

$(document).on('change', 'select[name="buyer"]', function(){
  var buyer_id = $(this).val();
  $('select[name="contract_number"]').prop('disabled', true);
  $.ajax({
    url: '/warehouse/get_export_contracts',
    type: 'POST',
    data: {buyer_id: buyer_id, tezbazar: token},
    success: function(data){
      var cn = $.parseJSON(data);
      var html = '<option value="0"></option>';
      for (var i = 0; i < cn.length; i++)
        html = html + '<option value="' + cn[i].id + '">' + cn[i].contract_number + '</option>';

      $('select[name="contract_number"]').html(html);
      $('select[name="contract_number"]').prop('disabled', false);
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
	var export_price = '';

  product_id = $('input[name="product_id"]').val();
  product_name = $('input[name="product_name"]').val();
  sku = $('input[name="sku"]').val();
	count = $('input[name="count"]').val();
	measure = $('input[name="measure_disabled"]').val();
	export_price = $('input[name="ex_price"]').val();

  if (product_id && product_name && sku && count && im_price2) {
    var html = `<tr>
                  <td>#` + sku + `</td>
                  <td>` + product_name + `</td>
                  <td>
                    ` + count + `
										<input type="hidden" name="product_name2[]" value="` + product_name + `">
										<input type="hidden" name="sku2[]" value="` + sku + `">
										<input type="hidden" name="count2[]" value="` + count + `">
										<input type="hidden" name="product_id2[]" value="` + product_id + `">
										<input type="hidden" name="im_ex_id2[]" value="` + im_price_id + `">
										<input type="hidden" name="ex_price2[]" value="` + export_price + `">
                  </td>
									<td>` + measure + `</td>
									<td>` + im_price2 + ` ₼</td>
									<td>` + export_price + ` ₼</td>
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
		$('input[name="ex_price"]').val('');
		$('input[name="expiration_date"]').val('');
    $('input[list="product_search"]').val('');
		$('#selectpicker option').remove();
		$('#selectpicker').selectpicker('refresh');

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

</script>

<style media="screen">
::-webkit-scrollbar {
    width: 10px;
}
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 4px #55585799;
}
::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 4px #55585799;
}
.overflow{
  overflow: hidden;
}
.overflow:hover{
  overflow: overlay;
}
.edit_open{
	display: none;
}
</style>
