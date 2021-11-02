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



    <div class="">


<div class="page blogpost-page">

    <!-- <div class='post-navigation'>
      <a href='kakov-kufer-da-izberete' title='Каков куфер да изберете –  со мека школка или со тврда школка?!' class='prev'>Претходно</a>
    </div> -->

    <div class="page-body">
        <div class="post">
            <div class="page-title">
                <h1><?=$blog->title;?></h1>
            </div>
            <div class="post-date">
                <?=date("d-m-Y", strtotime($blog->date_time));?>
            </div>

<?php if($blog->thumb): ?>
    <div class="rich-blog-image">
            <img src="/img/blogs/810x550/<?=$blog->thumb;?>" title="<?=$blog->title;?>" alt="<?=$blog->title;?>" />
    </div>
<?php endif; ?>
            <div class="post-body">
                <?=$blog->content;?>
            </div>
        </div>

<div class="post-footer">

    <div class="post-actions">

            <div class="share-post">
                <label><?=$this->langs->share;?>:</label>
                <ul id="share-buttons">
                  <li class="facebook">
                      <!-- Facebook -->
                  <a href="javascript:openShareWindow('https://www.facebook.com/sharer.php?u=http://<?=base_url().'blog/blog/'.$blog->id;?>')"></a>
                  </li>
                  <li class="twitter">
                      <!-- Twitter -->
                  <a href="javascript:openShareWindow('https://twitter.com/share?url=http://<?=base_url().'blog/blog/'.$blog->id;?>')"></a>
                  </li>
                  <li class="linkedin">
                      <a href="javascript:openShareWindow('https://www.linkedin.com/shareArticle?mini=true&url=http://<?=base_url().'blog/blog/'.$blog->id;?>')"></a>
                  </li>
                </ul>
            </div>
            <script>
                function openShareWindow(url) {
                    var winWidth = 520;
                    var winHeight = 400;
                    var winTop = (screen.height / 2) - (winHeight / 2);
                    var winLeft = (screen.width / 2) - (winWidth / 2);

                    window.open(url, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
                }


                !function (a, b, c) { var d, e, f; d = "PIN_" + ~~((new Date).getTime() / 864e5), a[d] ? a[d] += 1 : (a[d] = 1, a.setTimeout(function () { e = b.getElementsByTagName("SCRIPT")[0], f = b.createElement("SCRIPT"), f.type = "text/javascript", f.async = !0, f.src = c.mainUrl + "?" + Math.random(), e.parentNode.insertBefore(f, e) }, 10)) }(window, document, { mainUrl: "//assets.pinterest.com/js/pinit_main.js" });
            </script>
    </div>
</div>


    </div>

</div>


    </div>




        </div>

    </div>
