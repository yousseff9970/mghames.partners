@extends('layouts.frontend.app')

@section('title','Register')

@section('content')
<!-- register area start -->
<section>
    <div class="register-area">
        <div class="container mr-0 pr-0">
            <div class="row">
                @php
                    $info = get_option('theme',true);
                    $logo_img=$info->logo_img ?? '';
                @endphp
                <div class="col-lg-6">
                    <div class="header-logo-area">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('uploads/'.$logo_img) }}" alt="">
                        </a>
                    </div>
                    <div class="header-form-area pb-100">
                        <div class="header-form-title">
                            <h2>{{ __('Sign up') }}</h2>
                        </div>
                        <div class="header-form-body-area">
                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf 
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('First Name') }}</label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name">
                                            @error('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Last Name') }}</label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name">
                                            @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{ __('Email') }}</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email }}" name="email">
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Password') }}</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Confirm Password') }}</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="button-btn">
                                            <button type="submit">{{ __('Sign Up') }}</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="already-have-member">
                                            <p>{{ __('Already a member?') }}<a href="{{ route('user.login') }}"> {{ __('Sign In') }}</a></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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

