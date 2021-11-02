<div id="pageHead">
  <span class="ttl"><?=$this->langs->basket; ?></span>
  <span><?=$this->langs->select_unselect_all; ?></span>
</div>

<form action="/pages/done_basket" method="post">
<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div id="contentDiv2">
  <?php  $i=0; $total=0;
    foreach ($basket_data as $value):
      $total = $total+($value->count*$value->ex_price);
    endforeach;
    foreach ($basket_data as $row): $i++;?>
    <div class="row_div">
      <div class="lleft">
        <div class="mehsul row_div_wp">
          <a class="ttitle flex_left" href="/goods/product/<?=$row->product_id; ?>">
            <img src="/img/products/95x95/<?=$row->img; ?>">
            <input class="cdisable" type="hidden" name="img[]" value="<?=$row->img; ?>">
            <span class="spwidth"><?=$row->title." - ".$row->description; ?></span>
            <input class="cdisable" type="hidden" name="title[]" value="<?=$row->title; ?>">
            <input class="cdisable" type="hidden" name="description[]" value="<?=$row->description; ?>">
            <input class="cdisable" type="hidden" name="product_id[]" value="<?=$row->product_id; ?>">
          </a>
        </div>
        <div class="row_div_wp flex_left">
          <div class="flexDiv">
            <div class="quantityDiv">
              <span class="minus">-</span>
              <input type="text" class="cdisable kolichestvo" data="<?=$row->product_id; ?>" name="count[]" value="<?=$row->count; ?>" />
              <span class="plus" name="<?=$row->product_id; ?>">+</span>
            </div>
            <span class="yedinicaİzmereniya"><?php
              if($row->mn_title)
                echo $row->mn_title;
              else
                echo $default_measure;
            ?></span>
            <input class="cdisable" type="hidden" name="mn_title[]" value="<?php
              if($row->mn_title)
                echo $row->mn_title;
              else
                echo $default_measure;
            ?>">
          </div>
        </div>
      </div>
      <div class="rright">
        <div class="row_div_wp flex_right">
          <a class="ttrash" href="/pages/delete_item/<?=$row->id; ?>">
            <i class="fa fa-trash-o"></i>
          </a>
          <input class="cdisable" type="hidden" name="id[]" value="<?=$row->id; ?>">
          <input class="cdisable checkbox" type="checkbox" name="<?=md5($row->id); ?>" checked="true">
        </div>
        <div class="row_div_wp flex_right">
          <div>
            <div class="tsena2">
              <span><?=number_format($row->ex_price, 2); ?></span> ₼
              <input class="cdisable" type="hidden" name="tsena[]" value="<?= number_format($row->ex_price, 2); ?>">
            </div>
            <div class="summ2">
              <span><?=number_format($row->ex_price*$row->count, 2); ?></span> ₼
              <input class="cdisable" type="hidden" name="summ[]" value="<?= number_format($row->ex_price*$row->count, 2); ?>">
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  <div class="row_div_wp" style="margin-top: 15px;">
    <span class="butun_qiy">* <?=$this->langs->basket_text; ?>.</span>
    <div class="">
      <span class="yekk yekunQiymet2"><span><?=number_format($total, 2); ?></span>  ₼</span>
    </div>
  </div>
</div>

<div class="scrollTable">
  <div id="contentDiv">
    <table class="headerTable">
      <tr>
        <th width="9%">#
          <i class="fa fa-angle-down" aria-hidden="true"></i>
        </th>
        <th width="34%"><?=$this->langs->product; ?></th>
        <th width="20%"><?=$this->langs->count; ?></th>
        <th width="10%"><?=$this->langs->price; ?> *</th>
        <th width="7%"><?=$this->langs->sum; ?></th>
        <th width="12%" class="seredina"><?=$this->langs->delete2; ?></th>
        <th width="8%"><?=$this->langs->select2; ?></th>
      </tr>
    </table>
    <div id="tableBodyDiv">
      <table>
          <?php  $i=0; $total=0; foreach ($basket_data as $value):
                                    $total = $total+($value->count*$value->ex_price);
                                 endforeach;?>
          <?php foreach ($basket_data as $row): ?>
            <?php $i++;?>
            <tr>
              <td width="9%"><?=$i; ?></td>
              <td width="34%" class="mehsul">
                <a href="/goods/product/<?=$row->product_id; ?>">
                  <img src="/img/products/95x95/<?=$row->img; ?>">
                  <input class="mdisable" type="hidden" name="img[]" value="<?=$row->img; ?>">
                  <span><?=$row->title." - ".$row->description; ?></span>
                  <input class="mdisable" type="hidden" name="title[]" value="<?=$row->title; ?>">
                  <input class="mdisable" type="hidden" name="description[]" value="<?=$row->description; ?>">
                  <input class="mdisable" type="hidden" name="product_id[]" value="<?=$row->product_id; ?>">
                </a>
              </td>
              <td width="20%">
                <div class="flexDiv">
                  <div class="quantityDiv">
                    <span class="minus">-</span>
                    <input type="text" class="mdisable kolichestvo" data="<?=$row->product_id; ?>" name="count[]" value="<?=$row->count; ?>">
                    <span class="plus" name="<?=$row->product_id; ?>">+</span>
                  </div>
                  <span class="yedinicaİzmereniya"><?php
                    if($row->mn_title)
                      echo $row->mn_title;
                    else
                      echo $default_measure;
                  ?></span>
                  <input class="mdisable" type="hidden" name="mn_title[]" value="<?php
                    if($row->mn_title)
                      echo $row->mn_title;
                    else
                      echo $default_measure;
                  ?>">
                </div>
              </td>
              <td width="10%" class="tsena"><span><?=number_format($row->ex_price, 2); ?></span> ₼
                <input class="mdisable" type="hidden" name="tsena[]" value="<?= number_format($row->ex_price, 2); ?>">
              </td>
              <td width="7%" class="summ"><span><?=number_format($row->ex_price*$row->count, 2); ?></span> ₼
                <input class="mdisable" type="hidden" name="summ[]" value="<?= number_format($row->ex_price*$row->count, 2); ?>">
              </td>
              <td width="12%" class="seredina silmek">
                <a href="/pages/delete_item/<?=$row->id; ?>">
                  <i class="fa fa-trash-o"></i>
                </a>
                <input class="mdisable" type="hidden" name="id[]" value="<?=$row->id; ?>">
              </td>
              <td width="8%" class="seredina">
                <input class="mdisable checkbox" type="checkbox" name="<?=md5($row->id); ?>" checked="true">
              </td>
            </tr>
          <?php endforeach; ?>
      </table>
    </div>
  </div>

  <table class="yekun">
     <tr>
       <td width="63%">* <?=$this->langs->basket_text; ?>.</td>
       <td width="27%" class="yekunQiymet"><span><?=number_format($total, 2); ?></span> ₼</td>
       <td width="10%">
       </td>
     </tr>
  </table>
</div>

<button type="submit" class="submitKorzina1"><?=$this->langs->resume; ?></button>

</form>
