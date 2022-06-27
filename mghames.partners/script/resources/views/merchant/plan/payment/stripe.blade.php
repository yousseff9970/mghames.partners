@extends('layouts.backend.app')

@section('title','Select Payment Getway')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Make Payment'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="px-4">
                    <table class="table">
                        <tr>
                            <td>{{ __('Amount') }}</td>
                            <td class="float-right">{{ $Info['main_amount'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Charge') }}</td>
                            <td class="float-right">{{ $Info['charge'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Total') }}</td>
                            <td class="float-right">{{ $Info['main_amount'] + $Info['charge'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Amount ') }} ({{ $Info['currency'] }})</td>
                            <td class="float-right">{{ $Info['amount'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Payment Mode') }}</td>
                            <td class="float-right">{{ __('Stripe') }}</td>
                        </tr>
                    </table>
                    <form action="{{ url('stripe/payment') }}" method="post" id="payment-form" class="paymentform p-4">
                        @csrf
                        <div class="form-row">
                            <label for="card-element">
                                {{ __('Credit or debit card') }}
                            </label>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 mt-4" id="submit_btn">{{ __('Submit Payment') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="publishable_key" value="{{ $Info['publishable_key'] }}">

@endsection

@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('admin/assets/js/stripe.js') }}"></script>
@endpush
