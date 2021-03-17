@extends('frontend.layouts.master')
@section('content')
	<!-- ============================ Dashboard: My Order Start ================================== -->
	<section class="gray pt-0">
		<div class="container-fluid">
			
			<!-- Row -->
			<div class="row">
			
				<div class="col-lg-3 col-md-3 p-0">
					<?php include('inc/dashboard-navbar.php'); ?>
				</div>	
				
				<div class="col-lg-9 col-md-9 col-sm-12">
					
					<!-- Row -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">All Courses</li>
								</ol>
							</nav>
						</div>
					</div>
					<!-- /Row -->
					
					<!-- Row -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							
							<!-- Course Style 1 For Student -->
							<div class="dashboard_container">
								<div class="dashboard_container_header">
									<div class="dashboard_fl_1">
									<h4>All Courses</h4>
									</div>
									<div class="dashboard_fl_2">
										<ul class="mb0">
											<li class="list-inline-item">
												
											</li>
											<li class="list-inline-item">
												<form class="form-inline my-2 my-lg-0">
													<input class="form-control" type="search" placeholder="Search Courses" aria-label="Search">
													<button class="btn my-2 my-sm-0" type="submit"><i class="ti-search"></i></button>
												</form>
											</li>
										</ul>
									</div>
								</div>
								<div class="dashboard_container_body">
									
									<!-- Single Course -->
									<div class="dashboard_single_course">
										<div class="dashboard_single_course_thumb">
											<img src="{{ asset('frontend') }}/img/co-1.jpg" class="img-fluid" alt="" />
											<div class="dashboard_action">
												<a href="#" class="btn btn-ect">Edit</a>
												<a href="#" class="btn btn-ect">View</a>
											</div>
										</div>
										<div class="dashboard_single_course_caption">
											<div class="dashboard_single_course_head">
												<div class="dashboard_single_course_head_flex">
													<span class="dashboard_instructor">Adam Wilson</span>
													<h4 class="dashboard_course_title">Introduction Web Design with HTML</h4>
													<div class="dashboard_rats">
														<div class="dashboard_rating">
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star"></i>
														</div>
														<span>(40 Reviews)</span>
													</div>
												</div>
												<div class="dc_head_right">
													<h4 class="dc_price_rate theme-cl">$129.00</h4>
												</div>
											</div>
											<div class="dashboard_single_course_des">
												<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
											</div>
											<div class="dashboard_single_course_progress">
												<div class="dashboard_single_course_progress_1">
													<label>82% Completed</label>
													<div class="progress">
														<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="dashboard_single_course_progress_2">
													<ul class="m-0">
														<li class="list-inline-item"><i class="ti-user mr-1"></i>4512 Enrolled</li>
														<li class="list-inline-item"><i class="ti-comment-alt mr-1"></i>112 Comments</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									
									<!-- Single Course -->
									<div class="dashboard_single_course">
										<div class="dashboard_single_course_thumb">
											<img src="{{ asset('frontend') }}/img/co-2.jpg" class="img-fluid" alt="" />
											<div class="dashboard_action">
												<a href="#" class="btn btn-ect">Edit</a>
												<a href="#" class="btn btn-ect">View</a>
											</div>
										</div>
										<div class="dashboard_single_course_caption">
											<div class="dashboard_single_course_head">
												<div class="dashboard_single_course_head_flex">
													<span class="dashboard_instructor">Shaurya Preet</span>
													<h4 class="dashboard_course_title">Introduction Full About Advance PHP</h4>
													<div class="dashboard_rats">
														<div class="dashboard_rating">
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star"></i>
														</div>
														<span>(44 Reviews)</span>
													</div>
												</div>
												<div class="dc_head_right">
													<h4 class="dc_price_rate theme-cl">$249.00</h4>
												</div>
											</div>
											<div class="dashboard_single_course_des">
												<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
											</div>
											<div class="dashboard_single_course_progress">
												<div class="dashboard_single_course_progress_1">
													<label>90% Completed</label>
													<div class="progress">
														<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="dashboard_single_course_progress_2">
													<ul class="m-0">
														<li class="list-inline-item"><i class="ti-user mr-1"></i>5412 Enrolled</li>
														<li class="list-inline-item"><i class="ti-comment-alt mr-1"></i>72 Comments</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									
									<!-- Single Course -->
									<div class="dashboard_single_course">
										<div class="dashboard_single_course_thumb">
											<img src="{{ asset('frontend') }}/img/co-3.jpg" class="img-fluid" alt="" />
											<div class="dashboard_action">
												<a href="#" class="btn btn-ect">Edit</a>
												<a href="#" class="btn btn-ect">View</a>
											</div>
										</div>
										<div class="dashboard_single_course_caption">
											<div class="dashboard_single_course_head">
												<div class="dashboard_single_course_head_flex">
													<span class="dashboard_instructor">Krish Wilson</span>
													<h4 class="dashboard_course_title">Full WordPress Development Package</h4>
													<div class="dashboard_rats">
														<div class="dashboard_rating">
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star"></i>
														</div>
														<span>(57 Reviews)</span>
													</div>
												</div>
												<div class="dc_head_right">
													<h4 class="dc_price_rate theme-cl">$179.00</h4>
												</div>
											</div>
											<div class="dashboard_single_course_des">
												<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
											</div>
											<div class="dashboard_single_course_progress">
												<div class="dashboard_single_course_progress_1">
													<label>95% Completed</label>
													<div class="progress">
														<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="dashboard_single_course_progress_2">
													<ul class="m-0">
														<li class="list-inline-item"><i class="ti-user mr-1"></i>6587 Enrolled</li>
														<li class="list-inline-item"><i class="ti-comment-alt mr-1"></i>365 Comments</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									
									<!-- Single Course -->
									<div class="dashboard_single_course">
										<div class="dashboard_single_course_thumb">
											<img src="{{ asset('frontend') }}/img/co-4.jpg" class="img-fluid" alt="" />
											<div class="dashboard_action">
												<a href="#" class="btn btn-ect">Edit</a>
												<a href="#" class="btn btn-ect">View</a>
											</div>
										</div>
										<div class="dashboard_single_course_caption">
											<div class="dashboard_single_course_head">
												<div class="dashboard_single_course_head_flex">
													<span class="dashboard_instructor">Adam Wilson</span>
													<h4 class="dashboard_course_title">Introduction Magento Advance Code</h4>
													<div class="dashboard_rats">
														<div class="dashboard_rating">
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star filled"></i>
															<i class="ti-star"></i>
														</div>
														<span>(30 Reviews)</span>
													</div>
												</div>
												<div class="dc_head_right">
													<h4 class="dc_price_rate theme-cl">$229.00</h4>
												</div>
											</div>
											<div class="dashboard_single_course_des">
												<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
											</div>
											<div class="dashboard_single_course_progress">
												<div class="dashboard_single_course_progress_1">
													<label>70% Completed</label>
													<div class="progress">
														<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="dashboard_single_course_progress_2">
													<ul class="m-0">
														<li class="list-inline-item"><i class="ti-user mr-1"></i>6582 Enrolled</li>
														<li class="list-inline-item"><i class="ti-comment-alt mr-1"></i>65 Comments</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							
						</div>
					</div>
					<!-- /Row -->
					
				</div>
			
			</div>
			<!-- Row -->
			
		</div>
	</section>
	<!-- ============================ Dashboard: My Order Start End ================================== -->
	
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