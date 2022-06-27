@extends('theme.grshop.layouts.app')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('theme/resto/css/blog.css') }}">
@endpush
@section('content')
<!-- Start Breadcrumbs Area -->

<section class="breadcrumbs"   >
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner  gr-overlay"  style="background-image:url({{ asset($page_data->blog_page_banner ?? '') }})">
					<div class="row">
						<!-- Breadcrumb-Content -->
						<div class="col-lg-6 col-md-8 col-12">
							<div class="breadcrumb-content">
								<h2 class="page-title">{{ $page_data->blog_page_title ?? 'Blogs' }}</h2>
								<p>{{ $page_data->blog_page_description ?? '' }}</p>
								<ul class="breadcrumb-nav">
									<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
									<li><i class="icofont-fast-food"></i> {{ $page_data->blog_page_title ?? 'Blogs' }}</li>
								</ul>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--/ End Breadcrumbs Area -->

<!-- Start Blog Area  -->
<section class="shop-blog blog-archive section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-12">
				<div class="row">
					@foreach($posts as $row)
					<div class="col-lg-3 col-md-3 col-12">
						<!-- Start Single Blog  -->
						<div class="shop-single-blog">
							<div class="image"><a href="{{ url('blog',$row->slug) }}"><img src="{{ asset($row->preview->value ?? 'uploads/default.png') }}" alt="#"></a></div>
							<div class="content">
								<p class="date">{{ $row->updated_at->format('d M, Y.') }}</p>
								<h4 class="title"><a href="{{ url('blog',$row->slug) }}">{{ Str::limit($row->title ?? '',40) }}</a></h4>
								<p class="text">{{ Str::limit($row->excerpt->value ?? '',50) }}</p>
								<div class="button">
									<a href="{{ url('blog',$row->slug) }}" class="btn theme-btn without-bordered">{{ __('Learn More') }}</a>
								</div>
							</div>
						</div>
						<!-- End Single Blog  -->
					</div>
					@endforeach
				</div>
				<div class="row">
					<div class="col-12">
						<!-- Pagination -->
						<div class="pagination center">
							{{ $posts->links('vendor.pagination.bootstrap-4') }}
						</div>
						<!--/ End Pagination -->
					</div>
				</div>
			</div>
			

		</div>
	</div>
</section>
<!-- End Blog Area  -->
@endsection