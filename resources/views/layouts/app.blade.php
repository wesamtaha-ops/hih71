

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
	<title>HIH71 - Human Intelligence Hub</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="icon" href="images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/feather.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/fontawesome/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/splide.min.css')}}">	
    <link rel="stylesheet" href="{{asset('assets/css/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/venobox.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery.mCustomScrollbar.min.css')}}">
    <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Highly-Customizable-jQuery-Toast-Message-Plugin-Toastr/build/toastr.css">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    @yield('styles')
</head>
<body dir="{{app()->currentLocale() == 'ar' ? 'rtl' : 'ltr'}}">
    <!-- Preloader Start -->
    <div class="tu-preloader">
        <div class="tu-preloader_holder">
            <img src="{{asset('assets/images/favicon.png')}}" alt="laoder img">
            <div class="tu-loader"></div>
        </div>
    </div>
    <!-- Preloader End -->
	<!-- HEADER START -->
    <header class="tu-header tu-headerv2" style="background: @if(\Request::route()->getName() == 'home') transparent @else #0F012E @endif" >
        <nav class="navbar navbar-expand-xl tu-navbar tu-navbarvtwo">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('https://votly.io/media/400/97b0pbl01fi7npvttoz59xl0279v98hwlwbbckqbbk7em3zuhz.webp')}}" alt="Logo"></a>
                <button class="tu-menu"  aria-label="Main Menu" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse">
                    <i class="icon icon-menu"></i>
                </button>
                <div class="collapse navbar-collapse tu-themenav" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="search-listing.html">
                                {{__('app.contact')}}
                            </a>
                        </li>
                        <li class="menu-item-has-children nav-item">
                            <a href="javascript:void(0);">{{ __('app.current_lang') }} </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('locale.update', ['locale' => 'en'])}}">English</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('locale.update', ['locale' => 'ar'])}}">العربية</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children nav-item">
                            <a href="javascript:void(0);">
                            {{session()->get('current_currency')['name']}}
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    @foreach(session()->get('currencies') as $currency)
                                    <a class="nav-link" href="{{route('currency.update', ['currency_id' => $currency['id']])}}">{{$currency['name']}}</a>
                                    @endforeach
                                </li>
                            </ul>
                        </li>
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('login')}}">{{ __('app.login') }}</a>
                        </li>
                        <li>
                            <a class="nav-link btn" style="color:#fff; padding: 10px; margin-left: 15px; margin-top:5px" href="{{route('register', ['user_type' => 'student'] )}}">{{__('app.register')}}</a>
                        </li>
                        <li>
                            <a class="nav-link btn" style="color:#fff; padding: 10px; margin-left: 15px; margin-top:5px;    background: #03a9f4; " href="{{route('register', ['user_type' => 'teacher'] )}}">{{__('app.become_tutor')}}</a>
                        </li>
                        @endguest
                    </ul>
                </div>
                @auth
                <ul class="nav-item tu-afterlogin">
                    <!-- <li>
                        <a class="nav-link" href="{{ route('message.read', ['id' => 'new']) }}"><span class="icon icon-message-square"></span></a>
                    </li> -->
                    <li class="menu-item-has-children">
                        <strong><a class="nav-link" href="javascript:void(0);"><img src="{{\Auth::user()->image ? asset('images/' . \Auth::user()->image) : 'https://votly.io/media/400/welnnxojxk3w0hpc7gq4tcriarfzvxsaoc7rgdi78ml4j0jbqk.webp'}}" style="width: 30px; height: 30px;" alt="image-description"></a></strong>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{route('profile')}}"><i class="icon icon-user"></i>Profile</a>
                            </li>
                            <li>
                                <a href="{{route('wallet')}}"><i class="icon icon-user"></i>Wallet</a>
                            </li>
                            <li>
                                <a href="{{route('lessons')}}"><i class="icon icon-phone"></i>Lessons</a>
                            </li>
                            @if(isTeacher())
                            <li>
                                <a href="{{route('packages')}}"><i class="icon icon-user"></i>Packages</a>
                            </li>
                            @endif
                            <li>
                                <a href="{{route('password.update')}}"><i class="icon icon-book"></i>Change Password</a>
                            </li>
                            <li>
                                <a href="{{route('logout')}}"><i class="icon icon-book-open"></i>{{__('app.logout')}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endauth
            </div>
        </nav>
    </header>
	<!-- HEADER END -->
    @yield('content')
	<!-- FOOTER START -->
    <footer>
        <div class="tu-footerdark">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <strong class="tu-footerlogo">
                            <a href="{{route('home')}}"><img src="{{asset('images/logo.jpeg')}}" alt="Logo" style="width: 200px;"></a>
                        </strong>
                        <p class="tu-footerdescription">Accusamus etidio dignissimos ducimus blanditiis praesentium volupta eleniti atquete corrupti quolores etmquasa molestias epturi sinteam occaecati cupiditate non providente mikume molareshe.</p>
                        <ul class="tu-socialmedia">
                            <li class="tu-facebookv3"><a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li class="tu-twitterv3"><a href="https://twitter.com/?lang=en" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li class="tu-linkedinv3"><a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <h5 class="tu-footertitle">Feel free to share your question</h5>
                        <ul class="tu-footerlist tu-footericonlist">
                            <li><a href="tel:+6287777263549"><i class="icon icon-phone-call"></i><em>+971 5 77263549</em><span>( Mon to Sun 9am - 11pm GMT )</span></a></li>
                            <li><a href="mailto:hello@youremailid.co.uk"><i class="icon icon-mail"></i><em>info@hih71.co.uk</em></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <br /><br />
            <div class="tu-footercopyright">
                <div class="container">
                    <div class="tu-footercopyright_content">
                        <p>© 2023 All Rights Reserved.</p>
                        <ul class="tu-footercopyright_list">
                            <li><a href="how-it-work.html">Terms of use</a></li>
                            <li><a href="how-it-work.html">Privacy policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
	<!-- FOOTER END -->
    <!-- Custom Tooltip Render Here -->
	<div class="tu-tippysm">
        <span id="tu-verifed" class="d-none">
            <span class="tu-tippytooltip">
                <span>Verified</span>
            </span>
        </span>
    </div>
    <!-- Custom Tooltip Render Here -->
	<script src="{{asset('assets/js/vendor/jquery.min.js')}}"></script>	
    <script src="{{asset('assets/js/vendor/popper-core.js')}}"></script>
	<script src="{{asset('assets/js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/appear.js')}}"></script>
    <script src="{{asset('assets/js/vendor/countTo.js')}}"></script>
    <script src="{{asset('assets/js/vendor/splide.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/nouislider.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/wNumb.js')}}"></script>
    <script src="{{asset('assets/js/vendor/tippy.js')}}"></script>
    <script src="{{asset('assets/js/vendor/typed.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/particles.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/venobox.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="https://www.jqueryscript.net/demo/Highly-Customizable-jQuery-Toast-Message-Plugin-Toastr/toastr.js"></script>
	<script src="{{asset('assets/js/main.js')}}"></script>
    @stack('scripts')
</body>
</html>
