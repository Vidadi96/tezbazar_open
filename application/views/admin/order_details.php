
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
									<strong style="margin-right:5px;"><?=@$order[0]->order_number;?> </strong> nömrəli sifariş
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
						<table delete_url="/adm/delete_order_product/" class="table table-bordered m-table">
							<thead>
								<tr>
									<th>
										Sku kod
									</th>
									<th>
										Şəkli
									</th>
									<th>
										Məhsulun adı
									</th>
									<th>
										Məhsulun qiyməti
									</th>
									<th>
										Məhsul sayı
									</th>
									<th>
										Toplam qiyməti
									</th>
									<th>
										Sil
									</th>
								</tr>
							</thead>
							<tbody>
								<?php $total = 0; foreach ($order as $value) { $total = $total+($value->count*$value->ex_price);


                  ?>
                  <td><?=$value->sku;?></td>
                  <td><a href="<?=base_url();?>/office/product/<?=$value->id;?>"><img width="30" src="<?=base_url();?>/img/products/95x95/<?=$value->img;?>"/></a>
                  </td>
                  <td><?=$value->title;?></td>
                  <td><?=$value->ex_price;?></td>
                  <td><?=$value->count;?></td>
                  <td><?=$value->count*$value->ex_price;?></td>
                  <td>
                    <button href="#" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="<?=$value->id;?>">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
							  <?php	} ?>

							</tbody>
              <tfoot>

              </tfoot>
						</table>
						<!--end: Datatable -->
            <div class="total-info" style="float: left; border: 1px solid #e9e9e9;background-color: #fff;padding: 40px 40px; width: 60%;">
              <?php
              $cargo_total = 0;
              $cargo = [];
              foreach ($shipping as $value) {
                if($value->region_id==$order_number->region_id)
                {
                  $cargo_total = $value->price;
                  $cargo = $value;
                }
              }


               echo '<table border="0" cellpadding="10">
              <tbody>
              <tr>
              <td><strong>Sifarişin nömrəsi</strong></td>
              <td>:</td>
              <td>'.$order_number->order_number.'</td>
              </tr>
              <tr>
              <td><strong>Soyad, ad, ata adı</strong></td>
              <td>:</td>
              <td>'.$address->lastname.' '.$address->firstname.' '.$address->middlename.'</td>
              </tr>
              <tr>
              <td><strong>E-poçt</strong></td>
              <td>:</td>
              <td>'.$user->email.'</td>
              </tr>
              <tr>
              <td><strong>Telefon nömrəsi</strong></td>
              <td>:</td>
              <td>'.$address->phone.'</td>
              </tr>
              <tr>
              <td><strong>Ünvan</strong></td>
              <td>:</td>
              <td>'.$address->address.'</td>
              </tr>
              <tr>
              <td><strong>Daşınma istiqaməti</strong></td>
              <td>:</td>
              <td>'.$cargo->name.' - '.$cargo->price.' AZN</td>
              </tr>


              </tbody>
              </table>'; ?>
            </div>
            <div class="total-info" style="float: right; border: 1px solid #e9e9e9;background-color: #fff;padding: 40px 40px; width: 35%;">
               <?php

               $total_without_vat = $total-($total*18/100); $vat_total = $total*18/100; ?>
               <table class="cart-total" border="0" cellpadding="10">
                   <tbody>
                       <tr class="order-subtotal">
                           <td class="cart-total-left">
                               <label>Toplam:</label>
                           </td>
                           <td class="cart-total-right">
                               <span class="value-summary"><?=$total_without_vat;?> AZN</span>
                           </td>
                       </tr>
                       <tr class="shipping-cost">
                           <td class="cart-total-left">
                               <label>Daşınma:</label>
                           </td>
                           <td class="cart-total-right">
                             <?=$cargo_total;?> AZN
                           </td>
                       </tr>
                       <tr class="tax-rate">
                           <td class="cart-total-left">
                               <label>ƏDV 0%:</label>
                           </td>
                           <td class="cart-total-right">
                               <span><?=$vat_total;?> AZN</span>
                           </td>
                       </tr>
                       <tr class="order-total" style="font-size: 18px;font-weight: bold;color: #067baf;text-transform: uppercase;">
                           <td class="cart-total-left">
                               <label>ÜMUMİ CƏM:</label>
                           </td>
                           <td class="cart-total-right">
                              <span><span class="sum_total"><?=($total_without_vat+$cargo_total+$vat_total);?></span> AZN</span>
                           </td>
                       </tr>
                   </tbody>
               </table>
            </div>
            <div class="clearfix"></div>
            <form method="post" action="/adm/index/">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <input type="hidden" name="order_number" value="<?=$this->uri->segment(3);?>">
              <div class="form-group m-form__group row">
                <div class="col-md-4 offset-md-8">
                  <label><strong>Sifarişin statusu</strong></label>
                  <select class="form-control m-select2 m_select2_3" id="" name="order_status_id">
                    <option value="0">Seçin</option>
                      <?php foreach ($order_status_id as $item) {
                          echo '<option '.(($order_number->order_status_id==$item->order_status_id)?'selected':'').' value="'.$item->order_status_id.'">'.$item->order_status_title.'</option>';
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group m-form__group row">
                <div class="col-md-4 offset-md-8">
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Yadda saxla</button>
                </div>
              </div>
            </form>
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
