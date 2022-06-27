@extends('theme.grocery.customer.app')
@section('customer_content')
<!-- Start Profile Settings Area -->
<div class="dashboard-block mt-0 profile-settings-block">
	<h3 class="block-title">Profile Settings</h3>
	<div class="inner-block">

		<form class="profile-setting-form ajaxform" method="post" action="{{ route('customer.profile.update') }}">
			@csrf
			<div class="row">
				<div class="col-lg-12 col-12">
					<div class="form-group">
						<label>{{ __('Name') }}</label>
						<input  type="text" name="name" maxlength="100" value="{{ Auth::user()->name }}" />
					</div>
				</div>
			</div>	
			<div class="row">	
				<div class="col-lg-6 col-12">
					<div class="form-group">
						<label>{{ __('Email Address*') }}</label>
						<input name="email" type="email" value="{{ Auth::user()->email }}"/>
					</div>
				</div>

				<div class="col-lg-6 col-12">
					<div class="form-group">
						<label>{{ __('Phone') }}</label>
						<input name="phone" type="number" maxlength="20" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" value="{{ Auth::user()->phone }}" />
					</div>
				</div>
				<div class="col-lg-6 col-12">
					<div class="form-group">
						<label>{{ __('Address') }}</label>
						<input name="address" type="text"  value="{{ $meta->address ?? '' }}" id="location_input" />
					</div>
				</div>
				<div class="col-lg-6 col-12">
					<div class="form-group">
						<label>{{ __('Post Code') }}</label>
						<input name="post_code" type="text"  value="{{ $meta->post_code ?? '' }}" />
					</div>
				</div>
				<input type="hidden" name="lat" id="latitude" value="{{ $meta->lat ?? '' }}">
				<input type="hidden" name="long" id="longitude" value="{{ $meta->long ?? '' }}">
				@if(!empty($order_settings->google_api ?? ''))
				<div class="col-lg-12 col-12 @if(empty($meta->long ?? '')) none @endif" id="map-area">
					<label>{{ __('Drag Your Location') }}</label>
					<div id="map-canvas" class="map-canvas h-300 w-100p"></div>
				</div>
				@endif
				<div class="col-12">
					<div class="form-group button mb-0 mt-2">
						<button type="submit" class="btn basicbtn">
							{{ __('Save changes') }}
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End Profile Settings Area -->
<!-- Start Password Change Area -->
<div class="dashboard-block password-change-block">
	<h3 class="block-title">{{ __('Change Password') }}</h3>
	<div class="inner-block">
		<form class="default-form-style ajaxform_with_reset" method="post" action="{{ route('customer.password.update') }}">
			@csrf
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label>{{ __('Current Password*') }}</label>
						<input type="password" name="current" id="oldpassword" class="form-control"  placeholder="Enter Old Password" required>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label>{{ __('New Password') }}</label>
						<input type="password" name="password" id="password" class="form-control"  placeholder="Enter New Password" required>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label>{{ __('Retype Password*') }}</label>
						<input type="password" name="password_confirmation" id="password1" class="form-control"  placeholder="Enter Again" required>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group button mb-0">
						<button type="submit" class="btn basicbtn">
							{{ __('Save changes') }}
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End Password Change Area -->
@endsection
@if(!empty($order_settings->google_api ?? ''))
@push('js')
 <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $order_settings->google_api ?? '' }}&libraries=places&callback=initialize"></script>
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
<script src="{{ asset('admin/js/user-settings.js') }}"></script>
@endpush
@endif