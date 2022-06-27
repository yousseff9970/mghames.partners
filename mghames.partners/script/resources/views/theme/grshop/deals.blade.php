@extends('theme.grshop.layouts.app')
@section('content')

<!-- Breadcrumbs -->
<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner  gr-overlay" style="background-image:url({{ asset($products_page_banner)  }})">
					<div class="row">
						<!-- Breadcrumb-Content -->
						<div class="col-lg-6 col-md-8 col-12">
							<div class="breadcrumb-content">
								<h2>{{ $page_title }}</h2>
								<p>{{ $products_page_description }}</p>
								<ul class="breadcrumb-nav">
									<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
									<li><i class="icofont-fast-food"></i> {{ $page_title }}</li>
								</ul>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Breadcrumbs -->

<!-- Product Style -->
<section class="product-area shop-sidebar shop p-top-40 p-btm-70">
	<div class="container">
		<div class="row">
			
			<div class="col-lg-12 col-md-12 col-12 col-main">
				<div class="category-grid-list">
					<div class="row">
						
						<div class="col-12">
							<div class="category-grid-topbar">
								<h3 class="title">{{ __('Showing') }} <span class="from_products">0</span>- <span class="to_products">-</span> {{ __('of') }} <span class="total_products"></span> {{ __('Products found') }}</h3>
								<!-- Shop Top -->
								<div class="shop-top">
									<div class="shop-shorter">
										<div class="single-shorter">
											<label>{{ __('Show :') }}</label>
											<select id="product_limit">
												<option value="12" selected="selected">{{ __('12') }}</option>
												<option value="25">{{ __('25') }}</option>
												<option value="35">{{ __('35') }}</option>
												<option value="45">{{ __('45') }}</option>
											</select>
										</div>
										<div class="single-shorter">
											<label>{{ __('Sort By :') }}</label>
											<select id="order_by">
												<option value="DESC">{{ __('Short By latest') }}</option>
												<option value="ASC">{{ __('Default Shorting') }}</option>
												<option value="rating">{{ __('Short By Reviews') }}</option>
											</select>
										</div>
									</div>
								</div>
								<!--/ End Shop Top -->
								<div class="shop-navigation-menu">
									<div class="filter-menu"><i class="icofont-filter"></i><span>Filter</span></div>
									<nav>
										<div class="nav nav-tabs" id="nav-tab" role="tablist">
											<button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab" data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid" aria-selected="true" > <i class="icofont-calendar"></i></button>
											<button class="nav-link" id="nav-list-tab" data-bs-toggle="tab" data-bs-target="#nav-list" type="button" role="tab" aria-controls="nav-list" aria-selected="false"><i class="icofont-listing-box"></i></button>
										</div>
									</nav>
								</div>
							</div>
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
									<div class="row primary_products_area">
										<h6 class="text-center mt-2 none zero_product">{{ __('0 Product available') }}</h6>
										
									</div>
								</div>
								<div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
									<div class="row ">
										<div class="col-12 grid_products_area">
											<h6 class="text-center mt-2 none zero_product">{{ __('0 Product available') }}</h6>
											
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<!-- Pagination -->
									<div class="pagination left">
										<ul class="pagination-list">
											
										</ul>
									</div>
									<!--/ End Pagination -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
 @include('theme.grshop.components.quickview')
<!--/ End Product Style 1  -->	
<input type="hidden" id="cat" value="{{ $categoryid ?? '' }}">
<input type="hidden" id="term_src" value="{{ $request->src ?? '' }}">
@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
<script src="{{ asset('theme/jquery.unveil.js') }}"></script>
<script src="{{ asset('theme/grshop/js/deal.js') }}"></script>
@endpush