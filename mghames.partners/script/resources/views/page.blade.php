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
                        <h2>{{ $page->title }}</h2>
                        <p><a href="{{ url('/') }}">{{ __('Home') }}</a> > {{ $page->title }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb area end -->

<!-- page area start -->
<section>
    <div class="page-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @php
                        $data = json_decode($page->pagecontent->value);
                    @endphp
                    <div class="page-content">
                        <p>{{ $data->page_excerpt ?? '' }}</p>
                       {{ content_format($data->page_content ?? '') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- page area end -->

<!-- footer area start -->
@include('layouts.frontend.partials.footer')
<!-- footer area end -->
@endsection