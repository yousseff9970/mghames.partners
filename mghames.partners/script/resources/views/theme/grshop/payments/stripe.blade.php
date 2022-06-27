@extends('theme.grshop.layouts.app')
@section('content')
<!-- Start Breadcrumbs Area -->

<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner  gr-overlay" >
					<div class="row">
						<!-- Breadcrumb-Content -->
						<div class="col-lg-6 col-md-8 col-12">
							<div class="breadcrumb-content">
								<h2 >{{ __('Make Payment') }}</h2>
								
								<ul class="breadcrumb-nav">
									<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
					               <li><i class="icofont-fast-food"></i> {{ __('Make Payment') }}</li>
								</ul>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--/ End Breadcrumbs Area -->


<!-- Shopping Cart -->
<div class="shopping-cart section">
	<div class="container">

		<div class="row">
			<div class="col-12">
				<!-- Total Amount -->
				<div class="card">
					<div class="card-body">
						<div class="px-4">
							<table class="table">
								<tr>
									<td>{{ __('Amount') }}</td>
									<td class="float-right">{{ $Info['main_amount'] }}</td>
								</tr>
								<tr>
									<td>{{ __('Charge') }}</td>
									<td class="float-right">{{ $Info['charge'] }}</td>
								</tr>
								<tr>
									<td>{{ __('Total') }}</td>
									<td class="float-right">{{ $Info['main_amount'] + $Info['charge'] }}</td>
								</tr>
								<tr>
									<td>{{ __('Amount ') }} ({{ $Info['currency'] }})</td>
									<td class="float-right">{{ $Info['amount'] }}</td>
								</tr>
								<tr>
									<td>{{ __('Payment Mode') }}</td>
									<td class="float-right">{{ __('Stripe') }}</td>
								</tr>
							</table>
							<form action="{{ route('order.stripe.payment') }}" method="post" id="payment-form" class="paymentform p-4">
								@csrf
								<div class="form-row">
									<label for="card-element">
										{{ __('Credit or debit card') }}
									</label>
									<div id="card-element">
										<!-- A Stripe Element will be inserted here. -->
									</div>
									<!-- Used to display form errors. -->
									<div id="card-errors" role="alert"></div>
									<button type="submit" class="btn btn-primary btn-lg w-100 mt-4" id="submit_btn">{{ __('Submit Payment') }}</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!--/ End Total Amount -->
			</div>
		</div>
	</div>
</div>
<!--/ End Shopping Cart -->
<input type="hidden" id="publishable_key" value="{{ $Info['publishable_key'] }}">
@endsection
@push('js')
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('admin/assets/js/stripe.js') }}"></script>

@endpush