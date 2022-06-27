@extends('theme.resto.customer.app')
@section('customer_content')
<!-- Start Details Lists -->
<div class="details-lists">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-6">
			<!-- Start Single List -->
			<div class="single-list primary">
				<div class="list-icon"><i class="icofont-fast-food"></i></div>
				<h3>{{ $total_orders }}<span>{{ __('Total Orders') }}</span></h3>
			</div>
			<!-- End Single List -->
		</div>
		<div class="col-lg-6 col-md-6 col-6">
			<!-- Start Single List -->
			<div class="single-list dark">
				<div class="list-icon"><i class="icofont-sand-clock"></i></div>
				<h3>{{ $total_pending_orders }}<span>{{ __('Pending Orders') }}</span></h3>
			</div>
			<!-- End Single List -->
		</div>
	</div>
</div>
<!-- End Details Lists -->
<div class="row">
	<div class="col-lg-6 col-md-12 col-12">
		<!-- Start Activity Log -->
		<div class="activity-log dashboard-block">
			<h3 class="block-title">{{ __('My Recent Orders') }}</h3>

			<div class="my-items">
				<div class="item-list-title">
					<div class="row align-items-center">
						<div class="col-lg-4 col-md-4 col-12">
							<p>{{ __('Order') }}</p>
						</div>

						<div class="col-lg-3 col-md-3 col-12">
							<p>{{ __('Status') }}</p>
						</div>
						<div class="col-lg-3 col-md-3 col-12">
							<p>{{ __('Payment') }}</p>
						</div>
						<div class="col-lg-2 col-md-2 col-12">
							<p>{{ __('Date') }}</p>
						</div>

					</div>
				</div>
				@foreach($orders ?? [] as $row)
				<div class="single-item-list">
					<div class="row align-items-center">
						<div class="col-lg-4 col-md-4 col-12">
							<div class="single-item-inner image-top" data-title="Order No">
								<div class="item-image">

									<div class="content">
										<h3 class="title">
											<a class="text-primary" href="{{ url('/customer/order/'.$row->id) }}">{{ $row->invoice_no }}</a>
										</h3>
										<span class="price render_currency">{{ number_format($row->total,2) }}</span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-md-3 col-12">
							<div class="single-item-inner conditions" data-title="Order Status">
								<p><span class="badge" style="background-color: {{ $row->orderstatus->slug ?? ''  }}">{{ $row->orderstatus->name ?? '' }}</span></p>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-12">
							<div class="single-item-inner conditions" data-title="Payment Status">
								@php
								if($row->payment_status == 1){
									$payment_status='Paid';
									$payment_badge='badge-success';
								} 

								elseif($row->payment_status == 2){
									$payment_status='Pending';
									$payment_badge='badge-warning';
								} 

								else{
									$payment_status='Payment Fail';
									$payment_badge='badge-warning';
								} 


								@endphp 

								<p><span class="badge {{ $payment_badge }}"> 
									{{ $payment_status }}
								</span></p>

							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-12">
							<div class="single-item-inner category" data-title="Placed At">
								<p>{{ $row->created_at->diffForHumans() }}</p>
							</div>
						</div>

					</div>
				</div>
				@endforeach
			</div>
			
		</div>
		<!-- End Activity Log -->
	</div>
	<div class="col-lg-6 col-md-12 col-12">
		<!-- Start Recent Items -->
		<div class="recent-items dashboard-block row">

			<h3 class="block-title">{{ __('Welcome') }}</h3>
			<p>{{ __('Hello') }} <strong>{{ Auth::user()->name }} (not <strong>{{ Auth::user()->name  }}</strong>?
				<a class="text-success" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>)</p>

				<p>{{ __('From your account dashboard you can view your') }} <a class="text-success" href="{{ url('/customer/orders') }}">{{ __('recent orders') }}</a> and <a class="text-success" href="{{ url('/customer/settings') }}">{{ __('edit your password and account details') }} </a>.</p>
			</div>
			<!-- End Recent Items -->
		</div>
	</div>
	@endsection