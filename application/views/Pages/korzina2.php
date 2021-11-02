<div id="pageHead">
  <span class="ttl"><?=$this->langs->order_confirmation; ?></span>
</div>

<form action="/pages/order" method="post">
  <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div id="contentDiv2">
    <?php  $i=0; $total=0;
      foreach ($verify_basket as $value):
        $total = $total+($value['count']*$value['tsena']);
      endforeach;
      foreach ($verify_basket as $row): $i++;?>
      <div class="row_div">
        <div class="lleft">
          <div class="mehsul row_div_wp">
            <a class="ttitle flex_left" href="/goods/product/<?=$row['p_id']; ?>">
              <img src="/img/products/95x95/<?=$row['img']; ?>">
              <input class="cdisable" type="hidden" name="img[]" value="<?=$row['img']; ?>">
              <span class="spwidth"><?=$row['title']." - ".$row['description']; ?></span>
              <input class="cdisable" type="hidden" name="title[]" value="<?=$row['title']; ?>">
              <input class="cdisable" type="hidden" name="p_id[]" value="<?=$row['p_id']; ?>">
            </a>
          </div>
          <div class="row_div_wp flex_left">
            <span style="margin-right: 5px; font-size: 16px;"><?=$row['count']; ?>
              <span class="yedinicaİzmereniya"><?=$row['mn_title']; ?></span>
            </span>
            <input class="cdisable" type="hidden" name="count[]" value="<?=$row['count']; ?>">
            <input class="cdisable" type="hidden" name="mn_title[]" value="<?=$row['mn_title']; ?>">
          </div>
        </div>
        <div class="rright">
          <div class="row_div_wp flex_right">
            <i class="fa fa-comment-o add_comment" aria-hidden="true"></i>
            <input class="cdisable" type="hidden" name="comment[]" value="">
            <input class="cdisable" type="hidden" name="id[]" value="<?=$row['id']; ?>">
          </div>
          <div class="row_div_wp flex_right">
            <div>
              <div class="tsena2">
                <span><?=number_format($row['tsena'], 2); ?></span> ₼
                <input class="cdisable" type="hidden" name="tsena[]" value="<?= number_format($row['tsena'], 2); ?>">
              </div>
              <div class="summ2">
                <span><?=number_format($row['summ'], 2); ?></span> ₼
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <div class="row_div_wp" style="margin-top: 15px;">
      <span class="butun_qiy">* <?=$this->langs->basket_text; ?>.</span>
      <span class="yekk">
        <i class="fa fa-address-card-o open_add_address" aria-hidden="true"></i>
        <i class="fa fa-comment-o add_total_comment" aria-hidden="true"></i>
        <input class="cdisable" type="hidden" name="total_comment" value="">
        <input class="cdisable" type="hidden" name="address" value="">
        <?=number_format($total, 2); ?> ₼
      </span>
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
          <th width="20%"><?=$this->langs->comment; ?></th>
        </tr>
      </table>
      <div id="tableBodyDiv">
        <table>
          <?php if(isset($verify_basket)): ?>
            <?php  $j=0; $total=0; foreach ($verify_basket as $value):
                                      $total = $total+($value['count']*$value['tsena']);
                                   endforeach;?>
            <?php $i=0; ?>
            <?php foreach ($verify_basket as $row): ?>
              <?php $i++; ?>
              <tr>
                <td width="9%"><?=$i; ?></td>
                <td width="34%" class="mehsul">
                  <a href="/goods/product/<?=$row['p_id']; ?>">
                    <img src="/img/products/95x95/<?=$row['img']; ?>">
                    <span><?=$row['title']." - ".$row['description']; ?></span>
                  </a>
                  <input class="mdisable" type="hidden" name="p_id[]" value="<?=$row['p_id']; ?>">
                  <input class="mdisable" type="hidden" name="img[]" value="<?=$row['img']; ?>">
                </td>
                <td width="20%">
                  <?=$row['count']; ?> <?=$row['mn_title']; ?>
                  <input class="mdisable" type="hidden" name="count[]" value="<?=$row['count']; ?>">
                  <input class="mdisable" type="hidden" name="title[]" value="<?=$row['title']; ?>">
                  <input class="mdisable" type="hidden" name="mn_title[]" value="<?=$row['mn_title']; ?>">
                </td>
                <td width="10%" class="tsena">
                  <?=$row['tsena']; ?> ₼
                  <input class="mdisable" type="hidden" name="price[]" value="<?=$row['tsena']; ?>">
                </td>
                <td width="7%" class="summ"><?=$row['summ']; ?> ₼</td>
                <td width="20%">
                  <input class="mdisable sherh" type="text" placeholder="<?=$this->langs->enter_a_commnet_to_this_product; ?>" name="comment[]">
                  <input class="mdisable" type="hidden" name="id[]" value="<?=$row['id']; ?>">
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif;?>
        </table>
      </div>
    </div>

    <table class="yekun">
       <tr>
         <td width="43%">* <?=$this->langs->basket_text; ?>.</td>
         <td width="10%" class="yekunQiymet"><?php echo isset($verify_basket)?$total:0; ?> ₼</td>
         <td width="20%">
           <input type="text" class="sherh2 mdisable" placeholder="<?=$this->langs->address; ?>" name="address">
         </td>
         <td width="27%">
           <input type="text" class="sherh2 mdisable" placeholder="<?=$this->langs->enter_a_comment_to_order; ?>" name="total_comment">
         </td>
       </tr>
    </table>
  </div>

  <a href="/pages/index/korzina1" class="backToKorzina1">
    <i class="fa fa-angle-left" aria-hidden="true"></i>
    <?=$this->langs->edit_order; ?>
  </a>
  <button type="submit" class="submitKorzina1" <?php if(!$this->session->userdata("user_id") || !(isset($verify_basket))): echo 'disabled'; endif;?>>
    <?php if(!$this->session->userdata("user_id")): echo $this->langs->login_for_order; else: echo $this->langs->order2; endif;?>
  </button>

</form>

<div class="zanaveska3">
  <div class="flexStyle2">
    <div id="login_form2">
      <span id="title2"><?=$this->langs->write_a_comment; ?></span>
      <span id="close3">x</span>
      <textarea placeholder="<?=$this->langs->write_a_comment; ?>"></textarea>
      <div style="position: relative; float: left; width: calc(100% - 40px); margin: 0px 20px 10px 20px;">
        <button class="imtina" type="button"><?=$this->langs->cancel; ?></button>
        <button class="yadda_saxla" type="button"><?=$this->langs->save2; ?></button>
      </div>
    </div>
  </div>
</div>

<div class="add_address">
  <div class="flexStyle2">
    <div id="add_address_form">
      <span id="add_address_title"><?=$this->langs->address; ?></span>
      <span id="add_address_close">x</span>
      <textarea placeholder="<?=$this->langs->address; ?>"></textarea>
      <div style="position: relative; float: left; width: calc(100% - 40px); margin: 0px 20px 10px 20px;">
        <button class="imtina" type="button"><?=$this->langs->cancel; ?></button>
        <button class="yadda_saxla" type="button"><?=$this->langs->save2; ?></button>
      </div>
    </div>
  </div>
</div>
