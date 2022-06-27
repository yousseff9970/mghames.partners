@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Dashboard') }}</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-4">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>{{ __('Total Orders') }}</h4>
                  </div>
                  <div class="card-body">
                    {{ $total_orders }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>{{ __('Complete Orders') }}</h4>
                  </div>
                  <div class="card-body">
                    {{ $approve_orders }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>{{ __('Cancelled Orders') }}</h4>
                  </div>
                  <div class="card-body">
                    {{ $failed_orders }}
                  </div>
                </div>
              </div>
            </div>                
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">{{ __('All Orders') }}</h2>
                <p></p>
            </div>
        </div>
        <div class="row" id="live_orders">

        </div>
    </div>
</section>

@if(tenant('push_notification') == 'on' && env('FMC_SERVER_API_KEY') != null)
<div class="notification-button-area notification_button">
  <button id="btn-nft-enable" class="btn btn-danger btn-xs btn-flat notification_button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zM9 21h6v2H9v-2z"/></svg></button>
</div>
@endif
<input type="hidden" id="live_order_url" value="{{ route('rider.live.orders') }}">
<input type="hidden" id="save_token" value="{{ route('save-token') }}">
@endsection

@push('script')
  <script src="{{ asset('rider/dashboard.js') }}"></script>
@endpush

