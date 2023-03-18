<div class="alert alert-success" style="display: none;">Your review has been sent! it will be added once it's approved</div>
<div class="alert alert-danger" style="display: none;">Something went wrong! please try again</div>

<div id="frm-container" class="tu-tabswrapper">
    <div class="tu-boxtitle">
        <h4>@lang('app.add_review')</h4>
    </div>
    <form class="tu-themeform" id="frm_review" method="post" action="{{route('review.add')}}">
        <fieldset>
            <div class="tu-themeform__wrap">
                <div class="form-group-wrap">
                    <div class="form-group">
                        <div class="tu-reviews">

                            <div class="tu-listing-location tu-ratingstars">
                                @lang('app.time')
                                
                                <input type="hidden" id="rating_time" name="rating_time" value="5" />
                                <div>
                                    <i class="fa fa-star tu-coloryellow rating rating-time" data-change="rating_time" data-value="1"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-time" data-change="rating_time" data-value="2"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-time" data-change="rating_time" data-value="3"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-time" data-change="rating_time" data-value="4"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-time" data-change="rating_time" data-value="5"></i>
                                </div>
                            </div>

                            <div class="tu-listing-location tu-ratingstars">
                                @lang('app.quality')
                                <input type="hidden" id="rating_quality" name="rating_quality" value="5" />   
                                <div>
                                    <i class="fa fa-star tu-coloryellow rating rating-quality" data-change="rating_quality" data-value="1"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-quality" data-change="rating_quality" data-value="2"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-quality" data-change="rating_quality" data-value="3"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-quality" data-change="rating_quality" data-value="4"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-quality" data-change="rating_quality" data-value="5"></i>
                                </div>
                            </div>

                            <div class="tu-listing-location tu-ratingstars">
                                @lang('app.easy_to_get') 
                                <input type="hidden" id="rating_easy" name="rating_easy" value="5" />  
                                <div>
                                    <i class="fa fa-star tu-coloryellow rating rating-easy" data-change="rating_easy" data-value="1"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-easy" data-change="rating_easy" data-value="2"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-easy" data-change="rating_easy" data-value="3"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-easy" data-change="rating_easy" data-value="4"></i>
                                    <i class="fa fa-star tu-coloryellow rating rating-easy" data-change="rating_easy" data-value="5"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group tu-message-text">
                        <label class="tu-label">@lang('app.review')</label>
                        <div class="tu-placeholderholder">
                            <textarea class="form-control tu-textarea" id="tu-reviews-content" name="review" required="" placeholder="Enter description" maxlength="500"></textarea>
                            <div class="tu-placeholder">
                                <span>@lang('app.description')</span>
                            </div>
                        </div>
                    </div>

                    @csrf
                    <input type="hidden" name="user_id" value="{{$user_id}}" />

                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.rating').click(function () {
                $(this).prevAll().removeClass('tu-colororange tu-coloryellow').addClass('tu-coloryellow');
                $(this).nextAll().removeClass('tu-colororange tu-coloryellow').addClass('tu-colororange');
                $(this).removeClass('tu-colororange tu-coloryellow').addClass('tu-coloryellow');
                const txtName = $(this).data('change')
                const value = $(this).data('value');
                $('#'+txtName).val(value)
            })

            $('#frm_review').submit(function (e) {
                e.preventDefault();

                var form = $(this);
                var actionUrl = form.attr('action');

                $('.alert').hide();

                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        if(data.success == '1') {
                            $('.alert-success').show();
                            $('#frm-container').hide();
                        } else {
                            $('.alert-danger').show();
                        }
                    }
                });
            })
        })
    </script>
@endpush