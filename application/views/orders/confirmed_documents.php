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

							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

    						<div class="row">
    							<div class="col-xl-12">
                    <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    								<table class="table table-bordered m-table">
    									<thead>
    										<tr>
                          <th>#</th>
    											<th><?=$this->langs->onum; ?></th>
                          <th><?=$this->langs->product_count; ?></th>
													<th><?=$this->langs->company_name; ?></th>
                          <th><?=$this->langs->user_name; ?></th>
    											<th><?=$this->langs->date; ?></th>
													<th><?=$this->langs->delivery_date; ?></th>
													<th><?=$this->langs->complete_the_order; ?></th>
    										</tr>
    									</thead>
    									<tbody>
                        <?php $i=0; ?>
                        <?php foreach($order_list_10 as $row): ?>
                          <?php $i++; ?>
                        <tr>
                          <td><?=$i; ?></td>
                          <td><a style="text-decoration: none; color: inherit" href="/pages/qaime_pdf/<?=$row->order_number; ?>" target="_blank"><u>#<?=$row->order_number; ?></u></a></td>
                          <td style="text-transform: lowercase"><?=$row->count; ?> <?=$this->langs->product; ?></td>
													<td><?=$row->company_name; ?></td>
                          <td><?=$row->firstname." ".$row->lastname." ".$row->middlename; ?></td>
                          <td><?=$row->date_time; ?></td>
													<td>
														<input style="border: none; outline: none;" type="text" class="delivery_date date_time_picker" placeholder="<?=$this->langs->date; ?>...">
													</td>
													<td>
														<button style="margin-bottom: 0px;" type="button" class="complete_the_order form-group btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only" name="<?=$row->order_number; ?>">
															<i class="fa fa-share"></i>
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
<script src="/assets/demo/default/custom/crud/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript">

	var token = $('#token').val();
	$('.complete_the_order').click(function(){
		var delivery_date = '';
		var id = 0;
		delivery_date = $(this).closest('tr').find('.delivery_date').val();
		id = parseInt($(this).attr('name'));

		if(delivery_date)
		{
			$.ajax({
				url: '/orders/add_contract_number',
				type: 'POST',
				data: {id: id, delivery_date: delivery_date, tezbazar: token},
				success: function(response){
					data = $.parseJSON(response);
					if(data['msg'] == 'success')
						toastr.success("Çatdırılma tarixi uğurla əlavə edildi", "Uğur");
					else if(data['msg'] = 'error')
						toastr.error("Xəta baş verdi", 'Xəta');
				},
				error: function(){
					toastr.error("Xəta baş verdi", 'Xəta');
				}
			});
		}
		else
			toastr.error("Çatdırılma tarixini qeyd edin", 'Xəta');
	});

</script>
