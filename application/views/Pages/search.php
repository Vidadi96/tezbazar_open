<div class="white_background">
  <span id="productsTitle"><?=$this->langs->seaching_results; ?></span>
</div>

<?php if($products): ?>
<div id="productLine">
  <?php foreach($products as $row): ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
      <div class="product">
        <?php if($row->as_new): ?>
          <?php
            $today = date("Y-m-d H:i:s");
            $end_date = $row->as_new_end_date;
            $start_date = $row->as_new_start_date;
            if($end_date>$today && $start_date<$today){
           ?>
            <span class="new">
              <i class="fa fa-circle" aria-hidden="true"></i>
              <?=$this->langs->new; ?>
            </span>
          <?php }?>
        <?php endif; ?>
        <a href="/goods/product/<?=$row->p_id; ?>">
          <div class="flexStyle_universal">
            <img src="/img/products/415xauto/<?=$row->img;?>">
          </div>
          <div class="productStyle">
            <div style="position: relative; float: left; width:100%">
              <span class="productName"><?=$row->title." - ".$row->description; ?></span>
              <div class="productPrice">
                <?php //if($row->discount): ?>
                  <!-- <span class="oldPrice"><?=number_format($row->ex_price, 2);?> <span>₼</span></span>
                  <span class="newPrice"><?=number_format(((float)$row->ex_price*(100 - (float)$row->discount))/100, 2); ?> <span>₼</span></span> -->
                <?php //else:?>
                    <span class="newPrice"><?=number_format($row->ex_price, 2); ?> <span>₼</span></span>
                <?php //endif;?>
              </div>
            </div>
          </div>
        </a>
        <form action="/profile/add_basket" method="post">
          <input type="hidden" name="product_id" value="<?=$row->p_id; ?>">
          <input type="hidden" name="color_id" value="<?=$row->color_id; ?>">
          <input type="hidden" name="mn_id" value="<?=$row->mn_id; ?>">
          <button type="submit" class="korzina"></button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php else: ?>
  <h3><?=$this->langs->nothing_found; ?></h3>
<?php endif; ?>
<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

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
