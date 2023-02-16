<form class="tu-themeform tu-login-form">
    <fieldset>
        <div class="tu-themeform__wrap">
            <div class="form-group-wrap" style="margin: auto">
                <div class="form-group">
                    <div class="tu-placeholderholder">
                        <input id="full_name" type="text" class="form-control" required="" placeholder="Full Name">
                        <div class="tu-placeholder">
                            <span>Full name</span>
                            <em>*</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="tu-placeholderholder">
                        <input id="email" type="email" class="form-control" required="" placeholder="Email address">
                        <div class="tu-placeholder">
                            <span>Your email address</span>
                            <em>*</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="tu-placeholderholder">
                        <input id="password" type="password" class="form-control" required="" placeholder="password">
                        <div class="tu-placeholder">
                            <span>Enter password</span>
                            <em>*</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="tu-placeholderholder">
                        <input id="phone" type="text" class="form-control" required="" placeholder="phone">
                        <div class="tu-placeholder">
                            <span>Enter Phone</span>
                            <em>*</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div id="register_err" class="alert alert-danger" style="width: 100%;display: none"></div>
                </div>
                <div class="form-group">
                    <a href="#" class="tu-primbtn-lg" id="send_otp" ><span>Send OTP</span><i class="icon icon-arrow-right"></i></a>
                </div>
                <div class="form-group">
                    <div class="tu-check tu-signup-check">
                        <input type="checkbox" id="expcheck2" name="expcheck">
                        <label for="expcheck2"><span>I have read and agree to all <a href="javascript:void(0);">Terms &amp; conditions</a></span></label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="tu-optioanl-or">
                        <span>OR</span>
                    </div>
                </div>
                <div class="tu-lost-password form-group">
                    <a href="/login">Login now</a>
                    <a href="/forget" class="tu-password-clr_light">Lost password?</a>
                </div>
            </div>
        </div>
    </fieldset>
</form>


@push('scripts')
<script>
    $(document).ready(function () {
        $('#send_otp').click(function () {
            $('#register_err').hide()
            $('#register_err').text('')
            
            $.ajax( {
                url: "{{route('register_func')}}",
                data: {
                    name: $('#full_name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    password: $('#password').val(),
                    type: "{{$user_type}}",
                    "_token": "{{ csrf_token() }}",
                },
                type: 'post',
                dataType: "json",
                success: function( data ) {
                    $('.sw-btn-next').click();
                },
                error: function(data) {
                    $('#register_err').show()
                    
                    var response = JSON.parse(data.responseText);
                    $.each( response.errors, function( key, value) {
                        $('#register_err').append(value + '<br />')
                    });
                }
            });
            return false;
        });
    });
</script>
@endpush