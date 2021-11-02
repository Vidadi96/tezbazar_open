<div class="popup_table">
<table class="cart">
    <thead>
        <tr class="cart-header-row">
            <th>
          <span class="item-count">#</span>
      </th>
                <th class="product-picture">
                    <?=$this->langs->img;?>
                </th>
            <th class="product">
                <?=$this->langs->products;?>
            </th>
            <th class="unit-price">
                <?=$this->langs->price;?>
            </th>
            <th class="quantity">
                <?=$this->langs->quantity;?>
            </th>
            <th class="subtotal">
                <?=$this->langs->total;?>
            </th>
        </tr>
    </thead>
    <tbody>
      <?php $total=0; foreach ($orders as $value): $total = $total+($value["count"]*$value["ex_price"]); ?>
      <tr class="cart-item-row">
          <td>
            <span class="item-count"><?=$value["count"];?></span>
          </td>
          <td class="product-picture">
              <a href="/office/product/<?=$value["id"];?>"><img width="40" alt="<?=$value["title"];?>" src="/img/products/95x95/<?=$value["img"];?>" title="<?=$value["title"];?>" /></a>
          </td>
          <td class="product">
            <a href="/office/product/<?=$value["id"];?>" class="product-name"><?=$value["title"];?></a>
          </td>
          <td class="unit-price">
              <span class="product-unit-price"><?=$value["ex_price"];?></span>
          </td>
          <td class="quantity">
              <?=$value["count"];?>
          </td>
          <td class="subtotal">
              <span class="product-subtotal"><?=$value["count"]*$value["ex_price"];?> AZN</span>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
</table>
</div>
