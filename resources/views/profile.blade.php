@extends('layouts.app')

@section('content')
<main class="tu-main tu-bgmain">
    <div class="tu-main-section">
        <div class="container">
            @if(!\Auth::user()->is_approved)
                <div class="alert alert-danger alert-dismissible ew-info">@lang('app.your_profile_not_approve')</div>
            @endif
            <div class="row gy-4">
                <div class="col-lg-4 col-xl-3">
                    <aside class="tu-asider-holder">
                        <div class="tu-asidebox">
                            <form id="form-profile-image">
                                @csrf
                                <figure>
                                    <img src="{{\Auth::user()->image ? asset('images/' . \Auth::user()->image) : 'https://votly.io/media/400/welnnxojxk3w0hpc7gq4tcriarfzvxsaoc7rgdi78ml4j0jbqk.webp'}}" alt="No Image" style="object-fit: cover">
                                    <figcaption class="tu-uploadimage">
                                        <input type="file" id="dropbox" name="file">
                                        <label for="dropbox"><i class="icon icon-camera"></i></label>
                                    </figcaption>
                                </figure>
                            </form>
                        </div>
                        <ul class="tu-side-tabs">
                            <li class="nav-item">
                                <a data-tab="personal" href="#" class="active nav-link"><i class="icon icon-user"></i><span>@lang('app.personal_details')</span></a>
                            </li>
                            @if(isTeacher())
                            <li class="nav-item">
                                <a data-tab="additional-info" href="#" class="nav-link"><i class="icon icon-phone"></i><span>@lang('app.additionanl_information')</span></a>
                            </li>
                            <li class="nav-item">
                                <a data-tab="subjects" href="#" class="nav-link"><i class="icon icon-book"></i><span>@lang('app.subjects')</span></a>
                            </li>
                            <li class="nav-item">
                                <a data-tab="resume" href="#" class="nav-link"><i class="icon icon-book-open"></i><span>@lang('app.resume')</span></a>
                            </li>
                            <li class="nav-item">
                                <a data-tab="availablity" href="#" class="nav-link"><i class="icon icon-image"></i><span>@lang('app.availablity')</span></a>
                            </li>
                            <li class="nav-item">
                                <a data-tab="description" href="#" class="nav-link"><i class="icon icon-book"></i><span>@lang('app.description')</span></a>
                            </li>
                            @endif
                        </ul>
                    </aside>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="tu-boxwrapper">
                        <div id="tab-personal" class="tabs">
                            @include('components.profile.personal_details', [
                                'currencies' => $currencies,
                                'countries' => $countries,
                                'languages' => $languages,
                                'languages_levels' => $languages_levels    
                            ])
                        </div>
                        @if(isTeacher())
                        <div id="tab-additional-info" class="tabs" style="display: none">
                            @include('components.profile.additional_info',[
                                'teacher_info' => $teacher_info,
                                'levels' => $levels,
                                'curriculums' => $curriculums
                            ])
                        </div>

                        <div id="tab-subjects" class="tabs" style="display: none">
                            @include('components.profile.subjects', [
                                'topics' => $topics    
                            ])
                        </div>

                        <div id="tab-resume" class="tabs" style="display: none">
                            @include('components.profile.resume')
                        </div>

                        <div id="tab-availablity" class="tabs" style="display: none">
                            @include('components.profile.availablity', [
                                'teacher_info' => $teacher_info,
                            ])
                        </div>

                        <div id="tab-description" class="tabs" style="display: none">
                            @include('components.profile.description')
                        </div>
                        @endif

                    </div>
                    <div class="tu-btnarea-two">
                        <a href="#" id="btn-save" class="tu-primbtn-lg tu-primbtn-orange">@lang('app.save_update')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.nav-link').click(function () {
            const data = $(this).data('tab')

            $('.nav-link').removeClass('active')
            $(this).addClass('active');

            $('.tabs').hide();
            $('#tab-' + data).slideDown();
        })

        $('#dropbox').change(function () {
            $('#form-profile-image').closest('form').submit();
        })

        $('#form-profile-image').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type:'POST',
                url: "{{{route('image.store')}}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    $('#form-profile-image img').attr('src', 'http://localhost:8000/images/' + data);
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });
        })

        $('#btn-save').click(function() {
            let languages = [];
            let langauges_levels = [];
            let levels = [];
            let levels_to_teach = [];
            let weekly_hours = [];
            let courses = [];
            let availability = [];
            let work_experience = [];
            let proffesional_certificates = [];
            let higher_educations = [];
            let topics = [];
            let teach_types = [];

            $('[name=languages]').each(function(idx, el){
                languages.push($(this).val())
            })

            $('[name=languages_levels]').each(function(idx, el){
                langauges_levels.push($(this).val())
            })

            $('[name=levels]').each(function(idx, el){
                levels.push($(this).val())
            })

            $('[name=level]:checked').each(function(idx, el){
                levels_to_teach.push($(this).val())
            })

            $('[name=hours]:checked').each(function(idx, el){
                weekly_hours.push($(this).val())
            })

            $('[name=course]:checked').each(function(idx, el){
                courses.push($(this).val())
            })


            $('[name=topic]:checked').each(function(idx, el){
                topics.push($(this).val())
            })

            $('.work-experience-subconatiner').each(function(idx, el){
                work_experience.push({
                    title: $(this).find('#job_title').val(),
                    from: '01-' + $(this).find('#from_month').val() + '-' + $(this).find('#from_year').val(),
                    to: '01-' + $(this).find('#to_month').val() + '-' + $(this).find('#to_year').val(),
                    company: $(this).find('#company_name').val()
                });
            })

            $('.professional-certificates-subconatiner').each(function(idx, el){
                proffesional_certificates.push({
                    institution: $(this).find('#institution').val(),
                    from: '01-' + $(this).find('#from_month').val() + '-' + $(this).find('#from_year').val(),
                    to: '01-' + $(this).find('#to_month').val() + '-' + $(this).find('#to_year').val(),
                    subject: $(this).find('#subject').val(),
                });
            })

            $('.higher-education-degrees-subconatiner').each(function(idx, el){
                higher_educations.push({
                    university: $(this).find('#university').val(),
                    from: '01-01-' + $(this).find('#from_year').val(),
                    to: '01-01-' + $(this).find('#to_year').val(),
                    degree: $(this).find('#degree').val(),
                    image: $(this).find('#university_image').val()
                });
            })

            $('[name=teach_type]:checked').each(function(idx, el){
                if($(this).val() == 'remote') {
                    teach_types.push( { 'type': $(this).val(), fee: $('#teach_online_container_hour').val(), currency_id: $('#teach_online_container_currency').val() } )
                } else if($(this).val() == 'teacher_place') {
                    teach_types.push( { 'type': $(this).val(), fee: $('#teach_teacher_place_container_hour').val() , currency_id: $('#teach_teacher_place_container_currency').val() } )
                } else if($(this).val() == 'student_place') {
                    teach_types.push( { 'type': $(this).val(), fee: $('#teach_student_place_container_hour').val() , currency_id: $('#teach_student_place_container_currency').val() } )
                }
            })


            const data = {
                name: $('#full_name').val(),
                phone: $('#phone').val(),
                gender: $('#gender').val(),
                currency_id: $('#currency_id').val(),
                country_id: $('#country_id').val(),
                fees: $('#fees').val(),
                birthday: $('#dob').val(),
                languages: languages,
                langauges_levels: langauges_levels,
                levels: levels,
                levels: levels_to_teach,
                teach_gender: $('[name=gender_to_teach]:checked').val(),
                weekly_hours: weekly_hours,
                allow_express: $('[name=allow_express]:checked').val(),
                courses: courses,
                timezone: $('#timezone').val(),
                order_immediatly: $('[name=should_organize]:checked').val(),
                days_availablity: $('#availablity').text(),
                video: $('#video').val(),
                heading_en: $('#heading_en').val(),
                description_en: $('#description_en').val(),
                heading_ar: $('#heading_ar').val(),
                description_ar: $('#description_ar').val(),
                work_experience: work_experience,
                proffesional_certificates: proffesional_certificates,
                higher_educations: higher_educations,
                topics: topics,
                teach_types: teach_types
            };

            $.ajax({
                method: "POST",
                url: `{{route('profile_func')}}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function() {
                    toastr.success('Updated!');
                    $('.tu-side-tabs .active').parent('.nav-item').next().find('.nav-link').click()
                    // $('.sw-btn-next').click();
                },
                error: function () {
                    toastr.error('An erro happened!')
                    // alert('An error happened! Please try again')
                }
            });
        })
    })
</script>
@endpush