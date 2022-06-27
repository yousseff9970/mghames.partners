@extends('theme.grocery.layouts.app')

@section('content')
<div class="thanks-section">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="thanks-main-area text-center">
                <img src="{{ asset('theme/grocery/img/thanks.png') }}" alt="">
                <div class="thanks-des-content">
                    <h2>Thank You <br>Your Order Successfully <br>been Placed</h2>
                </div>
                <div class="thanks-btn">
                    <a href="{{ url('customer/dashboard') }}">View Order Status</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




