
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
									<?=$this->langs->edit; ?>
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
					<form method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
						<div class="m-portlet__body">
							<div class="form-group m-form__group row">

								<div class="col-lg-3">
									<label><?=$this->langs->parameter_group; ?></label>
									<select class="form-control" name="param_group_id">
										<?php foreach ($param_groups as $group) {
											if($group->param_group_id == $param_id->param_group_id)
												echo '<option selected value="'.$group->param_group_id.'">'.$group->param_group_title.'</option>';
											else
												echo '<option value="'.$group->param_group_id.'">'.$group->param_group_title.'</option>';
										}
										?>
									</select>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								</div>
								<div class="col-lg-3">
									<label><?=$this->langs->parameter_type; ?></label>
									<select class="form-control" name="param_type_id">
										<?php foreach ($param_types as $item) {
											if($item->param_type_id == $param_id->param_type_id)
												echo '<option selected value="'.$item->param_type_id.'">'.$item->param_type_title.'</option>';
											else
												echo '<option value="'.$item->param_type_id.'">'.$item->param_type_title.'</option>';
										}
										?>
									</select>
								</div>

								<div class="col-lg-5">
									<div class="form-group row">
										<div class="col-lg-6">
											<label><?=$this->langs->active_passive; ?></label>
											<div class="m-radio-inline">
												<label class="m-radio m-radio--solid">
													<input type="radio" name="active" <?=$param_id->active?"checked":"";?> value="1">
													<?=$this->langs->active; ?>
													<span></span>
												</label>
												<label class="m-radio m-radio--solid">
													<input type="radio" name="active" <?=$param_id->active?"":"checked";?> value="0">
													<?=$this->langs->passive; ?>
													<span></span>
												</label>
											</div>
										</div>
										<div class="col-lg-6">
											<label><?=$this->langs->required_field; ?></label>
											<div class="m-radio-inline">
												<label class="m-radio m-radio--solid">
													<input type="radio" name="required" <?=$param_id->required?"checked":"";?> value="1">
													<?=$this->langs->required2; ?>
													<span></span>
												</label>
												<label class="m-radio m-radio--solid">
													<input type="radio" name="required" <?=$param_id->required?"":"checked";?> value="0">
													<?=$this->langs->not_required; ?>
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-1">
									<label><?=$this->langs->row_number; ?></label>
									<input type="text" class="form-control" value="<?=$param_id->order_by;?>" name="order_by" />
								</div>
								<?php $i=1; foreach($langs as $lang):
									$key = array_search($lang->lang_id, array_column($params, 'lang_id'));
									if($i==1)
									{
										$i=1;
										echo '</div><div class="form-group m-form__group row">';
									}?>
								<div class="col-lg-3">
									<div class="form-group">
										<label><?=$this->langs->parameter_name; ?> (<?=$lang->name;?>) <img style="max-width: 20px" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" /></label>
										<input type="text" name="param_title-<?=$lang->lang_id;?>" class="form-control" id="param_title" value="<?=$params[$key]["param_title"];?>" />
									</div>
								</div>
								<?php
								if($i==4)
								{$i=1;}


								$i++; endforeach;?>

							</div>
							<div class="form-group m-form__group row">
								<div class="col-lg-12 param_container">
									<?php if($param_id->param_type_id>=4 && $param_id->param_type_id<=6){
											echo '<table delete_url="/product/delete_sub_param_id/" class="table table-sm m-table m-table--head-bg-light table-bordered">
											<thead class="thead-inverse">
												<tr>';
												$thead="";
												foreach($langs as $lang){
													echo '<th>
														<img alt="'.$lang->name.'" style="max-width: 20px" src="/img/langs/'.$lang->thumb.'" style="margin-right: 5px" /> Sub '.$this->langs->parameter_name.'
													</th>';
												}
												echo '<th style="position:relative;">'.$this->langs->delete.' <a style="position: absolute; top:-24px; right: 0px;" href="javascript:;" class="btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only add_sub_param" rel="'.$param_id->param_type_id.'" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="'.$this->langs->new_sub_parameter.'">
													<i class="fa fa-plus"></i>
												</a></th></tr></thead><tbody>';

												foreach ($sub_params_id as $sp_id) {
													echo '<tr>';
													foreach($langs as $lang){
														$sub_td = false;
														foreach ($sub_params as $sub) {
															if(($sub->sub_param_id==$sp_id->sub_param_id) && ($sub->lang_id==$lang->lang_id))
															{
																$sub_td = '<td>
																<textarea name="sub_param_title-'.$lang->lang_id.'-['.$sp_id->sub_param_id.'][]" class="form-contrl param_txt" >'.$sub->sub_param_title.'</textarea>
																</td>';
															}
														}
														if(!$sub_td)
														{
															$sub_td = '<td>
															<textarea name="sub_param_title-'.$lang->lang_id.'-['.$sp_id->sub_param_id.'][]" class="form-contrl param_txt" ></textarea>
															</td>';
														}
														echo $sub_td;
													}
													echo '<td><a href="javascript:;" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="'.$sp_id->sub_param_id.'"><i class="fa fa-trash"></i></a></td></tr>';
												}
												echo '</tbody></table>';
												// $sub_tr = "";
												// foreach ($sub_params as $sub) {
												// 	if($sub->lang_id==$lang->lang_id)
												// 	{
												// 		$sub_tr
												// 	}
												// }
												// $tbody = $tbody.'<td>
												// <textarea name="sub_param_title-'.$lang->lang_id.'[]" class="form-contrl param_txt" ></textarea>
												// </td>';

									}?>
								</div>
							</div>
						</div>
						<!--begin:: Portlet footer-->
						<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
							<div class="m-form__actions m-form__actions--solid">
								<div class="row">
									<div class="col-lg-12 m--align-right">
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?=$this->langs->save2; ?></button>
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
		<!--end::.row-->
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
		$("select[name=param_type_id]").change(function(){
			var selected_val = $(this).val();
			$.get("/ajax/get_param_add_edit/"+selected_val,function(data){
				$(".param_container").html(data);
			})
		});

		$(document).on('click', ".add_sub_param", function (evt) {
			var tbody = $(this).closest("table").find("tbody");
			var selected_val = $(this).attr("rel");
			$.get("/ajax/get_sub_param_add_edit/"+selected_val,function(data){
				tbody.append(data);
			})
		});

});

</script>
<!--end::Page Resources -->
