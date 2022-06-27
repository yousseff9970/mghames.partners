@extends('layouts.backend.app')

@section('title','Dashboard')

@section('head')
@include('layouts.backend.partials.headersection',['title'=> 'Site Settings'])
@endsection

@section('content')
<div class="section-body">
  <div class="row">
   <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="fas fa-cog"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('General') }}</h4>
        <p>{{ __('View and update your store details') }}</p>
        <a href="{{ route('seller.site-settings.show','general') }}" class="card-cta">{{ __('Change Setting') }}<i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="fas fa-cog"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('Menu Settings') }}</h4>
        <p>{{ __('View and update your menu details') }}</p>
        <a href="{{ route('seller.menu.index') }}" class="card-cta">{{ __('Change Settings') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="fas fa-map-marked-alt"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('Locations') }}</h4>
        <p>{{ __('Manage the places you fulfill orders and sell products') }}</p>
        <a href="{{ route('seller.location.index') }}" class="card-cta">{{ __('Change Settings') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="fas fa-money-bill-alt"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('Payments') }}</h4>
        <p>{{ __('Enable and manage your store payment providers') }}</p>
        <a href="{{ route('seller.payment.gateway') }}" class="card-cta">{{ __('Change Settings') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="far fa-bell"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('Notifications') }}</h4>
        <p>{{ __('Manage Notifications sent to you and your customers') }}</p>
        <a href="{{ url('/seller/notification') }}" class="card-cta">{{ __('Change Settings') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
         <i class="fas fa-globe-americas"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('Store languages') }}</h4>
        <p>{{ __('Manage the languages your customers can view on your orders') }}</p>
        <a href="{{ route('seller.language.index') }}" class="card-cta">{{ __('Change Settings') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="fas fa-truck"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('Shipping and delivery') }}</h4>
        <p>{{ __('Manage how you ship order to customers') }}</p>
        <a href="{{ url('/seller/shipping') }}" class="card-cta">{{ __('Change Settings') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="fas fa-user-shield"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('Admins') }}</h4>
        <p>{{ __('Manage Admins') }}</p>
       
        <a href="{{ route('seller.admin.index') }}" class="card-cta">{{ __('Admins Settings') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
   <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="fas fa-images"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('Files') }} </h4>
        <p>{{ __('Manage your uploaded files') }}</p>
        <p>{{ __('Total :') }} <span>{{ number_format(\App\Models\Media::sum('size'),2).'MB' }}</span></p>
        <a href="{{ url('/seller/medias') }}" class="card-cta">{{ __('Change Settings') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="fas fa-crop"></i>
      </div>
      <div class="card-body">
        <h4> @if(tenant('image_optimization') != 'on' ) <i class="fa fa-lock text-danger"></i> @endif {{ __('Image Optimization') }}</h4>
        <p>{{ __('Optimize your uploaded images for better performance and reduce storage size') }}</p>
        <a href="{{ url('/seller/mediacompress') }}" class="card-cta">{{ __('Visit') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
 
  <div class="col-lg-6">
    <div class="card card-large-icons">
      <div class="card-icon bg-primary text-white">
        <i class="fas fa-images"></i>
      </div>
      <div class="card-body">
        <h4>{{ __('Theme') }}</h4>
        <p>{{ __('Change your store theme') }}</p>
        <a href="{{ url('/seller/theme') }}" class="card-cta">{{ __('Change Settings') }} <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

