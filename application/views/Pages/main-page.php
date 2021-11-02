<?php if(isset($_SESSION['error'])) {?>
  <div class="alert alert-danger"><?=$_SESSION['error']; ?></div>
<?php }?>
<?php if(isset($_SESSION['success'])) {?>
  <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
<?php }?>

<div id="sliderContainer">
  <ul class="slides">
    <?php foreach($main_slide as $row): ?>
      <li>
        <div style="background-image: url('<?=$row->destination; ?>')"></div>
      </li>
    <?php endforeach; ?>
  </ul>
  <div id="slideTitle"><?=$this->langs->constantly_updated_products; ?></div>
  <div id="next">
    <img src="/assets/img/right_arrow.png">
  </div>
  <div id="prev">
    <img src="/assets/img/left_arrow.png">
  </div>
  <span class="hidden slide1_time"><?=$time1; ?></span>
  <span class="hidden slide1_active_passive"><?=$active_passive1; ?></span>
</div>

<div id="dailyProducts">
  <div id="dailyProductsTitle">
    <span><?=$this->langs->products_of_the_day; ?></span>
    <div class="grayRightArrow"></div>
    <div class="grayLeftArrow"></div>
    <span class="hidden daily_products_time"><?=$time4; ?></span>
    <span class="hidden daily_products_active_passive"><?=$active_passive4; ?></span>
  </div>

  <div id="sliderContainer4">
    <ul class="slides4">
      <?php foreach ($main_page_daily_products as $row):?>
        <li>
          <div class="dailyProductsContent">
            <a href="/goods/product/<?=$row->p_id; ?>">
              <img src="/img/products/415xauto/<?=$row->img; ?>">
              <div class="productStyle">
                <div style="position: relative; float: left; width:100%">
                  <div class="dailyProductsName">
                    <span><?=$row->title." - ".$row->description; ?></span>
                    <i style="display: none" class="fa fa-heart-o" aria-hidden="true"></i>
                  </div>
                  <div class="dailyProductsPrice">
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
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<div id="partners" class="popularBrands">
  <span><?=$this->langs->partners; ?></span>
  <div class="blackRightArrow"></div>
  <div class="blackLeftArrow"></div>
</div>

<div id="sliderContainer5" class="sliderContainer2">
  <ul class="slides5">
    <?php foreach($partners_slide as $row):?>
      <li>
        <a href="<?=$row->link; ?>" target="_blank">
          <div style="background-image: url('<?=$row->destination; ?>')"></div>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
  <span class="hidden partners_slide_time"><?=$time3; ?></span>
  <span class="hidden partners_slide_active_passive"><?=$active_passive3; ?></span>
</div>

<div class="line_row2">
  <div id="dailyProducts2">
    <div id="dailyProductsTitle2">
      <span><?=$this->langs->products_of_the_day; ?></span>
      <div class="grayRightArrow"></div>
      <div class="grayLeftArrow"></div>
      <span class="hidden daily_products_time"><?=$time4; ?></span>
      <span class="hidden daily_products_active_passive"><?=$active_passive4; ?></span>
    </div>

    <div id="sliderContainer4_2">
      <ul class="slides4_2">
        <?php foreach ($main_page_daily_products as $row):?>
          <li>
            <div class="dailyProductsContent">
              <a href="/goods/product/<?=$row->p_id; ?>">
                <img src="/img/products/415xauto/<?=$row->img; ?>">
                <div class="productStyle">
                  <div style="position: relative; float: left; width:100%">
                    <div class="dailyProductsName">
                      <span><?=$row->title." - ".$row->description; ?></span>
                      <i style="display: none" class="fa fa-heart-o" aria-hidden="true"></i>
                    </div>
                    <div class="dailyProductsPrice">
                      <span class="newPrice"><?=number_format($row->ex_price, 2); ?> <span>₼</span></span>
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
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>

<div id="kolleksiyalar">
  <div id="kolleksiyaTitle">
    <span><?=$this->langs->collections; ?></span>
    <div class="blackRightArrow"></div>
    <div class="blackLeftArrow"></div>
  </div>

  <div id="sliderContainer3">
    <ul class="slides3">
      <?php foreach($kolleksiyalar as $row): ?>
        <?php if($row->count > 0):?>
          <li>
            <div class="kolleksiyaContent">
              <img <?php if($row->icon): ?>src="/img/icons/90x90/<?=$row->icon; ?>"<?php endif;?> />
              <div class="kolleksiyalarTitle">
                <span><?=$row->name; ?></span>
                <span style="text-transform: lowercase"><?=$row->count; ?> <?=$this->langs->product; ?></span>
              </div>
              <div class="kolleksiyalarContent">
                <span class="newPrice"><?=$row->price; ?> <span>₼</span></span>
                <span class="smallText">-dan</span>
              </div>
              <a href="/goods/category/<?=$row->cat_id; ?>" class="grayRightArrow"></a>
            </div>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<span id="productsTitle"><?=$this->langs->novelty; ?></span>

<div id="productLine">
  <?php foreach($main_page_products as $row): ?>
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

<div id="popularBrands" class="popularBrands">
  <span><?=$this->langs->popular_brands; ?></span>
  <div class="blackRightArrow"></div>
  <div class="blackLeftArrow"></div>
</div>

<div id="sliderContainer2" class="sliderContainer2">
  <ul class="slides2">
    <?php foreach($brands_slide as $row):?>
      <li>
        <div style="background-image: url('<?=$row->destination; ?>')"></div>
      </li>
    <?php endforeach; ?>
  </ul>
  <span class="hidden brands_slide_time"><?=$time2; ?></span>
  <span class="hidden brands_slide_active_passive"><?=$active_passive2; ?></span>
</div>

<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
