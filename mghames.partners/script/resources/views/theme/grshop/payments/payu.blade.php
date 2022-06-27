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
							

							<form action="#" method="post" name="payuForm" id="payment_form">
								@csrf
								<input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
								<input type="hidden" id="salt" value="{{ $Info['salt'] }}" />
								<input type="hidden" name="key" id="key" value="{{ $Info['key'] }}" />
								<input type="hidden" name="hash" id="hash" value="{{ $Info['hash'] }}"/>
								<input type="hidden" name="txnid" id="txnid" value="{{ $Info['txnid'] }}" />
								<input type="hidden" name="amount" id="amount" value="{{ $Info['amount'] }}" />
								<input type="hidden" name="firstname" id="firstname" value="{{ $Info['firstname'] }}"/>
								<input type="hidden" name="email" id="email" value="{{ $Info['email'] }}" />
								<input type="hidden" name="phone" id="mobile" value="{{ $Info['phone'] }}" />
								<input type="hidden" name="productinfo" id="productinfo" value="{{ $Info['productinfo'] }}"/>
								<input type="hidden" name="surl" id="surl" value="{{ $Info['surl'] }}"/>
								<input type="hidden" name="furl" id="furl" value="{{ $Info['furl'] }}"/>
								<div class="card-footer bg-white">
									<input  class="btn btn-primary mt-4 col-12 w-100 btn-lg" type="button" value="Submit" onclick="launchBOLT(); return false;"/>
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

@endsection
@push('js')

@if ($Info['test_mode'] == true)
<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-
color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
@else 
<script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
@endif

<script src="{{ asset('admin/assets/js/payu.js')}}"></script>
@endpush