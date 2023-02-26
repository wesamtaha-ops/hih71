@extends('layouts.app')

@section('content')
<main class="tu-main tu-bgmain">
        <section class="tu-main-section">
            <div class="container">
                @if($teacher)
                <div class="row gy-4">
                    <div class="col-xl-8 col-xxl-9">
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
                                                <h5>{{@$teacher->teacher->heading_en}}</h5>
                                            </div>
                                        </div>
                                        <ul class="tu-tutorreview">
                                            <li>
                                                <span><i class="fa fa-star tu-coloryellow"> <em>{{sprintf('%0.1f', $reviews['avg'])}}<span>/5.0</span></em> </i>  <em>({{$reviews['count']}})</em></span>
                                            </li>
                                        </ul>	
                                        <div class="tu-detailitem">
                                            <h6>Languages I know</h6>
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
                                        <a href="{{route('book.single', ['teacher_id' => @$teacher->id ])}}" class="tu-primbtn">Book a tution</a>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="tu-detailstabs">
							<ul class="nav nav-tabs tu-nav-tabs" id="myTab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="icon icon-home"></i><span>Introduction</span></button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="icon icon-message-circle"></i><span>Reviews</span></button>
								</li>
							</ul>
							<div class="tab-content tu-tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="tu-tabswrapper">
                                        <div class="tu-tabstitle">
											<h4>A brief introduction</h4>
										</div>
                                        <div class="tu-description">
											{{@$teacher->teacher->description_en}}
										</div>
                                    </div>
                                    <div class="tu-tabswrapper">
                                        <div class="tu-tabstitle">
											<h4>Education</h4>
										</div>

                                        <div class="accordion tu-accordionedu" id="accordionFlushExampleaa">
											<div id="tu-edusortable" class="tu-edusortable">
												<div class="tu-accordion-item">
													<div class="tu-expwrapper">
														<div class="tu-accordionedu">
															<div class="tu-expinfo">
																<div class="tu-accodion-holder">
																	<h5 class="collapsed"   data-bs-toggle="collapse" data-bs-target="#flush-collapseOneba" aria-expanded="true" aria-controls="flush-collapseOneba">Higher Education</h5>
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
																	<h5  class="collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneaa" aria-expanded="false" aria-controls="flush-collapseOneaa">Work Experience</h5>
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
																	<h5 data-bs-toggle="collapse" data-bs-target="#flush-collapseOneca" aria-expanded="false" aria-controls="flush-collapseOneca">Professional Certificates</h5>
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
											<h4>I can teach</h4>
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
											<h4>Media gallery</h4>
										</div>
                                        <iframe style="width: 100%; margin-top: 20px;" height="315" src="https://www.youtube.com/embed/{{@$teacher->teacher->video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
								</div>
								<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="tu-tabswrapper">
                                        <div class="tu-boxtitle">
                                            <h4>Reviews ({{$reviews['count']}})</h4>
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
                                                                <span class="tu-stars tu-sm-stars">
                                                                    <span></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tu-description">
                                                        <p>{{$review->review}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="show-more">
                                                <a href="javascript:void(0);" class="tu-readmorebtn tu-show_more">Show all</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tu-tabswrapper">
                                        <div class="tu-boxtitle">
                                            <h4>Add your review</h4>
                                        </div>
                                        <form class="tu-themeform" id="tu-reviews-form">
                                            <fieldset>
                                                <div class="tu-themeform__wrap">
                                                    <div class="form-group-wrap">
                                                        <div class="form-group">
                                                            <div class="tu-reviews">

                                                                <div class="tu-listing-location tu-ratingstars">
                                                                    Time     
                                                                    <div>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="tu-listing-location tu-ratingstars">
                                                                    Quality     
                                                                    <div>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="tu-listing-location tu-ratingstars">
                                                                    Easy to get     
                                                                    <div>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                        <i class="fa fa-star tu-coloryellow rating-start"></i>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="form-group tu-message-text">
                                                            <label class="tu-label">Review details</label>
                                                            <div class="tu-placeholderholder">
                                                                <textarea class="form-control tu-textarea" id="tu-reviews-content" name="reviews_content" required="" placeholder="Enter description" maxlength="500"></textarea>
                                                                <div class="tu-placeholder">
                                                                    <span>Enter description</span>
                                                                </div>
                                                            </div>
                                                        </div>
                        
                                                        <div class="form-group tu-formspacebtw">
                                                            <div class="tu-check">
                                                                <input type="hidden" name="termsconditions" value="">
                                                                <input type="checkbox" id="termsconditions" name="termsconditions">
                                                                <label for="termsconditions"><span>I have read and agree to all <a href="javascript:void(0);">Terms &amp; conditions</a></span></label>
                                                            </div>
                                                            <a href="tutor-detail.html" class="tu-primbtn-lg tu-submit-reviews" data-profile_id=""><span>Submit</span><i class="icon icon-chevron-right"></i></a>
                                                            <input type="hidden" name="profile_id" value="584">
                                                            <input type="hidden" name="user_id" value="691">
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-4 col-xxl-3">
                        <aside class="tu-asidedetail">
                            <div class="tu-asideinfo text-center">
                                <h6>My Packages</h6>
                            </div>

                            
                            @if(@$teacher->teacher->packages)
                            <div class="tu-contactbox">
                                @foreach($teacher->teacher->packages as $package)
                                <div style="margin-bottom: 10px;">
                                    <a href="{{ route('package.show', ['package_id' => $package->id]) }}">
                                        <img src="{{asset('images/' . $package->image)}}" style="width: 100%; height: 150px; object-fit: cover;" />
                                        <label style="text-align: center">{{$package->title_en}}</label>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </aside>
                    </div>
                </div>
                @else
                    There is no such teacher
                @endif
            </div>
        </section>
	</main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.rating-start').click(function () {
                $(this).prevAll().removeClass('tu-colororange tu-coloryellow').addClass('tu-coloryellow');
                $(this).nextAll().removeClass('tu-colororange tu-coloryellow').addClass('tu-colororange');
                $(this).removeClass('tu-colororange tu-coloryellow').addClass('tu-coloryellow');
            })
        })
    </script>
@endpush