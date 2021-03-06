<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="/slides/get_view_main/" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
			</ul>
			<h3 class="m-subheader__title m-subheader__title--separator">
				<?=$page_title;?>
			</h3>
		</div>
		<div class="btn btn-success pull-right" id="new_slide"><i class="fa fa-plus"></i> <?=$this->langs->new_slide; ?></div>
	</div>
</div>
<!-- END: Subheader -->

	<div class="m-content">
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
									<?=$this->langs->settings;?>
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

								<form action="/slides/save_settings_main" method="POST">
									<div class="form-group m-form__group row">
										<div class="col-lg-3">
											<label><?=$this->langs->change_time;?></label>
											<input type="text" name="change_time" class="form-control m-input" placeholder="" value="<?=$time; ?>">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
											<input type="hidden" name="slide_name" value="daily_products">
											<span class="m-form__help"><?=$this->langs->for_example; ?>: <i>10</i></span>
										</div>
										<div class="col-lg-3">
											<label><?=$this->langs->active_passive;?></label>
											<div class="m-radio-inline">
												<label class="m-radio m-radio--solid">
													<input type="radio" name="active" <?=($active_passive==1)?"checked":"";?> value="1">
													<?=$this->langs->active;?>
													<span></span>
												</label>
												<label class="m-radio m-radio--solid">
													<input type="radio" name="active" <?=($active_passive==0)?"checked":"";?> value="0">
													<?=$this->langs->passive;?>
													<span></span>
												</label>
											</div>
										</div>
										<div class="col-md-3">
											<label>&nbsp;</label><br />
											<button type="submit" class="btn btn-primary"><i class="la la-save"></i>
												<?=$this->langs->save;?>
											</button>
										</div>
									</div>

								</form>
								<!--end: Save Settings Form -->

							</div>
						</div>
					</div>
				</div>
				<!--end::Portlet-->
				<div class="text-center">
					 <ul class="pagination pagination-sm ">
							<?=@$pagination;?>
					 </ul>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">

lang = $('#language2').text();

var notification = [];
notification['az'] = 'Bildiri??';
notification['tr'] = 'Bildiri??';
notification['en'] = 'Notification';
notification['ru'] = '??????????????????????';

var error2 = [];
error2['az'] = 'X??ta';
error2['ru'] = '????????????';
error2['en'] = 'Error';
error2['tr'] = 'Hata';

var error_msg = [];
error_msg['az'] = 'X??ta ba?? verdi';
error_msg['ru'] = '?????????????????? ????????????';
error_msg['en'] = 'An error has occured';
error_msg['tr'] = 'Bir hata olu??tu';

var success_msg = [];
success_msg['az'] = 'U??urla yadda saxlan??ld??';
success_msg['ru'] = '?????????????? ??????????????????';
success_msg['en'] = 'Successfully saved';
success_msg['tr'] = 'Ba??ar??yla kayd edildi';

var success_msg2 = [];
success_msg2['az'] = 'Y??kl??nm?? u??urla tamamland??';
success_msg2['ru'] = '???????????????? ???????????? ??????????????';
success_msg2['en'] = 'Successfully downloaded';
success_msg2['tr'] = 'Ba??ar??yla y??klenildi';

let searchParams = new URLSearchParams(window.location.search)
if(searchParams.has('img_name'))
{
  let error = searchParams.get('error');
  let img_name = searchParams.get('img_name');

  if(img_name.length > 0)
    toastr.success(img_name, success_msg2[lang]);
  else
    toastr.error(error, error2[lang]);
}

if(searchParams.has('message'))
{
  let message = searchParams.get('message');

  if(message == 'saved')
    toastr.success(notification[lang], success_msg[lang]);
  else
		toastr.error(notification[lang], error_msg[lang]);
}

</script>
