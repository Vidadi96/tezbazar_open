 $('#datePicker1').datepicker({format: "yyyy-mm-dd"});
 $('#datePicker2').datepicker({format: "yyyy-mm-dd"});

// LANGUAGE

var lang = $('#language_js').text();

var total = [];
total['az'] = 'Toplam';
total['ru'] = 'Общий';
total['en'] = 'Total';
total['tr'] = 'Toplam';

var cancel_confirmation = [];
cancel_confirmation['az'] = 'Imtina etmək istədiyinizə əminsiniz?';
cancel_confirmation['ru'] = 'Уверены, что хотите удалить?';
cancel_confirmation['en'] = 'Are you sure?';
cancel_confirmation['tr'] = 'Redd etmek isdeyinize eminsinizmi?';

var order_again_confirmation = [];
order_again_confirmation['az'] = 'Yenidən sifariş et';
order_again_confirmation['ru'] = 'Закажи снова';
order_again_confirmation['en'] = 'Order again';
order_again_confirmation['tr'] = 'Yeniden sipariş et';

var summ_word = [];
summ_word['az'] = 'Məbləğ';
summ_word['ru'] = 'Сумма';
summ_word['en'] = 'Sum';
summ_word['tr'] = 'Tutar';

var name2 = [];
name2['az'] = 'Adı';
name2['ru'] = 'Название';
name2['en'] = 'Name';
name2['tr'] = 'İsmi';

var price = [];
price['az'] = 'Qiymət';
price['ru'] = 'Цена';
price['en'] = 'Price';
price['tr'] = 'Fiyat';

var result2 = [];
result2['az'] = 'Məbləğ';
result2['ru'] = 'Итог';
result2['en'] = 'Result';
result2['tr'] = 'Sonuç';

var count = [];
count['az'] = 'Miqdar';
count['ru'] = 'Количество';
count['en'] = 'Count';
count['tr'] = 'Miktar';

var discount_percentage = [];
discount_percentage['az'] = 'Endirim faizi';
discount_percentage['ru'] = 'Процент скидки';
discount_percentage['en'] = 'Discount percentage';
discount_percentage['tr'] = 'İndirim yüzdesi';

var proposal = [];
proposal['az'] = 'Təklif';
proposal['ru'] = 'Предложение';
proposal['en'] = 'Proposal';
proposal['tr'] = 'Teklif';

var date = [];
date['az'] = 'Tarix';
date['ru'] = 'Дата';
date['en'] = 'Date';
date['tr'] = 'Tarih';

var success = [];
success['az'] = 'Uğurlu';
success['ru'] = 'Успешно';
success['en'] = 'Success';
success['tr'] = 'Başarılı';

var success_msg = [];
success_msg['az'] = 'Uğurla yadda saxlanıldı';
success_msg['ru'] = 'Успешно сохранено';
success_msg['en'] = 'Successfully saved';
success_msg['tr'] = 'Başarıyla kayd edildi';

var error = [];
error['az'] = 'Xəta';
error['ru'] = 'Ошибка';
error['en'] = 'Error';
error['tr'] = 'Hata';

var error_msg = [];
error_msg['az'] = 'Xəta baş verdi';
error_msg['ru'] = 'Произошла ошибка';
error_msg['en'] = 'An error has occured';
error_msg['tr'] = 'Bir hata oluştu';

var order_successfully_confirmed = [];
order_successfully_confirmed['az'] = 'Sifariş uğurla təsdiqləndi';
order_successfully_confirmed['ru'] = 'Заказ успешно подтвержден';
order_successfully_confirmed['en'] = 'Order successfully confirmed';
order_successfully_confirmed['tr'] = 'Sipariş başarıyla onaylandı';

var cancel_message_sent_successfully = [];
cancel_message_sent_successfully['az'] = 'Imtina sorğusu uğurla göndərildi';
cancel_message_sent_successfully['ru'] = 'Сообщение об отказе успешно отправлено';
cancel_message_sent_successfully['en'] = 'Cancellation message sent successfully';
cancel_message_sent_successfully['tr'] = 'İptal mesajı başarıyla gönderildi';

var order_resubmitted = [];
order_resubmitted['az'] = 'Sifariş yenidən verildi';
order_resubmitted['ru'] = 'Заказ подан повторно';
order_resubmitted['en'] = 'Order resubmitted';
order_resubmitted['tr'] = 'Sipariş yeniden gönderildi';

var reject_period = [];
reject_period['az'] = 'İmtina edə biləcək müddət sona çatıb';
reject_period['ru'] = 'Период отказа от заказа завершен';
reject_period['en'] = 'Reject period is ended';
reject_period['tr'] = 'Ret süresi sona ermişdir';

// OPEN AN ORDER FORM

var token = $('#token').val()

$('.sifarish_number').click(function(){
  var id = 0;
  var html = '';
  if($(this).hasClass('shown'))
  {
    $('.qaime').fadeOut(300);
    $('.sifarish_number').removeClass('shown');
    $('.proposal').removeClass('shown');
    $('.qaime_click').removeClass('shown');
  }
  else
  {
    $(this).html("<div class='loader'></div>" + $(this).text());
    $('.sifarish_number').removeClass('shown');
    $('.proposal').removeClass('shown');
    $('.qaime_click').removeClass('shown');
    $(this).addClass('shown');
    id = parseInt($(this).text().substr(1));

    $.ajax({
      url: '/pages/get_order_list',
      type: 'POST',
      data: {id: id, tezbazar: token},
      success: function(data){
        result = $.parseJSON(data);
        $('.a4 .teklif_change').text(summ_word[lang]);
        $('.a4 .order_number u').text('#' + result['users'].order_number);
        $('.a4 .user_name').text(result['users'].company_name)
        $('.sifarish_time').text('Tarix: ' + result['users'].date_time);
        $('.tehvil_aldi_verdi').hide();
        html = '';
        var tot = 0;
        for(var i=0; i<result['list'].length; i++)
        {
          html = html + '<tr><td>'+ (i+1) +'</td><td>'+ result['list'][i].title + ' - ' + result['list'][i].description +'</td><td>'+ result['list'][i].count +'</td><td>'+ result['list'][i].ex_price +' azn</td><td>'+ parseFloat(result['list'][i].ex_price*result['list'][i].count).toFixed(2) +' azn</td></tr>';
          tot = tot + result['list'][i].count * result['list'][i].ex_price;
        }

        // $('.qaime_discount').hide();
        $('.discount_show').hide();
        $('.new_total').text(tot.toFixed(2));
        $('.a4 table tbody').html(html);
        $('.sifarish_number div.loader').remove();
        $('.qaime').fadeIn(100);
      },
      error: function(){
        $('.sifarish_number div.loader').remove();
      }
    });
  }
});

// OPEN A PROPOSAL FORM

$('.proposal').click(function(){
  var id = 0;
  var html = '';
  if($(this).hasClass('shown'))
  {
    $('.qaime').fadeOut(300);
    $('.sifarish_number').removeClass('shown');
    $('.proposal').removeClass('shown');
    $('.qaime_click').removeClass('shown');
  }
  else
  {
    $(this).html("<div class='loader'></div>" + $(this).text());
    $('.sifarish_number').removeClass('shown');
    $('.proposal').removeClass('shown');
    $('.qaime_click').removeClass('shown');
    $(this).addClass('shown');
    id = parseInt($(this).text().substr(1));

    $.ajax({
      url: '/pages/get_order_list',
      type: 'POST',
      data: {id: id, tezbazar: token},
      success: function(data){
        result = $.parseJSON(data);
        $('.a4 .teklif_change').text(proposal[lang]);
        $('.a4 .teklif_delete').remove();
        $('.a4 .order_number u').text('#' + result['users'].order_number);
        $('.a4 .user_name').text(result['users'].company_name)
        $('.sifarish_time').text(date[lang] + ': ' + result['users'].date_time);
        html = '';
        for(var i=0; i<result['list'].length; i++)
          html = html + '<tr><td>'+ (i+1) +'</td><td>'+ result['list'][i].title + ' - ' + result['list'][i].description +'</td><td>'+ result['list'][i].count +'</td><td>'+ result['list'][i].ex_price +' azn</td><td>'+ parseFloat(result['list'][i].qiymet_teklifi).toFixed(2) +' azn</td></tr>';

        $('.a4 table tbody').html(html);
        $('.proposal div.loader').remove();
        $('.qaime').fadeIn(100);
      },
      error: function(){
        $('.proposal div.loader').remove();
      }
    });
  }
});

// CLOSE COMMENT FORM

$('#close3').click(function(){
	$('.zanaveska3').hide()
})

$('#login_form2 .imtina').click(function(){
	$('.zanaveska3').hide()
})

// OPEN COMMENT FORM

$('.comment2').click(function(){
  var id=0;
  id = $(this).attr('name');

  $.ajax({
    url: '/pages/get_comment',
    type: 'POST',
    data: {id: id, tezbazar: token},
    success: function(data){
      $('#login_form2 .yadda_saxla').attr('name', id);
      $('#login_form2 textarea').val(data);
      $('.zanaveska3').show();
    }
  });
});

// ADD COMMENT

$(document).on("click", "#login_form2 .yadda_saxla", function(){
  var id=0;
  var text = '';
  id = $(this).attr('name');
  text = $('#login_form2 textarea').val();

  $.ajax({
    url: '/pages/add_comment',
    type: 'POST',
    data: {id: id, text: text, tezbazar: token},
    success: function(data){
      if(data)
        toastr["success"](success_msg[lang], success[lang]);
      else
        toastr["error"](error_msg[lang], error[lang]);

      $('.zanaveska3').hide();
    }
  });
});

// INFO TOASTR
if(searchParams.has('msg'))
{
  let msg = searchParams.get('msg');

  if(msg==1)
    toastr["success"](order_successfully_confirmed[lang], success[lang]);
  else if(msg==2)
    toastr["success"](cancel_message_sent_successfully[lang], success[lang]);
  else if(msg==3)
    toastr["success"](order_resubmitted[lang], success[lang]);
  else if(msg==4)
    toastr["error"](reject_period[lang], error[lang])
  else
    toastr["error"](error_msg[lang], error[lang]);
}

// SHOW ROW WITH ANIMATION

if(searchParams.has('add'))
{
  let onum = searchParams.get('add');
  $('.id' + onum).addClass('animation_switch');
}

// OPEN QAIME FORM

$('.qaime_click').click(function(){
  var id = 0;
  var html = '';
  if($(this).hasClass('shown'))
  {
    $('.qaime').fadeOut(300);
    $('.sifarish_number').removeClass('shown');
    $('.proposal').removeClass('shown');
    $('.qaime_click').removeClass('shown');
  }
  else
  {
    $(this).html("<div class='loader'></div>" + $(this).text());
    $('.sifarish_number').removeClass('shown');
    $('.proposal').removeClass('shown');
    $('.qaime_click').removeClass('shown');
    $(this).addClass('shown');
    id = $(this).attr('name');

    $.ajax({
      url: '/pages/get_order_list',
      type: 'POST',
      data: {id: id, tezbazar: token},
      success: function(data){
        result = $.parseJSON(data);
        $('.a4 .teklif_change').text(summ_word[lang]);
        $('.a4 .order_number u').text('#' + result['users'].order_number);
        $('.a4 .user_name').text(result['users'].company_name)
        $('.sifarish_time').text('Tarix: ' + result['users'].date_time);
        $('.tehvil_aldi_verdi').show();
        html = '';
        var new_total = 0;
        for(var i=0; i<result['list'].length; i++)
        {
          html = html + '<tr><td>'+ (i+1) +'</td><td>'+ result['list'][i].title + ' - ' + result['list'][i].description +'</td><td>'+ result['list'][i].count +'</td><td>'+ result['list'][i].ex_price +' azn</td><td>'+ parseFloat(result['list'][i].ex_price*result['list'][i].count).toFixed(2) +' azn</td></tr>';
          new_total = new_total + parseFloat(result['list'][i].ex_price*result['list'][i].count);
        }

        if(result['users'].discount > 0)
        {
          $('.discount_show').show();
          new_total = new_total*(100 - result['users'].discount)/100;
        }
        else
          $('.discount_show').hide();

        $('.a4 table tbody').html(html);
        // $('.qaime_discount').show();
        $('.discount').text(result['users'].discount + "%");
        $('.new_total').text(new_total.toFixed(2) + " azn");
        $('.qaime_click div.loader').remove();
        $('.qaime').fadeIn(100);
      },
      error: function(){
        $('.qaime_click div.loader').remove();
      }
    });
  }
});

// FILTER

//--orders
$('.orders_date').click(function(){
  var obj = {
    search: $('.search_param').val(),
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val(),
  }

  window.location.replace('/pages/index/orders?' + $.param(obj));
});

$('.orders_search').click(function(){
  var obj = {
    search: $('.search_param').val(),
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val(),
  }

  window.location.replace('/pages/index/orders?' + $.param(obj));
});

//--documents
$('.documents_date').click(function(){
  var obj = {
    search: $('.search_param').val(),
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val(),
  }

  window.location.replace('/pages/index/documents?' + $.param(obj));
});

$('.documents_search').click(function(){
  var obj = {
    search: $('.search_param').val(),
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val(),
  }

  window.location.replace('/pages/index/documents?' + $.param(obj));
});

//--order history
$('.order_history_date').click(function(){
  var obj = {
    search: $('.search_param').val(),
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val()
  }

  window.location.replace('/pages/index/order-history?' + $.param(obj));
});

$('.order_history_search').click(function(){
  var obj = {
    search: $('.search_param').val(),
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val()
  }

  window.location.replace('/pages/index/order-history?' + $.param(obj));
});

/*----- OPEN CLOSE MOBILE ORDERS -----*/

$('.m_open_sub i').click(function(){
  if ($(this).hasClass('fa-angle-down')) {
    $(this).removeClass('fa-angle-down');
    $(this).addClass('fa-angle-up');
    $(this).closest('.m_border_bottom').find('.open_close').show();
    $(this).closest('.m_border_bottom').find('.flex_center').css('display', 'flex');
  } else {
    $(this).addClass('fa-angle-down');
    $(this).removeClass('fa-angle-up');
    $(this).closest('.m_border_bottom').find('.open_close').hide();
    $(this).closest('.m_border_bottom').find('.flex_center').css('display', 'none');
  }
})

/*------ CLOSE MOBILE QAIME ------*/

$('.close_qaime').click(function(){
  $('.qaime').fadeOut(300);
  $('.sifarish_number').removeClass('shown');
  $('.proposal').removeClass('shown');
  $('.qaime_click').removeClass('shown');
});


/*------ CANCEL CONFIRMATION ------*/

$(document).on('click', '.cancel_confirmation', function(){
  return confirm(cancel_confirmation[lang]);
});

/*------ ORDER AGAIN CONFIRMATION ------*/

$(document).on('click', '.order_again_confirmation', function(){
  return confirm(order_again_confirmation[lang]);
});
