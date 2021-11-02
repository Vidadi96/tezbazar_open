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
    var nop_store_directory_root = "<?=base_url();?>";
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


<div class="page wishlist-page">
    <div class="page-title">
        <h1><?=$this->langs->wishlist;?></h1>
    </div>
    <div class="page-body">
            <div class="wishlist-content">
                <form action="/wishlist" method="post">                <div class="table-wrapper">
                    <table class="cart">
                        <colgroup>
                            <col width="1" />
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
                                <th class="add-to-cart" data-hide="w410, w480, w580, w768, w980">
                                    <?=$this->langs->add_to_basket;?>
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

                          <?php $total=0; foreach ($wishlist as $value): $total = $total+($value["count"]*$value["ex_price"]); ?>
                          <tr class="cart-item-row">

                              <td>
                                <span class="item-count">1</span>
                              </td>
                              <td class="">
                                  <a href="/profile/wishlist/<?=$value["id"];?>" class="delete_btn"><img src="/site/img/delete.png"></img></a>
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
                <div class="buttons">
                  <input type="submit" name="addtocartbutton" value="+ <?=$this->langs->add_to_basket;?>" class="button-2 wishlist-add-to-cart-button" />
                  <input type="button" value="E-mail на пријател" class="button-2 email-a-friend-wishlist-button" onclick="setLocation('/emailwishlist')" />
                </div>
</form>            </div>

            <div class=share-info><span class=share-label><?=$this->langs->list_for_share;?>:</span> <a href="<?=base_url();?>profile/sharing_list/<?=md5($this->session->userdata("user_id")."wishlist");?>" class=share-link><?=base_url();?>profile/sharing_list/<?=md5($this->session->userdata("user_id")."wishlist");?></a></div>
    </div>
</div>


</div>

        </div>

    </div>
