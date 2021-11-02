$('#datePicker1').datepicker({format: "yyyy-mm-dd"});
$('#datePicker2').datepicker({format: "yyyy-mm-dd"});

/*----- GLOBAL PARAMETERS -----*/

var ord_type = 'asc';
var ord_name = 'num';

/*----- GET DIAGRAM PARAMETERS -----*/

var token = $('#token').val();
var labels1 = [];
var data1 = [];
var labels2 = [];
var data2 = [];
var total_price = 0;
var success_order_count = 0;
var cancelled_order_count = 0;
var waiting_proposal = 0;
var waiting_confirmation = 0;
var page_name = 'statistika';
page_name = $('input[name="page_name"]').val();

$(document).ready(function(){
  $.ajax({
    url: '/pages/get_statistics_data',
    type: 'GET',
    data: {tezbazar: token, admin: $('input[name="admin"]').val()},
    success: function(data){
      result = $.parseJSON(data);
      var html = '';
      for(var i=0; i<result['first_diagram'].length; i++)
      {
        labels1.push(result['first_diagram'][i].name);
        data1.push(parseFloat(result['first_diagram'][i].price));
      }
      for(var i=0; i<result['second_diagram'].length; i++)
      {
        labels2.push(result['second_diagram'][i].date_time);
        data2.push(parseFloat(result['second_diagram'][i].price));
        total_price = total_price + parseFloat(result['second_diagram'][i].price);
      }
      success_order_count = result['success_order_count'];
      cancelled_order_count = result['cancelled_order_count'];
      waiting_proposal = result['waiting_proposal'];
      waiting_confirmation = result['waiting_confirmation'];
      myChart1.update(0);
      for(var i=0; i<result['first_diagram'].length; i++)
      {
        html =  html + `<div class="category_row">
                          <div class="category_div">
                            <div class="chertochka" style="background: ` + myChart1.data.datasets[0].backgroundColor[i] + `;"></div>
                            <span class="category_name">` + result['first_diagram'][i].name + `</span>
                            <span class="category_price">` + result['first_diagram'][i].price + ` AZN</span>
                          </div>
                        </div>`;
      }
      $('.category_row_main').html(html);
      myChart2.update(0);
      $('.total_price').text(total_price.toFixed(2) + " AZN");
      $('.success_order_count').text(success_order_count);
      $('.cancelled_order_count').text(cancelled_order_count);
      $('.waiting_proposal').text(waiting_proposal);
      $('.waiting_confirmation').text(waiting_confirmation);
    }
  });
});

/*----- CHART 1 -----*/
if(page_name!='statistics')
{

var dleft = 0;
var dright = 0;
var dtop = 0;
var dbottom = 0;

var ctx1 = $('#myChart1')[0];
if($(window).width() > 1150) {
  ctx1.height = 500;
  ctx1.width = 1000;
  dleft = 150;
  dright = 150;
  dtop = 60;
  dbottom = 60;
} else {
  ctx1.height = 300;
  ctx1.width = 300;
  dleft = 10;
  dright = 10;
  dtop = 10;
  dbottom = 10;
}

var labelFontSize;
var centerFontSize;
if($(window).width() < 1350)
{
  labelFontSize = 9
  centerFontSize = 18
}
else
{
  labelFontSize = 14
  centerFontSize = 22
}

var myChart1 = new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: labels1,
        datasets: [{
            label: '# of Votes',
            data: data1,
            backgroundColor: [
                '#68EFAF',
                '#1EBE71',
                '#008B48'
            ],
            borderColor: [
                'white',
                'white',
                'white'
            ],
            borderWidth: 3
        }]
    },
    options: {
        plugins: {
            // Change options for ALL labels of THIS CHART
            datalabels: {
                color: '#000',
                labels: {
                  title: {
                    anchor: 'end',
                    align: 'end',
                    offset: 10,
                    font: {
                      weight: 'bold'
                    },
                    formatter: function(value, ctx1) {
                      return ($(window).width() > 1150)?ctx1.chart.data.labels[ctx1.dataIndex] + '\n':'';
                    }
                  },
                  value: {
                    color: '#8A928E',
                    anchor: 'end',
                    align: 'end',
                    offset: 10,
                    formatter: function(value, ctx1) {
                        return ($(window).width() > 1150)?'\n' + value + ' AZN':'';
                    }
                  }
                },
                font: {
                    lineHeight: 1.5,
                    size: 16
                },
                textAlign: 'start'
            }
        },
        legend: {
          display: false
        },
        cutoutPercentage: 90,
        elements: {
          center: {
            text: '4 Total',
            color: '#4E6681',
            fontStyle: 'Inter',
            sidePadding: 30,
            maxFontSize: centerFontSize,
            lineHeight: 25
          }
        },
        layout: {
            padding: {
                left: dleft,
                right: dright,
                top: dtop,
                bottom: dbottom
            }
        }
    }
});

/*----- BAR CHART -----*/

var ctx2 = $('#myChart2')[0];
ctx2.height = 250;
ctx2.width = 1200;

if ($(window).width() < 1350) {
  $('#chart2').css('width', 750);
  ctx2.width = 750;
} else if ($(window).width() < 1700) {
  $('#chart2').css('width', 900);
  ctx2.width = 900;
}

var myChart2 = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: labels2,
        datasets: [{
            data: data2,
            backgroundColor: '#FD9840',
            barThickness: 18,
            borderWidth: 0,
            pointRadius: [0, 0, 0, 0, 0, 0, 0, 6],
            pointBackgroundColor: '#fff'
        }]
    },
    options: {
        responsive: false,
        plugins: {
            // Change options for ALL labels of THIS CHART
            datalabels: {
                display: false,
            }
        },
        tooltips: {
          enabled: true,
          callbacks: {
              label: function(tooltipItem) {
                  return tooltipItem.yLabel + " AZN";
              }
          }
        },
        legend: {
          display: false
        },
        layout: {
            padding: {
                left: ($(window).width() > 1150)?60:0,
                right: ($(window).width() > 1150)?7:30,
                top: 1,
                bottom: 0
            }
        },
        scales:{
            xAxes: [{
              ticks: {
                  display: true //this will remove only the label
              },
              gridLines: {
                display: false,
                borderDash: [2, 2],
                color: "#0A2C4C33"
              }
            }],
            yAxes: [{
              ticks: {
                  display: true, //this will remove only the label
                  beginAtZero: true
              },
              gridLines: {
                borderDash: [2, 2],
                color: "#0A2C4C33"
              }
            }],
            elements: {
              point: {
                color: '#fff'
              }
            }
        }
    }
});
}

/*----- FILTER DATA WITH DATE -----*/

var date_start = '';
var date_end = '';
var global_buyer = 0;

$('.filter_button').click(function(){
  labels1 = [];
  data1 = [];
  labels2 = [];
  data2 = [];
  total_price = 0;
  success_order_count = 0;
  cancelled_order_count = 0;
  waiting_proposal = 0;
  waiting_confirmation = 0;
  date_start = $('.date_start').val();
  date_end = $('.date_end').val();
  $('input[name="date_start"]').val(date_start);
  $('input[name="date_end"]').val(date_end);

  $.ajax({
    url: '/pages/get_statistics_data',
    type: 'GET',
    data: { date_start: date_start,
            date_end: date_end,
            tezbazar: token,
            buyer: global_buyer,
            admin: $('input[name="admin"]').val()
          },
    success: function(data){
      result = $.parseJSON(data);
      for(var i=0; i<result['first_diagram'].length; i++)
      {
        labels1.push(result['first_diagram'][i].name);
        data1.push(parseFloat(result['first_diagram'][i].price));
      }
      for(var i=0; i<result['second_diagram'].length; i++)
      {
        labels2.push(result['second_diagram'][i].date_time);
        data2.push(parseFloat(result['second_diagram'][i].price));
        total_price = total_price + parseFloat(result['second_diagram'][i].price);
      }
      success_order_count = result['success_order_count'];
      cancelled_order_count = result['cancelled_order_count'];
      waiting_proposal = result['waiting_proposal'];
      waiting_confirmation = result['waiting_confirmation'];
      myChart1.data.labels = labels1;
      myChart1.data.datasets[0].data = data1;
      myChart1.update(0);
      var html = '';
      for(var i=0; i<result['first_diagram'].length; i++)
      {
        html =  html + `<div class="category_row">
                          <div class="category_div">
                            <div class="chertochka" style="background: ` + myChart1.data.datasets[0].backgroundColor[i] + `;"></div>
                            <span class="category_name">` + result['first_diagram'][i].name + `</span>
                            <span class="category_price">` + result['first_diagram'][i].price + ` AZN</span>
                          </div>
                        </div>`;
      }
      $('.category_row_main').html(html);
      myChart2.data.labels = labels2;
      myChart2.data.datasets[0].data = data2;
      myChart2.update(0);
      $('.total_price').text(total_price.toFixed(2) + " AZN");
      $('.success_order_count').text(success_order_count);
      $('.cancelled_order_count').text(cancelled_order_count);
      $('.waiting_proposal').text(waiting_proposal);
      $('.waiting_confirmation').text(waiting_confirmation);
    }
  });
});

/*----- FILTER DATA WITH BUYER -----*/

$('.filter_select3').change(function(){
  labels1 = [];
  data1 = [];
  labels2 = [];
  data2 = [];
  total_price = 0;
  success_order_count = 0;
  cancelled_order_count = 0;
  waiting_proposal = 0;
  waiting_confirmation = 0;
  global_buyer = $(this).val();

  $.ajax({
    url: '/pages/get_statistics_data',
    type: 'GET',
    data: { date_start: date_start,
            date_end: date_end,
            tezbazar: token,
            buyer: global_buyer,
            admin: $('input[name="admin"]').val()
          },
    success: function(data){
      result = $.parseJSON(data);
      for(var i=0; i<result['first_diagram'].length; i++)
      {
        labels1.push(result['first_diagram'][i].name);
        data1.push(parseFloat(result['first_diagram'][i].price));
      }
      for(var i=0; i<result['second_diagram'].length; i++)
      {
        labels2.push(result['second_diagram'][i].date_time);
        data2.push(parseFloat(result['second_diagram'][i].price));
        total_price = total_price + parseFloat(result['second_diagram'][i].price);
      }
      success_order_count = result['success_order_count'];
      cancelled_order_count = result['cancelled_order_count'];
      waiting_proposal = result['waiting_proposal'];
      waiting_confirmation = result['waiting_confirmation'];
      myChart1.data.labels = labels1;
      myChart1.data.datasets[0].data = data1;
      myChart1.update(0);
      var html = '';
      for(var i=0; i<result['first_diagram'].length; i++)
      {
        html =  html + `<div class="category_row">
                          <div class="category_div">
                            <div class="chertochka" style="background: ` + myChart1.data.datasets[0].backgroundColor[i] + `;"></div>
                            <span class="category_name">` + result['first_diagram'][i].name + `</span>
                            <span class="category_price">` + result['first_diagram'][i].price + ` AZN</span>
                          </div>
                        </div>`;
      }
      $('.category_row_main').html(html);
      myChart2.data.labels = labels2;
      myChart2.data.datasets[0].data = data2;
      myChart2.update(0);
      $('.total_price').text(total_price.toFixed(2) + " AZN");
      $('.success_order_count').text(success_order_count);
      $('.cancelled_order_count').text(cancelled_order_count);
      $('.waiting_proposal').text(waiting_proposal);
      $('.waiting_confirmation').text(waiting_confirmation);
    }
  });
});

/*----- SEND TO MAIL -----*/

var lang = $('#language_js').text();

var msg = [];

var success = [];
success['az'] = 'Uğurlu';
success['ru'] = 'Успешно';
success['en'] = 'Success';
success['tr'] = 'Başarılı';
msg['success'] = success;

var success_msg = [];
success_msg['az'] = 'Meilə göndərildi';
success_msg['ru'] = 'Отправлено на почту';
success_msg['en'] = 'Sent to mail';
success_msg['tr'] = 'Postaya gönderildi';
msg['success_msg'] = success_msg;

var error = [];
error['az'] = 'Xəta';
error['ru'] = 'Ошибка';
error['en'] = 'Error';
error['tr'] = 'Hata';
msg['error'] = error;

var error_msg = [];
error_msg['az'] = 'Xəta baş verdi';
error_msg['ru'] = 'Произошла ошибка';
error_msg['en'] = 'An error has occured';
error_msg['tr'] = 'Bir hata oluştu';
msg['error_msg'] = error_msg;

$('.send_mail').click(function(){
  $.ajax({
    url: '/pages/send_statistics_mail',
    type: 'GET',
    data: {date_start: date_start, date_end: date_end, tezbazar: token},
    success: function(data){
      if(data)
        toastr["success"](msg['success_msg'][lang], msg['success'][lang]);
      else
        toastr["error"](msg['error_msg'][lang], msg['error'][lang]);
    }
  });
});

/*----- SEND TO MAIL STATISTICS -----*/

var statistics_type = $('input[name="statistics_type"]').val();

$('.send_mail_statistics').click(function(){
  ord_type = $('input[name="ord_type"]').val();
  ord_name = $('input[name="ord_name"]').val();
  $.ajax({
    url: '/pages/send_statistics_mail2',
    type: 'GET',
    data: {date_start: date_start, date_end: date_end, tezbazar: token, type: statistics_type, ord_type: ord_type, ord_name: ord_name},
    success: function(data){
      if(data)
        toastr["success"](msg['success_msg'][lang], msg['success'][lang]);
      else
        toastr["error"](msg['error_msg'][lang], msg['error'][lang]);
    }
  });
});

/*----- EXPORT TO EXCEL -----*/

$('.excel_click').click(function(){
$.ajax({
    type:'GET',
    url:'/pages/statistics_export',
    data: { date_start: date_start,
            date_end: date_end,
            tezbazar: token,
            admin: $('input[name="admin"]').val()
          },
    dataType:'json'
  }).done(function(data){
      var $a = $("<a>");
      $a.attr("href",data.file);
      $("body").append($a);
      $a.attr("download","Statistika.xls");
      $a[0].click();
      $a.remove();
  });
});

/*----- EXPORT TO EXCEL STATISTICS -----*/

$('.excel_click_statistics').click(function(){
  ord_type = $('input[name="ord_type"]').val();
  ord_name = $('input[name="ord_name"]').val();
  $.ajax({
      type:'GET',
      url:'/pages/statistics_export2',
      data: { date_start: date_start,
              date_end: date_end,
              tezbazar: token,
              type: statistics_type,
              ord_type: ord_type,
              ord_name: ord_name,
              admin: $('input[name="admin"]').val()
            },
      dataType:'json'
    }).done(function(data){
        var $a = $("<a>");
        $a.attr("href",data.file);
        $("body").append($a);
        $a.attr("download","Statistika.xls");
        $a[0].click();
        $a.remove();
    });
});

/*----- OPEN CLOSE LEFT SIDE -----*/

$('#open_close_left_side').click(function(){
  if(!$(this).hasClass('opened'))
  {
    $(this).html('<i class="fa fa-chevron-left" aria-hidden="true"></i>');
    $('#downLeftSide').animate({width:'toggle'},500);
    $('#downRightSide').animate({width: $('#downRightSide').width()*75/100},450);
    $('#downLeftSide div').show(500);
    $(this).addClass('opened');
  }
  else
  {
    $(this).html('<i class="fa fa-chevron-right" aria-hidden="true"></i>');
    $('#downLeftSide div').hide();
    $('#downLeftSide').animate({width:'toggle'},500);
    $('#downRightSide').animate({width: $('#downRightSide').width()*133.3/100},500);
    $(this).removeClass('opened');
  }
});


/*----- OPEN PRODUCT LIST -----*/

$(document).on('click', '.open_product_list i', function(){
  var product_id = $(this).attr('name');
  var row = $(this).closest('td').attr('name');
  var admin = $('input[name="admin"]').val();

  if($(this).closest('td').hasClass('opened'))
  {
    $('.delete_' + product_id).remove();
    $(this).closest('td').removeClass('opened');
    $(this).closest('td').html('<i class="fa fa-angle-down" aria-hidden="true" name="'+ product_id +'"></i>');
  }
  else
  {
    date_start = $('.date_start').val();
    date_end = $('.date_end').val();
    $(this).closest('td').addClass('opened');
    $(this).closest('td').html('<i class="fa fa-angle-up" aria-hidden="true" name="'+ product_id +'"></i>');
    $.ajax({
      url: '/pages/get_opening_list',
      type: 'GET',
      data: {tezbazar: token, id: product_id, date_start: date_start, date_end: date_end, admin: admin},
      success: function(data){
        var res = $.parseJSON(data);
        var tr_html = '';
        for(let i=0; i<res.length; i++)
          tr_html = tr_html + `<tr class="delete_` + product_id + `" style="background: #F5F5F5">
                                 <td width="9%"><a style="text-decoration: none; color: inherit" target="_blank" href="/pages/qaime_pdf/` + res[i].order_number + `"><u>#` + res[i].order_number + `</u></a></td>
                                 <td width="35%">` + res[i].date_time + `</td>
                                 <td width="28%" colspan="2">` + res[i].ex_price + ` azn</td>
                                 <td width="14%">` + res[i].count + `</td>
                                 <td width="14%" colspan="2">` + (res[i].ex_price*res[i].count).toFixed(2) + ` azn</td>
                               </tr>`;

        $(tr_html).insertAfter('.product_id_' + product_id);
      }
    });
  }
});

/*----- OPEN CHEQUE LIST -----*/

$(document).on('click', '.open_cheque_list i', function(){
  var order_number = $(this).attr('name');
  var admin = $('input[name="admin"]').val();

  if($(this).closest('td').hasClass('opened'))
  {
    $('.delete_' + order_number).remove();
    $(this).closest('td').removeClass('opened');
    $(this).closest('td').html('<i class="fa fa-angle-down" aria-hidden="true" name="'+ order_number +'"></i>');
  }
  else
  {
    date_start = $('.date_start').val();
    date_end = $('.date_end').val();
    $(this).closest('td').addClass('opened');
    $(this).closest('td').html('<i class="fa fa-angle-up" aria-hidden="true" name="'+ order_number +'"></i>');
    $.ajax({
      url: '/pages/get_cheque_opening_list',
      type: 'GET',
      data: {tezbazar: token, order_number: order_number, date_start: date_start, date_end: date_end, admin: admin, buyer: global_buyer},
      success: function(data){
        var res = $.parseJSON(data);
        var tr_html = '';
        for(let i=0; i<res.length; i++)
          tr_html = tr_html + `<tr class="delete_` + order_number + `" style="background: #F5F5F5">
                                 <td width="10%">` + (i+1) + `</td>
                                 <td width="33%" colspan="2" class="image_and_name">
                                    <img src="/img/products/95x95/` + res[i].img + `">
                                    <span>` + res[i].product_name + `</span>
                                 </td>
                                 <td width="16%">` + res[i].count + ` ` + res[i].measure + `</td>
                                 <td width="17%">` + res[i].ex_price + ` ₼</td>
                                 <td width="24%" colspan="2">` + (res[i].ex_price*res[i].count).toFixed(2) + ` ₼</td>
                               </tr>`;

        $(tr_html).insertAfter('.order_number_' + order_number);
      }
    });
  }
});

/*----- FILTER STATISTICS PAGE -----*/

$('.filter_button_statistics').click(function(){
  var buyer = 0;
  buyer = ($('.filter_select2').length > 0)?$('.filter_select2').val():0;
  var obj = {
    type: $('.filter_select option').filter(':selected').val(),
    buyer: buyer,
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val(),
    ord_type: 'asc',
    ord_name: 'num',
    admin: $('input[name="admin"]').val(),
  }

  window.location.replace('/pages/index/statistics?' + $.param(obj));
});

/*----- CHANGE STATISTICS TYPE -----*/

$('.filter_select').change(function(){
  var buyer = 0;
  buyer = ($('.filter_select2').length > 0)?$('.filter_select2').val():0;
  var obj = {
    type: $('.filter_select option').filter(':selected').val(),
    buyer: buyer,
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val(),
    ord_type: ord_type,
    ord_name: ord_name,
    admin: $('input[name="admin"]').val(),
  }

  window.location.replace('/pages/index/statistics?' + $.param(obj));
});

/*----- CHANGE BUYER -----*/

$('.filter_select2').change(function(){
  var buyer = 0;
  buyer = ($('.filter_select2').length > 0)?$('.filter_select2').val():0;
  var obj = {
    type: $('.filter_select option').filter(':selected').val(),
    buyer: buyer,
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val(),
    ord_type: ord_type,
    ord_name: ord_name,
    admin: $('input[name="admin"]').val(),
  }

  window.location.replace('/pages/index/statistics?' + $.param(obj));
});

/*----- ORDER BY TABLE -----*/

$('.orderTable th').click(function(){
  $('.orderTable th i').remove();
  ord_name = $(this).attr('name');
  if ($(this).hasClass('asc')) {
    $('.orderTable th').removeClass('asc');
    $('.orderTable th').removeClass('desc');
    $(this).addClass('desc');
    $(this).html($(this).text() + '<i class="fa fa-chevron-up" aria-hidden="true"></i>');
    ord_type = 'desc';
  } else if ($(this).hasClass('desc')) {
    $('.orderTable th').removeClass('asc');
    $('.orderTable th').removeClass('desc');
    $(this).addClass('asc');
    $(this).html($(this).text() + '<i class="fa fa-chevron-down" aria-hidden="true"></i>');
    ord_type = 'asc';
  } else {
    $('.orderTable th').removeClass('asc');
    $('.orderTable th').removeClass('desc');
    $(this).addClass('asc');
    $(this).html($(this).text() + '<i class="fa fa-chevron-down" aria-hidden="true"></i>');
    ord_type = 'asc';
  }

  var buyer = 0;
  buyer = ($('.filter_select2').length > 0)?$('.filter_select2').val():0;
  var obj = {
    type: $('.filter_select option').filter(':selected').val(),
    buyer: buyer,
    date_start: $('.date_start').val(),
    date_end: $('.date_end').val(),
    ord_type: ord_type,
    ord_name: ord_name,
    admin: $('input[name="admin"]').val(),
  }

  window.location.replace('/pages/index/statistics?' + $.param(obj));
});
