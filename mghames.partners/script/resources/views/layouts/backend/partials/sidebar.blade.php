<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ Config::get('app.name') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('login') }}">{{ Str::limit(env('APP_NAME'), $limit = 1) }}</a>
        </div>
        <ul class="sidebar-menu">
            @if(Auth::user()->role_id == 1)

              @include('admin.adminmenu')
            @elseif (Auth::user()->role_id == 2)

              @include('merchant.merchantmenu')
            @elseif (Auth::user()->role_id == 3)

              @include('seller.sellermenu')
            @elseif (Auth::user()->role_id == 5)

              @include('rider.ridermenu')
            @endif
        </ul>
        @if(Auth::user()->role_id == 3)
        <div class=" mb-4 p-3 hide-sidebar-mini">
            <a href="{{ url('seller/site-settings') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
              <i class="fas fa-cog"></i> {{ __('App Settings') }}
            </a>
          </div> 
        @endif  
    </aside>
</div>
