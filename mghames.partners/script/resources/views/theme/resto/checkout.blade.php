@extends('theme.resto.layouts.app')
@section('content')
<!-- Start Breadcrumbs Area -->
		<div class="breadcrumbs" style="background-image:url({{ asset($page_data->checkout_page_banner ?? '') }})">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-8 col-12">
						<div class="breadcrumbs-content">
							<h1 class="page-title">{{ $page_data->cart_page_title ?? 'Checkout' }}</h1>
							<p>{{ $page_data->cart_page_description ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text' }}</p>
						</div>
						<ul class="breadcrumb-nav">
							<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
							<li><i class="icofont-cart"></i> {{ $page_data->cart_page_title ?? 'Cart' }}</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Breadcrumbs Area -->
		
		
		
		<!-- Start Checkout -->
		<section class="shop checkout section">
			<div class="container">
				@if(Cart::instance('default')->count() != 0)
				<form class="form orderform" method="post" action="{{ route('make.order') }}">
					@csrf
				<div class="row"> 
					<div class="col-lg-8 col-12">
						<div class="checkout-form">
							<h2>{{ $page_data->checkout_form_title ?? 'Make Your Checkout Here' }}</h2>
							<p>{{ $page_data->checkout_form_description ?? '' }}</p>
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
											<label>Select Delivery Area<span>*</span></label>
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
											<input type="text" class="location_input" id="location_input" name="address" placeholder="" required="required" value="{{ $meta->address ?? '' }}">
										</div>
									</div>
									@if(count($locations) != 0)
									<div class="col-lg-6 col-md-6 col-12 post_code_area">
										<div class="form-group">
											<label>{{ __('Postal Code') }}<span>*</span></label>
											<input type="text" name="post_code" placeholder="" value="{{ $meta->post_code ?? '' }}" required="required">
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
										<div class="form-group  password_area none">
										<input type="password" name="password" placeholder="Password" >
									    </div>
									</div>
									@endif
								</div>
							
							<!--/ End Form -->
						</div>
					</div>
					<div class="col-lg-4 col-12">
						<div class="order-details">
							<!-- Order Widget -->
							<div class="single-widget">
								<h2>{{ __('CART  TOTALS') }}</h2>
								@if($pickup_order == 'on')
								<div class="order-type-section">
									<input  type="radio" name="order_method" id="is_pickup" class="order_method {{ $pickup_order == 'off' ? 'none' : '' }}" value="pickup" @if($order_method == 'pickup') checked="" @endif>
									<label for="is_pickup">{{ __('pickup') }}</label>
									
									<input type="radio" name="order_method" id="is_pickup1" class="order_method" value="delivery" @if($order_method == 'delivery') checked="" @endif>
									<label for="is_pickup1">{{ __('delivery') }}</label>
									
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
							@if($order_settings->shipping_amount_type != 'distance')
							<div class="single-widget shipping_method_area none">
								<h2>{{ __('Shipping Method') }}</h2>
								<div class="content">
									<div class="checkbox shipping_render_area">

									</div>	
								</div>
							</div>
							@endif
							<!--/ End Order Widget -->
							<!-- Order Widget -->
							<div class="single-widget">
								<h2>Payments</h2>
								<div class="content">
									<div class="checkbox">

										@foreach($getways as $getway)
										<label class="checkbox-inline" for="getway{{ $getway->id }}"><input name="payment_method" class="getway" id="getway{{ $getway->id }}" type="radio" data-logo="{{ $getway->logo }}" data-rate="{{ $getway->rate }}"  data-charge="{{ $getway->charge }}" data-currency="{{ $getway->currency_name }}" data-instruction="{{ $getway->instruction }}" value="{{ $getway->id }}"> {{ $getway->name }}</label>
										@endforeach
										
									</div>
									<ul class="none payement_inst">
										<li><img src="" class="getway_logo" height="50"></li>
										<li class="currency_area none">
											{{ __('Currency : ') }} <span class="currency"></span>
										</li>
										<li class="rate_area none">
											{{ __('Currency Rate : ') }} <span class="rate"></span>
										</li>
										<li class="charge_area none">
											{{ __('Payment Charge : ') }} <span class="charge"></span>
										</li>
										<li class="instruction_area last none">
											{{ __('Payment instruction : ') }} <span class="instruction"></span>
										</li>
										
									</ul>
								</div>
							</div>

							@if($pre_order == 'on')
							<div class="single-widget">
								<h2><input type="checkbox" id="pre_order" class="pre_order" name="pre_order" value="1"> <label for="pre_order">{{ __('Pre Order ?') }}</label></h2>
								<div class="content pre_order_area none">
									<div class="checkbox">
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
							@endif
							<!--/ End Order Widget -->
							
							<!-- Button Widget -->
							<div class="single-widget get-button">
								<div class="content">
									<div class="button">
										<input type="hidden" id="shipping_fee" name="shipping_fee">
										<input type="hidden" id="total_price" name="total_price">
										<input type="hidden" id="my_lat" name="my_lat" value="{{ $meta->lat ?? '' }}">
										<input type="hidden" id="my_long" name="my_long" value="{{ $meta->long ?? '' }}">
										<button type="submit"  class="btn submit_btn submitbtn">{{ __('Proceed to checkout') }}</a>
									</div>
								</div>
							</div>
							<!--/ End Button Widget -->
						</div>
					</div>
				</div>
				</form>
				@else
				<div class="alert alert-danger" role="alert">
					{{ __('No Cart Item Available For Checkout') }}
				</div>
				@endif
			</div>
		</section>
		<!--/ End Checkout -->
<input type="hidden" id="subtotal" value="{{ Cart::instance('default')->subtotal() }}">
<input type="hidden" id="tax" value="{{ Cart::instance('default')->tax() }}">
<input type="hidden" id="total" value="{{ Cart::instance('default')->total() }}">

<input type="hidden" id="latitude" value="{{ tenant('lat') }}">
<input type="hidden" id="longitude" value="{{ tenant('long') }}">
<input type="hidden" id="city" value="{{ $invoice_data->store_legal_city ?? '' }}">




@endsection
@push('js')
<script type="text/javascript">
	"use strict";

var subtotal=parseFloat($('#subtotal').val());
var tax=parseFloat($('#tax').val());
var total=parseFloat($('#total').val());
var new_total=subtotal;
</script>
@if($source_code == 'off')
<script type="text/javascript" src="{{ asset('theme/disable-source-code.js') }}"></script>
@endif
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