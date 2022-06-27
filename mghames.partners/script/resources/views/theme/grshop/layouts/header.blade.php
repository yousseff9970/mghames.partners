@php
$languages=json_decode($autoload_data['languages']);
$default_language=$autoload_data['default_language'] ?? '';
$current_url=url()->current();
$wishlist_count=Cart::instance('wishlist')->count();
$cart_sidebar=$site_settings->cart_sidebar ?? 'yes';
$bottom_bar=$site_settings->bottom_bar ?? 'yes';
$topbar=$site_settings->topbar ?? '';
@endphp
@if(url('/checkout') !=  $current_url &&  Request::is('customer/*') !=  $current_url)
@if($bottom_bar == 'yes')
<!-- Mobile Cart Show -->
<div class="mobile-cart-show">
   <ul>
      <li><div class="single-cart-show"><a href="{{ url('/') }}"><i class="icofont-home"></i><span>{{ __('Home') }}</span></a></div></li>

      <li><div class="single-cart-show"><a href="{{ url('/cart') }}"><i class="icofont-cart"></i><span>{{ __('Cart') }}</span><span class="total-count cart_count">{{ $cart_count }}</span></a></div></li>

      <li><div class="single-cart-show"><a href="{{ url('/checkout') }}"><i class="icofont-credit-card"></i><span>{{ __('Checkout') }}</span></a></div></li>

      <li><div class="single-cart-show"><a href="{{ url('/wishlist') }}"><i class="icofont-heart"></i><span>{{ __('Wishlist') }}</span><span class="total-count wishlist_count">{{ $wishlist_count }}</span></a></div></li>

      <li><div class="single-cart-show"><a href="{{ url('/customer/dashboard') }}"><i class="icofont-ui-user"></i><span>{{ __('Account') }}</span></a></div></li>
   </ul>
</div>
<!-- End Mobile Cart Show -->
@endif
@endif

@if($cart_sidebar == 'yes')
<!-- Shopping Item -->
<div class="shopping-item">
   <div class="dropdown-cart-header">
      <div class="close-button"><a><i class="icofont-close"></i></a></div>
      <span><i class="icofont-food-basket"></i>{{ __('Total Items') }} <b class="cart_count">{{ $cart_count }}</b> </span>
      <a href="{{ url('/cart') }}" class="view-cart animate">{{ __('View Cart') }}</a>
   </div>
   <div class="shopping-item-inner">
      <div class="cart-single-inner">
         <ul id="shopping" class="shopping-list">
           
      </ul>
   </div>
   <div class="cart-single-inner bottom"  >
        <a href="{{ url('/checkout') }}">
      <div class="total">
       
        <span class="total-amounts"> <span>{{ __('Processed To checkout') }}</span><b class="cart_subtotal render_currency">{{ Cart::instance('default')->subtotal() }}</b></span>
      </div>
      </a>
   </div>
</div>
</div>
@endif
<!--/ End Shopping Item -->

<!-- Header -->
<header id="header" class="header shop">
   <!-- Topbar -->
   @if(!empty($topbar))
   <div class="topbar bg-second">
      <div class="container">
         <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-12 col-12">
               <!-- Top Right -->
               <div class="right-content language_section">
                  <div class="list-main">
                   {{ content_format($topbar) }}
                  </div>
                  <div class="topbar-language-area">
                     <form class="change_lang_form" action="{{ url('/locale/lang') }}">
                        <select name="locale" class="trans_lang">
                           @php
                           $local=Session::get('locale');
                           @endphp
                           @foreach($languages ?? [] as $key => $row)
                           <option value="{{ $row->code }}" @if($local == $row->code) selected @endif>{{ $row->name }}</option>
                           @endforeach
                        </select>
                     </form>
                  </div>
               </div>
               <!-- End Top Right -->
            </div>
         </div>
      </div>
   </div>
   @endif
   <!-- End Topbar -->
   <div class="middle-inner">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="middle-bar-item">
                  <!-- Logo -->
                  <div class="header-logo">
                     <a href="{{ url('/') }}"> <img src="{{ asset('uploads/'.tenant('uid').'/logo.png?v='.tenant('cache_version')) }}" alt=""></a>
                  </div>
                  <div class="search-bar-top">
                     <div class="search-bar">
                        <form action="{{ url('/products') }}">
                           <input id="product_src"  placeholder="Search Products Here.." type="search" name="src">
                           <button type="submit" class="btnn"><i class="icofont-search"></i></button>
                        </form>
                     </div>
                  </div>
                  <div class="header-contact">
                     <div class="single-contact">
                        <div class="icon"><i class="icofont-user"></i></div>
                        <div class="title-desc">
                           <h4>{{ $site_settings->header_contact_title ?? '' }}</h4> 
                           <p>{{ $site_settings->header_contact_number ?? '' }}</p>
                        </div>
                     </div>
                     <div class="single-contact">
                       <a href="{{ url('/wishlist') }}"><div class="icon"><i class="icofont-heart"></i></div></a> 
                        <div class="title-desc">
                          <a href="{{ url('/wishlist') }}"> <h4>{{ __('Wishlist') }} (<span class="wishlist_count">{{ $wishlist_count }}</span>)</h4> </a>
                        </div>
                     </div>
                     @if(tenant('customer_modules') == 'on')
                     <div class="single-contact">
                        <div class="head-button"><a href="{{ !Auth::check() ? url('/customer/login') : url('/customer/dashboard') }}" class="theme-btn">{{ !Auth::check() ? __('My Account') : Auth::user()->name }}</a></div>
                     </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Header Inner -->
   <div class="header-inner">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="menu-area">
                  <!-- End Mobile Menu -->
                  <div class="mobile-menu-actives">
                     <!-- Tab Menu -->
                     <div class="menu-home-tabs">
                        <ul class="list-group" id="list-tab" role="tablist">
                           <li><a class="list-group-item active" data-bs-toggle="list" href="#f-menu1" role="tab"><i class="icofont-navigation-menu" aria-hidden="true"></i>{{ __('Menu') }}</a></li>
                           <li><a class="list-group-item" data-bs-toggle="list" href="#f-tab2" role="tab"><i class="icofont-papers"></i>{{ __('Categories') }}</a></li>
                        </ul>
                     </div>
                     <!-- End Tab Menu -->
                     <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="f-menu1" role="tabpanel">

                           <div class="close-sm-menu"><i class="icofont-close-circled"></i></div>
                           <div class="menu-category-menu"></div>
                        </div>

                        <div class="tab-pane fade" id="f-tab2" role="tabpanel">
                            <div class="close-sm-menu"><i class="icofont-close-circled"></i></div>
                           <div class="menu-category-one"></div>
                        </div>
                     </div>
                  </div>
                  <!-- End Mobile Menu -->
                  
                  <div class="mobile-cart-nav"><i class="icofont-navigation-menu"></i></div>
                  
                  {{ThemeMenu('megamenu','theme.grshop.components.megamenu')}}
                  <!-- Main Menu -->
                  <nav class="navbar navbar-expand-lg">
                     <div class="navbar-collapse"> 
                        <div class="nav-inner"> 
                           <ul class="nav main-menu menu navbar-nav mobile-menu">
                             {{ThemeMenu('header','theme.grshop.components.menu')}}
                          </ul>
                       </div>
                    </div>
                 </nav>
                 <!-- Search Form -->
                 <div class="sinlge-bar shopping">
                  <div class="cart-boxed">
                     <a href="javascript:void(0)" class="single-icon"><i class="icofont-bag"></i><span class="cart_count total-count">{{ $cart_count }}</span></a>
                     <div class="cart-box-side">
                        <h5>{{ __('Cart') }}</h5>
                        <p><span class="cart_subtotal render_currency">{{ Cart::instance('default')->subtotal() }}</span></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</header>
<!-- End Header -->

