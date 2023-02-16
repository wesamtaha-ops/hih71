@extends('layouts.app')

@section('content')
<!-- BANNER START -->
    <div class="tu-bannervthree">
        <div class="container">
            <div class="align-items-center" style="max-width:1200px">
                <div class="tu-dottedimage">
            <img src="https://votly.io/media/400/3vuw5cvzd70io9rshd2d03hrhff06q40h894lrkryf6k28hzak.webp" alt="img">
        </div>
        <div class="tu-linedimage">
            <img src="https://votly.io/media/400/b4l6dytq1x91a9rst97kb2j0n2olsxtf39z5ydbni8wqtllhom.webp" alt="img">
        </div>
                <div class="tu-particles">
            <div id="tu-particle"><canvas class="particles-js-canvas-el" width="1792" height="646" style="width: 100%; height: 100%;"></canvas></div>
        </div>
                <h1 style="color: white;padding-left: 0px;">{{__('app.home_banner_title')}}</h1>
                <h3 style="color: white; padding-left: 0px;">{{__('app.home_banner_subtitle')}}</h3>
                
                <form action="{{route('search')}}" method="get" style="padding: 0px;">
                    <div class="home-banner-form-container">
                            @include('components.standard.select', ['id' => 'topic', 'half' => 1, 'name' => 'topic_id', 'placeholder' => __('app.select_topic'), 'options' => $topics])
                            @include('components.standard.select', ['id' => 'level', 'half' => 1, 'name' => 'level_id', 'placeholder' => __('app.select_level'), 'options' => $levels])
                    </div>

                    <button class="btn btn-outline-light btn-lg btn-find-tutor" style="background: #F97315; border-radius: 0px; border: 0px;">{{__('app.find_my_tutor')}}</button>
                </form>
            </div>
        </div>
    </div>
<!-- BANNER END -->
<!-- MAIN START -->
<main class="tu-main">
    <section class="tu-main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="tu-maintitle text-center">
                        <img src="https://amentotech.com/htmls/tuturn/images/zigzag-line.svg" alt="img" data-pagespeed-url-hash="2568097027" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                        <h4>{{__('app.home_topic_subtitle')}}</h4>
                        <h2>{{__('app.home_topic_title')}}</h2>
                        <p>{{__('app.home_topic_caption')}}</p>
                    </div>
                </div>
            </div>
            <div id="tu-categoriesslider" class="splide tu-categoriesslider tu-splidedots" style="direction: ltr">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($main_topics as $topic)
                        <li class="splide__slide">
                            <a class="tu-categories_content" href="{{route('search', ['topic_id' => $topic['id']])}}">
                                <img src="{{asset('images/' . $topic['image'])}}" alt="img">
                                <div class="tu-categories_title">
                                    <h6>{{$topic['name']}}</h6>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="tu-main-section" style="background: #f7f8fc">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="tu-maintitle text-center">
                        <img src="https://amentotech.com/htmls/tuturn/images/zigzag-line.svg" alt="img" data-pagespeed-url-hash="2568097027" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                        <h4>{{__('app.home_teacher_subtitle')}}</h4>
                        <h2>{{__('app.home_teacher_title')}}</h2>
                        <p>{{__('app.home_teacher_caption')}}</p>
                    </div>
                </div>
            </div>
            <div id="tu-featurelist" class="splide tu-featurelist  tu-splidedots"  style="direction: ltr">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($teachers as $teacher)
                        <li class="splide__slide">
                            <a href="{{route('teacher', ['slug' => $teacher->slug])}}"> 
                            <div class="tu-featureitem">
                                <div class="tu-authorinfo">
                                    <div class="tu-authordetail">
                                        <figure>
                                            <img src="images/{{$teacher->image}}" alt="image-description" style="width: 50px; height: 50px; object-fit: cover">
                                        </figure>
                                        <div class="tu-authorname">
                                            <h5>{{$teacher->name}}  <i class="icon icon-check-circle tu-greenclr" data-tippy-trigger="mouseenter" data-tippy-html="#tu-verifed" data-tippy-interactive="true" data-tippy-placement="top"></i></h5>
                                            <span>{{$teacher->city}}, {{$teacher->country->name_en}}</span>
                                        </div>
                                        <ul class="tu-authorlist">
                                            <li>
                                            </li>
                                            <li>
                                                <span>{{$teacher->teacher->heading_en}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tu-instructors_footer">
                                        <div class="tu-rating">
                                            <i class="fas fa-star"></i>
                                            <h6>5.0</h6>
                                            <span>(66,951)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    
    <section class="tu-main-section">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-md-12 col-lg-6">
                    <div class="tu-maintitle p-0">
                        <img src="https://amentotech.com/htmls/tuturn/images/zigzag-line.svg" alt="img">
                        <h4>{{__('app.home_about_subtitle')}}</h4>
                        <h2>{{__('app.home_about_title')}}</h2>
                        <p>{{__('app.home_about_caption')}}</p>
                        <a href="how-it-work.html" class="tu-primbtn-lg"><span>{{__('app.home_about_explore_btn')}}</span><i class="icon icon-chevron-right"></i></a>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="tu-betterresult">
                        <figure>
                            <img src="https://amentotech.com/htmls/tuturn/images/index/platform/img-01.png" alt="image-description">
                        </figure>
                        <img src="https://amentotech.com/htmls/tuturn/images/index/platform/img-02.png" alt="image-description">
                        <div class="tu-resultperson">
                            <h6>{{__('app.home_about_founder')}}</h6>
                            <h5>{{__('app.home_about_name')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</main>
<!-- MAIN END -->
@endsection



@section('scripts')
<script>
    $(document).ready(function () {
        $('#select-topic').select2();
        $('#select-level').select2();
    })
</script>
@endsection