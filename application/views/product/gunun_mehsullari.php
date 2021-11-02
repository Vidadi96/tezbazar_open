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
						<div class="m-section">
							<div class="m-section__content">

								<!--begin: Search Form -->
								<form action="/product/gunun_mehsuli" method="POST">
									<div class="form-group m-form__group row">
										<div class="col-lg-3">
											<label><?=$this->langs->product_name; ?></label>
											<input type="text" name="title" class="form-control m-input" placeholder="" value="<?=@$filter["title"];?>">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
										</div>
										<div class="col-lg-3">
											<label><?=$this->langs->category; ?></label>
											<input id="cc" name="category_id[]" class="easyui-combotree" data-options="url:'/ajax/get_categories/', method:'get',multiple:true,value:[<?=@implode(",",$filter["category_id"]);?>]" style="width:100%">
										</div>
										<div class="col-lg-3">
											<label>SKU</label>
											<input type="text" name="sku" value="" class="form-control m-input" placeholder="">
										</div>
										<div class="col-md-3">
											<label>&nbsp;</label><br />
											<button type="submit" class="btn btn-primary"><i class="la la-search"></i> <?=$this->langs->search; ?> (<?=@$total[0]->count; ?>)</i></button>
										</div>
									</div>

								</form>
								<!--end: Search Form -->


						<div class="row">
							<div class="col-xl-12">
                <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<table class="table table-bordered m-table" active_passive_url="/product/show_unshow2/">
									<thead>
										<tr>
											<th>
												<?=$this->langs->product_photo; ?>
											</th>
											<th>
												<?=$this->langs->name2; ?>
											</th>
											<th>
												<?=$this->langs->price; ?>
											</th>
											<th>
												SKU
											</th>
                      <th>
												<?=$this->langs->category; ?>
											</th>
											<th>
												<?=$this->langs->show_unshow2; ?>
											</th>
										</tr>
									</thead>
									<tbody>
                    <?php foreach($list as $row): ?>
                      <?php
											$word=$this->langs->unshow."!"; $class="btn-success";
                      $active_passive = 0;
  											if(!$row->show)
  											{
  												$word=$this->langs->display."!";
  												$class="btn-danger";
                          $active_passive = 1;
  											}
  											$btn_active_passive ='<button id="'.$row->p_id.'" active_passive="'.$active_passive.'" type="button" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="'.$word.'" class="'.$class.' set_active_passive btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air show_unshow"></button>';
                      ?>
                      <tr>
                        <td scope="row sm_img">
                          <img src="/img/products/95x95/<?=$row->img; ?>" width="24" />
                        </td>
                        <td><?=$row->title; ?></td>
                        <td><?=$row->ex_price; ?></td>
                        <td><?=$row->sku; ?></td>
                        <td><?=$row->category; ?></td>
                        <td><?=$btn_active_passive; ?></td>
                      </tr>
                    <?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>





							</div>
						</div>
					</div>
				</div>
				<!--end::Portlet-->
				<div class="text-center">
					 <ul class="pagination pagination-lg text-center" style="display: inline-flex;">
							<?=@$pagination;?>
					 </ul>
				</div>
			</div>
		</div>
	</div>

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/easyui.css">
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
