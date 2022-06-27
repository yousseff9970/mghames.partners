<li class="menu-header">{{ __('Dashboard') }}</li>
@can('dashboard.index')
    <li class="active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>
@endcan
<li class="menu-header">{{ __('Store Management') }}</li>
@can('plan.index', 'plan.create')
<li class="nav-item dropdown {{ Request::is('admin/plan*') ? 'active' : '' }}">
      <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-money-bill-alt"></i>
          <span>{{ __('Plan') }}</span></a>
      <ul class="dropdown-menu">
          @can('plan.create')
           <li><a class="nav-link" href="{{ route('admin.plan.create') }}">{{ __('Create Plan') }}</a></li>
          @endcan
          @can('plan.index')
           <li><a class="nav-link" href="{{ route('admin.plan.index') }}">{{ __('All Plan') }}</a></li>
           <li><a class="nav-link" href="{{ route('admin.plan.settings') }}">{{ __('Plan Settings') }}</a></li>
          @endcan
      </ul>
</li>
@endcan

@can('order.index', 'order.create', 'order.edit')
<li class="{{ Request::is('admin/order*') ? 'active' : '' }}">
      <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-sort-amount-up"></i>
          <span>{{ __('Orders') }}</span></a>
       <ul class="dropdown-menu">
            <li> <a class="nav-link" href="{{ route('admin.order.create') }}">{{ __('Create Order') }}</a></li>
            <li> <a class="nav-link" href="{{ route('admin.order.index') }}">{{ __('All Orders') }}</a></li>
      </ul>
</li>
@endcan

@can('domain.create', 'domain.list')
<li class="{{ Request::is('admin/store*') || Request::is('admin/domain*') ? 'active' : '' }}">
   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i>
   <span>{{ __('Stores & Domains') }}</span></a>
   <ul class="dropdown-menu">
      @can('domain.list')
      <li>
         <a class="nav-link" href="{{ route('admin.store.index') }}">{{ __('All Stores') }}</a>
      </li>
      <li>
         <a class="nav-link" href="{{ route('admin.domain.index') }}">{{ __('All Domains') }}</a>
      </li>
      @endcan
      @can('dns.settings')
      <li>
         <a class="nav-link" href="{{ route('admin.dns.settings') }}">{{ __('DNS Settings Instruction') }}</a>
      </li>
      <li>
         <a class="nav-link" href="{{ route('admin.developer.instruction') }}">{{ __('Developer Instruction') }}</a>
      </li>
      @endcan
   </ul>
</li>
@endcan

@can('fund')
<li class="{{ Request::is('admin/fund/history*') ? 'active' : '' }}">
   <a class="nav-link" href="{{ route('admin.fund.history') }}?data=1">
   <i class="fas fa-search-dollar"></i>
   <span>{{ __('Fund History') }}</span>
   </a>
</li>
@endcan
@can('store.theme')
<li class="{{ Request::is('admin/template*') ? 'active' : '' }}">
   <a class="nav-link" href="{{ route('admin.template.index') }}">
   <i class="fas fa-palette"></i>
   <span>{{ __('Store Templates') }}</span>
   </a>
</li>
@endcan

<li class="menu-header">{{ __('User Management') }}</li>
@can('merchant.index','merchant.create','merchant.edit')
<li class="{{ Request::is('admin/partner*') ? 'active' : '' }}">
   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i>
   <span>{{ __('Partners') }}</span></a>
   <ul class="dropdown-menu">
      <li><a class="nav-link" href="{{ route('admin.partner.create') }}">{{ __('Create Partner') }}</a></li>
      <li><a class="nav-link" href="{{ route('admin.partner.index') }}">{{ __('Manage Partner') }}</a></li>
   </ul>
</li>
@endcan

@can('role.list', 'admin.list')
<li
   class="dropdown {{ Request::is('admin/role*') ? 'active' : '' }} {{ Request::is('admin/users*') ? 'active' : '' }}">
   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
      class="fas fa-user-shield"></i><span>{{ __('Admins & Roles') }}</span></a>
   <ul class="dropdown-menu">
      @can('role.list')
      <li>
         <a class="nav-link" href="{{ route('admin.role.index') }}">{{ __('Roles') }}</a>
      </li>
      @endcan
      @can('admin.list')
      <li><a class="nav-link" href="{{ route('admin.admin.index') }}">{{ __('Admins') }}</a>
      </li>
      @endcan
   </ul>
</li>
@endcan

<li class="menu-header">{{ __('Payment Gateway') }}</li>
@can('getway.index')
<li class="{{ Request::is('admin/gateway*') ? 'active' : '' }}">
   <a class="nav-link" href="{{ route('admin.gateway.index') }}">
   <i class="fas fa-wallet"></i>
   <span>{{ __('Gateway') }}</span>
   </a>
</li>
@endcan

<li class="menu-header">{{ __('Manage Report') }}</li>
@can('report')
<li
   class="{{ Request::is('admin/report') ? 'active' : '' }}">
   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-arrows-alt"></i>
   <span>{{ __('Report') }}</span></a>
   <ul class="dropdown-menu">
      <li>
         <a class="nav-link" href="{{ route('admin.report.index') }}">{{ __('Order Report') }}</a>
      </li>
   </ul>
</li>
@endcan

<li class="menu-header">{{ __('Cron Management') }}</li>
<li class="{{ Request::is('admin/cron') ? 'active' : '' }}">
   <a href="{{ route('admin.cron.index') }}" class="nav-link">
   <i class="fas fa-clone"></i>
   <span>{{ __('Cron Jobs') }}</span>
   </a>
</li>
<li class="menu-header">{{ __('Website Management') }}</li>

@can('blog.index', 'blog.create')
<li class="{{ Request::is('admin/blog*') ? 'active' : '' }}">
   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fab fa-blogger"></i>
   <span>{{ __('Blog') }}</span></a>
   <ul class="dropdown-menu">
      <li>
         <a class="nav-link" href="{{ route('admin.blog.create') }}">{{ __('Blog Create') }}</a>
      </li>
      <li>
         <a class="nav-link" href="{{ route('admin.blog.index') }}">{{ __('Blog List') }}</a>
      </li>
   </ul>
</li>
@endcan

@can('page.index', 'page.create')
<li class="{{ Request::is('admin/page*') ? 'active' : '' }}">
   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
   <i class="fas fa-copy"></i>
   <span>{{ __('Page') }}</span>
   </a>
   <ul class="dropdown-menu">
      <li>
         <a class="nav-link" href="{{ route('admin.page.create') }}">{{ __('Page Create') }}</a>
      </li>
      <li>
         <a class="nav-link" href="{{ route('admin.page.index') }}">{{ __('Page List') }}</a>
      </li>
   </ul>
</li>
@endcan

<li class="menu-header">{{ __('Support Management') }}</li>
@can('support.index')
<li class="nav-item dropdown {{ Request::is('admin/support*') ? 'show active' : '' }}">
   <a href="{{ route('admin.support.index') }}" class="nav-link"><i class="fas fa-headset"></i>
   <span>{{ __('Support') }}</span></a>
</li>
@endcan 

<li class="menu-header">{{ __('Settings') }}</li>
<li
   class="nav-item dropdown {{ Request::is('admin/menu') ? 'show active' : '' }} {{ Request::is('admin/language') ? 'show active' : '' }}">
   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cogs"></i>
   <span>{{ __('Settings') }}</span></a>
   <ul class="dropdown-menu">
      @can('language.index')
      <li class="{{ Request::is('admin/language') ? 'active' : '' }}">
         <a href="{{ route('admin.language.index') }}"
            class="nav-link"><span>{{ __('Languages') }}</span></a>
      </li>
      @endcan
      @can('menu')
      <li><a class="nav-link" href="{{ route('admin.menu.index') }}">{{ __('Menu Settings') }}</a>
      </li>
      @endcan
      <li><a class="nav-link" href="{{ route('admin.seo.index') }}">{{ __('SEO Settings') }}</a>
      <li><a class="nav-link" href="{{ route('admin.env.index') }}">{{ __('System Settings') }}</a>
      </li>
   </ul>
</li>

<li class="{{ Request::is('admin/theme/settings') ? 'active' : '' }}">
   <a href="{{ route('admin.theme.settings') }}" class="nav-link">
   <i class="fas fa-pencil-ruler"></i>
   <span>{{ __('Theme Settings') }}</span>
   </a>
</li>