@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Store','prev'=>route('merchant.domain.list')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Edit Store') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('merchant.domain.update',$info->id) }}" class="ajaxform">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Store Name') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control"
                            placeholder="Store name" required name="name" value="{{ $info->id }}">                           
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <label class="">
                                <input type="checkbox" name="auto_renew"  {{ $info->auto_renew == 1 ? 'checked' : '' }} value="1" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">{{ __('Automatic Renew From My Credits') }}</span>
                            </label>      
                        </div>
                    </div>
                    @foreach($arr ?? []  as $key => $row)
                    <div class="form-group row mb-4">
                            <label
                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ str_replace('_', ' ',$key) }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" disabled="" class="form-control"
                                value="{{ $info->$key ?? '' }}">                           
                            </div>
                        </div>
                    @endforeach
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Update Store') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="{{ route('merchant.domain.list') }}" id="domain_index">   
@endsection

@push('script')
    <script>
      "use strict";

      function success(params) {
          var url=$('#domain_index').val();
          window.location=url;
      }
  </script>
@endpush
