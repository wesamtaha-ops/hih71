<form class="tu-themeform tu-login-form">
    <fieldset>
        <div class="tu-themeform__wrap">
            <div class="form-group-wrap" style="margin: auto">
                <p>@lang('app.mail_sent')</p>
                <div class="form-group">
                    <div class="tu-placeholderholder">
                        <input id="otp" type="text" class="form-control" required="" placeholder="OTP">
                        <div class="tu-placeholder">
                            <span>@lang('app.otp')</span>
                            <em>*</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div id="verify_err" class="alert alert-danger" style="width: 100%;display: none"></div>
                </div>
                <div class="form-group">
                    <a href="#" id="btn_verify" class="tu-primbtn-lg"><span>@lang('app.verify')</span><i class="icon icon-arrow-right"></i></a>
                </div>
                <div class="form-group">
                    <div class="tu-optioanl-or">
                        <span>@lang('or')</span>
                    </div>
                </div>
                <div class="tu-lost-password form-group">
                    <a class="btn" style="color: #fff; background-color: #03a9f4;" href="{{route('login')}}">@lang('app.login')</a>
                    <a href="{{route('forget')}}" class="tu-password-clr_light">@lang('app.lost_password')</a>
                </div>
            </div>
        </div>
    </fieldset>
</form>


@push('scripts')
<script>
    $(document).ready(function () {
        $('#btn_verify').click(function () {
            $('#verify_err').hide();
            $('#verify_err').text('');

            $.ajax( {
                url: "{{route('verify_otp')}}",
                data: {
                    otp: $('#otp').val(),
                    "_token": "{{ csrf_token() }}",
                },
                type: 'post',
                dataType: "json",
                success: function( data ) {
                    if(data.success == "1") {
                        window.location.replace("{{route('home')}}")
                    } else {
                        $('#verify_err').show()
                        $('#verify_err').text('OTP is wrong! please try again')
                    }
                },
                error: function(data) {
                    $('#verify_err').show()
                    var response = JSON.parse(data.responseText);
                    $.each( response.errors, function( key, value) {
                        $('#verify_err').append(value + '<br />')
                    });
                }
            });
            return false;
        });
    });
</script>
@endpush