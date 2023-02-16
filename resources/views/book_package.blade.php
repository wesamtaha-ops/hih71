@extends('layouts.app')

@php
    $hours = [['id' => '4', 'name' => '4'],['id' => '5', 'name' => '5'],['id' => '6', 'name' => '6'],['id' => '7', 'name' => '7'],['id' => '8', 'name' => '8'],['id' => '9', 'name' => '9'],['id' => '10', 'name' => '10'],['id' => '11', 'name' => '11'],['id' => '12', 'name' => '12'],['id' => '13', 'name' => '13'],['id' => '14', 'name' => '14'],['id' => '15', 'name' => '15'],['id' => '16', 'name' => '16'],['id' => '17', 'name' => '17'],['id' => '18', 'name' => '18'],['id' => '19', 'name' => '19'],['id' => '20', 'name' => '20'],['id' => '21', 'name' => '21'],['id' => '22', 'name' => '22'],['id' => '23', 'name' => '23'],['id' => '24', 'name' => '24'],['id' => '25', 'name' => '25'],['id' => '26', 'name' => '26'],['id' => '27', 'name' => '27'],['id' => '28', 'name' => '28'],['id' => '29', 'name' => '29'],['id' => '30', 'name' => '30'],['id' => '31', 'name' => '31'],['id' => '32', 'name' => '32'],['id' => '33', 'name' => '33'],['id' => '34', 'name' => '34'],['id' => '35', 'name' => '35'],['id' => '36', 'name' => '36'],['id' => '37', 'name' => '37'],['id' => '38', 'name' => '38'],['id' => '39', 'name' => '39'],['id' => '40', 'name' => '40']];
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
                                                    <div><i class="icon icon-map-pin"><span>{{$teacher->city}}, {{$teacher->country->name_en}}</span></i></div>
                                                    <div>{{$teacher->teacher->description_en}}</div>
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                            </div>
                            <div class="tu-actionbts">
                                <ul class="tu-profilelinksbtn">
                                    <li>
                                        <a href="{{route('book.single', ['teacher_id' => $teacher->id ])}}" class="tu-secbtn">Book Single</a>
                                    </li>
                                    <li>
                                        <a href="{{route('book.package', ['teacher_id' => $teacher->id ])}}" class="tu-primbtn">Book Package</a>
                                    </li>
                                </ul>
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
                            <form class="tu-themeform tu-dhbform" style="padding: 20px;" action="{{route('book.package_func', ['teacher_id' => $teacher->id] )}}" method="post">
                                <fieldset>
                                    <div class="tu-themeform__wrap">
                                        <div class="form-group-wrap">
                                            @csrf

                                            @include('components.standard.select', ['id' => 'hours', 'name' => 'hours', 'placeholder' => __('app.select_how_many_hours'), 'options' => $hours])
                                            
                                            @include('components.standard.textarea', ['id' => 'notes', 'name' => 'notes', 'placeholder' => 'Notes'])
                                            
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

@push('scripts')
<script>
    $(document).ready(function () {
        $('#hours').change(function () {
            const hours = $(this).val();
            const packages = {!! $teacher->teacher->packages !!};
            packages.map(package => {
                if(hours <= package.to && hours >= package.from ) {
                    $('#total').text(package.fee)
                }
            })
        })
    });
</script>
@endpush