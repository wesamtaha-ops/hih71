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
                                    <img src="{{asset('images/' . $teacher->image)}}" alt="image-description" style="height: 200px; width: 200px; object-fit: cover">
                                </figure>
                                <div class="tu-protutorinfo">
                                    <div class="tu-protutordetail">
                                        <div class="tu-productorder-content">
                                            <figure>
                                            <img src="{{asset('images/' . $teacher->image)}}" alt="image-description" style=" object-fit: cover">
                                            </figure>
                                            <div class="tu-product-title">
                                                <h3>{{$teacher->name}}
                                                    <!-- <i class="icon icon-check-circle tu-greenclr" data-tippy-trigger="mouseenter" data-tippy-html="#tu-verifed" data-tippy-interactive="true" data-tippy-placement="top"></i> -->
                                                </h3>
                                                <h5>{{$teacher->teacher->heading_en}}</h5>
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
                                                        @foreach(json_decode($teacher->teacher->teacher_language) as $language)
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
                            <div class="tu-actionbts">
                                <div class="tu-userurl">
                                    <!-- <i class="icon icon-globe"></i>
                                    <a href="javascript:void(0);">www.tutorlinkhere.com/tutor/uk/armando/295548 <i class="icon icon-copy"></i></a> -->
                                </div> 
                                <ul class="tu-profilelinksbtn">
                                    <!-- <li>
                                        <a class="tu-linkheart" href="javascript:void(0);"><i class="icon icon-heart"></i><span>Save</span></a>
                                    </li> -->
                                    <!-- <li><a href="{{route('message.read', ['id' => $teacher->id ])}}" class="tu-secbtn">Let’s talk now</a></li> -->
                                    <li>
                                        <a href="{{route('book.single', ['teacher_id' => $teacher->id ])}}" class="tu-primbtn">Book a tution</a>
                                    </li>
                                </ul>
                            </div>
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
											{{$teacher->teacher->description_en}}
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
                                                                @foreach($teacher->teacher->certificates as $certificate)
                                                                <ul class="tu-branchdetail" style="margin-top: 10px;">
                                                                    <li><i class="icon icon-home"></i><span>{{$certificate->university}}</span></li>
                                                                    <li><i class="icon icon-book"></i><span>{{$certificate->degree}}</span></li>
                                                                    <li><i class="icon icon-calendar"></i><span>From: {{$certificate->from_date}}</span></li>
                                                                    <li><i class="icon icon-calendar"></i><span>To: {{$certificate->to_date}}</span></li>
                                                                </ul>
                                                                @endforeach
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
                                                                @foreach($teacher->teacher->experiences as $experience)
                                                                <ul class="tu-branchdetail" style="margin-top: 10px;">
                                                                    <li><i class="icon icon-home"></i><span>{{$experience->company}}</span></li>
                                                                    <li><i class="icon icon-book"></i><span>{{$experience->title}}</span></li>
                                                                    <li><i class="icon icon-calendar"></i><span>From: {{$experience->from_date}}</span></li>
                                                                    <li><i class="icon icon-calendar"></i><span>To: {{$experience->to_date}}</span></li>
                                                                </ul>
                                                                @endforeach
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
                                                                @foreach($teacher->teacher->trains as $train)
                                                                <ul class="tu-branchdetail" style="margin-top: 10px;">
                                                                    <li><i class="icon icon-home"></i><span>{{$train->instituation}}</span></li>
                                                                    <li><i class="icon icon-book"></i><span>{{$train->subject}}</span></li>
                                                                    <li><i class="icon icon-calendar"></i><span>From: {{$train->from_date}}</span></li>
                                                                    <li><i class="icon icon-calendar"></i><span>To: {{$train->to_date}}</span></li>
                                                                </ul>
                                                                @endforeach
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
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tu-tabswrapper">
                                        <div class="tu-tabstitle">
											<h4>Media gallery</h4>
										</div>
                                        <iframe style="width: 100%; margin-top: 20px;" height="315" src="https://www.youtube.com/embed/{{$teacher->teacher->video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
                                                                <label class="tu-label">Give rating to your review</label>
                                                                <!-- <div class="tu-my-ratingholder">
                                                                    <h6>Good experience</h6>
                                                                    <div id="tu-addreview" class="tu-addreview"></div>
                                                                </div> -->
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
                                                            <!-- <div class="tu-input-counter">
                                                                <span>Characters left:</span>
                                                                <b class="tu_current_comment">500</b>
                                                                /                                        <em class="tu_maximum_comment"> 500</em>
                                                            </div> -->
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
                        
                        <!-- <div class="tu-explore-title">
                            <h3>Explore related tutors</h3>
                        </div>
                        <div class="tu-explore-content row gy-4">
                            <div class="col-12 col-md-6 col-lg-4 col-xl-6 col-xxl-4">
                                <div class="tu-featureitem">
                                    <figure>
                                        <a href="tutor-detail.html"><img src="images/index/qualified/img-04.jpg" alt="image-description"></a>
                                        <span class="tu-featuretag">FEATURED</span>
                                    </figure>
                                    <div class="tu-authorinfo">
                                        <div class="tu-authordetail">
                                            <figure>
                                                <img src="images/index/professionol/img-04.jpg" alt="image-description">
                                            </figure>
                                            <div class="tu-authorname">
                                                <h5><a href="tutor-detail.html"> William Williams</a> <i class="icon icon-check-circle tu-greenclr" data-tippy-trigger="mouseenter" data-tippy-html="#tu-verifed" data-tippy-interactive="true" data-tippy-placement="top"></i></h5>
                                                <span>Nashville, IL</span>
                                            </div>
                                            <ul class="tu-authorlist">
                                                <li>
                                                    <span>Starting from:<em>$1,198.12/hr</em></span>
                                                </li>
                                                <li>
                                                    <span>Mobile:<em>xxx-xxxxx-54</em></span>
                                                </li>
                                                <li>
                                                    <span>Whatsapp:<em>xxx-xxxxx-88</em></span>
                                                </li>
                                                <li>
                                                    <span>Qualification:<em>B.Tech/B.E.</em></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tu-instructors_footer">
                                            <div class="tu-rating">
                                                <i class="fas fa-star"></i>
                                                <h6>5.0</h6>
                                                <span>(57,282)</span>
                                            </div>
                                            <div class="tu-instructors_footer-right">
                                                <a href="javascript:void(0);"><i class="icon icon-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-6 col-xxl-4">
                                <div class="tu-featureitem">
                                    <figure>
                                        <a href="tutor-detail.html"><img src="images/index/qualified/img-02.jpg" alt="image-description"></a>
                                        <span class="tu-featuretag">FEATURED</span>
                                    </figure>
                                    <div class="tu-authorinfo">
                                        <div class="tu-authordetail">
                                            <figure>
                                                <img src="images/index/professionol/img-02.jpg" alt="image-description">
                                            </figure>
                                            <div class="tu-authorname">
                                                <h5><a href="tutor-detail.html">Gwendolyn Parker</a> <i class="icon icon-check-circle tu-greenclr" data-tippy-trigger="mouseenter" data-tippy-html="#tu-verifed" data-tippy-interactive="true" data-tippy-placement="top"></i></h5>
                                                <span>Las Vegas, TN</span>
                                            </div>
                                            <ul class="tu-authorlist">
                                                <li>
                                                    <span>Starting from:<em>$1,385.10/hr</em></span>
                                                </li>
                                                <li>
                                                    <span>Mobile:<em>xxx-xxxxx-11</em></span>
                                                </li>
                                                <li>
                                                    <span>Whatsapp:<em>xxx-xxxxx-80</em></span>
                                                </li>
                                                <li>
                                                    <span>Qualification:<em>B.Tech/B.E.</em></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tu-instructors_footer">
                                            <div class="tu-rating">
                                                <i class="fas fa-star"></i>
                                                <h6>5.0</h6>
                                                <span>(38,494)</span>
                                            </div>
                                            <div class="tu-instructors_footer-right">
                                                <a href="javascript:void(0);"><i class="icon icon-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-6 col-xxl-4">
                                <div class="tu-featureitem">
                                    <figure>
                                        <a href="tutor-detail.html"><img src="images/index/qualified/img-01.jpg" alt="image-description"></a>
                                        <span class="tu-featuretag">FEATURED</span>
                                    </figure>
                                    <div class="tu-authorinfo">
                                        <div class="tu-authordetail">
                                            <figure>
                                                <img src="images/index/professionol/img-01.jpg" alt="image-description">
                                            </figure>
                                            <div class="tu-authorname">
                                                <h5><a href="tutor-detail.html"> Dwayne Garrett</a> <i class="icon icon-check-circle tu-greenclr" data-tippy-trigger="mouseenter" data-tippy-html="#tu-verifed" data-tippy-interactive="true" data-tippy-placement="top"></i></h5>
                                                <span>Arlington, TN</span>
                                            </div>
                                            <ul class="tu-authorlist">
                                                <li>
                                                    <span>Starting from:<em>$893.30/hr</em></span>
                                                </li>
                                                <li>
                                                    <span>Mobile:<em>xxx-xxxxx-33</em></span>
                                                </li>
                                                <li>
                                                    <span>Whatsapp:<em>xxx-xxxxx-11</em></span>
                                                </li>
                                                <li>
                                                    <span>Qualification:<em>B.Tech/B.E.</em></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tu-instructors_footer">
                                            <div class="tu-rating">
                                                <i class="fas fa-star"></i>
                                                <h6>5.0</h6>
                                                <span>(4,448)</span>
                                            </div>
                                            <div class="tu-instructors_footer-right">
                                                <a href="javascript:void(0);"><i class="icon icon-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="col-xl-4 col-xxl-3">
                        <aside class="tu-asidedetail">
                            <div class="tu-asideinfo text-center">
                                <h6>My Packages</h6>
                            </div>
                            @if(@$teacher->teacher->packages)
                            <div class="tu-contactbox">
                                <h6 style="margin-bottom: 20px;">Packages</h6>
                                <table class="table">
                                    <tr>
                                        <td style="display: flex; justify-content: space-around; padding: 0px;">
                                            <label style="text-decoration: line-through; margin: 0px;">102$</label>
                                            <label style="color: red; margin: 0px;"> 10$ discount</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="display: flex; justify-content: space-around; padding: 0px;">
                                            <label style="margin: 0px">16 - 24 hours</label>
                                            <label style="margin: 0px"> 91.4$/h</label>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table">
                                    <tr>
                                        <td style="display: flex; justify-content: space-around; padding: 0px;">
                                            <label style="text-decoration: line-through; margin: 0px;">102$</label>
                                            <label style="color: red; margin: 0px;"> 10$ discount</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="display: flex; justify-content: space-around; padding: 0px;">
                                            <label style="margin: 0px">16 - 24 hours</label>
                                            <label style="margin: 0px"> 91.4$/h</label>
                                        </td>
                                    </tr>
                                </table>
<!--                                 
                                <ul class="tu-listinfo">
                                        @foreach(json_decode($teacher->teacher->packages) as $package)
                                        <li style="flex-direction: column; align-items: flex-start; width: 100%">
                                            <h6> <label class="fa fa-clock"></label> {{$package->from}} - {{$package->to}}  {{__('hr')}}</h6>
                                            <h6> <label class="fa-solid fa-money-check"></label> {{$package->fee}}</h6>
                                        </li>
                                        @endforeach
                                </ul> -->
                            </div>
                            @endif
                            <div class="tu-unlockfeature text-center">
                                <!-- <h6>
                                    Click the button below to buy a package & unlock the contact details
                                </h6>
                                <a href="package.html" class="tu-primbtn tu-btngreen"><span>Unlock feature</span><i class="icon icon-lock"></i></a> -->
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
	</main>
@endsection