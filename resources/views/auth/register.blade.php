@extends('layouts.auth')

@section('content')
    <div class="tu-main-login">
        <div class="tu-login-left">
            <strong>
                <a href="{{route('home')}}"><img class="innerLogo" src="{{asset('images/logo.jpeg')}}" alt="images"></a>
            </strong>
            <figure>
                <img src="https://amentotech.com/htmls/tuturn/images/login/img-01.png" alt="images">
            </figure>
            <div class="tu-login-left_title">
                <h2>{{__('app.register_white_description')}}</h2>
                <span>{{__('app.register_yellow_description')}}</span>
            </div>
        </div>
        <div class="tu-login-right">
            <div class="tu-login-right_title">
                <h2>{{__('app.welcome')}} @lang('app.' . $user_type)!</h2>
                <h3>{{__('app.register_caption')}}</h3>
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
	