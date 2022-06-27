@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Plan Payment history'])
@endsection

@section('content')
<div class="row">
    <div class="offset-3 col-6">
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
                            <td class="float-right">{{ $Info['main_amount']+$Info['charge'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Amount (GHS)') }}</td>
                            <td class="float-right">{{ $Info['amount'] }}</td>
                        </tr>  
                        <tr>
                            <td>{{ __('Payment Mode') }}</td>
                            <td class="float-right">{{ __('Hyperpay') }}</td>
                        </tr>                                      
                    </table>
                </div>
            </div>
            <form action="{{ url('/payment/hyperpay') }}" class="paymentWidgets" data-brands="VISA MASTER AMEX">
                @csrf
            </form>
        </div>
    </div>
</div>   
@endsection

@push('js')
<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $response->id }}"></script>
@endpush