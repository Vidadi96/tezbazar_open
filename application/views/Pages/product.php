<div id="pageDestination">
  <a href="/pages/index/main-page"><?=$this->langs->main_page; ?></a>
  <?php if($cats):?>
    <i class="fa fa-angle-right" aria-hidden="true"></i>
    <a class="category_id" name="<?=$cats[0]->cat_id; ?>" href="/goods/category/<?=$cats[0]->cat_id; ?>"><?=$cats[0]->name; ?></a>
  <?php endif; ?>
  <i class="fa fa-angle-right" aria-hidden="true"></i>
  <span><?=$product->title;?></span>
</div>
<div id="productDiv">

  <div id="leftSliderDiv">
    <div id="sliderContainer">
      <ul class="slides">
        <?php if(@count($thumbs)>0): ?>
          <?php foreach ($thumbs as $value):?>
            <li>
              <div style="background-image: url('/img/products/auto/<?=$value->img;?>')" value="<?=$value->img;?>"></div>
            </li>
          <?php endforeach; ?>
        <?php endif;?>
      </ul>
    </div>
    <i id="prev" class="fa fa-angle-up" aria-hidden="true"></i>
    <i id="next" class="fa fa-angle-down" aria-hidden="true"></i>
  </div>

  <input type="hidden" class="cloudZoomAdjustPictureOnProductAttributeValueChange" data-productid="3444" data-isintegratedbywidget="true">
  <input type="hidden" class="cloudZoomEnableClickToZoom">
  <div class="picture-wrapper">
    <div class="ribbon-wrapper">
      <div class="picture" id="sevenspikes-cloud-zoom" data-zoomwindowelementid="" data-selectoroftheparentelementofthecloudzoomwindow="" data-defaultimagecontainerselector=".product-essential .gallery" data-zoom-window-width="250" data-zoom-window-height="250">
        <a href="<?php if($thumbs): ?>/img/products/auto/<?=$thumbs[0]->img;?>" data-full-image-url="/img/products/auto/<?=$thumbs[0]->img;?><?php endif; ?>" class="picture-link" id="zoom1">
          <img src="<?php if($thumbs): ?>/img/products/415x415/<?=$thumbs[0]->img;?><?php endif; ?>" class="bigPhoto cloudzoom" id="cloudZoomImage" itemprop="image" data-cloudzoom="appendSelector: &#x27;.picture-wrapper&#x27;, zoomPosition: &#x27;inside&#x27;, zoomOffsetX: 0, captionPosition: &#x27;bottom&#x27;, tintOpacity: 0, zoomWidth: 250, zoomHeight: 250, easing: 3, touchStartDelay: true, zoomFlyOut: false, disableZoom: &#x27;auto&#x27;">
        </a>
      </div>
    </div>
  </div>
  <div id="rightSide">
    <span class="title"><?=$product->title;?></span>
    <span class="description"><?=$product->description;?></span>
    <div class="line"></div>
    <div class="priceDiv">
      <?php //if($default_price[0]->discount): ?>
        <!-- <span class="oldPrice"><?//=number_format($default_price[0]->price, 2);?> <span>₼</span></span>
        <span class="price"><?//=number_format(((float)$default_price[0]->price*(100 - (float)$default_price[0]->discount))/100, 2); ?> <span>₼</span></span> -->
      <?php //else:?>
          <span class="price"><?=number_format($default_price[0]->price, 2); ?> <span>₼</span></span>
      <?php //endif;?>
    </div>
    <div style="position: relative; float: left; width: 100%">
      <?php $o_count = isset($ordered_count->count)?$ordered_count->count:0; ?>
      <button class="sebete" <?=$counts->count?((($counts->count - $o_count) > 0)?'':'disabled'):'disable'; ?>>
        <img src="/assets/img/korzina_bez_kruqa_white.png">
        <?=$this->langs->to_basket; ?>
      </button>
    </div>
    <?php $i_want = 0; if($i_want): ?>
      <?php if($color[0]->color_code): ?>
        <div class="colorDiv">
          <span class="colorTitle">Color *</span>
          <?php $c=0; ?>
          <?php  foreach($color as $row): ?>
            <div class="colorBox" style="background: <?=$row->color_code; ?>" name="<?=$row->color_id; ?>"></div>
            <?php $c++; ?>
          <?php endforeach;?>
        </div>
        <div class="SizeDiv">
          <span class="colorTitle">Size *</span>
        </div>
      <?php elseif($sizes[0]->title):?>
        <div class="SizeDiv2">
          <span class="colorTitle">Size *</span>
          <?php foreach($sizes as $row): ?>
            <div class="sizeBox" name="<?=$row->mn_id; ?>"><?=$row->title; ?></div>
          <?php endforeach;?>
        </div>
      <?php endif;?>
    <?php endif;?>
    <?php if($counts->count): ?>
      <div class="countDiv">
        <label for="count" class="countTitle"><?=$this->langs->count; ?> *</label>
        <input type="number" id="count" min="1" max="<?=($counts->count - $o_count); ?>" value="1">
        <span style="margin-left: 5px"><?=$counts->measure; ?></span>
      </div>
    <?php endif;?>
    <input type="hidden" name="<?=$product_id; ?>" id="product_id">
    <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">



    <table>
      <tr>
        <td><?=$this->langs->code_of_product; ?></td>
        <td><?=$product->sku;?></td>
      </tr>
      <?php if($product->brand_name): ?>
        <tr>
          <td><?=$this->langs->brand; ?></td>
          <td><?=$product->brand_name;?></td>
        </tr>
      <?php endif;?>
      <?php foreach($dop_param as $row): ?>
        <tr>
          <td><?=$row->param_title; ?></td>
          <?php if($row->sub_param_title): ?>
            <td><?=$row->sub_param_title; ?></td>
          <?php elseif($row->param_value): ?>
            <td><?=$row->param_value; ?></td>
          <?php else:?>
            <td></td>
          <?php endif; ?>
        </tr>
      <?php endforeach;?>
      <tr>
        <td><?=$this->langs->availability;?></td>
        <td><?=$counts->count?$counts->count:$this->langs->out_of_stock;?></td>
      </tr>
    </table>
  </div>
</div>

<?php if($similar): ?>

<div class="offerDiv">
  <span class="offerSpan"><?=$this->langs->buy_with_this_product; ?></span>
  <div class="grayRightArrow"></div>
  <div class="grayLeftArrow"></div>
</div>

<div id="sliderContainer2">
  <ul class="slides2">
    <?php foreach($similar as $row): ?>
      <li>
        <div>
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
            <span class="flexStyle_universal">
              <img src="/img/products/415xauto/<?=$row->img;?>">
            </span>
            <span style="position: relative; float: left; width:100%; height: 108px">
              <span class="productStyle">
                <span style="position: relative; float: left; width:100%">
                  <span class="productName"><?=$row->title." - ".$row->description; ?></span>
                  <span class="productPrice">
                    <?php //if($row->discount): ?>
                      <!-- <span class="oldPrice"><?=number_format($row->ex_price, 2);?> <span>₼</span></span>
                      <span class="newPrice"><?=number_format(((float)$row->ex_price*(100 - (float)$row->discount))/100, 2); ?> <span>₼</span></span> -->
                    <?php //else:?>
                      <span class="newPrice"><?=number_format($row->ex_price, 2); ?> <span>₼</span></span>
                    <?php //endif;?>
                  </span>
                </span>
              </span>
            </span>
          </a>
          <form action="/profile/add_basket" method="post">
            <input type="hidden" name="product_id" value="<?=$row->p_id; ?>">
            <input type="hidden" name="color_id" value="<?=$row->color_id; ?>">
            <input type="hidden" name="mn_id" value="<?=$row->mn_id; ?>">
            <button type="submit" class="korzina"></button>
          </form>
        </div>
      </li>
    <?php endforeach;?>
  </ul>
</div>

<?php endif; ?>

<input type="hidden" id="def_color_id" name="<?=$default_price[0]->color_id; ?>">
<input type="hidden" id="def_mn_id" name="<?=$default_price[0]->mn_id; ?>">
