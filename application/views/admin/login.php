<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			Tezbazar | Login page
		</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Base Styles -->
		<link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/demo/default/base/custom_login.css" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="/assets/img/logo_part1.png" />
	</head>
	<!-- end::Head -->
    <!-- end::Body -->
	<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->

		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-login m-login--signin  m-login--5" id="m_login" style="background-image: url(/assets/app/media/img/bg/bg-3.jpg);">
				<div class="m-login__wrapper-2 m-portlet-full-height">
					<div class="m-login__contanier">
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">
									<img width="200" src="/assets/img/logo_tezbazar.png">
								</h3>
							</div>

							<form class="m-login__form m-form" action="/auth/index/" method="post">
								<?php if(isset($status)):?>
								<div class="m-alert m-alert--outline alert alert-<?=$status["status"];?> alert-dismissible animated fadeIn" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
									<span><?=$status["msg"];?></span>
								</div>
								<?php endif;?>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="İstifadəçi adı" name="user_name" autocomplete="off">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input " type="password" placeholder="Şifrə" name="user_pass">
								</div>



								<?php if(isset($captcha)): ?>
								<div class="form-group m-form__group">
									<div class="input-group">
										<input type="text" style="z-index: 887;" class="form-control m-input" name="captcha" placeholder="Security Code">
										<span class="input-group-btn">
											<img style="z-index: 888; cursor: pointer; position: absolute; right: 0; bottom: 1px;" src="/auth/captcha?<?=strtotime(date("Y-d-m H:i:s"));?>" class="captcha" />
										</span>
									</div>
								</div>
								<?php endif;?>


								<div class="row m-login__form-sub">
									<div class="col m--align-left">
										<label class="m-checkbox m-checkbox--focus">
											<input type="checkbox" name="remember">
											Yadda saxla
											<span></span>
										</label>
									</div>
									<div class="col m--align-right" style="display: none;">
										<a href="javascript:;" id="m_login_forget_password" class="m-link">
											Şifrənizi unutdunuz ?
										</a>
									</div>
								</div>
								<div class="m-login__form-action">
									<button id="m_login_signin_submit" class="btn btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air">
										Daxil ol
									</button>
								</div>
							</form>
						</div>
						<div class="m-login__signup">
							<div class="m-login__head">
								<h3 class="m-login__title">
									Qeydiyyatdan keç
								</h3>
								<div class="m-login__desc">
									Şəxsi məlumatları daxil edərək hesabınızı yaradın:
								</div>
							</div>
							<form class="m-login__form m-form" action="">
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Tam adınız" name="fullname">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="E-poçt" name="email" autocomplete="off">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="password" placeholder="Şifrə" name="password">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Şifrənin təkrarı" name="rpassword">
								</div>
								<div class="m-login__form-sub">
									<label class="m-checkbox m-checkbox--focus">
										<input type="checkbox" name="agree">
										<a href="#" class="m-link m-link--focus">
											Şərtləri
										</a>
										qəbul edirəm.
										<span></span>
									</label>
									<span class="m-form__help"></span>
								</div>
								<div class="m-login__form-action">
									<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
										Göndər
									</button>
									<button id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">
										İmtina
									</button>
								</div>
							</form>
						</div>
						<div class="m-login__forget-password">
							<div class="m-login__head">
								<h3 class="m-login__title">
									Şifrənizi unutdunuz ?
								</h3>
								<div class="m-login__desc">
									E-poçt ünvanınızı daxil edib şifrə bərpa linkini əldə edin:
								</div>
							</div>
							<form class="m-login__form m-form" action="">
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
								</div>
								<div class="m-login__form-action">
									<button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
										Sorğu
									</button>
									<button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom ">
										İmtina
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end:: Page -->
    	<!--begin::Base Scripts -->
		<script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Base Scripts -->
        <!--begin::Page Snippets -->
		<script src="/assets/snippets/custom/pages/user/login.js" type="text/javascript"></script>
		<!--end::Page Snippets -->
	</body>
	<!-- end::Body -->
</html>
