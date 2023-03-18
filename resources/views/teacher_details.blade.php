@extends('layouts.app')

@section('content')
<main class="tu-main tu-bgmain">
        <section class="tu-main-section">
            <div class="container">
                @if($teacher)
                <div class="row gy-4">
                    <div class="@if(sizeOf($teacher->teacher->packages) > 0) col-xl-9 @else col-xl-12 @endif">
                        <div class="tu-tutorprofilewrapp">
                            @if(isset(request()->success) && request()->success == 1)
                            <div class="alert alert-success">{{request()->message}}</div>
                            @endif

                            <span class="tu-cardtag"></span>
                            <div class="tu-profileview">
                                <figure>
                                    <img src="{{asset('images/' . @$teacher->image)}}" alt="image-description" style="height: 200px; width: 200px; object-fit: cover">
                                </figure>
                                <div class="tu-protutorinfo">
                                    <div class="tu-protutordetail">
                                        <div class="tu-productorder-content">
                                            <figure>
                                            <img src="{{asset('images/' . @$teacher->image)}}" alt="image-description" style=" object-fit: cover">
                                            </figure>
                                            <div class="tu-product-title">
                                                <h3>{{@$teacher->name}}
                                                    <!-- <i class="icon icon-check-circle tu-greenclr" data-tippy-trigger="mouseenter" data-tippy-html="#tu-verifed" data-tippy-interactive="true" data-tippy-placement="top"></i> -->
                                                </h3>
                                                <h5>{{app()->currentLocale() == 'ar' ?  @$teacher->teacher->heading_ar : @$teacher->teacher->heading_en}}</h5>
                                            </div>
                                        </div>
                                        <ul class="tu-tutorreview">
                                            <li>
                                                <span> @include('components.star', ['value' => $reviews['avg']]) {{sprintf('%0.1f', $reviews['avg'])}}<span>/5.0</span> </i>  <em>({{$reviews['count']}})</em></span>
                                                
                                            </li>
                                        </ul>	
                                        <div class="tu-detailitem">
                                            <h6>@lang('app.language')</h6>
                                            <div class="tu-languagelist">
                                                <ul class="tu-languages">
                                                    @if(@$teacher->teacher->teacher_language)
                                                        @foreach(json_decode(@$teacher->teacher->teacher_language) as $language)
                                                            @foreach($languages as $lang)
                                                                @if($lang['id'] == $language->language)
                                                                    <li>{{$lang['name']}}</li>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(isStudent() || isGuest())
                            <div class="tu-actionbts">
                                <ul class="tu-profilelinksbtn">
                                    <li>
                                        <a href="{{route('book.single', ['teacher_id' => @$teacher->id ])}}" class="tu-primbtn">@lang('app.book_tution')</a>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="tu-detailstabs">
							<ul class="nav nav-tabs tu-nav-tabs" id="myTab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="icon icon-home"></i><span>@lang('app.introduction')</span></button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="icon icon-message-circle"></i><span>@lang('app.reviews')</span></button>
								</li>
							</ul>
							<div class="tab-content tu-tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="tu-tabswrapper">
                                        <div class="tu-description">
											{{@$teacher->teacher->description_en}}
										</div>
                                    </div>
                                    <div class="tu-tabswrapper">
                                        <div class="tu-tabstitle">
											<h4>@lang('app.education')</h4>
										</div>

                                        <div class="accordion tu-accordionedu" id="accordionFlushExampleaa">
											<div id="tu-edusortable" class="tu-edusortable">
												<div class="tu-accordion-item">
													<div class="tu-expwrapper">
														<div class="tu-accordionedu">
															<div class="tu-expinfo">
																<div class="tu-accodion-holder">
																	<h5 class="collapsed"   data-bs-toggle="collapse" data-bs-target="#flush-collapseOneba" aria-expanded="true" aria-controls="flush-collapseOneba">@lang('app.higher_education_degree')</h5>
																</div>
																<i class="icon icon-plus" role="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneba" aria-expanded="true" aria-controls="flush-collapseOneba"></i>
															</div>
														</div>
													</div>
													<div id="flush-collapseOneba" class="accordion-collapse collapse show"  data-bs-parent="#accordionFlushExampleaa">
														<div class="tu-edubodymain">
															<div class="tu-accordioneduc">
                                                                @if(@$teacher->teacher->certificates)
                                                                    @foreach($teacher->teacher->certificates as $certificate)
                                                                    <ul class="tu-branchdetail" style="margin-top: 10px;">
                                                                        <li><i class="icon icon-home"></i><span>{{$certificate->university}}</span></li>
                                                                        <li><i class="icon icon-book"></i><span>{{$certificate->degree}}</span></li>
                                                                        <li><i class="icon icon-calendar"></i><span>From: {{$certificate->from_date}}</span></li>
                                                                        <li><i class="icon icon-calendar"></i><span>To: {{$certificate->to_date}}</span></li>
                                                                    </ul>
                                                                    @endforeach
                                                                @endif
															</div>
														</div>
													</div>
												</div>
												<div class="tu-accordion-item">
													<div id="flush-headingOneaa" class="tu-expwrapper" >
														<div class="tu-accordionedu">
															<div class="tu-expinfo">
																<div class="tu-accodion-holder">
																	<h5  class="collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneaa" aria-expanded="false" aria-controls="flush-collapseOneaa">@lang('app.work_experience')</h5>
																</div>
																<i class="icon icon-plus" role="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneaa" aria-expanded="false" aria-controls="flush-collapseOneaa"></i>
															</div>
														</div>
													</div>
													<div id="flush-collapseOneaa" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExampleaa">
														<div class="tu-edubodymain">
															<div class="tu-accordioneduc">
                                                                @if(@$teacher->teacher->experiences)
                                                                    @foreach($teacher->teacher->experiences as $experience)
                                                                    <ul class="tu-branchdetail" style="margin-top: 10px;">
                                                                        <li><i class="icon icon-home"></i><span>{{$experience->company}}</span></li>
                                                                        <li><i class="icon icon-book"></i><span>{{$experience->title}}</span></li>
                                                                        <li><i class="icon icon-calendar"></i><span>From: {{$experience->from_date}}</span></li>
                                                                        <li><i class="icon icon-calendar"></i><span>To: {{$experience->to_date}}</span></li>
                                                                    </ul>
                                                                    @endforeach
                                                                @endif
															</div>
														</div>
													</div>
												</div>
												<div class="tu-accordion-item">
													<div class="collapsed tu-expwrapper">
														<div class="tu-accordionedu">
															<div class="tu-expinfo">
																<div class="tu-accodion-holder">
																	<h5 data-bs-toggle="collapse" data-bs-target="#flush-collapseOneca" aria-expanded="false" aria-controls="flush-collapseOneca">@lang('app.proffesional_certificate')</h5>
																</div>
																<i class="icon icon-plus" role="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneca" aria-expanded="false" aria-controls="flush-collapseOneca"></i>
															</div>
														</div>
													</div>
													<div id="flush-collapseOneca" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExampleaa">
														<div class="tu-edubodymain">
															<div class="tu-accordioneduc">
                                                                @if(@$teacher->teacher->trains)
                                                                    @foreach($teacher->teacher->trains as $train)
                                                                    <ul class="tu-branchdetail" style="margin-top: 10px;">
                                                                        <li><i class="icon icon-home"></i><span>{{$train->instituation}}</span></li>
                                                                        <li><i class="icon icon-book"></i><span>{{$train->subject}}</span></li>
                                                                        <li><i class="icon icon-calendar"></i><span>From: {{$train->from_date}}</span></li>
                                                                        <li><i class="icon icon-calendar"></i><span>To: {{$train->to_date}}</span></li>
                                                                    </ul>
                                                                    @endforeach
                                                                @endif
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="tu-tabswrapper">
                                        <div class="tu-tabstitle">
											<h4>@lang('app.i_can_teach')</h4>
										</div>
                                        <ul class="tu-icanteach">  
                                            <li>
                                                <ul class="tu-serviceslist">
                                                    @if(@$teacher->teacher->topics)
                                                        @foreach($teacher->teacher->topics as $topic)
                                                        <li>
                                                            <a href="#">
                                                                @foreach($topics as $single_topic)
                                                                    @if($single_topic['id'] == $topic->topic_id )
                                                                        {{$single_topic['name']}}, {{$single_topic['parent']}}
                                                                    @endif
                                                                @endforeach
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tu-tabswrapper">
                                        <div class="tu-tabstitle">
											<h4>@lang('app.media')</h4>
										</div>
                                        <iframe style="width: 100%; margin-top: 20px;" height="315" src="https://www.youtube.com/embed/{{@$teacher->teacher->video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
								</div>
								<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="tu-tabswrapper">
                                        <div class="tu-boxtitle">
                                            <h4>@lang('app.reviews') ({{$reviews['count']}})</h4>
                                        </div>
                                        <div class="tu-commentarea">
                                            @foreach($reviews['reviews'] as $review)
                                            <div class="tu-commentlist">
                                                <div class="tu-coomentareaauth">
                                                    <div class="tu-commentright">
                                                        <div class="tu-commentauthor">
                                                            <h6><span>{{$review->user->name}}</span>{{$review->created_at->diffForHumans()}}</h6>
                                                            <div class="tu-listing-location tu-ratingstars">
                                                                <span>{{sprintf('%0.1f', $review->points)}} </span>
                                                                @include('components.star', ['value' => $review->points])
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tu-description">
                                                        <p>{{$review->review}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if(isStudent())
                                    @include('components.add_review', ['user_id' => $teacher->id])
                                    @endif
                                    
								</div>
							</div>
						</div>
                    </div>
                    @if(sizeOf($teacher->teacher->packages) > 0)
                    <div class="col-xl-3">
                        <aside class="tu-asidedetail">
                            <div class="tu-asideinfo text-center">
                                <h6>@lang('app.packages')</h6>
                            </div>

                            
                            @if(@$teacher->teacher->packages)
                            <div class="tu-contactbox">
                                @foreach($teacher->teacher->packages as $package)
                                <div style="margin-bottom: 10px;">
                                    <a href="{{ route('package.show', ['package_id' => $package->id]) }}">
                                        <img src="{{asset('images/' . $package->image)}}" style="width: 100%; height: 150px; object-fit: cover;" />
                                        <label style="text-align: center">{{app()->currentLocale() == 'ar' ? $package->title_ar : $package->title_en}}</label>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </aside>
                    </div>
                    @endif
                </div>
                @else
                    There is no such teacher
                @endif
            </div>
        </section>
	</main>
@endsection
