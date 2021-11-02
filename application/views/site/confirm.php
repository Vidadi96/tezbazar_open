<div class=master-wrapper-content>
   <div class=master-column-wrapper>
      <div class=center-1>
         <div class="page checkout-page billing-address-page">
            <?=$order_progress;?>
            <div class=page-title>
               <h1><?=$this->langs->confirm;?></h1>
            </div>
            <div class="page-body checkout-data">

               <div class="section order-summary">
                  <div class=title><strong>Order summary</strong></div>
                  <div class=order-summary-content>
                     <form method=post id=shopping-cart-form action="/profile/complete/?<?php $get = $this->input->get();  $url = $get?"&".http_build_query($get):""; echo substr($url, 1);?>">
                       <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">



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
                                    <th class="sku" data-hide="w410, w480, w580, w768, w980">
                                       SKU
                                    </th>
                                    <th class="product-picture">
                                       <?=$this->langs->img;?>
                                   </th>
                                   <th class="product" data-hide="w410, w480">
                                       <?=$this->langs->products;?>
                                   </th>
                                   <th class="unit-price" data-hide="w410, w480, w580, w768">
                                       <?=$this->langs->price;?>
                                   </th>
                                   <th class="quantity" data-hide="w410, w480, w580, w768">
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

                             <?php
                             $cargo_total = 0;
                             foreach ($shipping as $value) {
                               if($value->region_id==$this->input->get("city"))
                               $cargo_total = $value->price;
                             }

                             $total_without_vat = $total-($total*18/100); $vat_total = $total*18/100; ?>
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
         <br />
         <br />
         <br />
         <div class="buttons">
           <input type="submit" value="<?=$this->langs->confirm;?>" class="button-1 cart-button" />
         </div>




                       </div>
                   </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
