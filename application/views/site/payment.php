<div class=master-wrapper-content>
   <div class=ajaxCartInfo data-getajaxcartbuttonurl=/NopAjaxCart/GetAjaxCartButtonsAjax data-productpageaddtocartbuttonselector=input.add-to-cart-button data-productboxaddtocartbuttonselector=button.product-box-add-to-cart-button data-productboxproductitemelementselector=.product-item data-enableonproductpage=True data-enableoncatalogpages=True data-minishoppingcartquatityformattingresource=({0}) data-miniwishlistquatityformattingresource=({0}) data-addtowishlistbuttonselector=input.add-to-wishlist-button></div>
   <input id=addProductVariantToCartUrl name=addProductVariantToCartUrl type=hidden value=/AddProductFromProductDetailsPageToCartAjax> <input id=addProductToCartUrl name=addProductToCartUrl type=hidden value=/AddProductToCartAjax> <input id=miniShoppingCartUrl name=miniShoppingCartUrl type=hidden value=/MiniShoppingCart> <input id=flyoutShoppingCartUrl name=flyoutShoppingCartUrl type=hidden value=/NopAjaxCartFlyoutShoppingCart> <input id=checkProductAttributesUrl name=checkProductAttributesUrl type=hidden value=/CheckIfProductOrItsAssociatedProductsHasAttributes> <input id=getMiniProductDetailsViewUrl name=getMiniProductDetailsViewUrl type=hidden value=/GetMiniProductDetailsView> <input id=flyoutShoppingCartPanelSelector name=flyoutShoppingCartPanelSelector type=hidden value=#flyout-cart> <input id=shoppingCartMenuLinkSelector name=shoppingCartMenuLinkSelector type=hidden value=span.cart-qty> <input id=wishlistMenuLinkSelector name=wishlistMenuLinkSelector type=hidden value=span.wishlist-qty>
   <div id=product-ribbon-info data-productid=0 data-productboxselector=".product-item, .item-holder" data-productboxpicturecontainerselector=".picture, .item-picture" data-productpagepicturesparentcontainerselector=.product-essential data-productpagebugpicturecontainerselector=.picture data-retrieveproductribbonsurl=/RetrieveProductRibbons></div>
   <div class=quickViewData data-productselector=.product-item data-productselectorchild=.buttons-upper data-retrievequickviewurl=/quickviewdata data-quickviewbuttontext="Quick View" data-quickviewbuttontitle="Quick View" data-isquickviewpopupdraggable=True data-enablequickviewpopupoverlay=True data-accordionpanelsheightstyle=content data-getquickviewbuttonroute=/getquickviewbutton></div>
   <input type=hidden id=theme-active-preset data-colorpreset="f74258, 00a1b1">
   <div class=master-column-wrapper>
      <div class=center-1>
         <div class="page checkout-page billing-address-page">
            <?=$order_progress;?>
            <div class=page-title>
               <h1><?=$this->langs->delivery_address;?></h1>
            </div>
            <div class="page-body checkout-data">
                <div class="section shipping-method">
              <form method="POST" action="/profile/confirm/?<?php $get = $this->input->get();  $url = $get?"&".http_build_query($get):""; echo substr($url, 1);?>">
                <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <ul class=method-list>
                      <li>
                          <div class=method-name>
                              <input id=shippingoption_0 type=radio name=payment value="1" checked>
                              <label for=shippingoption_0><?=$this->langs->cash_payment;?></label></label>
                          </div>
                          <div class=method-description><?=$this->langs->payment_at_delivery;?></div>
                        </li>
                          <li style="opacity: .4;">
                              <div class=method-name>
                                  <input id=payment disabled type=radio name=payment value="2">
                                  <label for=shippingoption_1><?=$this->langs->online_payment;?></label>
                                    <ul class="accepted-payments">
                                  <li class="method2"></li>
                                  <li class="method4"></li>
                            </ul></label>
                              </div>
                              <div class=method-description><?=$this->langs->pay_by_card;?></label></div>
                            </li>
                  </ul>
                  <div class=buttons>
                      <input type=submit value="<?=$this->langs->next;?>" class="button-1 shipping-method-next-step-button">
                  </div>
              </form>
            </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</div>
