@extends('layouts.backend.app')

@section('title','Edit Order')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Order','prev'=> route('admin.order.index')])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Order Edit') }}</h4>
                </div>
                <form method="POST" action="{{ route('admin.order.update',$order->id) }}" class="ajaxform">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Email') }}<sup>*</sup></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" readonly="" placeholder="User Email" required name="email" value="{{ $order->user->email }}"></div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Plan') }}</label>
                            <div class="col-sm-12 col-md-7" >
                                <select name="plan_id" class="form-control selectric">
                                    @foreach ($plans as $plan)
                                    @php $info = json_decode($plan->data) @endphp
                                        <option value="{{ $plan->id }}" {{ $order->plan_id == $plan->id ? 'selected' : '' }}>{{ $plan->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Gateway') }}</label>
                            <div class="col-sm-12 col-md-7" >
                                <select name="getway_id" class="form-control selectric">
                                    @foreach ($getways as $getway)
                                            <option value="{{ $getway->id }}"
                                                {{ $order->getway_id == $getway->id ? 'selected' : '' }}>
                                                {{ $getway->name }}
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Trx') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" placeholder="Trx" required name="trx"
                                    value="{{ $order->trx }}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Send Email to customer?') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <select name="email_status" class="form-control">
                                    <option value="1">{{ __('Yes') }}
                                    </option>
                                    <option value="0" selected>{{ __('No') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Order Status') }}</label>
                            <div class="col-sm-12 col-md-7" name="status">
                                <select name="status" class="form-control">
                                    <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>
                                        {{ __('Pending') }}
                                    </option>
                                    <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>
                                        {{ __('Approved') }}
                                    </option>
                                    <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>
                                        {{ __('Cancel') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Payment Status') }}</label>
                            <div class="col-sm-12 col-md-7" name="payment_status">
                                <select name="payment_status" class="form-control">
                                    <option value="2" {{ $order->payment_status == 2 ? 'selected' : '' }}>
                                        {{ __('Pending') }}
                                    </option>
                                    <option value="1" {{ $order->payment_status == 1 ? 'selected' : '' }}>
                                        {{ __('Approved') }}
                                    </option>
                                    <option value="0" {{ $order->payment_status == 0 ? 'selected' : '' }}>
                                        {{ __('Reject') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Assign Plan To The Store') }}</label>
                            <div class="col-sm-12 col-md-7" name="payment_status">
                                <select name="plan_assign" class="form-control">
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
                            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
    
