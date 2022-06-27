@extends('theme.grocery.layouts.app')

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
									<td class="float-right">{{ __('Paystack') }}</td>
								</tr>
							</table>
							 <button class="btn btn-primary mt-4 col-12 w-100 btn-lg" id="payment_btn">{{ __('Pay Now') }}</button>
						</div>
					</div>
				</div>
				<!--/ End Total Amount -->
			</div>
		</div>
	</div>
</div>
<!--/ End Shopping Cart -->
<form method="post" class="status" action="{{ route('order.paystack.payment') }}">
    @csrf
    <input type="hidden" name="ref_id" id="ref_id">
</form>
<input type="hidden" value="{{ $Info['currency'] }}" id="currency">
<input type="hidden" value="{{ $Info['amount'] }}" id="amount">
<input type="hidden" value="{{ $Info['public_key'] }}" id="public_key">
<input type="hidden" value="{{ $Info['email'] ?? Auth::user()->email }}" id="email">
@endsection
@push('js')
<script src="https://js.paystack.co/v1/inline.js"></script> 
<script>
    "use strict";

    $('#payment_btn').on('click',()=>{
        payWithPaystack();
    });
   payWithPaystack();
 
    function payWithPaystack() {
        var amont= $('#amount').val() * 100 ;
        let handler = PaystackPop.setup({
            key: $('#public_key').val(), // Replace with your public key
            email: $('#email').val(),
            amount: amont,
            currency: $('#currency').val(),
            ref: 'ps_{{ Str::random(15) }}',
            onClose: function(){
                payWithPaystack();
            },
            callback: function(response){
                $('#ref_id').val(response.reference);
                $('.status').submit();
            }
        });
        handler.openIframe();
    }
</script>
@endpush