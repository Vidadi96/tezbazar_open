<!--Basket start-->
<?php $total=0; foreach ($in_basket as $key => $value):
$total = $total+($value["ex_price"]*$value["count"]);
endforeach; ?>
<div class="flyout-cart-wrapper" id="flyout-cart">
  <a href="/profile/cart/" class="cart-trigger"><span class="cart-qty">(<?=$in_basket?count($in_basket):0;?>)</span><span class="cart-label"><?=mb_strtolower($this->langs->products);?></span><span class="cart-ttl">- <?=$total;?>  AZN</span></a>
  <div class="flyout-cart">
    <div class="mini-shopping-cart">
      <div class="count">
        <a href="/profile/cart/"><?=$total;?> <?=mb_strtolower($this->langs->products);?></a>
      </div>
      <div class="items">
          <?php $total_price=0;  foreach ($in_basket as $key => $value) {
            $total_price = $total_price+$value["ex_price"];
        echo '<div class="item first">
                  <div class="picture">
                      <a href="/office/product/'.$value["product_id"].'">
                          <img alt="'.$value["title"].'" src="/img/products/95x95/'.$value["img"].'" title="'.$value["title"].'" />
                      </a>
                  </div>
              <div class="product">
                  <div class="name">
                      <a href="/office/product/'.$value["product_id"].'">'.$value["title"].'</a>
                  </div>
                  <div class="price"><label>'.$value["count"].'</label> <span>x</span> <strong>'.$value["ex_price"].' AZN</strong></div>
              </div>
          </div>';
            }?>
      </div>
      <?php if($total){?>
      <div class="totals"><?=$this->langs->total;?>: <strong><?=$total;?> AZN</strong></div>
        <div class="buttons">
          <input type="button" value="<?=$this->langs->go_to_cart;?>" class="button-1 cart-button" onclick="setLocation('/profile/cart/')" />
        </div>
        <?php } ?>
      </div>

  </div>
</div>
<!--Basket END-->
