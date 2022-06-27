@extends('layouts.backend.app')

@section('title','Fund View')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Fund View'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (Session::has('message'))
                    <div class="alert alert-danger">
                    {{ Session::get('message') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped" id="table-2">
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Details') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('Geteway') }}</td>
                            <td>{{ $fund->getway->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Amount') }}</td>
                            <td>{{ $fund->amount }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Currency') }}</td>
                            <td>{{ $fund->getway->currency_name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Transaction ID') }}</td>
                        <td>{{ $fund->trx }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Status') }}</td>
                            @php
                            $status = [
                            0 => ['class' => 'badge-danger',  'text' => 'Filed'],
                            1 => ['class' => 'badge-primary', 'text' => 'Active'],
                            2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                            3 => ['class' => 'badge-danger', 'text' => 'Expired']
                            ][$fund->status]
                            @endphp
                            <td>
                                <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Payment Status') }}</td>
                            @php
                                $pstatus = [
                                    0 => ['class' => 'badge-danger',  'text' => 'Failed'],
                                    1 => ['class' => 'badge-primary', 'text' => 'Active'],
                                    2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                    3 => ['class' => 'badge-danger', 'text' => 'Expired']
                                ][$fund->payment_status];
                            @endphp
                            <td>
                                <span class="badge {{ $pstatus['class'] }}">{{ $pstatus['text'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Created At') }}</td>
                            <td>{{ $fund->created_at->isoFormat('LL') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

