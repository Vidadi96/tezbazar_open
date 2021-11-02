<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			Tezbazar | Dashboard
		</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
		<link href="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors -->
		<!-- <script src="/js/jquery.min.js" type="text/javascript"></script> -->
		<link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/demo/default/base/custom_main.css" rel="stylesheet" type="text/css" />
		<?php if($title == 'users/waiting'): ?>
			<link href="/assets/adminPanel/css/waiting.css" rel="stylesheet" type="text/css" />
		<?php endif; ?>
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<!--begin::Base Scripts -->
		<script src="/assets/vendors/base/vendors.bundle.js?v=2" type="text/javascript"></script>
		<script src="/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
		<script src="/js/jquery.autocomplete.js"></script>
		<!--end::Base Scripts -->
	</head>
	<!-- end::Head -->
    <!-- end::Body -->
	<body  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item    m-header "  m-minimize-offset="200" m-minimize-mobile-offset="200" >
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">
						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-dark ">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="/" target="_blank" class="m-brand__logo-wrapper">
										<!-- <img alt="" src="/img/logo.png"/> -->
										Tezbazar
									</a>
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">
									<!-- BEGIN: Left Aside Minimize Toggle -->
									<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
										<span></span>
									</a>
									<!-- END -->
							<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>
									<!-- END -->
							<!-- BEGIN: Responsive Header Menu Toggler -->
									<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>
									<!-- END -->
			<!-- BEGIN: Topbar Toggler -->
									<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
										<i class="flaticon-more"></i>
									</a>
									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
						</div>
						<!-- END: Brand -->
						<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
							<!-- BEGIN: Horizontal Menu -->
							<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
								<i class="la la-close"></i>
							</button>
							<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark "  >
								<?php
								$lang_array = json_decode(json_encode($langs), true);
								$key = array_search($this->session->lang, array_column($lang_array, 'lang_id'));

								function removeParam($url, $param) {
									$url = preg_replace('/(&|\?)'.preg_quote($param).'=[^&]*$/', '', $url);
									$url = preg_replace('/(&|\?)'.preg_quote($param).'=[^&]*&/', '$1', $url);
									return filter_var(str_replace(array("'", '"',"`", ')', '('), array("","","","",""),strip_tags($url)), FILTER_SANITIZE_STRING);
								}
								$current_url =  "/".$_SERVER['REQUEST_URI'];
								$lang_url =  removeParam($current_url, "lang");

								$parts = parse_url($lang_url );
								parse_str(@$parts['query'], $query);
								?>
								<ul class="m-menu__nav  m-menu__nav--submenu-arrow langs">
									<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
										<a  href="<?=substr(($query?$lang_url."&lang=".$this->session->lang:$lang_url."?lang=".$this->session->lang),1);?>" class="m-menu__link m-menu__toggle">
											<span class="m-menu__link-text">
												<img src="/img/langs/<?=$lang_array[$key]["thumb"];?>" class="m-menu__link-ico"/> <?=$lang_array[$key]["name"];?>
											</span>
											<i class="m-menu__hor-arrow la la-angle-down"></i>
											<i class="m-menu__ver-arrow la la-angle-right"></i>
										</a>
										<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
											<span class="m-menu__arrow m-menu__arrow--adjust"></span>
											<ul class="m-menu__subnav">
												<?php foreach ($langs as $lang) {
													if($this->session->lang!=$lang->lang_id)
													{
														echo '<li class="m-menu__item "  aria-haspopup="true">
															<a  href="'.substr(($query?$lang_url."&lang=".$lang->lang_id:$lang_url."?lang=".$lang->lang_id), 1).'" class="m-menu__link ">
																<span class="m-menu__link-text">
																	<img src="/img/langs/'.$lang->thumb.'" class="m-menu__link-ico"/> '.$lang->name.'
																</span>
															</a>
														</li>';
													}
												};?>

											</ul>
										</div>
									</li>

								</ul>
							</div>
							<!-- END: Horizontal Menu -->								<!-- BEGIN: Topbar -->
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
								<div class="m-stack__item m-topbar__nav-wrapper">
									<ul class="m-topbar__nav m-nav m-nav--inline">
										<li class="
	m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light"
	m-dropdown-toggle="click" id="m_quicksearch" m-quicksearch-mode="dropdown" m-dropdown-persistent="1">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-nav__link-icon">
													<i class="flaticon-search-1"></i>
												</span>
											</a>
											<div class="m-dropdown__wrapper">
												<span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
												<div class="m-dropdown__inner ">
													<div class="m-dropdown__header">
														<form  class="m-list-search__form">
															<div class="m-list-search__form-wrapper">
																<span class="m-list-search__form-input-wrapper">
																	<input id="m_quicksearch_input" autocomplete="off" type="text" name="q" class="m-list-search__form-input" value="" placeholder="Search...">
																</span>
																<span class="m-list-search__form-icon-close" id="m_quicksearch_close">
																	<i class="la la-remove"></i>
																</span>
															</div>
														</form>
													</div>
													<div class="m-dropdown__body">
														<div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-height="300" data-mobile-height="200">
															<div class="m-dropdown__content"></div>
														</div>
													</div>
												</div>
											</div>
										</li>

										<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img src="/img/profiles/small/<?=$this->session->thumb;?>" class="m--img-rounded m--marginless" alt=""/>
																</span>
																<span class="m-topbar__username m--hide">
																	Nick
																</span>
															</a>
															<div class="m-dropdown__wrapper">
																<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
																<div class="m-dropdown__inner">
																	<div class="m-dropdown__header m--align-center" style="background: url(assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
																		<div class="m-card-user m-card-user--skin-dark">
																			<div class="m-card-user__pic">
																				<img src="/img/profiles/small/<?=$this->session->thumb;?>" class="m--img-rounded m--marginless" alt=""/>
																							</div>
																							<div class="m-card-user__details">
																								<span class="m-card-user__name m--font-weight-500">
																									<?=$this->session->full_name;?>
																								</span>
																								<a href="" class="m-card-user__email m--font-weight-300 m-link">
																									<?=$this->session->email;?>
																								</a>
																							</div>
																						</div>
																					</div>
																					<div class="m-dropdown__body">
																						<div class="m-dropdown__content">
																							<ul class="m-nav m-nav--skin-light">
																								<li class="m-nav__section m--hide">
																									<span class="m-nav__section-text">
																										Section
																									</span>
																								</li>
																								<li class="m-nav__item">
																									<a href="header/profile.html" class="m-nav__link">
																										<i class="m-nav__link-icon flaticon-profile-1"></i>
																										<span class="m-nav__link-title">
																											<span class="m-nav__link-wrap">
																												<span class="m-nav__link-text">
																													My Profile
																												</span>
																											</span>
																										</span>
																									</a>
																								</li>
																								<li class="m-nav__item">
																									<a href="" class="m-nav__link">
																										<i class="m-nav__link-icon flaticon-info"></i>
																										<span class="m-nav__link-text">
																											FAQ
																										</span>
																									</a>
																								</li>
																								<li class="m-nav__item">
																									<a href="header/profile.html" class="m-nav__link">
																										<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																										<span class="m-nav__link-text">
																											Support
																										</span>
																									</a>
																								</li>
																								<li class="m-nav__separator m-nav__separator--fit"></li>
																								<li class="m-nav__item">
																									<a href="/auth/logout/" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
																										Logout
																									</a>
																								</li>
																							</ul>
																						</div>
																					</div>
																				</div>
																			</div>
																		</li>
																		<!-- <li id="m_quick_sidebar_toggle" class="m-nav__item">
																			<a href="#" class="m-nav__link m-dropdown__toggle">
																				<span class="m-nav__link-icon">
																					<i class="flaticon-grid-menu"></i>
																				</span>
																			</a>
																		</li> -->
																	</ul>
																</div>
															</div>
															<!-- END: Topbar -->
														</div>
													</div>
												</div>
											</header>
											<span style="display: none;" id="language2"><?=$this->langs->language; ?></span>
											<!-- END: Header -->
