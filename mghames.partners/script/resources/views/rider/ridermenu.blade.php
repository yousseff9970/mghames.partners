<li class="menu-header">{{ __('Dashboard') }}</li>
<li class="{{ Request::is('rider/dashboard*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/rider/dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('Orders') }}</li>
<li class="{{ Request::is('rider/order*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/rider/order') }}">
        <i class="fas fa-list-alt"></i>
        <span>{{ __('Orders') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('Settings') }}</li>
<li class="{{ Request::is('rider/settings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/rider/settings') }}">
        <i class="fas fa-cog"></i>
        <span>{{ __('Settings') }}</span>
    </a>
</li>
<li>
    <a href="{{ route('logout') }}" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();" class="nav-link">
    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
    </a>
</li>