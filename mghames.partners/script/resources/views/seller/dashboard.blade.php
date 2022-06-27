@extends('layouts.backend.app')

@section('title','Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/owl.theme.default.min.css') }}">
@endpush
@section('content')
<div class="row">
  <div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card card-statistic-2">
      <div class="card-stats">
        <div class="card-stats-title">{{ __('Order Statistics') }} - <div class="dropdown d-inline">
            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month" id="orders-month">{{ Date('F') }}</a>
            <ul class="dropdown-menu dropdown-menu-sm">
              <li class="dropdown-title">{{ __('Select Month') }}</li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='January') active @endif" data-month="January">{{ __('January') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='February') active @endif" data-month="February">{{ __('February') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='March') active @endif" data-month="March">{{ __('March') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='April') active @endif" data-month="April">{{ __('April') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='May') active @endif" data-month="May">{{ __('May') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='June') active @endif" data-month="June">{{ __('June') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='July') active @endif" data-month="July">{{ __('July') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='August') active @endif" data-month="August">{{ __('August') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='September') active @endif" data-month="September">{{ __('September') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='October') active @endif" data-month="October">{{ __('October') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='November') active @endif" data-month="November">{{ __('November') }}</a>
              </li>
              <li>
                <a href="#" class="dropdown-item month @if(Date('F')=='December') active @endif" data-month="December">{{ __('December') }}</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-stats-items">
          <div class="card-stats-item">
            <div class="card-stats-item-count" id="pending_order"></div>
            <div class="card-stats-item-label">{{ __('Pending') }}</div>
          </div>
          <div class="card-stats-item">
            <div class="card-stats-item-count" id="completed_order"></div>
            <div class="card-stats-item-label">{{ __('Completed') }}</div>
          </div>
          <div class="card-stats-item">
            <div class="card-stats-item-count" id="shipping_order"></div>
            <div class="card-stats-item-label">{{ __('Processing') }}</div>
          </div>
        </div>
      </div>
      <div class="card-icon shadow-primary bg-primary">
        <i class="fas fa-archive"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>{{ __('Total Orders') }}</h4>
        </div>
        <div class="card-body" id="total_order"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card card-statistic-2">
      <div class="card-chart">
        <canvas id="sales_of_earnings_chart" height="80"></canvas>
      </div>
      <div class="card-icon shadow-primary bg-primary">
        <i class="fas fa-dollar-sign"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>{{ __('Total Sales Of Earnings') }} - {{ date('Y') }}</h4>
        </div>
        <div class="card-body" id="sales_of_earnings">
          <img src="{{ asset('uploads/loader.gif') }}">
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card card-statistic-2 ">
      <div class="card-chart">
        <canvas id="total-sales-chart" height="80"></canvas>
      </div>
      <div class="card-icon shadow-primary bg-primary">
        <i class="fas fa-shopping-bag"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>{{ __('Total Sales') }} - {{ date('Y') }}</h4>
        </div>
        <div class="card-body" id="total_sales">
          <img src="{{ asset('uploads/loader.gif') }}" class="loads">
        </div>
      </div>
    </div>
  </div>

  @php

     $date= \Carbon\Carbon::now()->addDays(7)->format('Y-m-d');
     $will_expire=tenant('will_expire');
    @endphp
    @if($will_expire <= $date)
    <div class="col-md-12">
        <div class="alert alert-warning">
             {{ __('Your subscription is ending in') }} 
            
             {{ \Carbon\Carbon::parse($will_expire)->diffForHumans() }}
            {{ __('Please') }} <ins><a target="_blank" class="text" href="{{ url(env('APP_URL').'/partner/domain/renew/'.tenant('id')) }}">{{ __('renew') }}</a></ins> {{ __('the plan!') }}
        </div>
    </div>
    @endif
</div>
 <div class="row pending_order_list" id="pending_order_list">
    
  </div>
<div class="row">
  <div class="col-lg-8 col-md-12 col-12 col-sm-12">
    <div class="card card-primary">
      <div class="card-header">
        <h4 class="card-header-title">{{ __('Sells performance') }}
          <img src="{{ asset('uploads/loader.gif') }}" height="20" id="earning_performance">
        </h4>
        <div class="card-header-action">
          <select class="form-control selectric" id="perfomace">
            <option value="7">{{ __('Last 7 Days') }}</option>
            <option value="15">{{ __('Last 15 Days') }}</option>
            <option value="30">{{ __('Last 30 Days') }}</option>
            <option value="365">{{ __('Last 365 Days') }}</option>
          </select>
        </div>
      </div>
      <div class="card-body">
        <canvas id="myChart" height="158"></canvas>
      </div>
    </div>

    <div class="row">
       <div class="col-12 col-md-6">

            <div class="card card-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">

                            <h6 class="text-uppercase text-muted mb-2">{{ __('Today\'s Total Sales') }}</h6>

                            <span class="h2 mb-0" id="today_total_sales"><img src="{{ asset('uploads/loader.gif') }}"></span>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">

            <div class="card card-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">

                            <h6 class="text-uppercase text-muted mb-2">{{ __('Today\'s Orders') }}</h6>

                            <span class="h2 mb-0" id="today_order"><img src="{{ asset('uploads/loader.gif') }}"></span>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <div class="col-6">

            <div class="card card-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">

                            <h6 class="text-uppercase text-muted mb-2">{{ __('Yesterday') }}</h6>

                            <span class="h2 mb-0" id="yesterday_total_sales"><img src="{{ asset('uploads/loader.gif') }}"></span>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

         <div class="col-6">

            <div class="card card-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">

                            <h6 class="text-uppercase text-muted mb-2">{{ __('7 days') }}</h6>

                            <span class="h2 mb-0" id="last_seven_days_total_sales"><img src="{{ asset('uploads/loader.gif') }}"></span>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="col-6">

            <div class="card card-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">

                            <h6 class="text-uppercase text-muted mb-2">{{ __('This Month') }}</h6>

                            <span class="h2 mb-0" id="monthly_total_sales"><img src="{{ asset('uploads/loader.gif') }}"></span>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <div class="col-6">

            <div class="card card-primary">
               <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">

                        <h6 class="text-uppercase text-muted mb-2">{{ __('Last Month') }}</h6>

                        <span class="h2 mb-0" id="last_month_total_sales"><img src="{{ asset('uploads/loader.gif') }}"></span>
                    </div>
                </div> 
            </div>
        </div>
      </div>
    </div>


    <div class="card card-primary">
      <div class="card-header">
        <h4>{{ __('Top Selling Products') }}</h4>
      </div>
      <div class="card-body">
        <div class="owl-carousel owl-theme products-carousel top_selling_products">
          
        
        </div>
      </div>
    </div>

    <div class="card card-primary">
      <div class="card-header">
        <h4>{{ __('Top Rated Products') }}</h4>
      </div>
      <div class="card-body">
        <div class="owl-carousel owl-theme products-carousel max_rated_products">
         
        </div>
      </div>
    </div>

    <div class="card card-primary">
      <div class="card-header">
        <h4>{{ __('Top Customers') }}</h4>

      </div>
      <div class="card-body">
        <div class="owl-carousel owl-theme products-carousel top_customer">
         
          
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
  
   
    @if(tenant('qr_code') == 'on')
    <div class="card card-primary">
      <div class="card-header">
        <h4>{{ __('Scan Your Site') }}</h4>
      </div>
      <div class="card-body">
        <div class="qrcode-area">
          <img id="qrcode_img" src="data:image/png;base64,{{ DNS2D::getBarcodePNG(url('/'), 'QRCODE',15,15) }}" alt="">  
        </div>
        <div class="button mt-3">
          <button class="btn btn-primary w-100 btn-lg downloadPng" >{{ __('Download') }}</button>
        </div>
      </div>
    </div>
    @endif

    <div class="card gradient-bottom card-primary">
      <div class="card-header">
        <h4>{{ __('Today\'s Pending Orders') }}</h4>
      </div>
      <div class="card-body top-5-scroll">
        <ul class="list-unstyled list-unstyled-border todays_orders_list">
        
        </ul>
      </div>
      <div class="card-footer pt-3 d-flex justify-content-center">
        <div class="budget-price justify-content-center">
          <div class="budget-price-square bg-primary" data-width="20"></div>
          <div class="budget-price-label"><a href="{{ route('seller.order.index') }}">{{ __('Orders') }}</a></div>
        </div>
      </div>
    </div>

     <div class="card card-primary">
      <div class="card-header">
        <h4>{{ __('Subscription Status') }}</h4> 
        <div class="card-header-action ">
          <span>{{ __('Expire') }}: {{ \Carbon\Carbon::parse(tenant('will_expire'))->format('d-F-Y') }}</span>

        </div>
      </div>
      <div class="card-body" >
        <div class="top-5-scroll">
        <ul class="list-unstyled list-unstyled-border subscription_data_list">
        
        </ul>
        </div>
        <div class="button mt-3">
          <button class="btn btn-primary w-100 btn-lg clear_site_cache" >{{ __('Clear Site Cache') }}</button>
        </div>
      </div>
    </div>

    


  </div>
</div>
<div class="row">
  <div class="col-lg-4">
    
  </div>
</div>

@if(tenant('push_notification') == 'on' && env('FMC_SERVER_API_KEY') != null)
<div class="notification-button-area notification_button">
  <button id="btn-nft-enable" class="btn btn-danger btn-xs btn-flat notification_button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zM9 21h6v2H9v-2z"/></svg></button>
</div>
@endif
  

<input type="hidden" id="dashboard_static" value="{{ url('/seller/dashboard/static') }}">
<input type="hidden" id="dashboard_perfomance" value="{{ url('/seller/dashboard/perfomance') }}">
<input type="hidden" id="deposit_perfomance" value="{{ url('/seller/dashboard/deposit/perfomance') }}">
<input type="hidden" id="dashboard_order_statics" value="{{ url('/seller/dashboard/order_statics') }}">
<input type="hidden" id="gif_url" value="{{ asset('uploads/loader.gif') }}">
<input type="hidden" id="month" value="{{ date('F') }}">
<input type="hidden" id="new_order_link" value="{{ route('seller.orders.new') }}">
<input type="hidden" id="save_token" value="{{ route('seller.save-token') }}">
<input type="hidden" id="currency_settings" value="{{ get_option('currency_data') }}">
@endsection
@push('script')
<script src="{{ asset('admin/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/chart.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/seller.js') }}"></script>


@endpush
