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
									<td class="float-right">{{ __('Razorpay') }}</td>
								</tr>
							</table>
							 <button class="btn btn-primary mt-4 col-12 btn-lg w-100" id="rzp-button1">{{ __('Pay Now') }}</button>
							<form action="{{ route('order.razorpay.payment') }}" method="POST" hidden>
								<input type="hidden" value="{{csrf_token()}}" name="_token"/>
								<input type="text" class="form-control" id="rzp_paymentid" name="rzp_paymentid">
								<input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
								<input type="text" class="form-control" id="rzp_signature" name="rzp_signature">
								<button type="submit" id="rzp-paymentresponse" hidden class="btn btn-primary"></button>
							</form>
							<input type="hidden" value="{{ $response['razorpayId'] }}" id="razorpayId">
							<input type="hidden" value="{{ $response['amount'] }}" id="amount">
							<input type="hidden" value="{{ $response['currency'] }}" id="currency">
							<input type="hidden" value="{{ $response['name'] }}" id="name">
							<input type="hidden" value="{{ $response['description'] }}" id="description">
							<input type="hidden" value="{{ $response['orderId'] }}" id="orderId">
							<input type="hidden" value="{{ $response['name'] }}" id="name">
							<input type="hidden" value="{{ $response['email'] }}" id="email">
							<input type="hidden" value="{{ $response['contactNumber'] }}" id="contactNumber">
							<input type="hidden" value="{{ $response['address'] }}" id="address">
						</div>
					</div>
				</div>
				<!--/ End Total Amount -->
			</div>
		</div>
	</div>
</div>
<!--/ End Shopping Cart -->

@endsection
@push('js')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('admin/assets/js/razorpay.js')}}"></script>

@endpush