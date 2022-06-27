@extends('theme.resto.layouts.app')
@section('content')
<!-- Start Breadcrumbs Area -->
<div class="breadcrumbs" style="background-image:url({{ asset($page_data->meta_image ?? '')  }})">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-8 col-12">
				<div class="breadcrumbs-content">
					<h1 class="page-title">{{ $page_data->menu_page_title ?? 'Our menu' }}</h1>
					<p>{{ $page_data->menu_page_description ?? '' }}</p>
				</div>
				<ul class="breadcrumb-nav">
					<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
					<li><i class="icofont-fast-food"></i> {{ $page_data->menu_page_title ?? '' }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!--/ End Breadcrumbs Area -->


<!-- start login section -->
<section class="food-menu section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-8 col-12">
				<div class="section__title text-left mb-0">
					<h2 class="main__title"><span></span>{{ $page_data->menu_product_section_title ?? '' }}</h2>
					<p class="section__text">
						{{ $page_data->menu_product_section_description ?? '' }}
					</p>
					<div class="waves-block">
						<div class="waves wave-1"></div>
						<div class="waves wave-2"></div>
						<div class="waves wave-3"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-9 col-m-6 col-12">
				<div class="top-content-addon">
					<h6 class="text-center mt-2 none zero_product">{{ __('0 Product available') }}</h6>
					<div class="row product_area ">
						
						
						


						

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
			<div class="col-lg-3 col-12">
				<div class="food-menu-sidebar">
					<div class="single-food-sidebar categories-widget food">
						<h4 class="title">{{ __('Our Catalog') }}</h4>
						<ul class="custom product_menu">
							
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						    <li class="menu_preload content-preloader  content-placeholder" data-height="40px"  data-width="100%"></li>
						   
							
							
						</ul>
					</div>
					@if(!empty($page_data->menu_page_product_ads_link ?? ''))
					<div class="single-widget mt-4">
						
						<div >
							<a href="{{ url($page_data->menu_page_product_ads_link ?? '') }}"><img src="{{ asset($page_data->menu_page_product_ads_banner ?? '') }}" alt=""></a>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end login section -->



@endsection
@push('js')
<script src="{{ asset('theme/resto/js/product-menu.js') }}"></script>
@endpush