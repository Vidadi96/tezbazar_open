/*------ EDIT ------*/

$(document).on('click', '.edit', function(){
  $(this).closest('tr').find('.edit_open').show();
  $(this).closest('tr').find('.edit_close').hide();
  $(this).closest('.flex-justify-center').html('<button class="save btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only" name="'+ $(this).attr('name') +'"><i class="fa fa-save" aria-hidden="true"></i></button>');
});

/*------ SAVE ------*/

token = $('#token').val();
$(document).on('click', '.save', function(){
  var thiss = $(this);
  var closest = $(this).closest('tr');
  $.ajax({
    url: '/pages/edit_order',
    type: 'POST',
    data: { tezbazar: token,
            id: thiss.attr('name'),
            count: closest.find('input[name="count"]').val()
    },
    success: function(data){
      var res = $.parseJSON(data);
      token = res.tezbazar;
      if (res.status == 'success')
      {
        closest.find('span[name="count_span"]').text(closest.find('input[name="count"]').val());
        closest.find('.edit_open').hide();
        closest.find('.edit_close').show();
        thiss.closest('.flex-justify-center').html('<button class="edit btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only" name="'+ thiss.attr('name') +'"><i class="fa fa-pencil"></i></button>');
      }
      toastr[res.status](res.msg, res.header);
    },
    error: function(){
      toastr["error"]('Xəta baş verdi', 'Xəta');
    }
  });
});

/*----- DELETE -----*/

$(document).on('click', '.delete', function(){
  var thiss = $(this);
  if (confirm('Are you sure?')) {
    $.ajax({
      url: '/pages/delete_order_product',
      type: 'POST',
      data: { tezbazar: token, id: thiss.attr('name')},
      success: function(data){
        var res = $.parseJSON(data);
        token = res.tezbazar;
        if (res.status == 'success')
          thiss.closest('tr').remove();

        toastr[res.status](res.msg, res.header);
      },
      error: function() {
        toastr["error"]('Xəta baş verdi', 'Xəta');
      }
    });
  }
});
