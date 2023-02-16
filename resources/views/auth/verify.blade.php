@extends('layouts.auth')

@section('content')
<div class="tu-main-login">
    <div class="tu-login-left">
        <strong>
            <a href="index.html"><img src="{{asset('images/logo.jpeg')}}" alt="images"></a>
        </strong>
        <figure>
            <img src="{{asset('assets/images/login/img-01.png')}}" alt="images">
        </figure>
        <div class="tu-login-left_title">
            <h2>Yes! we’re making progress</h2>
            <span>every minute & every second</span>
        </div>
    </div>
    <div class="tu-login-right">
        <div class="tu-login-right_title">
            <h2>Welcome!</h2>
            <h3>We know you'll come back</h3>
        </div>
        @include('auth.components.verify_form')
    </div>
</div>
@endsection
