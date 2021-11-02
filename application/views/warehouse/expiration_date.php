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

                <form action="/warehouse/expiration_date" method="GET">
                  <!--begin: Search Form -->
  								<div class="row">
  									<div class="col-lg-3 col-md-4">
  										<label><?=$this->langs->date2; ?></label>
  										<input type="text" class="form-control date_time_picker" name="expiration_date" value="<?=$expiration_date; ?>">
  									</div>
  									<div class="col-lg-3 col-md-4">
  										<label>&nbsp;</label>
  										<br>
  										<button type="submit" id="show" class="btn btn-primary"><i class="la la-plus"></i> <?=$this->langs->display; ?></i><?=isset($row_count)?' ('.$row_count.')':''; ?></button>
  									</div>
  								</div>
                  <br><br>
                </form>
								<!--end: Search Form -->

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
                          <th><?=$this->langs->import_type; ?></th>
                          <th><?=$this->langs->provider; ?></th>
  												<th><?=$this->langs->expiration_date; ?></th>
    										</tr>
    									</thead>
    									<tbody>
                        <?php foreach ($expiration_date_list as $row): ?>
                          <tr>
                            <td><?=$row->sku; ?></td>
                            <td><?=$row->product_name; ?></td>
                            <td><?=$row->count; ?></td>
                            <td><?=$row->measure; ?></td>
                            <td><?=$row->im_price; ?> ₼</td>
                            <td><?=$row->ex_price; ?> ₼</td>
                            <td><?=$row->entry_name; ?></td>
                            <td><?=$row->provider; ?></td>
                            <td><?=$row->expiration_date; ?></td>
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
</style>

<script type="text/javascript">
</script>
