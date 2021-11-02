<style media="screen">
  td, th{
    border: 1px solid #000;
  }
</style>

<h2><?=$this->langs->statistics; ?></h2>
<br>

<?php if($statistic_type == 'check'): ?>

<h3><?=$this->langs->by_check; ?></h3>
<br>

<table cellspaceing="0" cellpadding="10">
  <thead>
    <tr>
      <th width="10%">#</th>
      <th width="33%"><?=$this->langs->check; ?> #</th>
      <th width="33%"><?=$this->langs->date2; ?></th>
      <th width="24%"><?=$this->langs->price; ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $i=0; foreach($statistic_checks as $row): $i++; ?>
      <tr>
        <td width="10%"><?=$i; ?></td>
        <td width="33%">
          <a style="text-decoration: none; color: inherit" target="_blank" href="/pages/qaime_pdf/<?=$row->order_number; ?>">
            <u>#<?=$row->order_number; ?></u>
          </a>
        </td>
        <td width="33%"><?=$row->date_time; ?></td>
        <td width="24%"><?=$row->price; ?> azn</td>
      </tr>
    <?php endforeach; ?>
  </tbody>
 </table>

<?php elseif($statistic_type == 'product'): ?>

 <h3><?=$this->langs->by_products; ?></h3>
 <br>

 <table class="orderTable">
   <tr>
     <th width="6%">#
       <i class="fa fa-chevron-down" aria-hidden="true"></i>
     </th>
     <th width="52%"><?=$this->langs->product; ?></th>
     <th width="14%"><?=$this->langs->bought_times; ?></th>
     <th width="14%"><?=$this->langs->count; ?></th>
     <th width="14%"><?=$this->langs->total; ?></th>
   </tr>
   <?php $i=0; foreach($statistic_products as $row): $i++;
      $data = $this->PagesModel->get_opening_list($row->product_id, $date_start, $date_end);
   ?>
     <tr>
       <td><?=$i; ?></td>
       <td>
         <div style="position: relative; float: left; display: flex; align-items: center">
           <img src="<?=base_url(); ?>/img/products/95x95/<?=$row->img; ?>" width="40px" height="40px">
           <span><?=$row->title.' - '.$row->description; ?></span>
         </div>
       </td>
       <td><?=$row->count; ?></td>
       <td><?=$row->sum_count; ?></td>
       <td><?=$row->price; ?> azn</td>
       <td>
         <i class="fa fa-angle-down" aria-hidden="true"></i>
       </td>
     </tr>
     <?php $j=0; foreach($data as $raw): $j++; ?>
       <tr style="background: #F5F5F5">
        <td><?=$i.".".$j; ?></td>
        <td><?=$raw->date_time; ?></td>
        <td><?=$raw->ex_price; ?> azn</td>
        <td><?=$raw->count; ?></td>
        <td width="14%" colspan="2"><?=number_format($raw->ex_price*$raw->count, 2); ?> azn</td>
      </tr>
   <?php endforeach;
           endforeach; ?>
</table>

<?php endif; ?>
