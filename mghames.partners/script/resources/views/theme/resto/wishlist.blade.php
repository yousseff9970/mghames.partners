@extends('theme.resto.layouts.app')
@section('content')
@php
$autoloaddata=getautoloadquery();
$currency_data=$autoloaddata['currency_data'];
@endphp
<!-- Start Breadcrumbs Area -->
		<div class="breadcrumbs" style="background-image:url({{ asset($page_data->wishlist_page_banner ?? '')  }})">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-8 col-12">
						<div class="breadcrumbs-content">
							<h1 class="page-title"> {{ $page_data->wishlist_page_title ?? 'Wishlist' }}</h1>
							<p>{{ $page_data->wishlist_page_description ?? '' }}</p>
						</div>
						<ul class="breadcrumb-nav">
							<li><a href="{{ url('/') }}"><i class="icofont-home"></i> Home</a></li>
							<li><i class="icofont-fast-food"></i> {{ __('Wishlist') }}</li>
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
									
									
									<th class="text-center"><i class="icofont-trash"></i>{{ __('Remove') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($contents as $row)
								<tr>
									<td class="image" data-title="No"><img src="{{ asset($row->options->preview) }}" alt="{{ $row->name }}"></td>
									<td class="product-desc" data-title="Description">
										<p class="product-name"><a href="{{ url('/product',$row->options->slug) }}">{{ $row->name }}</a></p>
										
									</td>
									<td class="price" data-title="Price"><span>{{ number_format($row->price,2) }} </span></td>
									
									
									<td class="action" data-title="Remove"><a href="{{ url('/remove-wishlist',$row->rowId) }}" class=""><i class="icofont-trash remove-icon"></i></a></td>
								</tr>
								@endforeach
								
							</tbody>
						</table>
						<!--/ End Shopping Summery -->
					</div>
				</div>
				
			</div>
		</div>
		<!--/ End Shopping Cart -->
@endsection