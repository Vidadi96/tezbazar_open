
<h1 class="product-name">
Fringed ankle boots
</h1>
<div class="product-details-page">
<form method="post" id="product-details-form" action="/fringed-ankle-boots">
<div class="product-overview-line">
<div class="product-essential">

<div class="gallery">
<div class="picture">
<img alt="Picture of Fringed ankle boots" src="http://www.themes.pavilion.nop-templates.com/images/thumbs/0000189_fringed-ankle-boots_550.jpeg" title="Picture of Fringed ankle boots" />
</div>
</div>
<div class="overview">
<h1 class="product-variant-name">
Fringed ankle boots
</h1>
<div class="short-description">
Lorem ipsum suspendisse et ante vitae curabitur nisl curabitur ultrices et torquent magna, etiam justo morbi dui feugiat tortor nisi lorem sodales turpis augue, metus per diam faucibus nullam commodo quis tellus convallis mauris eget risus nostra euismod tempor.
</div>
<div class="prices" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<div class="product-price">
<span  itemprop="price" content="274.00" class="price-value-20" >
$274.00
</span>
</div>
<div class="old-product-price">
<label>Old price:</label>
<span>$290.00</span>
</div>
<meta itemprop="priceCurrency" content="USD" />
</div>
<script>
        function showHideDropdownQuantity(id) {
            $('select[name=' + id + '] > option').each(function () {
                $('#' + id + '_' + this.value + '_qty_box').hide();
            });
            $('#' + id + '_' + $('select[name=' + id + '] > option:selected').val() + '_qty_box').css('display', 'inline-block');
        };

        function showHideRadioQuantity(id) {
            $('input[name=' + id + ']:radio').each(function () {
                $('#' + $(this).attr('id') + '_qty_box').hide();
            });
            $('#' + id + '_' + $('input[name=' + id + ']:radio:checked').val() + '_qty_box').css('display', 'inline-block');
        };

        function showHideCheckboxQuantity(id) {
            if ($('#' + id).is(':checked'))
                $('#' + id + '_qty_box').css('display', 'inline-block');
            else
                $('#' + id + '_qty_box').hide();
        };
    </script>
<div class="attributes">
<dl>
<dt id="ajaxCart_product_attribute_label_31">
<label class="text-prompt">
Shoe Size Women
</label>
<span class="required">*</span>
</dt>
<dd id="ajaxCart_product_attribute_input_31">
<select name="ajaxCart_product_attribute_31" id="ajaxCart_product_attribute_31" >
<option value="76">7</option>
<option value="77">8 [&#x2B;$15.00]</option>
<option value="78">9 [&#x2B;$35.00]</option>
<option value="79">10 [&#x2B;$50.00]</option>
</select>
<script>
                                    $(document).ready(function() {
                                        showHideDropdownQuantity("ajaxCart_product_attribute_31");
                                    });
                                </script>
</dd>
<dt id="ajaxCart_product_attribute_label_32">
<label class="text-prompt">
Color
</label>
<span class="required">*</span>
</dt>
<dd id="ajaxCart_product_attribute_input_32">
<ul class="option-list attribute-squares color-squares" id="color-squares-32">
<li >
<label for="ajaxCart_product_attribute_32_523">
<span class="attribute-square-container" title="Black">
<span class="attribute-square" style="background-color:#2c2628;">&nbsp;</span>
</span>
<input id="ajaxCart_product_attribute_32_523" type="radio" name="ajaxCart_product_attribute_32" value="523"
                                                       />
</label>
</li>
<li  class="selected-value">
<label for="ajaxCart_product_attribute_32_80">
<span class="attribute-square-container" title="Brown">
<span class="attribute-square" style="background-color:#914729;">&nbsp;</span>
</span>
<input id="ajaxCart_product_attribute_32_80" type="radio" name="ajaxCart_product_attribute_32" value="80" checked="checked"
                                                       />
</label>
</li>
</ul>
<script type="text/javascript">
                                    $(document).ready(function() {
                                        $('.miniProductDetailsView .attributes #color-squares-32').on('click', 'input', function(event) {
                                            $('.miniProductDetailsView .attributes #color-squares-32').find('li').removeClass('selected-value');
                                            $(this).closest('li').addClass('selected-value');
                                        });
                                        showHideRadioQuantity("ajaxCart_product_attribute_32");
                                    });
                                </script>
</dd>
</dl>
</div>
<script type="text/javascript">
            function ajaxCart_attribute_change_handler_20(element) {
                var closestFormToAnElement = element.closest('form');
                var formSerialization = closestFormToAnElement.serialize();

                //Replace all occurrences of ajaxCart_product_attribute with product_attribute so that the "productdetails_attributechange" method would work fine.
                formSerialization = formSerialization.replace(new RegExp('ajaxCart_product_attribute', 'g'), 'product_attribute');

                $.ajax({
                    cache: false,
                    url: '/shoppingcart/productdetails_attributechange?productId=20&validateAttributeConditions=False&loadPicture=True',
                    data: formSerialization,
                    type: 'post',
                    success: function(data) {
                        if (data.price) {
                            $('.miniProductDetailsView .price-value-20').text(data.price);
                        }
                        if (data.basepricepangv) {
                            $('.miniProductDetailsView #base-price-pangv-20').text(data.basepricepangv);
                        }else {
                            $('.miniProductDetailsView #base-price-pangv-20').hide();
                        }
                        if (data.sku) {
                            $('.miniProductDetailsView #sku-20').text(data.sku).parent(".sku").show();
                        } else {
                            $('.miniProductDetailsView #sku-20').parent(".sku").hide();
                        }
                        if (data.mpn) {
                            $('.miniProductDetailsView #mpn-20').text(data.mpn).parent(".manufacturer-part-number").show();
                        } else {
                            $('.miniProductDetailsView #mpn-20').parent(".manufacturer-part-number").hide();
                        }
                        if (data.gtin) {
                            $('.miniProductDetailsView #gtin-20').text(data.gtin).parent(".gtin").show();
                        } else {
                            $('.miniProductDetailsView #gtin-20').parent(".gtin").hide();
                        }
                        if (data.stockAvailability) {
                            $('.miniProductDetailsView #stock-availability-value-20').text(data.stockAvailability);
                        }
                        if (data.enabledattributemappingids) {
                            for (var i = 0; i < data.enabledattributemappingids.length; i++) {
                                $('.miniProductDetailsView #ajaxCart_product_attribute_label_' + data.enabledattributemappingids[i]).show();
                                $('.miniProductDetailsView #ajaxCart_product_attribute_input_' + data.enabledattributemappingids[i]).show();
                            }
                        }
                        if (data.disabledattributemappingids) {
                            for (var i = 0; i < data.disabledattributemappingids.length; i++) {
                                $('.miniProductDetailsView #ajaxCart_product_attribute_label_' + data.disabledattributemappingids[i]).hide();
                                $('.miniProductDetailsView #ajaxCart_product_attribute_input_' + data.disabledattributemappingids[i]).hide();
                            }
                        }
                        if (data.pictureDefaultSizeUrl) {
                            $('.miniProductDetailsView #main-product-img-20').attr("src", data.pictureDefaultSizeUrl);
                        }
                        if (data.pictureFullSizeUrl) {
                            $('.miniProductDetailsView #main-product-img-lightbox-anchor-20').attr("href", data.pictureFullSizeUrl);
                        }
                        if (data.message) {
                            alert(data.message);
                        }
                        $(document).trigger({ type: "ajaxCart.product_attributes_changed", changedData: data, element: element });
                    }
                });
            }
            $(document).ready(function() {
                ajaxCart_attribute_change_handler_20($('.miniProductDetailsView #product-details-form'));
                $('#ajaxCart_product_attribute_31').change(function(){ajaxCart_attribute_change_handler_20($(this));});
$('#ajaxCart_product_attribute_32_523').click(function(){ajaxCart_attribute_change_handler_20($(this));});
$('#ajaxCart_product_attribute_32_80').click(function(){ajaxCart_attribute_change_handler_20($(this));});

            });
        </script>
<div class="add-to-cart">
<label class="qty-label" for="addtocart_20_EnteredQuantity">Qty:</label>
<input class="qty-input" type="text" type="text" data-val="true" data-val-required="The Qty field is required." id="addtocart_20_EnteredQuantity" name="addtocart_20.EnteredQuantity" value="1" />
<input type="button" id="add-to-cart-button-20" value="Add to cart" class="button-1 add-to-cart-button nopAjaxCartProductVariantAddToCartButton miniProductDetailsViewAddToCartButton" data-productId="20" />
<input id="addtocart_20_addProductVariantToCartUrl" name="addtocart_20.addProductVariantToCartUrl" type="hidden" value="/AddProductFromProductDetailsPageToCartAjax" /></div>
<div class="message-error"></div>
</div>
</div>
</div> <input name="__RequestVerificationToken" type="hidden" value="CfDJ8BZg4PhImT5Hp-usOReKji6fcD-alrwkeRZrHWwXbFvO6kjvDGCOknxUXnKo5Km6bx8JrRb7OSmIM4FEXmjVKuTP9PVuAu4ngtz6XXa7xH-x9PRECljfp4WFEQ-PtoMb13wq9qMfpTpCcHyCW5bWhfte7LES5DkzUCTo46VVpO5U2QCPAq5o9rqZtROYXH7plw" /></form>
</div>
