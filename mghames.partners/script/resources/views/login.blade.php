@extends('layouts.frontend.app')

@section('title','Login')

@section('title','Register')

@section('content')
<!-- register area start -->
<section>
    <div class="register-area"> 
        <div class="container mr-0 pr-0">
            <div class="row">
                @php
                    $info = get_option('theme',true);
                @endphp
                <div class="col-lg-6">
                    <div class="header-logo-area">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('uploads/'.$info->logo_img) }}" alt="">
                        </a>
                    </div>
                    <div class="header-form-area pb-100">
                        <div class="header-form-title">
                            <h2>{{ __('Log In') }}</h2>
                        </div>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf 
                            <div class="header-form-body-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{ __('Email') }}</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{ __('Password') }}</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                            <label class="form-check-label" for="remember_me">
                                              {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="forgotten-pass">
                                            <a href="{{ route('password.request') }}">Forgotten Password?</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="button-btn">
                                            <button type="submit">{{ __('Log In') }}</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="already-have-member">
                                            <p>{{ __("Doesn't have an Account?") }}<a href="{{ route('user.register') }}"> {{ __('Sign Up') }}</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="register-right-section">
                        <img class="img-fluid" src="{{ asset('uploads/register.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- register area end -->
@endsection

