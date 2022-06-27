@extends('layouts.backend.app')

@push('css')
<!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush
@section('head')
@include('layouts.backend.partials.headersection',['title'=> $gateway->name,'prev'=> url('/seller/payment/gateway')])
@endsection

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $gateway->name }} {{ __('Method') }}</h4>
                    </div>
                    <form action="{{ route('seller.payment.gateway.store',$gateway->id) }}" method="POST" class="ajaxform">
                        @csrf
                 
                        <div class="card-body">
                            <div class="card-body pb-0">
                                 {{mediasection(['preview'=>$gateway->logo ?? '','value'=>$gateway->logo ?? ''])}}
                                <div class="form-group">
                                    <label for="name">{{ __('Display name at Checkout') }}</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $gateway->name ?? '' }}">
                                    <small class="form-text text-muted">{{ __('Customers will see this when checking out.') }}</small>
                                </div>
                                <div class="form-group">
                                    <label for="rate">Rate</label>
                                    <input type="number" id="rate" class="form-control" name="rate" value="{{ $gateway->rate ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="charge">Charge</label>
                                    <input type="number" id="charge" class="form-control" name="charge" value="{{ $gateway->charge ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="currency_name">{{ __('Currency Name') }}</label>
                                    <input type="text" class="form-control" id="currency_name" name="currency_name" value="{{ $gateway->currency_name ?? '' }}"> 
                                </div>
                                @php
                                    $data = json_decode($gateway->data);
                                @endphp
                                @if (is_array($data) || is_object($data))
                                @foreach ($data as $key => $item)
                                <div class="form-group">
                                    <label for="{{ $key }}">{{ ucwords(str_replace('_',' ',$key)) }}</label>
                                    <input type="text" name="data[{{ $key }}]" id="{{ $key }}" class="form-control" value="{{ $item }}" required="">
                                </div>
                                @endforeach
                                @endif
                                <input type="hidden" value="{{ $gateway->namespace }}" name="namespace">
                                <div class="form-group">
                                    <label for="instruction">{{ __('Instruction') }}</label>
                                    <textarea name="instruction" id="instruction" cols="30" rows="10" class="form-control">{{ $gateway->instruction ?? '' }}</textarea>
                                </div>
                                @if($gateway->is_auto == 1)
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input id="test" class="custom-control-input" {{ $gateway->test_mode ?? '' == 1 ? 'checked' : '' }} name="test_mode" type="checkbox" value="1">
                                        <label class="custom-control-label" for="test">{{ __('Sandbox Mode (Developer only)') }}</label>
                                        <small class="form-text text-muted">&nbsp&nbsp&nbsp {{ __('Test your') }} {{ $gateway['name'] }}   {{ __(' Setup by simulating successful and failed transactions.') }}</small>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input id="enabled" class="custom-control-input" {{ $gateway->status ?? '' == 1 ? 'checked' : '' }} name="status" type="checkbox" value="1">
                                        <label class="custom-control-label" for="enabled">{{ __('Enable') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix text-muted">
                                <div class="float-left clear-both">
                                <a class="btn btn-white" href="{{ route('seller.payment.gateway') }}">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary basicbtn">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
{{ mediasingle() }} 
@endsection

@push('script')
 <!-- JS Libraies -->
<script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('admin/plugins/dropzone/components-multiple-upload.js') }}"></script>
<script src="{{ asset('admin/js/media.js') }}"></script>
@endpush