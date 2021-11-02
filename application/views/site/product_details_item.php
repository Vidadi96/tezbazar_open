

<input id="add-to-cart-details" type="hidden"
       data-productid="10231"
       data-url="/addproducttocart/details/10231/1" />

<div class="product-essential">
<form action="/%D0%91%D0%A0%D0%9E%D0%88%D0%90%D0%A7-%D0%97%D0%90-%D0%9F%D0%90%D0%A0%D0%98-%D0%9D%D0%A6-520-%D0%9E%D0%9B%D0%98%D0%9C%D0%9F%D0%98%D0%88%D0%90-947730520" id="product-details-form" method="post">        <div class="popup-header">
            <h1 class="product-name">
                <?=$product->title;?>
            </h1>
        </div>
        <div class="product-content">
            <div class="gallery">
                <!--product pictures-->


    <script>
    $(document).ready(function() {
            CloudZoom.quickStart();
        });
    </script>
    <div class="picture">
        <a href="/img/products/auto/<?=$thumbs[0]->img;?>">
            <img class="cloudzoom" src="/img/products/415x415/<?=$thumbs[0]->img;?>" data-cloudzoom="appendSelector: &#39;.quickViewWindow .gallery .picture&#39;, zoomPosition: &#39;inside&#39;, zoomOffsetX: 0, easing: 3, zoomFlyOut: false, disableZoom: &#39;auto&#39;"
                 alt="<?=$product->title;?>" id="quick-view-zoom" />
        </a>
    </div>

<input type="hidden" class="quickViewAdjustPictureOnProductAttributeValueChange"
       data-productId="10231"
       data-isCloudZoomAvailable="true" />

                <div class="links-panel">
                    <a href="/office/product/<?=$product->p_id;?>" class="link-to-product-page"><?=$product->title;?></a>
                </div>
            </div>
            <div class="overview">
                <div id="accordion">
                    <h3><?=$this->langs->details;?></h3>
                    <div class="product-details">
                        <div class="left">
                            <!--product SKU, manufacturer part number, stock info-->

<div class="additional-details">

        <div class="sku" >
            <span class="label">SKU:</span>
            <span class="value" itemprop="sku" id="sku-10231"><?=$product->sku;?></span>
        </div>
            </div>

                            <!--delivery-->


          <div class="availability">
            <div class="stock">
                <span class="label"><?=$this->langs->availability;?>:</span>
                <span class="stock_value"> <?=$colors[0]->counts?$colors[0]->counts:'Out of stock';?></span>
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

                            <!--product manufacturers-->
                                <!-- <div class="manufacturers">
            <span class="label">Производител:</span>
        <span class="value">
                <a href="/olympia">Olympia</a>
        </span>
    </div> -->


                            <!--sample download-->

                        </div>
                        <div class="right">

    <div class="compare-products">
        <input type="button" value="Додади во споредувачката листа" class="button-2 add-to-compare-list-button" onclick="AjaxCart.addproducttocomparelist('/compareproducts/add/10231');return false;" />
    </div>
                        </div>







                        <!--product tier prices-->



                        <div class="purchase-area">

	<div class="prices" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	        <div class="					product-price
">


				<span   itemprop="price" content="19995.00" class="price-value-10231"  >
	                <?=$colors[0]->ex_price;?> AZN
	            </span>
	        </div>
	            <meta itemprop="priceCurrency" content="MKD" />
	</div>


    <div class="add-to-cart">
                    <div class="add-to-cart-panel">
                <label class="qty-label" for="addtocart_10231_EnteredQuantity">Кол.:</label>
<input class="qty-input" data-val="true" data-val-number="The field Кол. must be a number." id="addtocart_10231_EnteredQuantity" name="addtocart_10231.EnteredQuantity" type="text" value="1" />                    <script type="text/javascript">
                        $(document).ready(function () {
                            $("#addtocart_10231_EnteredQuantity").keydown(function (event) {
                                if (event.keyCode == 13) {
                                    $("#add-to-cart-button-10231").click();
                                    return false;
                                }
                            });
                        });
                    </script>
                                    <input type="button" class="button-1 add-to-cart-button" value="+ <?=$this->langs->add_to_basket;?>" data-productid="10231" onclick="AjaxCart.addproducttocart_single(<?=$product->p_id;?>, <?=$colors[0]->color_id?$colors[0]->color_id:0;?>, <?=$colors[0]->mn_id?$colors[0]->mn_id:0;?>,1,8);return false;" />

            </div>

    </div>

                        </div>
                    </div>




                </div>
            </div>
        </div>
</form></div>
