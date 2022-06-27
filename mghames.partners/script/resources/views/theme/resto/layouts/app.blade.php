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
      <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('theme/resto/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/resto/css/icofont.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/resto/css/nice-select.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/resto/css/animate.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/resto/css/tiny-slider.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/resto/css/glightbox.min.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/resto/css/perfect-scrollbar.css') }}">
      <!-- Theme Styles -->
      <link rel="stylesheet" href="{{ asset('theme/resto/css/reset.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/resto/style.css') }}">
      <link rel="stylesheet" href="{{ asset('theme/resto/css/responsive.css') }}">
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

      @if($preloader == 'yes')
      <div class="preloader">
         <div class="preloader-inner">
            <div class="preloader-icon"><span></span><span></span></div>
         </div>
      </div>
      @endif

      @endif

     @include('theme.resto.layouts.header',['autoload_data'=>$autoload_data,'cart_count'=>$cart_count,'wishlist_count'=>$wishlist_count,'average_times'=>$average_times,'site_settings'=>$site_settings ?? ''])
     @yield('content')
     @include('theme.resto.layouts.footer',['site_settings'=>$site_settings ?? ''])

      @if(isset($autoload_data['whatsapp_settings']))
     @php
     $whatsapp= json_decode($autoload_data['whatsapp_settings'])
     @endphp
     @if($whatsapp->whatsapp_status == 'on')
       @include('components.whatsapp',['whatsapp'=>$whatsapp])
     @endif
     @endif
<!--  scroll-top -->
<a href="#" class="scroll-top btn-hover"><i class="icofont-long-arrow-up"></i></a>
<input type="hidden" id="callback_url" value="{{ url('/databack') }}">  
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
<!--  JS Files  -->
<script src="{{ asset('theme/resto/js/jquery.min.js') }}"></script>
<script src="{{ asset('theme/resto/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('theme/resto/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/resto/js/nice-select.js') }}"></script>
<script src="{{ asset('theme/resto/js/wow.min.js') }}"></script>
<script src="{{ asset('theme/resto/js/tiny-slider.js') }}"></script>
<script src="{{ asset('theme/resto/js/glightbox.min.js') }}"></script>
<script src="{{ asset('theme/resto/js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('theme/resto/js/main.js') }}"></script>
<script src="{{ asset('theme/helper.js?v=1.0') }}"></script>
<script src="{{ asset('theme/resto/js/theme-helper.js') }}"></script>

@stack('js')
{{ load_footer() }}
  </body>
</html>