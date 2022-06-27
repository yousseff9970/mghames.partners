@extends('layouts.backend.app')

@section('title','Dashboard')

@section('head')
@include('layouts.backend.partials.headersection',['title'=> $info->invoice_no,'prev'=> url('rider/order')])
@endsection

@section('content')
<div class="row" id="order">
	<div class="col-12 col-lg-8">
		@if(!empty($ordermeta))
				<div class="card card-primary">
					<div class="card-header">
						<h4 class="card-header-title">{{ __('Shipping details') }}</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								<p class="mb-0">{{ __('Customer Name') }}: {{ $ordermeta->name ?? '' }}</p>
								<p class="mb-0">{{ __('Customer Email') }}: {{ $ordermeta->email ?? '' }}</p>
								<p class="mb-0">{{ __('Customer Phone') }}: <a href="tel:+{{ $ordermeta->phone ?? '' }}">{{ $ordermeta->phone ?? '' }}</a></p>
							</div>
						</div>
						@if($info->order_method == 'delivery')
						@php
						$shipping_info=json_decode($info->shippingwithinfo->info ?? '');
						$location=$info->shippingwithinfo->location->name ?? '';
						$address=$shipping_info->address ?? '';
						@endphp
						<p class="mb-0">{{ __('Location') }}: {{ $location }}</p>
						<p class="mb-0">{{ __('Zip Code') }}: {{ $shipping_info->post_code ?? '' }}</p>
						<p class="mb-0">{{ __('Address') }}: {{ $address }}</p>
						<p class="mb-0">{{ __('Shipping Method') }}: {{ $info->shippingwithinfo->shipping->name ?? '' }}</p>
						@endif
						@if($info->order_method == 'delivery' && !empty($info->shippingwithinfo))
						<div id="map" class="map-canvas"></div>
						@endif
					</div>
				</div>
			@endif

		<div class="card card-primary">
			<div class="card-header">
						<h4 class="card-header-title">{{ __('Order Details') }}</h4>
					</div>
			<div class="card-body">
				<ul class="list-group list-group-lg list-group-flush list">
					<li class="list-group-item">
						<div class="row align-items-center">
							<div class="col-6">
								<strong>{{ __('Product') }}</strong>
							</div>
							<div class="col-3 text-right">
								<strong>{{ __('Amount') }}</strong>
							</div>
							<div class="col-3 text-right">
								<strong>{{ __('Total') }}</strong>
							</div>
						</div> 
					</li>

					@foreach($info->orderitems ?? [] as $row)
					<li class="list-group-item">
						<div class="row align-items-center">
							<div class="col-6">
								@php
								$variations=json_decode($row->info);
								$options=$variations->options ?? [];

								@endphp
								{{ $row->term->title ?? '' }} <br>
									
									
									@foreach ($options ?? [] as $key => $item)
									
									<span>{{ $key }}: </span>
										@foreach($item ?? [] as $r)
										<span> {{ $r->name ?? '' }},</span>
										@endforeach
									<hr>
									@endforeach
								</div>
								<div class="col-3 text-right">
									{{ $row->amount }} × {{ $row->qty }}
								</div>
								<div class="col-3 text-right">
									{{  number_format($row->amount*$row->qty,2) }}
								</div>
							</div> 
						</li>
						<hr>
						@endforeach
						@if($info->order_method == 'delivery')
						@php
						$shipping_price=$info->shippingwithinfo->shipping_price ?? 0;
						@endphp
						<li class="list-group-item">
							<div class="row align-items-center">
								<div class="col-6">
									{{ $info->shipping_info->shipping_method->name ?? '' }}
								</div>
								<div class="col-3 text-right">
									{{ __('Shipping Fee') }}
								</div>
								<div class="col-3 text-right">
									{{ number_format($shipping_price,2) }}
								</div>
							</div> 
						</li>
						@endif
						<li class="list-group-item">
							<div class="row align-items-center">
								<div class="col-9 text-right">{{ __('Tax') }}</div>
								<div class="col-3 text-right"> {{ number_format($info->tax,2) }} </div>
							</div> 
						</li>
						<li class="list-group-item">
							<div class="row align-items-center">
								<div class="col-9 text-right">{{ __('Discount') }}</div>
								<div class="col-3 text-right"> - {{ number_format($info->discount,2) }} </div>
							</div> 
						</li>
						
						<li class="list-group-item">
							<div class="row align-items-center">
								<div class="col-9 text-right">{{ __('Total') }}</div>
								
								<div class="col-3 text-right">{{ number_format($info->total,2) }}</div>
							</div> 
						</li>
					</ul>
				</div>
			</div>
			
		</div>
		<div class="col-12 col-lg-4">
			<div class="card-grouping">
				@if($info->status_id != 1 && $info->status_id != 2)
				<div class="card card-primary">
					<div class="card-header">
						<h4>{{ __('Update Status') }}</h4>
					</div>
					<div class="card-body">
						<div class="row">
						@if ($info->shipping->status_id == 1)
						<a class="btn btn-success btn-lg disabled col-lg-6 mt-2" href="#">{{ __('Mark As Delivery') }}</a>
						@else 
						@if ($info->shipping->status_id == 2)
						<a class="btn btn-success btn-lg disabled col-lg-6 mt-2" href="#">{{ __('Mark As Delivery') }}</a>
						@else 
						<a class="btn btn-success btn-lg col-lg-6 mt-2" href="#" data-toggle="modal" data-target="#OrderDelivery">Mark As Delivery</a>
						@endif
						@endif
						@if ($info->shipping->status_id == 2)
						<a class="btn btn-danger btn-lg disabled col-lg-5 mt-2 ml-1" href="#">{{ __('Cancel') }}</a>
						@else 
						@if ($info->shipping->status_id == 1)
						<a class="btn btn-danger btn-lg disabled col-lg-5 mt-2 ml-1" href="#">{{ __('Cancel') }}</a>
						@else 
						<a class="btn btn-danger btn-lg cancel col-lg-5 mt-2 ml-1" href="{{ route('rider.order.cancelled',$info->id) }}">{{ __('Cancel') }}</a>
						@endif
						@endif
						</div>
					</div>
				</div>
				@endif

				<div class="card card-primary">
					<div class="card-header">
						<h4>{{ __('Status') }}</h4>
					</div>
					<div class="card-body">
						<p>{{ __('Payment Status') }} 
							@if($info->payment_status==2)
							<span class="badge badge-warning float-right">{{ __('Pending') }}</span>

							@elseif($info->payment_status==1)
							<span class="badge badge-success float-right">{{ __('Paid') }}</span>

							@elseif($info->payment_status==0)
							<span class="badge badge-danger float-right">{{ __('Cancel') }}</span> 
							@elseif($info->payment_status==3)
							<span class="badge badge-danger float-right">{{ __('Incomplete') }}</span> @endif</p>
							<p>{{ __('Order Status') }}
							@if($info->status_id != null)
							<span class="badge  float-right text-white" style="background-color: {{ $info->orderstatus->slug ?? '' }}">{{ $info->orderstatus->name ?? '' }}</span>
						@endif
						</p>
						<p>{{ __('Order Type') }}
						<span class="badge badge-success float-right">{{ $info->order_method }}</span>
						</p>
					</div>
				</div>
				@if(!empty($info->schedule))
				<div class="card card-primary">
					<div class="card-header">
						<h4>{{ __('Pre Order Information') }}</h4>
					</div>
					<div class="card-body">
						<p>{{ __('Date Of Order') }}
						<span class="float-right"><b>{{ $info->schedule->date ?? '' }}</b></span>
						</p>
						<p>{{ __('Order Time') }}
						<span class="float-right"><b>{{ $info->schedule->time ?? '' }}</b></span>
						</p>
					</div>
				</div>
				@endif
				@if($info->order_method == 'table')
				<div class="card card-primary">
					<div class="card-header">
						<h4>{{ __('Table Information') }}</h4>
					</div>
					<div class="card-body">
						@foreach($info->ordertable ?? [] as $row)
						<p>{{ __('Table No :') }}
						<a href="{{ route('seller.table.edit',$row->id) }}"><span class="float-right"><b>{{ $row->name }}</b></span></a>
						</p>
						@endforeach
					</div>
				</div>
				@endif
				<div class="card card-primary">
					<div class="card-header">
						<h4>{{ __('Payment Mode') }}</h4>
					</div>
					<div class="card-body">
						@if($info->getway_id  != null)
						<p>{{ __('Transaction Method') }}  <span class="badge  badge-success  float-right">{{ $info->getway->name ?? '' }} </span></p>
						
						@else
						<p>{{ __('Incomplete Payment') }}</p>
						@endif
					</div>
				</div>
				@if(!empty($ordermeta->comment ?? ''))
				<div class="card card-primary">
					<div class="card-header">
						<h4 class="card-header-title">{{ __('Note') }}</h4>
					</div>
					<div class="card-body">
						<p class="mb-0">{{ $ordermeta->comment ?? '' }}</p>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>	
</div>

@section('modal')
<div class="modal fade" id="OrderDelivery" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Delivery Complete ?') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ route('rider.order.delivered') }}" method="POST" class="ajaxform_with_reload">
            @csrf
            <div class="modal-body">
            	@if(!empty($info->user_id))
                <div class="form-group">
                    <label for="tracking_no" class="col-form-label">{{ __('Enter Confirmation OTP:') }}</label>
                    <input type="number" name="otp" class="form-control" id="tracking_no" required="">
                </div>
                @endif
                <input type="hidden" name="order_id" value="{{ $info->id }}"> 
				<input type="hidden" name="shipping_id" value="{{ $info->shippingwithinfo->id }}">
                <div class="form-group">
                    <label for="status">{{ __('Order Status') }}</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">{{ __('Delivered') }}</option>
                    </select>
                </div>
                @if($info->payment_status != 1)
                <div class="form-group">
                    <label for="payment_status">{{ __('Have you received the payment?') }}</label>
                    <select name="payment_status" id="payment_status" class="form-control selectric">
                        <option value="1">{{ __('Yes') }}</option>
                        <option value="2">{{ __('No') }}</option>
                    </select>
                </div>
                @endif
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('Delivered') }}</button>
            </div>
        </form>
    </div>
    </div>
</div>

@endsection
@endsection

@push('script')
@if($info->order_method == 'delivery' && !empty($info->shippingwithinfo))
@php
$order_settings=get_option('order_settings',true);
@endphp
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $order_settings->google_api ?? '' }}&libraries=places&sensor=false&callback=initialise"></script>
<script>
	"use strict";
	var resturent_lat = {{ tenant('lat') ?? 0.00 }};
	var resturent_long  = {{ tenant('long') ?? 0.00 }};
	var customer_lat = {{ $info->shippingwithinfo->lat ?? 0.00 }};
	var customer_long = {{ $info->shippingwithinfo->long ?? 0.00  }};
	var resturent_icon= '{{ asset('uploads/resturent.png') }}';
	var user_icon= '{{ asset('uploads/userpin.png') }}';

	var customer_name= '{{ $info->user->name ?? 'customer' }}';
	var resturent_name= '{{ tenant('id') }}';
	var mainUrl= "{{ url('/') }}";

	function initialise(){
	var map;
	var resturent = new google.maps.LatLng(resturent_lat,resturent_long);
	var customer = new google.maps.LatLng(customer_lat,customer_long);
	var option ={
		zoom : 10,
		center : resturent, 
	};
	map = new google.maps.Map(document.getElementById('map'),option);
	var display = new google.maps.DirectionsRenderer({polylineOptions: {
		strokeColor: "rgba(255, 0, 0, 0.5)"
	}});
	var services = new google.maps.DirectionsService();
	display.setMap(map);
	calculateroute();

	function calculateroute(){
		var request ={
		origin : resturent,
		destination:customer,
		travelMode: 'DRIVING'
		};
		services.route(request,function(result,status){

		if(status =='OK'){
			display.setDirections(result);
			display.setOptions( { suppressMarkers: true } );
			var leg = result.routes[ 0 ].legs[ 0 ];
			makeMarker( leg.start_location, resturent_icon, resturent_name );
			makeMarker( leg.end_location, user_icon, customer_name );
		}
		});
	}
	function makeMarker( position, icon, title ) {
	new google.maps.Marker({
		position: position,
		map: map,
		icon: icon,
		title: title
	});
	}
	}
</script>
@endpush
@endif