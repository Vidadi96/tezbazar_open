/*----- ADD PRODUCT TO CARD -----*/

token = $('#token').val()

$('.korzina').click(function(){

  event.preventDefault();
  var color_id = 0;
  var mn_id = 0;
  var count = 1;
  var p_id = 0;
  var cat_id = 0;

  p_id = $(this).closest('form').find('input[name="product_id"]').val();
  mn_id = $(this).closest('form').find('input[name="mn_id"]').val();
  color_id = $(this).closest('form').find('input[name="color_id"]').val();
  cat_id = $('.category_id').attr('name');

  $.ajax({
    url: '/profile/add_basket',
    type: 'POST',
    data: {cat_id: cat_id, product_id: p_id, color_id: color_id, mn_id: mn_id, count: count, order_status_id: 8, tezbazar: token},
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
