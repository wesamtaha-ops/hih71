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
            <h2>Dont worry!</h2>
            <h3>We’ll send you the reset link</h3>
        </div>
        <form class="tu-themeform tu-login-form">
            <fieldset>
                <div class="tu-themeform__wrap">
                    <div class="form-group-wrap">
                        <div class="form-group">
                            <div class="tu-placeholderholder">
                                <input type="email" class="form-control" required="" placeholder="Enter email address">
                                <div class="tu-placeholder">
                                    <span>Enter email address</span>
                                    <em>*</em>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="login.html" class="tu-primbtn-lg"><span>Send reset link</span><i class="icon icon-arrow-right"></i></a>
                        </div>
                        <div class="tu-lost-password form-group">
                            <a href="/login">Login now</a>
                            <a href="/register">Join us today</a>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection