@extends('layouts.backend.app')

@section('title','Theme Settings')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Theme Settings') }}</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-6">
              <div class="card card-large-icons">
                <div class="card-icon bg-primary text-white">
                  <i class="fas fa-cog"></i>
                </div>
                <div class="card-body">
                  <h4>{{ __('General') }}</h4>
                  <p>{{ __('General settings such as, site logo, favicon, hero image and so on.') }}</p>
                  <a href="{{ route('admin.settings.general') }}" class="card-cta">{{ __('Change Setting') }} <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card card-large-icons">
                <div class="card-icon bg-primary text-white">
                    <i class="fas fa-list"></i>
                </div>
                <div class="card-body">
                  <h4>{{ __('Services Section') }}</h4>
                  <p>{{ _('Here you can create new service, edit, update and delete.') }}</p>
                  <a href="{{ route('admin.settings.service.index') }}" class="card-cta">{{ __('Change Setting') }} <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-stopwatch"></i>
                  </div>
                  <div class="card-body">
                    <h4>{{ __('Footer Section') }}</h4>
                    <p>{{ __('Footer section about site address, phone number, email address and so on.') }}</p>
                    <a href="{{ route('admin.settings.footer.index') }}" class="card-cta text-primary">{{ __('Change Setting') }} <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
            </div>
            <div class="col-lg-6">
              <div class="card card-large-icons">
                <div class="card-icon bg-primary text-white">
                    <i class="fas fa-list"></i>
                </div>
                <div class="card-body">
                  <h4>{{ __('Site Option') }}</h4>
                  <p>{{ _('Here you can create new service, edit, update and delete.') }}</p>
                  <a href="{{ route('admin.option.edit','all') }}" class="card-cta">{{ __('Change Setting') }} <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card card-large-icons">
                <div class="card-icon bg-primary text-white">
                    <i class="fas fa-list"></i>
                </div>
                <div class="card-body">
                  <h4>{{ __('SEO Settings') }}</h4>
                  <p>{{ _('Here you can create new service, edit, update and delete.') }}</p>
                  <a href="{{ route('admin.option.seo-index') }}" class="card-cta">{{ __('Change Setting') }} <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card card-large-icons">
                <div class="card-icon bg-primary text-white">
                    <i class="fas fa-list"></i>
                </div>
                <div class="card-body">
                  <h4>{{ __('Theme Demo Lists') }}</h4>
                  <p>{{ _('Here you can create new service, edit, update and delete.') }}</p>
                  <a href="{{ route('admin.settings.demo') }}" class="card-cta">{{ __('Change Settings') }} <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>
@endsection








