<!doctype html>
<!--[if lt IE 7]>       <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>          <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>          <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="zxx">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>BootStrap HTML5 CSS3 Theme</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="icon" href="images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/feather.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/fontawesome/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/splide.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
	<link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
	<style>
		.sw-btn-next{ display: none !important}
	</style>
</head>
<body>
	<!-- Preloader Start -->
	<div class="tu-preloader">
        <div class="tu-preloader_holder">
            <img src="{{asset('assets/images/favicon.png')}}" alt="laoder img">
            <div class="tu-loader"></div>
        </div>
    </div>
    <!-- Preloader End -->
    <!-- MAIN START -->
	<main>
        @yield('content')
	</main>
	<!-- MAIN END -->
	<script src="{{asset('assets/js/vendor/jquery.min.js')}}"></script>	
	<script src="{{asset('assets/js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/appear.js')}}"></script>
    <script src="{{asset('assets/js/vendor/countTo.js')}}"></script>
    <script src="{{asset('assets/js/vendor/splide.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/select2.min.js')}}"></script>
	<script src="{{asset('assets/js/main.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
	<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
	@stack('scripts')
</body>
</html>
