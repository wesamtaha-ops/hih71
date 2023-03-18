<div class="tu-boxarea">
    <div class="tu-boxsm">
        <div class="tu-boxsmtitle"> 
            <h4>@lang('app.description')</h4>
        </div>
    </div>
    <div class="tu-box">
        <form class="tu-themeform tu-dhbform">
            <fieldset>
                <div class="tu-themeform__wrap">
                    <div class="form-group-wrap">
                        <label>Youtube Video</label>

                        @include('components.standard.inputtext', ['id' => 'video', 'name' => 'video', 'placeholder' => __('app.youtube_video'), 'value' => @$teacher_info->video])

                        @include('components.standard.inputtext', ['id' => 'heading_en', 'name' => 'heading_en', 'placeholder' => __('app.headline_en'), 'value' => @$teacher_info->heading_en])
                        @include('components.standard.textarea', ['id' => 'description_en', 'name' => 'description_en', 'placeholder' => __('app.description_en'), 'value' => @$teacher_info->description_en])

                        @include('components.standard.inputtext', ['id' => 'heading_ar', 'name' => 'heading_ar', 'placeholder' => __('app.headline_ar'), 'value' => @$teacher_info->heading_ar])
                        @include('components.standard.textarea', ['id' => 'description_ar', 'name' => 'description_ar', 'placeholder' => __('app.description_ar'), 'value' => @$teacher_info->description_ar])

                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>