<div class="item-box">

    <div class="product-item" data-productid="<?=$p_id;?>">
        <div class="picture">
            <a class="prod" href="/office/product/<?=$p_id;?>" title="" style="background: url(/img/products/415x415/<?=$img;?>) no-repeat;">
              <img alt="<?=$title;?>" src="/img/products/415x415/transparent.png" />
            </a>
        </div>
        <?php




         if($as_new ){
           $as_new_start_date = date("d-m-Y", strtotime($as_new_start_date));
           $as_new_end_date = date("d-m-Y", strtotime($as_new_end_date));
           $current_date = date("d-m-Y");
           if (($current_date >= $as_new_start_date) && ($current_date <= $as_new_end_date)){ ?>
        <a href="/office/product/<?=$p_id;?>" class="ribbon-position top-right" data-productribbonid="1" data-productid="60" tabindex="-1">
          <div class="product-ribbon" style="background: #f6f6f6; padding: 5px 15px; top: 15px;">
            <label class="ribbon-text" style="font-size: 13px; font-weight: bold; color: #f74258; text-shadow: none;"><?=$this->langs->new;?></label>
          </div>
        </a>
        <?php }}

        if($discount || $discount_id){ ?>
        <a href="/office/product/<?=$p_id;?>" class="ribbon-position top-left" data-productribbonid="2" data-productid="60" tabindex="-1">
          <div class="product-ribbon" style="background: #f74258; padding: 5px 15px; top: 15px;">
            <label class="ribbon-text" style="font-size: 13px; font-weight: bold; color: #fff; text-shadow: none;">-<?=$discount?$discount:$discount_left;?>%</label>
          </div>
        </a>
        <?php } ?>
        <div class="details">
            <div class="product-rating-box" title="0 Осврт(и)">
                <div class="rating">
                    <div style="width: 0%"></div>
                </div>
            </div>
            <div class="attribute-squares-wrapper"></div>
            <h2 class="product-title">
                <a href="/office/product/<?=$p_id;?>"><?=$title;?></a>
            </h2>
            <div class="sku">
                <?=$sku;?>
            </div>
            <div class="add-info">
                <div class="prices">
                    <span class="price actual-price"><?=(($discount || $discount_id)?($ex_price-($ex_price*($discount?$discount:$discount_left)/100)):$ex_price);?> AZN</span>
                    <?=($discount || $discount_id)?'<span class="price old-price">'.$ex_price.' AZN</span>':'';?>
                </div>
                <div class="description">
                </div>
                <div class="buttons-upper">
                    <!-- <input type="button" value="Додади листа за споредување" title="Add to compare list" class="button-2 add-to-compare-list-button" onclick="AjaxCart.addproducttocomparelist('/office/add_compare/<?=$p_id;?>');return false;" /> -->
                    <input type="button" value="+ Add to favorite list" title="+ Add to favorite list" class="button-2 add-to-wishlist-button add_wishlist" onclick="AjaxCart.addproducttocart_single(<?=$p_id;?>, <?=$color_id?$color_id:0;?>, <?=$mn_id?$mn_id:0;?>,1, 9);return false;"  rel="<?=$p_id;?>"/>
                </div>
                <div class="buttons-lower">
                    <button type="button" class="button-2 product-box-add-to-cart-button" onclick="AjaxCart.addproducttocart_single(<?=$p_id;?>, <?=$color_id?$color_id:0;?>, <?=$mn_id?$mn_id:0;?>,1,8);return false;"><span>+ <?=$this->langs->add_to_basket;?></span></button>

                </div>
            </div>
        </div>
    </div>
</div>
