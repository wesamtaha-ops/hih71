<div class="tu-listinginfo tu-listinginfo_two">
    <!-- <span class="tu-cardtag"></span> -->
    <div class="tu-listing-slider">  
        <img src="{{asset('images/' . $teacher->image)}}" alt="Image Description" style="height: 200px; width: 400px; object-fit: cover">
    </div>
    <div class="tu-listinginfo_wrapper">
        <div class="tu-listinginfo_title">
            <div class="tu-listinginfo-img">
                <!-- <figure>
                    <img src="{{asset('images/' . $teacher->image)}}" alt="imge">
                </figure> -->
                <div class="tu-listing-heading">
                    <h5>{{$teacher->name}}
                    <!-- <i class="icon icon-check-circle tu-greenclr" data-tippy-trigger="mouseenter" data-tippy-html="#tu-verifed" data-tippy-interactive="true" data-tippy-placement="top"></i> -->
                </h5>
                    <div class="tu-listing-location">
                        
                            <span> @include('components.star', ['value' => $teacher->rate]) {{sprintf('%0.1f', $teacher->rate)}}<span>/5.0</span> </i>  <em>({{$teacher->review_count}})</em></span>
                        
                    </div>
                </div>
            </div>
            <div class="tu-listinginfo_price">
                
            </div>
        </div>
        <div class="tu-listinginfo_service">
            <ul class="tu-service-list">
                <li>
                    <a href="{{route('teacher', ['slug' => $teacher->slug] )}}">
                        <span>
                            <i class="icon icon-home tu-greenclr"></i>
                            @lang('app.teacher_details')
                        </span>
                    </a>
                </li>
                @if(\Auth::check() && \Auth::user()->type == 'student')
                <li>
                    <a href="{{route('book.single', ['teacher_id' => $teacher->id, 'topic_id' => request()->topic_id ])}}">
                        <span>
                            <i class="icon icon-map-pin tu-orangeclr"></i>
                            @lang('app.book_now')
                        </span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="tu-listinginfo_description">
            <p>{{app()->currentLocale() == 'ar' ? @$teacher->teacher->description_ar : @$teacher->teacher->description_en}}</p>
        </div>
        <ul class="tu-serviceslist">
            <li style="font-weight: bold; font-size: 13px">@lang('app.language')</li>
            @if(@$teacher->teacher->teacher_language)
                @foreach(json_decode($teacher->teacher->teacher_language) as $teacher_language)
                <li>
                    <a href="#">
                        @foreach($languages as $language)
                            @if($language['id'] == $teacher_language->language) 
                                {{$language['name']}}
                            @endif
                        @endforeach

                        @foreach($languages_levels as $level)
                            @if($level['id'] == $teacher_language->level) 
                                ( {{$level['name']}} )
                            @endif
                        @endforeach
                    </a>
                </li>
                @endforeach
            @endif
        </ul>

        
    </div>
</div>