@extends('frontend.layouts.master')
@section('content')
<section class="page-title">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="order_success" style="margin: 20px auto">
					<div>
					<i class="fa fa-check-circle" style="font-size: 125px;color: #16a20d;"></i></div>
					<h3>Thanks you for purchase course at {{Config::get('siteSetting.site_name')}}!</h3>
					<p style="padding:0px;margin: 0px;"><a class="btn btn-primary" href="{{route('user.orderHistory')}}">Now Start Lesson</a></p>
					
				</div>
			</div>
		</div>
	</div>
</section>
@endsection