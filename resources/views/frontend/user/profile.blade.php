@extends('frontend.user.layouts')
@section('title', 'Profile')

@section('userLayouts')

	<!-- Row -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="dashboard_container">
				<div class="dashboard_container_header">
					<div class="dashboard_fl_1">
						<h4>Setup Your Detail</h4>
					</div>
				</div>
				<div class="dashboard_container_body p-4">
					<!-- Basic info -->
					<div class="submit-section">
						<form action="{{ route('user.profileUpdate') }}" method="post" data-parsley-validate>
						@csrf
						<div class="form-row">
						
							<div class="form-group col-md-6">
								<label>Your Name</label>
								<input type="text" name="name" class="form-control"  value="{{$user->name}}">
							</div>
							
							<div class="form-group col-md-6">
								<label>Email</label>
								<input type="email" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" name="email" class="form-control" value="{{$user->email}}">
							</div>
							
							<div class="form-group col-md-6">
								<label>Mobile</label>
								<input type="text" pattern="/(01)\d{9}/" minlength="11" name="mobile" class="form-control" value="{{$user->mobile}}">
							</div>
							<div class="form-group col-md-6">
								<label>Birthday</label>
								<input type="date" name="birthday" class="form-control" value="{{$user->birthday}}">
							</div>

							<div class="form-group col-md-6">
								<label>Blood Group</label>
								<select name="blood" class="form-control">
									<option value="">Select</option>
									<option @if( $user->blood == 'A+') selected @endif value="A+">A+</option>
									<option @if( $user->blood == 'A-') selected @endif value="A-">A-</option>
									<option @if( $user->blood == 'B+') selected @endif value="B+">B+</option>
									<option @if( $user->blood == 'B-') selected @endif value="B-">B-</option>
									<option @if( $user->blood == 'O+') selected @endif value="O+">O+</option>
									<option @if( $user->blood == 'O-') selected @endif value="O-">O-</option>
									<option @if( $user->blood == 'AB+') selected @endif value="AB+">AB+</option>
									<option @if( $user->blood == 'AB-') selected @endif value="AB-">AB-</option>
								</select>
							</div>

							<div class="form-group col-md-6">
								<label>Gender</label>
								<select name="gender" id="gender" class="form-control">
									<option value="">Select</option>
									<option @if( $user->gender == 'male') selected @endif value="male">Male</option>
									<option @if( $user->gender == 'female') selected @endif value="female">Female</option>
								</select>
							</div>
							
							<div class="form-group col-md-6">
								<label>State</label>
								<select name="region" onchange="get_city(this.value)" required id="input-payment-country" class="form-control">
									<option value=""> Please Select  </option>
									@foreach($states as $state)
									<option @if($user->region == $state->id) selected @endif value="{{$state->id}}"> {{$state->name}} </option>
									@endforeach
								</select>
							</div>
							
							<div class="form-group col-md-6">
								<label>City</label>
								<select name="city" onchange="get_area(this.value)"  required id="show_city" class="form-control">
									
									<option value="">Please Select</option>
									@foreach($cities as $city)
									<option @if($user->city == $city->id) selected @endif value="{{$city->id}}"> {{$city->name}} </option>
									@endforeach
								</select>
							</div>
							
							<div class="form-group col-md-6">
								<label>Area</label>
								<select name="area" required id="show_area" class="form-control">
									<option value="">Please Select</option>
									@foreach($areas as $area)
									<option @if($user->area == $area->id) selected @endif value="{{$area->id}}"> {{$area->name}} </option>
									@endforeach
								</select>
							</div>
							
							<div class="form-group col-md-6">
								<label>Zip</label>
								<input type="text" name="zip_code" placeholder="Enter zip code" class="form-control" value="{{$user->zip_code}}">
							</div>

							<div class="form-group col-md-12">
								<label>Address</label>
								<input type="text" placeholder="Exm: Village, Road, Post" class="form-control" name="address" value="{{$user->address}}">
							</div>

							
							<div class="form-group col-md-12">
								<label>About</label>
								<textarea name="user_dsc" placeholder="Describe About" class="form-control">{{$user->user_dsc}}</textarea>
							</div>
							
						</div>
						<div class="form-group col-lg-12 col-md-12">
							<button class="btn btn-theme" type="submit">Save Changes</button>
						</div>
						</form>
					</div>
					<!-- Basic info -->
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- /Row -->
	
@endsection

@section('js')
<script type="text/javascript">
	function get_city(id, type=''){
       
        var  url = '{{route("get_city", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_city"+type).html(data);
                    $("#show_city"+type).focus();
                }else{
                    $("#show_city"+type).html('<option>City not found</option>');
                }
            }
        });
    }  	 

    function get_area(id, type=''){
           
        var  url = '{{route("get_area", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_area"+type).html(data);
                    $("#show_area"+type).focus();
                }else{
                    $("#show_area"+type).html('<option>Area not found</option>');
                }
            }
        });
    }  
</script>
@endsection