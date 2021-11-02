
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
									<?=$this->langs->edit_measure_name; ?>
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
									<label><?=$this->langs->measurement; ?></label>
                  <select class="form-control" name="measure_id">
                      <option value="0"><?=$this->langs->select2; ?></option>
                      <?php foreach ($measure_id as $m) {
                          echo '<option '.(($item[0]["measure_id"]==$m->measure_id)?'selected':'').' value="'.$m->measure_id.'">'.$m->title.'</option>';
                      }
                      ?>
                  </select>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								</div>
								<?php $i=1; foreach($langs as $lang):?>
								<div class="col-lg-3">
									<div class="form-group">
										<label><?=$this->langs->name2; ?> (<?=$lang->name;?>) <img style="max-width: 20px" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" /></label>
										<input type="text" name="title-<?=$lang->lang_id;?>" class="form-control" id="name" value="<?=@$item[(array_search($lang->lang_id, array_column($item, 'lang_id')))]["title"];?>" />
									</div>
								</div>
								<?php
								if($i==3)
								{
									$i=-1;
									echo '</div><div class="form-group m-form__group row">';
								}

								$i++; endforeach;?>
								<div class="col-lg-3">
									<label><?=$this->langs->active_passive; ?></label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=($item[0]["active"]==1)?"checked":"";?> value="1">
											<?=$this->langs->active; ?>
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" <?=($item[0]["active"]==1)?"":"checked";?> value="0">
											<?=$this->langs->passive; ?>
											<span></span>
										</label>
									</div>
								</div>
							</div>

						</div>
						<!--begin:: Portlet footer-->
						<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
							<div class="m-form__actions m-form__actions--solid">
								<div class="row">
									<div class="col-lg-12 m--align-right">
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?=$this->langs->save; ?></button>
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

</script>
<!--end::Page Resources -->
