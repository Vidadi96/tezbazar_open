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


<div class="page contact-page">
<div class="page-title">
    <h1><?=$this->langs->contactus;?></h1>
</div>


<div style="width: 30%; float: left;">
<?php foreach ($markers as $value) {
  echo '<a class="addr_container" id="'.$value->map_id.'">
  <h4 class="addr_title">'.$value->title.'</h4>
  <p>'.$value->content.'</p>
  </a>';
}?>
<br />
<br />
    <a class="write_to_us" href="javascript:;" style="border-bottom: 1px solid #136499; font-size: 16px; color: #136499;"><?=$this->langs->write_to_us;?> <img style="margin-left: 3px; width: 16px; margin-bottom: -2px;" src="/img/icons/24x24/write_to_us.png"></a>

</div>
<div style="width: 70%; float: right; padding-right: 10px;">
  <div id="map" class="map" style="
height: 300px;
width: 100%;
border: 1px solid #DDD;
"></div>

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/icon.css">





<script type="text/javascript">
	$(document).ready(function(){
    //jQuery(document).on('click', '#button', function(e){alert();});
    $(document).on("click", ".contact-us-button", function(evt){
      evt.preventDefault();
      var data = $(this).closest("form").serialize();

      $.post("/contactus/submit_letter/",{data:data, "<?php echo $this->security->get_csrf_token_name(); ?>":$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()},function(res){
        var obj = JSON.parse(res);
        if(obj.status=="error")
        {
          alert(obj.msg);
        }else {
          $(".ui-dialog").fadeOut(500,function(){
            $(this).remove();
            alert(obj.msg);
          })
        }

      })
    })
    $(".write_to_us").click(function(){
      displayPopupContentFromUrl('/contactus/write_to_us/', '<?=$this->langs->write_to_us;?>');

    });
    $(window).on("load", function(){
      //console.log("555")
    	init_map();
    });
		map_init_count = 1;

		/*** Google map ***/
		var marker = [];
    var infowindow = [];
		function init_map()
		{

      $(".addr_container").click(function(){
        $(".addr_container").removeClass("clicked_addr");
        $(this).addClass("clicked_addr");



        //console.log(marker[$(this).attr("id")].position);
        map.setCenter(marker[$(this).attr("id")].position);
				map.setZoom(17);
        $.each( infowindow, function( ind, value ) {
          if(ind in infowindow )
          infowindow[ind].close();
        });
        var map_id = $(this).attr("id");
        infowindow[map_id].open(map, marker[map_id]);

      });

			var mapOptions =
			{
				zoom: 11,
				/*scrollwheel: false,*/
				center: new google.maps.LatLng(40.3892737, 49.7889018),
				mapTypeControl: false,
				mapTypeId: google.maps.MapTypeId.roadmap,
				panControl: true,
				panControlOptions: {
					position: google.maps.ControlPosition.RIGHT
				},
				zoomControl: true,
				//scaleControl: true,
				zoomControlOptions: {
					style: google.maps.ZoomControlStyle.LARGE,
					position: google.maps.ControlPosition.RIGHT
				},
			}
			map = new google.maps.Map($("#map").get(0), mapOptions);

/*pillar_image = new google.maps.MarkerImage("/images/icons/24x24/parking.png", new google.maps.Size(24, 24), new google.maps.Point(0, 0), new google.maps.Point(10, 0));
									// console.log("parking");
									var pillar_lat_lng = new google.maps.LatLng(data.data[i].l[0],data.data[i].l[1]);
									track_marker[data.data[i].s[3]] = new google.maps.Marker({position: pillar_lat_lng, map: map, cursor: 'pointer', icon: pillar_image, optimized: true, zIndex: google.maps.Marker.MAX_ZINDEX + 1});*/



      var markers_json = <?=json_encode($markers);?>;

      markers_json.forEach((item) => {
        var marker_icon = "/img/marker2.png";
        // if(marker[1].length != 0)
        // marker['.$marker->map_id.'].setMap(null);
        var pillar_lat_lng = new google.maps.LatLng(item.lat, item.lng);
        marker[item.map_id] = new google.maps.Marker({
          position: pillar_lat_lng,
          map: map,
          draggable:false,
          animation: google.maps.Animation.DROP,
          title:"",
          cursor: "pointer",
          icon: marker_icon,
          optimized: true
        });
        marker[item.map_id].setValues({map_id: item.map_id});





        google.maps.event.addListener(marker[item.map_id], 'click', function() {
          $.each( infowindow, function( ind, value ) {
    				if(ind in infowindow )
    				infowindow[ind].close();
    			});
          var map_id = this.map_id;

          infowindow[map_id] = new google.maps.InfoWindow({
              content: '<strong>'+item.title+'</strong><br /><p>'+item.content+'</p>'
          });
          infowindow[map_id].open(map, marker[item.map_id]);

        })


      });


		}
	});
</script>

</div>



</div>


</div>

    </div>

</div>
