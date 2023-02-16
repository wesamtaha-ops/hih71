@extends('layouts.app')

@php
    $times = [['id' => '00_30', 'name' => '00:30'],['id' => '01_00', 'name' => '01:00'],['id' => '01_30', 'name' => '01:30'],['id' => '02_00', 'name' => '02:00'],['id' => '02_30', 'name' => '02:30'],['id' => '03_00', 'name' => '03:00'],['id' => '03_30', 'name' => '03:30'],['id' => '04_00', 'name' => '04:00'],['id' => '04_30', 'name' => '04:30'],['id' => '05_00', 'name' => '05:00'],['id' => '05_30', 'name' => '05:30'],['id' => '06_00', 'name' => '06:00'],['id' => '06_30', 'name' => '06:30'],['id' => '07_00', 'name' => '07:00'],['id' => '07_30', 'name' => '07:30'],['id' => '08_00', 'name' => '08:00'],['id' => '08_30', 'name' => '08:30'],['id' => '09_00', 'name' => '09:00'],['id' => '09_30', 'name' => '09:30'],['id' => '10_00', 'name' => '10:00'],['id' => '10_30', 'name' => '10:30'],['id' => '11_00', 'name' => '11:00'],['id' => '11_30', 'name' => '11:30'],['id' => '12_00', 'name' => '12:00'],['id' => '12_30', 'name' => '12:30'],['id' => '13_00', 'name' => '13:00'],['id' => '13_30', 'name' => '13:30'],['id' => '14_00', 'name' => '14:00'],['id' => '14_30', 'name' => '14:30'],['id' => '15_00', 'name' => '15:00'],['id' => '15_30', 'name' => '15:30'],['id' => '16_00', 'name' => '16:00'],['id' => '16_30', 'name' => '16:30'],['id' => '17_00', 'name' => '17:00'],['id' => '17_30', 'name' => '17:30'],['id' => '18_00', 'name' => '18:00'],['id' => '18_30', 'name' => '18:30'],['id' => '19_00', 'name' => '19:00'],['id' => '19_30', 'name' => '19:30'],['id' => '20_00', 'name' => '20:00'],['id' => '20_30', 'name' => '20:30'],['id' => '21_00', 'name' => '21:00'],['id' => '21_30', 'name' => '21:30'],['id' => '22_00', 'name' => '22:00'],['id' => '22_30', 'name' => '22:30'],['id' => '23_00', 'name' => '23:00'],['id' => '23_30', 'name' => '23:30'],['id' => '23_59', 'name' => '23:59']];
    $durations = [['id' => 60, 'name' => '60'], ['id' => 120, 'name' => '120'],['id' => 180, 'name' => '1800']];
@endphp

@section('content')
<main class="tu-main tu-bgmain">
        <section class="tu-main-section" style="padding-bottom: 0px;">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-xl-12">
                        @if(isset(request()->success) && request()->success == 0)
                        <div class="alert alert-danger">{{request()->message}}</div>
                        @endif
                        <div class="tu-tutorprofilewrapp">
                            <div class="tu-profileview">
                                <div class="tu-protutorinfo">
                                    <div class="tu-protutordetail">
                                        <div class="tu-productorder-content">
                                            <img src="{{asset('images/' . $teacher->image)}}" alt="image-description" style="height: 200px; width: 200px; object-fit: cover">
                                            <div class="tu-product-title" style="padding: 20px; padding-top: 0px;">
                                                <div class="tu-detailitem">
                                                    <h6>{{$teacher->name}}</h6>
                                                    <div>{{$teacher->teacher->description_en}}</div>
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="tu-main-section" style="padding-top: 20px;">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="tu-tutorprofilewrapp">
                            <form class="tu-themeform tu-dhbform" style="padding: 20px;" action="{{route('book.single_func', ['teacher_id' => $teacher->id] )}}" method="post">
                                <fieldset>
                                    <div class="tu-themeform__wrap">
                                        <div class="form-group-wrap">
                                            @include('components.standard.select', ['id' => 'topic', 'name' => 'topic', 'placeholder' => __('app.select_topic'), 'options' => $topics, 'value' => request()->topic_id])

                                            @csrf

                                            @include('components.available_calendar', ['availablility_arr' => $availablility_arr])

                                            <button class="tu-primbtn">Submit</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</main>
@endsection