@extends('theme.grshop.layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('theme/grshop/css/thanks.css') }}">
@endpush
@section('content')
<!-- Start Order Confirm Area -->

<div class="order-confirm">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
				<div class="confirm-content text-center">
					<i class="icofont-simple-smile"></i>
					<h4>{{ __('Order No') }}: {{ $orderno }}</h4>
					<h1>{{ __('Your order has been placed successfully') }}</h1>
					<p>{{ __('It means you have successfully placed the order and no furtheraction is required from you.') }}</p>
					<div class="button">
						<a href="{{ url('/') }}" class="btn ">{{ __('Go To Home') }}</a>
					</div>
				</div>
			</div>
		</div>
		
	</div>

</div>

<!-- End Order Confirm Area -->
@endsection