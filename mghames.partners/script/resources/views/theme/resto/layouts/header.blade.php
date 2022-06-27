@php
$invoice_data=json_decode($autoload_data['invoice_data'] ?? '');
$languages=json_decode($autoload_data['languages']);
$default_language=$autoload_data['default_language'] ?? '';
$current_url=url()->current();
@endphp

 @if(url('/checkout') !=  $current_url &&  Request::is('customer/*') !=  $current_url)

<!-- Cart Sidebar -->
@php
$cart_sidebar=$site_settings->cart_sidebar ?? 'yes';
$bottom_bar=$site_settings->bottom_bar ?? 'yes';
@endphp
@if($cart_sidebar == 'yes')
      <div class="cart-sidebar">
         <div class="item-line">
            <div class="cart-line"><i class="icofont-cart-alt"></i></div>
            <div class="cart-line item-name"><span class="cart_count">{{ $cart_count }}</span><span>{{ __('Items') }}</span></div>
         </div>
         <div class="prrice-tag"><span class="cart_subtotal render_currency">{{ Cart::instance('default')->subtotal() }}</span></div>
      </div>
      <!-- End Cart Sidebar -->
      @endif
    @if($bottom_bar == 'yes') 
      <!-- Mobile Cart Show -->
      <div class="mobile-cart-show">
         <ul>
            <li>
               <div class="single-cart-show"><a href="{{ url('/') }}"><i class="icofont-home"></i><span>{{ __('Home') }}</span></a></div>
            </li>
            <li>
               <div class="single-cart-show"><a href="{{ url('/wishlist') }}"><i class="icofont-heart"></i><span>{{ __('Wishlist') }}</span></a></div>
            </li>
            <li>
               <div class="single-cart-show"><a href="{{ url('/cart') }}"><i class="icofont-cart"></i><span>{{ __('Cart') }}</span></a></div>
            </li>
            <li>
               <div class="single-cart-show"><a href="{{ url('/customer/dashboard') }}"><i class="icofont-ui-user"></i><span>{{ __('Account') }}</span></a></div>
            </li>
         </ul>
      </div>
      <!-- End Mobile Cart Show -->
    @endif
         
               
      <!-- Shopping Item -->
      <div class="shopping-item">
         <div class="dropdown-cart-header">
            <div class="close-button"><a href="#"><i class="icofont-close"></i></a></div>
            <span><span class="cart_count">{{ $cart_count }}</span> {{ __('Items') }}</span>
         </div>
         <div class="shopping-item-inner">
            <div class="cart-single-inner">
               <ul id="shopping" class="shopping-list">
                  
                  
               </ul>
            </div>
            <div class="cart-single-inner bottom">
               <div class="total">
                  <span>{{ __('Total') }}</span>
                  <span class="total-amount cart_subtotal">{{ Cart::instance('default')->subtotal() }}</span>
               </div>
               <a href="{{ url('/cart') }}" class="btn animate">{{ __('View Cart') }}</a>
               <a href="{{ url('/checkout') }}" class="btn primary animate">{{ __('Checkout') }}</a>
            </div>
         </div>
      </div>
      <!--/ End Shopping Item -->
      @endif
      <!-- Topbar Area -->
      <div class="topbar-area">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 col-md-7 col-12">
                  <!-- Topbar Left -->
                  <div class="topbar-left">
                     <ul class="topbar-left-inner">
                        <li><i class="icofont-delivery-time"></i><span class="info"><a href="javascript:void(0)"><b>{{ __('Delivery') }}:</b>{{ $average_times->delivery_time ?? '' }}</a></span></li>
                        <li><i class="icofont-food-cart"></i><span class="info"><b>{{ __('Takeout') }}:</b>{{ $average_times->pickup_time ?? '' }}</span></li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-6 col-md-5 col-12">
                  <!-- Topbar Right -->
                  <div class="topbar-right">
                      <div class="topbar-language-section">
                        <li class="topbar-language">
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
                        </li>
                      </div>
                     <ul class="topbar-right-inner">
                        <!-- Topbar Language -->
                        @if(tenant('customer_modules') == 'on')
                        <li class="accounts-top-btn"><a href="{{ !Auth::check() ? '#' : url('/customer/dashboard') }}"><i class="icofont-user-male"></i><span>{{ !Auth::check() ? __('My Account') : Auth::user()->name }}</span></a>
                           @if(!Auth::check())
                           <!-- Topbar Accounts Form -->
                           <div class="accounts-signin-top-form">
                              <form action="{{ route('login') }}" method="post" class="accounts-signin-inner">
                                 @csrf
                                 <div class="row">
                                    <div class="col-12">
                                       <div class="form-group">

                                          <label><i class="icofont-ui-user"></i> {{ __('Email') }}</label>
                                          <input type="email" name="email"  required="required" placeholder="Enter Email">
                                          
                                       </div>
                                    </div>
                                    <div class="col-12">
                                       <div class="form-group">
                                          <label><i class="icofont-ssl-security"></i> {{ __('Password') }}</label>
                                          <input type="password" name="password" required="">
                                          <a href="{{ url('/password/reset') }}">{{ __('Forgot password?') }}</a>
                                       </div>
                                    </div>
                                    <div class="col-12">
                                       <div class="accounts-signin-btn">
                                          <button type="submit" class="theme-btn">{{ __('Sign in') }}</button>
                                       </div>   
                                    </div>   
                                    <div class="col-12">
                                       <div class="accounts-signin-bottom">
                                          <p>{{ __('Dont have any account?') }}</p>
                                          <a href="{{ url('customer/register') }}" class="theme-btn">Sign up</a>
                                       </div>
                                    </div>
                                 </div>   
                              </form>  
                           </div>
                           <!-- End Topbar Accounts Form -->
                           @endif
                        </li>
                        @endif
                     </ul>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- End Topbar Area -->
      
      <!-- Header Area -->
      <header class="header navbar-area">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-12">
                  <div class="nav-inner">
                     <!-- navbar -->
                     <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="{{ url('/') }}">
                           <img src="{{ asset('uploads/'.tenant('uid').'/logo.png?v='.tenant('cache_version')) }}" alt="">
                        </a>
                        <!-- Responsive Nav Button -->
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
                           <span class="toggler-icon"></span>
                           <span class="toggler-icon"></span>
                           <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                           <ul id="nav" class="navbar-nav ms-auto">
                              {{ThemeMenu('header','theme.resto.components.menu')}}
                           </ul>
                        </div>
                     </nav>
                     <!-- End navbar -->
                     <div class="right-bar">
                        <ul class="cart-list-top">
                           <li class="single-bar"><a href="{{ url('/cart') }}" class="icon"><i class="icofont-cart-alt"></i><span class="count cart_count">{{ $cart_count }}</span></a></li>

                           <li class="single-bar"><a href="{{ url('/wishlist') }}" class="icon"><i class="icofont-heart-alt"></i><span class="count wishlist_count">{{ $wishlist_count }}</span></a></li>
                           
                        </ul>
                        <!--/ End Shopping Cart -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- End Header Area -->

      