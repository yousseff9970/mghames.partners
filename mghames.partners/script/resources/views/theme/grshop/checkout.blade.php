@extends('theme.grshop.layouts.app')
@section('content')

<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner  gr-overlay" style="background-image:url({{ asset($page_data->checkout_page_banner ?? '') }})">
					<div class="row">
						<!-- Breadcrumb-Content -->
						<div class="col-lg-6 col-md-8 col-12">
							<div class="breadcrumb-content">
								<h2 class="page-title">{{ $page_data->cart_page_title ?? 'Checkout' }}</h2>
								<p>{{ $page_data->cart_page_description ?? '' }}</p>
								<ul class="breadcrumb-nav">
									<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
									<li><i class="icofont-cart"></i> {{ $page_data->cart_page_title ?? 'Cart' }}</li>
								</ul>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Start Checkout -->
<section class="shop checkout p-top-40 p-btm-70 section">
	<div class="container">
		@if(Cart::instance('default')->count() != 0)
		<form class="form orderform" method="post" action="{{ route('make.order') }}">
			@csrf
			<div class="row"> 
				<div class="col-lg-8 col-12">
					<div class="checkout-form m-top-30">
						<div class="checkout-form-inner">
							<div class="checkout-heading">
								<h2>{{ __('Personal Details') }}</h2>
							</div>
							<!-- Form -->

							<div class="row">
								<div class="col-lg-12 col-md-12 col-12">
									@if ($errors->any())
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
									@endif
									@if (Session::has('error'))
									<div class="alert alert-danger">
										<ul>
											
											<li>{{ Session::get('error') }}</li>
											
										</ul>
									</div>
									@endif
									@if (Session::has('alert'))
									<div class="alert alert-danger">
										<ul>
											
											<li>{{ Session::get('alert') }}</li>
											
										</ul>
									</div>
									@endif
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ __('Name') }}<span>*</span></label>
										<input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" placeholder="" required="required">
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ __('Email Address') }}<span>*</span></label>
										<input value="{{ Auth::check() ? Auth::user()->email : '' }}" type="email" name="email" placeholder="" required="required">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ __('Phone Number') }}<span>*</span></label>
										<input type="number" name="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}" placeholder="" required="required" maxlength="20">
									</div>
								</div>

								@if(count($locations) != 0)
								<div class="col-lg-6 col-md-6 col-12 delivery_address_area">
									<div class="form-group">
										<label>{{ __('Select Delivery Area') }}<span>*</span></label>
										<select name="location" id="locations" >
											<option value="" selected="" disabled=""></option>
											@foreach($locations as $key => $row)
											<option value="{{ $row->id }}" data-shipping="{{ $row->shippings }}" 
												>{{ $row->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									@endif
									<div class="col-lg-6 col-md-6 col-12 delivery_address_area">
										<div class="form-group">
											<label>{{ __('Delivery Address') }} <span>*</span></label>
											<input type="text" class="location_input" id="location_input" name="address" placeholder=""  value="{{ $meta->address ?? '' }}">
										</div>
									</div>
									@if(count($locations) != 0)
									<div class="col-lg-6 col-md-6 col-12 post_code_area">
										<div class="form-group">
											<label>{{ __('Postal Code') }}<span>*</span></label>
											<input type="text" name="post_code" placeholder="" value="{{ $meta->post_code ?? '' }}" >
										</div>
									</div>
									@endif
									@if($order_settings->shipping_amount_type == 'distance')
									<div class="col-lg-12 col-md-12 col-12 map_area">
										<div class="form-group">
											<p class="text-danger alert_area"></p>
											<div class="map-canvas h-300" id="map-canvas">

											</div>
											
										</div>
									</div>
									@endif
									<div class="col-lg-12 col-md-12 col-12">
										<div class="form-group">
											<label>{{ __('Comment') }}</label>
											<textarea class="form-control h-150" name="comment" maxlength="300"></textarea>
										</div>
									</div>
									
									@if(Auth::check() == false)
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group create-account">
											<input id="create_account" type="checkbox" value="1">
											<label for="create_account">{{ __('Create an account?') }}</label>

										</div>
										<div class="form-group  password_area none mt-2">
											<input type="password" name="password" placeholder="Password" >
										</div>
									</div>
									@endif
								</div>
							
							<!--/ End Form -->
						</div>

					</div>
				</div>
				<div class="col-lg-4 col-12">
					<div class="order-details m-top-30">
						<h2 class="payment-side-title">{{ __('Your Order') }}</h2>
						<!-- Order Widget -->
						<div class="single-widget order-dt">
							@if($pickup_order == 'on')
							<div class="cart-img-head">
								<input  type="radio" name="order_method" id="is_pickup" class="order_method" value="pickup" @if($order_method == 'pickup') checked="" @endif>
								<label for="is_pickup">&nbsp{{ __(' Pickup') }}</label>
								<input type="radio" name="order_method" id="is_pickup1" class="order_method" value="delivery" @if($order_method == 'delivery') checked="" @endif>
								<label for="is_pickup1">&nbsp{{ __(' Delivery') }}</label>
							</div>
							@else
							<input  type="hidden" name="order_method" class="order_method none" value="delivery" >
							@endif
							<div class="content">
								<ul>
									<li>{{ __('Subtotal') }}
										<span class="cart_subtotal">
											0.00
										</span>
									</li>
									<li>(+) {{ __('Tax') }}
										<span class="cart_tax">
											0.00
										</span>
									</li>
									<li>(+) {{ __('Delivery fee') }}<span class="shipping_fee">0.00</span></li>

									<li class="last">{{ __('Total') }}<span class="cart_total">0.00</span></li>
								</ul>
							</div>
						</div>
						<!--/ End Order Widget -->
						@if($order_settings->shipping_amount_type != 'distance')
						<div class="single-widget payments shipping_method_area none">
							<h2 class="payment-side-title">{{ __('Shipping Method') }}</h2>
							<div class="content">
								<div class="checkbox shipping_render_area accordion">

								</div>	
							</div>
						</div>
						@endif
						<!-- Order Widget -->
						<div class="single-widget payments">
							<h2 class="payment-side-title">{{ __('Payment Method') }}</h2>
							<div class="content">
								<div class="accordion" id="paymentac">
									@foreach($getways as $getway)
									<div class="payment-list-item">
										<h2 class="accordion-header" id="headingThree">
											<button class="accordion-button getway_btn collapsed getway" 
											type="button"
											data-bs-toggle="collapse" 
											data-bs-target="#collapseThree{{ $getway->id }}" 
											aria-expanded="false" 
											aria-controls="collapseThree" 
											data-logo="{{ asset($getway->logo) }}" 
											data-rate="{{ $getway->rate }}"  
											data-charge="{{ $getway->charge }}" 
											data-currency="{{ $getway->currency_name }}" 
											data-instruction="{{ $getway->instruction }}" 
											data-id="{{ $getway->id }}">
												
												<input 
												name="payment_method" 
												class="getway " 
												id="getway{{ $getway->id }}" 
												type="radio" 
												data-logo="{{ $getway->logo }}" 
												data-rate="{{ $getway->rate }}"  
												data-charge="{{ $getway->charge }}" 
												data-currency="{{ $getway->currency_name }}" 
												data-instruction="{{ $getway->instruction }}" 
												data-id="{{ $getway->id }}"
												value="{{ $getway->id }}">

												<label class="checkbox-inline" for="getway{{ $getway->id }}"></label>{{ $getway->name }}
											</button>
										</h2>
										<div id="collapseThree{{ $getway->id }}" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#paymentac">
											<div class="accordion-body">
												<ul>
													<li class="currency_area none">
														{{ __('Currency : ') }} {{ $getway->currency_name }}
													</li>
													<li class="rate_area none">
														{{ __('Currency Rate : ') }} {{ $getway->rate }}
													</li>
													<li class="charge_area none">
														{{ __('Payment Charge : ') }} {{ $getway->charge }}
													</li>
													<li class="instruction_area  none">
														{{ __('Payment instruction : ') }} {{ $getway->instruction }}
													</li>
												</ul>
												
											</div>
										</div>
									</div>
									@endforeach

									
								</div>

							</div>
							
						</div>

						<div class="single-widget payments">
							<h2 class="payment-side-title"><input type="checkbox" id="pre_order" class="pre_order" name="pre_order" value="1"> <label for="pre_order">{{ __('Pre Order ?') }}</label></h2>
							<div class="content pre_order_area none">
								<div class="">
									<div class="form-group">
										<label>{{ __('Delivery Date ?') }}</label>
										<input type="date" name="date" class="form-control date">
									</div>
									<div class="form-group">
										<label>{{ __('Delivery Time ?') }}</label>
										<input type="time" id="time"  class="form-control">
										<input type="hidden" name="time" class="time">
									</div>
								</div>	
							</div>
							
						</div>

						<input type="hidden" id="shipping_fee" name="shipping_fee">
						<input type="hidden" id="total_price" name="total_price">
						<input type="hidden" id="my_lat" name="my_lat" value="{{ $meta->lat ?? '' }}">
						<input type="hidden" id="my_long" name="my_long" value="{{ $meta->long ?? '' }}">
						<!--/ End Order Widget -->
						<!-- Button Widget -->
						<div class="single-widget get-button">
							<div class="content">
								<div class="button">
									<button type="submit"  class="btn submit_btn submitbtn">{{ __('Proceed to checkout') }}</button>
								</div>
							</div>
						</div>
						<!--/ End Button Widget -->
						<div class="checkout-bottom">
							<div class="checkout-first"><b>Total</b><span class="cart_total">0.00</span></div>
							<div class="button">
								<button type="submit"  class="btn submit_btn submitbtn">{{ __('Proceed to checkout') }}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		@else
		<div class="row">
			<div class="alert alert-danger" role="alert">
					{{ __('No Cart Item Available For Checkout') }}
				</div>
		</div>
		@endif
	</div>
</section>
<!--/ End Checkout -->



<!--/ End Checkout -->
<input type="hidden" id="subtotal" value="{{ Cart::instance('default')->subtotal() }}">
<input type="hidden" id="tax" value="{{ Cart::instance('default')->tax() }}">
<input type="hidden" id="total" value="{{ Cart::instance('default')->total() }}">
<input type="hidden" id="latitude" value="{{ tenant('lat') }}">
<input type="hidden" id="longitude" value="{{ tenant('long') }}">
<input type="hidden" id="city" value="{{ $invoice_data->store_legal_city ?? '' }}">
@endsection
@push('js')
@if($source_code == 'off')
<script type="text/javascript" src="{{ asset('theme/disable-source-code.js') }}"></script>
@endif
<script type="text/javascript">
	"use strict";

	var subtotal=parseFloat($('#subtotal').val());
	var tax=parseFloat($('#tax').val());
	var total=parseFloat($('#total').val());
	var new_total=subtotal;
</script>
@if($order_settings->shipping_amount_type == 'distance')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $order_settings->google_api ?? '' }}&libraries=places&radius=5&location={{ tenant('lat') }}%2C{{ tenant('long') }}&callback=initialize"></script>
<script type="text/javascript">
	"use strict";


	if ($('#my_lat').val() != null) {
		localStorage.setItem('lat',$('#my_lat').val());

	}
	if ($('#my_long').val() != null) {
		localStorage.setItem('long',$('#my_long').val());

	}

	if ($('#location_input').val() != null) {
		localStorage.setItem('location',$('#location_input').val());
	}



	if (localStorage.getItem('location') != null) {
		var locs= localStorage.getItem('location');
	}
	else{
		var locs = "";
	}
	$('#location_input').val(locs);
	if (localStorage.getItem('lat') !== null) {
		var lati=localStorage.getItem('lat');
		$('#my_lat').val(lati)
	}	
	else{
		var lati= {{ tenant('lat') }};
	}
	if (localStorage.getItem('long') !== null) {
		var longlat=localStorage.getItem('long');
		$('#my_long').val(longlat)
	}
	else{
		var longlat= {{ tenant('long') }};
	}

	const maxRange= {{ $order_settings->google_api_range ?? 0 }};
	const resturentlocation="{{ $invoice_data->store_legal_address ?? '' }}";
	const feePerkilo= {{ $order_settings->delivery_fee ?? 0 }};

	var mapOptions;
	var map;
	var marker;
	var searchBox;
	var city;
</script>

<script type="text/javascript" src="{{ asset('theme/resto/js/google-api.js') }}"></script>
@endif


<script type="text/javascript" src="{{ asset('theme/checkout.js') }}"></script>
@endpush