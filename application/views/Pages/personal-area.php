<?php if(isset($_SESSION['error'])) {?>
  <div class="alert alert-danger"><?=$_SESSION['error']; ?></div>
<?php }?>
<?php if(isset($_SESSION['success'])) {?>
  <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
<?php }?>

<section>
  <div id="head">
    <a href="/pages/index/orders" class="<?php if($title=='orders'){ echo 'activeHeadSpan';}?> headSpan">
      <i class="fa fa-list-alt" aria-hidden="true"></i>
      <span class="m-hide"><?=$this->langs->orders; ?></span>
    </a>
    <a href="/pages/index/documents" class="<?php if($title=='documents'){ echo 'activeHeadSpan';}?> headSpan">
      <i class="fa fa-file-text-o" aria-hidden="true"></i>
      <span class="m-hide"><?=$this->langs->documents; ?></span>
    </a>
    <a href="/pages/index/order-history" class="<?php if($title=='order-history'){ echo 'activeHeadSpan';}?> headSpan">
      <i class="fa fa-clock-o" aria-hidden="true"></i>
      <span class="m-hide"><?=$this->langs->history; ?></span>
    </a>
    <div class="rightHead">
      <?php if($title=='orders'){ ?>
        <div class="m-100">
          <div class="new_order_div">
            <a href='/goods/new_order' id="newOrder">
              <i class="fa fa-plus" aria-hidden="true"></i>
              <?=$this->langs->new_order; ?>
            </a>
          </div>
        </div>
      <?php }?>
      <div class="m-100">
        <div class="headArea">
          <i
            style="cursor: pointer"
            class="fa fa-calendar
                   <?php if($title=='orders')
                          echo 'orders';
                         else if($title=='documents')
                          echo 'documents';
                         else
                          echo 'order_history';
                   ?>_date"
             aria-hidden="true"
          ></i>
          <!-- Datepicker as text field -->
          <div id="datePicker1" class="input-group date" data-date-format="yyyy-mm-dd">
            <input  type="text" class="form-control datePickerInput date_start" placeholder="yyyy-mm-dd" value="<?=$search_params['date_start']; ?>">
            <div class="input-group-addon">
              <span class="glyphicon glyphicon-th"></span>
            </div>
          </div>
          <span>-</span>
          <div id="datePicker2" class="input-group date" data-date-format="yyyy-mm-dd">
            <input  type="text" class="form-control datePickerInput date_end" placeholder="yyyy-mm-dd"  value="<?=$search_params['date_end']; ?>">
            <div class="input-group-addon" >
              <span class="glyphicon glyphicon-th"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="m-100">
        <div class="headArea">
          <input type="text" placeholder="<?=$this->langs->search; ?>" id="headAreaSearchInput" class="search_param"  value="<?=$search_params['search']; ?>"/>
          <i class="fa fa-search <?php if($title=='orders')
                                          echo 'orders';
                                        else if($title=='documents')
                                          echo 'documents';
                                        else
                                          echo 'order_history';
                                  ?>_search" aria-hidden="true" id="headAreaSearchIcon"></i>
        </div>
      </div>
    </div>
  </div>
  <?php if($title=='orders')
          echo $orders;
        else if($title=='documents')
          echo $documents;
        else
          echo $orderHistory;
  ?>
</section>

<div class="m-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="text-center">
         <ul class="pagination pagination-lg text-center" style="display: inline-flex;">
            <?=@$pagination;?>
         </ul>
      </div>
    </div>
  </div>
</div>

<div class="qaime">
  <i class="fa fa-times close_qaime" aria-hidden="true"></i>
 <div class="a4">
   <div class="head">
     <span class="order_number"><u>-</u></span>
     <div class="logo"></div>
   </div>
   <span class="user_name">-</span>
   <table>
     <thead>
       <tr>
         <th width="5%">#</th>
         <th width="35%" class="insert_after"><?=$this->langs->name; ?></th>
         <th width="15%"><?=$this->langs->count; ?></th>
         <th width="15%"><?=$this->langs->price; ?></th>
         <th width="15%" class="teklif_change"><?=$this->langs->sum; ?></th>
       </tr>
     </thead>
     <tbody>

     </tbody>
   </table>
   <div class="qaime_discount">
     <div class="row discount_show">
       <b><span><?=$this->langs->discount_percentage; ?>: </span></b>
       <span class="discount"></span>
     </div>
     <div class="row">
       <b><span><?=$this->langs->total2; ?>: </span></b>
       <span class="new_total"></span>
     </div>
   </div>
   <div class="tehvil_aldi_verdi">
     <span>Təhvil verdi ______________</span>
     <span>Təhvil aldı ______________</span>
   </div>
 </div>
 <table>
   <tr>
     <td class="sifarish_time"><?=$this->langs->date2; ?>: - </td>
     <td></td>
   </tr>
 </table>
</div>
<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">



<div class="zanaveska3">
  <div class="flexStyle2">
    <div id="login_form2">
      <span id="title2"><?=$this->langs->write_a_comment; ?></span>
      <span id="close3">x</span>
      <textarea placeholder="<?=$this->langs->cancel_comment; ?>"></textarea>
      <div style="position: relative; float: left; width: calc(100% - 64px); margin: 0px 32px 24px 32px;">
        <button class="imtina" type="button"><?=$this->langs->cancel; ?></button>
        <button class="yadda_saxla" type="button"><?=$this->langs->save2; ?></button>
      </div>
    </div>
  </div>
</div>
