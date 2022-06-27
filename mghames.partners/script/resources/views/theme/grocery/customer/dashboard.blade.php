@extends('theme.grocery.customer.app')
@section('customer_content')
<!-- Start Details Lists -->
<div class="details-lists">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-6">
			<!-- Start Single List -->
			<div class="single-list primary">
				<div class="list-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.5 2a3.5 3.5 0 0 1 3.437 4.163l-.015.066a4.502 4.502 0 0 1 .303 8.428l-1.086 6.507a1 1 0 0 1-.986.836H6.847a1 1 0 0 1-.986-.836l-1.029-6.17a3 3 0 0 1-.829-5.824L4 9a6 6 0 0 1 8.574-5.421A3.496 3.496 0 0 1 15.5 2zM9 15H6.86l.834 5H9v-5zm4 0h-2v5h2v-5zm4.139 0H15v5h1.305l.834-5zM10 5C7.858 5 6.109 6.684 6.005 8.767L6 8.964l.003.17a2 2 0 0 1-1.186 1.863l-.15.059A1.001 1.001 0 0 0 5 13h12.5a2.5 2.5 0 1 0-.956-4.81l-.175.081a2 2 0 0 1-2.663-.804l-.07-.137A4 4 0 0 0 10 5zm5.5-1a1.5 1.5 0 0 0-1.287.729 6.006 6.006 0 0 1 1.24 1.764c.444-.228.93-.384 1.446-.453A1.5 1.5 0 0 0 15.5 4z"/></svg></div>
				<div class="order-list-content">
					<h3>{{ $total_orders }}</h3><p>{{ __('Total Orders') }}</p>
				</div>
			</div>
			<!-- End Single List -->
		</div>
		<div class="col-lg-6 col-md-6 col-6">
			<!-- Start Single List -->
			<div class="single-list primary dark">
				<div class="list-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 7a8 8 0 1 1 0 16 8 8 0 0 1 0-16zm0 3.5l-1.323 2.68-2.957.43 2.14 2.085-.505 2.946L12 17.25l2.645 1.39-.505-2.945 2.14-2.086-2.957-.43L12 10.5zm1-8.501L18 2v3l-1.363 1.138A9.935 9.935 0 0 0 13 5.049L13 2zm-2 0v3.05a9.935 9.935 0 0 0-3.636 1.088L6 5V2l5-.001z"/></svg></div>
				<div class="order-list-content">
					<h3>{{ $total_pending_orders }}</h3><p>{{ __('Pending Orders') }}</p>
				</div>
			</div>
			<!-- End Single List -->
		</div>
	</div>
</div>
<!-- End Details Lists -->
<div class="row">
	<div class="col-lg-7 col-md-12 col-12">
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
	<div class="col-lg-5 col-md-12 col-12">
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