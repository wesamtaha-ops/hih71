<form action="{{route('login_func')}}" method="post" class="tu-themeform tu-login-form">
    <fieldset>
        <div class="tu-themeform__wrap">
            <div class="form-group-wrap" style="margin: auto;margin-top: 40px;">
                <div class="form-group">
                    <div class="tu-placeholderholder">
                        <input name="email" type="text" class="form-control" required="" placeholder="Email" value="">
                        <div class="tu-placeholder">
                            <span>Email</span>
                            <em>*</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="tu-placeholderholder">
                        <input name="password" type="password" class="form-control" required="" placeholder="Email address" value="">
                        <div class="tu-placeholder">
                            <span>Your password</span>
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
                    <button class="tu-primbtn-lg" style="width: 100%"><span>Login now</span><i class="icon icon-arrow-right"></i></button>
                </div>

                <div class="tu-lost-password form-group">
                    <a href="{{route('register')}}">Join us today</a>
                    <a href="{{route('forget')}}" class="tu-password-clr_light">Lost password?</a>
                </div>
            </div>
        </div>
    </fieldset>
</form>