@extends('theme.grshop.layouts.app')
@section('content')
<!-- Start Breadcrumbs Area -->

<!--/ End Breadcrumbs Area -->
<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner  gr-overlay" style="background-image:url({{ asset($page_data->cart_page_banner ?? '') }})">
					<div class="row">
						<!-- Breadcrumb-Content -->
						<div class="col-lg-6 col-md-8 col-12">
							<div class="breadcrumb-content">
								<h2 >{{ $page_data->cart_page_title ?? 'Cart' }}</h2>
								<p>{{ $page_data->cart_page_description ?? '' }}</p>
								<ul class="breadcrumb-nav">
									<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
									<li><i class="icofont-cart"></i> {{ $page_data->cart_page_title ?? 'Cart' }}</li>
								</ul>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="shopping-cart section-padding">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-12">
				<div class="checkout-cart">
					<h2>{{ __('Shopping Cart') }}</h2>
					<p><span class="cart_count">{{ Cart::instance('default')->count() }}</span> {{ __('Items') }}</p>
				</div>
				<!-- Shopping Summery -->
				<table class="table shopping-summery">
					<thead>
						<tr class="main-hading">
							<th>{{ __('Product Details') }}</th>
							
							<th class="text-center">{{ __('Quantity') }}</th>
							<th class="text-center">{{ __('Unit Price') }}</th> 
						</tr>
					</thead>
					<tbody class="cart_page">
						
						
					</tbody>
				</table>
				<!--/ End Shopping Summery -->
				<div class="button-check">
					<a href="{{ url('/products') }}" class="btn">{{ __('Continue shopping') }}</a>
				</div>
			</div>
			<div class="col-lg-4 col-12">
				<!-- Total Amount -->
				<div class="total-amount">
					<div class="cart-total">
						<h4>{{ __('Cart Subtotal') }}<span class="cart_subtotal render_currency"> {{ Cart::instance('default')->subtotal() }}</span></h4>
					</div>
					
					<div class="single-cart-widget">
						<ul class="s-widget-cart-list">
							
							<li>{{ __('Tax') }}<span>{{ Cart::instance('default')->tax() }}</span></li>
							<li>{{ __('You Save') }}<span>{{ Cart::instance('default')->discount() }}</span></li>
							<li class="last">{{ __('Total') }}<span class="cart_tota pay-aml render_currency cart_total">{{ Cart::instance('default')->total() }}</span></li>
							
						</ul>
					</div>
					<div class="single-cart-widget coupon-area">
						<h4>{{ __('Have a coupon? Put that here') }}</h4>
						
						<form method="post" action="{{ route('makediscount') }}" class="ajaxform_with_reload">
							@csrf
							<input name="coupon" required="" placeholder="Enter Your Coupon">
							<button class="btn basicbtn" type="submit">{{ __('Apply') }}</button>
						</form>
					</div>
					<div class="button-check two">
						<a href="{{ url('/checkout') }}" class="btn">Checkout</a>
					</div>
				</div>
				<!--/ End Total Amount -->
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
@endpush