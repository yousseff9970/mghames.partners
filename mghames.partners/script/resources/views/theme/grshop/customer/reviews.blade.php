@extends('theme.grshop.customer.app')
@section('customer_content')
<!-- Start Dashboard Section -->
<div class="row">
	<div class="col-lg-12 col-md-12 col-12">
		<div class="main-content">
			<div class="dashboard-block mt-0">
				<h3 class="block-title">{{ __('My Reviews') }}</h3>
				<!-- Start Items Area -->
				<div class="my-items">
					<!-- Start Item List Title -->
					<div class="item-list-title">
						<div class="row align-items-center">
							<div class="col-lg-2 col-md-2 col-12">
								<p>{{ __('Order No') }}</p>
							</div>
							<div class="col-lg-3 col-md-3 col-12">
								<p>{{ __('Rating') }}</p>
							</div>
							<div class="col-lg-2 col-md-2 col-12">
								<p>{{ __('Placed At') }}</p>
							</div>
							<div class="col-lg-5 col-md-5 col-12">
								<p>{{ __('Comment') }}</p>
							</div>
							
							
						</div>
					</div>
					<!-- End List Title -->
					<!-- Start Single List -->
					@foreach($posts as $row)
					<div class="single-item-list">
						<div class="row align-items-center">
							<div class="col-lg-2 col-md-2 col-12">
								<div class="single-item-inner image-top" data-title="Order No">
									<div class="item-image">
										
										<div class="content">
											<h3 class="title">
												<a  href="{{ url('/customer/order/'.$row->order_id) }}">{{ $row->order->invoice_no }}</a>
											</h3>
											
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-3 col-md-3 col-12">
								<div class="single-item-inner conditions" data-title="Rating">
									<div class="rating-main">
									<ul class="rating">
									@for($i=1; $i <= 5; $i++)  
									<li><i class="icofont-star {{ $i <= $row->rating ? 'star' : '' }} "></i></li>
									@endfor
								    </ul>
								   </div>
								</div>
							</div>
							
							<div class="col-lg-2 col-md-2 col-12">
								<div class="single-item-inner category" data-title="Created At">
									<p>{{ $row->updated_at->diffForHumans() }}</p>
								</div>
							</div>

							<div class="col-lg-5 col-md-5 col-12">
								<div class="single-item-inner conditions" data-title="Comments">
									
									<p>{{ $row->comment }}</p>
									
									
								</div>
							</div>
							
						</div>
					</div>
					@endforeach
					<!-- End Single List -->


					<!-- End Single List -->
					<!-- Pagination -->
					<div class="pagination left">
						 {{ $posts->links('vendor.pagination.bootstrap-4') }}
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