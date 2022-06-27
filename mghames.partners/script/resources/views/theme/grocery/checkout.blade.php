@extends('theme.grocery.layouts.app')

@section('content')
<div class="hero-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 category-lists-sidebar">
                <div class="grocery-items-collection" id="categories">
                    
                </div>
            </div>
            <div class="col-lg-9 hero-fixed">
                <div class="row">
                    <div class="col-lg-12">
                        @if(Cart::instance('default')->count() != 0)
                        <div class="checkout-area">
                            <form class="form orderform" method="post" action="{{ route('make.order') }}">
                                @csrf
                                <div class="checkout-form">
                                    <div class="delivery-address-header">
                                        <h2><span>1</span>Delivery Address</h2>
                                    </div>
                                    <div class="delivery-address-form">
                                        <div class="row mt-5">
                                            <div class="col-lg-12">
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
                                            <div class="col-lg-6">
                                                <div class="form-input">
                                                    <label>Name</label>
                                                    <input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-input">
                                                    <label>Email</label>
                                                    <input value="{{ Auth::check() ? Auth::user()->email : '' }}" type="email" name="email">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-input">
                                                    <label>Phone Number</label>
                                                    <input type="number" name="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                                                </div>
                                            </div>
                                            @if(count($locations) != 0)
                                            <div class="col-lg-6 col-md-6 col-12 delivery_address_area">
                                                <div class="form-input">
                                                    <label>Select Delivery Area<span>*</span></label>
                                                    <select name="location" id="locations" required="" class="form-control">
                                                        <option value="" selected="" disabled=""></option>
                                                        @foreach($locations as $key => $row)
                                                        <option value="{{ $row->id }}" data-shipping="{{ $row->shippings }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-lg-6 col-md-6 col-12 delivery_address_area">
                                                <div class="form-input">
                                                    <label>Delivery Address <span>*</span></label>
                                                    <input type="text" class="location_input" id="location_input" name="address" placeholder="" required="required" value="{{ $meta->address ?? '' }}">
                                                </div>
                                            </div>
                                            @if(count($locations) != 0)
                                            <div class="col-lg-6 col-md-6 col-12 post_code_area">
                                                <div class="form-input">
                                                    <label>Postal Code<span>*</span></label>
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
                                                <div class="form-input">
                                                    <label>{{ __('Comment') }}</label>
                                                    <textarea class="form-control h-150" name="comment" maxlength="300" cols="30" rows="5"></textarea>
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
                                    </div>
                                </div>
                                <div class="delivery-address-header">
                                    <h2><span>2</span>Order Type</h2>
                                </div>
                                <div class="delivery-system">
                                    @if($pickup_order == 'on')
                                    <div class="single-payment">
                                        <div class="form-check">
                                            <input class="form-check-input order_method" type="radio" name="order_method" id="is_pickup"  value="pickup" @if($order_method == 'pickup') checked="" @endif>
                                            <label class="form-check-label" for="is_pickup">
                                                Pick Up
                                            </label>
                                        </div>
                                    </div>
                                    <div class="single-payment">
                                        <div class="form-check">
                                            <input class="form-check-input order_method" type="radio" name="order_method" id="is_pickup1"  value="delivery" @if($order_method == 'delivery') checked="" @endif>
                                            <label class="form-check-label" for="is_pickup1">
                                                Delivery
                                            </label>
                                        </div>
                                    </div>
                                    @else
                                    <input  type="hidden" name="order_method" class="order_method none" value="delivery" >
                                    @endif
                                </div>
                                <div class="delivery-address-header">
                                    <h2><span>3 </span>Shipping Method</h2>
                                </div>
                                @if($order_settings->shipping_amount_type != 'distance')
                                <div class="single-widget payments shipping_method_area none">
                                    <div class="content">
                                        <div class="checkbox shipping_render_area accordion">

                                        </div>	
                                    </div>
                                </div>
                                @endif
                                <div class="delivery-address-header">
                                    <h2><span>4 </span>Payment Method</h2>
                                </div>
                                <div class="delivery-system">
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
                                <div class="single-widget payments">
                                    <h2 class="payment-side-title"><input type="checkbox" id="pre_order" class="pre_order" name="pre_order" value="1"> <label for="pre_order">{{ __('Pre Order ?') }}</label></h2>
                                    <div class="content pre_order_area none">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ __('Delivery Date ?') }}</label>
                                                    <input type="date" name="date" class="form-control date">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ __('Delivery Time ?') }}</label>
                                                    <input type="time" id="time"  class="form-control">
                                                    <input type="hidden" name="time" class="time">
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                                <input type="hidden" id="shipping_fee" name="shipping_fee">
						        <input type="hidden" id="total_price" name="total_price">
						        <input type="hidden" id="my_lat" name="my_lat" value="{{ $meta->lat ?? '' }}">
						        <input type="hidden" id="my_long" name="my_long" value="{{ $meta->long ?? '' }}">
                                <div class="row">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-6">
                                        <div class="single-widget get-button f-right">
                                            <div class="content">
                                                <div class="button">
                                                    <button type="submit"  class="btn submit_btn submitbtn">{{ __('Proceed to checkout') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @else 
                        <div class="checkout-area">
                            <div class="alert alert-danger text-center" role="alert">
                                {{ __('No Cart Item Available For Checkout') }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    

<input type="hidden" id="subtotal" value="{{ Cart::instance('default')->subtotal() }}">
<input type="hidden" id="tax" value="{{ Cart::instance('default')->tax() }}">
<input type="hidden" id="total" value="{{ Cart::instance('default')->total() }}">
<input type="hidden" id="latitude" value="{{ tenant('lat') }}">
<input type="hidden" id="longitude" value="{{ tenant('long') }}">
<input type="hidden" id="city" value="{{ $invoice_data->store_legal_city ?? '' }}">
@endsection

@push('js')
<script src="{{ asset('theme/grocery/js/home.js') }}"></script>
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