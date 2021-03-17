<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="TechyDevs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" type="text/css" href="{{asset('upload/images/logo/'. Config::get('siteSetting.favicon'))}}"/>
    <title>@yield('title')</title>
    @yield('metatag') 
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">

    @include('frontend.layouts.style')

    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    	.profileImageBox { position: relative; width: 100%; height: 120px; text-align: center;}
    	.profileImageBox img{border-radius: 50%}
    	.d-user-avater p{text-align: center;}
    	.uploadIcon{position: absolute;bottom: 50%;transform: translate(50%, 35%);right: 50%;opacity: 0;font-size: 25px;color:#1bd43b;}
    	.profileImageBox:hover .uploadIcon{opacity: 1;}
    </style>

    <!-- end inject -->
</head>
<body>
	@include('frontend.layouts.header')

<!-- ================================
    START DASHBOARD AREA
================================= -->
<section class="dashboard-area">
    <div class="dashboard-sidebar">
        <div class="dashboard-nav-trigger">
            <div class="dashboard-nav-trigger-btn">
                <i class="la la-bars"></i> Dashboard Nav
            </div>
        </div>
        <div class="dashboard-nav-container">
            <div class="humburger-menu">
                <div class="humburger-menu-lines side-menu-close"></div><!-- end humburger-menu-lines -->
            </div><!-- end humburger-menu -->

            <div class="d-user-avater" data-toggle="modal" data-target="#user_imageModal">
				<div class="profileImageBox">
					<img style="height: 100%;" src="{{ asset('upload/images/users') }}/{{(Auth::user()->photo) ? Auth::user()->photo : 'defaultprofile.png'}}" class="img-fluid avater" alt="">
					<span class="uploadIcon" ><i class="fa fa-camera"></i></span>
				</div>
				<p>{{Auth::user()->name}}</p>
			</div>
            <div class="side-menu-wrap">
                <ul class="side-menu-ul">
                    <li class="sidenav__item page-active"><a href="dashboard.html"><i class="la la-dashboard"></i> Dashboard</a></li>
                    <li class="sidenav__item"><a href="dashboard-profile.html"><i class="la la-user"></i>My Profile</a></li>
                    <li class="sidenav__item"><a href="dashboard-courses.html"><i class="la la-file-video-o"></i>My Courses</a></li>
                    <li class="sidenav__item"><a href="dashboard-quiz.html"><i class="la la-bolt"></i>Quiz Attempts</a></li>
                    <li class="sidenav__item"><a href="dashboard-bookmark.html"><i class="la la-bookmark"></i>Bookmarks</a></li>
                    <li class="sidenav__item"><a href="dashboard-enrolled-courses.html"><i class="la la-graduation-cap"></i>Enrolled Courses</a></li>
                    <li class="sidenav__item"><a href="dashboard-message.html"><i class="la la-bell"></i>Message <span class="badge badge-info radius-rounded p-1 ml-1">2</span></a></li>
                    <li class="sidenav__item"><a href="dashboard-reviews.html"><i class="la la-star"></i>Reviews</a></li>
                    <li class="sidenav__item"><a href="dashboard-earnings.html"><i class="la la-dollar"></i>Earnings</a></li>
                    <li class="sidenav__item"><a href="dashboard-withdraw.html"><i class="la la-money"></i>Withdraw</a></li>
                    <li class="sidenav__item"><a href="dashboard-purchase-history.html"><i class="la la-shopping-cart"></i>Purchase History</a></li>
                    <li class="sidenav__item"><a href="dashboard-submit-course.html"><i class="la la-plus-circle"></i>Submit Course</a></li>
                    <li class="sidenav__item"><a href="dashboard-settings.html"><i class="la la-cog"></i>Settings</a></li>
                    <li class="sidenav__item"><a href="index.html"><i class="la la-power-off"></i> Logout</a></li>
                    <li class="sidenav__item"><a href="javascript:void(0)" data-toggle="modal" data-target=".account-delete-modal" ><i class="la la-trash"></i> Delete Account</a></li>
                </ul>
            </div><!-- end side-menu-wrap -->
        </div>
    </div><!-- end dashboard-sidebar -->
    <div class="dashboard-content-wrap">

    	@yield('content')

        
    </div><!-- end dashboard-content-wrap -->
</section><!-- end dashboard-area -->
<!-- ================================
    END DASHBOARD AREA
================================= -->

<!--user image Modal -->
<div class="modal fade" id="user_imageModal">
    <div class="modal-dialog">
      <!-- Modal content-->
      	<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Change Profile Image</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>	
			</div>
	        <form action="{{route('changeProfileImage')}}" method="post" enctype="multipart/form-data">
	        	@csrf
		        <div class="modal-body">
		         	<div class="form-group"> 
				        <input data-default-file="{{ asset('upload/images/users') }}/{{(Auth::user()->photo) ? Auth::user()->photo : 'defaultprofile.png'}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif" required="" data-max-file-size="10M"  name="profileImage" id="input-file-events">
				        <i style="color: red;font-size: 12px;">Image Size: 150px*150px</i>
				    </div>
				    @if ($errors->has('profileImage'))
				        <span class="invalid-feedback" role="alert">
				            {{ $errors->first('profileImage') }}
				        </span>
				    @endif
		        </div>
		        <div class="modal-footer">
		          	<button type="submit" class="btn btn-success" >Change Image</button>
		        </div>
	        </form>
      	</div>
    </div>
</div>

<!-- start scroll top -->
<div id="scroll-top">
    <i class="fa fa-angle-up" title="Go top"></i>
</div>
<!-- end scroll top -->

@include('frontend.layouts.js')

   	<script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
       
    });
    </script>
</body>

</html>