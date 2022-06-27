@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Payment Gateway') }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('login') }}">{{ __('Dashboard') }}</a></div>
          <div class="breadcrumb-item"><a href="#">{{ __('settings') }}</a></div>
          <div class="breadcrumb-item">{{ __('payment') }}</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h4>{{ __('Settings') }}</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12 col-sm-12 col-md-4">
                          <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="false">Manual Payments</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">Alternative Payments</a>
                            </li>
                          </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8">
                          <div class="tab-content no-padding" id="myTab2Content">
                            <div class="tab-pane fade active show" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                              <div class="custom-payment-btn mb-3">
                                <a href="{{ route('seller.custom.payment.create') }}" class="btn btn-primary btn-lg">{{ __('Create Payment Method') }}</a>
                              </div>
                              <div class="payment-gateway-section">
                                
                                @foreach ($installed_payments as $gateway)
                                @if ($gateway->is_auto == 0)
                      
                                <div class="single-payment-gateway mb-3">
                                    <div class="gateway-left">
                                      <div class="gateway-name">
                                          <h2>{{ $gateway->name }}</h2>
                                          <p>{{ __('Installed') }}</p>
                                      </div>
                                    </div>
                                    <div class="gateway-right">
                                      <a href="{{ route('seller.payment.edit',$gateway->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                    </div>
                                </div>  
                                @endif
                                @endforeach
                            </div>
                            </div>
                            <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                                <div class="payment-gateway-section">
                                 
                                    @foreach ($payments_gateways as $gateway)
                                      @if($gateway->is_auto == 1)
                                    
                                    <div class="single-payment-gateway">
                                        <div class="gateway-left">
                                          <div class="gateway-name">
                                              <h2>{{ $gateway->name }}</h2>
                                              
                                              <p>{{ in_array($gateway->namespace,$namespaces) ? __('Installed') :  __('Install') }}</p>
                                          </div>
                                        </div>

                                        @if(in_array($gateway->namespace,$namespaces))
                                        @foreach($installed_payments as $row)
                                        @if($row->namespace == $gateway->namespace)
                                        <div class="gateway-right">
                                          <a href="{{ route('seller.payment.edit',$row->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        </div>
                                        @endif
                                        @endforeach
                                        
                                        @else


                                        <div class="gateway-right">
                                          <a href="{{ route('seller.payment.install',$gateway->name) }}" class="btn btn-primary">{{ __('Install') }}</a>
                                        </div>
                                        @endif
                                    </div>  
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection