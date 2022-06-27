@extends('theme.grshop.layouts.app')
@section('content')
@php
$header_slider_status=$page_data->header_slider_status ?? 'yes';
$header_short_banner=$page_data->header_short_banner ?? 'yes';
$latest_product_status=$page_data->latest_product_status ?? 'yes';
$featured_category_status=$page_data->featured_category_status ?? 'yes';
$filter_product_status=$page_data->filter_product_status ?? 'yes';
$top_rated_product_status=$page_data->top_rated_product_status ?? 'yes';
$promotion_area_status=$page_data->promotion_area_status ?? 'yes';
$blog_area_status=$page_data->blog_area_status ?? 'yes';
$brand_area_status=$page_data->brand_area_status ?? 'yes';
@endphp

@if($header_slider_status == 'yes')

<section class="hero-area hero_slider_section" >
   <div class="hero-slider">
      <div class="content-preloader" >
         <div class="content-placeholder"   data-height="400px" data-width="100%"> </div>
      </div>
   </div>
</section>

@endif
@if($header_short_banner == 'yes')
<!-- Features -->
<section class="content-preloader">
<div class="container">
      <div class="row mt-3">
        <div class="col-lg-3 col-md-6 col-6  content-preloader" >
         <div class="content-placeholder"   data-height="250px" data-width="100%">
         </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6  content-preloader" >
         <div class="content-placeholder"   data-height="250px" data-width="100%">
         </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6  content-preloader" >
         <div class="content-placeholder"   data-height="250px" data-width="100%">
         </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6  content-preloader" >
         <div class="content-placeholder"   data-height="250px" data-width="100%">
         </div>
      </div>
   </div>
</div>
</section>

<section class="features short_banner_section">
   <div class="container">
      <div class="row short_banner">

      </div>
   </div>
</section>
<!-- End Features -->
<!-- Products Area -->
@endif
@if($latest_product_status == 'yes')
<section class="products-area bg-second section-padding latest_product_section">
   <div class="container">
      <div class="row">
         <div class="col-lg-6 col-md-8 col-12">
            <div class="section-title m-btm-30">
               <p class="small-title font-stylish m-btm-10 pr-color">{{ $page_data->latest_product_short_title ?? '' }}</p>
               <h2 class="s-content-title">{{ $page_data->latest_product_title ?? '' }}</h2>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="product-area-main">
               <div class="single-product-top product-latest-slider latest_products_preloader">
               </div>
               <div class="single-product-top product-latest-slider latest_products">
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endif

@if($featured_category_status == 'yes')
<!-- Category Area Start -->
<section class="featured_category category_section">
   <div class="category-area">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="category-header">
                  <h2>{{ $page_data->featured_category_title ?? '' }}</h2>
               </div>
            </div>
         </div>
         <div class="row department-slider">
           
           
         </div>
      </div>
   </div>
</section>
<!-- Category Area end -->
@endif

@if($filter_product_status == 'yes')
<!-- Product Home Tab -->
<section class="product-home-tabs bg-second section-padding product_tab_section">
   <div class="container">
      <div class="row">
         <div class="col-lg-6 offset-md-3 col-md-8 offset-md-2 col-12 wow fadeInUp"  data-wow-delay=".3s">
            <div class="section-title m-btm-30 text-center">
               <p class="small-title font-stylish m-btm-10 pr-color">{{ $page_data->filter_product_short_title ?? '' }}</p>
               <h2 class="s-content-title">{{ $page_data->filter_product_title ?? '' }}</h2>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12 wow fadeInUp"  data-wow-delay=".5s">
            <!-- Tab Menu -->
            <div class="latest-home-tabs">
               <ul class="list-group product_menu" id="list-tab" role="tablist">
                 <li><a class="list-group-item active" data-bs-toggle="list" href="#f-tab1" role="tab">{{ __('All') }} </a></li>
                 
               </ul>
            </div>
            <!-- End Tab Menu -->
         </div>
         <div class="col-12">
            <!-- Tab Details -->
            <div class="latest-tab-details m-top-30">
               <div class="tab-content" id="nav-tabContent">
                  <!-- Property Tab One -->
                  <div class="tab-pane fade show active tab1" id="f-tab1" role="tabpanel">
                      <div class="row random_products_preload">
                        
                       
                        
                       
                     </div>
                     <div class="row random_products">
                        
                       
                        
                       
                     </div>
                  </div>
                 
                  <!-- Property Tab Two -->
                  <div class="tab-pane fade tab2" id="f-tab2" role="tabpanel">
                     <div class="row filtered_product_tab">
                        
                     </div>
                  </div>

                
               </div>
            </div>
            <!-- End Tab Details -->
         </div>
      </div>
   </div>
</section>
<!-- End Product Home Tab -->
<!-- Products Area -->
<div class="featured_products_area">
   
</div>
@endif
<!-- End Products Area -->
<!-- Products Area -->
@if($top_rated_product_status == 'yes')
<section class="products-area bg-second section-padding toprated_products_area">
   <div class="container">
      <div class="row">
         <div class="col-lg-6 col-md-8 col-12">
            <div class="section-title m-btm-30">
               <p class="small-title font-stylish m-btm-10 pr-color">{{ $page_data->top_rated_product_short_title ?? '' }}</p>
               <h2 class="s-content-title">{{ $page_data->top_rated_product_title ?? '' }}</h2>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="product-area-main">
               <div class="single-product-top product-latest-slider toprated_products_preload">

                 
                  
               </div>
               <div class="single-product-top product-latest-slider toprated_products">

                 
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endif
<!-- End Products Area -->
<!-- Call to action -->
@if($promotion_area_status == 'yes')
<div class="cta-main section-padding">
   <div class="container">
      <div class="row d-flex align-items-center justify-content-center">
         <div class="col-lg-5 col-md-5 col-12 wow fadeInLeft"  data-wow-delay=".2s">
            <div class="food-ct-img">
               <img class="lazy" src="{{ asset('uploads/preload.webp') }}" data-src="{{ asset($page_data->promotion_banner ?? '') }}" alt="">
               <a href="{{ $page_data->promotion_video_link ?? '' }}" class="video-btn video video-popup mfp-fade"><i class="icofont-ui-play"></i></a>
            </div>
         </div>
         <div class="col-lg-7 col-md-7 col-12 wow fadeInRight"  data-wow-delay=".4s">
            <div class="cta-content">
               <span>{{ $page_data->promotion_short_title ?? '' }}</span>
               <h2>{{ $page_data->promotion_title ?? '' }}</h2>
               <p>{{ $page_data->promotion_description ?? '' }}</p>
               <div class="food-dt-button">
                  <a href="{{ $page_data->promotion_link ?? '' }}" class="theme-btn primary">{{ $page_data->promotion_button_title ?? '' }}</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endif
<!-- End Call to action -->
<!-- Blog Area -->
@if($blog_area_status == 'yes')
<section class="blog-area bg-second section-padding blog_section">
   <div class="container">
      <div class="row">
         <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12 wow fadeInDown"  data-wow-delay=".2s">
            <div class="section-title text-center m-btm-50">
               <p class="small-title font-stylish m-btm-10 pr-color">{{ $page_data->blog_area_short_title ?? '' }}</p>
               <h2 class="s-content-title">{{ $page_data->blog_area_title ?? '' }}</h2>
            </div>
         </div>
      </div>
      <div class="row latest_blogs">
      </div>
   </div>
</section>

@endif
<!-- End Blog Area -->
@if($brand_area_status == 'yes')
<!-- Partner Area -->
<div class="partner-area gr-overlay section-padding brand_section" style="background-image:url({{ asset($page_data->brand_area_background ?? '')  }})">
   <div class="container">
      <div class="row">
         <div class="col-lg-4 col-12">
            <div class="section-title s-white-title text-center m-btm-50">
               <p class="small-title font-stylish m-btm-10 pr-color">{{ $page_data->brand_area_short_title ?? '' }}</p>
               <h2 class="s-content-title">{{ $page_data->brand_area_title ?? '' }}</h2>
            </div>
         </div>
         <div class="col-lg-8 col-12">
            <div class="partner-slider">
            </div>
         </div>
      </div>
   </div>
</div>
@endif
<!-- End Partner Area -->
<!-- Modal -->
 @include('theme.grshop.components.quickview')
<!-- Modal end -->
<input type="hidden" id="blog_read_more" value="{{ __('Learn More') }}">
@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
<script src="{{ asset('theme/jquery.unveil.js') }}"></script>
<script src="{{ asset('theme/grshop/js/home.js') }}"></script>

@endpush