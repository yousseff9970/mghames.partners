@extends('theme.resto.layouts.app')
@section('content')
<!-- Start Breadcrumbs Area -->
<div class="breadcrumbs" style="background-image:url('images/bread-bg.jpg')">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-8 col-12">
				<div class="breadcrumbs-content">
					<h1 class="page-title">{{ ucwords(Request::segment(2)) }}</h1>
					
				</div>
				<ul class="breadcrumb-nav">
					<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
					<li><i class="icofont-fast-food"></i> {{ Request::segment(2) }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!--/ End Breadcrumbs Area -->

<!-- Start Dashboard Section -->
<section class="dashboard section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4 col-12">
				<!-- Start Dashboard Sidebar -->
				<div class="dashboard-sidebar">
					<div class="user-image">
						
						<h3>{{ Auth::user()->name }}</h3>
					</div>
					<div class="dashboard-menu">
						<ul>
							<li><a class="{{ url()->current() == url('/customer/dashboard') ? 'active' : '' }}" href="{{ url('/customer/dashboard') }}"><i class="lni lni-dashboard"></i> {{ __('Dashboard') }}</a></li>
							<li><a href="{{ url('/customer/orders') }}" href="{{ url()->current() == url('/customer/orders') ? 'active' : '' }}"><i class="lni lni-bolt-alt"></i> {{ __('My Orders') }}</a></li>
							<li><a href="{{ url('/customer/reviews') }}"><i class="lni lni-pencil-alt"></i>{{ __('Reviews') }}</a></li>
							<li><a href="{{ url('/customer/settings') }}"><i class="lni lni-pencil-alt"></i> {{ __('Edit Profile') }}</a></li>
							
						</ul>
						<div class="button">
							<a class="btn alt-btn" href="javascript:void(0)" onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
							<form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</div>
				</div>
				<!-- Start Dashboard Sidebar -->
			</div>
			<div class="col-lg-9 col-md-8 col-12">
				<div class="main-content">
					@if (Auth::user()->role_id == 3)
					<div class="row">
						<div class="col-lg-12">
						<div class="customer-button-area">
							<a href="{{ url('/seller/dashboard') }}">Go To Your Panel</a>
						</div>
						</div>
					</div>

					@elseif(Auth::user()->role_id == 5)
					<div class="row">
						<div class="col-lg-12">
						<div class="customer-button-area">
							<a href="{{ url('/rider/dashboard') }}">Go To Your Panel</a>
						</div>
						</div>
					</div>
					@endif
					@yield('customer_content')
					
				</div>
			</div>
		</div>
	</div>
</section>

@if(tenant('push_notification') == 'on' && env('FMC_SERVER_API_KEY') != null)
<!-- End Dashboard Section -->
<div class="notification-button-area notification_button">
	<button type="button" class="notification_buttons"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zM9 21h6v2H9v-2z"/></svg></button>
</div>
@endif
@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
@endpush