@extends('theme.grshop.customer.app')
@section('customer_content')
<!-- Start Dashboard Section -->
<div class="row">
	<div class="col-lg-12 col-md-12 col-12">
		<div class="main-content">
			<div class="dashboard-block mt-0">
				<h3 class="block-title">{{ __('My Orders') }}</h3>
				<!-- Start Items Area -->
				<div class="my-items">
					<!-- Start Item List Title -->
					<div class="item-list-title">
						<div class="row align-items-center">
							<div class="col-lg-4 col-md-4 col-12">
								<p>{{ __('Order No') }}</p>
							</div>
							<div class="col-lg-2 col-md-2 col-12">
								<p>{{ __('Total Items') }}</p>
							</div>
							<div class="col-lg-2 col-md-2 col-12">
								<p>{{ __('Order Status') }}</p>
							</div>
							<div class="col-lg-2 col-md-2 col-12">
								<p>{{ __('Payment Status') }}</p>
							</div>
							<div class="col-lg-2 col-md-2 col-12">
								<p>{{ __('Placed At') }}</p>
							</div>
							
						</div>
					</div>
					<!-- End List Title -->
					<!-- Start Single List -->
					@foreach($orders as $row)
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
							<div class="col-lg-2 col-md-2 col-12">
								<div class="single-item-inner category" data-title="Total Items">
									<p>{{ $row->orderitems_count }}</p>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-12">
								<div class="single-item-inner conditions" data-title="Order Status">
									<p><span class="badge" style="background-color: {{ $row->orderstatus->slug ?? ''  }}">{{ $row->orderstatus->name ?? '' }}</span></p>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-12">
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
								<div class="single-item-inner category" data-title="Order Updated At">
									<p>{{ $row->updated_at->diffForHumans() }}</p>
								</div>
							</div>
							
						</div>
					</div>
					@endforeach
					<!-- End Single List -->


					<!-- End Single List -->
					<!-- Pagination -->
					<div class="pagination-area left">
						 {{ $orders->links('vendor.pagination.bootstrap-4') }}
					</div>
					<!--/ End Pagination -->
				</div>
				<!-- End Items Area -->
			</div>
		</div>
	</div>
</div>
<!-- End Dashboard Section -->
@endsection