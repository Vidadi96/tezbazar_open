

<div id="nopAjaxFiltersNoProductsDialog" title="NO RESULTS FOUND">
    <p>There are no products for the filters that you selected. Please widen your search criteria.</p>
</div>
        <div class="product-grid nop7SpikesAjaxFiltersGrid">
            <div class="item-grid">
              <?php foreach($list as $item){
                  $this->load->view("site/product_item", $item);
              } ?>
            </div>
        </div>
        <div class="pager">
            <div>
                <ul><li class="current-page"><span>1</span></li><li class="individual-page"><a href="/getFilteredProducts?pagenumber=2">2</a></li><li class="next-page"><a href="/getFilteredProducts?pagenumber=2">Следно</a></li></ul>
            </div>
        </div>

<input id="specificationFilterModel7SpikesJson" name="specificationFilterModel7SpikesJson" type="hidden" value='{"CategoryId":56,"ManufacturerId":0,"VendorId":0,"Priority":0,"SpecificationFilterGroups":[],"NopAjaxFiltersSettings":null}' />
<input id="attributeFilterModel7SpikesJson" name="attributeFilterModel7SpikesJson" type="hidden" value='{"CategoryId":56,"ManufacturerId":0,"VendorId":0,"Priority":0,"AttributeFilterGroups":[],"NopAjaxFiltersSettings":null}' />
<input id="manufacturerFilterModel7SpikesJson" name="manufacturerFilterModel7SpikesJson" type="hidden" value='{"CategoryId":56,"VendorId":0,"Priority":0,"ManufacturerFilterItems":[{"Id":16,"Name":null,"FilterItemState":3},{"Id":32,"Name":null,"FilterItemState":0},{"Id":1,"Name":null,"FilterItemState":3},{"Id":72,"Name":null,"FilterItemState":0},{"Id":121,"Name":null,"FilterItemState":0},{"Id":122,"Name":null,"FilterItemState":3},{"Id":166,"Name":null,"FilterItemState":0}],"NopAjaxFiltersSettings":null}' />
<input id="vendorFilterModel7SpikesJson" name="vendorFilterModel7SpikesJson" type="hidden" value='{"CategoryId":56,"Priority":0,"VendorFilterItems":[],"NopAjaxFiltersSettings":null}' />
<input id="onSaleFilterModel7SpikesJson" name="onSaleFilterModel7SpikesJson" type="hidden" value='{"Id":0,"Name":null,"CategoryId":56,"ManufacturerId":0,"VendorId":0,"Priority":0,"FilterItemState":3,"NopAjaxFiltersSettings":null}' />
<input id="inStockFilterModel7SpikesJson" name="inStockFilterModel7SpikesJson" type="hidden" value="" />

<input id="urlHashQuery" name="urlHashQuery" type="hidden" value="prFilter=From-36!-#!To-190" />
<input id="currentPageSizeJson" name="currentPageSizeJson" type="hidden" value="16" />
<input id="currentViewModeJson" name="currentViewModeJson" type="hidden" value='"grid"' />
<input id="currentOrderByJson" name="currentOrderByJson" type="hidden" value="0" />
<input id="currentPageNumberJson" name="currentPageNumberJson" type="hidden" value="1" />
<input id="priceRangeFromJson" name="priceRangeFromJson" type="hidden" value="36" />
<input id="priceRangeToJson" name="priceRangeToJson" type="hidden" value="190" />
<input data-val="true" data-val-number="The field TotalCount must be a number." id="totalCount" name="totalCount" type="hidden" value="29" />




<!--
72
121
<input id="specificationFilterModel7SpikesJson" name="specificationFilterModel7SpikesJson" type="hidden" value="{"CategoryId":56,"ManufacturerId":0,"VendorId":0,"Priority":0,"SpecificationFilterGroups":[],"NopAjaxFiltersSettings":null}" />
<input id="attributeFilterModel7SpikesJson" name="attributeFilterModel7SpikesJson" type="hidden" value="{"CategoryId":56,"ManufacturerId":0,"VendorId":0,"Priority":0,"AttributeFilterGroups":[],"NopAjaxFiltersSettings":null}" />
<input id="manufacturerFilterModel7SpikesJson" name="manufacturerFilterModel7SpikesJson" type="hidden" value="{"CategoryId":56,"VendorId":0,"Priority":1,"ManufacturerFilterItems":[{"Id":16,"Name":null,"FilterItemState":3},{"Id":32,"Name":null,"FilterItemState":0},{"Id":1,"Name":null,"FilterItemState":3},{"Id":72,"Name":null,"FilterItemState":1},{"Id":121,"Name":null,"FilterItemState":1},{"Id":122,"Name":null,"FilterItemState":3},{"Id":166,"Name":null,"FilterItemState":0}],"NopAjaxFiltersSettings":null}" />
<input id="vendorFilterModel7SpikesJson" name="vendorFilterModel7SpikesJson" type="hidden" value="{"CategoryId":56,"Priority":0,"VendorFilterItems":[],"NopAjaxFiltersSettings":null}" />
<input id="onSaleFilterModel7SpikesJson" name="onSaleFilterModel7SpikesJson" type="hidden" value="{"Id":0,"Name":null,"CategoryId":56,"ManufacturerId":0,"VendorId":0,"Priority":0,"FilterItemState":3,"NopAjaxFiltersSettings":null}" />
<input id="inStockFilterModel7SpikesJson" name="inStockFilterModel7SpikesJson" type="hidden" value="" />

<input id="urlHashQuery" name="urlHashQuery" type="hidden" value="manFilters=72!##!121&amp;prFilter=From-36!-#!To-190" />
<input id="currentPageSizeJson" name="currentPageSizeJson" type="hidden" value="16" />
<input id="currentViewModeJson" name="currentViewModeJson" type="hidden" value=""grid"" />
<input id="currentOrderByJson" name="currentOrderByJson" type="hidden" value="0" />
<input id="currentPageNumberJson" name="currentPageNumberJson" type="hidden" value="1" />
<input id="priceRangeFromJson" name="priceRangeFromJson" type="hidden" value="36" />
<input id="priceRangeToJson" name="priceRangeToJson" type="hidden" value="190" />
<input data-val="true" data-val-number="The field TotalCount must be a number." id="totalCount" name="totalCount" type="hidden" value="19" />
-->
