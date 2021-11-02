<script type="text/javascript">
    AjaxCart.init(false, '.header-links .cart-qty', '.header-links .wishlist-qty', '#flyout-cart');
</script>
    <div class="overlayOffCanvas"></div>
    <div class="responsive-nav-wrapper-parent" style="height: 76px;">
        <div class="responsive-nav-wrapper stick">
            <div class="menu-title">
                <span>Menu</span>
            </div>
            <div class="shopping-cart-link">
                <span>Кошничка</span>
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





<div class="ajaxCartInfo" data-getajaxcartbuttonurl="/NopAjaxCart/GetAjaxCartButtonsAjax" data-productpageaddtocartbuttonselector=".add-to-cart-button" data-productboxaddtocartbuttonselector="button.product-box-add-to-cart-button" data-productboxproductitemelementselector=".product-item" data-enableonproductpage="True" data-enableoncatalogpages="True" data-minishoppingcartquatityformattingresource="({0})" data-miniwishlistquatityformattingresource="({0})" data-addtowishlistbuttonselector=".add-to-wishlist-button">
</div>

<input id="addProductVariantToCartUrl" name="addProductVariantToCartUrl" type="hidden" value="/AddProductFromProductDetailsPageToCartAjax">
<input id="addProductToCartUrl" name="addProductToCartUrl" type="hidden" value="/AddProductToCartAjax">
<input id="miniShoppingCartUrl" name="miniShoppingCartUrl" type="hidden" value="/MiniShoppingCart">
<input id="flyoutShoppingCartUrl" name="flyoutShoppingCartUrl" type="hidden" value="/NopAjaxCartFlyoutShoppingCart">
<input id="checkProductAttributesUrl" name="checkProductAttributesUrl" type="hidden" value="/CheckIfProductOrItsAssociatedProductsHasAttributes">
<input id="getMiniProductDetailsViewUrl" name="getMiniProductDetailsViewUrl" type="hidden" value="/GetMiniProductDetailsView">
<input id="flyoutShoppingCartPanelSelector" name="flyoutShoppingCartPanelSelector" type="hidden" value="#flyout-cart">
<input id="shoppingCartMenuLinkSelector" name="shoppingCartMenuLinkSelector" type="hidden" value=".cart-qty">
<input id="wishlistMenuLinkSelector" name="wishlistMenuLinkSelector" type="hidden" value="span.wishlist-qty">





<script type="text/javascript">
    var nop_store_directory_root = "<?=base_url();?>";
</script>

<div id="product-ribbon-info" data-productid="3444" data-productboxselector=".product-item, .item-holder" data-productboxpicturecontainerselector=".picture, .item-picture" data-productpagepicturesparentcontainerselector=".product-essential" data-productpagebugpicturecontainerselector=".picture" data-retrieveproductribbonsurl="/ProductRibbons/RetrieveProductRibbons">
</div>



    <div class="quickViewData" data-productselector=".product-item" data-productselectorchild=".buttons-upper" data-retrievequickviewurl="/office/quickview/" data-quickviewbuttontext="<?=$this->langs->quick_overview;?>" data-quickviewbuttontitle="<?=$this->langs->quick_overview;?>" data-isquickviewpopupdraggable="True" data-enablequickviewpopupoverlay="True" data-accordionpanelsheightstyle="content">
    </div>



<div id="color-squares-info" data-retrieve-color-squares-url="/PavilionTheme/RetrieveColorSquares" data-product-attribute-change-url="/ShoppingCart/ProductDetails_AttributeChange" data-productbox-selector=".product-item" data-productbox-container-selector=".attribute-squares-wrapper" data-productbox-price-selector=".prices .actual-price">
</div>




<div class="breadcrumb">
    <ul>
        <li>

                <a href="/" itemprop="url">
                    <span itemprop="title"><?=$this->langs->home;?></span>
                </a>
            <span class="delimiter"> /</span>
        </li>
        <?php  foreach(@$cats as $cat) {
          echo '<li>
                  <a href="/office/category/'.$cat->cat_id.'" itemprop="url">
                      <span itemprop="title">'.$cat->name.'</span>
                  </a>
                  <span class="delimiter"> /</span>
                </li>';
        }?>
        <li>
            <strong class="current-item"><?=$product->title;?></strong>
        </li>
    </ul>
</div>


            <div class="master-column-wrapper">

<div class="center-1">


<!--product breadcrumb-->


<div class="prev-next-wrapper">
    <?=$next_prev->prev?'<div class="previous-product">
            <a href="/office/product/'.$next_prev->prev.'"><span class="previous-product-label">'.$this->langs->prev_p.'</span><span class="previous-product-title"></span></a>
    </div>':'';?>
    <?=$next_prev->next?'<div class="next-product">
            <a href="/office/product/'.$next_prev->next.'"><span class="next-product-label">'.$this->langs->next_p.'</span><span class="next-product-title"></span></a>
    </div>':'';?>
</div>
<div class="page product-details-page">
    <div class="page-body">

<form action="/" id="product-details-form" method="post" novalidate="novalidate" product-id="<?=$product->p_id;?>">
  <div itemscope="">
    <div class="product-essential">
      <input type="hidden" class="cloudZoomPictureThumbnailsInCarouselData" data-vertical="false" data-numvisible="5" data-numscrollable="5" data-enable-slider-arrows="true" data-enable-slider-dots="false" data-size="1" data-rtl="false" data-responsive-breakpoints-for-thumbnails="[{&quot;breakpoint&quot;:1001,&quot;settings&quot;:{&quot;slidesToShow&quot;:3, &quot;slidesToScroll&quot;:3,&quot;arrows&quot;:true,&quot;dots&quot;:false}},{&quot;breakpoint&quot;:769,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:4,&quot;arrows&quot;:false,&quot;dots&quot;:true}},{&quot;breakpoint&quot;:400,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3,&quot;arrows&quot;:false,&quot;dots&quot;:true}}]" data-magnificpopup-counter="%curr% of %total%" data-magnificpopup-prev="Претходно (Left arrow key)" data-magnificpopup-next="Следно (Right arrow key)" data-magnificpopup-close="Затвори (Esc)" data-magnificpopup-loading="Се вчитува...">
      <input type="hidden" class="cloudZoomAdjustPictureOnProductAttributeValueChange" data-productid="3444" data-isintegratedbywidget="true">
      <input type="hidden" class="cloudZoomEnableClickToZoom">
      <div class="gallery sevenspikes-cloudzoom-gallery">
          <div class="picture-wrapper">
            <div class="ribbon-wrapper">
                <div class="picture" id="sevenspikes-cloud-zoom" data-zoomwindowelementid="" data-selectoroftheparentelementofthecloudzoomwindow="" data-defaultimagecontainerselector=".product-essential .gallery" data-zoom-window-width="244" data-zoom-window-height="257">
                  <a href="/img/products/auto/<?=$thumbs[0]->img;?>" data-full-image-url="/img/products/auto/<?=$thumbs[0]->img;?>" class="picture-link" id="zoom1">
                    <img src="/img/products/415x415/<?=$thumbs[0]->img;?>" alt="<?=$product->title;?>" class="cloudzoom" id="cloudZoomImage" itemprop="image" data-cloudzoom="appendSelector: &#x27;.picture-wrapper&#x27;, zoomPosition: &#x27;inside&#x27;, zoomOffsetX: 0, captionPosition: &#x27;bottom&#x27;, tintOpacity: 0, zoomWidth: 244, zoomHeight: 257, easing: 3, touchStartDelay: true, zoomFlyOut: false, disableZoom: &#x27;auto&#x27;" />
                  </a>
                </div>
                <!-- <div class="ribbon-position top-left" data-productribbonid="1" data-productid="11" style="display: none;">
                  <div class="product-ribbon" style="background: #f6f6f6; padding: 5px 15px; top: 15px;">
                    <label class="ribbon-text" style="font-size: 13px; font-weight: bold; color: #f74258; text-shadow: none;">NEW</label>
                  </div>
                </div>
                <div class="ribbon-position top-right" data-productribbonid="2" data-productid="11" style="display: none;">
                  <div class="product-ribbon" style="background: #f74258; padding: 5px 15px; top: 15px;">
                    <label class="ribbon-text" style="font-size: 13px; font-weight: bold; color: #fff;">-0%</label>
                  </div>
                </div> -->
              </div>
          </div>
          <?php if(@count($thumbs)>0){?>
          <div class="picture-thumbs in-carousel">
            <div class="picture-thumbs-list" id="picture-thumbs-carousel">
            <?php foreach ($thumbs as $value) {?>
              <div class="picture-thumbs-item">
                <a href="/img/products/auto/<?=$value->img;?>" class="cloudzoom-gallery thumb-item" data-full-image-url="/img/products/auto/<?=$value->img;?>" data-cloudzoom="appendSelector: &#x27;.picture-wrapper&#x27;, zoomPosition: &#x27;inside&#x27;, zoomOffsetX: 0, captionPosition: &#x27;bottom&#x27;, tintOpacity: 0, zoomWidth: 244, zoomHeight: 257, useZoom: &#x27;.cloudzoom&#x27;, image: &#x27;/img/products/415x415/<?=$value->img;?>&#x27;, zoomImage: &#x27;/img/products/auto/<?=$value->img;?>&#x27;, easing: 3, touchStartDelay: true, zoomFlyOut: false, disableZoom: &#x27;auto&#x27;"><img class="cloud-zoom-gallery-img" src="/img/products/95x95/<?=$value->img;?>" alt="<?=$product->title;?>" />
                </a>
              </div>
            <?php } ?>
            </div>
          </div>
        <?php }?>
      </div>
      <div class="overview">
        <!--manufacturers-->
        <div class="manufacturers">
            <span class="label"><?=$this->langs->brand;?>: </span>
            <span class="value"><a href="/office/brand/<?=$product->brand_id;?>"><?=$product->brand_name;?></a></span>
            <span class="value">
              <a href="/office/brand/<?=$product->brand_id;?>"></a>
            </span>
          </div>
          <div class="product-name">
              <h1 itemprop="name"><?=$product->title;?></h1>
          </div>
          <!--reviews-->
          <div class="product-reviews-overview">
              <div class="product-review-box">
                  <div class="rating">
                      <div style="width: 0%">
                      </div>
                  </div>
              </div>
          </div>
          <!--price & add to cart-->

          <div class="prices" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
            <div class="product-price">
        		    <span>
                      <?=$colors[0]->ex_price;?> AZN
                </span>
            </div>
            <meta itemprop="priceCurrency" content="AZN">
          </div>
          <div class="short-description">
            <?=$product->description;?>
          </div>

          <div class="additional-details"></div>
          <ul class="option-list attribute-squares  color-squares" id="color-squares-137">

                  </ul>

          <div class="attributes">

            <dl>
              <?php if($sizes){ ?>
              <dt id="product_attribute_label_31" style="width: 134.828px;">
                <label class="text-prompt"><?=$this->langs->size;?></label>
                <span class="required">*</span>
                </dt>
                <dd id="product_attribute_input_31">
                <select name="mn_id" class="valid" aria-invalid="false">
                  <?php foreach ($sizes as $value) {
                    if($colors[0]->mn_id==$value->mn_id)
                      echo '<option selected value="'.$value->mn_id.'">'.$value->title.' ['.$value->ex_price.' AZN]</option>';
                    else
                      echo '<option value="'.$value->mn_id.'">'.$value->title.' ['.$value->ex_price.' AZN]</option>';
                  }
                  ?>
                </select>
              </dd>
              <?php } ?>
              <dt id="product_attribute_label_137">
                <label class="text-prompt">Color</label>
                <span class="required">*</span>
              </dt>

              <dd id="product_attribute_input_137">
                <ul class="option-list attribute-squares  color-squares" id="color-squares-137">
                  <?php $b=1; $i=1; foreach ($colors as $color) {
                    if($color->color_code)
                    {
                      echo '<li class="selected-value color_item" data-color_id="'.$color->color_id.'">
                        <label for="product_attribute_'.$color->color_id.'_311"><span class="attribute-square-container '.($b?'selected_color':'').'" title="'.$color->color_name.'"><span class="attribute-square" style="background-color:'.$color->color_code.';">&nbsp;</span></span></label>
                      </li>';
                      $b=0;
                    }
                    $i++;
                  }?>
                </ul>
              </dd>
            </dl>
          </div>
          <!--rental info-->
          <!--SKU, MAN, GTIN, vendor-->
          <div class="additional-details">
            <div class="sku">
                <span class="label">SKU: </span>
                <span class="value" itemprop="sku" id="sku-3444"><?=$product->sku;?></span>
            </div>
          </div>
          <!--sample download-->
          <!--attributes-->
          <script>
              $(document).ready(function() {
                  $('.attribute_input').each(function(i, obj) {
                      var attr_val = $(this).find("select option:selected").text();
                      console.log(attr_val);
                      if (attr_val == "Нема")
                      {
                          $(this).css("display", "none");
                          $(this).prev().css("display", "none");
                      }
                  });
              });
          </script>
          <!--gift card-->
          <!--availability-->
          <div class="availability">
            <div class="stock">
                <span class="label"><?=$this->langs->availability;?>:</span>
                <span class="stock_value"> <?=$colors[0]->counts?$colors[0]->counts:$this->langs->out_of_stock;?></span>
            </div>
          </div>
          <?php if($product->in_warehouse){ ?>
          <div class="warehouses_availability">
            <ul class="warehouses_list" style="width: 100%;">
                <li id="showOrHideWA" style="width: 50%; float: left;">
                    <?=$this->langs->in_warehouse;?>:
                    <div class="plus-button"></div>
                </li>
                <?php foreach ($warehouse_in as $warehouse) {?>
                <li class="warehouse_name" style="width: 50%; float: left;">
                        <?=$warehouse->name;?>

                </li>
              <?php } ?>
            </ul>
        </div>
        <?php } ?>

<script>
    $(document).ready(function () {

        var len = $("ul.warehouses_list li").length;

        var win_size = $(document).width();

        if (win_size > 951) {
            if (len <= 6) {
                $("ul.warehouses_list").css("width", "initial");
                $("ul.warehouses_list li").css({ "width": "initial", "float": "initial" });
            }
            else if (len <= 12) {
                $("ul.warehouses_list").css("width", "100%");
                $("ul.warehouses_list li").css({ "width": "50%", "float": "left" });
            }
        }

        $(window).resize(function () {
            var win_size = $(document).width();
            if (win_size > 1263) {
                if (len <= 6) {
                    $("ul.warehouses_list").css("width", "initial");
                    $("ul.warehouses_list li").css({ "width": "initial", "float": "initial" });
                }
                else if (len <= 12) {
                    $("ul.warehouses_list").css("width", "100%");
                    $("ul.warehouses_list li").css({ "width": "50%", "float": "left" });
                }
                else if (len <= 18) {
                    $("ul.warehouses_list").css("width", "100%");
                    $("ul.warehouses_list li").css({ "width": "33.33%", "float": "left" });
                }
            }
            else if (win_size > 983) {
                if (len <= 6) {
                    $("ul.warehouses_list").css("width", "initial");
                    $("ul.warehouses_list li").css({ "width": "initial", "float": "initial" });
                }
                else if (len <= 12) {
                    $("ul.warehouses_list").css("width", "100%");
                    $("ul.warehouses_list li").css({ "width": "50%", "float": "left" });
                }
                else if (len <= 18) {
                    $("ul.warehouses_list").css("width", "100%");
                    $("ul.warehouses_list li").css({ "width": "50%", "float": "left" });
                }

            }
            else {
                $("ul.warehouses_list").css("width", "100%");
                $("ul.warehouses_list li").css({ "width": "100%", "float": "left" });
            }
        });

        $("#showOrHideWA").click(function () {

            var x = $("ul.warehouses_list li.warehouse_name").css("display");

            if (x == "none") {
                $("ul.warehouses_list li.warehouse_name").css("display", "list-item");
                $("ul.warehouses_list").css("background-color", "#f6f6f6");
            }
            else {
                $("ul.warehouses_list li.warehouse_name").css("display", "none");
                $("ul.warehouses_list").css("background-color", "initial");
            }

        });

        $("#showOrHideWA .plus-button").click(function () {

            var x = $("ul.warehouses_list li.warehouse_name").css("display");

            if (x == "none") {
                $("ul.warehouses_list li.warehouse_name").css("display", "list-item");
                $("ul.warehouses_list").css("background-color", "#f6f6f6");
            }
            else {
                $("ul.warehouses_list li.warehouse_name").css("display", "none");
                $("ul.warehouses_list").css("background-color", "initial");
            }

        });

    });
</script>
                        <!--add to cart-->
    <div class="add-to-cart sevenspikes-ajaxcart">
      <div class="add-to-cart-panel">
      <label class="qty-label" for="quantity">Quantity:</label>
        <input class="qty-input" data-val="true" data-val-number="The field Quantity must be a number." id="quantity" name="quantity" type="text" value="1">
        <div class="ajax-cart-button-wrapper" data-isproductpage="true">
          <input type="button" value="+ <?=$this->langs->add_to_basket;?>" class="button-1 add_to_basket add-to-cart-button" onclick="AjaxCart.addproducttocart_details('/addproducttocart/details/4243/1', '#product-details-form');return false;">
        </div>

      </div>

    </div>

                        <!--wishlist, compare, email a friend-->
                        <div class="overview-buttons">

    <div class="add-to-wishlist">
        <input type="button" id="add-to-wishlist-button-3444" class="button-2 add-to-wishlist-button" value="Add to wishlist" data-productid="3444">
    </div>


    <!-- <div class="compare-products">
        <input type="button" value="Add to comparison list" class="button-2 add-to-compare-list-button" onclick="AjaxCart.addproducttocomparelist('/compareproducts/add/3444');return false;">
    </div> -->

                                <div class="email-a-friend">
        <input type="button" value="E-mail to a friend" class="button-2 email-a-friend-button" onclick="setLocation('/productemailafriend/3444')">
    </div>


                        </div>

                    </div>
                    <div class="overview-bottom">
                        <!--sharing-->



<div class="product-social-buttons">
    <label>Share:</label>
    <ul class="social-sharing">
        <li class="twitter">
            <!-- Twitter -->
            <a href="javascript:openShareWindow('http://twitter.com/share?url=<?=current_url();?>')">
                <span class="flip"></span>
                <span class="flop"></span>
            </a>
        </li>
        <li class="facebook">
            <!-- Facebook -->
            <a href="javascript:openShareWindow('http://www.facebook.com/sharer.php?u=<?=current_url();?>')">
                <span class="flip"></span>
                <span class="flop"></span>
            </a>
        </li>
        <li class="pinterest">
            <!-- Pinterest -->
            <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
                <span class="flip"></span>
                <span class="flop"></span>
            </a>
        </li>
        <li class="whatsapp">
            <!-- Google+ -->
            <a href="javascript:openShareWindow('whatsapp://send?text=<?=current_url();?>')"  data-action="share/whatsapp/share">
              <img src="/site/img/whatsapp.png" width="24"/>
              <span class="flip"></span>
              <span class="flop"></span>
            </a>
        </li>
    </ul>

    <script>
        function openShareWindow(url) {
            var winWidth = 520;
            var winHeight = 400;
            var winTop = (screen.height / 2) - (winHeight / 2);
            var winLeft = (screen.width / 2) - (winWidth / 2);

            window.open(url, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
        }
    </script>
</div>
                        <!--delivery-->

                    </div>
                </div>



                    <div class="one-column-wrapper">



    <div id="quickTabs" class="productTabs  ui-tabs ui-widget ui-widget-content ui-corner-all" data-ajaxenabled="false" data-productreviewsaddnewurl="/ProductTab/ProductReviewsTabAddNew/3444" data-productcontactusurl="/ProductTab/ProductContactUsTabAddNew/3444" data-couldnotloadtaberrormessage="Couldn't load this tab.">


<div class="productTabs-header">
    <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="quickTab-reviews" aria-labelledby="ui-id-0" aria-selected="true">
                <a href="#quickTab-about-product" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-0"><?=$this->langs->about_product;?></a>
            </li>
            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="quickTab-reviews" aria-labelledby="ui-id-1" aria-selected="false">
                <a href="#quickTab-reviews" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"><?=$this->langs->comments;?></a>
            </li>
            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="quickTab-contact_us" aria-labelledby="ui-id-2" aria-selected="false">
                <a href="#quickTab-contact_us" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"><?=$this->langs->contactus;?></a>
            </li>


    </ul>
</div>
<div class="productTabs-body">
        <div id="quickTab-about-product" aria-labelledby="ui-id-0" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">
          <div id="updateTargetId" class="product-reviews-page">
            <div class="write-review" id="review-form">
                <?=$product->content;?>
            </div>
          </div>
        </div>
        <!--End tab content-->
        <div id="quickTab-reviews" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">


<div id="updateTargetId" class="product-reviews-page">

        <div class="write-review" id="review-form">
            <div class="title">
                <strong><?=$this->langs->w_review;?></strong>
            </div>
            <div class="message-error"><div class="validation-summary-errors"><ul><li><?=$this->langs->only_can_w_user;?></li>
</ul></div></div>
            <div class="form-fields">
                <div class="inputs">
                    <label for="AddProductReview_Title"><?=$this->langs->w_title;?>:</label>
                    <input class="review-title" disabled="disabled" id="AddProductReview_Title" name="AddProductReview.Title" type="text" value="">
                    <span class="field-validation-valid" data-valmsg-for="AddProductReview.Title" data-valmsg-replace="true"></span>
                </div>
                <div class="inputs">
                    <label for="AddProductReview_ReviewText"><?=$this->langs->msg;?>:</label>
                    <textarea class="review-text" cols="20" disabled="disabled" id="AddProductReview_ReviewText" name="AddProductReview.ReviewText" rows="2"></textarea>
                    <span class="field-validation-valid" data-valmsg-for="AddProductReview.ReviewText" data-valmsg-replace="true"></span>
                </div>
                <div class="review-rating">
                    <label for="AddProductReview_Rating"><?=$this->langs->raiting;?>:</label>
                    <ul>
                        <li class="first"><?=$this->langs->bad;?></li>
                        <li>
                            <input data-val="true" data-val-number="The field Рејтинг must be a number." id="AddProductReview_Rating" name="AddProductReview.Rating" type="radio" value="1">
                            <input id="AddProductReview_Rating" name="AddProductReview.Rating" type="radio" value="2">
                            <input id="AddProductReview_Rating" name="AddProductReview.Rating" type="radio" value="3">
                            <input id="AddProductReview_Rating" name="AddProductReview.Rating" type="radio" value="4">
                            <input checked="checked" id="AddProductReview_Rating" name="AddProductReview.Rating" type="radio" value="5">
                        </li>
                        <li class="last"><?=$this->langs->good;?></li>
                    </ul>
                </div>

            </div>
            <div class="buttons">
                    <input type="button" id="add-review" disabled="disabled" name="add-review" class="button-1 write-product-review-button" value="<?=$this->langs->send;?>">
            </div>

        </div>
</div>

        </div>
        <!--End tab content-->
        <div id="quickTab-contact_us" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">




<div id="contact-us-tab" class="write-review">

    <div class="form-fields">
        <div class="inputs">
            <label for="FullName"><?=$this->langs->full_name;?></label>
            <input class="contact_tab_fullname review-title" data-val="true" data-val-required="Внесете го Вашето име" id="FullName" name="FullName" placeholder="" type="text" value="">
            <span class="field-validation-valid" data-valmsg-for="FullName" data-valmsg-replace="true"></span>
        </div>
        <div class="inputs">
            <label for="Email"><?=$this->langs->enter_email;?></label>
            <input class="contact_tab_email review-title" data-val="true" data-val-email="<?=$this->langs->v_email;?>" data-val-required="<?=$this->langs->v_email;?>" id="Email" name="Email" placeholder="" type="text" value="">
            <span class="field-validation-valid" data-valmsg-for="Email" data-valmsg-replace="true"></span>
        </div>
        <div class="inputs">
            <label for="Enquiry"><?=$this->langs->msg;?></label>
            <textarea class="contact_tab_enquiry review-text" cols="20" data-val="true" data-val-required="Внесете прашање" id="Enquiry" name="Enquiry" rows="2"></textarea>
            <span class="field-validation-valid" data-valmsg-for="Enquiry" data-valmsg-replace="true"></span>
        </div>
    </div>
    <div class="buttons">
        <input type="button" id="send-contact-us-form" name="send-email" class="button-1 contact-us-button" value="<?=$this->langs->send;?>">
    </div>
</div>
        </div>


</div>
    </div>



                    </div>

                <div class="product-collateral" style="display: none;">




                </div>
                    <div class="also-purchased-products-grid product-grid">
        <div class="title">
            <strong><?=$this->langs->similer_product;?></strong>
        </div>
        <div class="item-grid">
          <?php foreach($similar_products as $item){ ?>

              <?=$this->load->view("site/product_item", $item, true);?>

          <?php } ?>
        </div>
    </div>


            </div>
</form>
    </div>
</div>


</div>

        </div>

    </div>
