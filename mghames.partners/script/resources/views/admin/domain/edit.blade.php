@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Store','prev'=>route('admin.store.index')])
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

                <form method="POST" action="{{ route('admin.store.update',$info->id) }}" class="ajaxform">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Store Id') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control"
                            placeholder="Store Id" required name="store_id" value="{{ $info->id }}">                           
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Owner Email') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="email" class="form-control"
                            placeholder="Customer Email" required name="user_email" required value="{{ $info->user->email ?? '' }}">                           
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="status" class="form-control">
                                <option value="1" @if($info->status == 1) selected @endif>{{ __('Active') }}</option>
                                <option value="2" @if($info->status == 2) selected @endif>{{ __('Pending') }}</option>
                                <option value="3" @if($info->status == 3) selected @endif>{{ __('Expired') }}</option>
                                <option value="0" @if($info->status == 0) selected @endif>{{ __('Disable') }}</option>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Update Domain') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="{{ route('admin.store.index') }}" id="domain_index">   
@endsection

@push('script')
 <script src="{{ asset('admin/js/domain/edit.js') }}"></script>
@endpush
