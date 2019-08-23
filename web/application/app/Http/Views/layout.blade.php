<?php
$sesi = Auth::user();
?>
<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
	<meta charset="utf-8" />
	<title>{{(empty($title)? '' : $title.' | ').app_info('name')}}</title>
	<meta name="csrf-token" content="{{csrf_token()}}" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="{{app_info('description')}}" />
	<meta name="author" content="{{app_info('vendor.company')}}" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!--begin::Web font -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});

		var baseUrl = "{{url('/')}}/";
		var idUser = "{{$sesi->usr_id}}";
		var roleUser = "{{$sesi->usr_role}}";
		var date = new Date();
	</script>
	<!--end::Web font -->

	<!--begin::Base Styles -->  
	<!--begin::Page Vendors -->
	<link href="{{aset_tema('', 'metronic-5.5.5')}}vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors -->
	<link href="{{aset_tema('', 'metronic-5.5.5')}}vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
	<link href="{{aset_tema('', 'metronic-5.5.5')}}demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Base Styles -->


	<!-- JAVASCRIPT -->
	<!--begin::Base Scripts -->
	<script src="{{aset_tema('', 'metronic-5.5.5')}}vendors/base/vendors.bundle.js" type="text/javascript"></script>
	<script src="{{aset_tema('', 'metronic-5.5.5')}}demo/default/base/scripts.bundle.js" type="text/javascript"></script>
	<!--end::Base Scripts -->   
	<!--begin::Page Vendors -->
	<script src="{{aset_tema('', 'metronic-5.5.5')}}vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
	<!--end::Page Vendors -->  
	<!--begin::Page Snippets -->
	<script src="{{aset_tema('', 'metronic-5.5.5')}}app/js/dashboard.js" type="text/javascript"></script>
	<!--end::Page Snippets -->

	<!-- datatables -->
	<link href="{{aset_extends('plugins/custom/datatables')}}/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<link href="{{aset_extends('plugins/custom/datatables')}}/style.custom.css" rel="stylesheet" type="text/css" />
	<script src="{{aset_extends('plugins/custom/datatables')}}/datatables.bundle.js" type="text/javascript"></script>
	<!-- ladda -->
	<link rel="stylesheet" href="{{aset_extends('plugins/ladda/dist/ladda-themeless.min.css')}}">
	<script src="{{aset_extends('plugins/ladda/dist/spin.min.js')}}"></script>
	<script src="{{aset_extends('plugins/ladda/dist/ladda.min.js')}}"></script>
	<!-- helper -->
	<link rel="stylesheet" href="{{aset_extends('css/general.css')}}">
	<link rel="stylesheet" href="{{aset_extends('css/pre-loader.css')}}">
	<script type="text/javascript" src="{{aset_extends('js/helper.bundle.js')}}"></script>
	<script type="text/javascript" src="{{aset_extends('js/helper.app.js')}}"></script>
	<script type="text/javascript">
		Dropzone.autoDiscover=false;
	</script>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<!-- BEGIN: Header -->
		<header class="m-grid__item    m-header "  data-minimize-offset="200" data-minimize-mobile-offset="200" >
			<div class="m-container m-container--fluid m-container--full-height">
				<div class="m-stack m-stack--ver m-stack--desktop">
					<!-- BEGIN: Brand -->
					<div class="m-stack__item m-brand  m-brand--skin-dark ">
						<div class="m-stack m-stack--ver m-stack--general">
							<div class="m-stack__item m-stack__item--middle m-brand__logo">
								<a href="{{route('home')}}" class="m-brand__logo-wrapper">
									<img alt="" style="width: 130px;" src="{{aset_extends('img/laravel-5.5-120.png')}}"/>
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
						<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark "  >
							<h3 style="margin-top: 20px;margin-left: 5px;" >{{app_info('name')}}</h3>
						</div>
						<!-- END: Horizontal Menu -->
						<!-- BEGIN: Topbar -->
						<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
							<div class="m-stack__item m-topbar__nav-wrapper">
								<ul class="m-topbar__nav m-nav m-nav--inline">
									<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
										<a href="#" class="m-nav__link m-dropdown__toggle">
											<span class="m-topbar__userpic">
												<img src="{{aset_tema('', 'metronic-5.5.5')}}app/media/img/users/user4.jpg" class="m--img-rounded m--marginless m--img-centered" alt=""/>
											</span>
											<span class="m-topbar__username m--hide">
												Nick
											</span>
										</a>
										<div class="m-dropdown__wrapper">
											<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
											<div class="m-dropdown__inner">
												<div class="m-dropdown__header m--align-center" style="background: url({{aset_tema('', 'metronic-5.5.5')}}app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
													<div class="m-card-user m-card-user--skin-dark">
														<div class="m-card-user__pic">
															<img src="{{aset_tema('', 'metronic-5.5.5')}}app/media/img/users/user4.jpg" class="m--img-rounded m--marginless" alt=""/>
														</div>
														<div class="m-card-user__details">
															<span class="m-card-user__name m--font-weight-500">
																{{$sesi->usr_name}}
															</span>
															<a href="" class="m-card-user__email m--font-weight-300 m-link">
																{{$sesi->usr_email}}
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
																<a href="javascript:;" onclick="modal_password()" class="m-nav__link">
																	<i class="m-nav__link-icon flaticon-lock"></i>
																	<span class="m-nav__link-text">
																		Ubah Password
																	</span>
																</a>
															</li>
															<li class="m-nav__separator m-nav__separator--fit"></li>
															<li class="m-nav__item">
																<a href="{{route('logout')}}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
																	Logout
																</a>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<!-- END: Topbar -->
					</div>
				</div>
			</div>
		</header>
		<!-- END: Header -->

		<!-- begin::Body -->
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
			<!-- BEGIN: Left Aside -->
			<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
				<i class="la la-close"></i>
			</button>
			<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
				<!-- BEGIN: Aside Menu -->
				<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">
					<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
						<li id="menu-home" class="m-menu__item" aria-haspopup="true" >
							<a  href="{{route('home')}}" class="m-menu__link ">
								<i class="m-menu__link-icon flaticon-line-graph"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">
											Home
										</span>
									</span>
								</span>
							</a>
						</li>
						<li id="menu-mahasiswa" class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
							<a href="{{route('mahasiswa')}}" class="m-menu__link ">
								<i class="m-menu__link-icon flaticon-users"></i>
								<span class="m-menu__link-text">
									Mahasiswa
								</span>
							</a>
						</li>
					</ul>
				</div>
				<!-- END: Aside Menu -->
			</div>
			<!-- END: Left Aside -->
			
			@yield('content')
		</div>
		<!-- end:: Body -->
		<!-- begin::Footer -->
		<footer class="m-grid__item		m-footer ">
			<div class="m-container m-container--fluid m-container--full-height m-page__container">
				<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
					<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
						<span class="m-footer__copyright">
							2017 &copy; Metronic theme by
							<a href="https://keenthemes.com" class="m-link">
								Keenthemes
							</a>
						</span>
					</div>
					<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
						<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
							<li class="m-nav__item">
								<a href="#" class="m-nav__link">
									<span class="m-nav__link-text">
										About
									</span>
								</a>
							</li>
							<li class="m-nav__item">
								<a href="#"  class="m-nav__link">
									<span class="m-nav__link-text">
										Privacy
									</span>
								</a>
							</li>
							<li class="m-nav__item">
								<a href="#" class="m-nav__link">
									<span class="m-nav__link-text">
										T&C
									</span>
								</a>
							</li>
							<li class="m-nav__item">
								<a href="#" class="m-nav__link">
									<span class="m-nav__link-text">
										Purchase
									</span>
								</a>
							</li>
							<li class="m-nav__item m-nav__item">
								<a href="#" class="m-nav__link" data-toggle="m-tooltip" title="Support Center" data-placement="left">
									<i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
		<!-- end::Footer -->
	</div>
	<!-- end:: Page -->		    
	<!-- begin::Scroll Top -->
	<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
		<i class="la la-arrow-up"></i>
	</div>
	<!-- end::Scroll Top -->

	<div class="se-pre-con" style="display: none;"></div>

	<div class="modal fade" id="modal_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Form Ubah Password
					</h5>
					<button type="button" class="close btn_close_modal" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
				<div class="modal-body" style="padding-top: 0;">
					<form id="formPassword" action="" method="post" onsubmit="return false;">
						<input type="hidden" name="id_user" id="id_user" value="">
						
						<div class="form-group">
							<label class="form-control-label lbl">
								Password Lama:
							</label>
							<input type="password" class="form-control m-input input-password" id="password_lama" name="password_lama" placeholder="Masukkan password lama" autocomplete="off">
						</div>
						<div class="form-group">
							<label class="form-control-label lbl">
								Password Baru:
							</label>
							<input type="password" class="form-control m-input input-password" id="password_baru" name="password_baru" placeholder="Masukkan password baru" autocomplete="off">
						</div>
						<div class="form-group">
							<label class="form-control-label lbl">
								Konfirmasi Password Baru:
							</label>
							<input type="password" class="form-control m-input input-password" id="conf_password_baru" name="conf_password_baru" placeholder="Masukkan kembali password baru Anda" autocomplete="off">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn_close_modal" data-dismiss="modal">
						Tutup
					</button>
					<button type="button" class="btn btn-success ladda-button" data-style="zoom-in" id="btn_save_password">
						Simpan
					</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{aset_extends('js/page/password.js')}}"></script>
	<script type="text/javascript">
		<?php
		$alerts = session('alerts');

		if(!empty($alerts)){
			foreach ($alerts as $key => $value) {
				?>
				swal('<?php echo $value[2]; ?>', '<?php echo $value[1]; ?>', '<?php echo $value[0]; ?>');
				<?php
			}
		}
		?>
	</script>
	
</body>
<!-- end::Body -->
</html>
