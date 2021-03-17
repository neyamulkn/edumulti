@extends('frontend.layouts.master')
@section('title', 'About Us')
@section('content')
		<section class="page-title">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						
						<div class="breadcrumbs-wrap">
							<h1 class="breadcrumb-title">Who We are?</h1>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">About Us</li>
								</ol>
							</nav>
						</div>
						
					</div>
				</div>
			</div>
		</section>
		<!-- ============================ Page Title End ================================== -->	
		
		<!-- ========================== About Facts List Section =============================== -->
		<section class="pt-0">
			<div class="container">
				
				<div class="row align-items-center">
				
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="list_facts_wrap">
							<div class="sec-heading mb-3">
								<h2>Know about <span class="theme-cl">e-Learn</span> learning platform</h2>
							</div>
							<div class="list_facts">
								<div class="list_facts_icons"><i class="ti-desktop"></i></div>
								<div class="list_facts_caption">
									<h4>Nemo enim ipsam voluptatem quia.</h4>
									<p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure</p>
								</div>
							</div>
							<div class="list_facts">
								<div class="list_facts_icons"><i class="ti-heart"></i></div>
								<div class="list_facts_caption">
									<h4>Nemo enim ipsam voluptatem quia.</h4>
									<p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure</p>
								</div>
							</div>
							<div class="list_facts">
								<div class="list_facts_icons"><i class="ti-harddrives"></i></div>
								<div class="list_facts_caption">
									<h4>Nemo enim ipsam voluptatem quia.</h4>
									<p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure</p>
								</div>
							</div>
							
						</div>
						<a href="#" class="btn btn-modern">Know More<span><i class="ti-arrow-right"></i></span></a>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="list_facts_wrap_img">
						
							<img src="{{ asset('frontend') }}/img/edu_2.png" class="img-fluid" alt="" />
							
						</div>
					</div>

				</div>
				
			</div>
		</section>
		<!-- ========================== About Facts List Section =============================== -->
		
		<!-- ============================ Featured Instructor Start ================================== -->
		<section class="bg-light">
			<div class="container">
			
				<div class="row justify-content-center">
					<div class="col-lg-5 col-md-6 col-sm-12">
						<div class="sec-heading center">
							<p>Meet Instructors</p>
							<h2><span class="theme-cl">Top & Famous</span> Instructor in Your City</h2>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
					
						<div class="four_slide-dots articles arrow_middle">
							
							<!-- Single Slide -->
							<div class="singles_items">
								<div class="instructor_wrap">
									<div class="instructor_thumb">
										<a href="instructor-detail.html"><img src="{{ asset('frontend') }}/img/user-1.jpg" class="img-fluid" alt=""></a>
									</div>
									<div class="instructor_caption">
										<h4><a href="instructor-detail.html">Daniel Diwansker</a></h4>
										<span>Web Designer</span>
										<ul>
											<li><a href="#" class="cl-fb"><i class="ti-facebook"></i></a></li>
											<li><a href="#" class="cl-twitter"><i class="ti-twitter"></i></a></li>
											<li><a href="#" class="cl-linked"><i class="ti-linkedin"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							
							<!-- Single Slide -->
							<div class="singles_items">
								<div class="instructor_wrap">
									<div class="instructor_thumb">
										<a href="instructor-detail.html"><img src="{{ asset('frontend') }}/img/user-5.jpg" class="img-fluid" alt=""></a>
									</div>
									<div class="instructor_caption">
										<h4><a href="instructor-detail.html">Adnan Morshed</a></h4>
										<span>Apps Developer</span>
										<ul>
											<li><a href="#" class="cl-fb"><i class="ti-facebook"></i></a></li>
											<li><a href="#" class="cl-twitter"><i class="ti-twitter"></i></a></li>
											<li><a href="#" class="cl-linked"><i class="ti-linkedin"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							
							<!-- Single Slide -->
							<div class="singles_items">
								<div class="instructor_wrap">
									<div class="instructor_thumb">
										<a href="instructor-detail.html"><img src="{{ asset('frontend') }}/img/user-3.jpg" class="img-fluid" alt=""></a>
									</div>
									<div class="instructor_caption">
										<h4><a href="instructor-detail.html">Neyamul</a></h4>
										<span>Web Developer</span>
										<ul>
											<li><a href="#" class="cl-fb"><i class="ti-facebook"></i></a></li>
											<li><a href="#" class="cl-twitter"><i class="ti-twitter"></i></a></li>
											<li><a href="#" class="cl-linked"><i class="ti-linkedin"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							
							<!-- Single Slide -->
							<div class="singles_items">
								<div class="instructor_wrap">
									<div class="instructor_thumb">
										<a href="instructor-detail.html"><img src="{{ asset('frontend') }}/img/user-4.jpg" class="img-fluid" alt=""></a>
									</div>
									<div class="instructor_caption">
										<h4><a href="instructor-detail.html">Ragini Singh</a></h4>
										<span>Business Executing</span>
										<ul>
											<li><a href="#" class="cl-fb"><i class="ti-facebook"></i></a></li>
											<li><a href="#" class="cl-twitter"><i class="ti-twitter"></i></a></li>
											<li><a href="#" class="cl-linked"><i class="ti-linkedin"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							
							<!-- Single Slide -->
							<div class="singles_items">
								<div class="instructor_wrap">
									<div class="instructor_thumb">
										<a href="instructor-detail.html"><img src="{{ asset('frontend') }}/img/user-5.jpg" class="img-fluid" alt=""></a>
									</div>
									<div class="instructor_caption">
										<h4><a href="instructor-detail.html">Daniel Wilson</a></h4>
										<span>HR Manager</span>
										<ul>
											<li><a href="#" class="cl-fb"><i class="ti-facebook"></i></a></li>
											<li><a href="#" class="cl-twitter"><i class="ti-twitter"></i></a></li>
											<li><a href="#" class="cl-linked"><i class="ti-linkedin"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
						
						</div>
					
					</div>
				</div>
				
			</div>
		</section>
		<!-- ============================ Featured Instructor End ================================== -->
		
		<!-- ============================ Testimonial Start ================================== -->
		<section style="background:url({{ asset('frontend') }}/img/testimonial.png)">
			<div class="container">
			
				<div class="row justify-content-center">
					<div class="col-lg-5 col-md-6 col-sm-12">
						<div class="sec-heading center">
							<p>What People Say?</p>
							<h2><span class="theme-cl">Reviews</span> By Our Success & Top Students</h2>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<div id="testimonials_style" class="slick-carousel-3 arrow_middle">
							<div class="testimonial-detail">
								<div class="client-detail-box">
									<div class="pic">
										<img src="{{ asset('frontend') }}/img/user-1.jpg" alt="">
									</div>
									<div class="client-detail">
										<h3 class="testimonial-title">Adam Alloriam</h3>
										<span class="post">Web Developer</span>
									</div>
								</div>
								<p class="description">
									" Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem commodi eligendi facilis itaque minus non odio, quaerat ullam eligendi facilis itaque minus non odio, quaerat ullam unde  unde voluptatum Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem commodi eligendi. "
								</p>
							</div>

							<div class="testimonial-detail">
								<div class="client-detail-box">
									<div class="pic">
										<img src="{{ asset('frontend') }}/img/user-2.jpg" alt="">
									</div>
									<div class="client-detail">
										<h3 class="testimonial-title">Illa Millia</h3>
										<span class="post">Project Manager</span>
									</div>
								</div>
								<p class="description">
									" Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem commodi eligendi facilis itaque minus non odio, quaerat ullam unde voluptatum eligendi facilis itaque minus non odio, quaerat ullam unde  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem commodi eligendi."
								</p>
							</div>
							
							<div class="testimonial-detail">
								<div class="client-detail-box">
									<div class="pic">
										<img src="{{ asset('frontend') }}/img/user-3.jpg" alt="">
									</div>
									<div class="client-detail">
										<h3 class="testimonial-title">Rout Millance</h3>
										<span class="post">Web Designer</span>
									</div>
								</div>
								<p class="description">
									" Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem commodi eligendi facilis itaque minus non odio, quaerat ullam unde voluptatum Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem commodi eligendi."
								</p>
							</div>
							
							<div class="testimonial-detail">
								<div class="client-detail-box">
									<div class="pic">
										<img src="{{ asset('frontend') }}/img/user-4.jpg" alt="">
									</div>
									<div class="client-detail">
										<h3 class="testimonial-title">williamson</h3>
										<span class="post">Web Developer</span>
									</div>
								</div>
								<p class="description">
									" Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem commodi eligendi facilis itaque minus non odio, quaerat ullam unde voluptatum eligendi facilis itaque minus non odio, quaerat ullam unde ? "
								</p>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</section>	
		<!-- ============================ Testimonial End ================================== -->
		
		<!-- ============================== Start Newsletter ================================== -->
		<section class="newsletter theme-bg inverse-theme">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-7 col-md-8 col-sm-12">
						<div class="text-center">
							<h2>Join Thousand of Happy Students!</h2>
							<p>Subscribe our newsletter & get latest news and updation!</p>
							<form class="sup-form">
								<input type="email" class="form-control sigmup-me" placeholder="Your Email Address" required="required">
								<input type="submit" class="btn btn-theme" value="Get Started">
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ================================= End Newsletter =============================== -->
@endsection