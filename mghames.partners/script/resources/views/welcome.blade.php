@extends('layouts.frontend.app')

@section('title','HomePage')

@section('content')
<!-- header area start -->
@include('layouts.frontend.partials.header')
<!-- header area end -->
<script src="https://support.mghames.com/js/min/jquery.min.js"></script>
<script id="sbinit" src="https://support.mghames.com/js/main.js"></script>
<!-- hero area start -->
<section>
  <div class="hero-area">
      <div class="container">
          <div class="row align-items-center">
              <div class="col-lg-5">
                  <div class="hero-content">
                      <h2>{{ __('hero_title') }}</h2>
                      <p>{{ __("hero_des") }}</p>
                        <form action="{{ route('register') }}" method="GET">
                            @csrf 
                            <div class="hero-input">
                                <div class="input-filed">
                                    <div class="input-icon">
                                        <span>@</span>
                                    </div>
                                    <input type="text" placeholder="{{ __('Enter your email...') }}" name="email">
                                </div>
                                <div class="hero-btn">
                                    <button type="submit">{{ __('Start Free Trial') }}</button>
                                </div>
                            </div>
                        </form>
                        <div class="hero-small-message">
                            <p>{{ __('hero_small_message') }}</p>
                        </div>
                  </div>
              </div>
              <div class="col-lg-7">
                  <div class="hero-img">
                      @php
                      $hero_img=$info->hero_img ?? '';
                      @endphp
                      <img class="img-fluid" src="{{ asset('uploads/'.$hero_img) }}" alt="">
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- hero area end -->

<!-- demo area start -->
<section>
    <div class="demo-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="demo-header-area">
                        <h1>{{ __('See Our Themes Lists') }}</h1>
                        <p>{{ __('theme_des') }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="demo-header-right-area">
                        <a href="{{ url('demos') }}">{{ __('Explore More Themes') }} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg></a>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                @foreach ($demos as $demo)
                <div class="col-lg-4">
                    <div class="single-demo text-center">
                        <div class="demo-img">
                            @php
                                $data = json_decode($demo->meta->value ?? '');
                            @endphp
                            <a href="{{ $data->theme_url ?? '' }}" target="_blank"><img class="img-fluid" src="{{ asset('uploads/demo/'.$data->theme_image ?? '') }}" alt=""></a>
                        </div>
                        <div class="demo-name">
                            <h4>{{ $demo->title }}</h4>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- demo area end -->

<!-- features area start -->
<section>
  <div class="features-area pt-150 mb-150">
      <div class="container">
          <div class="row align-items-center">
              <div class="col-lg-7">
                  <div class="row">
                      @foreach ($services as $service)
                        <div class="col-lg-6">
                          <div class="single-features">
                              @php
                                  $serviceinfo = json_decode($service->servicemeta->value ?? '');
                              @endphp
                              <div class="features-img">
                                  <img src="{{ asset($serviceinfo->image ?? '') }}" alt="">
                              </div>
                              <div class="features-title">
                                  <h4>{{ $service->title }}</h4>
                              </div>
                              
                              <div class="features-des">
                                  <p>{{ $serviceinfo->short_content ?? '' }}</p>
                              </div>
                          </div>
                      </div>
                      @endforeach
                  </div>
              </div>
              <div class="col-lg-5">
                  <div class="key-features-content">
                      <h5>{{ __('Our Key Features') }}</h5>
                      <h2>{{ __('service_title') }}</h2>
                      <p>{{ __("service_des") }}</p>
                      <div class="features-btn">
                          <a href="#">{{ __('Learn More') }}</a>
                          <a href="{{ url('/contact') }}">{{ __('Talk with us') }}</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- features area end -->

<!-- pricing area start -->
<section>
  <div class="pricing-area pt-150 pb-150">
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
                <div class="single-pricing">
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

<!-- Details area Start -->
<section>
    <div class="details-area-start mt-150">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="details-img">
                        <img class="img-fluid" src="{{ asset('uploads/'.$info->market_img ?? '') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="details-content">
                        <h3>{{ __('Market your business') }}</h3>
                        <p>{{ __('market_des') }}</p>
                        <a href="{{ $info->market_url ?? '' }}">{{ __('Explore how to market your busines') }}s <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Details area end -->

<!-- Details area Start -->
<section>
    <div class="details-area-start mt-150">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="details-content">
                        <h3>{{ __('Sell everywhere') }}</h3>
                        <p>{{ __('sell_des') }}</p>
                        <a href="{{ $info->sell_url ?? '' }}">{{ __('Explore ways to sell') }} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg></a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="details-img">
                        <img class="img-fluid" src="{{ asset('uploads/'.$info->sell_img ?? '') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Details area end -->


<!-- blog area start -->
<section>
  <div class="blog-area mb-150 mt-150">
      <div class="container">
          <div class="row">
              <div class="col-lg-6 offset-lg-3">
                  <div class="blog-header-area text-center">
                      <h2>{{ __('Our Recent Story') }}</h2>
                      <p>{{ __('news_des') }}</p>
                  </div>
              </div>
          </div>
          <div class="row mt-5">
              @foreach ($blogs as $blog)
              <div class="col-lg-4">
                <div class="single-blog">
                    <div class="blog-img">
                        <img class="img-fluid" src="{{ asset($blog->preview->value) }}" alt="">
                    </div>
                    <div class="blog-content">
                        <div class="blog-author-date">
                            <span>{{ $blog->created_at->toDateString() }}</span>
                        </div>
                        <div class="blog-title">
                            <h2>{{ $blog->title }}</h2>
                        </div>
                        <div class="blog-des">
                            <p>{{ $blog->excerpt->value ?? '' }}</p>
                        </div>
                        <div class="blog-action">
                            <a href="{{ route('blog.show',$blog->slug) }}">{{ __('Read Story') }} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg></a>
                        </div>
                    </div>
                </div>
              </div> 
              @endforeach
          </div>
      </div>
  </div>
</section>
<!-- blog area end -->

<!-- footer area start -->
@include('layouts.frontend.partials.footer')
<!-- footer area end -->
@endsection