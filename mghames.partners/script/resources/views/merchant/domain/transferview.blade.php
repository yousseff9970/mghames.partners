@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Transfer Store','prev'=>route('merchant.domain.list')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Transfer Store') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('merchant.domain.transfer.otp',$info->id) }}" class="ajaxform">
                    @csrf
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('User email') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="email" class="form-control email"
                            required name="email" value="">                           
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Confirmation OTP') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" disabled="" class="form-control"
                            placeholder="OTP"   name="otp"  id="otp">                           
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Send OTP') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    "use strict";
    var i=0;
    function success(params) {
        i++
        $('.ajaxform').attr('action', "{{ route('merchant.domain.verify.otp',$info->id) }}");
        $('.email').attr('disabled','');
        $('#otp').removeAttr('disabled');
        $('.basicbtn').text('Submit');
    
        if (i > 1) {
            window.location.href="{{ route('merchant.domain.list') }}";
            
        }
    }
</script>
@endpush
