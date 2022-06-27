@extends('layouts.backend.app')

@section('title','Plan Payment history')

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
                            <td class="float-right">{{ $Info['main_amount']+$Info['charge'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Amount') }} ({{ $Info['currency'] }})</td>
                            <td class="float-right">{{ $Info['amount'] }}</td>
                        </tr>  
                        <tr>
                            <td>{{ __('Payment Mode') }}</td>
                            <td class="float-right">{{ __('Paystack') }}</td>
                        </tr>                                      
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <button class="btn btn-primary mt-4 col-12 w-100 btn-lg" id="payment_btn">{{ __('Pay Now') }}</button>
            </div>
        </div>
    </div>
</div>   


<form method="post" class="status" action="{{ url('/payment/paystack') }}">
    @csrf
    <input type="hidden" name="ref_id" id="ref_id">
</form>
<input type="hidden" value="{{ $Info['currency'] }}" id="currency">
<input type="hidden" value="{{ $Info['amount'] }}" id="amount">
<input type="hidden" value="{{ $Info['public_key'] }}" id="public_key">
<input type="hidden" value="{{ $Info['email'] ?? Auth::user()->email }}" id="email">
@endsection


@push('script')
<script src="https://js.paystack.co/v1/inline.js"></script> 
<script>
    "use strict";

    $('#payment_btn').on('click',()=>{
        payWithPaystack();
    });
   payWithPaystack();
 
    function payWithPaystack() {
        var amont= $('#amount').val() * 100 ;
        let handler = PaystackPop.setup({
            key: $('#public_key').val(), // Replace with your public key
            email: $('#email').val(),
            amount: amont,
            currency: $('#currency').val(),
            ref: 'ps_{{ Str::random(15) }}',
            onClose: function(){
                payWithPaystack();
            },
            callback: function(response){
                $('#ref_id').val(response.reference);
                $('.status').submit();
            }
        });
        handler.openIframe();
    }
</script>
@endpush