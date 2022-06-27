@extends('layouts.backend.app')

@section('title', 'Payment Report')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Payment Report'])
@endsection
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/reportshow.css') }}">
@endpush
@section('content')
<div class="container">
    <div class="invoice" id="printableArea">
        <div class="row">
            <div class="col-7">
                <h4 class="display-5">{{ $data->invoice_no }}</h4>
            </div>
            <div class="col-5">
                <h4 class="document-type display-5 text-right">{{ config('app.name') }}</h4>
                <p class="text-right"><strong>Today Date : {{ \Carbon\Carbon::now()->format('M d Y') }}</strong></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <address>
                    <strong>{{ __('Billed To:') }}</strong><br>
                    {{ $data->user->name }}<br>
                    {{ $data->user->email }}<br>
                    {{ $data->user->phone ?? null }}<br>
                </address>
            </div>
            <div class="col-md-6 text-md-right">
                <address>
                    <strong>{{ __('payment Date:') }}</strong><br>
                    {{ $data->created_at->format('M d Y') }}<br>
                </address>
            </div>
        </div>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Description') }}</th>
                </tr>
                <tr>
                    <td>{{ __('Plan') }}</td>
                    <td>{{ $data->plan->name ?? 'null' }}</td>
                </tr>
                <tr>
                    <td>{{ __('Expire At') }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->will_expire)->isoFormat('LL') ?? 'null' }}</td>
                </tr>
                <tr>
                    <td>{{ __('Gateway Method Name') }}</td>
                    <td>{{ $data->getway->name ?? 'null' }}</td>
                </tr>
                <tr>
                    <td>{{ __('Order Amount') }}</td>
                    <td>{{ amount_admin_format($data->price)}}</td>
                </tr>
                <tr>
                    <td>{{ __('Tax') }}</td>
                    <td>{{ amount_admin_format($data->tax) }}</td>
                </tr>
                <tr>
                    <td>{{ __('Trx Id') }}</td>
                    <td>{{ $data->trx ?? '' }}</td>
                </tr>
                @if(!empty($data->ordermeta))
                @php
                $comments=json_decode($data->ordermeta->value);

                @endphp
                <tr>
                    <td>{{ __('Attachment') }}</td>
                    <td><a href="{{ asset($comments->screenshot) }}" target="_blank">View</a></td>
                    
                </tr>
                <tr>
                    <td>{{ __('Comment') }}</td>
                    <td>{{ $comments->comment }}</td>
                </tr>
                @endif
                <tr>
                    <td>{{ __('Status') }}</td>
                    <td>
                        @if ($data->status == 1)
                        <span>{{ __('Active') }}</span>
                        @elseif($data->status == 2)  
                        <span>{{ __('Pending') }}</span>  
                        @else
                        <span>{{ __('Deactive') }}</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <button class="btn btn-warning btn-icon icon-left printableArea"><i class="fas fa-print"></i>
        {{ __('Print') }}
    </button>
</div>
@endsection

@push('script')
<script src="{{ asset('admin/js/reportshow.js?v=1') }}"></script>
@endpush
