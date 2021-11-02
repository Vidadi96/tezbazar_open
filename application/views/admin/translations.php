
	<div class="m-content">
		<div class="row">
			<div class="col-lg-12">
				<!--begin::Portlet-->
				<?php if(isset($status)): ?>
				<div class="m-alert m-alert--icon m-alert--outline alert alert-<?=$status['status'];?> alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="fa fa-<?=$status['icon'];?>"></i>
					</div>
					<div class="m-alert__text">
						<strong><?=$status['title'];?> </strong> <?=$status['msg'];?>
					</div>
					<div class="m-alert__close">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
					</div>
				</div>
				<?php endif;?>
				<div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Yeni söz
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-angle-down"></i>
									</a>
								</li>
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-expand"></i>
									</a>
								</li>

							</ul>
						</div>
					</div>
					<!--begin::Form-->
					<form enctype="multipart/form-data" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
						<div class="m-portlet__body">
							<div class="form-group m-form__group row">
								<div class="col-lg-3">
									<label>Açar söz</label>
									<input type="text" name="meta_key" value="" class="form-control m-input" placeholder="">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									<span class="m-form__help">Misal üçün: <i>user_surname</i></span>
								</div>
								<div class="col-lg-3">
									<label>Site/Admin</label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="where_for" <?=(@$filter["active"])?"":"checked";?> value="0">
											Admin
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="where_for" <?=(@$filter["active"]==1)?"checked":"";?> value="1">
											Site
											<span></span>
										</label>
									</div>
								</div>
								<?php $i=2; foreach($langs as $lang):?>
								<div class="col-lg-3">
									<div class="form-group">
										<label>Söz (<?=$lang->name;?>) <img style="max-width: 20px" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" /></label>
										<input type="text" name="meta_value-<?=$lang->lang_id;?>" class="form-control" id="name" value="" />
									</div>
								</div>
								<?php
								if($i==3)
								{
									$i=-1;
									echo '</div><div class="form-group m-form__group row">';
								}

								$i++; endforeach;?>
							</div>

						</div>
						<!--begin:: Portlet footer-->
						<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
							<div class="m-form__actions m-form__actions--solid">
								<div class="row">
									<div class="col-lg-12 m--align-right">
										<button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Daxil et</button>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Portlet footer-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Portlet-->
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<!--begin::Portlet-->
				<div class="m-portlet m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Siyahı
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-angle-down"></i>
									</a>
								</li>
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-expand"></i>
									</a>
								</li>

							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<!--begin: Search Form -->
						<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
							<div class="row align-items-center">
								<div class="col-xl-8 order-2 order-xl-1">
									<div class="form-group m-form__group row align-items-center">
										<div class="col-md-4">
											<div class="m-input-icon m-input-icon--left">
												<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
												<span class="m-input-icon__icon m-input-icon__icon--left">
													<span>
														<i class="la la-search"></i>
													</span>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end: Search Form -->
						<!--begin: Datatable -->
						<table class="m-datatable inline_edit" id="html_table" width="100%" delete_url="/adm/delete_meta_key/" inline_save_url="/adm/translation_update/">
							<thead>
								<tr>

									<th>
										Metakey
									</th>
									<?php $i=0; $width=100/count($langs); foreach($langs as $lang):?>

										<th width="<?=$width;?>%">
											<?=$lang->name;?> <img width="20" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" />
										</th>
									<?php endforeach; ?>
									<th>
										Delete
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($lang_meta as $meta):?>
								<tr class="odd gradeX" meta_key="<?=$meta->meta_key;?>" class="deleted_tr_<?=$meta->meta_key;?>">

	                <td>
	                  <?=$meta->meta_key;?>
	                </td>
									<?php $i=0; foreach($langs as $lang):?>
									<td>
										 <a meta_key="<?=$meta->meta_key;?>" name="data" lang_id="<?=$lang->lang_id;?>" classes="input-sm"  input_type="textarea" href="javascript:;"><?=($meta->{"lang_".$lang->lang_id})?($meta->{"lang_".$lang->lang_id}):"---";?></a>
									</td>
									<?php endforeach; ?>
									<td>
										<button href="#" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="<?=$meta->meta_key;?>">
											<i class="fa fa-trash"></i>
										</button>
	                </td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<!--end: Datatable -->
					</div>
				</div>
				<!--end::Portlet-->
			</div>
		</div>
	</div>

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<!--begin::Page Resources -->
<script type="text/javascript">
var DatatableHtmlTableDemo = {
    init: function() {
        $(".m-datatable").mDatatable({
            search: {
                input: $("#generalSearch")
            },
            layout: {
                scroll: !0,
                height: 600
            }/*,
            columns: [{
                field: "Metakey",
                type: "text",
                locked: {
                    left: "xl"
                }
            },{
                field: "Delete",
                type: "text",
                locked: {
                    left: "xl"
                }
            }]*/
        })
    }
};
jQuery(document).ready(function() {
    DatatableHtmlTableDemo.init()
});




/*============Start Inline edit============*/
		var current_value = "";
		var html_input = "";
		var input_type ="";
		var classes = "";
		var current_lang_id="";
		var current_meta_key="";
		var span_attr="";
		function set_input(evt)
		{
			input_type = $(evt.target).attr("input_type");
			current_value = $(evt.target).html();
			classes = $(evt.target).attr("classes");

			if(input_type == "text")
			html_input = '<input elm="current" class="html_input form-control '+classes+'" type="text" value="'+current_value+'" />';
			else
			html_input = '<textarea elm="current" class="html_input form-control '+classes+'" type="text">'+current_value+'</textarea>';

			current_lang_id = $(evt.target).attr("lang_id");
			current_meta_key = $(evt.target).attr("meta_key");
			span_attr = $(evt.target).closest("span").attr("style");
			$(evt.target).closest("td").html(html_input);
			$(".html_input").focus().select();
		}
		var save_input_values  = function (evt)
		{

			if($(evt.target).attr("elm")!="current")//if input or textarea is not active
			{

				if($(evt.target).attr("name")=="data")//if clicked on a element
				{

					if($(".inline_edit").find(".html_input").length==0)//if not opened input or textarea
					{
						set_input(evt);
					}else
					{
						var html_input_val = $(".html_input").val();
						if(current_value!=html_input_val)// if have any changes
						{
							$.post($("table.inline_edit").attr("inline_save_url"),
							{
								meta_key: current_meta_key,
								column_value: html_input_val,
								lang_id: current_lang_id,
								tezbazar:$("input[name=tezbazar]").val()
							},function(data)
							{
								$(".html_input").closest("td").html('<span style="'+span_attr+'"><a meta_key="'+current_meta_key+'" name="data" lang_id="'+current_lang_id+'" classes="input-sm"  input_type="textarea" href="javascript:;">'+html_input_val+'</a></span>');
								set_input(evt);
							});
						}else
						{
							$(".html_input").closest("td").html('<span style="'+span_attr+'"><a meta_key="'+current_meta_key+'" name="data" lang_id="'+current_lang_id+'" classes="input-sm"  input_type="textarea" href="javascript:;">'+html_input_val+'</a></span>');
							set_input(evt);
						}

					}


				}else
				{
//console.log(1);
					if($(".inline_edit").find(".html_input").length>0)//if have ane opened input or textarea
					{

						var html_input_val = $(".html_input").val();
						if(current_value!=html_input_val)// if have any changes
						{
							$.post($(".inline_edit").attr("inline_save_url"),
							{
								meta_key: current_meta_key,
								column_value: html_input_val,
								lang_id: current_lang_id,
								tezbazar:$("input[name=tezbazar]").val()

							},function(data)
							{
								var obj = $.parseJSON(data);
								if(obj.status=="success")
								{
									$(".html_input").closest("td").html('<span style="'+span_attr+'"><a meta_key="'+current_meta_key+'" name="data" lang_id="'+current_lang_id+'" classes="input-sm"  input_type="textarea" href="javascript:;">'+html_input_val+'</a></span>');
									toastr.success(obj.msg, obj.header);
								}else
								{
									toastr.error(obj.msg, obj.header);
								}

							});
						}else
						{
							$(".html_input").closest("td").html('<span style="'+span_attr+'"><a meta_key="'+current_meta_key+'" name="data" lang_id="'+current_lang_id+'" classes="input-sm"  input_type="textarea" href="javascript:;">'+html_input_val+'</a></span>');
						}
					}
				}

			}

		}
		$(document).on("click", save_input_values);

		$(document).on('click', '.inline_edit a', function (evt) {
				evt.preventDefault();
		});

		//$(".html_input").livequery(function(){
			$(document).on('keyup', '.html_input', function (e) {
			//$(this).keyup(function(e){
				//console.log(e.which);
				if(e.which == 13) {
					var html_input_val = $(".html_input").val();
					if(current_value!=html_input_val)// if have any changes
					{
						$.post($(".inline_edit").attr("inline_save_url"),
						{
							meta_key: current_meta_key,
							column_value: html_input_val,
							lang_id: current_lang_id,
							tezbazar:$("input[name=tezbazar]").val()
						},function(data)
						{
							var obj = $.parseJSON(data);
							if(obj.status=="success")
							{
								$(".html_input").closest("td").html('<span style="'+span_attr+'"><a meta_key="'+current_meta_key+'" name="data" lang_id="'+current_lang_id+'" classes="input-sm"  input_type="textarea" href="javascript:;">'+html_input_val+'</a></span>');
								toastr.success(obj.msg, obj.header);
							}else
							{
								toastr.error(obj.msg, obj.header);
							}
						});
					}else
					{
						$(".html_input").closest("td").html('<span style="'+span_attr+'"><a meta_key="'+current_meta_key+'" name="data" lang_id="'+current_lang_id+'" classes="input-sm"  input_type="textarea" href="javascript:;">'+html_input_val+'</a></span>');
					}
				}else if(e.which == 27)
				{
					$(".html_input").closest("td").html('<span style="'+span_attr+'"><a meta_key="'+current_meta_key+'" name="data" lang_id="'+current_lang_id+'" classes="input-sm"  input_type="textarea" href="javascript:;">'+current_value+'</a></span>');
				}
			//});
		});
		/*============End Inline edit============*/










</script>
<!--end::Page Resources -->
