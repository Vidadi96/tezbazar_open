<div id="statistika_page">
  <span id="pageName"><?=$this->langs->statistics; ?></span>
  <div id="upSide">
    <div class="filter_line">
      <div class="datePickerDiv">
        <i class="fa fa-calendar filter_button_statistics" aria-hidden="true" style="cursor: pointer"></i>
        <!-- Datepicker as text field -->
        <div id="datePicker1" class="input-group date" data-date-format="yyyy-mm-dd">
          <input type="text" class="form-control datePickerInput date_start" placeholder="yyyy-mm-dd" value="<?=$date_start; ?>">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
        <span>-</span>
        <div id="datePicker2" class="input-group date" data-date-format="yyyy-mm-dd">
          <input  type="text" class="form-control datePickerInput date_end" placeholder="yyyy-mm-dd" value="<?=$date_end; ?>">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
      </div>
    </div>
    <div class="filter_line">
      <select class="filter_select">
        <option value="2" <?=$statistic_type=='product'?'selected':''; ?>><?=$this->langs->by_products; ?></option>
        <option value="1" <?=$statistic_type=='check'?'selected':''; ?>><?=$this->langs->by_check; ?></option>
      </select>
    </div>
    <?php if($admin):
      if(isset($site_users)): ?>
        <div class="filter_line">
          <select class="filter_select2">
            <option value=""></option>
            <?php foreach ($site_users as $row): ?>
              <option <?=isset($buyer)?($row->user_id == $buyer?'selected':''):''; ?> value="<?=$row->user_id; ?>"><?=$row->company_name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endif;
    endif;?>
    <div class="filter_line mr-top15">
      <a href="/pages/index/statistika<?=$admin?'?admin=1':''; ?>" style="text-decoration: none; color: inherit" class="upSideSpan">
        <i class="fa fa-reply" aria-hidden="true"></i>
        <span class="mobile_close"><?=$this->langs->back; ?></span>
      </a>
      <span class="upSideSpan excel_click_statistics">
        <i class="fa fa-upload" aria-hidden="true"></i>
        <span class="mobile_close"><?=$this->langs->export; ?></span>
      </span>
      <form style="position: relative; float: right; margin-bottom: 0px;" action="/pages/statistics_pdf2" method="get">
        <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="date_start" value="<?=$date_start; ?>">
        <input type="hidden" name="date_end" value="<?=$date_end; ?>">
        <input type="hidden" name="ord_type" value="<?=$ord_type; ?>">
        <input type="hidden" name="ord_name" value="<?=$ord_name; ?>">
        <input type="hidden" name="type" value="<?=$type; ?>">
        <input type="hidden" name="admin" value="<?=$admin; ?>">
        <button style="outline: none" type="submit" class="upSideSpan">
          <i class="fa fa-print" aria-hidden="true"></i>
          <span class="mobile_close"><?=$this->langs->printt; ?></span>
        </button>
      </form>
    </div>
    <?php $i_want = false; if($i_want): ?>
      <span class="upSideSpan send_mail_statistics">
        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
        <?=$this->langs->send_to_mail; ?>
      </span>
    <?php endif; ?>
  </div>

<?php if($statistic_type == 'product'): ?>

  <div class="tableMainDiv" id="with_products">
    <table class="orderTable productTable">
      <tr>
        <?php $up_down=$ord_type=="asc"?'down':'up'; ?>
        <th width="9%" name="num" class="<?=$ord_name=='num'?$ord_type:''; ?>">#
          <?=$ord_name=='num'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
        <th width="35%" name="title" class="<?=$ord_name=='title'?$ord_type:''; ?>">
          <?=$this->langs->product; ?>
          <?=$ord_name=='title'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
        <th width="14%"><?=$this->langs->price; ?></th>
        <th width="14%" name="count" class="<?=$ord_name=='count'?$ord_type:''; ?>">
          <?=$this->langs->bought_times; ?>
          <?=$ord_name=='count'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
        <th width="14%" name="sum_count" class="<?=$ord_name=='sum_count'?$ord_type:''; ?>">
          <?=$this->langs->count; ?>
          <?=$ord_name=='sum_count'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
        <th colspan="2" width="14%" name="price" class="<?=$ord_name=='price'?$ord_type:''; ?>">
          <?=$this->langs->total; ?>
          <?=$ord_name=='price'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
      </tr>
      <?php $i=0; foreach($statistic_products as $row): $i++; ?>
        <tr class="product_id_<?=$row->product_id; ?>">
          <td width="8%"><?=$i; ?></td>
          <td colspan="2" class="image_and_name" width="50%">
            <img src="/img/products/95x95/<?=$row->img; ?>">
            <span><?=$row->title.' - '.$row->description; ?></span>
          </td>
          <td width="14%"><?=$row->count; ?></td>
          <td width="14%"><?=$row->sum_count; ?></td>
          <td width="12%"><?=$row->price; ?> azn</td>
          <td width="2%" class="open_product_list" name="<?=$i; ?>">
            <i class="fa fa-angle-down" aria-hidden="true" name="<?=$row->product_id; ?>"></i>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

<?php else: ?>

  <div class="tableMainDiv" id="with_check">
    <table class="orderTable orderTable2">
      <tr>
        <?php $up_down=$ord_type=="asc"?'down':'up'; ?>
        <th width="10%" name="num" class="<?=$ord_name=='num'?$ord_type:''; ?>">#
          <?=$ord_name=='num'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
        <th width="16%" name="order_number" class="<?=$ord_name=='order_number'?$ord_type:''; ?>">
          <?=$this->langs->check; ?> #
          <?=$ord_name=='order_number'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
        <th width="17%" name="contract_number" class="<?=$ord_name=='contract_number'?$ord_type:''; ?>">
          <?=$this->langs->contract_number; ?> #
          <?=$ord_name=='contract_number'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
        <th width="33%" name="date_time" colspan="2" class="<?=$ord_name=='date_time'?$ord_type:''; ?>">
          <?=$this->langs->date2; ?>
          <?=$ord_name=='date_time'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
        <th colspan="2" width="24%" name="price" class="<?=$ord_name=='price'?$ord_type:''; ?>">
          <?=$this->langs->price; ?>
          <?=$ord_name=='price'?'<i class="fa fa-chevron-'.$up_down.'" aria-hidden="true"></i>':''; ?>
        </th>
      </tr>
        <?php $i=0; foreach($statistic_checks as $row): $i++; ?>
          <tr class="order_number_<?=$row->order_number; ?>">
            <td width="10%"><?=$i; ?></td>
            <td width="16%">
              <a style="text-decoration: none; color: inherit" target="_blank" href="/pages/qaime_pdf/<?=$row->order_number; ?>">
                <u>#<?=$row->order_number; ?></u>
              </a>
            </td>
            <td width="17%">
              <a style="text-decoration: none; color: inherit" target="_blank" href="<?=$row->pdf_path?$row->pdf_path:'#'; ?>">
                <u>#<?=$row->contract_number; ?></u>
              </a>
            </td>
            <td width="33%" colspan="2"><?=$row->date_time; ?></td>
            <td width="22%"><?=$row->price; ?> azn</td>
            <td width="2%" class="open_cheque_list" name="<?=$i; ?>">
              <i class="fa fa-angle-down" aria-hidden="true" name="<?=$row->order_number; ?>"></i>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>

<?php endif; ?>

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

</div>

<input type="hidden" name="page_name" value="statistics">
<input type="hidden" name="statistics_type" value="<?=$type; ?>">
