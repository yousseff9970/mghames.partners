@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card card-primary">
      <div class="card-body">
      <div class="row">
        <div class="col-sm-3">
          <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
            <li class="nav-item">
              <a class="nav-link {{ route('seller.product.edit',$product_id) == url()->current() ? 'active' : '' }}" href="{{ route('seller.product.edit',$product_id) }}" >{{ __('General Information') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ url('/seller/product/edit/'.$product_id.'/price') == url()->current() ? 'active' : '' }}"  href="{{ url('/seller/product/edit/'.$product_id.'/price') }}">{{ __('Price') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ url('/seller/product/edit/'.$product_id.'/image') == url()->current() ? 'active' : '' }}"  href="{{ url('/seller/product/edit/'.$product_id.'/image') }}">{{ __('Images') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ url('/seller/product/edit/'.$product_id.'/discount') == url()->current() ? 'active' : '' }}"  href="{{ url('/seller/product/edit/'.$product_id.'/discount') }}">{{ __('Discount') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ url('/seller/product/edit/'.$product_id.'/seo') == url()->current() ? 'active' : '' }}"  href="{{ url('/seller/product/edit/'.$product_id.'/seo') }}">{{ __('SEO') }}</a>
            </li>
            <li class="nav-item">
               <a class="nav-link {{ url('/seller/product/edit/'.$product_id.'/express-checkout') == url()->current() ? 'active' : '' }}"  href="{{ url('/seller/product/edit/'.$product_id.'/express-checkout') }}">{{ __('Express Checkout') }}</a>
            <li class="nav-item">
               <a class="nav-link {{ url('/seller/product/edit/'.$product_id.'/barcode') == url()->current() ? 'active' : '' }}"  href="{{ url('/seller/product/edit/'.$product_id.'/barcode') }}">{{ __('Barcode Print') }} @if(tenant('barcode') != 'on')  <i class="fa fa-lock text-danger"></i> @endif</a>   
            </li>
          </ul>
        </div>
        <div class="col-sm-9">
          <div class="tab-content no-padding">
            @yield('product_content')
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
@yield('product_extra_content')
@endsection

