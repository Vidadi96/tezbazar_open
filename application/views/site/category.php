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




        <?=$breadcrumb;?>

            <div class="master-column-wrapper">



    <div class="center-2">



<div class="page category-page">
    <div class="page-title">
        <h1><?=$cat->cat_name;?></h1>
    </div>
    <div class="page-body">








<div class="product-selectors">

        <div class="product-viewmode">
            <span>Види како</span>
                <a class="viewmode-icon grid selected" href="https://www.officeplus.mk/торби?viewmode=grid" title="Табела">Табела</a>
                <a class="viewmode-icon list " href="https://www.officeplus.mk/торби?viewmode=list" title="Листа">Листа</a>
        </div>
            <div class="product-sorting">
            <span><?=$this->langs->sort_by;?></span>
            <select id="products-orderby" name="products-orderby" onchange="setLocation(this.value);"><option selected="selected" value="0"><?=$this->langs->position;?></option>
<option value="5"><?=$this->langs->a_z;?></option>
<option value="6"><?=$this->langs->z_a;?></option>
<option value="10"><?=$this->langs->price_0_9;?></option>
<option value="11"><?=$this->langs->price_9_0;?></option>
<option value="15"><?=$this->langs->created_on;?></option>
</select>
        </div>
            <div class="product-page-size">
            <span><?=$this->langs->display;?></span>
            <select id="products-pagesize" name="products-pagesize" onchange="setLocation(this.value);"><option selected="selected" value="https://www.officeplus.mk/торби?pagesize=16">16</option>
<option value="https://www.officeplus.mk/торби?pagesize=32">32</option>
<option value="https://www.officeplus.mk/торби?pagesize=64">64</option>
<option value="https://www.officeplus.mk/торби?pagesize=128">128</option>
</select>
            <span><?=$this->langs->per_page;?></span>
        </div>
</div>



            <div class="product-grid">
                <div class="item-grid">
                  <?php foreach($list as $item){
                      $this->load->view("site/product_item", $item);
                  } ?>
                </div>
            </div>

            <div class="pagination">
              <ul>
                <?=$pagination;?>
                </ul>
            </div>

    </div>
</div>



    </div>

<div class="side-2">

    <div class="page-title">
        <h1><?=$cat->cat_name;?></h1>
    </div>





<div class="nopAjaxFilters7Spikes"
     data-categoryid="<?=$this->uri->segment(3);?>"
     data-manufacturerid="0"
     data-vendorid="0"
     data-isonsearchpage="False"
     data-searchkeyword=""
     data-searchcategoryid="0"
     data-searchmanufacturerid="0"
     data-searchvendorid ="0"
     data-searchpricefrom=""
     data-searchpriceto=""
     data-searchincludesubcategories="False"
     data-searchinproductdescriptions="False"
     data-searchadvancedsearch="False"
     data-getfilteredproductsurl="/ajax/filter_products"
     data-productslistpanelselector=".product-list"
     data-productsgridpanelselector=".product-grid"
     data-pagerpanelselector=".pager"
     data-pagerpanelintegrationselector=".product-grid, .product-list"
     data-sortoptionsdropdownselector="#products-orderby"
     data-viewoptionsdropdownselector=".viewmode-icon, #products-viewmode"
     data-productspagesizedropdownselector="#products-pagesize"
     data-filtersuimode="usecheckboxes"
     data-defaultviewmode="grid"
     data-enableinfinitescroll="False"
     data-infinitescrollloadertext="Loading more products ..."
     data-scrolltoelement="False"
     data-scrolltoelementselector=".product-selectors"
     data-showselectedfilterspanel="False"
     data-numberofreturnedproductsselector="false"
     data-selectedOptionsTargetSelector=".nopAjaxFilters7Spikes .filtersPanel:first"
     data-selectedOptionsTargetAction="prependTo"
     data-isRTL="false"
     data-closeFiltersPanelAfterFiltrationInMobile="true">

        <div class="filtersTitlePanel">
            <p class="filtersTitle">Filter by:</p>
            <a class="clearFilterOptionsAll"><?=$this->langs->clear_all;?></a>
        </div>
        <div class="filtersPanel">




<div class="block filter-block priceRangeFilterPanel7Spikes" data-currentcurrencysymbol="ден">
    <div class="title">
        <a class="toggleControl"><?=$this->langs->price;?></a>
        <a class="clearPriceRangeFilter"><?=$this->langs->clear;?></a>
    </div>
    <div class="filtersGroupPanel" style="">
        <div class="priceRangeMinMaxPanel">
            <span class="priceRangeMinPanel">
                <span><?=$this->langs->min;?>:</span>
                <span class="priceRangeMinPrice"><?=$min;?> AZN</span>
            </span>
            <span class="priceRangeMaxPanel">
                <span><?=$this->langs->max;?>:</span>
                <span class="priceRangeMaxPrice"><?=$max;?> AZN</span>
            </span>
        </div>
        <div id="slider" data-sliderminvalue="<?=$min;?>" data-slidermaxvalue="<?=$max;?>"
             data-selectedfromvalue="<?=$min;?>" data-selectedtovalue="<?=$max;?>"
             data-customformatting="#,###,##0.00 AZN">
        </div>
        <div class="priceRangeCurrentPricesPanel">
            <span class="currentMinPrice"><?=$min;?> AZN</span>
            <span class="currentMaxPrice"><?=$max;?> AZN</span>
        </div>
    </div>
</div>













<div class="block filter-block manufacturerFilterPanel7Spikes">
    <div class="title">
        <a class="toggleControl"><?=$this->langs->brand;?></a>
        <a class="clearFilterOptions"><?=$this->langs->clear;?></a>
    </div>
    <div class="filtersGroupPanel filtersCheckboxPanel" style="">
        <ul class="checkbox-list">
        <?php foreach ($brands as $brand) {
          if($brand->brand_id)
          {
            echo '<li class="checkbox-item">
                <input  data-option-ids="'.$brand->brand_id.'" type="checkbox" id="manufacturer-input-'.$brand->brand_id.'" />
                <label class="filter-item-name" for="manufacturer-input-'.$brand->brand_id.'">'.$brand->brand_name.'</label>
            </li>';
          }

        }?>


        </ul>
    </div>
</div>

        </div>
        <div class="block filter-block selected-options" style="display: none;">
            <div class="title">
                <a class="toggleControl">Selected Options</a>
            </div>
            <div class="filtersGroupPanel">
                <ul class="selected-options-list"></ul>
            </div>
        </div>
        <div class="number-of-returned-products sample-element" style="display: none;">
            <span class="showing-text">Showing</span>
            <span class="productsPerPage"></span>
            <span class="of-text">of</span>
            <span class="allProductsReturned"></span>
            <span class="results-text">results</span>
        </div>
        <div class="returned-products-filters-panel" style="display: none;">
            <span class="allProductsReturned"></span>
        </div>
</div>




<input id="availableSortOptionsJson" name="availableSortOptionsJson" type="hidden" value='[{"Disabled":false,"Group":null,"Selected":true,"Text":"<?=$this->langs->position;?>","Value":"0"},{"Disabled":false,"Group":null,"Selected":false,"Text":"<?=$this->langs->a_z;?>","Value":"5"},{"Disabled":false,"Group":null,"Selected":false,"Text":"<?=$this->langs->z_a;?>","Value":"6"},{"Disabled":false,"Group":null,"Selected":false,"Text":"<?=$this->langs->price_0_9;?>","Value":"10"},{"Disabled":false,"Group":null,"Selected":false,"Text":"<?=$this->langs->price_9_0;?>","Value":"11"},{"Disabled":false,"Group":null,"Selected":false,"Text":"<?=$this->langs->created_on;?>","Value":"15"}]' />
<input id="availableViewModesJson" name="availableViewModesJson" type="hidden" value='[{"Disabled":false,"Group":null,"Selected":true,"Text":"Табела","Value":"grid"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Листа","Value":"list"}]' />
<input id="availablePageSizesJson" name="availablePageSizesJson" type="hidden" value='[{"Disabled":false,"Group":null,"Selected":true,"Text":"16","Value":"16"},{"Disabled":false,"Group":null,"Selected":false,"Text":"32","Value":"32"},{"Disabled":false,"Group":null,"Selected":false,"Text":"64","Value":"64"},{"Disabled":false,"Group":null,"Selected":false,"Text":"128","Value":"128"}]' />




</div>


        </div>

    </div>
