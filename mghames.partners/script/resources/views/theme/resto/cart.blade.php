@extends('theme.resto.layouts.app')
@section('content')
<!-- Start Breadcrumbs Area -->
		<div class="breadcrumbs" style="background-image:url({{ asset($page_data->cart_page_banner ?? '') }})">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-8 col-12">
						<div class="breadcrumbs-content">
							<h1 class="page-title">{{ $page_data->cart_page_title ?? 'Cart' }}</h1>
							<p>{{ $page_data->cart_page_description ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text' }}</p>
						</div>
						<ul class="breadcrumb-nav">
							<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
							<li><i class="icofont-cart"></i> {{ $page_data->cart_page_title ?? 'Cart' }}</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Breadcrumbs Area -->
		
		
		<!-- Shopping Cart -->
		<div class="shopping-cart section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- Shopping Summery -->
						<table class="table shopping-summery">
							<thead>
								<tr class="main-hading">
									<th><i class="icofont-price"></i> {{ __('PRODUCT') }}</th>
									<th><i class="icofont-pencil-alt-5"></i> {{ __('NAME') }}</th>
									<th class="text-center"><i class="icofont-money"></i> {{ __('UNIT PRICE') }}</th>
									<th class="text-center"><i class="icofont-attachment"></i> {{ __('QUANTITY') }}</th>
									<th class="text-center"><i class="icofont-price"></i> {{ __('TOTAL') }}</th> 
									<th class="text-center"><i class="icofont-trash"></i>{{ __('Remove') }}</th>
								</tr>
							</thead>
							<tbody class="cart_page">
								
								
							</tbody>
						</table>
						<!--/ End Shopping Summery -->
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<!-- Total Amount -->
						<div class="total-amount">
							<div class="row">
								<div class="col-lg-8 col-md-5 col-12">
									<div class="left">
										<div class="coupon">
											<form method="post" action="{{ route('makediscount') }}" class="ajaxform_with_reload">
												@csrf
												<input name="coupon" required="" placeholder="Enter Your Coupon">
												<button class="btn basicbtn" type="submit">{{ __('Apply') }}</button>
											</form>
										</div>
										
									</div>
								</div>
								<div class="col-lg-4 col-md-7 col-12">
									<div class="right">
										<ul>
											<li>{{ __('Cart Subtotal') }}<span class="cart_subtotal">{{ Cart::instance('default')->subtotal() }}</span></li>
											<li>{{ __('Tax') }}<span>{{ Cart::instance('default')->tax() }}</span></li>
											<li>{{ __('You Save') }}<span>{{ Cart::instance('default')->discount() }}</span></li>
											<li class="last">{{ __('Total') }}<span class="cart_total">{{ Cart::instance('default')->total() }}</span></li>
										</ul>
										<div class="button">
											<a href="{{ url('/checkout') }}" class="btn"><i class="icofont-shopping-cart"></i> {{ __('Checkout') }}</a>
											<a href="{{ url('/products') }}" class="btn primary"><i class="icofont-plus-circle"></i> {{ __('Continue shopping') }}</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--/ End Total Amount -->
					</div>
				</div>
			</div>
		</div>
		<!--/ End Shopping Cart -->
@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
@endpush