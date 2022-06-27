@extends('theme.resto.layouts.app')
@section('content')

		<!-- Start Breadcrumbs Area -->
		<div class="breadcrumbs" style="background-image: url({{ asset($home_data->product_page_banner ?? '')  }}); ">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-8 col-12">
						<div class="breadcrumbs-content">
							<h1 class="page-title">{{ $info->title }}</h1>
							<p>{{ $info->excerpt->value ?? ''  }}</p>
						</div>
						<ul class="breadcrumb-nav">
							<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
							<li><i class="icofont-fast-food"></i> {{ $info->title }}</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Breadcrumbs Area -->
		
		<!-- Shop Single -->
		<section class="shop single section">
			<div class="container">
				<div class="top-content">
					<div class="row align-items-center">
						<div class="col-lg-5 col-12">
							<!-- product details image -->
							<div class="product-details-image">
								<div class="main-preview-image">
									<div class="tab-content product-image" id="pills-tabContent">
										@foreach($galleries ?? [] as $key => $row)
										<div class="tab-pane fade  {{ $key == 0 ? 'show active' : '' }} " id="pills-home{{ $key }}" role="tabpanel" aria-labelledby="pills-home-tab{{ $key }}">
											<div class="single-product-image">
												<img src="{{ asset($row) }}" alt="{{ $info->title }}">
											</div>
										</div>
										@endforeach
										
										
										
									</div>
								</div>
								<ul class="nav-pills nav flex-nowrap product-thumbs" id="pills-tab" role="tablist">
									
									@foreach($galleries ?? [] as $key => $row)
									<li class="single-thumbs" role="presentation">
										<a class="{{ $key == 0 ? 'active' : '' }} " id="pills-home-tab{{ $key }}" data-bs-toggle="pill" href="#pills-home{{$key}}" role="tab" aria-controls="pills-home" aria-selected="true">
											<img height="100" src="{{ asset($row) }}" alt="{{ $info->title }}">
										</a>
									</li>
									@endforeach

									
									
									
								</ul>
							</div>
							<!-- product details image -->
						</div>
						<div class="col-lg-6 col-12">
							<div class="single-item-des">
								<!-- Description -->
								<div class="short">
									<h4>{{ $info->title }}</h4>
									
									<div class="rating-main">
										<ul class="rating">
											@for ($i=1; $i <= 5; $i++) 
											<li><i class="icofont-star {{ $i <= $info->rating ? 'star' : '' }}"></i></li>
											@endfor
										</ul>
										<a href="javascript:void(0)" class="total-review">({{ $info->reviews_count }}) Reviews</a>
									</div>

									<p class="price price_area"> {{ count($info->optionwithcategories ?? []) == 0 ? $info->price->price ?? '' : '' }} </p>
									<div class="product-tag stock_status @if(count($info->optionwithcategories ?? []) != 0) none @endif"><p class="cat">Availability: <span class="stock_status_display">@if(count($info->optionwithcategories ?? []) == 0) <a href="javascript:void(0)"> {{ $info->price->stock_status == 1 ? 'In Stock' : 'Out of stock' }} </a> @endif</span></p></div>
									<p class="description">
										{{ $info->excerpt->value ?? ''  }}
									</p>
								</div>
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
								   @endif		
								<!--/ End Description -->
								@include('theme.resto.components.variations',['info'=>$info ?? ''])
								<!-- Product Buy -->
								<div class="product-buy">
									<div class="quantity">
										<h6>{{ __('Quantity') }} :</h6>
										<div class="quantity-container product-quantity">
											<div class="sp-quantity single-page">
											  <button type="button" class="inline arrow sp-minus   fff"><a class="ddd minus" data-multi="-1">-</a></button>
											  <div class="inline sp-input">
												<input type="text" class="quntity-input input_qty" name="qty" value="1">
											  </div>
											  <button type="button" class="inline arrow sp-plus  fff"><a class="ddd cart_increase plus" data-multi="1">+</a></button>
											</div>
										</div>
									</div>
									<div class="add-to-cart button"><button type="submit" class="btn add_to_cart_form_btn">{{ __('Add to cart') }}</button></div>

								</div>
								<p class="text-danger none qty_display"><span class="maxqty"></span> : {{ __('pieces available') }}</p>
								 </form>
								<!--/ End Product Buy -->
								@if(count($info->category ?? []) != 0)
								<div class="product-tag"><p class="cat">{{ __('Category') }} : 
									@foreach($info->category ?? [] as $row)
									<a href="{{ url('/category',$row->slug) }}" class="categories" data-id="{{ $row->id }}">{{ $row->name }}</a>
									
								    @endforeach
							       </p></div>
								@endif
								@if(count($info->category ?? []) != 0)
								<div class="product-tag"><p class="cat">{{ __('Brand') }} : 
									@foreach($info->brands ?? [] as $row)
									<a href="{{ url('/brand',$row->slug) }}">{{ $row->name }}</a>
								    @endforeach
							       </p></div>
								@endif
								@if(count($info->category ?? []) != 0)
								<div class="product-tag"><p>{{ __('Tags') }} : 
									@foreach($info->tags ?? [] as $row)
									<a href="{{ url('/tag',$row->slug) }}" class="text-dark">{{ $row->name }}</a>,
								    @endforeach
							       </p></div>
								@endif
							</div>
						</div>


					</div>
				</div>
				
				<div class="product-info">
					<div class="row">
						<div class="col-lg-6 col-12">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">{{ __('Description') }}</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">{{ __('Reviews') }}</button>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
									<div class="tab-single">
										<div class="row">
											<div class="col-12">
												<div class="single-des">
													<h4>{{ __('Overview:') }}</h4>
													{{ content_format($info->description->value ?? '') }}
												</div>
												
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
									<div class="tab-single reviews-panel">
										<div class="row">
											<div class="col-12">
												<div class="ratting-main">
													<div class="avg-ratting">
														<h4>{{ $info->rating }} <span>(Overall)</span></h4>
														<span>Based on {{ $info->reviews_count }} Comments</span>
													</div>
													
												</div>
												<nav aria-label="navigation ">
													<ul class="pagination pagination-sm">
													</ul>
												</nav>
												
												<!-- Review -->
												
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="product-more">
								<div class="row">
									<div class="col-lg-8">
										<div class="section__title text-left p-0 mb-0">
											<span class="sub__title wow fadeInUp" data-wow-delay=".2s">{{ $meta->product_page_short_title ?? __('Wanna more?') }}</span>
											<h2 class="main__title s-title-single wow fadeInUp" data-wow-delay=".4s"><span></span>{{ $meta->product_page_title ?? __('Check Related products') }}</h2>
										</div>
									</div>
								</div>
								<div class="row product-single-slider">
									
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ End Shop Single -->
		<input type="hidden" id="term_id" value="{{ $info->id }}">
@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
<script src="{{ asset('theme/jquery.unveil.js') }}"></script>
<script src="{{ asset('theme/resto/js/product-details.js') }}"></script>
@endpush