@extends('layouts.backend.app')
@section('head')
@include('layouts.backend.partials.headersection',['title'=> 'Themes'])
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <div class="card">
            
            <div class="card-body">
                <div class="row">
                    @foreach ($themes as $item)
                    <div class="col-lg-4">
                        <div class="single-main-theme">
                            <div class="theme-main-img">
                                <img class="img-fluid" src="{{ asset($item->asset_path.'/screenshot.png') }}" alt="">
                            </div>
                            <div class="theme-name">
                                <h3>{{ $item->name }}</h3>
                            </div>
                            @if (tenant('theme') == $item->view_path)
                            <div class="theme-btn">
                                <a href="javascript:void(0)" class="btn btn-info btn-lg w-100">{{ __('Installed') }}</a>
                            </div>
                            @else 
                            <div class="theme-btn">
                                <a href="{{ route('seller.theme.install',$item->name) }}" class="btn btn-primary btn-lg w-100">{{ __('Install') }}</a>
                            </div>
                            @endif
                        </div>
                    </div> 
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection