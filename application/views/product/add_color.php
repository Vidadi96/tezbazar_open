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
                <?=$page_title;?>
            </h3>
        </div>
    </div>
</div>
<!-- END: Subheader -->
<div class="m-content">
    <!--begin::Form-->
    <form method="POST" class="">
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
                <ul class="nav nav-tabs" role="tablist" style="margin-bottom: -1px;">
                    <?php $active="active"; foreach ($langs as $lang) {
                        echo '<li class="nav-item">
							<a class="nav-link '.$active.'" data-toggle="tab" href="#" data-target="#tabs_'.$lang->lang_id.'">
								'.$lang->name.' <img style="max-width: 20px" src="/img/langs/'.$lang->thumb.'" style="margin-right: 5px" />
							</a>
						</li>';
                        $active="";
                    }
                    ?>

                </ul>

                <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">




                    <div class="m-portlet__body">
                        <form method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="tab-content">
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4">
                                        <label>Aktiv/Passiv</label>
                                        <div class="m-radio-inline">
                                            <label class="m-radio m-radio--solid">
                                                <input type="radio" name="active" <?=(@$filter["active"])?"":"checked";?> value="1">
                                                Aktiv
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid">
                                                <input type="radio" name="active" <?=(@$filter["active"]==1)?"checked":"";?> value="0">
                                                Passiv
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <?php $active="active"; foreach ($langs as $lang) {
                                    echo'
								<div class="tab-pane '.$active.'" id="tabs_'.$lang->lang_id.'" role="tabpanel">
								<div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label>R??ngin ad??</label>
										<textarea rows="1" type="text" name="name-'.$lang->lang_id.'" value="" class="form-control m-input" placeholder=""></textarea>
									</div>
								</div>
								</div>
								';
                                    $active ="";
                                }
                                ?>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label>&nbsp;</label></br>
                                        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Daxil et</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
                <!--end::Portlet-->
            </div>
            <!--end::Form-->
        </div>

</div>

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<script src="/assets/demo/default/custom/crud/forms/widgets/select2.js" type="text/javascript"></script>
<script src="/assets/demo/default/custom/crud/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/easyui.css">
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        function getChecked(){
            var nodes = $('.easyui-combotree').tree('getChecked');
            var s = '';
            for(var i=0; i<nodes.length; i++){
                if (s != '') s += ',';
                s += nodes[i].text;
            }
            console.log(s);
        }
        $(".easyui-combotree").tree({
            "onCheck": function(){
                getChecked();
            }
        })
        <?php foreach($langs as $lang):?>
        $('input[name=title-<?=$lang->lang_id;?>]').autocomplete({
            type: "GET",
            serviceUrl: '/ajax/get_product_name/'+<?=$lang->lang_id;?>,
            onSelect: function (suggestion) {
                product_id = suggestion.data;
            }
        })
        <?php endforeach;?>


    });

</script>
