<div class="tableHead">
  <table class="orderTable m_close">
    <th width="4%" class="number_th">#
      <i class="fa fa-chevron-down" aria-hidden="true"></i>
    </th>
    <th width="33%" class="order_number_th"><?=$this->langs->order; ?></th>
    <th width="22%" class="date_th"><?=$this->langs->date; ?></th>
    <th width="13%"><?=$this->langs->edit; ?></th>
    <th width="21%"><?=$this->langs->status; ?></th>
    <th width="7%"><?=$this->langs->order_again; ?></th>
  </table>

  <table class="orderTable m_open">
    <th width="31%"><?=$this->langs->order; ?></th>
    <th width="39%"><?=$this->langs->date; ?></th>
    <th width="30%"><?=$this->langs->order_again; ?></th>
  </table>
</div>
<div class="tableBody orderTableBody">
  <div class="m-open">
    <?php $i=0; foreach($orders_list as $row): $i++; ?>
      <div class="m_border_bottom">
        <div class="id<?=$row->order_number; ?> m_line">
          <span class="m_order_number">
            <span class="forStatusFirst <?php
              if($row->order_status_id == 10)
                echo 'teklif_hazirlanir';
              else if($row->order_status_id == 12)
                echo 'tesdiq_gozleyen';
              else if($row->order_status_id == 16)
                echo 'imtina_gozleyen';
              else if($row->order_status_id == 17 || $row->order_status_id == 14)
                echo 'imtina_olunmus';
            ?>">
              <i class="fa fa-circle" aria-hidden="true"></i>
            </span>
            <span class="sifarish_number">#<?=$row->order_number; ?></span>
          </span>
          <span class="m_date"><?=$row->date_time; ?></span>
          <span class="m_order_again">
            <a style="color: #8A928E;" href="/pages/order_again/<?=$row->order_number; ?>" class="again_order order_again_confirmation">
              <i class="fa fa-refresh" aria-hidden="true"></i>
            </a>
          </span>
          <div class="m_open_sub">
            <i class="fa fa-angle-down" aria-hidden="true"></i>
          </div>
        </div>
        <div class="m_line open_close">
          <span class="m_count_pdf" style="width: 70%">
            <?=$row->count; ?> <?=$this->langs->product; ?>
            <a class="fileType" href="/pages/pdf/<?=$row->order_number; ?>" target="_blank">pdf</a>
          </span>
          <span style="width: 27%" class="flex_justify_center">
            <?php if($row->order_status_id == 10): ?>
              <a href="/pages/index/edit_order/<?=$row->order_number; ?>" target="_blank" style="padding: 2px 3px; font-size: 15px;" class="btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only">
                <i class="fa fa-pencil"></i>
              </a>
            <?php else: ?>
              ---
            <?php endif; ?>
          </span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <table class="orderTable">
    <?php $i=0; ?>
    <?php foreach($orders_list as $row): ?>
      <?php $i++; ?>
      <tr class="id<?=$row->order_number; ?>">
        <td width="4%"><?=$i; ?></td>
        <td width="33%">
          <span class="sifarish_number">#<?=$row->order_number; ?></span>
          <span class="quantity"><?=$row->count; ?> <?=$this->langs->product; ?></span>
          <a class="fileType" href="/pages/pdf/<?=$row->order_number; ?>" target="_blank">pdf</a>
        </td>
        <td width="22%"><?=$row->date_time; ?></td>
        <td width="13%">
           <?php if($row->order_status_id == 10): ?>
             <a href="/pages/index/edit_order/<?=$row->order_number; ?>" target="_blank" style="padding: 2px 3px; font-size: 15px;" class="btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only">
               <i class="fa fa-pencil"></i>
             </a>
           <?php else: ?>
             ---
           <?php endif; ?>
        </td>
        <td width="21%" class="forStatusFirst <?php
          if($row->order_status_id == 10)
            echo 'teklif_hazirlanir';
          else if($row->order_status_id == 12)
            echo 'tesdiq_gozleyen';
          else if($row->order_status_id == 16)
            echo 'imtina_gozleyen';
          else if($row->order_status_id == 17 || $row->order_status_id == 14)
            echo 'imtina_olunmus';
        ?>">
          <i class="fa fa-circle" aria-hidden="true"></i>
          <?php
            if($row->order_status_id == 10)
              echo $this->langs->prepairing_a_cheque;
            else if($row->order_status_id == 12)
              echo $this->langs->delivery;
            else if($row->order_status_id == 15)
              echo $this->langs->completed;
            else if($row->order_status_id == 16)
              echo $this->langs->pending_cancellation;
            else if($row->order_status_id == 17 || $row->order_status_id == 14)
              echo $this->langs->cancelled;
          ?>
        </td>
        <td width="7%">
          <a style="color: #8A928E;" href="/pages/order_again/<?=$row->order_number; ?>" class="again_order order_again_confirmation">
            <i class="fa fa-refresh" aria-hidden="true"></i>
          </a>
        </td>
        <?php $prosto = 0; if($prosto): ?>
        <!-- <td width="19%"><?php
            if($row->order_status_id == 10 || $row->qiymet_teklifi)
              echo '<span style="color: #8A928E">'.$this->langs->performing.'</span>';
            else
              echo '<span class="number proposal">#'.$row->order_number.'</span>
                    <a class="fileType" href="/pages/proposal_pdf/'.$row->order_number.'" target="_blank">pdf</a>';
            ?>
        </td>
        <td width="39%">
          <div class="flexStatus">
            <div class="forStatus">
              <table>
                <th width="45%" class="forStatusFirst <?php
                  if($row->order_status_id == 10)
                  {
                    echo 'teklif_hazirlanir';
                  }
                  else if($row->order_status_id == 11)
                  {
                    echo 'tesdiq_gozleyen';
                  }
                  else if($row->order_status_id == 13)
                  {
                    echo 'imtina_gozleyen';
                  }
                  else if($row->order_status_id == 14)
                  {
                    echo 'imtina_olunmus';
                  }
                ?>">
                  <i class="fa fa-circle<?php if($row->order_status_id==10): echo '-o'; endif;?>" aria-hidden="true"></i>
                  <?php
                    if($row->order_status_id == 10)
                      echo $this->langs->prepairing_a_proposal;
                    else if($row->order_status_id == 11)
                      echo $this->langs->pending_confirmation2;
                    else if($row->order_status_id == 12 || $row->order_status_id == 15 || $row->order_status_id == 16 || $row->order_status_id == 17 || $row->order_status_id == 14)
                      echo $this->langs->confirmed;
                    else if($row->order_status_id == 13)
                      echo $this->langs->pending_cancellation;
                    else if($row->order_status_id == 14)
                      echo $this->langs->cancelled;
                  ?>
                </th>
                <th width="30%" class="forStatusSecond <?php if($row->order_status_id!=11): echo 'tesdiq_gozleyen2'; endif;?>">
                  <a style="text-decoration: none; color: inherit" href="<?php echo $row->order_status_id!=11?'#':'/pages/confirm_order/'.$row->order_number; ?>">
                    <button <?php if($row->order_status_id!=11): echo 'disabled'; endif;?> type="button" name="button">
                      <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                      <?=$this->langs->confirm2; ?>
                    </button>
                  </a>
                </th>
                <th  width="25%" class="forStatusThird <?php if($row->order_status_id!=10): if($row->order_status_id!=11): echo 'disableCancel'; endif; endif;?>">
                  <a
                    href="<?php if($row->order_status_id!=10): if($row->order_status_id!=11): echo '#'; else: echo '/pages/cancel_order/'.$row->order_number; endif; else: echo '/pages/cancel_order/'.$row->order_number; endif;?>"
                    style="text-decoration: none; color: inherit"
                  >
                    <button <?php if($row->order_status_id!=10): if($row->order_status_id!=11): echo 'disabled'; endif; endif;?> type="button" style="border: none; outline: none; background: none;">
                      <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                      <?=$this->langs->cancel; ?>
                    </button>
                  </a>
                </th>
              </table>
            </div>
            <a href="/pages/order_again/<?=$row->order_number; ?>" class="again_order">
              <i class="fa fa-refresh" aria-hidden="true"></i>
              <span class="hover_title"><?=$this->langs->order_again; ?></span>
            </a>
            <button <?php if($row->order_status_id!=11): if($row->order_status_id!=12): echo 'disabled'; endif; endif;?> class="comment2" name="<?=$row->order_number; ?>">
              <i class="fa fa-comment-o" aria-hidden="true"></i>
            </button>
          </div>
        </td> -->
      <?php endif; ?>
      </tr>
    <?php endforeach;?>
  </table>
</div>
