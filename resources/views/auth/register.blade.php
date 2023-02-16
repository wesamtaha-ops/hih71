@extends('layouts.auth')

@section('content')
    <div class="tu-main-login">
        <div class="tu-login-left">
            <strong>
                <a href="index.html"><img class="innerLogo" src="{{asset('images/logo.jpeg')}}" alt="images"></a>
            </strong>
            <figure>
                <img src="https://amentotech.com/htmls/tuturn/images/login/img-01.png" alt="images">
            </figure>
            <div class="tu-login-left_title">
                <h2>Yes! we’re making progress</h2>
                <span>every minute & every second</span>
            </div>
        </div>
        <div class="tu-login-right">
            <div class="tu-login-right_title">
                <h2>Welcome {{$user_type}}!</h2>
                <h3>It’s really nice to see you</h3>
            </div>

            @include('auth.components.register_tabs',['data' => [
                    [
                        'title' => 'Registration',
                        'content' => $register_form
                    ],
                    [
                        'title' => 'Verify',
                        'content' => $verify_form
                    ]
                ]
            ])
        </div>
    </div>
@endsection
	