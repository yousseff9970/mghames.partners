@extends('theme.resto.layouts.app')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('theme/resto/css/blog.css') }}">
@endpush
@section('content')
<!-- Start Breadcrumbs Area -->
<div class="breadcrumbs" >
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-12">
				<div class="breadcrumbs-content">
					<h1 class="page-title">{{ $info->title }}</h1>
					<p>{{ $info->excerpt->value ?? '' }}</p>
				</div>
				<ul class="breadcrumb-nav">
					<li><a href="{{ url('/blog') }}"><i class="icofont-home"></i> {{ __('blogs') }}</a></li>
					<li><i class="icofont-blogger"></i> {{ $info->title }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!--/ End Breadcrumbs Area -->


<!-- Start Blog Area  -->
<section class="shop-blog blog-archive section">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-8 col-12">
				<div class="post-details">
					<img src="{{ asset($info->preview->value ?? '') }}" alt="">
					<h2 class="post-title">
						<a href="#">{{ $info->title }}</a>
					</h2>
					<!-- post meta -->
					<ul class="custom-flex post-meta">
						
						<li>
							<a href="#">
								<i class="icofont-calendar"></i>
								{{ $info->updated_at->format('d M, Y.') }}
							</a>
						</li>
						
					</ul>
					{{ content_format($info->description->value ?? '') }}
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-12">
				<div class="sidebar">
					<div class="widget search-widget">
						<h5 class="widget-title">{{ __('Search post') }}</h5>
						<form action="{{ url('/blog') }}">
							<input type="text" name="src" placeholder="Search your keyword...">
							<button type="submit"><i class="icofont-search-1"></i></button>
						</form>
					</div>
				
					<div class="widget popular-feeds">
						<h5 class="widget-title">{{ __('Latest Posts') }}</h5>
						<div class="popular-feed-loop">
							@foreach($recent_posts as $row)
							<div class="single-popular-feed">
								<div class="feed-img animate-img">
									<a href="{{ url('blog',$row->slug) }}"><img src="{{ asset($row->preview->value ?? 'uploads/default.png') }}" class="image-fit " alt="{{ $row->title }}"></a>
								</div>
								<div class="feed-desc">
									<h6 class="post-title"><a href="{{ url('blog',$row->slug) }}">{{ $row->title }}</a></h6>
									<span class="price"><i class="icofont-blogger"></i>{{ $row->updated_at->format('d M, Y.') }}</span>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					
				</div>
			</div>

		</div>
	</div>
</section>
<!-- End Blog Area  -->
@endsection