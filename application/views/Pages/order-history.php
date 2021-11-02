<div class="tableHead">
  <div class="m-open">
    <span style="width: 31%" class="td_span"><?=$this->langs->order; ?></span>
    <span style="width: 32%" class="td_span"><?=$this->langs->check; ?></span>
    <span style="width: 37%" class="td_span"><?=$this->langs->date; ?></span>
  </div>

  <table class="orderHistoryTable">
    <th width="4%">#
      <i class="fa fa-chevron-down" aria-hidden="true"></i>
    </th>
    <th width="26%"><?=$this->langs->order; ?></th>
    <th width="18%"><?=$this->langs->check; ?></th>
    <th width="16%"><?=$this->langs->contract_number; ?></th>
    <th width="18%"><?=$this->langs->delivery_date2; ?></th>
    <th width="18%"><?=$this->langs->date; ?></th>
  </table>
</div>
<div class="tableBody documentTableBody">
  <div class="m-open">
    <?php $i=0; foreach($history_list as $row): $i++;?>
      <div class="m_border_bottom">
        <div class="m_line">
          <span class="m_qaime sifarish_number">
            <i class="fa fa-circle" aria-hidden="true" style="position: relative; top: -1px; font-size: 9px; margin-right: 5px; color: <?=$row->order_status_id==15?'#1EBE71':'#FF013E'; ?>"></i>
            #<?=$row->order_number; ?>
          </span>
          <?php if($row->order_status_id == 15): ?>
            <span class="mq_status qaime_click" name="<?=$row->order_number; ?>">Qaimə #<?=$row->order_number; ?></span>
          <?php else: ?>
            <span class="mq_status">---</span>
          <?php endif; ?>
          <span class="mq_date_i"><?=$row->date_time; ?></span>
          <div class="m_open_sub">
            <i class="fa fa-angle-down" aria-hidden="true"></i>
          </div>
        </div>
        <div class="m_line open_close">
          <span class="m_qaime">
            <span class="quantity"><?=$row->count; ?> <?=$this->langs->product; ?></span>
            <a style="text-decoration: none; color: inherit" class="fileType" href="/pages/pdf/<?=$row->order_number; ?>" target="_blank">pdf</a>
          </span>
          <span class="mq_status">
            <?php if($row->order_status_id == 15): ?>
              <a style="text-decoration: none; color: inherit" target="_blank" href="/pages/qaime_pdf/<?=$row->order_number; ?>" class="fileType">pdf</a>
            <?php else: ?>
              <span class="mq_status">---</span>
            <?php endif; ?>
          </span>
          <span class="mq_date" style="font-size: 13px;"><?=$row->delivery_date?$row->delivery_date:'---'; ?></span>
        </div>
        <?php if($row->contract): ?>
          <div class="m_line open_close">
            <span class="m_qaime">
              <span>
                <a style="text-decoration:none; color: inherit" target="_blank" href="<?=$row->pdf_path?$row->pdf_path:'#'; ?>'">
                  <u><?='M#'.$row->contract; ?></u>
                </a>
              </span>
            </span>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <table class="orderHistoryTable">
    <?php $i=0; foreach($history_list as $row): $i++;?>
      <tr>
        <td width="4%"><?=$i; ?></td>
        <td width="26%">
          <i class="fa fa-circle" aria-hidden="true" style="position: relative; top: -1px; font-size: 10px; margin-right: 5px; color: <?=$row->order_status_id==15?'#1EBE71':'#FF013E'; ?>"></i>
          <span class="number2 sifarish_number">#<?=$row->order_number; ?></span>
          <span class="quantity"><?=$row->count; ?> <?=$this->langs->product; ?></span>
          <a style="text-decoration: none; color: inherit" class="fileType" href="/pages/pdf/<?=$row->order_number; ?>" target="_blank">pdf</a>
        </td>
        <!-- <td width="23%">
          <span style="cursor: pointer" class="number2 proposal">#<?=$row->order_number; ?></span>
          <a style="text-decoration: none; color: inherit" class="fileType" href="/pages/proposal_pdf/<?=$row->order_number;?>" target="_blank">pdf</a>
        </td> -->
        <td width="18%">
          <?php if($row->order_status_id == 15): ?>
            <span class="number2 qaime_click" name="<?=$row->order_number; ?>">Qaimə #<?=$row->order_number; ?></span>
            <a style="text-decoration: none; color: inherit" target="_blank" href="/pages/qaime_pdf/<?=$row->order_number; ?>" class="fileType">pdf</a>
          <?php else: echo '---'; endif; ?>
        </td>
        <td width="16%"><?=$row->contract?('<a style="text-decoration:none; color: inherit" target="_blank" href="'.($row->pdf_path?$row->pdf_path:'#').'"><u>#'.$row->contract.'</u></a>'):'---'; ?></td>
        <td width="18%">
          <div class="historyflexStatus">
            <span><?=$row->delivery_date?$row->delivery_date:'---'; ?></span>
          </div>
        </td>
        <td width="18%">
          <div class="historyflexStatus">
            <span><?=$row->date_time; ?></span>
          </div>
        </td>
      </tr>
    <?php endforeach;?>
  </table>
</div>
