<!-- BEGIN: Subheader -->
<div class="m-subheader">
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

							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

    						<div class="row">
    							<div class="col-xl-12" style="overflow: auto;">
    								<table class="table table-bordered m-table">
    									<thead>
    										<tr>
                          <th>
    												#
    											</th>
    											<th>
    												<?=$this->langs->onum; ?>
    											</th>
                          <th>
                            <?=$this->langs->product_count; ?>
                          </th>
													<th>
														<?=$this->langs->company_name; ?>
													</th>
                          <th>
    												<?=$this->langs->user_name; ?>
    											</th>
    											<th>
    												<?=$this->langs->date; ?>
    											</th>
													<th>
    												<?=$this->langs->address; ?>
    											</th>
													<th>
    												<?=$this->langs->comment; ?>
    											</th>
													<th>
    												<?=$this->langs->edit_count; ?>
    											</th>
    											<th>
    												<?=$this->langs->send_cheque; ?>
    											</th>
                          <th>
    												<?=$this->langs->cancel_order; ?>
    											</th>
    										</tr>
    									</thead>
    									<tbody>
                        <?php $i=0; ?>
                        <?php foreach($order_list_10 as $row): ?>
                          <?php $i++; ?>
                        <tr>
                          <td><?=$i; ?></td>
                          <td><a style="text-decoration: none; color: inherit" href="/pages/pdf/<?=$row->order_number; ?>" target="_blank"><u>#<?=$row->order_number; ?></u></a></td>
                          <td><?=$row->count; ?> <span style="text-transform: lowercase"><?=$this->langs->product; ?></span></td>
													<td><?=$row->company_name; ?></td>
                          <td><?=$row->firstname?$row->firstname." ".$row->lastname." ".$row->middlename:$row->lastname; ?></td>
                          <td><?=$row->date_time; ?></td>
													<td><?=$row->address?$row->address:'---'; ?></td>
													<td><?=$row->comment?$row->comment:'---'; ?></td>
													<td>
                            <a target="_blank" href="/orders/edit_order_count/<?=$row->order_number; ?>" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only">
  														<i class="fa fa-pencil-alt"></i>
  													</a>
                          </td>
                          <td>
														<div class="row">
															<div class="col-lg-1 col-md-1" style="min-height: 25px">
																<button type="button" class="open_close form-group btn btn-info btn-sm m-btn m-btn--icon m-btn--icon-only">
																	<i class="fa fa-plus"></i>
																</button>
															</div>
															<div class="open_send_form col-lg-12 col-md-12">
																<form class="row" action="/orders/send_cheque" method="post" style="min-width: 300px">
																	<input type="hidden" name="current_url" value="<?=current_url(); ?>">
																	<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
																	<input type="hidden" name="id" value="<?=$row->order_number; ?>">
																	<input type="hidden" name="buyer_id" value="<?=$row->user_id; ?>">
																	<div class="row">
																		<div class="col-lg-4 col-md-4" style="min-height: 25px">
																			<select	name="contract_number" required style="width: 100%" class="form-control">
																				<option value=""></option>
																				<?php foreach($export_contracts as $raw):
																					if($raw->buyer_id == $row->user_id): ?>
																						<option value="<?=$raw->id; ?>"><?=$raw->contract_number; ?></option>
																					<?php endif;
																				endforeach; ?>
																			</select>
																		</div>
																		<div class="col-lg-3 col-md-3" style="min-height: 25px">
																			<input type="number" class="form-control m-input" name="discount" placeholder="<?=$this->langs->discount_percentage; ?>">
																		</div>
																		<div class="col-lg-3 col-md-3" style="min-height: 25px; padding-left: 0px;">
																			<input type="text" required class="form-control m-input date_time_picker" name="delivery_time" placeholder="<?=$this->langs->time_of_delivery; ?>">
																		</div>
																		<div class="col-lg-2 col-md-2" style="min-height: 25px">
																			<button type="submit" class="form-group btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only">
																				<i class="fa fa-share"></i>
																			</button>
																		</div>
																	</div>
																</form>
															</div>
														</div>
                          </td>
                          <td>
                            <a href="/orders/cancel_order/<?=$row->order_number; ?>" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only cancel_confirmation">
  														<i class="fa fa-trash"></i>
  													</a>
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
<script src="/assets/demo/default/custom/crud/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/icon.css">

<style media="screen">
	.open_send_form{
		display: none;
	}
</style>
<script type="text/javascript">

	// OPEN QAIME SEND FORM

	$('.open_close').click(function(){
		// $(this).closest('tr').find('.open_send_form').animate({width:'toggle'},500);
		if($(this).hasClass('opened')){
			$(this).html('<i class="fa fa-plus"></i>');
			$(this).closest('tr').find('.open_send_form').hide(500);
			$(this).removeClass('opened');
		} else {
			$(this).html('<i class="fa fa-minus"></i>');
			$(this).closest('tr').find('.open_send_form').show(500);
			$(this).addClass('opened');
		}
	});

	var lang = $('#language2').text();

	var success = [];
	success['az'] = 'U??ur';
	success['tr'] = 'Ba??ar??l??';
	success['en'] = 'Success';
	success['ru'] = '??????????????';

	var proposal_successfully_sent = [];
	proposal_successfully_sent['az'] = 'Qiym??t t??klifi u??urla g??nd??rildi';
	proposal_successfully_sent['tr'] = 'Fiyat teklifi ba??ar??l?? g??nderildi';
	proposal_successfully_sent['en'] = 'A price proposal successfully sent';
	proposal_successfully_sent['ru'] = '?????????????????????? ???????? ?????????????? ??????????????????';

	var cheque_successfully_sent = [];
	cheque_successfully_sent['az'] = 'Qaim?? u??urla g??nd??rildi';
	cheque_successfully_sent['tr'] = '??ek ba??ar??yla g??nderildi';
	cheque_successfully_sent['en'] = 'A cheque successfully sent';
	cheque_successfully_sent['ru'] = '?????? ?????????????? ??????????????????';

	var order_successfully_cancelled = [];
	order_successfully_cancelled['az'] = 'Sifari???? u??urla imtina edildi';
	order_successfully_cancelled['tr'] = 'Sipari?? ba??ar??l?? iptal edildi';
	order_successfully_cancelled['en'] = 'Order successfully cancelled';
	order_successfully_cancelled['ru'] = '?????????? ?????????????? ????????????????';

	var error = [];
	error['az'] = 'X??ta';
	error['ru'] = '????????????';
	error['en'] = 'Error';
	error['tr'] = 'Hata';

	var error_msg = [];
	error_msg['az'] = 'X??ta ba?? verdi';
	error_msg['ru'] = '?????????????????? ????????????';
	error_msg['en'] = 'An error has occured';
	error_msg['tr'] = 'Bir hata olu??tu';

	var cancel_confirmation = [];
	cancel_confirmation['az'] = 'Imtina etm??k ist??diyiniz?? ??minsiniz?';
	cancel_confirmation['ru'] = '??????????????, ?????? ???????????? ???????????????';
	cancel_confirmation['en'] = 'Are you sure?';
	cancel_confirmation['tr'] = 'Redd etmek isdeyinize eminsinizmi?';

	var out_of_stock = [];
	out_of_stock['az'] = 'Anbarda yet??ri q??d??r m??hsul yoxdur';
	out_of_stock['ru'] = '???? ???????????? ???????????????????????? ??????????????????';
	out_of_stock['en'] = 'There is not so many products in warehouse';
	out_of_stock['tr'] = 'Stokda yeteri kadar ??r??n yok';

	let searchParams = new URLSearchParams(window.location.search)
	if(searchParams.has('msg'))
	{
		let msg = searchParams.get('msg');

		if(msg==1)
			toastr.success(success[lang], proposal_successfully_sent[lang]);
		else if(msg==2)
			toastr.success(success[lang], order_successfully_cancelled[lang]);
		else if(msg=='success')
			toastr.success(success[lang], cheque_successfully_sent[lang]);
		else if(msg=='error')
			toastr.error(error_msg[lang], error[lang]);
		else if(msg=='info')
			toastr.info(out_of_stock[lang], 'Info');
		else
			toastr.error(error_msg[lang], error[lang]);
	}

	/*------ CANCEL CONFIRMATION ------*/

	$(document).on('click', '.cancel_confirmation', function(){
	  return confirm(cancel_confirmation[lang]);
	});


</script>
