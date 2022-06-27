@extends('layouts.backend.app')

@section('title','Payment Details')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Payment Details'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="">
            <div class="">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="main-container">
                            <div class="header-section">
                                <h4>{{ __('Payment') }}</h4>
                            </div>
                            <div class="section-body">
                                <div class="card w-50">
                                    <div class="card-body">
                                        <img src="{{ asset($gateway->logo) }}" alt="" width="100%">
                                    </div>
                                    <div class="px-4">
                                        <table class="table">
                                            <tr>
                                                <td>{{ __('Amount') }}</td>
                                                <td>{{ App\Models\Option::where('key','currency_icon')->first()->value }}{{ $data->amount }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total ({{ $gateway->currency }})
                                                </td> 
                                                <td>{{ $data->total_amount }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                        <form action="{{ route('user.plan.deposit') }}" method="post" id="payment-form" class="">
                                            @csrf
                                            <div class="form-row">
                                                <input type="hidden" name="id" value="{{ $gateway->id }}">
                                                <label for="card-element">
                                                    {{ __('Credit or debit card') }}
                                                </label>
                                                <div id="card-element">
                                                <!-- A Stripe Element will be inserted here. -->
                                                </div>
                                                <!-- Used to display form errors. -->
                                                <div id="card-errors" role="alert"></div>
                                            </div>
                                            <button class="btn btn-primary mt-4 w-100 btn-lg" id="submit_btn">{{ __('Submit Payment') }}</button>
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
</div>
<input type="hidden" id="stripe_api_key" value='{{ $data->publishable_key }}'>
@endsection

@push('js')
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('backend/admin/assets/js/paymentgateway.js') }}"></script>
@endpush