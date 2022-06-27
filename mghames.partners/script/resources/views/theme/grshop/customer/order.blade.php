@extends('theme.grshop.customer.app')


@section('customer_content')

@php
$address=json_decode($info->shippingwithinfo->info ?? '');
$ordermeta=json_decode($info->ordermeta->value ?? '');
@endphp
<!-- Start Dashboard Section -->
<div class="row">
	<div class="col-lg-9 col-md-9 col-12">
		<div class="main-content">
			<div class="dashboard-block mt-0">
				<h3 class="block-title order-view-title"> <b>{{ __('Order Number') }} <span>{{ $info->invoice_no }}</span></b> <span class="messages-auth"><span class="badge" style="background-color: {{ $info->orderstatus->slug ?? ''  }}">{{ $info->orderstatus->name ?? '' }}</span></span></a></h3>
				<!-- Start Items Area -->
				<div class="my-items">
					<!-- Start Item List Title -->
					<div class="item-list-title">
						<div class="row align-items-center">
							<div class="col-lg-5 col-md-5 col-12">
								<p>{{ __('Item summary') }}</p>
							</div>
							<div class="col-lg-2 col-md-2 col-12">
								<p>{{ __('QTY') }}</p>
							</div>
							<div class="col-lg-2 col-md-2 col-12">
								<p>{{ __('Price') }}</p>
							</div>
							<div class="col-lg-3 col-md-3 col-12 align-right">
								<p>{{ __('Total Price') }}</p>
							</div>
						</div>
					</div>
					<!-- End List Title -->
					@foreach($info->orderitemswithpreview ?? [] as $row)
					@php
					$variations=json_decode($row->info);
					$options=$variations->options ?? [];
					@endphp
					<!-- Start Single List -->
					<div class="single-item-list  order-view-list">
						<div class="row align-items-center">
							<div class="col-lg-5 col-md-5 col-12">
								<div class="item-image">
									<img height="40" src="{{ asset($row->termwithpreview->preview->value ?? 'uploads/default.png') }}" alt="{{ $row->term->title ?? '' }}"/>
									<div class="content">
										<h3 class="title"><a href="{{ url('/product/'.$row->term->slug ?? '') }}">{{ $row->term->title ?? '' }}</a> </h3>

										@foreach ($options ?? [] as $key => $item)

										<span>{{ $key }}:</span><br>

										@foreach($item ?? [] as $r)
										<span>{{ __('Name:') }} {{ $r->name ?? '' }}</span><br>
										@if($r->price > 0)
										<span class="render_currency">{{ __('Price:') }} <span class="render_currency"> {{ number_format($r->price ?? 0,2) }}</span></span><br>
										@endif

										@endforeach
										<hr>
										@endforeach
										<div class="rating-main">
											@php
											$stars=0;
											$comment ='';
											if(array_key_exists($row->term_id,$reviews)){
												$stars=$reviews[$row->term_id]['rating'];
												$comment=$reviews[$row->term_id]['comment'];
											}
											@endphp
											<a href="javascript:void(0)" data-star="{{ $stars }}" data-comment="{{ $comment }}" data-action="{{ url('/customer/order-make-rating/'.$info->id.'/'.$row->term_id.'/'.$row->id) }}" class="text-secondary make_review" data-bs-toggle="modal" data-bs-target="#exampleModal">
												<ul class="rating">
													@for($i=1; $i <= 5; $i++)  
														<li><i class="icofont-star {{ $i <= $stars ? 'star' : '' }} "></i></li>
													@endfor
													
													
												</ul>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-4">
								<p class="it-quantity">x {{ $row->qty }}</p>
							</div>
							<div class="col-lg-2 col-md-2 col-4">
								<p class="it-price render_currency">{{ number_format($row->amount,2) }}</p>
							</div>
							<div class="col-lg-3 col-md-3 col-4 align-right">
								<p class="total-price render_currency">{{ number_format($row->amount*$row->qty,2) }}</p>
							</div>
						</div>
					</div>
					<!-- End Single List -->
					@endforeach

				</div>
				<!-- End Items Area -->
			</div>
			<!-- Customer details -->
			<div class="customer-order-details dashboard-block mt-30">
				<h3 class="orderd-title">{{ __('Your') }} <span>{{ __('Order details') }}</span></h3>
				<ul class="order-d-list">
					<li><b>{{ __('Customer Name') }}</b> <span>{{ $ordermeta->name ?? '' }}</span></li>
					<li><b>{{ __('Phone Number') }}</b> <span>{{ $ordermeta->phone ?? '' }}</span></li>

					<li><b>{{ __('Order Status') }}</b> <span class="badge" style="background-color: {{ $info->orderstatus->slug ?? ''  }}">{{ $info->orderstatus->name ?? '' }}</span></li>
					@php
					if($info->payment_status == 1){
						$payment_status='Paid';
						$payment_badge='badge-success';
					} 

					elseif($info->payment_status == 2){
						$payment_status='Pending';
						$payment_badge='badge-warning';
					} 

					else{
						$payment_status='Payment Fail';
						$payment_badge='badge-warning';
					} 


					@endphp 
					<li><b>{{ __('Payment Status') }}</b> <span class="badge {{ $payment_badge }}"> 
						{{ $payment_status }}
					</span></li>
					<li><b>{{ __('Total') }}</b> <span class="render_currency">{{ number_format($info->total ?? 0,2) }}</span></li>
					<li><b>{{ __('Note') }} :</b> <span>{{ $ordermeta->note ?? '' }}</span></li>
				</ul>
			</div>
			<!-- End Customer details -->
			<!-- Location -->
			@if(!empty($info->shippingwithinfo))
			@if(!empty($info->shippingwithinfo->lat) && !empty($info->shippingwithinfo->long))
			<div class="customer-order-details order-map mt-30">
				<h3 class="orderd-title">{{ __('Your') }} <span>{{ __('Delivery Location') }}</span></h3>
				<div class="order-map-inner">
					<div class="mapouter"><div class="gmap_canvas h-300" id="map"></div></div>
				</div>
			</div>
			@endif
			@endif
			<!-- End Customer details -->
		</div>
	</div>
	<div class="col-lg-3 col-12">
		<!-- Customer details -->
		<div class="customer-order-details order-sum dashboard-block">
			<h3 class="orderd-title">{{ __('Order') }} <span>{{ __('summary') }}</span></h3>
			<ul class="order-d-list">
				<li><b>{{ __('Order Created') }}</b> <span>{{ $info->created_at->format('D, F Y') }}</span></li>
				@if(!empty($info->shippingwithinfo))
				@if(!empty($info->shippingwithinfo->rider))
				<li><b>{{ __('Order Security Code') }} </b> <span><b>({{ $info->shippingwithinfo->tracking_no ?? '' }})</b></span></li>
				@endif
				@endif
				<li><b>{{ __('Type') }} </b> <span>{{ ucwords(str_replace('_',' ',$info->order_method ?? '')) }}</span></li>

				<li><b>{{ __('Discount') }}</b> <span class="render_currency">{{ number_format($info->discount,2)  }}</span></li>
				<li><b>{{ __('Tax') }}</b> <span class="render_currency">{{ number_format($info->tax,2)  }}</span></li>

			</ul>
		</div>
		<!-- End Customer details -->

		<!-- Total Amount -->
		<div class="customer-order-details order-sum total-am-top dashboard-block">

			<h4 class="total-amount">{{ __('Total Amount') }} <span>{{ number_format($info->total,2) }}</span></h4>

		</div>
		<!-- End Total Amount -->

		@if($info->order_method == 'delivery')
		<!-- Delivery details -->
		<div class="customer-order-details order-sum dashboard-block">
			<h3 class="orderd-title">{{ __('Delivery') }} <span>{{ __('Address') }}</span></h3>
			<ul class="order-d-list">
				<li><b>{{ __('Address Line') }}</b> <span>{{ $address->address ?? '' }}</span></li>
				@if(!empty($info->shippingwithinfo->shipping->location ?? ''))
				<li><b>{{ __('Shipping Area') }}</b> <span>{{ $info->shippingwithinfo->location->name ?? '' }}</span></li>
				@endif
				@if(!empty($info->shippingwithinfo->shipping ?? ''))
				<li><b>{{ __('Shipping Method') }}</b> <span>{{ $info->shippingwithinfo->shipping->name ?? '' }}</span></li>
				@endif
				@if(!empty($address->post_code ?? ''))
				<li><b>{{ __('Post Code') }} </b> <span>{{ $address->post_code ?? '' }}</span></li>
				@endif
				@if(!empty($info->shippingwithinfo))
				<li><b>{{ __('Delivery Fee') }}</b> <span class="render_currency">{{ number_format($info->shippingwithinfo->shipping_price,2)  }}</span></li>
				@endif
			</ul>
		</div>
		@endif
		@if(!empty($info->shippingwithinfo))
		@if(!empty($info->shippingwithinfo->rider))
		<div class="customer-order-details order-sum dashboard-block">
			<h3 class="orderd-title">{{ __('Rider') }} <span>{{ __('Details') }}</span></h3>
			<ul class="order-d-list">
				<li><b>{{ __('Rider Name') }}</b> <span>{{ $info->shippingwithinfo->rider->name ?? '' }} (#{{ $info->shippingwithinfo->user_id }})</span></li>
				<li><b>{{ __('Rider Phone') }}</b> <span>{{ $info->shippingwithinfo->rider->phone ?? '' }}</span></li>
				<li><b>{{ __('Order Security Code') }} </b> <span><b>({{ $info->shippingwithinfo->tracking_no ?? '' }})</b></span></li>

			</ul>
		</div>
		@endif
		@endif
		@if(!empty($info->schedule))
		<div class="customer-order-details order-sum dashboard-block">
			<h3 class="orderd-title">{{ __('Schedule') }} <span>{{ __('Details') }}</span></h3>
			<ul class="order-d-list">
				<li><b>{{ __('Date :') }}</b> <span>{{ $info->schedule->date ?? '' }}</span></li>
				<li><b>{{ __('Time :') }}</b> <span>{{ $info->schedule->time ?? '' }}</span></li>


			</ul>
		</div>
		@endif
		<!-- End Delivery details -->
	</div>
</div>
<!-- End Dashboard Section -->
<div class="review-modal">
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ __('Leave a feedback') }}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="post" class="form review_form ajaxform_with_reload">
					@csrf
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<label for="recipient-name" class="col-form-label">{{ __('Rating') }}</label>
							<div class="product-availity">
								<select name="rating" class="rating_option">
									<option value="5">{{ __('5 Star') }}</option>
									<option value="4">{{ __('4 Star') }}</option>
									<option value="3">{{ __('3 Star') }}</option>
									<option value="2">{{ __('2 Star') }}</option>
									<option value="1">{{ __('1 Star') }}</option>
								</select>
							</div>
						</div>
						<div class="col-sm-12">
							<label for="feedback">{{ __('Feedback') }}</label>
							<textarea id="feedback" maxlength="200" class="form-control feedback" name="feedback"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
					<button type="submit" class="btn btn-primary basicbtn">{{ __('Leave') }}</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
@if(!empty($info->shippingwithinfo))
@if(!empty($info->shippingwithinfo->lat) && !empty($info->shippingwithinfo->long))

@php
$order_settings=get_option('order_settings',true);
@endphp

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $order_settings->google_api ?? '' }}&libraries=places&sensor=false&callback=initialise"></script>
<script>
	"use strict";
  //if order type home delivery
  var resturent_lat = {{ tenant('lat') }};
  var resturent_long  = {{ tenant('long') }};
  var customer_lat = {{ $info->shippingwithinfo->lat ?? '' }};
  var customer_long = {{ $info->shippingwithinfo->long ?? '' }};
  var resturent_icon= '{{ asset('uploads/resturent.png') }}';
  var user_icon= '{{ asset('uploads/userpin.png') }}';
  var customer_name= '{{ Auth::user()->name }}';
  var resturent_name= '{{ tenant('store_name') }}';
  var mainUrl= "{{ url('/') }}";
</script>
<script src="{{ asset('admin/js/orderview.js') }}"></script>

@endif
@endif
@endpush