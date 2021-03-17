@extends('frontend.user.layouts')
@section('title', 'Dashboard')

@section('userLayouts')
<!-- Row -->
<div class="row">
	<div class="col-md-12">
		<div class="dashboard_container">
				<div class="dashboard_container_header">
					<div class="dashboard_fl_1">
						<h4>Change Your Password</h4>
					</div>
				</div>
				<div class="dashboard_container_body p-4">
				<form action="{{route('user.change-password')}}" method="post" data-parsley-validate>
					@csrf
					<div class="row">
						
						<div class="col-sm-6">
							
							
								<div class="form-group ">
									<label for="input-password" class="control-label">Old Password</label>
									<input type="password" required class="form-control"  placeholder="Old Password" value="" name="old_password">
								</div>
								<div class="form-group ">
									<label for="input-password" class="control-label">New Password</label>
									<input type="password" required class="form-control" minlength="6" id="password" placeholder="Enter New Password" value="" name="password">
								</div>
								<div class="form-group ">
									<label for="input-confirm" class="control-label">Retype New Password</label>
									<input type="password" class="form-control" id="input-confirm"  data-parsley-equalto="#password" required="" placeholder="New Password Confirm" value="" name="password_confirmation">
								</div>
							
							<div class="buttons clearfix">
								<div class="pull-right">
									<input type="submit" class="btn btn-md btn-primary" value="Save Changes">
								</div>
							</div>
						</div>
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>
@endsection