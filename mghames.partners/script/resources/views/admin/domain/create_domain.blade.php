@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Create Domain','prev'=>route('admin.domain.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Create Domain') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.domain.store') }}" class="ajaxform_with_reset">
                    @csrf                    
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Store ID') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control"
                            placeholder="Store Id"  name="tenant_id" required value="">     
                        </div>
                    </div>
                    <div class="form-group row mb-4 customdomain_area">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Enter Domain Without Protocol') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control"
                            placeholder="Domain Name"  name="domain"  value="">     
                        </div>
                    </div>
                    <div class="form-group row mb-4 subdomain_area">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Add new subdomain') }}</label>
                        <div class="col-sm-12 col-md-7">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control text-right" name="subdomain" placeholder="" value="">
                            <div class="input-group-append">
                            <div class="input-group-text">.{{ env('APP_PROTOCOLESS_URL') }}</div>
                            </div>
                        </div>
                        <small class="form-text">{{ __('Example:') }} {example}.{{ env('APP_PROTOCOLESS_URL') }}</small>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Domain Type') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="type" id="type">
                                <option value="subdomain">{{ __('Subdomain') }}</option>
                                <option value="customdomain">{{ __('Custom Domain') }}</option>
                            </select>  
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('admin/js/admin.js') }}"></script>
@endpush
