@extends('layouts.frontend.app')

@section('content')
<!-- header area start -->
@include('layouts.frontend.partials.header')
<!-- header area end -->

<!-- breadcrumb area start -->
<section>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="breadcrumb-content text-center">
                        <h2>{{ __('Pricing') }}</h2>
                        <p><a href="{{ url('/') }}">{{ __('Home') }}</a> > {{ __('Pricing') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb area end -->

<!-- pricing area start -->
<section>
    <div class="pricing-area pt-100 pb-100 mt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="pricing-header-area text-center">
                        <h2>{{ __('Pricing & Plans') }}</h2>
                        <p>{{ __('With lots of unique blocks, you can easily build a page without coding. Build your next landing page.') }}</p>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                @foreach ($plans as $plan)
              <div class="col-lg-4">
                <div class="single-pricing mb-30">
                    <div class="pricing-header">
                        <span>{{ $plan->name }}</span>
                    </div>
                    <div class="pricing-middle-area">
                        <div class="pricing-monthly-area">
                            <span>{{ get_option('currency_symbol') }}</span>
                            <h2>{{ $plan->price }}</h2>
                            <span> /{{ $plan->duration }} {{ __('Days') }}</span>
                        </div>
                        <div class="pricing-des">
                              <p>{{ $plan->is_trial == 1 ? __(' No Credit Card Required') : '' }}</p>
                        </div>
                    </div>
                    @php
                      $plandata = json_decode($plan->data);
                    @endphp
                     <div class="pricing-menu-area">
                        <nav>
                            <ul>
                                @foreach($plandata as $key => $row)
                                <li>
                                    
                                    
                                    @if($row == 'off') 
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z" fill="rgba(90,228,166,1)"/></svg>
                                    @endif
                                    {{ ucfirst(str_replace('_',' ',$key)) }}{{ $row != 'off' && $row != 'on' ? ': '.$row : '' }}{{ $key == 'storage_limit' ? ' MB' : '' }}
                                </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                    <div class="pricing-btn">
                        <a href="{{ route('user.register') }}">{{ __('Become A Partner') }} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg></a>
                    </div>
                </div>
              </div>
              @endforeach
            </div>
        </div>
    </div>
  </section>
  <!-- pricing area end -->

<!-- footer area start -->
@include('layouts.frontend.partials.footer')
<!-- footer area end -->
@endsection