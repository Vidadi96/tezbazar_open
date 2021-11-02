<style media="screen">
  td, th{
    border: 1px solid #000;
  }
</style>

<h2><?=$this->langs->statistics; ?></h2>
<br>

<h3><?=$this->langs->by_category; ?></h3>
<br>

<table cellspaceing="0" cellpadding="10">
  <thead>
    <tr>
      <th><?=$this->langs->category_name; ?></th>
      <th><?=$this->langs->waste; ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($first_diagram as $row): ?>
      <tr>
        <td><?=$row->name; ?></td>
        <td><?=$row->price; ?> azn</td>
      </tr>
    <?php endforeach; ?>
  </tbody>
 </table>

 <br>
 <h3><?=$this->langs->by_date; ?></h3>
 <br>

 <table cellspaceing="0" cellpadding="10">
  <thead>
    <tr>
     <th><?=$this->langs->month; ?></th>
     <th><?=$this->langs->waste; ?></th>
   </tr>
 </thead>
 <tbody>
   <?php $total = 0; foreach ($second_diagram as $row): $total = $total + $row->price; ?>
     <tr>
       <td><?=$row->date_time; ?></td>
       <td><?=$row->price; ?> azn</td>
     </tr>
   <?php endforeach; ?>
 </tbody>
</table>

<h3><?=$this->langs->total; ?></h3>
<br>

<table cellspaceing="0" cellpadding="10">
 <thead>
   <tr>
    <th><?=$this->langs->total_waste; ?></th>
    <th><?=$this->langs->number_of_purchases; ?></th>
    <th><?=$this->langs->waiting_a_proposal; ?></th>
    <th><?=$this->langs->pending_confirmation; ?></th>
    <th><?=$this->langs->number_of_refusals; ?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td><?=$total; ?> azn</td>
    <td><?=$success_order_count; ?></td>
    <td><?=$waiting_proposal; ?></td>
    <td><?=$waiting_confirmation; ?></td>
    <td><?=$cancelled_order_count; ?></td>
  </tr>
</tbody>
</table>
