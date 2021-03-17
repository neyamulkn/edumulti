@extends('frontend.layouts.master')
@section('title', $course_details->title)

@section('css')
<style type="text/css">
	#lessonlist i{padding-right: 5px;color: #8c8989;}
</style>
@endsection
@section('content')

	<!-- ============================ Course Detail ================================== -->
	<section class="bg-light">
		<div class="container">
			<div class="row">
			
				<div class="col-lg-8 col-md-8">
					<div class="inline_edu_wrap">
						<div class="inline_edu_first">
							<h4>{{$course_details->title}}</h4>
							<ul class="edu_inline_info">
								<li><i class="ti-calendar"></i>{{Carbon\Carbon::parse($course_details->created_at)->format(Config::get('siteSetting.date_format'))}}</li>
								<li><i class="ti-control-forward"></i>{{count($course_details->course_lessons)}} Lessons</li>
								<li><i class="ti-eye"></i>{{ $course_details->views }} Student Views</li>
								<li><i class="ti-user"></i>{{count($course_details->course_enroll)}} Students Enrolled</li>
							</ul>
						</div>	
						<!-- <div class="inline_edu_last">
							<h4 class="edu_price">$49.00</h4><a href="#" class="btn btn-theme enroll-btn">Buy Now<i class="ti-angle-right"></i></a>
						</div> -->
					</div>
					<!-- Overview -->
					<div class="edu_wraper border">
						<h4 class="edu_title">Course Overview</h4>
						{!! $course_details->description !!}
						
					</div>
					@if(count($course_details->course_sections)>0)
					<div class="edu_wraper border">
						<h4 class="edu_title">Course content</h4>
						<div id="lessonlist" class="accordion shadow circullum">
							@foreach($course_details->course_sections as $secIndex => $course_details_section)
							<!-- Lesson {{$secIndex}} -->
							<div class="card">
							  <div id="sectionHeading{{$course_details_section->id}}" class="card-header bg-white shadow-sm border-0">
								<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#sectionBox{{$course_details_section->id}}" aria-expanded="{{($secIndex == 0) ? 'true' : 'false'}}" aria-controls="sectionBox{{$course_details_section->id}}" class="@if($secIndex != 0) collapsed @endif d-block position-relative text-dark collapsible-link py-2">{{ $course_details_section->section_title }}</a></h6>
							  </div>
							  <div id="sectionBox{{$course_details_section->id}}" aria-labelledby="sectionHeading{{$course_details_section->id}}" data-parent="#lessonlist" class="collapse @if($secIndex == 0) show @endif">
								<div class="card-body pl-3 pr-3">
									<ul class="lectures_lists">
										
										@if(count($course_details_section->courseLessons)>0)
										@foreach($course_details_section->courseLessons as $lessonIndex => $lesson)
										@php
											if($lesson->content_type == 'video' || $lesson->content_type == 'youtube' || $lesson->content_type == 'vimeo')
											{ $icon = 'fa-video'; }
											elseif($lesson->content_type == 'audio')
											{ $icon = 'fa-file-audio'; }
											elseif($lesson->content_type == 'image')
											{ $icon = 'fa-image'; }
											else{ $icon = 'fa-file-alt'; }
										@endphp
										<li @if($lesson->free_lesson || $course_details->price_type != 'paid') class="video_pop" data-toggle="modal" data-type="{{$lesson->content_type}}" data-src="{{($lesson->content) ? asset('upload/lessons/'.$lesson->content) : $lesson->content_link}}" data-target="#video_pop"  @else class="unview" @endif ><i class="fa {{$icon}}"> </i> {{ $lesson->lesson_title }}</li>
										@endforeach
										@else <p>No Lesson</p> @endif
									</ul>
								</div>
							  </div>
							</div>
							@endforeach
						</div>
					</div>
					@endif
					
					<!-- Reviews -->
					<div class="rating-overview border">
						<div class="rating-overview-box">
							<span class="rating-overview-box-total">4.2</span>
							<span class="rating-overview-box-percent">out of 5.0</span>
							<div class="star-rating" data-rating="5"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i>
							</div>
						</div>

						<div class="rating-bars">
							<div class="rating-bars-item">
								<span class="rating-bars-name">5 Star</span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating high" data-rating="4.7">
										<span class="rating-bars-rating-inner" style="width: 85%;"></span>
									</span>
									<strong>85%</strong>
								</span>
							</div>
							<div class="rating-bars-item">
								<span class="rating-bars-name">4 Star</span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating good" data-rating="3.9">
										<span class="rating-bars-rating-inner" style="width: 75%;"></span>
									</span>
									<strong>75%</strong>
								</span>
							</div>
							<div class="rating-bars-item">
								<span class="rating-bars-name">3 Star</span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating mid" data-rating="3.2">
										<span class="rating-bars-rating-inner" style="width: 52.2%;"></span>
									</span>
									<strong>53%</strong>
								</span>
							</div><div class="rating-bars-item">
								<span class="rating-bars-name">2 Star</span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating mid" data-rating="3.2">
										<span class="rating-bars-rating-inner" style="width: 52.2%;"></span>
									</span>
									<strong>53%</strong>
								</span>
							</div>
							<div class="rating-bars-item">
								<span class="rating-bars-name">1 Star</span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating poor" data-rating="2.0">
										<span class="rating-bars-rating-inner" style="width:20%;"></span>
									</span>
									<strong>20%</strong>
								</span>
							</div>
						</div>
					</div>
					
					<!-- Reviews -->
					<div class="list-single-main-item fl-wrap border">
						<div class="list-single-main-item-title fl-wrap">
							<h3>Item Reviews -  <span> 1 </span></h3>
						</div>
						<div class="reviews-comments-wrap">
						
							<!-- reviews-comments-item -->  
							<div class="reviews-comments-item">
								<div class="review-comments-avatar">
									<img src="{{ asset('frontend') }}/img/user-3.jpg" class="img-fluid" alt=""> 
								</div>
								<div class="reviews-comments-item-text">
									<h4><a href="#">Neyamul kobir</a><span class="reviews-comments-item-date"><i class="ti-calendar theme-cl"></i>10 Nov 2020</span></h4>
									
									<div class="listing-rating good" data-starrating2="5"><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star"></i> <span class="review-count">4.2</span> </div>
									<div class="clearfix"></div>
									<p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat blandit enim. Sem felis, ullamcorper vel aliquam non, varius eget justo. Duis quis nunc tellus sollicitudin mauris. "</p>
									<div class="pull-left reviews-reaction">
										<a href="#" class="comment-like active"><i class="ti-thumb-up"></i> 12</a>
										<a href="#" class="comment-dislike active"><i class="ti-thumb-down"></i> 1</a>
										<a href="#" class="comment-love active"><i class="ti-heart"></i> 07</a>
									</div>
								</div>
							</div>
							<!--reviews-comments-item end-->
							
						</div>
					</div>
					
					<!-- Submit Reviews -->
					<div class="edu_wraper border">
						<h4 class="edu_title">Submit Reviews</h4>
						<div class="review-form-box form-submit">
							<form>
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="form-group">
											<label>Name</label>
											<input class="form-control" type="text" placeholder="Your Name">
										</div>
									</div>
									
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="form-group">
											<label>Email</label>
											<input class="form-control" type="email" placeholder="Your Email">
										</div>
									</div>
									
									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="form-group">
											<label>Review</label>
											<textarea class="form-control ht-140" placeholder="Review"></textarea>
										</div>
									</div>
									
									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="form-group">
											<button type="submit" class="btn btn-theme">Submit Review</button>
										</div>
									</div>
									
								</div>
							</form>
						</div>
					</div>
					
				</div>
				
				<div class="col-lg-4 col-md-4">
						
					<!-- Course info -->
					<div class="ed_view_box style_3">
					
						<div class="property_video sm">
							<div class="thumb">
								<img class="pro_img img-fluid w100" src="{{asset('upload/images/course/'. $course_details->thumbnail_image)}}" alt="7.jpg">
								@if($course_details->video_provider)
								<div class="overlay_icon">
									<div class="bb-video-box">
										@php
											$content_path = ($course_details->video_provider == 'video') ? asset('upload/videos/course') : null;
										@endphp
										<div class="bb-video-box-inner video_pop" data-toggle="modal" data-type="{{$course_details->video_provider}}" data-src="{{$content_path.$course_details->overview_video}}" data-target="#video_pop">
											<div class="bb-video-box-innerup">
												<a class="theme-cl"><i class="ti-control-play"></i></a>
											</div>
										</div>
									</div>
								</div>
								@endif
							</div>
						</div>
						@php 

						$price = $course_details->price;
						$discount = $course_details->discount;
						if($discount){
							if($course_details->discount_type == '%') {
							$price = $price - ($course_details->discount * $price) / 100;
        					}else{
        					$price = $price - $course_details->discount;
        					}
        				}
    					@endphp
						<div class="ed_view_price pl-4">
							<span>Price</span>
							<h2 class="theme-cl">{{Config::get('siteSetting.currency_symble')}}{{$price}}
							@if($discount)<strike style="font-size: 15px;color: #a5a3a3">{{Config::get('siteSetting.currency_symble')}}{{$course_details->price}}</strike>@endif
							</h2>
						</div>
						<div class="edu_wraper border">
							<h4 class="edu_title">Course Features</h4>
							<ul class="edu_list right">
								<li><i class="ti-user"></i>Student Enrolled:<strong>1740</strong></li>
								<li><i class="ti-files"></i>lectures:<strong>10</strong></li>
								<li><i class="ti-game"></i>Quizzes:<strong>4</strong></li>
								<li><i class="ti-time"></i>Duration:<strong>60 hours</strong></li>
								<li><i class="ti-tag"></i>Skill Level:<strong>Beginner</strong></li>
								<li><i class="ti-flag-alt"></i>Language:<strong>{{ $course_details->language }}</strong></li>
								<li><i class="ti-shine"></i>Assessment:<strong>Yes</strong></li>
							</ul>
						</div>
						
						<div class="ed_view_link">
							<a href="{{ route('courseEnrolled', $course_details->slug) }}" class="btn btn-theme enroll-btn">Enroll Now<i class="ti-angle-right"></i></a>
						</div>
						
					</div>
					
				</div>
			
			</div>
		</div>
	</section>
	<!-- ============================ Course Detail ================================== -->
	
	<!-- Video Modal -->
	<div class="modal fade" id="video_pop" tabindex="-1" role="dialog" aria-labelledby="video_pop" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" id="showVideoFrame" role="document">
			
		</div>
	</div>
	<!-- End Video Modal -->
	
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function() {  
    // Gets the video src from the data-src on each button    
    
    $('.video_pop').click(function() {
         
        var videoType = $(this).data( "type" ); 
        var videoSrc = $(this).data( "src" );
       
        $("#video_pop").css("display","block")
        if(videoType == 'video'){
            $('#showVideoFrame').html('<video id="myVideo" width="100%" controls autoplay><source id="video" src="'+ videoSrc+'" type="video/mp4"></video>');
        }
        if(videoType == 'youtube'){
            $('#showVideoFrame').html( '<iframe class="embed-responsive-item" width="100%" height="480" src="'+ videoSrc+'?autoplay=1&rel=0'+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'); 
        }
    });

	$('.modal .close').click(function(){
	 	modal.style.display = "none";
	   $('#showVideoFrame').html('');
	});

    var modal = document.getElementById('video_pop');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
          $('#showVideoFrame').html('');
        }
    }
   
    // stop playing the video when I close the modal
    $('#video_pop').on('hidden.bs.modal', function (e) {
        $('#showVideoFrame').html('');
    });
 
}); 
</script>
@endsection