<li class="menu-header">{{ __('Dashboard') }}</li>
<li class="{{ Request::is('seller/dashboard*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('Order Management') }}</li>
<li class="{{ Request::is('seller/pos*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/pos') }}">
     <i class="fas fa-cart-plus"></i>
     <span>{{ __('POS') }}</span>
 </a>
</li>
<li class="{{ Request::is('seller/order*') ? 'active' : '' }} {{ Request::is('seller/order*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/order') }}">
     <i class="fas fa-box"></i>
     <span>{{ __('Orders') }}</span>
 </a>
</li>
<li class="{{ Request::is('seller/calender*') ? 'active' : '' }} {{ Request::is('seller/calender*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/calender') }}">
     <i class="fas fa-clock"></i>
     <span>{{ __('Calender') }}</span>
 </a>
</li>
<li class="{{ Request::is('seller/orderstatus*') ? 'active' : '' }} {{ Request::is('seller/orderstatus*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/orderstatus') }}">
     <i class="fas fa-tags"></i>
     <span>{{ __('Order Status') }}</span>
 </a>
</li>


<li class="menu-header">{{ __('Product Management') }}</li>
<li class="{{ Request::is('seller/product*') ? 'active' : '' }} {{ Request::is('seller/barcode*') ? 'active' : '' }}">
    <a class="nav-link has-dropdown" href="#">
        <i class="fas fa-box"></i>
        <span>{{ __('Products') }}</span>
    </a>
    <ul class="dropdown-menu" >
        <li>
            <a class="nav-link" href="{{ url('/seller/product') }}">{{ __('Products') }}</a>
        </li>
        <li>
            <a class="nav-link" href="{{ url('/seller/features') }}">{{ __('Product Features') }}</a>
        </li>
        
        <li>
            <a class="nav-link" href="{{ url('/seller/barcode') }}">{{ __('Barcode Print') }}</a>
        </li>
        <li>
            <a class="nav-link" href="{{ url('/seller/attribute') }}">{{ __('Attributes') }}</a>
        </li>
        <li>
            <a class="nav-link" href="{{ url('/seller/tag') }}">{{ __('Tags') }}</a>
        </li>
        <li>
            <a class="nav-link" href="{{ url('/seller/category') }}">{{ __('Categories') }}</a>
        </li>
        <li>
            <a class="nav-link" href="{{ url('/seller/brand') }}">{{ __('Brands') }}</a>
        </li>
        <li>
            <a class="nav-link" href="{{ url('/seller/coupon') }}">{{ __('Coupons') }}</a>
        </li>
    </ul>
</li>
<li class="{{ Request::is('seller/review*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/review') }}">
        <i class="fas fa-star-half-alt"></i>
        <span>{{ __('Reviews') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('User Management') }}</li>
<li class="{{ Request::is('seller/user*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/user') }}">
        <i class="fas fa-users"></i>
        <span>{{ __('Users') }}</span>
    </a>
</li>
<li class="{{ Request::is('seller/rider*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/rider') }}">
        <i class="fas fa-motorcycle"></i>
        <span>{{ __('Riders') }}</span>
    </a>
</li>

<li class="menu-header">{{ __('Payment Gateway') }}</li>
<li class="{{ Request::is('seller/payment/gateway*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/payment/gateway') }}">
        <i class="fas fa-money-check-alt"></i>
        <span>{{ __('Payment Gateways') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('Table Management') }}</li>
<li class="{{ Request::is('seller/table*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/table') }}">
        <i class="fas fa-table"></i>
        <span>{{ __('Tables') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('Website Management') }}</li>
<li class="{{ Request::is('seller/page*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/page') }}">
        <i class="fas fa-file"></i>
        <span>{{ __('Pages') }}</span>
    </a>
</li>
<li class="{{ Request::is('seller/blog*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/blog') }}">
        <i class="fas fa-blog"></i>
        <span>{{ __('Blogs') }}</span>
    </a>
</li>
<li class="{{ Request::is('seller/slider*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/slider') }}">
        <i class="fas fa-sliders-h"></i>
        <span>{{ __('Sliders') }}</span>
    </a>
</li>
<li class="{{ Request::is('seller/special-menu*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/seller/special-menu') }}">
        <i class="fas fa-th"></i>
        <span>{{ __('Special Menus') }}</span>
    </a>
</li>
<li class="{{ Request::is('seller/banner*') ? 'active' : '' }} {{ Request::is('seller/banner*') ? 'active' : '' }}">
    <a class="nav-link has-dropdown" href="#">
        <i class="fas fa-box"></i>
        <span>{{ __('Banners') }}</span>
    </a>
    <ul class="dropdown-menu" >
        <li><a class="nav-link" href="{{ url('/seller/banner/short-banner') }}"><span>{{ __('Short Banner') }}</span></a></li>
        <li><a class="nav-link" href="{{ url('/seller/banner/large-banner') }}"><span>{{ __('Large Banner') }}</span></a></li>
    </ul>
</li>
<li class="{{ Request::is('seller/settings*') ? 'active' : '' }} {{ Request::is('seller/settings*') ? 'active' : '' }}">
    <a class="nav-link has-dropdown" href="#">
        <i class="fas fa-cog"></i>
        <span>{{ __('Settings') }}</span>
    </a>
    <ul class="dropdown-menu" >
       <li><a class="nav-link" href="{{ url('/seller/store-settings') }}"><span>{{ __('Template Settings') }}</span></a></li>
       <li><a class="nav-link" href="{{ url('/seller/settings/custom_css_js') }}"><span>{{ __('Additional Css & Js') }}</span></a></li>
       <li><a class="nav-link" href="{{ url('/seller/settings/pwa') }}"><span> {{ __('PWA Configuration') }}</span></a></li>
       <li><a class="nav-link" href="{{ url('/seller/settings/seo') }}"><span>{{ __('SEO Settings') }}</span></a></li>
   </ul>
</li>