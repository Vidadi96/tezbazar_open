
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
									<?=$this->langs->new_parameter; ?>
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
													<input type="radio" name="active" <?=(@$filter["active"])?"":"checked";?> value="1">
													<?=$this->langs->active; ?>
													<span></span>
												</label>
												<label class="m-radio m-radio--solid">
													<input type="radio" name="active" <?=(@$filter["active"]==1)?"checked":"";?> value="0">
													<?=$this->langs->passive; ?>
													<span></span>
												</label>
											</div>
										</div>
										<div class="col-lg-6">
											<label><?=$this->langs->required_field; ?></label>
											<div class="m-radio-inline">
												<label class="m-radio m-radio--solid">
													<input type="radio" name="required" <?=(@$filter["required"])?"":"checked";?> value="1">
													<?=$this->langs->required2; ?>
													<span></span>
												</label>
												<label class="m-radio m-radio--solid">
													<input type="radio" name="required" <?=(@$filter["required"]==1)?"checked":"";?> value="0">
													<?=$this->langs->not_required; ?>
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-1">
									<label><?=$this->langs->row_number; ?></label>
									<input type="text" class="form-control" name="order_by" />
								</div>
								<?php $i=1; foreach($langs as $lang):
									if($i==1)
									{
										$i=1;
										echo '</div><div class="form-group m-form__group row">';
									}?>
								<div class="col-lg-3">
									<div class="form-group">
										<label><?=$this->langs->parameter_name; ?> (<?=$lang->name;?>) <img style="max-width: 20px" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" /></label>
										<input type="text" name="param_title-<?=$lang->lang_id;?>" class="form-control" id="param_title" value="" />
									</div>
								</div>
								<?php
								if($i==4)
								{$i=1;}


								$i++; endforeach;?>

							</div>
							<div class="form-group m-form__group row">
								<div class="col-lg-12 param_container">

								</div>
							</div>
						</div>
						<!--begin:: Portlet footer-->
						<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
							<div class="m-form__actions m-form__actions--solid">
								<div class="row">
									<div class="col-lg-12 m--align-right">
										<button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> <?=$this->langs->submit; ?></button>
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
									<?=$this->langs->list; ?>
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
						<table delete_url="/product/delete_param/" class="table table-bordered m-table" active_passive_url="/product/param_set_active_passive/">
							<thead>
								<tr>
									<th>
										<?=$this->langs->type; ?>
									</th>
									<th>
										<?=$this->langs->group; ?>
									</th>
									<th>
										<?=$this->langs->parameter_header; ?>
									</th>
									<th>
										<?=$this->langs->row_number; ?>
									</th>
									<th>
										<?=$this->langs->active_passive; ?>
									</th>
									<th>
										<?=$this->langs->edit; ?>
									</th>
									<th>
										<?=$this->langs->delete; ?>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list as $item) {
									$word=$this->langs->do_passive."!"; $class="btn-success"; $active_passive=0;
									if($item->active==0)
									{
										$word=$this->langs->do_active."!";
										$class="btn-danger";
										$active_passive = 1;
									}
									$btn_active_passive ='<button active_passive="'.$active_passive.'" id="'.$item->param_id.'" type="button" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="'.$word.'" class="'.$class.' set_active_passive btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"></button>';

									echo '
									<tr>
										<td>
											'.$item->param_type_title.'
										</td>
										<td>
											'.$item->param_group_title.'
										</td>
										<td>
											'.$item->param_title.'
										</td>
										<td>
											'.$item->order_by.'
										</td>
										<td>
											'.$btn_active_passive.'
										</td>
										<td>
											<a href="/product/edit_param/'.$item->param_id.'" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only">
												<i class="fa fa-pencil-alt"></i>
											</button>
										</td>
										<td>
											<a href="#" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="'.$item->param_id.'">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
									';
								};?>

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
		$("select[name=param_type_id]").change(function(){
			var selected_val = $(this).val();
			$.get("/ajax/get_param_add/"+selected_val,function(data){
				$(".param_container").html(data);
			})
		});

		$(document).on('click', ".add_sub_param", function (evt) {
			var tbody = $(this).closest("table").find("tbody");
			var selected_val = $(this).attr("rel");
			$.get("/ajax/get_sub_param_add/"+selected_val,function(data){
				tbody.append(data);
			})
		});

});

</script>
<!--end::Page Resources -->
