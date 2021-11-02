<div class=master-wrapper-content>
    <div class=ajaxCartInfo data-getajaxcartbuttonurl=/NopAjaxCart/GetAjaxCartButtonsAjax data-productpageaddtocartbuttonselector=input.add-to-cart-button data-productboxaddtocartbuttonselector=button.product-box-add-to-cart-button data-productboxproductitemelementselector=.product-item data-enableonproductpage=True data-enableoncatalogpages=True data-minishoppingcartquatityformattingresource=({0}) data-miniwishlistquatityformattingresource=({0}) data-addtowishlistbuttonselector=input.add-to-wishlist-button></div>
    <input id=addProductVariantToCartUrl name=addProductVariantToCartUrl type=hidden value=/AddProductFromProductDetailsPageToCartAjax>
    <input id=addProductToCartUrl name=addProductToCartUrl type=hidden value=/AddProductToCartAjax>
    <input id=miniShoppingCartUrl name=miniShoppingCartUrl type=hidden value=/MiniShoppingCart>
    <input id=flyoutShoppingCartUrl name=flyoutShoppingCartUrl type=hidden value=/NopAjaxCartFlyoutShoppingCart>
    <input id=checkProductAttributesUrl name=checkProductAttributesUrl type=hidden value=/CheckIfProductOrItsAssociatedProductsHasAttributes>
    <input id=getMiniProductDetailsViewUrl name=getMiniProductDetailsViewUrl type=hidden value=/GetMiniProductDetailsView>
    <input id=flyoutShoppingCartPanelSelector name=flyoutShoppingCartPanelSelector type=hidden value=#flyout-cart>
    <input id=shoppingCartMenuLinkSelector name=shoppingCartMenuLinkSelector type=hidden value=span.cart-qty>
    <input id=wishlistMenuLinkSelector name=wishlistMenuLinkSelector type=hidden value=span.wishlist-qty>
    <div id=product-ribbon-info data-productid=0 data-productboxselector=".product-item, .item-holder" data-productboxpicturecontainerselector=".picture, .item-picture" data-productpagepicturesparentcontainerselector=.product-essential data-productpagebugpicturecontainerselector=.picture data-retrieveproductribbonsurl=/RetrieveProductRibbons></div>
    <div class=quickViewData data-productselector=.product-item data-productselectorchild=.buttons-upper data-retrievequickviewurl=/quickviewdata data-quickviewbuttontext="Quick View" data-quickviewbuttontitle="Quick View" data-isquickviewpopupdraggable=True data-enablequickviewpopupoverlay=True data-accordionpanelsheightstyle=content data-getquickviewbuttonroute=/getquickviewbutton></div>
    <input type=hidden id=theme-active-preset data-colorpreset="f74258, 00a1b1">
    <div class=master-column-wrapper>
        <div class=center-1>
            <div class="page checkout-page shipping-method-page">
                <div class=order-progress>
                    <ul>
                        <li class=active-step><a href=/cart>Cart</a>
                            <li class=active-step><a href=/checkout/billingaddress>Address</a>
                                <li class=active-step><a href=/checkout/shippingmethod>Shipping</a>
                                    <li class=inactive-step><a>Payment</a>
                                        <li class=inactive-step><a>Confirm</a>
                                            <li class=inactive-step><a>Complete</a></ul>
                </div>
                <div class=page-title>
                    <h1>Select shipping method</h1></div>
                <div class="page-body checkout-data">
                    <div class="section shipping-method">
                        <form method=post action=/checkout/shippingmethod>
                            <label class="city" for="city">Şəhər</label>
                            <select name="city">
                              <?php foreach ($shipping as $value) {
                                echo '<option value="'.$value->region_id.'">'.$value->name.'</option>';
                              }
                              ?>
                            </select>
                            <br />
                            <br />
                            <br />
                            <div class=buttons>
                                <input type=submit name=nextstep value=Next class="button-1 shipping-method-next-step-button">
                            </div>
                            <input name=__RequestVerificationToken type=hidden value=CfDJ8NZg2KnAJF9Eg3XOYr6E1gZxBFn6BGQX-5xS-go6_9bdaECGCfGAqua7oTqj7irLDloRJqXtYNCeCiLqJEAK2ahF2fURX7E7gO7j6g6P6WZ8-9kmz3AdAz_G5Ncz1IFRJb94vmpDZf1BkOq8rJgBtwU>
                        </form>
                    </div>
                    <div class="section order-summary">
                       <div class=title><strong>Order summary</strong></div>
                       <div class=order-summary-content>
                          <form method=post enctype=multipart/form-data id=shopping-cart-form action=/cart>




                            <table class="cart">
                                <colgroup>
                                    <col width="1" />
                                        <col width="1" />
                                                                <col width="1" />
                                                                <col width="1" />
                                    <col />
                                    <col width="1" />
                                    <col width="1" />
                                    <col width="1" />
                                </colgroup>
                                <thead>
                                    <tr class="cart-header-row">
                                         <th class="sku" data-hide="w410, w480, w580, w768, w980">
                                            SKU
                                         </th>
                                         <th class="product-picture">
                                            <?=$this->langs->img;?>
                                        </th>
                                        <th class="product" data-hide="w410, w480">
                                            <?=$this->langs->products;?>
                                        </th>
                                        <th class="unit-price" data-hide="w410, w480, w580, w768">
                                            <?=$this->langs->price;?>
                                        </th>
                                        <th class="quantity" data-hide="w410, w480, w580, w768">
                                            <?=$this->langs->quantity;?>
                                        </th>
                                        <th class="subtotal">
                                            <?=$this->langs->total;?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $total=0; foreach ($in_basket as $value): $total = $total+($value["count"]*$value["ex_price"]); ?>
                                  <tr class="cart-item-row">

                                      <td class="sku">
                                          <?=$value["sku"];?>
                                      </td>
                                      <td class="product-picture">
                                          <a href="/office/product/<?=$value["id"];?>"><img alt="<?=$value["title"];?>" src="/img/products/95x95/<?=$value["img"];?>" title="<?=$value["title"];?>" /></a>
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
                      <div class="cart-options">

                      </div>
                        <div class="cart-footer">
                            <div class="totals">
                                <div class="total-info">
                                  <?php $cargo_total = 0.0; $vat_total = 0.0; ?>
                <table class="cart-total">
                    <tbody>
                        <tr class="order-subtotal">
                            <td class="cart-total-left">
                                <label><?=$this->langs->total;?>:</label>
                            </td>
                            <td class="cart-total-right">
                                <span class="value-summary"><?=$total;?> AZN</span>
                            </td>
                        </tr>
                                        <tr class="shipping-cost">
                                <td class="cart-total-left">
                                    <label><?=$this->langs->cargo;?>:</label>
                                </td>
                                <td class="cart-total-right">
                                        <span><?=$cargo_total;?> AZN</span>
                                </td>
                            </tr>
                                                    <tr class="tax-rate">
                                <td class="cart-total-left">
                                    <label><?=$this->langs->vat;?> 0%:</label>
                                </td>
                                <td class="cart-total-right">
                                    <span><?=$vat_total;?> AZN</span>
                                </td>
                            </tr>
                                                                        <tr class="order-total">
                            <td class="cart-total-left">
                                <label><?=$this->langs->sum_total;?>:</label>
                            </td>
                            <td class="cart-total-right">
                                    <span><?=($total+$cargo_total+($total*$vat_total/100));?> AZN</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>




                            </div>
                        </div>

                             <input name=__RequestVerificationToken type=hidden value=CfDJ8NZg2KnAJF9Eg3XOYr6E1gboS7gOAt-1bWUEBSz6hrNJgWopqMHlybvjEjb86HNKjmQbGbUOKV5SCZi8JLAFbQj2F4D8C-o-760e2CYmXAGXiIobMPR_h-XDJCEJN7JavoYbk31mYIQ6eftGhjtsjVk>
                          </form>
                       </div>
                </div>
            </div>
        </div>
    </div>
</div>
