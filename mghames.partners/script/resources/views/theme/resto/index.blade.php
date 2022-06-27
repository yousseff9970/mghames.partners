@extends('theme.resto.layouts.app')
@section('content')
<!-- Start Hero Area -->
      <section class="hero-area">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 col-12">
                  <div class="hero-slider-head">
                     <div class="hero-slider">
                      
                        
                       
                        
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-12">
                  <div class="row short_banner">
                     
                     
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!--/ End Hero Area -->
      
      <!--/ Start Popular Area -->
      @if($page_data->featured_products_status ?? 'yes' == 'yes')
      <section class="popular__food">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 col-md-8 col-12">
                  <div class="section__title text-left">
                     <h2 class="main__title"><span></span>{{ $page_data->featured_products_title ?? 'Top Product' }}</h2>
                     <p class="section__text">
                        {{ $page_data->featured_products_description ?? '' }}
                     </p>
                     <div class="waves-block">
                        <div class="waves wave-1"></div>
                        <div class="waves wave-2"></div>
                        <div class="waves wave-3"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="p-slider-head">
               <div class="popular-food-slider">
                  

                 
               </div>
            </div>
         </div>
      </section>
      @endif
      <!--/ End Popular Area -->
      
      <!-- Start Food Tab Area -->
      <section class="food-tab-main section">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                  <div class="section__title text-center">
                     <span class="sub__title wow fadeInUp" data-wow-delay=".2s">{{ $page_data->products_area_short_title ?? 'For you' }}</span>
                     <h2 class="main__title wow fadeInUp" data-wow-delay=".4s"><span></span>{{ $page_data->products_area_title ?? 'Latest Foods' }}</h2>
                     <p class="section__text">{{ $page_data->products_area_description ?? '' }}</p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <ul class="nav nav-tabs menutab" id="myTab" role="tablist">
                     <li class="nav-item" role="presentation">
                        <button class="nav-link active"  id="meat-tab" data-bs-toggle="tab" data-bs-target="#meat" type="button" role="tab" aria-controls="meat" aria-selected="true"> {{ __('All') }}</button>
                     </li>
                      
                     
                     <li class="nav-item content-preloader" role="presentation">
                        <button class="content-placeholder"  type="button" data-height="40px" data-width="100%"> </button>
                     </li>
                      <li class="nav-item content-preloader" role="presentation">
                        <button class="content-placeholder"  type="button" data-height="40px" data-width="100%"> </button>
                     </li>
                     <li class="nav-item content-preloader" role="presentation">
                        <button class="content-placeholder"  type="button" data-height="40px" data-width="100%"> </button>
                     </li>
                     <li class="nav-item content-preloader" role="presentation">
                        <button class="content-placeholder"  type="button" data-height="40px" data-width="100%"> </button>
                     </li>
                     <li class="nav-item content-preloader" role="presentation">
                        <button class="content-placeholder"  type="button" data-height="40px" data-width="100%"> </button>
                     </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="meat" role="tabpanel" aria-labelledby="meat-tab">
                        <div class="row latest_products">
                           <div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>
                          
                           
                        </div>
                     </div>
                     <div class="tab-pane fade" id="filteredtab" role="tabpanel" aria-labelledby="filteredtab-tab" >
                         <div class="row filtered_product_tab">
                        
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- /End Food Tab Area -->
      
      <!-- Start Call To Action Area -->
      <section class="call-to-action section large_banner">
         
      </section>
      <!-- End Call To Action Area -->
      @if($page_data->discount_product_status ?? 'yes' == 'yes')
      <!-- Start Count Down Area -->
      <section class="count-down section">
         <div class="container">
            <div class="section__title align-left p-0">
               <div class="row align-items-center">
                  <div class="col-lg-5 col-md-5 col-12">
                     <div class="section__title text-left m-0">
                        <h2 class="main__title"><span></span>{{ $page_data->discount_product_title ?? '' }}</h2>
                        <p class="section__text">{{ $page_data->discount_product_description ?? '' }}
                        </p>
                        <div class="waves-block off-white">
                           <div class="waves wave-1"></div>
                           <div class="waves wave-2"></div>
                           <div class="waves wave-3"></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-7 col-md-7 col-12">
                    
                  </div>
               </div>
               <div class="single-deal-main">
                  <div class="row getdiscountbleproducts">
                    
                    
                  </div>
               </div>
            </div>
         </div>
      </section>
      @endif
      <!-- /End Count Down Area -->
      @if($page_data->testimonial_status ?? 'yes' == 'yes')
      <!-- Start Testimonials Area -->
      <section class="testimonials section" style="background-image:url({{ $page_data->testimonial_background ?? '' }})">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                  <div class="section__title section-white text-center">
                     <h2 class="main__title wow fadeInUp" data-wow-delay=".2s">{{ $page_data->testimonial_title ?? 'Happy Clients Say' }}</h2>
                     <p class="section__text wow fadeInUp" data-wow-delay=".4s">{{ $page_data->testimonial_description ?? 'There are many variations of passages of Lorem Ipsum available,but the majority have suffered alteration in some form.' }}</p>
                  </div>
               </div>
            </div>
            <div class="row testimonial-slider">
               
              
            </div>
         </div>
      </section>
      <!-- End Testimonial Area -->
      @endif
      @if($page_data->menu_area_status ?? 'yes' == 'yes')
      <!-- Start Recommendations Area -->
      <section class="recommendations section">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                  <div class="section__title text-center">
                   
                     <h2 class="main__title wow fadeInUp" data-wow-delay=".4s">{{ $page_data->menu_area_title ?? 'Our special menu' }}</h2>
                     <p class="section__text wow fadeInUp" data-wow-delay=".6s">{{ $page_data->menu_area_description ?? 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.' }}</p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-10 offset-lg-1">
                  <div class="row">
                    <div class="col-lg-6 offset-lg-0 col-md-6 col-md-10 offset-md-1 col-12 day1">

                    </div>
                     <div class="col-lg-6 col-12">
                        <div class="row day2">

                           
                         
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- End Recommendations Area -->
      @endif
      @if($page_data->blog_area_status ?? 'yes' == 'yes')
      <!-- Start Blog Area  -->
      <section class="shop-blog section blog_section">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                  <div class="section__title text-center">
                     <h5 class="sub__title wow fadeInUp" data-wow-delay=".2s">{{ $page_data->blog_area_short_title ?? 'Read articles' }}</h5>
                     <h2 class="main__title wow fadeInUp" data-wow-delay=".4s">{{ $page_data->blog_area_title ?? 'Recent News & Blogs' }}</h2>
                     <p class="section__text wow fadeInUp" data-wow-delay=".6s">{{ $page_data->blog_area_description ?? 'There are many variations of passages of Lorem Ipsum available,but the majority have suffered alteration in some form.' }}</p>
                  </div>
               </div>
            </div>
            <div class="row latest_blogs">
               <input type="hidden" class="blog_read_more" value="Continue Reading">
               
            </div>
         </div>
      </section>
      <!-- End Blog Area  -->
      @endif
@endsection
@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
<script src="{{ asset('theme/jquery.unveil.js') }}"></script>
<script src="{{ asset('theme/resto/js/home.js?v='.tenant('cache_version')) }}"></script>
@endpush