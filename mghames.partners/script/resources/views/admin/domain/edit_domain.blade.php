@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Domain','prev'=>route('admin.domain.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Edit Domain') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.domain.update',$info->id) }}" class="ajaxform">
                    @csrf
                    @method('PUT')                 
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Store ID') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control"
                            placeholder="Store Id"  name="tenant_id" required value="{{ $info->tenant_id }}">     
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Enter Domain Without Protocol') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control"
                            placeholder="Domain Name"  name="domain"  value="{{ $info->domain }}">     
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Status') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="status">
                                <option value="1" @if($info->status == 1) selected @endif>{{ __('Active') }}</option>
                                <option value="2" @if($info->status == 2) selected @endif>{{ __('Pending') }}</option>
                                <option value="0" @if($info->status == 0) selected @endif>{{ __('Disabled') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

