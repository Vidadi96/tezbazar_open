
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
									<?=$this->langs->orders; ?>
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

  					<!--end::Form-->
						<!--begin: Datatable -->
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<table class="table table-bordered m-table">
							<thead>
								<tr>
									<th>
										<?=$this->langs->order_number; ?>
									</th>
									<th>
										<?=$this->langs->name2; ?>
									</th>
									<th>
										<?=$this->langs->product_count; ?>
									</th>
									<th>
										<?=$this->langs->date2; ?>
									</th>
									<th>
										<?=$this->langs->status; ?>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list as $item) {


									echo '
									<tr>
										<td>
											'.$item->order_number.'
										</td>
										<td>
											'.($item->full_name?$item->full_name:'Anonim').'
										</td>
										<td>
											'.$item->product_count.'
										</td>
										<td>
											'.$item->date_time.'
										</td>
										<td>
											'.$item->order_status_title.'
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
