@extends('theme.resto.layouts.app')
@section('content')
	<!-- Start Breadcrumbs Area -->
		<div class="breadcrumbs" style="background-image:url({{ asset($products_page_banner)  }})">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-8 col-12">
						<div class="breadcrumbs-content">
							<h1 class="page-title">{{ $page_title }}</h1>
							<p>{{ $products_page_description }}</p>
						</div>
						<ul class="breadcrumb-nav">
							<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
							<li><i class="icofont-fast-food"></i> {{ $page_title }}</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Breadcrumbs Area -->
		
		
		<!-- Start Items Listing Grid -->
		<section class="category-page section">
			<div class="container">
				<div class="row">
					<div class="col-lg-9 col-12">
						<div class="category-grid-list">
							<div class="row">
								<div class="col-12">
									<div class="category-grid-topbar">
										<div class="row align-items-center">
											<div class="col-lg-6 col-md-6 col-12">
												<h3 class="title">{{ __('Showing') }} <span class="from_products">0</span>- <span class="to_products">-</span> {{ __('of') }} <span class="total_products"></span> {{ __('Products found') }}</h3>
											</div>
											<div class="col-lg-6 col-md-6 col-12">
												<nav>
													<div class="nav nav-tabs" id="nav-tab" role="tablist">
														<button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab" data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid" aria-selected="true" > <i class="icofont-calendar"></i></button>
														<button class="nav-link" id="nav-list-tab" data-bs-toggle="tab" data-bs-target="#nav-list" type="button" role="tab" aria-controls="nav-list" aria-selected="false"><i class="icofont-listing-box"></i></button>
													</div>
												</nav>
											</div>
										</div>
									</div>
									<div class="tab-content" id="nav-tabContent">
										<div class="tab-pane fade show active" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
											<h6 class="text-center mt-2 none zero_product">{{ __('0 Product available') }}</h6>
											<div class="row latest_products">
												
												
											</div>
										</div>
										<div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
											<h6 class="text-center mt-2 none zero_product">{{ __('0 Product available') }}</h6>
											<div class="row listviewproducts">
												
												
											</div>
										</div>

										<div class="row">
											<div class="col-12">
												<div class="pagination left">
													<ul class="pagination-list">

													</ul>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-lg-3 col-12">
						<div class="category-sidebar">
							<!-- Single Widget -->
							@if(!empty($products_page_product_ads_link))
							<div class="single-widget">
								<h3 class="wd-title">{{ __('Special Offer') }}</h3>
								<div class="recommend-img">
									<a href="{{ url($products_page_product_ads_link) }}"><img src="{{ asset($products_page_product_ads_banner) }}" alt=""></a>
								</div>
							</div>
							@endif
							<!-- End Single Widget -->
							<div class="single-widget categories-widget food category_area">
								<h3 class="wd-title">{{ __('Categories') }}</h3>
								<ul class="custom product_menu">
									<li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
									<li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
									<li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
									<li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
									<li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
								</ul>
							</div>
							<div class="single-widget categories-widget food none brand_area">
								<h4 class="wd-title">{{ __('Brands') }}</h4>
								<ul class="custom product_brands">
								</ul>
							</div>
							
							<!-- Start Single Widget -->
							<div class="single-widget hot-product featured_area none">
								<h3 class="wd-title featured_title"></h3>
								<ul class="all-products featured_products">
									
									
								</ul>
							</div>
							<!-- End Single Widget -->
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Items Listing Grid -->
<input type="hidden" id="cat" value="{{ $categoryid ?? '' }}">

@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
<script src="{{ asset('theme/jquery.unveil.js') }}"></script>
<script src="{{ asset('theme/resto/js/products.js') }}"></script>
@endpush