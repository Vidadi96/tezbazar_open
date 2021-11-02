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
		<a class="btn btn-success pull-right" href="/warehouse/add_warehouse/"><i class="fa fa-plus"></i> <?=$this->langs->new_warehouse; ?></a>
	</div>
</div>
<!-- END: Subheader -->
	<div class="m-content">
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
									<?=$this->langs->list;?>
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
						<form action="" method="GET">
							<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
								<div class="row align-items-center">
									<div class="col-xl-8 order-2 order-xl-1">
										<div class="form-group m-form__group row align-items-center">
											<div class="col-md-4">
												<input type="text" name="name" class="form-control m-input" placeholder="<?=$this->langs->warehouse_name; ?>..." id="generalSearch" value="<?=$this->input->get("name");?>" />
											</div>
											<div class="col-md-4">
												<button type="submit" class="btn btn-primary"><i class="la la-search"></i> <?=$this->langs->search; ?> (<?=$list["total_row"];?></i>)</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
						<!--end: Search Form -->
						<!--begin: Datatable -->
						<div class="row">
							<div class="col-xl-12">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<table delete_url="/warehouse/delete_warehouse/" class="table table-bordered" active_passive_url="/warehouse/warehouse_set_active_passive/">
							<thead>
								<tr>
									<th>
										<?=$this->langs->warehouse_name; ?>
									</th>
									<th>
										<?=$this->langs->active_passive;?>
									</th>
									<th>
										<?=$this->langs->edit;?>
									</th>
									<th>
										<?=$this->langs->delete;?>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list["list"] as $item) {
									$word=$this->langs->do_passive."!"; $class="btn-success"; $active_passive=0;
									if($item->active==0)
									{
										$word=$this->langs->do_active."!";
										$class="btn-danger";
										$active_passive = 1;
									}
									$btn_active_passive ='<button active_passive="'.$active_passive.'" id="'.$item->warehouse_id.'" type="button" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="'.$word.'" class="'.$class.' set_active_passive btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"></button>';

									echo '
									<tr>
										<td>
											'.$item->name.'
										</td>
										<td>
											'.$btn_active_passive.'
										</td>
										<td>
											<a href="/warehouse/edit_warehouse/'.$item->warehouse_id.'" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only">
												<i class="fa fa-pencil-alt"></i>
											</button>
										</td>
										<td>
											<button href="#" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="'.$item->warehouse_id.'">
												<i class="fa fa-trash"></i>
											</button>
										</td>
									</tr>
									';
								};?>

							</tbody>
						</table>
					</div>
					</div>
						<!--end: Datatable -->
					</div>
				</div>
				<!--end::Portlet-->
				<div class="text-center">
					 <ul class="pagination pagination-sm ">
							<?=@$pagination;?>
					 </ul>
				</div>
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
