var touch = false, clickEv = 'click', checkDropdown = [], checkSideMenu = [], checks_scroll = 0;  ;

/* slider product*/
function sliderProduct(){
  /* Home1 */
  /* slides block products */
  if($(".home_latestproducts_content").length){
    $(".home_latestproducts_content").owlCarousel({
      navigation : true,
      pagination: false,
      autoPlay: false,
      items: 4,
      slideSpeed : 200,
      paginationSpeed : 800,
      rewindSpeed : 1000,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [991,2],
      itemsTablet: [767,2],
      itemsTabletSmall: [540,1],
      itemsMobile : [360,1]
    });
  }
  /* Slider Thumb */
  if($(".slider-3itemsc").length){
    $(".slider-3itemsc").owlCarousel({
      navigation : true,
      pagination: false,
      autoPlay: false,
      items: 3,
      slideSpeed : 200,
      paginationSpeed : 800,
      rewindSpeed : 1000,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [991,3],
      itemsTablet: [767,4],
      itemsTabletSmall: [540,3],
      itemsMobile : [420,2]
    });
  }
  $(".show-load-detail").css("display", "none");
  
  /* Slider Relatedpro */
  if($(".related-products-full .rp-slider").length){
    $(".related-products-full .rp-slider").owlCarousel({
      navigation : true,
      pagination: false,
      items: 4,
      slideSpeed : 200,
      paginationSpeed : 800,
      rewindSpeed : 1000,
      itemsDesktop : [1920,4],
      itemsDesktopSmall : [1200,4],
      itemsTablet: [1199,4],
      itemsTabletSmall: [991,3],
      itemsMobile : [767,2]
    });
  } 
  if($(".related-products-sidebar .rp-slider").length){
    $(".related-products-sidebar .rp-slider").owlCarousel({
      navigation : true,
      pagination: false,
      items: 4,
      slideSpeed : 200,
      paginationSpeed : 800,
      rewindSpeed : 1000,
      itemsDesktop : [1920,4],
      itemsDesktopSmall : [1400,3],
      itemsTablet: [1199,3],
      itemsTabletSmall: [991,3],
      itemsMobile : [767,2]
    });
  } 

  $(".vertical-slider").bxSlider({
    mode: 'vertical',
    slideWidth: 100,
    minSlides: 4,
    nextText: '<i class="fa fa-angle-up" title="Previous" data-toggle="tooltip" data-placement="top"></i>',
    prevText: '<i class="fa fa-angle-down" title="Next" data-toggle="tooltip" data-placement="top"></i>',
    hideControlOnEnd: true,
    infiniteLoop: false,
    pager: false,
    slideMargin: 0
  });
  
}

/* slider product*/
function sliderBlog(){
  if($(".related-blog-slider").length){
    $(".related-blog-slider").owlCarousel({
      navigation : true,
      pagination: false,
      autoPlay: false,
      items: 3,
      slideSpeed : 200,
      paginationSpeed : 800,
      rewindSpeed : 1000,
      itemsDesktop : [1199,1],
      itemsDesktopSmall : [991,1],
      itemsTablet: [767,1],
      itemsTabletSmall: [540,1],
      itemsMobile : [360,1]
    });
  }
}

/* Handle dropdown box */
function handleDropdown(){
  var changeIcon = function() {
    $( ".dropdownMobile-toggle" ).each(function( index ) {
      $(this).parent().find('.dropdown-menu').hide();
      $(this).removeClass('active-dropdown');
      var icon_class=$(this).find('.icon-dropdown').data('class');
      $(this).find('.icon-dropdown').attr('class','icon-dropdown '+icon_class);
    });
  }
  var dropdownDesktop = function() {
    if($('.dropdown-toggle').length){
      $('.dropdown-toggle').parent().hover(function (){
        if(touch == false && getWidthBrowser() > 767 ){
          $(this).find('.dropdown-menu').stop(true, true).slideDown(300);
        }
      }, function (){
        if(touch == false && getWidthBrowser() > 767 ){
          $(this).find('.dropdown-menu').hide();
        }
      });
    }
  }
  var dropdownTablet = function(){
    if($('.dropdownMobile-toggle').length){
      $('.dropdownMobile-toggle').on('click', function() {
        if(!$(this).hasClass('active-dropdown')){
          changeIcon();
          $('body').addClass('active-overflow');
          $(this).parent().find('.dropdown-menu').stop(true, true).slideDown(300);
          $(this).addClass('active-dropdown');
          $(this).find('.icon-dropdown').attr('class','icon-dropdown cs-icon icon-close');
        }
        else{
          $('body').removeClass('active-overflow');
          changeIcon();
        }
      });
    }
  }
  $('nav .dropdown-menu').each(function(){
    $(this).find('li').last().addClass('last');
  });
  $('.dropdown').on('click', function() {
    if(touch == false && getWidthBrowser() > 767 ){
      var href = $(this).find('.dropdown-link').attr('href');
      window.location = href;
    }
  });
  dropdownDesktop();
  dropdownTablet();
}

/* Fucntion get width browser */
function getWidthBrowser() {
  var myWidth;

  if( typeof( window.innerWidth ) == 'number' ) { 
    //Non-IE 
    myWidth = window.innerWidth;
    //myHeight = window.innerHeight; 
  } 
  else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) { 
    //IE 6+ in 'standards compliant mode' 
    myWidth = document.documentElement.clientWidth; 
    //myHeight = document.documentElement.clientHeight; 
  } 
  else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) { 
    //IE 4 compatible 
    myWidth = document.body.clientWidth; 
    //myHeight = document.body.clientHeight; 
  }

  return myWidth;
}

// handle scroll-to-top button
function handleScrollTop() {
  function totop_button(a) {
    var b = $("#scroll-to-top"),
        f = $(".cart-float-right");

    if (a == "on") { 
      f.addClass("on fadeInRight ").removeClass("off fadeOutRight");
      b.addClass("on fadeInRight ").removeClass("off fadeOutRight"); 
    } else {
      f.addClass("off fadeOutRight animated").removeClass("on fadeInRight");
      b.addClass("off fadeOutRight animated").removeClass("on fadeInRight"); 
    }
  }
  $(window).scroll(function() {
    var b = $(this).scrollTop();
    var c = $(this).height();
    if (b > 0) { 
      var d = b + c / 2;
    } 
    else { 
      var d = 1 ;
    }    
    if (d < 1e3 && d < c) { 
      totop_button("off");
    } 
    else {
      totop_button("on"); 
    }
  });  
  $("#scroll-to-top").click(function (e) {
    e.preventDefault();
    $('body,html').animate({scrollTop:0},800,'swing');
  });
}   

//newsletter popup
function ModalNewsletter(){
  var showNewsletter = function(date){
    $('#newsletter-popup').modal('toggle');
    $('.nl-wraper-popup').addClass('animated'); 
    var tnout = 20 ;
    setTimeout (function() { 
      $('#newsletter-popup').modal('hide');
    }, tnout*1000 );
    localStorage.setItem('cs-newsletter', date );
  }
  var checkNewsletter = function(){
    var date = '05/04/2018 05:06:14';
    if(localStorage.getItem('cs-newsletter') == null || localStorage.getItem('cs-newsletter') == "undefined" ){
	  showNewsletter(date);
    }
    else{
      var check_time = new Date(date) - new Date(localStorage.getItem('cs-newsletter'));
      var ms = check_time % 1000;
      check_time = (check_time - ms) / 1000;
      var days = Math.floor(check_time / 86400);
      if(days > 7){
        showNewsletter(date);
      }
    }
  }
  
  checkNewsletter();
  
}

/* Handle product quantity */
function handleQuantity(){
  if($('.quantity-wrapper').length){
    $('.quantity-wrapper').on(clickEv, '.qty-up', function() {
      var $this = $(this);

      var qty = $this.parents('.wrapper').find('input');
      $(qty).val(parseInt($(qty).val()) + 1);
    });
    $('.quantity-wrapper').on(clickEv, '.qty-down', function() {
      var $this = $(this);
      var qty = $this.parents('.wrapper').find('input');

      if(parseInt($(qty).val()) > 1)
        $(qty).val(parseInt($(qty).val()) - 1);
    });
  }
}

function colorwarches(){
  jQuery('.swatch :radio').change(function() {
    var optionIndex = jQuery(this).closest('.swatch').attr('data-option-index');
    var optionValue = jQuery(this).val();
    jQuery(this)
    .closest('form')
    .find('.single-option-selector')
    .eq(optionIndex)
    .val(optionValue)
    .trigger('change');
  }); 
}

function toggleTagsFilter(){ 
  if(window.innerWidth >= 768 ){
    var tagsbutton = document.getElementById( 'showTagsFilter' ),    
        tagscontent = document.getElementById( 'tags-filter-content' );    
    if(tagsbutton != null ){
      tagsbutton.onclick = function() {
        classie.toggle( this, 'closed' );
        classie.toggle( tagscontent, 'tags-closed' );
        if(classie.has( this, 'closed' ))
          $('#showTagsFilter').html("Filter <i class='fa fa-angle-down'></i>");
        else $('#showTagsFilter').html("Filter <i class='fa fa-angle-up'></i>");
      };
    }
  }
}

/* Function update scroll product thumbs */
function updateScrollThumbsQS(){
  if($('#gallery_main_qs').length){

    $('#quick-shop-image .fancybox').on(clickEv, function() {
      var _items = [];
      var _index = 0;
      var product_images = $('#gallery_main_qs .image-thumb a');
      product_images.each(function(key, val) {
        _items.push({'href' : val.href, 'title' : val.title});
        if($(this).hasClass('active')){
          _index = key;
        }
      });
      $.fancybox(_items,{
        closeBtn: true,
        index: _index,
        helpers: {
          buttons: {}
        }
      });
      return false;
    });

    $('#quick-shop-image').on(clickEv, '.image-thumb a', function() {

      var $this = $(this);
      var background = $('.product-image .main-image .main-image-bg');
      var parent = $this.parents('.product-image-wrapper');
      var src_original = $this.attr('data-image-zoom');
      var src_display = $this.attr('data-image');

      background.show();

      parent.find('.image-thumb').removeClass('active');
      $this.parent().addClass('active');

      parent.find('.main-image').find('img').attr('data-zoom-image', src_original);
      parent.find('.main-image').find('img').attr('src', src_display).load(function() {
        background.hide();
      });

      return false;
    });
  }
}

//Change Quantity Quick Show
function change_qs_quantity(qs){
  qs_quantity=qs;
}

function showMenuMobile(){
  var changeIconRight = function() {
    $( ".dropdownMobile-toggle" ).each(function( index ) {
      $(this).parent().find('.dropdown-menu').hide();
      $(this).removeClass('active-dropdown');
      var icon_class=$(this).find('.icon-dropdown').data('class');
      $(this).find('.icon-dropdown').attr('class','icon-dropdown '+icon_class);
    });
  }
  var changeIcon = function(){
    $('.navigation_mobile .arrow').removeClass('class_test');
    $('.navigation_mobile .arrow i').attr('class', 'cs-icon icon-ios-plus-empty');
    $('.navigation_mobile').removeClass('active_dropdown');
    $('.navigation_mobile .menu-mobile-container').hide("slow");
  }
  var showMenu = function(){
    $('.group_navbtn_action .dropdown-toggle-navigation').on('click', function() {
      $(this).addClass('active-dropdown');
      $(this).parent().find('.navigation_dropdown_scroll').addClass("hover-dropdown");
    });
  }
  var closeMenu = function(){
    $('.group_navbtn_action .close-navigation-dropdown').on('click', function() {
      $(this).parents('.navigation_dropdown_scroll').removeClass("hover-dropdown");
    });
    $('.navigation_dropdown_scroll').on('click', function(){
      if($(this).hasClass('hover-dropdown')){
        $(this).removeClass("hover-dropdown");
      }
    }).find('.navigation_dropdown_scroll_group').on('click', function(){
      return false;
    });
  }
  var showMegaMenu = function(){
    $('.navigation_mobile .arrow').on('click', function() {
      if($(this).hasClass('class_test')){
        $(this).removeClass('class_test');
        $(this).find('i').attr('class', 'cs-icon icon-ios-plus-empty');
        $(this).parent().removeClass('active_dropdown');
        $(this).parent().find('.menu-mobile-container').hide("slow");
      }
      else{
        changeIcon();
        $(this).addClass('class_test');
        $(this).find('i').attr('class', 'cs-icon icon-ios-minus-empty');
        $(this).parent().addClass('active_dropdown');
        $(this).parent().find('.menu-mobile-container').show("slow");
      }
    });
  }
  var showSubMenu = function(){
    $('.navigation_sub_mobile .arrow_sub_mobile').click(function(){
      if($(this).hasClass('class_test')){
        $(this).removeClass('class_test');
        $(this).find('i').attr('class', 'cs-icon icon-ios-plus-empty');
        $(this).parent().removeClass('active_dropdown');
        $(this).parent().find('.sub-menu-mobile-container').hide("slow");
      }
      else{
        $(this).addClass('class_test');
        $(this).find('i').attr('class', 'cs-icon icon-ios-minus-empty');
        $(this).parent().addClass('active_dropdown');
        $(this).parent().find('.sub-menu-mobile-container').first().show("slow");
      }
    });
  }
  var showShowInfo = function(){
    $('.icon_info .show-info').on('click', function() {
      $('#top .info-header').addClass('active');
      $('#top').attr("id","top-activeRight");
    });
    $('.info-header .close-info').on('click', function() {
      $('#top-activeRight').attr("id","top");
      $('#top').removeClass('affix fadeInDown animated');
      $('#top .info-header').removeClass('active');
      $('body,html').animate({scrollTop:0},1,'swing');
    });
    $('.info-header').on('click', function(){
      if($(this).hasClass('active')){
        $('#top-activeRight').attr("id","top");
        $('#top').removeClass('affix fadeInDown animated');
        $('#top .info-header').removeClass('active');
        $('body,html').animate({scrollTop:0},1,'swing');
      }
    }).find('.info-header-wrapper').on('click', function(){
      return false;
    });
  }
  var gotoLink = function(){
    $('#top .mobile-goto-link').on('click', function(){
      if($('.info-header').hasClass('active')){
        location.href = $(this).attr("href");
      }
      else if($('.navigation_dropdown_scroll').hasClass('hover-dropdown')){
        location.href = $(this).attr("href");
      }
    });
  }
  showMenu();
  gotoLink();
  closeMenu();
  showMegaMenu();
  showSubMenu();
  showShowInfo();
}

function showItemMobile(){
  $('.item-dropdown-mobile .btn-group').on('click', '.dropdown-toggle', function() {
    $('.item-dropdown-mobile .dropdown-menu').css('display','none');

    if($(this).hasClass('active_popup')){
      $(this).removeClass('active_popup');
    }
    else{
      $('.item-dropdown-mobile .dropdown-toggle').removeClass('active_popup');
      $(this).addClass('active_popup');
      $('.item-dropdown-mobile').each(function(){
        if($(this).find('.dropdown-toggle').hasClass('active_popup')){
          $(this).find('.dropdown-menu').css('display','block');
        }
      });
    }
  });
}

function showPassword(){
  $(".form-password .cs-icon").on(clickEv, function() {
    if($(this).hasClass("show-pass")){
      $(this).parent().find("input").attr('type','password');
      $(this).removeClass("show-pass");
    }
    else{
      $(this).parent().find("input").attr('type','text');
      $(this).addClass("show-pass");
    }
  });
}

function sidebarBlog(){
  $(".sidebar-block .sidebar-title").on(clickEv, '.cs-icon', function() {
    if($(this).hasClass("show-content")){
      $(this).parents('.sidebar-block').find(".sidebar-content").show( "slow" );
      $(this).attr('class','cs-icon icon-ios-minus-empty');
    }
    else{
      $(this).parents('.sidebar-block').find(".sidebar-content").hide( "slow" );
      $(this).attr('class','show-content cs-icon icon-ios-plus-empty');
    }
  });
}

function tagFilterCollection(){
  var newQuery = '';
  var init = function(){
    Shopify.queryParams = {};
    if (location.search.length) {
      for (var aKeyValue, i = 0, aCouples = location.search.substr(1).split('&'); i < aCouples.length; i++) {
        aKeyValue = aCouples[i].split('=');
        if (aKeyValue.length > 1) {
          Shopify.queryParams[decodeURIComponent(aKeyValue[0])] = decodeURIComponent(aKeyValue[1]);
        }
      }
    }
  }
  var createUrl = function(url,queryParams){
    history.pushState({
      param: queryParams
    }, url, url);
    $.ajax({
      type: 'GET',
      url: url,
      data: {},
      beforeSend: function( xhr ) {
        $("#tags-load").show();
      },
      complete: function (data) {  
        $('#collection').html($("#collection", data.responseText).html());      
        $("#tags-load").hide();
        var urls = "\/\/productreviews.shopifycdn.com\/assets\/v4\/spr.js?shop=";
        $.getScript(urls, function() {
        });
        handleGridList();
        toggleTagsFilter();
        $(GLOBAL['common']['init']);
        filterClick();
        sidebarBlog();
        clearFilterMobile();
        applyFilterMobile();
        paginationCollection();
        showFilter();
        if(checkCollection == 1){
          removeFilter();
        }
      }
    });
  }
  var filterClick = function(){
    $('.filter-block .filter-content li > a').click(function(event) {
      event.preventDefault();
      var newTags = [];
      if (Shopify.queryParams.constraint) {
        newTags = Shopify.queryParams.constraint.split('+');
      }
      var dataHandle = $(this).parents('li').data("handle");
      if (dataHandle) {
        var tagCheck = newTags.indexOf(dataHandle);
        if (tagCheck >= 0) {
          newTags.splice(tagCheck, 1);
        } else {
          newTags.push(dataHandle);
        }
      }
      if (newTags.length) {
        Shopify.queryParams.constraint = newTags.join('+');
      } else {
        delete Shopify.queryParams.constraint;
      }
      delete Shopify.queryParams.page;
      newQuery = jQuery.param(Shopify.queryParams).replace(/%2B/g, '+');

      if(getWidthBrowser() > 991 ){
        var url = location.pathname + "?" + newQuery;
        createUrl(url,Shopify.queryParams);
      }
      else{
        if($(this).parents('li').hasClass('active')){
          $(this).parents('li').removeClass('active');
        }
        else{
          $(this).parents('li').addClass('active');
        }
      }
    });
  }
  var clearFilterMobile = function(){
    $('.collection-leftsidebar .sidebarMobile-clear').on(clickEv, function() {
      var url = '/collections/all' ;
      createUrl(url,url);
      $('#collection .collection-leftsidebar').removeClass('active');
      $('body').removeClass('active-sidebar');
    });
  }
  var applyFilterMobile = function(){
    $('.sidebar-bottom .sidebarMobile-close').on(clickEv, function() {
      var url = location.pathname + "?" + newQuery;
      createUrl(url,Shopify.queryParam);
      $('.collection-leftsidebar').removeClass('active');
      $('body').removeClass('active-sidebar');
    });
  }
  var paginationCollection = function(){
    $('.pagination-collection li a').on(clickEv, function(event) {
      event.preventDefault();
      var linkPage = $(this).attr("href").match(/page=\d+/g);
      if (linkPage) {
        Shopify.queryParams.page = parseInt(linkPage[0].match(/\d+/g));
        if (Shopify.queryParams.page) {
          newQuery = jQuery.param(Shopify.queryParams).replace(/%2B/g, '+');
		  var url = location.pathname + "?" + newQuery;
          createUrl(url,Shopify.queryParam);
          $('body,html').animate({scrollTop:0},1,'swing');
        }
      }
    });
  }
  var removeFilter = function(){
    $('.collection-leftsidebar').removeClass('active');
    $('body').removeClass('active-sidebar');
  }
  var activeFilter = function(){
    $('.collection-leftsidebar').addClass('active');
    $('body').addClass('active-sidebar');
  }
  var showFilter = function(){
    $('.show-leftsidebar').on(clickEv, function() {
      if($('.collection-leftsidebar').hasClass('active')){
        removeFilter();
      }
      else{
        activeFilter();
      }
    });
    $('.close-leftsidebar').on(clickEv, function() {
      removeFilter();
    });
  }
  
  init();
  if(checkCollection != 0){
  filterClick();
  }
  clearFilterMobile();
  applyFilterMobile();
  paginationCollection();
  showFilter();
}

$(window).ready(function($) {
  
  handleDropdown();
  
  $('.not-animated').css("opacity","1");
  
  tagFilterCollection();
  
  sidebarBlog();
  
  showPassword();
  
  showItemMobile();

  sliderProduct();
  
  sliderBlog();

  handleScrollTop();

  colorwarches();

  $('[data-toggle="tooltip"]').tooltip();

  handleQuantity();

  toggleTagsFilter();

  updateScrollThumbsQS();

  showMenuMobile();
});


$(window).load(function() { 
  
  

  ModalNewsletter();
  
});
