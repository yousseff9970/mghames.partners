<li class="menu-header">{{ __('Dashboard') }}</li>
<li class="{{ Request::is('partner/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('merchant.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('Wallet') }}</li>
<li class="{{ Request::is('partner/fund') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('merchant.fund.index') }}">
        <i class="fas fa-money-check-alt"></i>
        <span>{{ __('Add Fund') }}</span>
    </a>
</li>
<li class="{{ Request::is('partner/fund/history/list') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('merchant.fund.history') }}">
        <i class="fas fa-list"></i>
        <span>{{ __('Fund History') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('Store Management') }}</li>
<li class="{{ Request::is('partner/domain*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fas fa-store"></i>
        <span>{{ __('My Stores') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="{{ route('merchant.domain.create') }}">{{ __('Add Store') }}</a></li>
        <li><a class="nav-link" href="{{ route('merchant.domain.list') }}">{{ __('My Stores') }}</a></li>
    </ul>
</li>
<li class="{{ Request::is('partner/order') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('merchant.order.index') }}">
        <i class="fas fa-th"></i>
        <span>{{ __('My Orders') }}</span>
    </a>
</li>
<li class="{{ Request::is('partner/support') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('merchant.support.index') }}">
        <i class="fas fa-headset"></i>
        <span>{{ __('Support') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('Report Management') }}</li>
<li class="{{ Request::is('partner/report') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('merchant.report.index') }}">
        <i class="fas fa-chart-bar"></i>
        <span>{{ __('Payment Report') }}</span>
    </a>
</li>