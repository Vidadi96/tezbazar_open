<div id="statistika_page">
  <span id="pageName"><?=$this->langs->statistics; ?></span>
  <div id="upSide">
    <div class="filter_line">
      <div class="datePickerDiv">
        <i class="fa fa-calendar filter_button" aria-hidden="true" style="cursor: pointer"></i>
        <!-- Datepicker as text field -->
        <div id="datePicker1" class="input-group date" data-date-format="yyyy-mm-dd">
          <input  type="text" class="form-control datePickerInput date_start" placeholder="yyyy-mm-dd">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
        <span>-</span>
        <div id="datePicker2" class="input-group date" data-date-format="yyyy-mm-dd">
          <input  type="text" class="form-control datePickerInput date_end" placeholder="yyyy-mm-dd">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
      </div>
    </div>
    <?php if($admin):
      if(isset($site_users)): ?>
        <div class="filter_line">
          <select class="filter_select3">
            <option value=""></option>
            <?php foreach ($site_users as $row): ?>
              <option value="<?=$row->user_id; ?>"><?=$row->company_name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endif;
    endif;?>
    <div class="filter_line mr-top15">
      <a href="/pages/index/statistics<?=$admin?'?admin=1':''; ?>" style="text-decoration: none; color: inherit" class="upSideSpan">
        <i class="fa fa-share" aria-hidden="true"></i>
        <span class="mobile_close"><?=$this->langs->more_details; ?></span>
      </a>
      <span class="upSideSpan excel_click">
        <i class="fa fa-upload" aria-hidden="true"></i>
        <span class="mobile_close"><?=$this->langs->export; ?></span>
      </span>
      <form style="position: relative; float: right; margin-bottom: 0px;" action="/pages/statistics_pdf" method="get">
        <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="date_start">
        <input type="hidden" name="date_end">
        <input type="hidden" name="admin" value="<?=$admin; ?>">
        <button style="outline: none" type="submit" class="upSideSpan">
          <i class="fa fa-print" aria-hidden="true"></i>
          <span class="mobile_close"><?=$this->langs->printt; ?></span>
        </button>
      </form>
    </div>
    <?php $i_want = false; if($i_want): ?>
      <span class="upSideSpan send_mail">
        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
        <?=$this->langs->send_to_mail; ?>
      </span>
    <?php endif; ?>
  </div>

  <div id="downLeftSide2">
    <div>
      <span><?=$this->langs->total_waste; ?></span>
      <span class="total_price">---</span>
    </div>
    <div>
      <span><?=$this->langs->number_of_purchases; ?></span>
      <span class="success_order_count">--</span>
    </div>
    <div>
      <span><?=$this->langs->waiting_a_proposal; ?></span>
      <span class="waiting_proposal">--</span>
    </div>
    <div>
      <span><?=$this->langs->pending_confirmation2; ?></span>
      <span class="waiting_confirmation">--</span>
    </div>
    <div>
      <span><?=$this->langs->number_of_refusals; ?></span>
      <span class="cancelled_order_count">--</span>
    </div>
  </div>

  <div id="downLeftSide">
    <div>
      <span><?=$this->langs->total_waste; ?></span>
      <span class="total_price">---</span>
    </div>
    <div>
      <span><?=$this->langs->number_of_purchases; ?></span>
      <span class="success_order_count">--</span>
    </div>
    <div>
      <span><?=$this->langs->waiting_a_proposal; ?></span>
      <span class="waiting_proposal">--</span>
    </div>
    <div>
      <span><?=$this->langs->pending_confirmation2; ?></span>
      <span class="waiting_confirmation">--</span>
    </div>
    <div>
      <span><?=$this->langs->number_of_refusals; ?></span>
      <span class="cancelled_order_count">--</span>
    </div>
  </div>
  <div id="downRightSide">
    <div id="open_close_left_side">
      <i class="fa fa-chevron-right" aria-hidden="true"></i>
    </div>
    <div class="centerSide">
      <div id="chart1">
        <canvas id="myChart1"></canvas>
      </div>
    </div>
    <div class="category_row_main">
    </div>
    <div  class="centerSide mpadding">
      <div id="chart2">
        <canvas id="myChart2"></canvas>
      </div>
    </div>
  </div>
</div>
