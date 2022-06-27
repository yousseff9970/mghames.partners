@extends('theme.grshop.layouts.app')
@section('content')
<!-- Breadcrumbs -->
<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner  gr-overlay">
					<div class="row">
						<!-- Breadcrumb-Content -->
						<div class="col-lg-6 col-md-8 col-12">
							<div class="breadcrumb-content">
								<h2 class="page-title">{{ $info->title }}</h2>
								<p>{{ $meta->page_excerpt ?? '' }}</p>
								<ul class="breadcrumb-nav">
									<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
									<li>{{ $info->title }}</li>
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
<!-- Start Breadcrumbs Area -->
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