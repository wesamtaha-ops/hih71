<div class="tu-boxarea">
    <div class="tu-boxsm">
        <div class="tu-boxsmtitle">
            <h4>Personal details</h4>
        </div>
    </div>
    <div class="tu-box">
        <form class="tu-themeform tu-dhbform">
            <fieldset>
                <div class="tu-themeform__wrap">
                    <div class="form-group-wrap">
                        @include('components.standard.inputtext', [
                            'id' => 'full_name', 
                            'name' => 'full_name', 
                            'placeholder' => 'Full Name', 
                            'half' => 1, 
                            'required' => 1,
                            'value' => @\Auth::user()->name
                        ])

                        @include('components.standard.inputtext', [
                            'id' => 'email', 
                            'name' => 'email', 
                            'placeholder' => 'Email', 
                            'half' => 1,
                            'disabled' => 'true', 
                            'type' => 'email', 
                            'value' => @\Auth::user()->email
                        ])

                        @include('components.standard.inputtext', [
                            'id' => 'phone', 
                            'name' => 'phone', 
                            'placeholder' => 'Phone', 
                            'half' => 1,
                            'value' => @\Auth::user()->phone
                        ])
                        
                        @include('components.standard.select', [
                            'id' => 'gender', 
                            'name' => 'gender', 
                            'half' => 1, 
                            'placeholder' => 'Select Gender', 
                            'value' => \Auth::user()->gender, 
                            'options' => [
                                ['id' => 'male', 'name' => 'Male'],
                                ['id' => 'female', 'name' => 'Female'],
                            ]
                        ])
                        
                        @include('components.standard.inputtext', [
                            'id' => 'dob', 
                            'name' => 'dob', 
                            'placeholder' => 'Date Of Birth', 
                            'half' => 1, 
                            'type' => 'date', 
                            'value' => @\Auth::user()->birthday
                        ])

                        @if(isTeacher())
                            @if(@$currencies)
                                @include('components.standard.select', [
                                    'id' => 'currency_id', 
                                    'name' => 'currency_id', 
                                    'placeholder' => 'Select Currency', 
                                    'half' => 1, 
                                    'value' => \Auth::user()->currency_id, 
                                    'options' => $currencies, 
                                    'required' => 1
                                ])
                            @endif

                            @include('components.standard.inputtext', [
                                'id' => 'fees', 
                                'name' => 'fees', 
                                'placeholder' => 'Fees', 
                                'half' => 1, 
                                'value' => @$teacher_info->fees,
                                'required' => 1
                            ])

                            @if(@$countries)
                                @include('components.standard.select', ['id' => 'country_id', 
                                    'name' => 'country_id', 
                                    'placeholder' => 'Select Nationality', 
                                    'half' => 1, 
                                    'value' => \Auth::user()->country_id, 
                                    'options' => $countries
                                ])
                            @endif

                            <div id="languages_section" style="width: 100%">

                                @isset($teacher_info->teacher_language)
                                    @foreach(json_decode($teacher_info->teacher_language) as $info)
                                    <span class="languages_container form-group-wrap" style="width: 100%">
                                        @include('components.standard.select', [
                                            'id' => 'languages', 
                                            'half' => 1, 
                                            'name' => 'languages', 
                                            'placeholder' => 'Select Languages', 
                                            'options' => $languages, 
                                            'value' => $info->language
                                        ])
                                        @include('components.standard.select', [
                                            'id' => 'languages_levels', 
                                            'half' => 1, 
                                            'name' => 'languages_levels', 
                                            'placeholder' => 'Select Levels', 
                                            'options' => $languages_levels, 
                                            'value' => $info->level
                                        ])
                                        </span>

                                    @endforeach
                                @endisset

                                <div class="languages_container form-group-wrap" style="width: 100%">
                                    @include('components.standard.select', [
                                        'id' => 'languages', 
                                        'half' => 1, 
                                        'name' => 'languages', 
                                        'placeholder' => 'Select Languages', 
                                        'options' => $languages
                                    ])

                                    @include('components.standard.select', [
                                        'id' => 'languages_levels', 
                                        'half' => 1, 
                                        'name' => 'languages_levels', 
                                        'placeholder' => 'Select Levels', 
                                        'options' => $languages_levels
                                    ])
                                </div>
                            </div>

                            <a href="#" id="btn-add-language" class="form-group">
                                <i class="fa fa-plus-circle" style="margin-right: 10px;"></i> Add another language
                            </a>
                        
                        @endif
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>



@push('scripts')
<script>
    $(document).ready(function () {
        //  Add another language
        const langauge_container = $('#languages_section').find('.languages_container').last().prop('outerHTML');
        $('#btn-add-language').click(function () {
            $('#languages_section').append(langauge_container);
            // $('.selectv').select2()
            return false;
        })
    });

    $('#btn_submit_profile').click(function() {

        let languages = [];
        let levels = [];

        $('[name=languages]').each(function(idx, el){
            languages.push($(this).val())
        })

        $('[name=languages_levels]').each(function(idx, el){
            levels.push($(this).val())
        })

        const data = {
            name: $('#full_name').val(),
            phone: $('#phone').val(),
            gender: $('#gender').val(),
            image: $('#profile_image').val(),
            currency_id: $('#currency_id').val(),
            country_id: $('#country_id').val(),
            fees: $('#fees').val(),
            birthday: $('#dob').val(),
            languages: languages,
            levels: levels
        };

        $.ajax({
            method: "POST",
            url: `{{route('profile_func')}}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function() {
                $('.sw-btn-next').click();
            },
            error: function () {
                alert('An error happened! Please try again')
            }
        });
    })
</script>
@endpush