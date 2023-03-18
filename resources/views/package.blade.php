@extends('layouts.app')

@section('content')
<main class="tu-main tu-bgmain">
        <section class="tu-main-section">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-xl-8 col-xxl-9">
                        <div class="tu-tutorprofilewrapp">
                            @if(isset(request()->success) && request()->success == 1)
                            <div class="alert alert-success">{{request()->message}}</div>
                            @endif

                            <span class="tu-cardtag"></span>
                            <div class="tu-profileview">
                                <figure>
                                    <img src="{{asset('images/' . @$package->image)}}" alt="image-description" style="height: 200px; width: 200px; object-fit: cover">
                                </figure>
                                <div class="tu-protutorinfo">
                                    <div class="tu-protutordetail">
                                        <div class="tu-productorder-content">
                                            <figure>
                                            <img src="{{asset('package/' . @$package->image)}}" alt="image-description" style=" object-fit: cover">
                                            </figure>
                                            <div class="tu-product-title">
                                            <div>
                                                    <ul class="tu-tutorreview">
                                                        <li>
                                                            <span><i class="fa fa-star tu-coloryellow"> <em>{{convert_to_currency(@$package->currency_id, @$package->fees)}}</em> </i></span>
                                                        </li>
                                                    </ul>
                                                </div>	
                                                <h3>{{app()->currentLocale() == 'ar' ?  @$package->title_ar : @$package->title_en}}</h3>
                                                <p>{{app()->currentLocale() == 'ar' ?  @$package->description_ar : @$package->description_en}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(\Auth::check() && \Auth::user()->type == 'student')
                            <div class="tu-actionbts">
                                <div class="tu-userurl">
                                    <!-- <i class="icon icon-globe"></i>
                                    <a href="javascript:void(0);">www.tutorlinkhere.com/tutor/uk/armando/295548 <i class="icon icon-copy"></i></a> -->
                                </div> 
                                
                                <ul class="tu-profilelinksbtn">
                                    <li>
                                        <form action="{{route('book.package_func', ['package_id' => $package->id])}}" method="post">
                                            @csrf
                                            <button class="tu-primbtn">@lang('app.book_now')</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</main>
@endsection