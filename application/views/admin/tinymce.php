<input class="hidden" style="display: none;" type="file" id="mp3_upload" name="mp3_upload" data-tabindex="1">
<input class="hidden" style="display: none;" type="file" id="image_upload" name="image_upload" data-tabindex="1">
<script type="text/javascript" src="/js/ajaxfileupload.js?v=8"></script>
<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var img_for = 0;
	var called_image = 1;
	function get_images(class_name)
	{
		$(".loader").fadeIn(100);
		$.get("/posts/file_manager/0",function(data){
			$("#file_manager_modal .modal-body").html(data);
			$("#file_manager_modal").addClass(class_name).modal("show");
			$(".loader").fadeOut(100);
		})
	}
	$(".file_manager3").click(function(){
		img_for = 3;
		get_images('file_manager_3')
	});
	$(".file_manager1").click(function(){
		img_for = 1;
		get_images('file_manager_1')
	});
	$(".remove_thumb_main").click(function(){
			$(".main_thumb img").remove();
			$(".main_thumb input[name=selected_thumb]").val("");
	});



		$(".file_manager_pagination li a").click(function(evt){
				evt.preventDefault();
				$(".loader").fadeIn(100);
				var current_a_href = $(this).attr("href");
				$.get(current_a_href, function(data){
					$("#file_manager_modal .modal-body").html(data);
					$(".loader").fadeOut(100);
				})
		});



		$(".btn_search_file").click(function(){
				$(".loader").fadeIn(100);
				$.get("/posts/search_file_manager/"+$(".input_search_file").val(), function(data){
					$("#file_manager_modal .modal-body").html(data);
					$(".loader").fadeOut(100);
					$(".loader").fadeOut(100);
				})
		});

		$(".file_manager_1 .file_manager_images li").click(function(){
				var thumb = $(this).attr("id");
				if(img_for==1)
				{
					$(".main_thumb").html('<img class="news_img" id="/img/news/350x300/'+thumb+'" style="height:30px !important; border:1px solid #DDD; border-radius: 2px; margin-right: 5px; float: left;" src="/img/news/95x95/'+thumb+'"/><img class="remove_thumb_main" src="/img/icons/16x16/close.png" /><input type="hidden" name="selected_thumb" value="'+thumb+'" />');
				}
		});
		$(".file_manager_3 .file_manager_images li").click(function(){
				var thumb = $(this).attr("id");
				if(img_for==3)
				{
					if(thumb)
					{
						$.post("/posts/available_thumb_upload/<?=$this->uri->segment(3)?$this->uri->segment(3):0;?>/", {thumb: thumb,tezbazar:$("input[name=tezbazar]").val()}, function(data){
							obj = $.parseJSON(data);
							if(obj.status=="success")
							{
								var img = '<div class="img"><a name="'+obj.id+'" id="3" class="remove" href=""></a><img src="/img/news/95x95/'+thumb+'"></div>';
								$(".shop_thumbs").append(img);
								toastr.success(obj.msg, obj.header);
							}else
							{
								toastr.error(obj.msg, obj.header);
							}
							//$(".loader").fadeOut(100);

						});

					}

				}
		});




	var img_upload = 0;
	var pdf_upload = 0;
	var file_upload = 0;
	var mp3_upload = 0;


	tinymce.init({
    selector: ".tinymce",
	theme: "modern",

	invalid_styles: {
		'*': 'font-family, padding, border',
		'a': 'background'
	},
	language : 'az',
	plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table directionality template paste textcolor imagetools "
   ],
   content_css: [
	'/css/bootstrap.min.css',
    '/css/tinymce.css'

    ],
   toolbar: "spellchecker insertfile undo redo | styleselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink image | print preview media fullpage | forecolor backcolor | add_img file file_manager_plugin add_file add_pdf add_mp3 | removeformat ",
   relative_urls: false,
   setup : function(ed, cm) {
			ed = ed;
		    ed.addButton('cust_setimgaspreview', {
		        title : 'Set image as a preview image',
		        image : 'ikony/previews.png',
		        onclick : function() {

		        }
		    });


			/*ed.addButton('full_screen', {
            	onPostRender: function() {
			        var ctrl = this;
			        ed.on('NodeChange', function(e) {
			            ctrl.active(e.element.nodeName == 'IMG');
			            //console.log(ctrl)
			        });
			    },
            	title : 'Şəklin böyüdülməsi',
            	image : '<?=base_url();?>img/icons/16x16/full_screen.png',

            	onclick : function(){
					if(ed.selection.getNode().tagName == 'IMG')
		            {
		                // ed.selection.getNode().className = 'preview';
		                //console.log(ed.selection);
		                if($(ed.selection.getNode()).closest("a").hasClass("lightbox"))
		                {
							//ed.selection.collapse(FALSE);
							//ed.selection.getContent().replace(/<img [^>]*>/i,'');
							$(ed.selection.getNode()).closest("a").contents().unwrap();
						}else
						{
							ed.selection.setContent('<a href="'+ed.selection.getNode().src+'" class="lightbox">'+ed.selection.getContent({format : 'html'})+'</a>');
						}

		            } else {
		                alert('Zəhmət olmasa şəkil seçin!');
		            }
				}
            });*/
            ed.addButton('add_img', {
							title : 'Şəkil Yüklə',
							image : '/img/icons/16x16/add_img.png',
							onclick : function() {

							var elem = document.getElementById("image_upload");
							if(elem && document.createEvent) {
							var evt = document.createEvent("MouseEvents");
							evt.initEvent("click", true, false);
							elem.dispatchEvent(evt);
							}

					if(img_upload==0)
					{
						$("#image_upload").change(function(){
								$('.waiter').fadeIn(200);
								img_upload = 1;
								console.log(777);
								$.ajaxFileUpload
								(
									{
										url:'/posts/img_upload/',
										secureuri:false,
										fileElementId:'image_upload',
										dataType: 'json',
										error: function(data, status)
										{
											console.log(data);
											console.log(status);
										},
										success: function (data, status)
										{
											console.log(data);
											console.log(status);
											//if(typeof(data.error) != 'undefined')
											//{
											console.log(555);
												if(data.error != '')
												{
													console.log(data.img_name);
													toastr.error(data);
												}else
												{
													//$("#new_img").modal("hide");
													tinymce.activeEditor.selection.setContent('<a data-fancybox="images" href="/img/blogs/auto/'+data.img_name+'"><img title="" src="/img/blogs/400x270/'+data.img_name+'" />');
													console.log(data.img_name);
												}
											//}
											$('.waiter').fadeOut(200);
										}

									}
								);
						});
					}



                }
            });

			ed.addButton('file_manager_plugin', {
				title : 'Şəkil arxivi',
				image : '/img/icons/16x16/main_img.png',
				onclick : function() {

						img_for = 2;
						get_images('file_manager_2');
					if(called_image==1)
					{
						$(".file_manager_2 .file_manager_images li").click(function(){
								var thumb = $(this).attr("id");
								if(img_for==2)
								{
									//if(called_image==1)
									tinymce.activeEditor.selection.setContent('<a class="fancybox" data-fancybox-group="gallery" href="/img/news/auto/'+thumb+'"><img title="" src="/img/news/250xauto/'+thumb+'" />');
									called_image = 2;
									//console.log("test");
								}
						});
					}

				}
			});


            /*
            ed.addButton('add_vimeo', {
            	title : 'Vimeo video əlavə edin',
            	image : '<?=base_url();?>img/icons/16x16/add_vimeo.png',
            	onclick : function(){

				}
            });*/
			ed.addButton('add_file', {
                title : 'Fayl yüklə',
                image : '/img/icons/16x16/add_file.png',
                onclick : function() {
				/*if(ed.selection.getContent({format : 'text'}).length<1)
				{
					toastr.warning("İlk öncə yüklənəcək fayl üçün bağlantı sözünü seçin!");
				}else
				{*/
				$("#new_file").modal("show");
				$("#new_file input").attr("id", "file_upload2");
				if(file_upload==0)
				{
					$("#new_file #file_upload2").change(function(){
							file_upload =1;
							$('.waiter').fadeIn(200);
							$.ajaxFileUpload
							(
								{
									url:'/posts/file_upload/',
									secureuri:false,
									fileElementId:'file_upload2',
									dataType: 'json',
									success: function (data, status)
									{
										if(typeof(data.error) != 'undefined')
										{
											if(data.error != '')
											{
												$.jGrowl(data.error, {status:"error"});
											}else
											{
												$("#new_file").modal("hide");

												//tinymce.activeEditor.selection.setContent('<a  href="/file/'+data.file_name+'">'+tinymce.activeEditor.selection.getContent({format : 'text'})+'</a>');

												tinymce.activeEditor.selection.setContent('<a target="_blank" href="/files/'+data.file_name+'">Yüklə</a>');
											}
										}
										$('.waiter').fadeOut(200);
									},
									error: function (data, status, e)
									{alert(e);}
								}
							);
					});

				}
				/*}*/

				}})

				ed.addButton('add_pdf', {
                title : 'PDF yüklə',
                image : '/img/icons/16x16/pdf.png',
                onclick : function() {

					$("#new_pdf").modal("show");
					$("#new_pdf input").attr("id", "file_upload3");
					if(pdf_upload==0)
					{
						$("#new_pdf #file_upload3").change(function(){
								pdf_upload = 1;
								$('.waiter').fadeIn(200);
								$.ajaxFileUpload
								(
									{
										url:'/posts/file_upload/',
										secureuri:false,
										fileElementId:'file_upload3',
										dataType: 'json',
										success: function (data, status)
										{
											if(typeof(data.error) != 'undefined')
											{
												if(data.error != '')
												{
													$.jGrowl(data.error, {status:"error"});
												}else
												{
													$("#new_pdf").modal("hide");
													tinymce.activeEditor.selection.setContent('<p></p><p><iframe src="/files/'+data.file_name+'" width="100%" height="800px"></iframe></p>');
												}
											}
											$('.waiter').fadeOut(200);
										},
										error: function (data, status, e)
										{alert(e);}
									}
								);
						});
					}
				}})
				ed.addButton('add_mp3', {
                title : 'MP3 Yüklə',
                image : '/img/icons/16x16/mp32.png',
                onclick : function() {

						var elem = document.getElementById("mp3_upload");
						if(elem && document.createEvent) {
							  var evt = document.createEvent("MouseEvents");
							  evt.initEvent("click", true, false);
							  elem.dispatchEvent(evt);
						}
						if(mp3_upload==0)
						{
							mp3_upload = 1;
							$("input[name=mp3_upload]").change(function(){
									$('.waiter').fadeIn(200);
									$.ajaxFileUpload
									(
										{
											url:'/posts/mp3_upload/',
											secureuri:false,
											fileElementId:'mp3_upload',
											dataType: 'json',
											success: function (data, status)
											{
												if(typeof(data.error) != 'undefined')
												{
													if(data.error != '')
													{

													}else
													{
														var arr = (data.file_name).split('.');

														tinymce.activeEditor.selection.setContent('<button type="button" id="'+arr[0]+'" class="player_audio btn btn-default">Dinlə <span class="fa fa-play">&nbsp;</span></button><audio class="'+arr[0]+'"><source src="/files/'+data.file_name+'" type="audio/ogg"><source src="/files/'+data.file_name+'" type="audio/mpeg">Sizin proqramınız Audio format dəstəkləmir!</audio>');
													}
												}
												$('.waiter').fadeOut(200);
											},
											error: function (data, status, e)
											{alert(e);}
										}
									);
							});


						}
				}})



        },
   style_formats: [
        {title: 'Qalın mətn', inline: 'b'},
        {title: 'Qırmızı mətn', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Qırmızı başlıq', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Cədvəl stili', selector: 'table', classes: 'table table-bordered table-hover'}
    ]
 });
 /*
 $(".file_manager_images li").livequery(function(){
	$(this).click(function(){
		var thumb = $(this).attr("id");
		if(img_for==1)
		{
			$(".main_thumb").html('<img class="news_img" id="/img/news/350x300/'+thumb+'" style="height:30px !important; border:1px solid #DDD; border-radius: 2px; margin-right: 5px; float: left;" src="/img/news/95x95/'+thumb+'"/><img class="remove_thumb_main" src="/img/icons/16x16/close.png" /><input type="hidden" name="selected_thumb" value="'+thumb+'" />');
		}else if(img_for==3)
		{

			if(thumb)
			{
				$.post("/posts/available_thumb_upload/0/", {thumb: thumb,cabmin:$("input[name=cabmin]").val()}, function(data){
					obj = $.parseJSON(data);
					if(obj.status=="success")
					{
						var img = '<div class="img"><a name="'+thumb+'" id="3" class="remove" href=""></a><img src="/img/news/95x95/'+thumb+'"></div>';
						$(".shop_thumbs").append(img);
						toastr.success(obj.msg, obj.header);
					}else
					{
						toastr.error(obj.msg, obj.header);
					}
					//$(".loader").fadeOut(100);

				});

			}

		}
	});
});
 */




	$(".new_img_slide").change(function(){
		$('.waiter').fadeIn(200);
		$(".img_loader").show();
		$.ajaxFileUpload
		({
			url:'/posts/upload_new_news_thumb/<?=$this->uri->segment(3)?$this->uri->segment(3):0;?>',
			secureuri:false,
			fileElementId:'new_img_slide',
			dataType: 'json',
			success: function (data, status)
			{
				if(typeof(data.error) != 'undefined')
				{
					if(data.error != '')
					{

					}else
					{
						var img = '<div class="img"><a name="'+data.id+'" id="3" class="remove" href=""></a><img src="<?=base_url();?>img/news/95x95/'+data.file_name+'"></div>';
						$(".shop_thumbs").append(img);
						$(".img_loader").hide();
					}
				}
				$('.waiter').fadeOut(200);
			},error: function (data, status, e){alert(e);}
			});
	});
	$(".remove").click(function(evt){
			evt.preventDefault();
			var item = $(this);
			var thumb = $(this).attr("name");
			$(".loader").fadeIn(100);
			$.post("/posts/remove_post_thumb/",{thumb: thumb, tezbazar:$("input[name=tezbazar]").val()},function(data){
				obj = $.parseJSON(data);
				if(obj.status=="success")
				{
					item.closest("div.img").fadeOut(500,function(){$(this).remove();});
					toastr.success(obj.msg, obj.header);
				}else
				{
					toastr.error(obj.msg, obj.header);
				}
				$(".loader").fadeOut(100);
			})
	});
})

</script>

<div id="new_file" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><i class="fa fa-paperclip  green"></i> Fayl Yüklə</h4>
			</div>
			<div class="modal-body">
				<h4>Fayl seçin</h4>
				<div class="form-group">
					<form class="" action=""  enctype="multipart/form-data" method="POST">
					<input class="" type="file" name="file_upload" data-tabindex="1">
					</form>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<div id="new_pdf" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><i class="fa fa-file-pdf-o text-danger"></i> PDF Yüklə</h4>
			</div>
			<div class="modal-body">
				<h4>Fayl seçin</h4>
				<div class="form-group">
					<form class="" action=""  enctype="multipart/form-data" method="POST">
					<input class="" type="file" name="file_upload" data-tabindex="1">
					</form>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<div id="new_img" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><i class="fa fa-camera  red"></i> Yeni Şəkil</h4>
			</div>
			<div class="modal-body">
				<h4>Şəkil seçin</h4>
				<div class="form-group">
					<form class="" action=""  enctype="multipart/form-data" method="POST">
					<input class="" type="file" name="file_upload" data-tabindex="1">
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<!--<button type="button" data-dismiss="modal" class="btn default">İmtina</button>
				<button type="button" class="btn green btn_add_new_role"><i class="fa fa-plus-circle"></i> Daxil et</button>-->
			</div>
		</div>
	</div>
</div>
<div id="new_video" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><i class="fa  fa-play red"></i> <span>Yeni Video</span></h4>
			</div>
			<div class="modal-body">
				<h4>Video linki</h4>
				<div class="form-group">
					<form class="" action=""  enctype="multipart/form-data" method="POST">
					<input class="form-control video_input" type="text" name="" data-tabindex="1">
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn default">İmtina</button>
				<button type="button" class="btn green btn_add add_youtube"><i class="fa fa-plus-circle"></i> Daxil et</button>
			</div>
		</div>
	</div>
</div>
<div id="file_manager_modal" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><img width="16" src="/img/thumbs.png" /> Şəkil arxivi</h4>
			</div>
			<div class="modal-body">


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">İmtina</button>

			</div>
		</div>
	</div>
</div>
