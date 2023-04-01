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
            <h2>{{__('app.welcome')}}</h2>
            <h3>@lang('app.register_caption')</h3>
        </div>
        
        
        
        <form action="{{route('contact_func')}}" method="post" class="tu-themeform tu-login-form">
            <fieldset>
                <div class="tu-themeform__wrap">
                    <div class="form-group-wrap" style="margin: auto;margin-top: 40px;">

                        @foreach ($errors->all() as $error)
                        <div class="form-group">
                            <div class="alert alert-danger" style="width: 100%;">{{$error}}</div>
                        </div>
                        @endforeach

                        @if (@$error)
                        <div class="form-group">
                            <div class="alert alert-danger" style="width: 100%;">{{$error}}</div>
                        </div>
                        @endif

                        @if (@$success)
                        <div class="form-group">
                            <div class="alert alert-success" style="width: 100%;">{{$message}}</div>
                        </div>
                        @endif
                        
                        <div class="form-group">
                            <div class="tu-placeholderholder">
                                <input name="name" type="text" class="form-control" required="" placeholder="Name" value="">
                                <div class="tu-placeholder">
                                    <span>@lang('app.full_name')</span>
                                    <em>*</em>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="tu-placeholderholder">
                                <input name="email" type="text" class="form-control" required="" placeholder="Email address" value="">
                                <div class="tu-placeholder">
                                    <span>@lang('app.email')</span>
                                    <em>*</em>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="tu-placeholderholder">
                                <textarea name="message"  class="form-control" required="" placeholder="Your Message" value=""></textarea>
                                <div class="tu-placeholder">
                                    <span>@lang('app.email')</span>
                                    <em>*</em>
                                </div>
                            </div>
                        </div>

                        
                        @csrf
                        <div class="form-group">
                            <button class="tu-primbtn-lg" style="width: 100%"><span>@lang('app.send')</span></button>
                        </div>

                    </div>
                </div>
            </fieldset>
        </form>

    </div>
    
</div>
@endsection
