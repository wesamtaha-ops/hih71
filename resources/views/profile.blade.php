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
                            <li class="nav-item" style="display: none">
                                <a data-tab="thanks" href="#" class="nav-link"><i class="icon icon-book"></i><span></span></a>
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

                        <div id="tab-thanks" class="tabs" style="display: none">
                            <div class="container">
                                <div class="header" style="text-align: center">
                                    <script data-pagespeed-no-defer>//<![CDATA[
                        (function(){for(var g="function"==typeof Object.defineProperties?Object.defineProperty:function(b,c,a){if(a.get||a.set)throw new TypeError("ES3 does not support getters and setters.");b!=Array.prototype&&b!=Object.prototype&&(b[c]=a.value)},h="undefined"!=typeof window&&window===this?this:"undefined"!=typeof global&&null!=global?global:this,k=["String","prototype","repeat"],l=0;l<k.length-1;l++){var m=k[l];m in h||(h[m]={});h=h[m]}var n=k[k.length-1],p=h[n],q=p?p:function(b){var c;if(null==this)throw new TypeError("The 'this' value for String.prototype.repeat must not be null or undefined");c=this+"";if(0>b||1342177279<b)throw new RangeError("Invalid count value");b|=0;for(var a="";b;)if(b&1&&(a+=c),b>>>=1)c+=c;return a};q!=p&&null!=q&&g(h,n,{configurable:!0,writable:!0,value:q});var t=this;function u(b,c){var a=b.split("."),d=t;a[0]in d||!d.execScript||d.execScript("var "+a[0]);for(var e;a.length&&(e=a.shift());)a.length||void 0===c?d[e]?d=d[e]:d=d[e]={}:d[e]=c};function v(b){var c=b.length;if(0<c){for(var a=Array(c),d=0;d<c;d++)a[d]=b[d];return a}return[]};function w(b){var c=window;if(c.addEventListener)c.addEventListener("load",b,!1);else if(c.attachEvent)c.attachEvent("onload",b);else{var a=c.onload;c.onload=function(){b.call(this);a&&a.call(this)}}};var x;function y(b,c,a,d,e){this.h=b;this.j=c;this.l=a;this.f=e;this.g={height:window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight,width:window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth};this.i=d;this.b={};this.a=[];this.c={}}function z(b,c){var a,d,e=c.getAttribute("data-pagespeed-url-hash");if(a=e&&!(e in b.c))if(0>=c.offsetWidth&&0>=c.offsetHeight)a=!1;else{d=c.getBoundingClientRect();var f=document.body;a=d.top+("pageYOffset"in window?window.pageYOffset:(document.documentElement||f.parentNode||f).scrollTop);d=d.left+("pageXOffset"in window?window.pageXOffset:(document.documentElement||f.parentNode||f).scrollLeft);f=a.toString()+","+d;b.b.hasOwnProperty(f)?a=!1:(b.b[f]=!0,a=a<=b.g.height&&d<=b.g.width)}a&&(b.a.push(e),b.c[e]=!0)}y.prototype.checkImageForCriticality=function(b){b.getBoundingClientRect&&z(this,b)};u("pagespeed.CriticalImages.checkImageForCriticality",function(b){x.checkImageForCriticality(b)});u("pagespeed.CriticalImages.checkCriticalImages",function(){A(x)});function A(b){b.b={};for(var c=["IMG","INPUT"],a=[],d=0;d<c.length;++d)a=a.concat(v(document.getElementsByTagName(c[d])));if(a.length&&a[0].getBoundingClientRect){for(d=0;c=a[d];++d)z(b,c);a="oh="+b.l;b.f&&(a+="&n="+b.f);if(c=!!b.a.length)for(a+="&ci="+encodeURIComponent(b.a[0]),d=1;d<b.a.length;++d){var e=","+encodeURIComponent(b.a[d]);131072>=a.length+e.length&&(a+=e)}b.i&&(e="&rd="+encodeURIComponent(JSON.stringify(B())),131072>=a.length+e.length&&(a+=e),c=!0);C=a;if(c){d=b.h;b=b.j;var f;if(window.XMLHttpRequest)f=new XMLHttpRequest;else if(window.ActiveXObject)try{f=new ActiveXObject("Msxml2.XMLHTTP")}catch(r){try{f=new ActiveXObject("Microsoft.XMLHTTP")}catch(D){}}f&&(f.open("POST",d+(-1==d.indexOf("?")?"?":"&")+"url="+encodeURIComponent(b)),f.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),f.send(a))}}}function B(){var b={},c;c=document.getElementsByTagName("IMG");if(!c.length)return{};var a=c[0];if(!("naturalWidth"in a&&"naturalHeight"in a))return{};for(var d=0;a=c[d];++d){var e=a.getAttribute("data-pagespeed-url-hash");e&&(!(e in b)&&0<a.width&&0<a.height&&0<a.naturalWidth&&0<a.naturalHeight||e in b&&a.width>=b[e].o&&a.height>=b[e].m)&&(b[e]={rw:a.width,rh:a.height,ow:a.naturalWidth,oh:a.naturalHeight})}return b}var C="";u("pagespeed.CriticalImages.getBeaconData",function(){return C});u("pagespeed.CriticalImages.Run",function(b,c,a,d,e,f){var r=new y(b,c,a,e,f);x=r;d&&w(function(){window.setTimeout(function(){A(r)},0)})});})();pagespeed.CriticalImages.Run('/mod_pagespeed_beacon','https://onak.app/hih71/public/templates/thank-teacher.html','82dtZm2p5Q',true,false,'iz4B1ADxmAo');
                        //]]></script><img src="https://votly.io/media/400/97b0pbl01fi7npvttoz59xl0279v98hwlwbbckqbbk7em3zuhz.webp" alt="Logo" width="200" data-pagespeed-url-hash="1266206036" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/>
                                    <h4 style="margin-top: 30px;">Thank You for Joining the HIH71 Platform</h4>
                                    <h5 style="margin-top: 30px;">Your application has been sent to the administration for checking and approval</h5>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="tu-btnarea-two">
                        <a href="#" id="btn-save" class="tu-primbtn-lg tu-primbtn-orange" style="margin-right: 10px">@lang('app.save_update')</a>
                        @if(request()->admin == '1')
                        <a href="#" id="btn-approve" class="tu-primbtn-lg" style="margin-right: 10px; background: green">@lang('app.approve')</a>
                    
                        <a href="#" id="btn-decline" class="tu-primbtn-lg" style="background: red">@lang('app.decline')</a> <br />
                        @endif
                    </div>
                    @if(request()->admin == '1')
                    <textarea id="decline_reason" placeholder="Decline Reason ..." style="margin-top: 20px;height: 150px; width: 100%"></textarea>
                    @endif
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

            if(data == 'thanks') {
                $('#btn-save').hide();
            }
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
                    $('#form-profile-image img').attr('src', "{{env('APP_URL')}}/images/" + data);
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
                    toastr.error('An error happened!')
                    // alert('An error happened! Please try again')
                }
            });
        })

        @if(request()->admin == '1')
        $('#btn-approve').click(function () {
            $.ajax({
                method: "POST",
                url: `{{env('APP_URL') . "admin/" . \Auth::id()}}/approve`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    toastr.success('Approved!');
                },
                error: function () {
                    toastr.error('An erro happened!')
                }
            });
        })


        $('#btn-decline').click(function () {
            $.ajax({
                method: "POST",
                data: {
                    reason: $('#decline_reason').val()
                },
                url: `{{env('APP_URL') . "admin/" . \Auth::id()}}/decline`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    toastr.success('Declined!');
                },
                error: function () {
                    toastr.error('An error happened!')
                }
            });
        })
        @endif
    })
</script>
@endpush