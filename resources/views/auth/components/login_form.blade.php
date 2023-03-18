<form action="{{route('login_func')}}" method="post" class="tu-themeform tu-login-form">
    <fieldset>
        <div class="tu-themeform__wrap">
            <div class="form-group-wrap" style="margin: auto;margin-top: 40px;">
                <div class="form-group">
                    <div class="tu-placeholderholder">
                        <input name="email" type="text" class="form-control" required="" placeholder="Email" value="">
                        <div class="tu-placeholder">
                            <span>@lang('app.email')</span>
                            <em>*</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="tu-placeholderholder">
                        <input name="password" type="password" class="form-control" required="" placeholder="Email address" value="">
                        <div class="tu-placeholder">
                            <span>@lang('app.password')</span>
                            <em>*</em>
                        </div>
                    </div>
                </div>

                @if(@$error)
                <div class="form-group">
                    <div class="alert alert-danger" style="width: 100%;">{{$error}}</div>
                </div>
                @endif
                
                @csrf
                <div class="form-group">
                    <button class="tu-primbtn-lg" style="width: 100%"><span>@lang('app.login')</span><i class="icon icon-arrow-right"></i></button>
                </div>

                <div class="tu-lost-password form-group">
                    <a class="btn" style="color: #fff; background-color: #03a9f4;" href="{{route('register')}}" > @lang('app.dont_have_account') </a>

                    <a href="{{route('forget')}}" class="tu-password-clr_light">@lang('app.lost_password')</a>
                </div>
            </div>
        </div>
    </fieldset>
</form>