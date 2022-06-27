@extends('layouts.backend.app')

@section('title', 'Create Partner')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Partner Create','button_name'=> 'All
    Partners','button_link'=> route('admin.partner.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Create Partner') }}</h4>
            </div>
             <form method="POST" action="{{ route('admin.partner.store') }}" class="ajaxform_with_reset"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }}</label>
                            <div class="col-sm-12 col-md-7" name="payment_status">
                                 <input type="text" class="form-control" name="name" required="">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Email') }}</label>
                            <div class="col-sm-12 col-md-7" name="payment_status">
                                  <input type="text" id="emil" class="form-control" name="email" required="">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Password') }}</label>
                            <div class="col-sm-12 col-md-7" name="payment_status">
                                 <input type="password" id="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('status') }}</label>
                            <div class="col-sm-12 col-md-7" name="payment_status">
                                <select name="status" class="form-control selectric">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                </select>
                            </div>
                        </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary basicbtn w-100 btn-lg" type="submit">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
