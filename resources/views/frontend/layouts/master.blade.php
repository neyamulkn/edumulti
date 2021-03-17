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

</head>
<body>

	@include('frontend.layouts.header')

	@yield('content')

	@include('frontend.layouts.footer')

	@if(!Auth::check())
	<!-- Log In Modal -->
	<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
			<div class="modal-content" id="registermodal">
				
				<div class="modal-body">
					<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></span>
					<h4 class="modal-header-title">Log In</h4>

					<div class="login-form">
						<form action="{{route('login')}}" data-parsley-validate method="post">
							@csrf
							<div class="form-group">
								
								<input type="text" type="text" name="emailOrMobile" value="@if(Cookie::has('emailOrMobile')){{Cookie::get('emailOrMobile')}}@else{{old('emailOrMobile')}}@endif" placeholder="Enter Email or Mobile Number " id="input-email" required="" data-parsley-required-message = "Email or Mobile number is required" class="form-control">
							</div>
							
							<div class="form-group">
								
								<input type="password" class="form-control" value="@if(Cookie::has('password')){{Cookie::get('password')}}@else{{old('password')}}@endif" required="" name="password" value="" placeholder="Password" id="input-password" data-parsley-required-message = "Password is required">
							</div>
							
							<div class="form-group">
								<button type="submit" class="btn btn-success btn-md full-width pop-login">Login</button>
							</div>
						
						</form>
					</div>
					
					<div class="social-login mb-3">
						<ul>
							<li>
								<input id="reg" class="checkbox-custom" name="reg" type="checkbox">
								<label for="reg" class="checkbox-custom-label">Save Password</label>
							</li>
							<li><a href="#" class="theme-cl">Forget Password?</a></li>
						</ul>
					</div>
					
					<div class="text-center">
						<p class="mt-2">Haven't Any Account? <a data-dismiss="modal" data-toggle="modal" data-target="#signup" href="#" class="link">Click here</a></p>
					</div>
					<div id="column-login">
                        <div class="social_login pull-right" id="so_sociallogin">
                          <a href="{{route('social.login', 'facebook')}}" class="btn btn-social-icon btn-sm btn-facebook"><i class="ti-facebook" aria-hidden="true"></i></a>
                         <!--  <a href="#" class="btn btn-social-icon btn-sm btn-twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></a> -->
                          <a href="{{route('social.login', 'google')}}" class="btn btn-social-icon btn-sm btn-google-plus"><i class="ti-google" aria-hidden="true"></i></a>
                          <!-- <a href="#" class="btn btn-social-icon btn-sm btn-linkdin"><i class="fa fa-linkedin fa-fw" aria-hidden="true"></i></a> -->
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Modal -->

	<!-- Sign Up Modal -->
	<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
			<div class="modal-content" id="sign-up">
				
				<div class="modal-body">
					<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></span>
					<h4 class="modal-header-title">Sign Up</h4>
					<div class="login-form">
						<form data-parsley-validate action="{{route('register')}}" method="post">
							@csrf
							<div class="form-group">
								<label class="control-label required" for="mobile">Name</label>
								<input type="text" required name="name" value="{{old('name')}}" placeholder="Enter Name" data-parsley-required-message = "Name is required" id="input-email" class="form-control">
                                @if ($errors->has('name'))
                                    <span class="error" role="alert">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
							</div>
							
							<div class="form-group">
								<label class="control-label required" for="mobile">Mobile Number</label>
								<input type="text" required name="mobile" value="{{old('mobile')}}" pattern="/(01)\d{9}/" minlength="11" placeholder="Enter Mobile Number" id="mobile" data-parsley-required-message = "Mobile number is required" class="form-control">
                              @if ($errors->has('mobile'))
                                    <span class="error" role="alert">
                                        {{ $errors->first('mobile') }}
                                    </span>
                                @endif
							</div>
							<div class="form-group">
								 <label class="control-label" for="email">Email Address (optional)</label>
								 <input type="email" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}"  name="email" value="{{old('email')}}" placeholder="Enter Email Address" id="email" class="form-control">
                              @if ($errors->has('email'))
                                    <span class="error" role="alert">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
							</div>
							
							<div class="form-group">
								<label class="control-label required" for="password">Password</label>
								<input type="password" name="password" placeholder="Password" required id="password" data-parsley-required-message = "Password is required" minlength="6" class="form-control">
                                @if ($errors->has('password'))
                                    <span class="error" role="alert">
                                       {{ $errors->first('password') }}
                                    </span>
                                @endif
							</div>

							
							<div class="form-group">
								<button type="submit" class="btn btn-success btn-md full-width pop-login">Sign Up</button>
							</div>
						
						</form>
					</div>
					<div class="text-center">
						<p class="mt-3"><i class="ti-user mr-1"></i>Already Have An Account? <a href="#" data-toggle="modal" data-target="#login" data-dismiss="modal" class="link">Go For LogIn</a></p>
					</div>
					<div id="column-login">
                        <div class="social_login pull-right" id="so_sociallogin">
                          <a href="{{route('social.login', 'facebook')}}" class="btn btn-social-icon btn-sm btn-facebook"><i class="ti-facebook" aria-hidden="true"></i></a>
                         <!--  <a href="#" class="btn btn-social-icon btn-sm btn-twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></a> -->
                          <a href="{{route('social.login', 'google')}}" class="btn btn-social-icon btn-sm btn-google-plus"><i class="ti-google" aria-hidden="true"></i></a>
                          <!-- <a href="#" class="btn btn-social-icon btn-sm btn-linkdin"><i class="fa fa-linkedin fa-fw" aria-hidden="true"></i></a> -->
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Modal -->
	@endif

	<!-- start scroll top -->
	<div id="scroll-top"> <i class="fa fa-angle-up" title="Go top"></i> </div>
	<!-- end scroll top -->

	@include('frontend.layouts.js')
	
	{!! Toastr::message() !!}
	<script>
	    @if($errors->any())
	    @foreach($errors->all() as $error)
	    toastr.error("{{ $error }}");
	    @endforeach
	    @endif
	</script>

	</body>
</html>