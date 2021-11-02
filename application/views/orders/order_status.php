
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
				<div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Yeni Status
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
					<!--begin::Form-->
					<form method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
						<div class="m-portlet__body">
							<div class="form-group m-form__group row">
								<div class="col-lg-3">
									<label>Aktiv/Passiv</label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=(@$filter["active"])?"":"checked";?> value="1">
											Aktiv
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=(@$filter["active"]==1)?"checked":"";?> value="0">
											Passiv
											<span></span>
										</label>
									</div>
								</div>
								<div class="col-lg-3">
									<label>Sıra sayı</label>
									<input type="text" name="order_by" value="" class="form-control m-input" placeholder="">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								</div>
								<?php $i=2; foreach($langs as $lang):?>
								<div class="col-lg-3">
									<div class="form-group">
										<label>Adı (<?=$lang->name;?>) <img style="max-width: 20px" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" /></label>
										<input type="text" name="meta_value-<?=$lang->lang_id;?>" class="form-control" id="name" value="" />
									</div>
								</div>
								<?php
								if($i==3)
								{
									$i=-1;
									echo '</div><div class="form-group m-form__group row">';
								}

								$i++; endforeach;?>

							</div>

						</div>
						<!--begin:: Portlet footer-->
						<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
							<div class="m-form__actions m-form__actions--solid">
								<div class="row">
									<div class="col-lg-12 m--align-right">
										<button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Daxil et</button>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Portlet footer-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Portlet-->
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<!--begin::Portlet-->
				<div class="m-portlet m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Siyahı
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
						<!--begin: Search Form -->
						<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
							<div class="row align-items-center">
								<div class="col-xl-8 order-2 order-xl-1">
									<div class="form-group m-form__group row align-items-center">
										<div class="col-md-4">
											<div class="m-input-icon m-input-icon--left">
												<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
												<span class="m-input-icon__icon m-input-icon__icon--left">
													<span>
														<i class="la la-search"></i>
													</span>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end: Search Form -->
						<!--begin: Datatable -->
						<table delete_url="/orders/delete_order_status/" class="table table-bordered m-table" active_passive_url="/orders/order_status_set_active_passive/">
							<thead>
								<tr>
									<th>
										Adı
									</th>
									<th>
										Sıra nömrəsi
									</th>
									<th>
										Aktiv/Passiv
									</th>
									<th>
										Redaktə
									</th>
									<th>
										Sil
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list as $item) {
									$word="Passiv et!"; $class="btn-success"; $active_passive=0;
									if($item->active==0)
									{
										$word="Aktiv et!";
										$class="btn-danger";
										$active_passive = 1;
									}
									$btn_active_passive ='<button active_passive="'.$active_passive.'" id="'.$item->order_status_id.'" type="button" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="'.$word.'" class="'.$class.' set_active_passive btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"></button>';

									echo '
									<tr>
										<td>
											'.$item->order_status_title.'
										</td>
										<td>
											'.$item->order_by.'
										</td>
										<td>
											'.$btn_active_passive.'
										</td>
										<td>
											<a href="/orders/edit_order_status/'.$item->order_status_id.'" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only">
												<i class="fa fa-pencil-alt"></i>
											</button>
										</td>
										<td>
											<button href="#" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="'.$item->order_status_id.'">
												<i class="fa fa-trash"></i>
											</button>
										</td>
									</tr>
									';
								};?>

							</tbody>
						</table>
						<!--end: Datatable -->
					</div>
				</div>
				<!--end::Portlet-->
			</div>
		</div>
	</div>

	<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
	<script src="/assets/demo/default/custom/crud/forms/widgets/select2.js" type="text/javascript"></script>

<!--begin::Page Resources -->
<script type="text/javascript">
var DatatableHtmlTableDemo = {
    init: function() {
        $(".m-datatable").mDatatable({
            search: {
                input: $("#generalSearch")
            },
            layout: {
                scroll: !0,
                height: 600
            }/*,
            columns: [{
                field: "Metakey",
                type: "text",
                locked: {
                    left: "xl"
                }
            },{
                field: "Delete",
                type: "text",
                locked: {
                    left: "xl"
                }
            }]*/
        })
    }
};
jQuery(document).ready(function() {
    DatatableHtmlTableDemo.init()
});

</script>
<!--end::Page Resources -->
