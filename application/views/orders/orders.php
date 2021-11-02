
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
            <!--begin::Form-->
  					<form method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
  						<div class="m-portlet__body">
  							<div class="form-group m-form__group row">

  								<!-- <div class="col-lg-3">
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
  								</div> -->
  								<div class="col-lg-3">
  									<label>Sifariş statusu</label>
                    <select name="order_status_id" class="form-control">
                      <option value="">Hamısı</option>
                      <?php foreach ($order_status as $item):
                        if($this->input->get("order_status_id")==$item->order_status_id)
                        {
                          echo '<option selected value="'.$item->order_status_id.'">'.$item->order_status_title.'</option>';
                        }else {
                          echo '<option value="'.$item->order_status_id.'">'.$item->order_status_title.'</option>';
                        }
                      endforeach; ?>
                    </select>

  									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
  								</div>
  								<div class="col-lg-3">
  									<label>&nbsp;</label><br />
  									<button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Axtar</button>
  								</div>


  							</div>

  						</div>

  					</form>
  					<!--end::Form-->
						<!--begin: Datatable -->
						<table delete_url="/orders/delete_order/" class="table table-bordered m-table" active_passive_url="/orders/order_status_set_active_passive/">
							<thead>
								<tr>
									<th>
										Adı
									</th>
									<th>
										Məhsul sayı
									</th>
									<th>
										Toplam dəyər
									</th>
									<th>
										Tarix
									</th>
									<th>
										Statusu
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


									echo '
									<tr>
										<td>
											'.($item->full_name?$item->full_name:'Anonim').'
										</td>
										<td>
											'.$item->product_count.'
										</td>
										<td>
											'.$item->product_price.'
										</td>
										<td>
											'.$item->date_time.'
										</td>
										<td>
											'.$item->order_status_title.'
										</td>
										<td>
											<a href="/orders/edit_order/'.$item->id.'" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only">
												<i class="fa fa-pencil-alt"></i>
											</button>
										</td>
										<td>
											<button href="#" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="'.$item->id.'">
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
