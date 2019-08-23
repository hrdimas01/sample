<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
	<meta charset="utf-8" />
	<title>{{(empty($title)? '' : $title.' | ').app_info('name')}}</title>
	<meta name="csrf-token" content="{{csrf_token()}}" />
	<meta name="description" content="{{app_info('description')}}" />
	<meta name="keywords" content="{{app_info('client.fullname').' '.app_info('client.city')}}" />
	<meta name="author" content="{{app_info('vendor.company')}}" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
	</script>
	<!--end::Web font -->
	<!--begin::Base Styles -->
	<link href="{{aset_tema('', 'metronic-5.5.5')}}vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
	<link href="{{aset_tema('', 'metronic-5.5.5')}}demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Base Styles -->
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url({{aset_tema('', 'metronic-5.5.5')}}app/media/img//bg/bg-2.jpg);">
			<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
				<div class="m-login__container">
					<div class="m-login__logo">
						<a href="#">
							<img src="{{aset_extends('img/laravel-5.5-120.png')}}" style="width: 90%">
						</a>
					</div>
					<div class="m-login__signin">
						<div class="m-login__head">
							<h3 class="m-login__title">
								Sign In To Admin
							</h3>
						</div>
						<form class="m-login__form m-form" action="">
							<input type="hidden" name="url_source" id="url_source" value="{{$source}}">
							<div class="form-group m-form__group">
								<input class="form-control m-input form-submit"   type="text" placeholder="Username" name="username" id="username" autocomplete="off">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input m-login__form-input--last form-submit" type="password" id="password" placeholder="Password" name="password">
							</div>
							<div class="row m-login__form-sub">
								<div class="col m--align-left m-login__form-left">
									<label class="m-checkbox  m-checkbox--light">
										<input type="checkbox" name="remember">
										Remember me
										<span></span>
									</label>
								</div>
								<div class="col m--align-right m-login__form-right">
									<a href="javascript:;" id="m_login_forget_password" class="m-link">
										Forget Password ?
									</a>
								</div>
							</div>
							<div class="m-login__form-action">
								<button type="button" id="btn_login" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn ladda-button" data-style="zoom-in">
									Sign In
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
	<script src="{{aset_tema('', 'metronic-5.5.5')}}vendors/base/vendors.bundle.js" type="text/javascript"></script>
	<script src="{{aset_tema('', 'metronic-5.5.5')}}demo/default/base/scripts.bundle.js" type="text/javascript"></script>
	<!--end::Base Scripts -->   
	<!--begin::Page Snippets -->
	<!-- <script src="{{aset_tema('', 'metronic-5.5.5')}}snippets/pages/user/login.js" type="text/javascript"></script> -->
	<!--end::Page Snippets -->

	<!-- sweetalert -->
	<link rel="stylesheet" href="{{aset_extends('plugins/sweet-alert/sweetalert.css')}}">
	<script src="{{aset_extends('plugins/sweet-alert/sweetalert.min.js')}}"></script>
	<!-- ladda -->
	<link rel="stylesheet" href="{{aset_extends('plugins/ladda/dist/ladda-themeless.min.css')}}">
	<script src="{{aset_extends('plugins/ladda/dist/spin.min.js')}}"></script>
	<script src="{{aset_extends('plugins/ladda/dist/ladda.min.js')}}"></script>
	<!-- loader -->
	<link rel="stylesheet" href="{{aset_extends('css/pre-loader.css')}}">
	<!-- page -->
	<script src="{{aset_extends('js/page/login.js')}}"></script>

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
