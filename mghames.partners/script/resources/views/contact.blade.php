@extends('layouts.frontend.app')

@section('title','Contact Us')

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
                        <h2>{{ __('Contact Us') }}</h2>
                        <p><a href="{{ url('/') }}">{{ __('Home') }}</a> > {{ __('Contact Us') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb area end -->


<section>
    <div class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="header-form-area mt-0">
                        <div class="header-form-title">
                            <h2>{{ __('Contact Us') }}</h2>
                        </div>
                        <div class="header-form-body-area">
                            <form action="{{ route('contact.send') }}" method="POST" class="ajaxform_with_reset">
                                @csrf 
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Email') }}</label>
                                            <input type="text" class="form-control" name="email">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{ __('Subject') }}</label>
                                            <input type="text" class="form-control" name="subject">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{ __('Message') }}</label>
                                            <textarea name="message" cols="30" rows="5" class="form-control" name="message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="contact-btn f-right">
                                            <button type="submit">{{ __('Send Message') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    @php
                        $info = get_option('footer_theme',true);
                    @endphp
                    <div class="contact-map">
                        <iframe src="https://maps.google.com/maps?q={{ $info->address ?? null }}&z=13&ie=UTF8&iwloc=&output=embed" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- footer area start -->
@include('layouts.frontend.partials.footer')
<!-- footer area end -->
@endsection