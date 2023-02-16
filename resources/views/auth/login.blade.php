@extends('layouts.auth')

@section('content')
<div class="tu-main-login">
    <div class="tu-login-left">
        <strong>
            <a href="index.html"><img class="innerLogo" src="{{asset('images/logo.jpeg')}}" alt="images"></a>
        </strong>
        <figure>
            <img src="https://amentotech.com/htmls/tuturn//images/login/img-01.png'" alt="images">
        </figure>
        <div class="tu-login-left_title">
            <h2>Yes! we’re making progress</h2>
            <span>every minute & every second</span>
        </div>
    </div>
    <div class="tu-login-right">
        <div class="tu-login-right_title">
            <h2>{{__('app.welcome')}}</h2>
            <h3>We know you'll come back</h3>
        </div>
        @include('auth.components.login_form', compact('error'))
    </div>
    
</div>
@endsection
