@extends('layouts.backend.app')

@section('title','Plan Payment history')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Plan Payment history'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <img  src="{{ asset($gateway->logo) }}" alt="" height="100">
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
                            <td>{{ __('Amount ') }} ({{ $Info['currency'] }})</td>
                            <td class="float-right">{{ $Info['amount'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Payment Mode') }}</td>
                            <td class="float-right">{{ __('Razorpay') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <button class="btn btn-primary mt-4 col-12 btn-lg w-100" id="rzp-button1">{{ __('Pay Now') }}</button>
            </div>
        </div>
    </div>
</div>

<form action="{{ url('/partner/razorpay/status')}}" method="POST" hidden>
    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
    <input type="text" class="form-control" id="rzp_paymentid" name="rzp_paymentid">
    <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
    <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">
    <button type="submit" id="rzp-paymentresponse" hidden class="btn btn-primary"></button>
</form>
<input type="hidden" value="{{ $response['razorpayId'] }}" id="razorpayId">
<input type="hidden" value="{{ $response['amount'] }}" id="amount">
<input type="hidden" value="{{ $response['currency'] }}" id="currency">
<input type="hidden" value="{{ $response['name'] }}" id="name">
<input type="hidden" value="{{ $response['description'] }}" id="description">
<input type="hidden" value="{{ $response['orderId'] }}" id="orderId">
<input type="hidden" value="{{ $response['name'] }}" id="name">
<input type="hidden" value="{{ $response['email'] }}" id="email">
<input type="hidden" value="{{ $response['contactNumber'] }}" id="contactNumber">
<input type="hidden" value="{{ $response['address'] }}" id="address">
@endsection

@push('script')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="{{ asset('admin/assets/js/razorpay.js')}}"></script>
@endpush
