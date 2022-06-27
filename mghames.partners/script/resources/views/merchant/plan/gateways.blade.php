@extends('layouts.backend.app')

@section('title','Select Payment Getway')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>  $plan->is_trial == 1 ? 'Enter Store name' : 'Select Payment Getway']) 
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="">
            <div class="">
                <div class="row">
                    <div class="offset-2 col-lg-8">
                        @if ($plan->is_trial == 0)
                        @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>           
                                    @foreach ($errors->all() as $error)
                                       <li>
                                        {{ $error }}
                                       </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @endif
                    </div>
                </div>
                @if ($plan->is_trial == 0)
                <div class="row">
                    <div class="offset-2 col-lg-8">
                        @if (Session::has('alert'))
                        <div class="alert {{ Session::get('type') }}">
                            {{ Session::get('alert') }}
                        </div>
                        @endif
                        <div class="card w-100">
                            <ul class="nav nav-pills mx-auto" id="myTab3" role="tablist">
                                @foreach ($gateways as $gateway)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $gateway->first()->id == $gateway->id ? 'active' : '' }}" id="getway-tab{{ $gateway->id }}" data-toggle="tab"
                                            href="#getway{{ $gateway->id }}" role="tab" aria-controls="home"
                                            aria-selected="true">
                                            <div class="card-body">
                                                <img class="payment-img" src="{{ asset($gateway->logo) }}" alt="{{ $gateway->name }}"
                                                    width="100">
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="card-footer">
                                <div class="tab-content" id="myTabContent2">
                                    @foreach ($gateways as $key => $gateway)
                                        @php $data = json_decode($gateway->data) @endphp
                                        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                            id="getway{{ $gateway->id }}" role="tabpanel"
                                            aria-labelledby="getway-tab{{ $gateway->id }}">
                                            <div class="">
                                                <table class="table">
                                                    <tr>
                                                        <td><strong>{{ __('Amount') }}</strong></td>
                                                        <td class="float-right">{{ $plan->price }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{ __('Currency') }}</strong></td>
                                                        <td class="float-right">{{ strtoupper($gateway->currency_name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{ __('Charge') }}</strong></td>
                                                        <td class="float-right">{{ $gateway->charge }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{ __('Rate') }}</strong></td>
                                                        <td class="float-right">{{ $gateway->rate }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{ __('Tax') }}</strong></td>
                                                        <td class="float-right">{{ (($plan->price / 100) * $tax->value), 2 }} ({{ $tax->value }} %) </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{ __('Total (Including Tax)') }}</strong></td>
                                                        <td class="float-right">{{ $withTax = (round($plan->price + (($plan->price / 100) * $tax->value), 2) * $gateway->rate) + $gateway->charge }}</td>
                                                        </tr>
        
                                                </table>
                                            </div>

                                            <form action="{{ isset($info) ? route('merchant.plan.renew-plan',$info->id) : route('merchant.plan.deposit') }}" method="post"
                                                class="paymentform" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" class="form-control" name="custom_domain">
                                                <input type="hidden" class="form-control" name="sub_domain">
                                                <input type="hidden" class="form-control" name="name">
                                                <div class="form-row">
                                                    @if ($gateway->phone_required == 1)
                                                        <table class="table">
                                                            <tr>
                                                                <td><label for="">Phone</label></td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="phone" required {{ Session::has('phone_error') ? 'is-invalid' : '' }}>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                    @if ($gateway->image_accept == 1)
                                                        <table class="table">
                                                            <tr>
                                                                <td>
                                                                    <label >{{ __('Payment Instructions') }}</label>
                                                                    
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ content_format($gateway->data) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label for="screenshot">{{ __('Upload Screenshot') }}</label>
                                                                    <input type="file" name="screenshot"
                                                                        class="form-control"
                                                                        value="" required/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label for="comment">{{ __('Comments') }}</label>
                                                                    <textarea class="form-control h-100" name="comment" id="" cols="30" rows="10"></textarea>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                    <input type="hidden" name="id" value="{{ $gateway->id }}">
                                                    <input type="hidden" name="plan_id"
                                                        value="{{ $plan->id }}">
                                                    <button type="submit"
                                                        class="btn btn-primary paymentbtn btn-lg w-100">{{ __('Submit Payment')}}</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('admin/js/merchant.js') }}"></script>
@endpush
