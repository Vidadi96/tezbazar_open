<script type="text/javascript">
      AjaxCart.init(false, '.header-links .cart-qty', '.header-links .wishlist-qty', '#flyout-cart');
  </script>
  <div class="overlayOffCanvas"></div>
  <div class="responsive-nav-wrapper-parent">
      <div class="responsive-nav-wrapper">
          <div class="menu-title">
              <span>Menu</span>
          </div>
          <div class="shopping-cart-link">
              <span>Кошничка</span>
          </div>
          <div class="filters-button">
              <span>Filters</span>
          </div>
          <div class="personal-button" id="header-links-opener">
              <span>Personal menu</span>
          </div>
          <div class="preferences-button" id="header-selectors-opener">
              <span>Подесувања</span>
          </div>
          <div class="search-wrap">
              <span>Пребарување</span>
          </div>
      </div>
  </div>
  <div class="master-wrapper-content">





<div class="ajaxCartInfo" data-getAjaxCartButtonUrl="/NopAjaxCart/GetAjaxCartButtonsAjax"
   data-productPageAddToCartButtonSelector=".add-to-cart-button"
   data-productBoxAddToCartButtonSelector="button.product-box-add-to-cart-button"
   data-productBoxProductItemElementSelector=".product-item"
   data-enableOnProductPage="True"
   data-enableOnCatalogPages="True"
   data-miniShoppingCartQuatityFormattingResource="({0})"
   data-miniWishlistQuatityFormattingResource="({0})"
   data-addToWishlistButtonSelector=".add-to-wishlist-button">
</div>

<input id="addProductVariantToCartUrl" name="addProductVariantToCartUrl" type="hidden" value="/AddProductFromProductDetailsPageToCartAjax" />
<input id="addProductToCartUrl" name="addProductToCartUrl" type="hidden" value="/AddProductToCartAjax" />
<input id="miniShoppingCartUrl" name="miniShoppingCartUrl" type="hidden" value="/MiniShoppingCart" />
<input id="flyoutShoppingCartUrl" name="flyoutShoppingCartUrl" type="hidden" value="/NopAjaxCartFlyoutShoppingCart" />
<input id="checkProductAttributesUrl" name="checkProductAttributesUrl" type="hidden" value="/CheckIfProductOrItsAssociatedProductsHasAttributes" />
<input id="getMiniProductDetailsViewUrl" name="getMiniProductDetailsViewUrl" type="hidden" value="/GetMiniProductDetailsView" />
<input id="flyoutShoppingCartPanelSelector" name="flyoutShoppingCartPanelSelector" type="hidden" value="#flyout-cart" />
<input id="shoppingCartMenuLinkSelector" name="shoppingCartMenuLinkSelector" type="hidden" value=".cart-qty" />
<input id="wishlistMenuLinkSelector" name="wishlistMenuLinkSelector" type="hidden" value="span.wishlist-qty" />





<script type="text/javascript">
  var nop_store_directory_root = "https://www.officeplus.mk/";
</script>

<div id="product-ribbon-info" data-productid="0"
   data-productboxselector=".product-item, .item-holder"
   data-productboxpicturecontainerselector=".picture, .item-picture"
   data-productpagepicturesparentcontainerselector=".product-essential"
   data-productpagebugpicturecontainerselector=".picture"
   data-retrieveproductribbonsurl="/ProductRibbons/RetrieveProductRibbons">
</div>



  <div class="quickViewData" data-productselector=".product-item"
       data-productselectorchild=".buttons-upper"
       data-retrievequickviewurl="/quickviewdata"
       data-quickviewbuttontext="Брз преглед"
       data-quickviewbuttontitle="Брз преглед"
       data-isquickviewpopupdraggable="True"
       data-enablequickviewpopupoverlay="True"
       data-accordionpanelsheightstyle="content">
  </div>



<div id="color-squares-info"
   data-retrieve-color-squares-url="/PavilionTheme/RetrieveColorSquares"
   data-product-attribute-change-url="/ShoppingCart/ProductDetails_AttributeChange"
   data-productbox-selector=".product-item"
   data-productbox-container-selector=".attribute-squares-wrapper"
   data-productbox-price-selector=".prices .actual-price">
</div>

      <div class="master-column-wrapper">

<div class="center-1">


<div class="page shopping-cart-page">
  <div class="page-title">
      <h1><?=$this->langs->basket;?></h1>
  </div>
  <div class="page-body">

<div class="order-summary-content">


<form action="/profile/checkout/" enctype="multipart/form-data" id="shopping-cart-form" method="get"><div class="table-wrapper">
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
                          <th class="remove-from-cart" data-hide="w410, w480, w580">
                              <?=$this->langs->remove;?>
                          </th>
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
  
                        <td class="">
                            <a href="/profile/cart/<?=$value["id"];?>" class="delete_btn"><img src="/site/img/delete.png"></img></a>
                        </td>
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
                  <!-- <div class="common-buttons">
                      <input type="submit" value="<?=$this->langs->continue_shopping;?>" class="button-2 continue-shopping-button" />
                  </div> -->
                          </div>
          <div class="cart-footer">

                  <!-- <div class="cart-collaterals">
                                                  <div class="accordion-tab coupon-codes">
                              <div class="accordion-tab-title">
                                  <strong>Код на Попуст</strong>
                              </div>
                              <div class="accordion-tab-content">
                                      <div class="coupon-box">
      <div class="title">
          <strong>Код на Попуст</strong>
      </div>
      <div class="hint">
          Внесете го Вашиот купон тука
      </div>
      <div class="coupon-code">
          <input name="discountcouponcode" id="discountcouponcode" type="text" class="discount-coupon-code" />
          <input type="submit" name="applydiscountcouponcode" id="applydiscountcouponcode"
                 value="Примени купон" class="button-2 apply-discount-coupon-code-button" />
      </div>
          </div>
  <script type="text/javascript">
      $(document).ready(function () {
          $('#discountcouponcode').keydown(function (event) {
              if (event.keyCode == 13) {
                  $('#applydiscountcouponcode').click();
                  return false;
              }
          });
      });
  </script>

                              </div>
                          </div>
                                                  <div class="accordion-tab gift-cards">
                              <div class="accordion-tab-title">
                                  <strong>Подарок Картички</strong>
                              </div>
                              <div class="accordion-tab-content">
                                      <div class="giftcard-box">
      <div class="title">
          <strong>Подарок Картички</strong>
      </div>
      <div class="hint">Внесете код за подарок картичката</div>
      <div class="coupon-code">
          <input name="giftcardcouponcode" id="giftcardcouponcode" type="text" class="gift-card-coupon-code" />
          <input type="submit" name="applygiftcardcouponcode" id="applygiftcardcouponcode"
                 value="Додај поклон картичка" class="button-2 apply-gift-card-coupon-code-button" />
      </div>
  </div>
  <script type="text/javascript">
      $(document).ready(function () {
          $('#giftcardcouponcode').keydown(function (event) {
              if (event.keyCode == 13) {
                  $('#applygiftcardcouponcode').click();
                  return false;
              }
          });
      });
  </script>

                              </div>
                          </div>


                  </div> -->
              <div class="totals">
                  <div class="total-info">
                    <?php $cargo_total = 0.0; $total_without_vat = $total-($total*18/100); $vat_total = $total*18/100; ?>
  <table class="cart-total">
      <tbody>
          <tr class="order-subtotal">
              <td class="cart-total-left">
                  <label><?=$this->langs->total;?>:</label>
              </td>
              <td class="cart-total-right">
                  <span class="value-summary"><?=$total_without_vat;?> AZN</span>
              </td>
          </tr>
                          <!-- <tr class="shipping-cost">
                  <td class="cart-total-left">
                      <label><?=$this->langs->cargo;?>:</label>
                  </td>
                  <td class="cart-total-right">
                          <span><?=$cargo_total;?> AZN</span>
                  </td>
              </tr> -->
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
                      <span><?=($total_without_vat+$cargo_total+$vat_total);?> AZN</span>
              </td>
          </tr>
      </tbody>
  </table>
</div>

                                              <div id="terms-of-service-warning-box" title="<?=$this->langs->term_conditions;?>" style="display:none;">
                              <p><?=$this->langs->terms_accept;?></p>
                          </div>
                          <div class="terms-of-service">
                              <div>
                                  <input class="check_term" value="1" id="termsofservice" type="checkbox" name="termsofservice" />
                              <label for="termsofservice"><?=$this->langs->terms_agree;?></label>
                              <a class="read" id="read-terms">(<?=$this->langs->read;?>)</a>
                <script>
                   $(document).ready(function() {
                      $(".check_term").change(function(){

                        if($(this).is(':checked'))
                        {
                          //console.log(1)
                          $(".checkout_btn").prop('disabled', false);
                          $(".checkout_btn").removeClass('disabled');
                        }else {
                          //console.log(0)
                          $(".checkout_btn").addClass('disabled');
                          $(".checkout_btn").prop('disabled', true);
                        }
                      });

                       $('#read-terms').on('click', function(e) {
                           e.preventDefault();
                           displayPopupContentFromUrl('/office/term_conditions/', '<?=$this->langs->term_conditions;?>');
                       });
                   });
                </script>
                              </div>
                          </div>
                      <div class="checkout-buttons">
                              <script type="text/javascript">
                                  $(document).ready(function () {
                                      $('#checkout').click(function () {
                                          //terms of service
                                          var termOfServiceOk = true;
                                          if ($('#termsofservice').length > 0) {
                                              //terms of service element exists
                                              if (!$('#termsofservice').is(':checked')) {
                                                  $("#terms-of-service-warning-box").dialog();
                                                  termOfServiceOk = false;
                                              } else {
                                                  termOfServiceOk = true;
                                              }
                                          }
                                          return termOfServiceOk;
                                      });
                                  });
                              </script>
                              <button type="submit" disabled id="checkout" name="checkout" value="checkout" class="button-1 checkout_btn checkout-button disabled">
                                  <?=$this->langs->checkout;?>
                              </button>
                      </div>
              </div>
          </div>
</form>
</div>

  </div>
</div>


</div>

      </div>

  </div>
