@extends('theme.grshop.layouts.app')
@section('content')


<section class="breadcrumbs" >
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner  gr-overlay" style="background-image:url({{ asset($page_data->wishlist_page_banner ?? '') }})">
					<div class="row">
						<!-- Breadcrumb-Content -->
						<div class="col-lg-6 col-md-8 col-12">
							<div class="breadcrumb-content">
								<h2 class="page-title"> {{ $page_data->wishlist_page_title ?? 'Wishlist' }}</h2>
							<p>{{ $page_data->wishlist_page_description ?? '' }}</p>
								<ul class="breadcrumb-nav">
									<li><a href="{{ url('/') }}"><i class="icofont-home"></i> Home</a></li>
							<li><i class="icofont-fast-food"></i> {{ __('Wishlist') }}</li>
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
			<div class="col-lg-12 col-12">
				
				<!-- Shopping Summery -->
				<table class="table shopping-summery">
					<thead>
						<tr class="main-hading">
							<th class="text-center"><i class="icofont-price"></i> {{ __('PRODUCT') }}</th>
							<th class="text-center"><i class="icofont-pencil-alt-5"></i> {{ __('NAME') }}</th>
							<th class="text-center"><i class="icofont-money"></i> {{ __('UNIT PRICE') }}</th>


							<th class="text-center"><i class="icofont-trash"></i>{{ __('Remove') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($contents as $row)
						<tr>
							<td class="image" data-title="No" ><a href="{{ url('/product',$row->options->slug) }}"><img src="{{ asset($row->options->preview) }}" alt="{{ $row->name }}"></a></td>
							<td class="product-desc " data-title="Description">
								<p class="product-name"><a href="{{ url('/product',$row->options->slug) }}">{{ $row->name }}</a></p>

							</td>
							<td class="price" data-title="Price"><span>{{ number_format($row->price,2) }} </span></td>


							<td class="action" data-title="Remove"><a href="{{ url('/remove-wishlist',$row->rowId) }}" ><i class="icofont-trash remove-icon"></i></a></td>
						</tr>
						@endforeach
						
					</tbody>
				</table>
				<!--/ End Shopping Summery -->
				<div class="button-check">
					<a href="{{ url('/products') }}" class="btn">{{ __('Continue shopping') }}</a>
				</div>
			</div>
			
		</div>
	</div>
</div>

		

@endsection