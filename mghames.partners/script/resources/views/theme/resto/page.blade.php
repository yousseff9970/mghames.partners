@extends('theme.resto.layouts.app')
@section('content')
<!-- Start Breadcrumbs Area -->
		<div class="breadcrumbs" >
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-12">
						<div class="breadcrumbs-content">
							<h1 class="page-title">{{ $info->title }}</h1>
							<p>{{ $meta->page_excerpt ?? '' }}</p>
						</div>
						<ul class="breadcrumb-nav">
							<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
							<li>{{ $info->title }}</li>
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
					<div class="col-sm-12">
						{{ content_format($meta->page_content ?? '') }}
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