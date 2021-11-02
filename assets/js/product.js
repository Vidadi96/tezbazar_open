
var height = ($(window).width() > 1150)?80:40;
$(document).ready(function() {
  //dimensions
  $('.slides>li').height(height);
  $('.slides').height(height*$('.slides>li').length);

  //positioning
   // $('.slides').css('top',-height);
   $('.slides>li:last-child').prependTo('.slides');

  //move slides forward
  function nextSlide() {
    $('.slides').animate({
      'margin-top':-height
    },500, function() {
      $('.slides>li:first-child').appendTo('.slides');
      $('.slides').css('margin-top', 0);
    });
  }
  //move slides backwards
  function prevSlide() {
    $('.slides').animate({
      'margin-top':height
    },500, function() {
      $('.slides>li:last-child').prependTo('.slides');
      $('.slides').css('margin-top', 0);
    });
  }

  //controls
  $('#next').click(nextSlide)
  $('#prev').click(prevSlide)

/*----- BU MEHSULNAN ALIRLAR SLIDE -----*/

  var width2 = ($(window).width() < 1150)?290:$('#sliderContainer2 li').width();

  $('.slides2>li').width(width2);

  //positioning
  $('.slides2>li:last-child').prependTo('.slides2');

 //move slides forward
 function nextSlide2() {
   $('.slides2').animate({
     'margin-left':-width2
   },1000, function() {
     $('.slides2>li:first-child').appendTo('.slides2');
     $('.slides2').css('margin-left', 0);
   });
 }
 //move slides backwards
 function prevSlide2() {
   $('.slides2').animate({
     'margin-left':width2
   },1000, function() {
     $('.slides2>li:last-child').prependTo('.slides2');
     $('.slides2').css('margin-left', 0);
   });
 }

 //controls
 $('.grayRightArrow').click(nextSlide2)
 $('.grayLeftArrow').click(prevSlide2)
 setInterval(nextSlide2, 20000)

});

// CHANGE IMAGE ON CLICK

$('.slides li div').click(function(){
  $('.bigPhoto').attr('src', '/img/products/415x415/' + $(this).attr('value'));
  $('#zoom1').attr('href', '/img/products/auto/' + $(this).attr('value')).attr('data-full-image-url', '/img/products/auto/' + $(this).attr('value'))
  $('.cloudzoom').data('CloudZoom').destroy();
  $('.cloudzoom').CloudZoom()
})

// ZOOM IMAGE

$(document).ready(function() {
  $('.cloudzoom').CloudZoom()
});

// OPEN SIZE IF EXIST. SELECT COLOR

// var color_id = '';
// var product_id = '';
// var token = '';
// var classs='';
// $('.colorBox').click(function(){
//   $('.colorBox').removeClass('activeBox');
//   $('.colorDiv .loader').remove();
//   $('.colorDiv').append("<div class='loader'></div>");
//   $(this).addClass('activeBox');
//   color_id = $(this).attr('name');
//   product_id = $('#product_id').attr('name')
//   token = $('#token').val()
//   $.ajax({
//     url: '/Goods/get_product_size',
//     type: 'POST',
//     data: {product_id: product_id, color_id: color_id, tezbazar: token},
//     success: function(data){
//       response = $.parseJSON(data);
//       if(response.length > 0)
//       {
//         var priceHtml = '';
//         var priceHtml2 = '';
//         if(response[0].discount > 0)
//         {
//           priceHtml = '<span class="oldPrice">'+ response[0].ex_price +' <span>₼</span></span>';
//           priceHtml2 = '<span class="price">'+ (response[0].ex_price*(100 - response[0].discount)/100) +' <span>₼</span></span>';
//         }
//         else
//         {
//           priceHtml2 = '<span class="price">'+ response[0].ex_price +' <span>₼</span></span>';
//         }
//         $('.priceDiv').html(priceHtml + priceHtml2);
//         if(response[0].title)
//         {
//           $('.sizeDiv').stop().slideDown(200);
//           $('.sizeDiv div').remove();
//           for(var i=0; i<response.length; i++)
//           {
//             if(i==0)
//               classs="sizeBox activeBox";
//             else
//               classs="sizeBox"
//             html = '<div class="'+ classs +'" name="'+ response[i].mn_id +'">'+ response[i].title +'</div>';
//             $('.sizeDiv').append(html);
//           }
//         }
//       }
//       $('.loader').remove();
//     }
//   })
// })


// SELECT SIZE BOX

// $(document).on("click", ".sizeBox", function(){
//   $('.sizeBox').removeClass('activeBox');
//   $(this).addClass('activeBox');
// })

/*----- ADD PRODUCT TO CARD -----*/

token = $('#token').val()

$('.sebete').click(function(){
  var color_id2 = 0;
  var mn_id2 = 0;
  var count = 1;
  var p_id2 = 0;
  var cat_id = 0;

  if($('.category_id').length)
    cat_id = $('.category_id').attr('name');

  if($('#count').length)
    count = $('#count').val();

  p_id2 = $('#product_id').attr('name');

  if(('.colorBox').length>0)
  {
    if($('.colorBox').hasClass('activeBox'))
      color_id2 = $('.colorBox.activeBox').attr('name');
    else
      color_id2 = $('#def_color_id').attr('name');
  }
  else
    color_id2 = $('#def_color_id').attr('name');

  if(('.sizeBox').length>0)
  {
    if($('.sizeBox').hasClass('activeBox'))
      mn_id2 = $('.sizeBox.activeBox').attr('name');
    else
      mn_id2 = $('#def_mn_id').attr('name');
  }
  else
  {
    mn_id2 = $('#def_mn_id').attr('name');
  }

  $.ajax({
    url: '/profile/add_basket',
    type: 'POST',
    data: {cat_id: cat_id, product_id: p_id2, color_id: color_id2, mn_id: mn_id2, count: count, order_status_id: 8, tezbazar: token},
    success: function(data){
      var result = $.parseJSON(data);
      if(result['status'] == 'success')
        toastr["success"](result['msg'], result['header']);
      else if(result['status'] == 'error')
        toastr["error"](result['msg'], result['header']);

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

/*----- ADD PRODUCT TO CARD -----*/

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
      {
        toastr["success"](result['msg'], result['header'])
      }
      if(result['status'] == 'error') {
        toastr["error"](result['msg'], result['header'])
      }

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
