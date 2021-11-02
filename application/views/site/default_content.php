


        <div class="two-columns-area slider-right-column">

            <div class="center">
                <div class="two-colums-area-left">
                    <div class="category-navigation-list-wrapper">
                        <ul class="category-navigation-list sticky-flyout"></ul>
                    </div>

                </div>
                <div class="two-colums-area-right">

                    <div class="slider-wrapper anywhere-sliders-nivo-slider theme- no-captions" data-imagesCount="7" data-sliderHtmlElementId="WidgetSlider-home_page_main_slider-1" data-imagesString="
                    <?php foreach ($slides as $value) {
                      echo "<a href='".$value->slide_link."'><img src='/img/slides/".$value->image."' data-thumb='/img/slides/95x95/".$value->image."' alt='slider image' /></a>";
                    }
                    ?>" data-effect="fade" data-slices="15" data-boxCols="8" data-boxRows="4" data-animSpeed="500" data-pauseTime="3000" data-directionNav="true" data-controlNav="true" data-controlNavThumbs="false" data-pauseOnHover="true" data-prevText="Prev" data-nextText="Next">
                        <div id="WidgetSlider-home_page_main_slider-1" class="nivoSlider">
                            <a href="<?=$slides[0]->slide_link;?>">
                                <img class="nivo-main-image" src="/img/slides/<?=$slides[0]->image;?>" alt="banner" />
                            </a>
                            <div class="nivo-caption" style="display: block;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

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

            <div class="ajaxCartInfo" data-getAjaxCartButtonUrl="/office/ajax_cart_buttons/" data-productPageAddToCartButtonSelector=".add-to-cart-button" data-productBoxAddToCartButtonSelector="button.product-box-add-to-cart-button" data-productBoxProductItemElementSelector=".product-item" data-enableOnProductPage="True" data-enableOnCatalogPages="True" data-miniShoppingCartQuatityFormattingResource="({0})" data-miniWishlistQuatityFormattingResource="({0})" data-addToWishlistButtonSelector=".add-to-wishlist-button">
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

            <div id="product-ribbon-info" data-productid="0" data-productboxselector=".product-item, .item-holder" data-productboxpicturecontainerselector=".picture, .item-picture" data-productpagepicturesparentcontainerselector=".product-essential" data-productpagebugpicturecontainerselector=".picture" data-retrieveproductribbonsurl="/office/retrieve_product_ribbons">
            </div>

            <div class="quickViewData" data-productselector=".product-item" data-productselectorchild=".buttons-upper" data-retrievequickviewurl="/quickviewdata" data-quickviewbuttontext="<?=$this->langs->quick_overview;?>" data-quickviewbuttontitle="<?=$this->langs->quick_overview;?>" data-isquickviewpopupdraggable="True" data-enablequickviewpopupoverlay="True" data-accordionpanelsheightstyle="content">
            </div>

            <div id="color-squares-info" data-retrieve-color-squares-url="/office/retrieve_color_squares" data-product-attribute-change-url="/ShoppingCart/ProductDetails_AttributeChange" data-productbox-selector=".product-item" data-productbox-container-selector=".attribute-squares-wrapper" data-productbox-price-selector=".prices .actual-price">
            </div>

            <div class="master-column-wrapper">

                <div class="center-1">

                    <div class="page home-page">
                        <div class="page-body">

                            <script>
                                $(document)
                                    .ready(function() {
                                        var jCarousel = $("#jcarousel-3-396 .slick-carousel");

                                        if (jCarousel.length === 0) {
                                            return;
                                        }

                                        var numOfSlidesToScroll = 1;
                                        var loopItems = true;
                                        var pauseOnHover = true;
                                        var isRtl = false;
                                        var autoscrollTimeout = 3;
                                        var autoscroll = autoscrollTimeout > 0 ? true : false;
                                        var navigationArrows = true;
                                        var navigationDots = false;
                                        var numberOfVisibleItems = 6 < 1 ? 1 : 6;
                                        var animationSpeedString = 'slow';
                                        var animationSpeed;

                                        switch (animationSpeedString) {
                                            case 'slow':
                                                animationSpeed = 300;
                                                break;
                                            case 'fast':
                                                animationSpeed = 150;
                                                break;
                                            default:
                                                animationSpeed = 0;
                                        }

                                        var responsiveBreakpointsObj = {};

                                        try {

                                            responsiveBreakpointsObj = JSON.parse('[{"breakpoint":890,"settings":{"slidesToShow":3}},{"breakpoint":711,"settings":{"slidesToShow":2}},{"breakpoint":425,"settings":{"slidesToShow":1}}]');

                                            for (var i = 0; i < responsiveBreakpointsObj.length; i++) {
                                                if (responsiveBreakpointsObj[i].settings.slidesToShow < numOfSlidesToScroll) {
                                                    responsiveBreakpointsObj[i].settings.slidesToScroll = responsiveBreakpointsObj[i].settings.slidesToShow;
                                                }
                                            }
                                        } catch (e) {
                                            console.log('Invalid slick slider responsive breakpoints setting value!');
                                        }

                                        jCarousel.on('init', function(slick) {
                                            $.event.trigger({
                                                type: "newProductsAddedToPageEvent"
                                            });
                                            $(".carousel-title").show();
                                        });

                                        jCarousel.slick({
                                            rtl: isRtl,
                                            infinite: loopItems,
                                            slidesToShow: numberOfVisibleItems,
                                            slidesToScroll: numOfSlidesToScroll,
                                            dots: navigationDots,
                                            speed: animationSpeed,
                                            autoplay: autoscroll,
                                            autoplaySpeed: autoscrollTimeout * 1000,
                                            arrows: navigationArrows,
                                            appendArrows: '#jcarousel-3-396 .carousel-title',
                                            cssEase: 'linear',
                                            respondTo: 'slider',
                                            edgeFriction: 0.05,
                                            initialSlide: 1 - 1,
                                            pauseOnHover: pauseOnHover,
                                            draggable: false,
                                            responsive: responsiveBreakpointsObj
                                        });
                                    });
                            </script>
                            <?php if($actions){?>
                            <div id="jcarousel-3-396" class="jCarouselMainWrapper ">
                                <div class="nop-jcarousel product-grid ">

                                    <h2 class="carousel-title">
                <span><?=$this->langs->action;?></span>
        </h2>

                                    <div class="slick-carousel item-grid">
                                        <?php foreach($actions as $item){ ?>
                                        <div class="carousel-item">
                                            <?=$this->load->view("site/product_item", $item, true);?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="category-grid home-page-category-grid">
                                <div class="item-grid">
                                    <div class="item-box">
                                        <div class="category-item">
                                            <h2 class="title">
                            <a href="/%D0%B0%D0%BA%D1%86%D0%B8%D0%B8" title="Прикажи ги производите во категоријата Акции">
                                Акции
                            </a>
                        </h2>
                                            <div class="picture">
                                                <a href="/%D0%B0%D0%BA%D1%86%D0%B8%D0%B8" title="Прикажи ги производите во категоријата Акции">
                                                    <img alt="Слика за категорија Акции" src="https://www.officeplus.mk/content/images/thumbs/default-image_300.png" title="Прикажи ги производите во категоријата Акции" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($categories_for_home as $key => $value): ?>
                              <div class="spc spc-products " notloaded data-getitemproductsurl="/office/get_products/<?=$value->cat_id;?>">
                                  <div class="spc-header">
                                      <h2 class="title"><span><?=$value->name;?></span></h2>
                                      <ul class="navigation">
                                          <li class="tab" data-tabid="1">
                                              <span><?=$this->langs->top_selling;?></span>
                                          </li>
                                          <li class="tab" data-tabid="2">
                                              <span><?=$this->langs->action;?></span>
                                          </li>
                                          <li class="tab" data-tabid="3">
                                              <span><?=$this->langs->price;?></span>
                                          </li>
                                          <li class="tab" data-tabid="4">
                                              <span><?=$this->langs->new;?></span>
                                          </li>
                                      </ul>
                                  </div>
                                  <div class="spc-body">

                                      <div class="product-grid" data-tabid="1">
                                          <div class="item-grid"></div>
                                      </div>
                                      <div class="product-grid" data-tabid="2">
                                          <div class="item-grid"></div>
                                      </div>
                                      <div class="product-grid" data-tabid="3">
                                          <div class="item-grid"></div>
                                      </div>
                                      <div class="product-grid" data-tabid="4">
                                          <div class="item-grid"></div>
                                      </div>
                                      <div class="loading-overlay">
                                          <span>Loading...</span>
                                      </div>
                                  </div>
                              </div>
                            <?php endforeach; ?>




                            <div class="homepage-middle-wrapper">

                                <div class="product-grid bestsellers carousel">
                                    <div class="title">
                                        <strong><?=$this->langs->top_selling;?></strong>
                                    </div>
                                    <div class="item-grid">

                                      <?php $i=0; foreach ($best_sellers as $item) {

                                        if($i==0){echo '<div class="three-items-holder">'; }
                                        ?>

                                            <?=$this->load->view("site/product_item", $item, true);?>
                                            <!--/.item-box-->

                                        <?php $i++; if($i==3){echo '</div>
                                        <!--/.three-items-holder-->'; $i=0; }  }

                                        if($i!=0){echo '</div>
                                        <!--/.three-items-holder-->'; $i=0; }
                                        ?>


                                    </div>
                                </div>

                                <div class="rich-blog-homepage">
                                    <div class="title">
                                        <strong><?=$this->langs->latest_blog;?></strong>
                                    </div>
                                    <div class="blog-posts">

                                        <?php foreach ($blog_posts as $blog) {
                                          echo '<div class="blog-post">
                                              <div class="post-picture">
                                                  <a href="/blog/blog/'.$blog->post_id.'">
                                                      <img src="/img/blogs/400x270/'.$blog->thumb.'" alt="'.$blog->title.'" title="'.$blog->title.'" />
                                                  </a>
                                              </div>
                                              <div class="post-details">
                                                  <span class="post-date">'.date("d-m-Y", strtotime($blog->date_time)).'</span>
                                                  <h3 class="post-title"><a href="/blog/blog/'.$blog->post_id.'">'.$blog->title.'</a></h3>
                                                  <div class="post-description">
                                                      <p><span style="color: #000000; font-size: 11pt;">'.mb_substr($blog->description, 0, 150).'</span></p>
                                                  </div>

                                              </div>
                                          </div>';
                                        }?>
                                    </div>
                                    <div class="view-all">
                                        <a href="/blog">View All Blog Posts</a>
                                    </div>
                                </div>
                            </div>

                            <div class="homepage-bottom-wrapper">

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
