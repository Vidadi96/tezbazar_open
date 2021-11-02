/*----- PLUS MINUS KOLICHESTVO -----*/

var token = $('#token').val();
var lang = $('#language_js').text();

var out_of_stock = [];
out_of_stock['az'] = 'Anbarda yetəri qədər məhsul yoxdur';
out_of_stock['ru'] = 'На складе недостаточно продуктов';
out_of_stock['en'] = 'There is not so many products in warehouse';
out_of_stock['tr'] = 'Stokda yeteri kadar ürün yok';

$('.plus').click(function(){
  var thiss = $(this);
  var p_id = $(this).attr('name');
  $.ajax({
    url: '/pages/get_ost_count',
    type: 'POST',
    data: {product_id: p_id, tezbazar: token},
    success: function(data){
      var countt = parseInt(data);

      if ((thiss.prev().val() + 1) <= countt) {
        thiss.prev().val((parseFloat(thiss.prev().val()) + 1).toFixed(3))
        var tsena = parseFloat(thiss.closest('tr').find('.tsena span').text());
        var summ = parseFloat(thiss.closest('tr').find('.summ span').text());
        var summ_res = summ + tsena;
        thiss.closest('tr').find('.summ span').text(summ_res.toFixed(2));
        thiss.closest('tr').find('input[name="summ[]"]').val(summ_res.toFixed(2));
        var yekun = parseFloat($('.yekunQiymet span').text());
        var result = (yekun + tsena);
        $('.yekunQiymet span').text(result.toFixed(2));
        var tsena2 = parseFloat(thiss.closest('.row_div').find('.tsena2 span').text());
        var summ2 = parseFloat(thiss.closest('.row_div').find('.summ2 span').text());
        var summ_res2 = summ2 + tsena2;
        thiss.closest('.row_div').find('.summ2 span').text(summ_res2.toFixed(2));
        thiss.closest('.row_div').find('input[name="summ[]"]').val(summ_res2.toFixed(2));
        var yekun2 = parseFloat($('.yekunQiymet2 span').text());
        var result2 = (yekun2 + tsena2);
        $('.yekunQiymet2 span').text(result2.toFixed(2));
      } else {
        toastr["info"](out_of_stock[lang], 'Info');
      }
    }
  });
});

$('.minus').click(function(){
  if(parseInt($(this).next().val()) > 1)
  {
    $(this).next().val((parseFloat($(this).next().val()) - 1).toFixed(3));
    var tsena = parseFloat($(this).closest('tr').find('.tsena span').text());
    var summ = parseFloat($(this).closest('tr').find('.summ span').text());
    var summ_res = summ - tsena;
    $(this).closest('tr').find('.summ span').text(summ_res.toFixed(2));
    $(this).closest('tr').find('input[name="summ[]"]').val(summ_res.toFixed(2));
    var yekun = parseFloat($('.yekunQiymet span').text());
    var result = (yekun - tsena);
    $('.yekunQiymet span').text(result.toFixed(2));
    var tsena2 = parseFloat($(this).closest('.row_div').find('.tsena2 span').text());
    var summ2 = parseFloat($(this).closest('.row_div').find('.summ2 span').text());
    var summ_res2 = summ2 - tsena2;
    $(this).closest('.row_div').find('.summ2 span').text(summ_res2.toFixed(2));
    $(this).closest('.row_div').find('input[name="summ[]"]').val(summ_res2.toFixed(2));
    var yekun2 = parseFloat($('.yekunQiymet2 span').text());
    var result2 = (yekun2 - tsena2);
    $('.yekunQiymet2 span').text(result2.toFixed(2));
  }
})

/*----- ONLY FLOAT NUMBERS -----*/

$('.kolichestvo').keypress(function(event) {
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});

/*----- CHANGE QUANTITY -----*/

$(document).on('blur', '.kolichestvo', function(){
  var thisss = $(this);
  var p_id = $(this).attr('data');
  $.ajax({
    url: '/pages/get_ost_count',
    type: 'POST',
    data: {product_id: p_id, tezbazar: token},
    success: function(data){
      var countt = parseInt(data);

      if(thisss.val() <= countt)
      {
        var result = 0;
        thisss.closest('tr').find('.summ span').text((thisss.val()*parseFloat(thisss.closest('tr').find('.tsena span').text())).toFixed(2));
        thisss.closest('tr').find('input[name="summ[]"]').val((thisss.val()*parseFloat(thisss.closest('tr').find('.tsena span').text())).toFixed(2));
        $('.tsena span').each(function() {
          result = result + parseFloat($(this).closest('tr').find('.kolichestvo').val())*parseFloat($(this).text());
        });
        $('.yekunQiymet span').text(result.toFixed(2));

        var result2 = 0;
        thisss.closest('.row_div').find('.summ2 span').text((thisss.val()*parseFloat(thisss.closest('.row_div').find('.tsena2 span').text())).toFixed(2));
        thisss.closest('.row_div').find('input[name="summ[]"]').val((thisss.val()*parseFloat(thisss.closest('.row_div').find('.tsena2 span').text())).toFixed(2));
        $('.tsena2 span').each(function() {
          result2 = result2 + parseFloat($(this).closest('.row_div').find('.kolichestvo').val())*parseFloat($(this).text());
        });
        $('.yekunQiymet2 span').text(result2.toFixed(2));
      } else {
        thisss.val(countt.toFixed(3));
        var result = 0;
        thisss.closest('tr').find('.summ span').text((countt*parseFloat(thisss.closest('tr').find('.tsena span').text())).toFixed(2));
        thisss.closest('tr').find('input[name="summ[]"]').val((countt*parseFloat(thisss.closest('tr').find('.tsena span').text())).toFixed(2));
        $('.tsena span').each(function() {
          result = result + parseFloat($(this).closest('tr').find('.kolichestvo').val())*parseFloat($(this).text());
        });
        $('.yekunQiymet span').text(result.toFixed(2));

        var result2 = 0;
        thisss.closest('.row_div').find('.summ2 span').text((countt*parseFloat(thisss.closest('.row_div').find('.tsena2 span').text())).toFixed(2));
        thisss.closest('.row_div').find('input[name="summ[]"]').val((countt*parseFloat(thisss.closest('.row_div').find('.tsena2 span').text())).toFixed(2));
        $('.tsena2 span').each(function() {
          result2 = result2 + parseFloat($(this).closest('.row_div').find('.kolichestvo').val())*parseFloat($(this).text());
        });
        $('.yekunQiymet2 span').text(result2.toFixed(2));

        toastr["info"](out_of_stock[lang], 'Info');
      }
    }
  });
});

/*----- SECHILMISHLERI SILMEK -----*/

$('#pageHead span:last-child').on("click", function(){
  if($(".checkbox").is(':checked'))
  {
    $('.checkbox').prop("checked", false);
  }
  else
  {
    $('.checkbox').prop("checked", true);
  }
})

/*----- TOASTR -----*/


var select_product = [];
select_product['az'] = 'Məhsul seçin';
select_product['ru'] = 'Выберите продукт';
select_product['en'] = 'Select a product';
select_product['tr'] = 'Ürün seçiniz';

var product_is_absent = [];
product_is_absent['az'] = 'Məhsul yoxdur';
product_is_absent['ru'] = 'Продукта нет';
product_is_absent['en'] = 'Product is absent';
product_is_absent['tr'] = 'Ürün yok';

if(searchParams.has('msg'))
{
  let msg = searchParams.get('msg');

  if(msg==0)
    toastr["error"](select_product[lang], product_is_absent[lang]);
}

/*------ DISABLE INPUT ------*/

if ($(window).width() < 1150) {
  $(".cdisable").prop('disabled', false);
  $(".mdisable").prop('disabled', true);
} else {
  $(".cdisable").prop('disabled', true);
  $(".mdisable").prop('disabled', false);
}

/*------ ADD COMMENT ------*/

$('.add_comment').click(function(){
  $('.zanaveska3').show();
  var value = $(this).closest('div').find('input[name="comment[]"]').val();
  $('#login_form2 textarea').val(value);
  $(this).closest('div').find('input[name="comment[]"]').addClass('past_here');
});

$('.add_total_comment').click(function(){
  $('.zanaveska3').show();
  var value = $('input[name="total_comment"]').val();
  $('#login_form2 textarea').val(value);
  $('input[name="total_comment"]').addClass('past_here');
});

$('.zanaveska3 .yadda_saxla').click(function(){
  var value = $(this).closest('#login_form2').find('textarea').val();
  $('.past_here').val(value);
  $('input[name="comment[]"]').removeClass('past_here');
  $('input[name="total_comment"]').removeClass('past_here');
  $('.zanaveska3').hide();
});

$('#close3').click(function(){
  $('.zanaveska3').hide();
  $('input[name="comment[]"]').removeClass('past_here');
  $('input[name="total_comment"]').removeClass('past_here');
});

$('.zanaveska3 .imtina').click(function(){
  $('.zanaveska3').hide();
  $('input[name="comment[]"]').removeClass('past_here');
  $('input[name="total_comment"]').removeClass('past_here');
});


/*------ ADD ADDRESS ------*/

$('.open_add_address').click(function(){
  $('.add_address').show();
  var value = $('input[name="address"]').val();
  $('#add_address_form textarea').val(value);
  $('input[name="address"]').addClass('past_here_address');
});

$('.add_address .yadda_saxla').click(function(){
  var value = $(this).closest('#add_address_form').find('textarea').val();
  $('.past_here_address').val(value);
  $('input[name="address"]').removeClass('past_here_address');
  $('.add_address').hide();
});

$('#add_address_close').click(function(){
  $('.add_address').hide();
  $('input[name="address"]').removeClass('past_here_address');
});

$('.add_address .imtina').click(function(){
  $('.add_address').hide();
  $('input[name="address"]').removeClass('past_here_address');
});
