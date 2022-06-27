@extends('layouts.backend.app')

@section('title','Create Order')


@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Create Order','prev'=> route('admin.order.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Create Order') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.order.store') }}" class="ajaxform_with_reset">
                @csrf
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Email') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" placeholder="User Email" required name="email">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Plan') }}</label>
                        <div class="col-sm-12 col-md-7" >
                            <select name="plan_id" class="form-control selectric">
                                @foreach ($plans as $plan)
                                    @php $info = json_decode($plan->data) @endphp
                                    <option data-subdomain="{{ $info->sub_domain }}" data-customdomain="{{ $info->custom_domain }}" value="{{ $plan->id }}">{{ $plan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Store Id') }}</label>
                        <div class="col-sm-12 col-md-7" >
                            <input name="store_id" required="" placeholder="store id" type="text" class="form-control ">
                        </div> 
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Gateway') }}</label>
                        <div class="col-sm-12 col-md-7" >
                            <select name="getway_id" class="form-control selectric">
                                @foreach ($getways as $getway)
                                    <option value="{{ $getway->id }}">{{ $getway->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Trx') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" placeholder="Trx" required name="trx">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Send Email to customer?') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="email_status" class="form-control selectric">
                                <option value="1">{{ __('Yes') }}
                                </option>
                                <option value="0" selected>{{ __('No') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                        <div class="col-sm-12 col-md-7" name="status">
                            <select name="status" class="form-control selectric">
                                <option value="2">
                                    {{ __('Pending') }}
                                </option>
                                <option value="1">
                                    {{ __('Approved') }}
                                </option>
                                <option value="3">
                                    {{ __('Expired') }}
                                </option>
                                <option value="0">
                                    {{ __('Rejected') }}
                                </option>
                            </select>
                        </div>
                    </div>
                     <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Payment Status') }}</label>
                            <div class="col-sm-12 col-md-7" name="payment_status">
                                <select name="payment_status" class="form-control selectric">
                                    <option value="2" >
                                        {{ __('Pending') }}
                                    </option>
                                    <option value="1" >
                                        {{ __('Approved') }}
                                    </option>
                                    <option value="0" >
                                        {{ __('Reject') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Assign Plan To The Store') }}</label>
                            <div class="col-sm-12 col-md-7" name="payment_status">
                                <select name="plan_assign" class="form-control selectric">
                                    <option value="yes">
                                        {{ __('Yes') }}
                                    </option>
                                    <option value="no" selected="">
                                        {{ __('No') }}
                                    </option>
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

<input type="hidden" id="app_url_with_tenant" value="{{ env('APP_URL_WITH_TENANT') }}">
@endsection


