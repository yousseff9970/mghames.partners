@extends('layouts.backend.app')

@section('title','Select Payment')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Select Payment'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
         <div class="">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="card w-100">
                            <ul class="nav nav-pills mx-auto getwaycard" id="myTab3" role="tablist">
                                @foreach ($gateways as $key => $gateway)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="getway-tab{{ $gateway->id }}" data-toggle="tab" href="#getway{{ $gateway->id }}" role="tab" aria-controls="home" aria-selected="true">
                                        <div class="card-body">
                                            @if ($gateway->logo)
                                            <img src="{{ asset($gateway->logo) }}" alt="{{ $gateway->name }}" width="100">
                                            @else 
                                                {{ $gateway->name }}
                                            @endif
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="card-footer">
                                <div class="tab-content" id="myTabContent2">
                                @foreach ($gateways as $key => $gateway)
                                @php $data = json_decode($gateway->data) @endphp
                                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="getway{{ $gateway->id }}" role="tabpanel" aria-labelledby="getway-tab{{ $gateway->id }}">
                                        <div class="">
                                            <table class="table">
                                                <tr>
                                                    <td>{{ __('Amount') }}</td>
                                                    <td>{{ Session::get('deposit_amount') }}</td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Rate') }}</td>
                                                    <td>{{ $gateway->rate }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Charge') }}</td>
                                                    <td>{{ $gateway->charge }}</td>
                                                </tr>
                                                @php
                                                    $total_amount = (Session::get('deposit_amount') * $gateway->rate) + $gateway->charge;
                                                @endphp
                                                <tr>
                                                    <td>{{ __('Currency') }}</td>
                                                    <td>{{ $gateway->currency_name ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Total') }}
                                                        ({{ $gateway->currency_name }})
                                                    </td>
                                                    <td>{{ number_format($total_amount,2) }}</td>
                                                </tr>
                                                 
                                            </table>
                                        </div>
                                        <form action="{{ route('merchant.fund.deposit') }}" method="post" id="payment-form" class="paymentform" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $gateway->id }}">
                                            <div class="form-row">
                                                @if ($gateway->phone_required == 1)
                                                    <table class="table">
                                                        <tr>
                                                            <td><label for="">Phone</label></td>
                                                            <td>
                                                                <input type="text" class="form-control" name="phone"
                                                                    required
                                                                    {{ Session::has('phone') ? 'is-invalid' : '' }}>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                @endif
                                                @if ($gateway->is_auto == 0)
                                                    <table class="table">
                                                        <tr>
                                                            <td>{{ __('Payment instruction') }}

                                                            </td>
                                                            <td>{{ $gateway->data }}</td>
                                                        </tr>

                                                        @if($gateway->image_accept == 1)
                                                        <tr>
                                                            <td><label for="">{{ __('Screenshot') }}</label></td>
                                                            <td>
                                                                <input accept="image/*" type="file" class="form-control" name="screenshot"  required
                                                            {{ Session::has('screenshot') ? 'is-invalid' : '' }}>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td><label for="">{{ __('Comment') }}</label></td>
                                                            <td>
                                                                <textarea class="form-control h-150" name="comment" required id="" cols="30" rows="10" maxlength="200"></textarea>
                                                                {{ Session::has('comment') ? 'is-invalid' : '' }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                @endif
                                                <button type="submit" class="btn btn-primary mt-4 w-100 btn-lg" id="submit_btn">{{ __('Submit Payment') }}</button>
                                            </div>
                                        </form>
                                       </div>
                                    @endforeach
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