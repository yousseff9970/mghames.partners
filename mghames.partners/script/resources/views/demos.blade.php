@extends('layouts.frontend.app')

@section('title','HomePage')

@section('content')
<!-- header area start -->
@include('layouts.frontend.partials.header')
<!-- header area end -->

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
            </div>
            <div class="row mt-5">
                @foreach ($demos as $demo)
                <div class="col-lg-4">
                    <div class="single-demo text-center">
                        <div class="demo-img">
                            @php
                                $info = json_decode($demo->meta->value);
                            @endphp
                            <a href="{{ $info->theme_url }}" target="_blank"><img class="img-fluid" src="{{ asset('uploads/demo/'.$info->theme_image) }}" alt=""></a>
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

<!-- footer area start -->
@include('layouts.frontend.partials.footer')
<!-- footer area end -->
@endsection