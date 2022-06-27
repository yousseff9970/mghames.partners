<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link collapse_btn nav-link-lg"><i class="fas fa-bars"></i></a></li>
     
    </ul>
    <div class="search-element"></div>
  </form>
  <ul class="navbar-nav navbar-right">
    @if (Auth::User()->role_id == 3)
    <li><a target="_blank" href="{{ url('/') }}" class="btn btn-white view-demo"><i class="fas fa-eye"></i> View Site</a></li>
    @endif
    @if (Auth()->user()->role_id == 3 && url()->current() == url('/seller/dashboard'))
    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i></a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">{{ __('Notifications') }}</div>
        <div class="dropdown-list-content dropdown-list-icons"></div>
        <div class="dropdown-footer text-center">
          <a href="{{ route('seller.order.index') }}">{{ __('View All ') }}<i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    </li>
    @endif
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
     
      <img alt="image" src='https://ui-avatars.com/api/?name={{Auth()->user()->name}}'
      class="rounded-circle profile-widget-picture ">
     
      <div class="d-sm-none d-lg-inline-block">{{ __('Hi') }}, {{ Auth::user()->name }}</div></a>
      <div class="dropdown-menu dropdown-menu-right">


        <a href="{{ url('/mysettings') }}" class="dropdown-item has-icon">
          <i class="far fa-user"></i> {{ __('Profile') }}
        </a>


        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
      </a>
      <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </div>
  </li>
</ul>
</nav>
