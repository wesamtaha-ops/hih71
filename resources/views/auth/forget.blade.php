@extends('layouts.auth')

@section('content')
<div class="tu-main-login">
<div class="tu-login-left">
        <strong>
            <a href="{{route('home')}}"><img class="innerLogo" src="{{asset('images/logo.jpeg')}}" alt="images"></a>
        </strong>
        <figure>
            <img src="https://amentotech.com/htmls/tuturn//images/login/img-01.png'" alt="images">
        </figure>
        <div class="tu-login-left_title">
            <h2>@lang('app.register_white_description')</h2>
            <span>@lang('app.register_yellow_description')</span>
        </div>
    </div>
    <div class="tu-login-right">
        <div class="tu-login-right_title">
            @if(@$success)
            <div class="alert alert-success" role="alert">
                @lang('app.success_reset_password')
            </div>
            @endif
            <h2>Dont worry!</h2>
            <h3>We’ll send you the reset link</h3>
        </div>
        <form class="tu-themeform tu-login-form" action="{{route('forget_func')}}" method="post">
            @csrf
            <fieldset>
                <div class="tu-themeform__wrap">
                    <div class="form-group-wrap">
                        <div class="form-group">
                            <div class="tu-placeholderholder">
                                <input type="email" name="email" class="form-control" required="" placeholder="Enter email address">
                                <div class="tu-placeholder">
                                    <span>Enter email address</span>
                                    <em>*</em>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="tu-primbtn-lg"><span>Send reset link</span><i class="icon icon-arrow-right"></i></button>
                        </div>
                       
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection