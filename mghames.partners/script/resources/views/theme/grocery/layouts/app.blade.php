<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- generate meta tags --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    {!! JsonLdMulti::generate() !!}
    {!! SEO::generate(true) !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/'.tenant('uid').'/favicon.ico') }}">

    <!-- css here -->
    <link rel="stylesheet" href="{{ asset('theme/grocery/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/grocery/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/grocery/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/grocery/css/responsive.css') }}">
     {{ load_header() }}
</head>

<body>

    <!-- header area start  -->
    @include('theme.grocery.layouts.header')
    <!-- header area start  -->

    <!-- hero area start  -->
    @yield('content')
    <!-- hero area end -->

    @php
     $autoload_data=getautoloadquery();
     @endphp

    @include('theme.grocery.components.quickview')

    <!-- cart count area start -->
    <a href="javascript:void(0)" class="cart_sidebar_modal">
        <div class="cart-count-right-area">
            <div class="count-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M7 8V6a5 5 0 1 1 10 0v2h3a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h3zm0 2H5v10h14V10h-2v2h-2v-2H9v2H7v-2zm2-2h6V6a3 3 0 0 0-6 0v2z"/></svg>
            </div>
            <span class="count cart_count">{{ Cart::count() }}</span>
        </div>
    </a>
    <!-- cart count area end -->

     <!-- mobile category count area start -->
     <a href="javascript:void(0)" class="category_mobile_icon">
        <div class="category-mobile">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 4h13v2H8V4zM4.5 6.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6.9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zM8 11h13v2H8v-2zm0 7h13v2H8v-2z"/></svg>
        </div>
     </a>
     <!-- mobile category count area end -->

    <!-- cart content area start -->
    <section>
        <div>
            <div class="cart-content-main-area" id="cart-siderbar">
                <div class="cart-header-area">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4>Shopping Cart</h4>
                        </div>
                        <div class="col-lg-4">
                            <a href="javascript:void(0)" id="cart_remove">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="cart-sidebar-load">
                    <div class="cart-main-area">
                        <div class="cart_page">
        
                        </div>
                    </div>
                </div>
                <div class="cart-footer-area">
                    <div class="cart-total">
                        <span><strong>Subtotal</strong> <span class="right cart_subtotal">{{ get_option('currency_data',true)->currency_icon }}{{ Cart::subtotal() }}</span></span>
                    </div>
                    <div class="cart-total">
                        <span><strong>Tax</strong> <span class="right cart_tax">{{ get_option('currency_data',true)->currency_icon }}{{ Cart::tax() }}</span></span>
                    </div>
                    <div class="cart-total">
                        <span><strong>Total</strong> <span class="right cart_total">{{ get_option('currency_data',true)->currency_icon }}{{ Cart::total() }}</span></span>
                    </div>
                    <a href="{{ url('/checkout') }}">Checkout</a>
                </div>
            </div>
        </div>
    </section>
    <!-- cart content area end -->

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
    <input type="hidden" id="wishlist_url" value="{{ route('add.wishlist') }}">
    <input type="hidden" id="product_search_url" value="{{ route('product.search') }}">
    <input type="hidden" id="category_product_url" value="{{ route('category.product') }}">

    <script src="{{ asset('theme/grocery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/grocery/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('theme/helper.js?v=1.0') }}"></script>
    <script src="{{ asset('theme/grocery/js/theme-helper.js') }}"></script>
    
    <script>
        "use strict";
        render_cart(cart_content);
    </script>
    @stack('js')
    {{ load_footer() }}
</body>

</html>