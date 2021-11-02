<!-- BEGIN: Subheader -->
<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="/adm/index/" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
			</ul>
			<h3 class="m-subheader__title m-subheader__title--separator">
				<?=$menu_name;?>
			</h3>
		</div>

	</div>
</div>
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
									Redaktə
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
									<label>Menyunun linki</label>
									<input type="text" name="link" value="<?=$menu_item[0]["link"];?>" class="form-control m-input" placeholder="">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									<span class="m-form__help">Misal üçün: <i>/adm/menu_permissions/</i></span>
								</div>
								<div class="col-lg-3">
									<label>İkon</label>
									<input type="text" name="icon" value="<?=$menu_item[0]["icon"];?>" class="form-control m-input" placeholder="">
									<span class="m-form__help">Misal üçün: <i>fa-home</i> <a href="https://fontawesome.com/v4.7.0/icons/">Fontlar</a></span>
								</div>

								<div class="col-lg-3">
									<label>Aid olduğu menu</label>
                  <select class="form-control" name="parent_id">
                    <option value=0>Baş səhifə</option>
                    <?php foreach ($all_menus as $value) {
                      echo '<option '.($menu_item[0]["parent_id"]==$value['menu_id']?"selected":"").' value="'.$value['menu_id'].'">'.$value['full_name'].'</option>';
                    } ?>
                  </select>
								</div>
								<div class="col-lg-3">
									<label>İcazə verilən rollar</label>
                  <input id="cc" name="role_id[]" class="easyui-combobox" data-options="url:'/ajax/get_roles/', method:'get',valueField:'id', textField:'name', multiple:true,value:[<?=$selected_roles;?>]" style="width:100%">
								</div>
							</div>
              <div class="form-group m-form__group row">
                <div class="col-lg-3">
									<label>Sıra nömrəsi</label>
									<input type="text" name="order_by" value="<?=$menu_item[0]["order_by"];?>" class="form-control m-input" placeholder="">
								</div>
								<div class="col-lg-3">
									<label>Menyu/Metod</label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="menu_type_id" <?=($menu_item[0]["menu_type_id"]==1)?"checked":"";?> value="1">
											Menyu
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="menu_type_id" <?=($menu_item[0]["menu_type_id"]==2)?"checked":"";?> value="2">
											Metod
											<span></span>
										</label>
									</div>
								</div>
								<?php $i=2; foreach($langs as $lang):?>
								<div class="col-lg-3">
									<div class="form-group">
										<label>Menyunun adı (<?=$lang->name;?>) <img style="max-width: 20px" src="/img/langs/<?=$lang->thumb;?>" style="margin-right: 5px" /></label>
										<input type="text" name="full_name-<?=$lang->lang_id;?>" class="form-control" id="name" value="<?=$menu_item[(array_search($lang->lang_id, array_column($menu_item, 'lang_id')))]["full_name"];?>" />
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
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Yadda saxla</button>
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
      <link rel="stylesheet" type="text/css" href="/css/easyui.css">
      <link rel="stylesheet" type="text/css" href="/css/icon.css">
      <script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
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
        DatatableHtmlTableDemo.init();
    });









    </script>
    <!--end::Page Resources -->
