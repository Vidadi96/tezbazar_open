
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
									Yeni dil
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
									<label>Bayraq şəkli</label>
									<div></div>
									<div class="custom-file">
										<input type="file" name="thumb" class="custom-file-input" id="customFile">
										<label class="custom-file-label" for="customFile">
											Choose file
										</label>
									</div>
									<span class="m-form__help">Şəklin ölçüsünün 24x24 olmasına diqqət edin.</span>
								</div>
								<div class="col-lg-3">
									<label>Dilin adı</label>
									<input type="text" name="name" class="form-control m-input" placeholder="">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									<span class="m-form__help">Misal üçün: <i>AZE</i></span>
								</div>
								<div class="col-lg-3">
									<label>Sıra nömrəsi</label>
									<input type="text" name="order_by" class="form-control m-input" placeholder="">
								</div>
								<div class="col-lg-3">
									<label>Aktiv/Passiv</label>
									<div class="m-radio-inline">
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" checked value="1">
											Aktiv
											<span></span>
										</label>
										<label class="m-radio m-radio--solid">
											<input type="radio" name="active" value="0">
											Passiv
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
						<div class="m-section">
							<div class="m-section__content">
								<table delete_url="/adm/delete_lang/" class="table table-bordered m-table" active_passive_url="/adm/set_active_passive_lang/">
									<thead>
										<tr>
											<th>
												Bayrağın şəkli (24x24)
											</th>
											<th>
												Adı
											</th>
											<th>
												Sıra nömrəsi
											</th>
											<th>
												Aktiv/Passiv
											</th>
											<th>
												Redaktə
											</th>
											<th>
												Sil
											</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($langs as $item) {
											$word="Passiv et!"; $class="btn-success"; $active_passive=0;
											if($item->active==0)
											{
												$word="Aktiv et!";
												$class="btn-danger";
												$active_passive = 1;
											}
											$btn_active_passive ='<button active_passive="'.$active_passive.'" id="'.$item->lang_id.'" type="button" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="'.$word.'" class="'.$class.' set_active_passive btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"></button>';

											echo '
											<tr>
												<td scope="row sm_img">
													<img src="/img/langs/'.$item->thumb.'" width="24" />
												</td>
												<td>
													'.$item->name.'
												</td>
												<td>
													'.$item->order_by.'
												</td>
												<td>
													'.$btn_active_passive.'
												</td>
												<td>
													<button href="#" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="'.$item->lang_id.'">
														<i class="fa fa-trash"></i>
													</button>
												</td>
												<td>
													<a href="/adm/edit_lang/'.$item->lang_id.'" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only">
														<i class="fa fa-pencil-alt"></i>
													</button>
												</td>
											</tr>
											';
										};?>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!--end::Portlet-->
			</div>
		</div>
	</div>

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
