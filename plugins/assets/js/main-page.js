var width = $('#sliderContainer').width();
var slide1_time = $('.slide1_time').text();
var slide1_active_passive = $('.slide1_active_passive').text();

var main_interval;

//dimensions
$('.slides>li').width(width);
$('.slides').width(width*$('.slides>li').length);

//positioning
$('.slides').css('left',-width);
$('.slides>li:last-child').prependTo('.slides');

//move slides forward
function nextSlide() {
  $('.slides').animate({
    'margin-left':-width
  },1000, function() {
    $('.slides>li:first-child').appendTo('.slides');
    $('.slides').css('margin-left', 0);
  });
}
//move slides backwards
function prevSlide() {
  $('.slides').animate({
    'margin-left':width
  },1000, function() {
    $('.slides>li:last-child').prependTo('.slides');
    $('.slides').css('margin-left', 0);
  });
}

//controls
$('#next').click(nextSlide);
$('#prev').click(prevSlide);
if(slide1_active_passive === '1')
  main_interval = setInterval(nextSlide, slide1_time*1000);

// SLIDE PARTNERS

var partners_slide_time = $('.partners_slide_time').text();
var partners_slide_active_passive = $('.partners_slide_active_passive').text();
var partners_interval;

  //positioning
   $('.slides5').css('left',-110);
   $('.slides5>li:last-child').prependTo('.slides5');

  //move slides forward
  function nextSlide5() {
    $('.slides5').animate({
      'margin-left':-110
    },1000, function() {
      $('.slides5>li:first-child').appendTo('.slides5');
      $('.slides5').css('margin-left', 0);
    });
  }
  //move slides backwards
  function prevSlide5() {
    $('.slides5').animate({
      'margin-left':110
    },1000, function() {
      $('.slides5>li:last-child').prependTo('.slides5');
      $('.slides5').css('margin-left', 0);
    });
  }

  //controls
  $('#partners .blackRightArrow').click(nextSlide5)
  $('#partners .blackLeftArrow').click(prevSlide5)
  if(partners_slide_active_passive === '1')
    partners_interval = setInterval(prevSlide5, partners_slide_time*1000)

// SLIDE POPULAR BRANDS

var brands_slide_time = $('.brands_slide_time').text();
var brands_slide_active_passive = $('.brands_slide_active_passive').text();
var brands_interval;

  //positioning
   $('.slides2').css('left',-110);
   $('.slides2>li:last-child').prependTo('.slides2');

  //move slides forward
  function nextSlide2() {
    $('.slides2').animate({
      'margin-left':-110
    },1000, function() {
      $('.slides2>li:first-child').appendTo('.slides2');
      $('.slides2').css('margin-left', 0);
    });
  }
  //move slides backwards
  function prevSlide2() {
    $('.slides2').animate({
      'margin-left':110
    },1000, function() {
      $('.slides2>li:last-child').prependTo('.slides2');
      $('.slides2').css('margin-left', 0);
    });
  }

  //controls
  $('#popularBrands .blackRightArrow').click(nextSlide2)
  $('#popularBrands .blackLeftArrow').click(prevSlide2)
  if(brands_slide_active_passive === '1')
    brands_interval = setInterval(prevSlide2, brands_slide_time*1000)

/*----- SLIDE KOLLEKSIYALAR -----*/

var width2 = 0;

if($(window).width() < 1150)
  width2 = 320;
else
  width2 = $('#sliderContainer3').width()/3 + 7;

var collections_interval;

  //dimensions
  $('.slides3>li').width(width2);
  $('.slides3').width(width2*$('.slides3>li').length);

  //positioning
  $('.slides3').css('left',-width2);
  $('.slides3>li:last-child').prependTo('.slides3');

 //move slides forward
 function nextSlide3() {
   $('.slides3').animate({
     'margin-left':-width2
   },1000, function() {
     $('.slides3>li:first-child').appendTo('.slides3');
     $('.slides3').css('margin-left', 0);
   });
 }
 //move slides backwards
 function prevSlide3() {
   $('.slides3').animate({
     'margin-left':width2
   },1000, function() {
     $('.slides3>li:last-child').prependTo('.slides3');
     $('.slides3').css('margin-left', 0);
   });
 }

 //controls
 $('#kolleksiyaTitle .blackRightArrow').click(nextSlide3)
 $('#kolleksiyaTitle .blackLeftArrow').click(prevSlide3)
 collections_interval = setInterval(nextSlide3, 20000)

/*----- SLIDE DAILY PRODUCTS -----*/

var width3 = $('#sliderContainer4').width();
var daily_products_time = $('.daily_products_time').text();
var daily_products_active_passive = $('.daily_products_active_passive').text();
var daily_interval;

  //dimensions
  $('.slides4>li').width(width3);
  $('.slides4').width(width3*$('.slides4>li').length);

  //positioning
  $('.slides4').css('left',-width3);
  $('.slides4>li:last-child').prependTo('.slides4');

 //move slides forward
 function nextSlide4() {
   $('.slides4').animate({
     'margin-left':-width3
   },1000, function() {
     $('.slides4>li:first-child').appendTo('.slides4');
     $('.slides4').css('margin-left', 0);
   });
 }
 //move slides backwards
 function prevSlide4() {
   $('.slides4').animate({
     'margin-left':width3
   },1000, function() {
     $('.slides4>li:last-child').prependTo('.slides4');
     $('.slides4').css('margin-left', 0);
   });
 }

 //controls
 $('#dailyProductsTitle .grayRightArrow').click(nextSlide4)
 $('#dailyProductsTitle .grayLeftArrow').click(prevSlide4)

 if(daily_products_active_passive === '1')
  daily_interval = setInterval(nextSlide4, daily_products_time*1000)

/*-----------------------------------------------------------------*/

  var width3_2 = $('#sliderContainer4_2').width();
  var daily_interval_2;

    //dimensions
    $('.slides4_2>li').width(width3_2);
    $('.slides4_2').width(width3_2*$('.slides4_2>li').length);

    //positioning
    $('.slides4_2').css('left',-width3_2);
    $('.slides4_2>li:last-child').prependTo('.slides4_2');

   //move slides forward
   function nextSlide4_2() {
     $('.slides4_2').animate({
       'margin-left':-width3_2
     },1000, function() {
       $('.slides4_2>li:first-child').appendTo('.slides4_2');
       $('.slides4_2').css('margin-left', 0);
     });
   }
   //move slides backwards
   function prevSlide4_2() {
     $('.slides4_2').animate({
       'margin-left':width3_2
     },1000, function() {
       $('.slides4_2>li:last-child').prependTo('.slides4_2');
       $('.slides4_2').css('margin-left', 0);
     });
   }

   //controls
   $('#dailyProductsTitle2 .grayRightArrow').click(nextSlide4_2)
   $('#dailyProductsTitle2 .grayLeftArrow').click(prevSlide4_2)

   if(daily_products_active_passive === '1')
    daily_interval_2 = setInterval(nextSlide4_2, daily_products_time*1000)


/*----- CLEAR INTERVAL IN UNFOCUS -----*/

$(window).on("blur focus", function(e) {
  switch (e.type) {
      case "blur":
          clearInterval(main_interval);
          clearInterval(brands_interval);
          clearInterval(collections_interval);
          clearInterval(daily_interval);
          clearInterval(daily_interval_2);
          clearInterval(partners_interval);
          break;
      case "focus":
          if(slide1_active_passive === '1')
            main_interval = setInterval(nextSlide, slide1_time*1000);
          if(brands_slide_active_passive === '1')
            brands_interval = setInterval(prevSlide2, brands_slide_time*1000)
          collections_interval = setInterval(nextSlide3, 20000)
          if(daily_products_active_passive === '1')
           daily_interval = setInterval(nextSlide4, daily_products_time*1000)
          if(daily_products_active_passive === '1')
           daily_interval_2 = setInterval(nextSlide4_2, daily_products_time*1000)
          if(partners_slide_active_passive === '1')
            partners_interval = setInterval(prevSlide5, partners_slide_time*1000)
          break;
  }
});

/*----- ADD PRODUCT TO CARD -----*/

token = $('#token').val()

$('.korzina').click(function(){

  event.preventDefault();
  var color_id = 0;
  var mn_id = 0;
  var count = 1;
  var p_id = 0;

  p_id = $(this).closest('form').find('input[name="product_id"]').val()
  mn_id = $(this).closest('form').find('input[name="mn_id"]').val()
  color_id = $(this).closest('form').find('input[name="color_id"]').val()

  $.ajax({
    url: '/profile/add_basket',
    type: 'POST',
    data: {product_id: p_id, color_id: color_id, mn_id: mn_id, count: count, order_status_id: 8, tezbazar: token},
    success: function(data){
      var result = $.parseJSON(data);
      if(result['status'] == 'success')
        toastr["success"](result['msg'], result['header'])

      if(result['status'] == 'error')
        toastr["error"](result['msg'], result['header'])

      $.ajax({
        url: '/pages/update_basket_count',
        type: 'POST',
        data: {tezbazar: token},
        success: function(data){
          var result = $.parseJSON(data);
          $('#basket_count').text(result[0].count);
        }
      });
    }
  });
});

// TOASTR OPTIONS

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1500",
  "timeOut": "2000",
  "extendedTimeOut": "1500",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
