<?php if(!@$cancel_order): ?>
<h3><?=$this->langs->new_order; ?></h3>
<br />

<table cellspaceing="0" cellpadding="10">
   <thead>
     <tr>
      <th><?=$this->langs->image; ?></th>
      <th><?=$this->langs->product_name; ?></th>
      <?php if(@!$qiymet_teklifi): ?>
        <th><?=$this->langs->discount_percentage; ?></th>
      <?php endif;?>
      <th><?=$this->langs->count; ?></th>
      <th><?=$this->langs->product_price; ?></th>
      <?php if(@!$qiymet_teklifi): ?>
        <th><?=$this->langs->total; ?></th>
      <?php endif;?>
      <?php if(@$qiymet_teklifi): ?>
        <th><?=$this->langs->proposal; ?></th>
      <?php endif;?>
    </tr>
  </thead>
  <tbody>
  <?php $total=0; foreach ($orders as $value): $total = $total+($value["count"]*$value["price"]); ?>
    <tr>
      <td><a href="<?=base_url();?>/goods/product/<?=$value["p_id"];?>"><img src="<?=base_url();?>/img/products/95x95/<?=$value["img"];?>"/></a>
      </td>
      <td><a href="<?=base_url();?>/goods/product/<?=$value["p_id"];?>"><?=$value["title"];?> - <?=$value['description']; ?></a></td>
      <?php if(@!$qiymet_teklifi): ?>
        <td><?=$value["discount"]; ?></td>
      <?php endif;?>
      <td><?=$value["count"];?></td>
      <td><?=$value["price"];?> AZN</td>
      <?php if(@!$qiymet_teklifi): ?>
        <td><?=number_format($value["count"]*$value["price"], 2);?> AZN</td>
      <?php endif;?>
      <?php if(@$qiymet_teklifi): ?>
        <td><?=$value["qiymet_teklifi"];?> AZN</td>
      <?php endif;?>
    </tr>
  <?php endforeach; ?>
  </tbody>
 </table>

<?php if($use_other_side): ?>
<div class="total-info" style="border: 1px solid #e9e9e9;background-color: #fff;padding: 40px 40px; width: 35%;">
   <?php
   $cargo_total = 0;
   foreach ($shipping as $value) {
     if($value->region_id==$this->input->get("city"))
     $cargo_total = $value->price;
   }
   $total_without_vat = $total-($total*18/100); $vat_total = $total*18/100; ?>
   <table class="cart-total" border="0" cellpadding="10">
       <tbody>
           <tr class="order-subtotal">
               <td class="cart-total-left">
                   <label><?=$this->langs->total; ?>:</label>
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
                 <?=$cargo_total;?>AZN
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
<?php endif; ?>
<br />
<h3><?=$this->langs->means_of_communication_with_the_user; ?></h3><br/>
<?php echo '<table border="0" style="border: 1px solid #000;" cellpadding="10">
<tbody>
<tr>
<td><strong>'.$this->langs->order_number.'</strong></td>
<td>:</td>
<td>'.@$order_number.'</td>
</tr>
<tr>
<td><strong>'.$this->langs->fullname.'</strong></td>
<td>:</td>
<td>'.@$user->firstname.' '.@$user->lastname.' '.@$user->middlename.'</td>
</tr>
<tr>
<td><strong>'.$this->langs->email.'</strong></td>
<td>:</td>
<td>'.@$user->email.'</td>
</tr>
<tr>
<td><strong>'.$this->langs->phone.'</strong></td>
<td>:</td>
<td>'.@$address->phone.'</td>
</tr>
<tr>
<td><strong>'.$this->langs->address2.'</strong></td>
<td>:</td>
<td>'.@$address->address.'</td>
</tr>

</tbody>
</table>'; ?>
<?php else: ?>
  <h3><a href="<?=base_url();?>/pages/pdf/<?=$order_number; ?>"><u>#<?=$order_number; ?></u></a> <?=$this->langs->order_is_not_confirmed; ?></h3>
<?php endif; ?>
