$(document).ready(function(){
  var dot = '<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>';
  $(".main_menu li ul li").each(function(){
    $(this).find(">a").prepend(dot);

    if($(this).find("ul").length>0)
    {
      var arrow = '<i class="m-menu__ver-arrow la la-angle-right"></i>';
      $(this).find(">a").append(arrow);
    }

  })



  // $('[data-toggle~="tooltip"]').tooltip({
	// 		container: 'body'
	// });


  $(".main_menu li").each(function(){
    if($(this).find("ul").length>0)
    {
      var arrow = '<i class="m-menu__ver-arrow la la-angle-right"></i>';
      $(this).find(">a").append(arrow);
    }
  })

	$(".invalid-feedback").each(function(){
		$(this).closest(".validated").find("textarea").addClass("is-invalid");
	});

  /*============Start Avtive/Passive Script============*/
			$(".set_active_passive").on("click", function(){
					var id = $(this).attr("id");
					var current_button = $(this);
					var active_passive = $(this).attr("active_passive");
					var url= $(this).closest("table").attr("active_passive_url");
					//$(".loader").fadeIn(200);
					$.post(url,
					{
						id: id,
						active_passive: active_passive,
						tezbazar:$("input[name=tezbazar]").val(),
						method: "ajax"
					},function(data)
					{
						var obj = $.parseJSON(data);
            $("input[name=tezbazar]").val(obj.tezbazar);
						if(obj.status=="success")
						{
							//$('.tooltip').remove();
							if(active_passive==0)
							{
								current_button.removeClass("btn-success").addClass("btn-danger");
								current_button.attr("active_passive", "1");
								current_button.attr("data-content", "Aktiv et!").data('bs.popover').setContent();

							}else
							{
								current_button.removeClass("btn-danger").addClass("btn-success");
								current_button.attr("active_passive", "0");
								current_button.attr("data-content", "Passiv et!").data('bs.popover').setContent();


							}
							toastr.success(obj.msg, obj.header);
						}else
						{
							toastr.error(obj.msg, obj.header);
						}
						//$('.loader').fadeOut(100);
					})
			});
			/*============End Avtive/Passive Script============*/

			/*============Start Delete Script============*/
			var deleted_id = 0;
			var current_tr = "";
			var post_url = "";
      $(document).on('click', ".delete", function (evt) {
				evt.preventDefault();
				deleted_id = $(this).attr("rel");
				post_url = $(this).closest("table").attr("delete_url");
				$("tr").removeClass("delete_item");
				if($(this).closest("table").find("td").length>0)
				{
					current_tr = $(this).closest("tr");
					$(this).closest("tr").addClass("delete_item");
				}else
				{
					current_tr = $(this).closest("li");
					$(this).closest("li").addClass("delete_item");
				}
				$('.delete_modal').modal({backdrop: 'static', keyboard: false});
			});
			$(".delete-cancel, .close").on("click", function(){
				$('tr').removeClass("delete_item");
			});
			$(".delete-accept").on("click", function(){
				//$(".loader").fadeIn(200);
				$('.delete_modal').modal("hide");
				$.post(post_url,
				{
					id: deleted_id,
					tezbazar: $("input[name=tezbazar]").val(),
					method: "ajax"
				},function(data)
				{
					var obj = $.parseJSON(data);
					$("input[name=tezbazar]").val(obj.tezbazar);
					if(obj.status=="success")
					{
						current_tr.fadeOut(500,function(){$(this).remove();});
						toastr.success(obj.msg, obj.header);
					}else
					{
						toastr.error(obj.msg, obj.header);
					}
					//$('.loader').fadeOut(200);
				})
			})
			/*============END Delete Script============*/


      $('.set_max_length').maxlength({
          threshold: 5,
          warningClass: "m-badge m-badge--primary m-badge--rounded m-badge--inline",
          limitReachedClass: "m-badge m-badge--brand m-badge--rounded m-badge--inline"
      });
      //console.log("set_max_length");
      $(".borders_tree_checkbox").change(function(){
        if($(this).is(':checked'))
        {
          $(this).closest(".borders_tree").addClass("opened");
        }else {
          $(this).closest(".borders_tree").removeClass("opened");
        }
      });
      $(".borders_tree_checkbox").change();


});
