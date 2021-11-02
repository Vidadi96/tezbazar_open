<div class=master-wrapper-content>
   <div class=master-column-wrapper>
      <div class=center-1>
         <div class="page checkout-page billing-address-page">
            <?=$order_progress;?>

            <div class=page-title>
               <h1><?=$this->langs->delivery_address;?></h1>
            </div>

            <div class="page-body checkout-data">

               <form method=get action="/profile/payment">
                 <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <div class=billing-addresses>
                     <div class="section new-billing-address">
                        <div class=enter-address>
                           <div class=edit-address>
                             <?php $json_address=[]; if($this->session->userdata("user_id")){ ?>
                               <div class=inputs>
                                 <label for=address_id><?=$this->langs->your_addresses;?>:</label>
                                 <select name="address_id" data-val=true data-val-required="<?=$this->langs->required;?>">
                                   <option value=""><?=$this->langs->select;?></option>
                                   <?php foreach ($addresses as $value) { $json_address[$value->address_id]=$value;
                                     echo '<option '.(($this->input->get("address_id")==$value->address_id)?'selected':'').' value="'.$value->address_id.'">'.$value->title.'</option>';
                                   }
                                   $json_address =json_encode($json_address);
                                   ?>
                                 </select><span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=address_id data-valmsg-replace=true></span>
                               </div>
                               <div class="address-list" style="display: none;">
                                 <div class="section address-item">

                   									<ul class="info">
                   										<li class="fullname"><strong class="title_addr"></strong></li>
                   										<li class="fullname fullname_addr"></li>
                   										<li class="phone"><label><?=$this->langs->phone;?>:</label> <span class="phone_addr"></span></li>
                   										<li class="city-state-zip"><label><?=$this->langs->zip_code?>:</label> <span class="zip_code_addr"></span></li>
                   										<li class="address"><label><?=$this->langs->address;?>:</label> <span class="address_addr"></span></li>
                   									</ul>
                                    <br />
                                    <br />
                                 </div>
                               </div>
                               <div class=inputs>
                                 <label for=city><?=$this->langs->delivery_to;?>:</label>
                                 <select name="city" data-val=true data-val-required="<?=$this->langs->required;?>">
                                   <option value=""><?=$this->langs->select;?></option>
                                   <?php foreach ($shipping as $value) {
                                     if($value->price)
                                     echo '<option '.(((isset($user->region_id)?$user->region_id:$this->input->get("city"))==$value->region_id)?'selected':'').' value="'.$value->region_id.'">'.$value->path.($value->price?' - '.$value->price.' AZN':'').'</option>';
                                   }
                                   ?>
                                 </select><span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=city data-valmsg-replace=true></span>
                               </div>



                             <?php }else { ?>
                             <div class=inputs>
                               <label for=firstname><?=$this->langs->firstname;?>:</label>
                               <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=firstname name="firstname" value="<?=isset($user->firstname)?$user->firstname:$this->input->get("firstname");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=firstname data-valmsg-replace=true></span>
                             </div>
                             <div class=inputs>
                               <label for=lastname><?=$this->langs->lastname;?>:</label>
                               <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=lastname name="lastname" value="<?=isset($user->lastname)?$user->lastname:$this->input->get("lastname");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=lastname data-valmsg-replace=true></span>
                             </div>
                             <div class=inputs>
                               <label for=middlename><?=$this->langs->middlename;?>:</label>
                               <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=middlename name="middlename" value="<?=isset($user->middlename)?$user->middlename:$this->input->get("middlename");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=middlename data-valmsg-replace=true></span>
                             </div>
                             <div class=inputs>
                               <label for=email><?=$this->langs->email;?>:</label>
                               <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=email name="email" value="<?=isset($user->email)?$user->email:$this->input->get("email");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=email data-valmsg-replace=true></span>
                             </div>
                             <div class=inputs>
                               <label for=phone><?=$this->langs->phone;?>:</label>
                               <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=phone name="phone" value="<?=isset($user->phone)?$user->phone:$this->input->get("phone");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=phone data-valmsg-replace=true></span>
                             </div>
                             <div class=inputs>
                               <label for=address><?=$this->langs->delivery_address;?>:</label>
                               <textarea rows=3 data-val=true data-val-required="<?=$this->langs->required;?>" type=text id=address name="address"><?=trim((isset($user->address)?$user->address:$this->input->get("address")));?></textarea><span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=address data-valmsg-replace=true></span>
                             </div>
                             <div class=inputs>
                               <label for=address><?=$this->langs->delivery_to;?>:</label>
                               <select name="city" data-val=true data-val-required="<?=$this->langs->required;?>">
                                 <option value="0"><?=$this->langs->select;?></option>
                                 <?php foreach ($shipping as $value) {
                                   if($value->price)
                                   echo '<option '.(((isset($user->region_id)?$user->region_id:$this->input->get("city"))==$value->region_id)?'selected':'').' value="'.$value->region_id.'">'.$value->path.($value->price?' - '.$value->price.' AZN':'').'</option>';
                                 }
                                 ?>
                               </select><span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=address data-valmsg-replace=true></span>
                             </div>
                              <div class=inputs><label for=zip_code><?=$this->langs->zip_code;?>:</label> <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=zip_code name="zip_code" value="<?=isset($user->zip_code)?$user->zip_code:$this->input->get("zip_code");?>"> <span class=required>*</span> <span class=field-validation-valid data-valmsg-for="zip_code" data-valmsg-replace="true"></span>
                              </div>
                              <?php } ?>








                           </div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="order_details">
                          <div class="section order-summary">
                             <div class=order-summary-content>
                                <form method=post enctype=multipart/form-data id=shopping-cart-form action=/cart>




                                  <table class="cart">
                                      <colgroup>
                                          <col width="1" />
                                              <col width="1" />
                                                                      <col width="1" />
                                                                      <col width="1" />
                                          <col />
                                          <col width="1" />
                                          <col width="1" />
                                          <col width="1" />
                                      </colgroup>
                                      <thead>
                                          <tr class="cart-header-row">
                                               <th class="sku" data-hide="w410, w480, w580, w768">
                                                  SKU
                                               </th>
                                               <th class="product-picture" data-hide="w410, w480, w580, w768">
                                                  <?=$this->langs->img;?>
                                              </th>
                                              <th class="product" style="min-width: 250px;">
                                                  <?=$this->langs->products;?>
                                              </th>
                                              <th class="unit-price" >
                                                  <?=$this->langs->price;?>
                                              </th>
                                              <th class="quantity" >
                                                  <?=$this->langs->quantity;?>
                                              </th>
                                              <th class="subtotal">
                                                  <?=$this->langs->total;?>
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php $total=0; foreach ($in_basket as $value): $total = $total+($value["count"]*$value["ex_price"]); ?>
                                        <tr class="cart-item-row">

                                            <td class="sku">
                                                <?=$value["sku"];?>
                                            </td>
                                            <td class="product-picture">
                                                <a href="/office/product/<?=$value["id"];?>"><img alt="<?=$value["title"];?>" src="/img/products/95x95/<?=$value["img"];?>" title="<?=$value["title"];?>" /></a>
                                            </td>
                                            <td class="product">
                                              <a href="/office/product/<?=$value["id"];?>" class="product-name"><?=$value["title"];?></a>
                                            </td>
                                            <td class="unit-price">
                                                <span class="product-unit-price"><?=$value["ex_price"];?></span>
                                            </td>
                                            <td class="quantity">
                                                <?=$value["count"];?>
                                            </td>
                                            <td class="subtotal">
                                                <span class="product-subtotal"><?=$value["count"]*$value["ex_price"];?> AZN</span>
                                            </td>
                                          </tr>
                                        <?php endforeach; ?>
                                      </tbody>
                                  </table>
                            </div>
                            <div class="cart-options">

                            </div>
                              <div class="cart-footer">
                                  <div class="totals">
                                      <div class="total-info">
                                        <?php $cargo_total = 0.0; $total_without_vat = $total-($total*18/100); $vat_total = $total*18/100; ?>

                                        <table class="cart-total">
                                            <tbody>
                                                <tr class="order-subtotal">
                                                    <td class="cart-total-left">
                                                        <label><?=$this->langs->total;?>:</label>
                                                    </td>
                                                    <td class="cart-total-right">
                                                        <span class="value-summary"><?=$total_without_vat;?> AZN</span>
                                                    </td>
                                                </tr>
                                                                <tr class="shipping-cost">
                                                        <td class="cart-total-left">
                                                            <label><?=$this->langs->cargo;?>:</label>
                                                        </td>
                                                        <td class="cart-total-right">
                                                                <span><span class="shipping_price"><?=$cargo_total;?></span> AZN</span>
                                                        </td>
                                                    </tr>
                                                                            <tr class="tax-rate">
                                                        <td class="cart-total-left">
                                                            <label><?=$this->langs->vat;?> 0%:</label>
                                                        </td>
                                                        <td class="cart-total-right">
                                                            <span><?=$vat_total;?> AZN</span>
                                                        </td>
                                                    </tr>
                                                                                                <tr class="order-total">
                                                    <td class="cart-total-left">
                                                        <label><?=$this->langs->sum_total;?>:</label>
                                                    </td>
                                                    <td class="cart-total-right">
                                                            <span><span class="sum_total"><?=($total_without_vat+$cargo_total+$vat_total);?></span> AZN</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                    </div>




                                  </div>
                              </div>
                                </form>
                             </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class=buttons><input type="submit" value="<?=$this->langs->next;?>" class="button-1 new-address-next-step-button"></div>
                     </div>
                  </div>
               </form>

               </div>
               <!--./checkout-data-->
            </div>
         </div>
      </div>
   </div>
</div>
<script>
<?php
$json_city = [];
foreach ($shipping as $value) {
  $json_city[$value->region_id] = $value;
}

 ?>
   $(document).ready(function() {

     $("select[name=address_id]").change(function(){
       var addr_id = $(this).val();
       var addr = JSON.parse('<?=$json_address;?>');
       if(addr_id.length>0)
       {
         $(".fullname_addr").text(addr[addr_id].firstname+" "+addr[addr_id].lastname+" "+addr[addr_id].middlename);
         $(".title_addr").text(addr[addr_id].title);
         $(".phone_addr").text(addr[addr_id].phone);
         $(".zip_code_addr").text(addr[addr_id].zip_code);
         $(".address_addr").text(addr[addr_id].address);
         $(".address-list").slideDown(500);
       }else {
         $(".address-list").slideUp(500);
       }
     })
     $("select[name=address_id]").change();




    var total_without_vat = <?=$total_without_vat?$total_without_vat:0;?>;
    var vat_total = <?=$vat_total?$vat_total:0;?>;
    var city = JSON.parse('<?=json_encode($json_city); ?>');
    console.log(city);
    $("select[name=city]").change(function(){
      var current_id = $(this).val();
      var shipping_price = city[current_id].price;
      var total_sum = parseFloat(total_without_vat)+parseFloat(vat_total)+parseFloat(shipping_price);
      //console.log(total_sum);
      $(".sum_total").text(total_sum);
      $(".shipping_price").text(shipping_price);
    });
    $("select[name=city]").change();
   });
  </script>
