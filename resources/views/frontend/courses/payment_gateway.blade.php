@extends('frontend.layouts.master')
@section('title', 'Payment')

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
				<div class="col-lg-8 col-md-8 col-sm-12">
					<div class="custom-tab customize-tab tabs_creative" style="background:#fff;">
						<ul class="nav nav-tabs" id="myTab" role="tablist" style="background: #ddd;padding: 3px 5px 0;border-radius: 5px;">
							@foreach($paymentgateways as $methodIndex => $method)
							<li class="nav-item">
								<a class="nav-link @if($methodIndex == 0) active @endif" id="home-tab" data-toggle="tab" href="#method{{$method->id}}" role="tab" aria-controls="method{{$method->id}}" aria-selected="{{($methodIndex == 0) ? 'true' : 'false' }}"><img src="{{asset('upload/images/payment/'.$method->method_logo)}}"><p style="margin-bottom: 0;text-align: center;">{{$method->method_name}}</p></a>

							</li>
							@endforeach
							
						</ul>
						<div class="tab-content" id="myTabContent" style="padding:10px 15px;">
							@if(count($paymentgateways)>0)
							@foreach($paymentgateways as $methodIndex => $method)
							<div class="tab-pane fade @if($methodIndex == 0) show active @endif" id="method{{$method->id}}" role="tabpanel" aria-labelledby="home-tab">
								{!! $method->method_info !!}
							<form action="{{route('coursePayment', $order->order_id)}}" data-parsley-validate method="post">
                              @csrf
                           
                              <input type="hidden" name="manual_method_name" value="{{$method->method_slug}}">
                              <strong>{{$method->method_name}} mobile number</strong>
                              <p><input type="text" data-parsley-required-message = "Mobile number is required" required placeholder="Enter Mobile Number" class="form-control" name="pay_mobile_no"></p>
                              <strong>Transaction Id</strong>
                              <p><input type="text" required data-parsley-required-message = "Transaction Id is required" placeholder="Enter Transaction Id" class="form-control" name="trnx_id"></p>
                              <strong>Write your payment information below.</strong>
                              <textarea name="payment_info" style="margin: 0;" rows="2" placeholder="Write Payment Information" class="form-control"></textarea>

                              <div class="text-left">
                                <span class="secure-checkout-banner1">
                                  <i class="fa fa-lock"></i> Secure checkout
                                </span>
                              </div>
                              <div class="text-right">
                                  <button name="payment_method" value="manual" style="width: 40%" class="btn btn-success"><span><i class="fa fa-money" aria-hidden="true"></i> Pay {{$method->method_name}}</span></button>
                              </div>
                            </form>
							</div>
							@endforeach
							@else
							<div style="text-align: center;">
							<img src="{{asset('frontend/img/error.png')}}">
							<h3>Sorry at this momment payment gateway not set please contact {{Config::get('siteSetting.phone')}}.</h3>
						</div>
							@endif
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<!-- Total Cart -->
					<div class="cart_totals checkout">
						<h4>Order Summary</h4>
						<div class="cart-wrap">
							<ul class="cart_list">
								<li><a href="{{ route('course_details',$order->courseDetails->slug) }} "> {{$order->courseDetails->title}}</a></li>
								<li>Price<strong>{{Config::get('siteSetting.currency_symble')}}{{$order->total_price}}</strong></li>
								<li>Discount<strong>{{Config::get('siteSetting.currency_symble')}}0.00</strong></li>
								
							</ul>
							<div class="flex_cart">
								<div class="flex_cart_1">
									Total Cost
								</div>
								<div class="flex_cart_2">
									{{Config::get('siteSetting.currency_symble')}}{{$order->total_price}}
								</div>
							</div>
							
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- ============================ Course Detail ================================== -->
	

@endsection

@section('js')

@endsection