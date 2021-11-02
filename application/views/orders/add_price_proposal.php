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
    											<th><?=$this->langs->name2; ?></th>
                          <th><?=$this->langs->discount_percentage; ?></th>
                          <th><?=$this->langs->price; ?></th>
                          <th><?=$this->langs->count; ?></th>
                          <th><?=$this->langs->total; ?></th>
													<th><?=$this->langs->comment; ?></th>
                          <th><?=$this->langs->proposal; ?></th>
    										</tr>
    									</thead>
    									<tbody>
                        <?php $i=0; ?>
                        <?php foreach($list as $row): ?>
                          <?php $i++; ?>
                          <tr>
                            <td><?=$i; ?></td>
                            <td><?=$row->title; ?></td>
                            <td><?=$row->discount; ?> %</td>
                            <td><?=$row->ex_price; ?> azn</td>
                            <td><?=$row->count; ?></td>
                            <td><?=number_format((100 - $row->discount)/100*$row->ex_price*$row->count, 2); ?> azn</td>
														<td><?=$row->comment; ?></td>
														<td>
                              <input
																style="border: none; outline: none;"
																class="teklif"
																type="number"
																name="<?=$row->id; ?>"
																required
																placeholder="daxil edin..."
																<?=$row->qiymet_teklifi?'value="'.number_format($row->qiymet_teklifi, 2).'"':'value="'.number_format((100 - $row->discount)/100*$row->ex_price*$row->count, 2).'"'; ?>>
                            </td>
                          </tr>
                        <?php endforeach; ?>
    									</tbody>
    								</table>
    							</div>
    						</div>


                <div class="form-group m-form__group row">
                  <div class="col-lg-12">
                    <label>&nbsp;</label></br>
										<form action="/orders/send_proposal/<?=$id; ?>" method="post">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
											<button type="submit" id="send_proposal" class="btn btn-primary pull-right"><i class="fa fa-share"></i> <?=$this->langs->send_proposal; ?></button>
										</form>
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
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript">

	var token = $('#token').val()
	$('.teklif').blur(function(){
		var teklif = 0;
		var id = 0;
		teklif = parseFloat($(this).val()).toFixed(2);
		id = parseInt($(this).attr('name'));
		if(teklif > 0)
		{
			$.ajax({
	      url: '/orders/change_proposal',
	      type: 'POST',
	      data: {id: id, teklif: teklif, tezbazar: token},
	      success: function(response){
					data = $.parseJSON(response);
					if(data['msg'] == 'success')
				  {
				    toastr.success("Uğur", "Təklif uğurla əlavə edildi");
				  }
				  else if(data['msg'] = 'error')
				  {
				    toastr.error('Xəta', "Təklif əlavə edilmədi");
				  }
				},
				error: function(){
					toastr.error('Xəta', "Təklif əlavə edilmədi");
				}
			});
		} else {
			toastr.error('Xəta', "0-dan böyük qiymət daxil edin");
		}
	});

</script>
