@extends('layouts.app')

@section('content')
    <!-- Main start -->
    <form action="{{route('search')}}" method="get">
        <main class="tu-bgmain tu-main">
            <section class="tu-main-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tu-listing-wrapper">
                                <div class="tu-sort">
                                    <h3>{{$teacher_count}} @lang('app.search_result')</h3>
                                    <div class="tu-sort-right-area">
                                        <!-- <div class="tu-sortby">
                                            <span>Sort by: </span>
                                            <div class="tu-select">
                                                <select class="form-control tu-selectv" name="sort">
                                                    <option value="asc">Price low to high </option>
                                                    <option value="desc">Price high to low</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <!-- <div class="tu-filter-btn">
                                            <a class="tu-listbtn active" href="search-listing-two.html"><i class="icon icon-list"></i></a>
                                            <a class="tu-listbtn" href="search-listing.html"><i class="icon icon-grid"></i></a>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- <ul class="tu-searchtags">
                                    <li>
                                        <span>Pre-School <a href="javascript:void(0)"><i class="icon icon-x"></i></a></span>
                                    </li>
                                    <li>
                                        <span> Middle (Class 6-8) <a href="javascript:void(0)"><i class="icon icon-x"></i></a></span>
                                    </li>
                                    <li>
                                        <span>Intermediate <a href="javascript:void(0)"><i class="icon icon-x"></i></a></span>
                                    </li>
                                    <li>
                                        <span>5.0 Stars <a href="javascript:void(0)"><i class="icon icon-x"></i></a></span>
                                    </li>
                                    <li>
                                        <span>Online bookings <a href="javascript:void(0)"><i class="icon icon-x"></i></a></span>
                                    </li>
                                    <li>
                                        <span>Male only <a href="javascript:void(0)"><i class="icon icon-x"></i></a></span>
                                    </li>
                                </ul> -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <aside class="tu-asidewrapper">
                                <a href="javascript:void(0)" class="tu-dbmenu"><i class="icon icon-chevron-left"></i></a>
                                <div class="tu-aside-menu"> 
                                    <div class="tu-aside-holder">
                                        <div class="tu-asidetitle" data-bs-toggle="collapse" data-bs-target="#side2" role="button" aria-expanded="true">
                                            <h5>@lang('app.education_level')</h5>
                                        </div>
                                        <div id="side2" class="collapse show">
                                            <div class="tu-aside-content">
                                            
                                                <div class="tu-filterselect">
                                                        @include('components.standard.select', [
                                                            'id' => 'topic_id', 
                                                            'name' => 'topic_id', 
                                                            'placeholder' => __('app.select_topic'), 
                                                            'options' => $main_topics, 
                                                            'value' => request()->topic_id 
                                                        ])
                                                
                                                        @include('components.standard.select', [
                                                            'id' => 'level_id', 
                                                            'name' => 'level_id', 
                                                            'placeholder' => __('app.select_level'), 
                                                            'options' => $levels, 
                                                            'value' => request()->level_id
                                                        ])

                                                        @include('components.standard.select', [
                                                            'id' => 'curriculum_id', 
                                                            'name' => 'curriculum_id', 
                                                            'placeholder' => __('app.select_curriculums'), 
                                                            'options' => $curriculums,
                                                            'value' => request()->curriculum_id
                                                        ])

                                                        @include('components.standard.select', [
                                                            'id' => 'languages', 
                                                            'name' => 'language_id', 
                                                            'placeholder' => __('app.language'), 
                                                            'options' => $languages,
                                                            'value' => request()->language_id
                                                        ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tu-aside-holder">
                                        <div class="tu-asidetitle" data-bs-toggle="collapse" data-bs-target="#side1a" role="button" aria-expanded="true">
                                            <h5>@lang('app.rating')</h5>
                                        </div>
                                        <div id="side1a" class="collapse show">
                                            <div class="tu-aside-content">
                                                <ul class="tu-categoriesfilter">
                                                    <li>
                                                        <div class="tu-check tu-checksm">
                                                            <input type="checkbox" id="rate5" name="rate5" @if(request()->rate5) checked @endif>
                                                            <label for="rate5">
                                                                <span class="tu-stars">
                                                                    <span></span>
                                                                </span>
                                                                <em class="tu-totalreview">
                                                                    <span>5.0/<em>5.0</em></span>
                                                                </em>  
                                                            </label>
                                                        </div>
                                                    </li>                                              
                                                    <li>
                                                        <div class="tu-check tu-checksm">
                                                            <input type="checkbox" id="rate4" name="rate4" @if(request()->rate4) checked @endif>
                                                            <label for="rate4">
                                                                <span class="tu-stars tu-fourstar">
                                                                    <span></span>
                                                                </span>
                                                                <em class="tu-totalreview">
                                                                    <span>4.0/<em>5.0</em></span>
                                                                </em>
                                                            </label>
                                                        </div>
                                                    </li>                                              
                                                    <li>
                                                        <div class="tu-check tu-checksm">
                                                            <input type="checkbox" id="rate3" name="rate3"  @if(request()->rate3) checked @endif>
                                                            <label for="rate3">
                                                                <span class="tu-stars tu-threestar">
                                                                    <span></span>
                                                                </span>
                                                                <em class="tu-totalreview">
                                                                    <span>3.0/<em>5.0</em></span>
                                                                </em>
                                                            </label>
                                                        </div>
                                                    </li>                                         
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tu-filterbtns">
                                        <button class="tu-primbtn w-100" >@lang('app.apply_filter')</button>
                                        <!-- <a href="search-listing.html" class="tu-sb-sliver">Clear all filters</a> -->
                                    </div>
                                </div>
                            </aside>
                        </div>
                        <div class="col-lg-12 col-xl-9">
                            @if(sizeOf($teachers) == 0) 
                                <h3>@lang('app.no_data')</h3>
                            @else 
                                @foreach($teachers as $teacher)
                                <div class="tu-listinginfo-holder">
                                    @include('components.search.search_teacher', [
                                        'teacher' => $teacher    
                                    ])
                                </div>
                                @endforeach
                            @endif
                            <nav class="tu-pagination">
                                <ul>
                                    @for ($i = 1; $i < $pages_count; $i++)
                                    <!-- <li class="tu-pagination-prev"><a href="javascript:void(0)"><i class="icon icon-chevron-left"></i></a> </li> -->
                                    <li @if($i == $current_page) class="active" @endif><a href="{{route('search', ['page' => $i] + \Request::all())}}">{{$i}}</a> </li>
                                    <!-- <li class="tu-pagination-next"><a href="javascript:void(0)"><i class="icon icon-chevron-right"></i></a> </li> -->
                                    @endfor
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </form>
    <!-- Main end -->
@endsection