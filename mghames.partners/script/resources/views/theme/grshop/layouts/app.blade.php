<!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      {{-- generate meta tags --}}
      {!! SEOMeta::generate() !!}
      {!! OpenGraph::generate() !!}
      {!! Twitter::generate() !!}
      {!! JsonLd::generate() !!}
      {!! JsonLdMulti::generate() !!}
      {!! SEO::generate(true) !!}

      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/'.tenant('uid').'/favicon.ico') }}">
      <!-- Web Font -->
         
      <!-- Google Font -->
      <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Mulish:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,500;1,600;1,700&display=swap" rel="stylesheet">   
      
      <!-- Bootstrap -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/bootstrap.min.css') }}">
      <!-- Owl Carousel -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/owl.carousel.min.css') }}">
      <!-- Jquery UI CSS -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/maginific-popup.min.css') }}">
      <!-- Jquery UI CSS -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/perfect-scroolbar.css') }}">
      <!-- Jquery UI CSS -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/jquery-ui.css') }}">
      <!-- Flex Slider CSS -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/flex-slider.css') }}">
      <!-- Nice select CSS -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/nice-select.css') }}">
      <!-- Animate CSS -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/animate.min.css') }}">
      <!-- Slicknav CSS -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/slicknav.min.css') }}">
      <!-- Icofont -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/css/icofont.css') }}">
      
      <!-- Main CSS -->
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/reset.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/header.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/hero-area.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/partner.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/departments.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/cart.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/cart-sidebar.css') }}">

      <link rel="stylesheet" href="{{ asset('theme/grshop/section/blog.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/shop-form.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/shop-single.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/checkout.css') }}">

      <link rel="stylesheet" href="{{ asset('theme/grshop/section/shop-form.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/banner-img.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/newsletter.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/latest-product.css') }}">

      <link rel="stylesheet" href="{{ asset('theme/grshop/section/modal.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/latest-product-tabs.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/shop-sidebar.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/grshop/section/footer.css') }}">




      
      <link rel="stylesheet" href="{{ asset('theme/helper.css') }}">
      @stack('css')
      {{ load_header() }}

    
   </head>
   <body>
     @php
     $autoload_data=getautoloadquery();
     $average_times=optionfromcache('average_times');
    
     $cart_count=Cart::instance('default')->count();
     $wishlist_count=Cart::instance('wishlist')->count();
     @endphp
      <!--[if lte IE 9]>
      <p class="browserupgrade">
         You are using an <strong>outdated</strong> browser. Please
         <a href="https://browsehappy.com/">upgrade your browser</a> to improve
         your experience and security.
      </p>
     <![endif]-->
      @if(isset($autoload_data['site_settings']))
      @php
      $site_settings=json_decode($autoload_data['site_settings']);
      $site_settings=$site_settings->meta ?? '';
      $preloader=$site_settings->preloader ?? 'yes';
      @endphp

      

      @endif

     @include('theme.grshop.layouts.header',['autoload_data'=>$autoload_data,'cart_count'=>$cart_count,'wishlist_count'=>$wishlist_count,'average_times'=>$average_times,'site_settings'=>$site_settings ?? ''])
     @yield('content')
     @include('theme.grshop.layouts.footer',['site_settings'=>$site_settings ?? ''])

     @if(isset($autoload_data['whatsapp_settings']))
     @php
     $whatsapp= json_decode($autoload_data['whatsapp_settings'])
     @endphp
     @if($whatsapp->whatsapp_status == 'on')
       @include('components.whatsapp',['whatsapp'=>$whatsapp])
     @endif
     @endif
<!--  scroll-top -->

<input type="hidden" id="callback_url" value="{{ route('callback.data') }}">  
<input type="hidden" id="cart_link" value="{{ route('add.tocart') }}" />
<input type="hidden" id="base_url" value="{{ url('/') }}" />
<input type="hidden" id="click_sound" value="{{ asset('uploads/click.wav') }}">
<input type="hidden" id="cart_sound" value="{{ asset('uploads/cart.wav') }}">
<input type="hidden" id="cart_increment" value="{{ url('/cart-qty') }}">
<input type="hidden" id="pos_product_varidation" value="{{ url('/product-varidation') }}">
<input type="hidden" id="cart_content" value="{{ Cart::content() }}">

<input type="hidden" class="total_amount" value="{{ str_replace(',','',Cart::total()) }}">
<input type="hidden" id="preloader" value="{{ asset('uploads/preload.webp') }}">
<input type="hidden" id="currency_settings" value="{{ $autoload_data['currency_data'] ?? '' }}">

<!-- Jquery JS -->
<script src="{{ asset('theme/grshop/js/jquery.min.js') }}"></script>
<script src="{{ asset('theme/grshop/js/jquery-migrate.js') }}"></script>
<script src="{{ asset('theme/grshop/js/jquery-ui.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('theme/grshop/js/bootstrap.min.js') }}"></script>
<!-- Wow JS -->
<script src="{{ asset('theme/grshop/js/wow.min.js') }}"></script>
<!-- Nice Select JS -->
<script src="{{ asset('theme/grshop/js/nice-select.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('theme/grshop/js/magnific-popup.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('theme/grshop/js/perfect-scroolbar.min.js') }}"></script>
<!-- Final Countodwn JS -->
<script src="{{ asset('theme/grshop/js/final-countdown.min.js') }}"></script>
<!-- Slick Nav JS -->
<script src="{{ asset('theme/grshop/js/jquery.slicknav.min.js') }}"></script>
<!-- Flex Slider JS -->
<script src="{{ asset('theme/grshop/js/flex-slider.js') }}"></script>
<!-- Owl Carousel JS -->
<script src="{{ asset('theme/grshop/js/owl.carousel.min.js') }}"></script>
<!-- Scroll UP Min -->
<script src="{{ asset('theme/grshop/js/scrollup.min.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('theme/grshop/js/active.js') }}"></script>
<script src="{{ asset('theme/helper.js?v=1.0') }}"></script>
<script src="{{ asset('theme/grshop/js/theme-helper.js') }}"></script>


@stack('js')
{{ load_footer() }}
  </body>
</html>