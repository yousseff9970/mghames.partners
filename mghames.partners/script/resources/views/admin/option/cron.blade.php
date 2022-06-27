@extends('layouts.backend.app')

@section('title','Cron Jobs')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Cron Jobs'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-circle"></i> {{ __('Make Recurring Charge From Marchant Wallet For Renew Subscription') }} <code>{{ __('Once/day') }}</code></h4>
            </div>
            <div class="card-body">
                <div class="code"><p>curl -s {{ url('/cron/make-charge') }}</p></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-circle"></i> {{ __('Make Store Subscription Expire') }} <code>Once/day</code></h4>
            </div>
            <div class="card-body">
                <div class="code"><p>curl -s {{ url('/cron/alert-user/after/order/expired') }}</p></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-circle"></i> {{ __('Alert Before Expire The Subscription') }} <code>Once/day</code></h4>
            </div>
            <div class="card-body">
                <div class="code"><p>curl -s {{ url('/cron/alert-user/before/order/expired') }}</p></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-circle"></i> {{ __('Reset Store Product Discount Price After Expire The Date') }} <code>Once/day</code></h4>
            </div>
            <div class="card-body">
                <div class="code"><p>curl -s {{ url('/cron/tenant-reset-product-price') }}</p></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Customise Cron Jobs') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.cron.update','cron_option') }}" class="ajaxform">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Alert Message Before Expire The Plan') }}</label>
                        <div class="col-sm-12 col-md-7">
                           <textarea class="form-control" name="alert_message" required="">{{ $option->alert_message ?? '' }}</textarea>
                            
                        </div>
                    </div>
                   <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Alert Message After Expire The Plan') }}</label>
                        <div class="col-sm-12 col-md-7">
                           <textarea class="form-control" name="alert_message" required="">{{ $option->expire_message ?? '' }}</textarea>
                            
                        </div>
                    </div>
                     <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Alert Message After Expire The Trial') }}</label>
                        <div class="col-sm-12 col-md-7">
                           <textarea class="form-control" name="alert_message" required="">{{ $option->trial_expired_message ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Sent Notification Before Expire ') }}</label>
                        <div class="col-sm-12 col-md-7">
                           <input type="number" name="days" value="{{ $option->days ?? '' }}" placeholder="number of days" class="form-control" min="1" max="30">
                        </div>
                    </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                        <button type="submit" class="btn btn-primary basicbtn">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Recurring plan renewal message') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.cron.update','automatic_renew_plan_mail') }}" class="ajaxform">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('After Successfully make charged') }}</label>
                        <div class="col-sm-12 col-md-7">
                           <textarea class="form-control" name="order_complete" required="">{{ $automatic_renew_plan_mail->order_complete ?? '' }}</textarea>
                        </div>
                    </div>
                   <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('If user credits is low') }}</label>
                        <div class="col-sm-12 col-md-7">
                           <textarea class="form-control" name="user_balance_low" required="">{{ $automatic_renew_plan_mail->user_balance_low ?? '' }}</textarea>
                        </div>
                    </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                        <button type="submit" class="btn btn-primary basicbtn">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

