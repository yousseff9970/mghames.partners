@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Plan Settings'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Settings') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4">
                            <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">Basic Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">Plan Renewal Massege</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab" aria-controls="contact" aria-selected="false">Plan Expire Settings & Alert Masseges</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="tab-content no-padding" id="myTab2Content">
                                <div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                                    <form class="ajaxform" method="post" action="{{ route('admin.plan.settings.update','general') }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Currency Name') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Currency name" required name="currency" value="{{ $currency->value }}">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Currency Symbol') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Currency Symbol" required name="currency_symbol" value="{{ $currency_symbol->value }}">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Tax') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                                <input type="number" step="any" class="form-control"
                                                placeholder="tax" required name="tax" value="{{ $tax->value }}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                            <div class="col-sm-12 col-md-7">
                                            <button type="submit" class="btn btn-primary float-right basicbtn">{{ __('Update') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                                    <form class="ajaxform" method="post" action="{{ route('admin.plan.settings.update','renewal') }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Order Complete Message') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" required="" name="order_complete">{{ $plan_renewal_massege->order_complete }}</textarea>
                                            <small>{{ __('It will show when your system successfully make charge from your user') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Alert to if user balance low') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" required="" name="user_balance_low">{{ $plan_renewal_massege->user_balance_low }}</textarea>
                                            <small>{{ __('It will show when your system cant charge for user balance low') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Alert to the user plan is not available') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" required="" name="plan_disabled">{{ $plan_renewal_massege->plan_disabled }}</textarea>
                                            <small>{{ __('It will show when the user current plan is disabled') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                            <div class="col-sm-12 col-md-7">
                                            <button type="submit" class="btn btn-primary float-right basicbtn">{{ __('Update') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
                                    <form class="ajaxform" method="post" action="{{ route('admin.plan.settings.update','cron') }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Total Alert Days') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                                <input type="number" class="form-control"
                                                placeholder="days" required name="days" value="{{ $cron_option->days }}">
                                                <small>{{ __('Note: It Will Send Notification Everyday Within The Selected Days Before Expire The Plan') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Plan Expire Soon') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" name="alert_message" required="">{{ $cron_option->alert_message }}</textarea>
                                            <small>{{ __('It will show when the user plan will expire soon') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Subscription Expired') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" name="expire_message" required="">{{ $cron_option->expire_message }}</textarea>
                                            <small>{{ __('It will show when the plan will expire') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Trial Expire Message') }}</label>
                                            <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" required="" name="trial_expired_message">{{ $cron_option->trial_expired_message }}</textarea>
                                            <small>{{ __('It will show when trial will expire') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                            <div class="col-sm-12 col-md-7">
                                            <button type="submit" class="btn btn-primary float-right basicbtn">{{ __('Update') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

