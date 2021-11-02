<div class="tableHead">

  <div class="m-open">
    <span style="width: 31%" class="td_span"><?=$this->langs->document_name; ?></span>
    <span style="width: 37%" class="td_span"><?=$this->langs->date; ?></span>
    <span style="width: 32%" class="td_span"><?=$this->langs->status; ?></span>
  </div>

  <table class="documentsTable">
    <th width="4%">#
      <i class="fa fa-chevron-down" aria-hidden="true"></i>
    </th>
    <th width="13%"><?=$this->langs->document_name; ?></th>
    <th width="9%"><?=$this->langs->order; ?></th>
    <th width="15%"><?=$this->langs->date; ?></th>
    <th width="10%" style="padding-left: 10px;"><?=$this->langs->contract_number; ?></th>
    <th width="10%"><?=$this->langs->time_of_delivery; ?></th>
    <th width="37%" style="padding-left: calc(18.5% - 120px);"><?=$this->langs->status; ?></th>
  </table>
</div>
<div class="tableBody documentTableBody">
  <div class="m-open">
    <?php foreach($orders_list as $row): ?>
      <div class="m_border_bottom">
        <div class="m_line">
          <span class="m_qaime <?=($row->order_status_id==10 || $row->order_status_id==16 || $row->order_status_id==17 || $row->order_status_id==14)?'seriy':'number2 qaime_click'; ?>" name="<?=($row->order_status_id==10 || $row->order_status_id==16 || $row->order_status_id==17)?'':$row->order_number; ?>">
            <?php if($row->order_status_id==10 || $row->order_status_id==16 || $row->order_status_id==17 || $row->order_status_id==14)
                    echo '---';
                  else
                    echo $this->langs->check." #".$row->order_number;
            ?>
          </span>
          <span class="mq_date"><?=$row->date_time; ?></span>
          <span class="mq_status_i forStatusFirst <?php
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
              <span class="mq_close"><?php
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
              ?></span>
          </span>
          <div class="m_open_sub">
            <i class="fa fa-angle-down" aria-hidden="true"></i>
          </div>
        </div>
        <div class="m_line open_close">
          <span class="m_qaime"><?=$row->contract?('<a style="text-decoration:none; color: inherit" target="_blank" href="'.($row->pdf_path?$row->pdf_path:'#').'"><u>M#'.$row->contract.'</u></a>'):'---'; ?></span>
          <span class="mq_date"><?=$row->delivery_time?$row->delivery_time:'---'; ?></span>
          <span class="mq_status">
            <a
              href="/pages/index/orders?add=<?=$row->order_number?>#id<?=$row->order_number; ?>"
              style="text-decoration: none; color: inherit"
              class="number2"
            >
              <u>#<?=$row->order_number; ?></u>
            </a>
          </span>
        </div>
        <div class="m_line flex_center">
          <span class="m_qaime">
            <?php if(!($row->order_status_id==10 || $row->order_status_id==16 || $row->order_status_id==17 || $row->order_status_id==14)): ?>
              <a style="text-decoration: none; color: inherit" target="_blank" href="/pages/qaime_pdf/<?=$row->order_number; ?>" class="fileType">pdf</a>
            <?php endif; ?>
          </span>
          <div class="forStatus">
            <span
                class="forStatusThird <?php
                  if($row->order_status_id!=10):
                    echo 'disableCancel';
                  elseif(strtotime(date('Y-m-d', strtotime($row->date_time.'+ 1 days'))." ".$reject_period) < strtotime(date('Y-m-d H:i:s'))):
                    echo 'disableCancel';
                  endif;
                ?>"
              >
                <a
                  href="<?php if($row->order_status_id!=10):
                                echo '#';
                              elseif(strtotime(date('Y-m-d', strtotime($row->date_time.'+ 1 days'))." ".$reject_period) < strtotime(date('Y-m-d H:i:s'))):
                                echo '#';
                              else:
                                echo '/pages/cancel_document/'.$row->order_number; endif;?>"
                  class="<?php if($row->order_status_id!=10): echo '';
                               elseif(strtotime(date('Y-m-d', strtotime($row->date_time.'+ 1 days'))." ".$reject_period) < strtotime(date('Y-m-d H:i:s'))): echo '';
                               else: echo 'cancel_confirmation';
                               endif; ?>"
                  style="text-decoration: none; color: inherit"
                >
                  <button <?php
                    if($row->order_status_id!=10)
                      echo 'disabled';
                    else if(strtotime(date('Y-m-d', strtotime($row->date_time.'+ 1 days'))." ".$reject_period) < strtotime(date('Y-m-d H:i:s')))
                      echo 'disabled';
                    ?>
                    type="button"
                    style="border: none; outline: none; background: none;"
                  >
                    <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    <?=$this->langs->cancel; ?>
                  </button>
                </a>
              </span>
          </div>
          <button <?php
            if($row->order_status_id!=10)
              echo 'disabled';
            ?>
            class="comment2"
            name="<?=$row->order_number; ?>"
          >
            <i class="fa fa-comment-o" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    <?php endforeach;?>
  </div>



  <table class="documentsTable">
    <?php $i=0; ?>
    <?php foreach($orders_list as $row): ?>
      <?php $i++; ?>
      <tr>
        <td width="4%"><?=$i; ?></td>
        <td width="13%">
          <span class="<?=($row->order_status_id==10 || $row->order_status_id==16 || $row->order_status_id==17 || $row->order_status_id==14)?'seriy':'number2 qaime_click'; ?>" name="<?=($row->order_status_id==10 || $row->order_status_id==16 || $row->order_status_id==17 || $row->order_status_id==14)?'':$row->order_number; ?>">
            <?=($row->order_status_id==10 || $row->order_status_id==16 || $row->order_status_id==17 || $row->order_status_id==14)?'---':($this->langs->check." #".$row->order_number); ?>
          </span>
          <?php if(!($row->order_status_id==10 || $row->order_status_id==16 || $row->order_status_id==17 || $row->order_status_id==14)): ?>
            <a style="text-decoration: none; color: inherit" target="_blank" href="/pages/qaime_pdf/<?=$row->order_number; ?>" class="fileType">pdf</a>
          <?php endif; ?>
        </td>
        <td width="9%">
          <a
            href="/pages/index/orders?add=<?=$row->order_number?>#id<?=$row->order_number; ?>"
            style="text-decoration: none; color: inherit"
            class="number2"
            >
            <u>#<?=$row->order_number; ?></u>
          </a>
        </td>
        <td width="15%"><?=$row->date_time; ?></td>
        <td width="10%" style="padding-left: 10px"><?=$row->contract?('<a style="text-decoration:none; color: inherit" target="_blank" href="'.($row->pdf_path?$row->pdf_path:'#').'"><u>#'.$row->contract.'</u></a>'):'---'; ?></td>
        <td width="10%"><?=$row->delivery_time?$row->delivery_time:'---'; ?></td>
        <td width="37%">
          <div class="flexStatus">
            <div class="forStatus">
              <table>
                <th width="60%" class="forStatusFirst <?php
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
                </th>
                <?php $b=0; ?>
                <?php if($b): ?>
                  <!-- <th width="30%" class="forStatusSecond <?php if($row->order_status_id!=12): echo 'tesdiq_gozleyen2'; endif;?>">
                    <a style="text-decoration: none; color: inherit" href="<?php echo $row->order_status_id!=12?'#':'/pages/confirm_document/'.$row->order_number; ?>">
                      <button <?php if($row->order_status_id!=12): echo 'disabled'; endif;?> type="button" name="button">
                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                        <?=$this->langs->confirm2; ?>
                      </button>
                    </a>
                  </th> -->
                <?php endif; ?>
                <th
                  width="40%"
                  class="forStatusThird <?php
                    if($row->order_status_id!=10):
                      echo 'disableCancel';
                    elseif(strtotime(date('Y-m-d', strtotime($row->date_time.'+ 1 days'))." ".$reject_period) < strtotime(date('Y-m-d H:i:s'))):
                      echo 'disableCancel';
                    endif;
                  ?>"
                >
                  <a
                    href="<?php if($row->order_status_id!=10):
                                  echo '#';
                                elseif(strtotime(date('Y-m-d', strtotime($row->date_time.'+ 1 days'))." ".$reject_period) < strtotime(date('Y-m-d H:i:s'))):
                                  echo '#';
                                else:
                                  echo '/pages/cancel_document/'.$row->order_number; endif;?>"
                    class="<?php if($row->order_status_id!=10): echo '';
                                 elseif(strtotime(date('Y-m-d', strtotime($row->date_time.'+ 1 days'))." ".$reject_period) < strtotime(date('Y-m-d H:i:s'))): echo '';
                                 else: echo 'cancel_confirmation';
                                 endif; ?>"
                    style="text-decoration: none; color: inherit"
                  >
                    <button <?php
                      if($row->order_status_id!=10)
                        echo 'disabled';
                      else if(strtotime(date('Y-m-d', strtotime($row->date_time.'+ 1 days'))." ".$reject_period) < strtotime(date('Y-m-d H:i:s')))
                        echo 'disabled';
                      ?>
                      type="button"
                      style="border: none; outline: none; background: none;"
                    >
                      <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                      <?=$this->langs->cancel; ?>
                    </button>
                  </a>
                </th>
              </table>
            </div>
            <button <?php
              if($row->order_status_id!=10)
                echo 'disabled';
              ?>
              class="comment2"
              name="<?=$row->order_number; ?>"
            >
              <i class="fa fa-comment-o" aria-hidden="true"></i>
            </button>
          </div>
        </td>
      </tr>
    <?php endforeach;?>
  </table>
</div>
