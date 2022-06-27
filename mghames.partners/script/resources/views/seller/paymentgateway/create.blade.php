@extends('layouts.backend.app')

@push('css')
<!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush
@section('head')
@include('layouts.backend.partials.headersection',['title'=> 'Create Payment Method','prev'=> url('/seller/payment/gateway')])
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Create Custom Payment') }}</h4>
                    </div>
                    <form action="{{ route('seller.custom.payment') }}" method="POST" class="ajaxform">
                        @csrf
                        <div class="card-body">
                            <div class="card-body pb-0">
                                 {{mediasection()}}
                                <div class="form-group">
                                    <label for="name">{{ __('Display name at Checkout') }}</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    <small class="form-text text-muted">{{ __('Customers will see this when checking out.') }}</small>
                                </div>
                                <div class="form-group">
                                    <label for="rate">Rate</label>
                                    <input type="number" id="rate" class="form-control" name="rate">
                                </div>
                                <div class="form-group">
                                    <label for="charge">Charge</label>
                                    <input type="number" id="charge" class="form-control" name="charge">
                                </div>
                                <div class="form-group">
                                    <label for="currency_name">{{ __('Currency Name') }}</label>
                                    <input type="text" class="form-control" id="currency_name" name="currency_name"> 
                                </div>
                                <div class="form-group">
                                    <label for="instruction">{{ __('Instruction') }}</label>
                                    <textarea name="instruction" id="instruction" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input id="enabled" class="custom-control-input" name="status" type="checkbox" value="1">
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