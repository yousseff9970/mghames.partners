@extends('theme.grshop.layouts.app')
@section('content')
<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner  gr-overlay" style="background-image:url({{ asset($home_data->product_page_banner ?? '')  }})">
					<div class="row">
						<!-- Breadcrumb-Content -->
						<div class="col-lg-6 col-md-8 col-12">
							<div class="breadcrumb-content">
								<h2 class="page-title">{{ $info->title }}</h2>
								<p>{{ $info->excerpt->value ?? ''  }}</p>
								<ul class="breadcrumb-nav">
									<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
									<li><i class="icofont-fast-food"></i> {{ $info->title }}</li>
								</ul>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Shop Single -->
<section class="shop single section">
	<div class="container">
		<div class="row"> 
			<div class="col-12">
				<div class="row">
					<div class="col-lg-5 col-md-5 col-12">
						<!-- Product Slider -->
						<div class="product-gallery">
							<!-- Images slider -->
							<div class="flexslider-thumbnails">
								<ul class="slides">
									@foreach($galleries ?? [] as $key => $row)
									<li data-thumb="{{ asset($row) }}" @if($key == 0) rel="adjustX:10, adjustY:" @endif>
										<img src="{{ asset($row) }}" alt="{{ $info->title }}">
									</li>
									@endforeach
									
								</ul>
							</div>
							<!-- End Images slider -->
						</div>
						<!-- End Product slider -->
					</div>
					<div class="col-lg-7  col-md-7 col-12">
						<div class="product-des">
							<!-- Description -->
							<div class="short">
								<div class="title-n-desc">
									<h2>{{ $info->title }}</h2>
									
								</div>
								@if($info->rating != null && $info->rating != 0)
								<div class="rating-main">
									<ul class="rating">
										@for ($i=1; $i <= 5; $i++) 
										<li><i class="icofont-star {{ $i <= $info->rating ? 'star' : '' }}"></i></li>
										@endfor
										
										
									</ul>
									<a href="#" class="total-review"> {{ number_format($info->rating,2) }} | ({{ $info->reviews_count }}) {{ __('Reviews') }}</a>
								</div>
								@endif
								<p class="price price_area">{{ count($info->optionwithcategories ?? []) == 0 ? $info->price->price ?? '' : '' }} </p>
								<div class="product-tag stock_status @if(count($info->optionwithcategories ?? []) != 0) none @endif"><p class="cat">Availability: <span class="stock_status_display">@if(count($info->optionwithcategories ?? []) == 0) <a href="javascript:void(0)"> {{ $info->price->stock_status == 1 ? 'In Stock' : 'Out of stock' }} </a> @endif</span></p></div>
								<p class="description">{{ $info->excerpt->value ?? ''  }}</p>
							</div>	
							
							<!--/ End Description -->
							<div class="option-colors">										
								<form class="product_option_form" method="post" action="{{ route('add.tocart') }}">
								 	@csrf
								 	<input type="hidden" name="id" value="{{ $info->id }}">
								 	@if(count($info->optionwithcategories ?? []) == 0)
								 	<input 
										class=" none pricesvariationshide" 
										data-stockstatus="{{ $info->price->stock_status }}"  
										data-stockmanage="{{ $info->price->stock_manage }}" 
										data-sku="{{ $info->price->sku }}" 
										data-qty="{{ $info->price->qty }}"  
										data-oldprice="{{ $info->price->old_price }}" 
										data-price="{{ $info->price->price }}" 
										type="radio" 
										checked
										>
									@else
									 @include('theme.grshop.components.variations',['info'=>$info ?? ''])	
								    @endif		
								<!--/ End Description -->
								
								
								 
							</div>

							<!-- Product Buy -->
							<div class="product-buy">
								<div class="quantity">
									<h6>{{ __('Quantity') }} :</h6>
									<!-- Input Order -->
									<div class="input-group">
										<div class="button minus">
											<button type="button" class="btn btn-primary btn-number minus_qty"  data-type="minus" data-field="quant[1]">
												<i class="icofont-minus"></i>
											</button>
										</div>
										<input type="number"   class="input-number input_qty" name="qty"  data-min="1" data-max="10" value="1">
										<div class="button plus">
											<button type="button" class="btn btn-primary btn-number qty_increase" data-type="plus" data-field="quant[1]">
												<i class="icofont-plus"></i>
											</button>
										</div>
									</div>
									<!--/ End Input Order -->
								</div>
								<div class="add-to-cart">
									
									<button type="submit" class="btn add_to_cart_btn">{{ __('Add to cart') }}</button>
									<a href="javascript:void(0)" data-id="{{ $info->id }}" class="btn min wishlist_btn wishlist_row"><i class="icofont-heart"></i></a>
									
								</div>
								@if(count($info->category ?? []) != 0)
								<p class="cat">{{ __('Category') }} : 
									@foreach($info->category ?? [] as $row)
									<a href="{{ url('/category',$row->slug) }}" class="categories" data-id="{{ $row->id }}">{{ $row->name }}</a>
								    @endforeach
								 </p>
								 @endif
								 @if(count($info->brands ?? []) != 0)
								<p class="cat">{{ __('Brand') }} : 
									@foreach($info->brands ?? [] as $row)
									<a href="{{ url('/brand',$row->slug) }}" class="categories" data-id="{{ $row->id }}">{{ $row->name }}</a>
									@endforeach
								 </p>
								 @endif
								 @if(count($info->tags ?? []) != 0)
								 <p class="cat">{{ __('Tags') }} : 
									@foreach($info->tags ?? [] as $row)
									<a href="{{ url('/tag',$row->slug) }}" class="text-dark categories"  data-id="{{ $row->id }}">{{ $row->name }}</a>
								    @endforeach
								 </p>
								 @endif
								
								<p class="availability none qty_display">{{ __('Availability') }} : <span class="maxqty"></span> {{ __('Products In Stock') }}</p>
							</div>
							</form>
							<!--/ End Product Buy -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--/ End Shop Single -->

<section class="product-detail-tabs bg-white">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
				<div class="section-title text-center m-btm-30">
					<p class="small-title font-stylish m-btm-10 pr-color">{{ $home_data->product_page__detail_short_title ?? '' }}</p>
					<h2 class="s-content-title">{{ $home_data->product_page_detail_title ?? '' }}</h2>
				</div>
				<!-- Tab Menu -->
				<div class="latest-home-tabs single text-center">
					<ul class="list-group" id="list-tab" role="tablist">
						<li><a class="list-group-item active" data-bs-toggle="list" href="#desc-tab" role="tab"><i class="icofont-fast-food"></i>{{ __('Description') }} </a></li>
						<li><a class="list-group-item" data-bs-toggle="list" href="#review-tab" role="tab"><i class="icofont-food-basket"></i>{{ __('Reviews') }}</a></li>
					</ul>
				</div>
				<!-- End Tab Menu -->
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="desc-tab" role="tabpanel" aria-labelledby="desc-tab">
						<div class="product-info">
							<div class="row ">
								{{ content_format($info->description->value ?? '') }}
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="review-tab" role="tabpanel" aria-labelledby="review-tab" >
						<div class="tab-single reviews-panel">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-12">
									<div class="ratting-main">
										<div class="avg-ratting">
											@if($info->rating != null && $info->rating != 0)
											<h4>{{ number_format($info->rating,2) }} <span>(Overall)</span></h4>
											<span>Based on {{ $info->reviews_count }} Comments</span>
											@endif
										</div>
										
										
										
									</div>
									<nav aria-label="navigation ">
										<ul class="pagination pagination-sm">
										</ul>
									</nav>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@php
$status=$home_data->related_product_status ?? 'yes';
@endphp
<!-- Products Area -->
@if($status == 'yes')
<section class="products-area related section-padding">
	<div class="container">	
		<div class="row align-items-center">
			<div class="col-lg-6 col-md-8 col-12">
				<div class="section-title m-btm-30">
					<p class="small-title font-stylish m-btm-10 pr-color">{{ $home_data->product_page_related_short_title ?? '' }}</p>
					<h2 class="s-content-title">{{ $home_data->product_page_related_title ?? '' }}</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="product-area-main">
					<div class="related-slider related-slider related_product_slider_preloader">
					</div>
					<div class="related-slider related-sliders">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endif
<!-- End Products Area -->
 @include('theme.grshop.components.quickview')
@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
<script src="{{ asset('theme/jquery.unveil.js') }}"></script>
<script src="{{ asset('theme/grshop/js/details.js') }}"></script>

<script type="text/javascript">
"use strict";

getreviews(base_url+'/get-product-reviews/'+{{$info->id}});	
</script>
@endpush