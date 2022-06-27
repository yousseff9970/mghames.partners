@extends('layouts.backend.app')

@section('title','Plan View')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Order View'])
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
                            <td>{{ __('Invoice No') }}</td>
                            <td>{{ $order->invoice_no ?? ''  }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Plan') }}</td>
                            <td>{{ $order->plan->name ?? ''  }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Geteway') }}</td>
                            <td>{{ $order->getway->name  ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Store') }}</td>
                            <td>{{ $order->orderlog->tenant_id  ?? '' }}</td>
                        </tr>
                        
                        @if ($order->ordermeta)

                        @php $info =  json_decode($order->ordermeta->value) @endphp
                        <tr>
                            <td width=30%>{{ __('Geteway') }}</td>
                            <td><img class="w-100 border m-2" src="{{ asset($info->screenshot) }}" alt=""></td>
                        </tr>
                        <tr>
                            <td>{{ __('Comment') }}</td>
                            <td><img src="{{ asset($info->comment) }}" alt=""></td>
                        </tr>
                        @endif
                        <tr>
                            <td>{{ __('Amount') }}</td>
                            <td>{{ $order->price }}</td>
                        </tr>
                        
                        <tr>
                            <td>{{ __('Transaction ID') }}</td>
                        <td>{{ $order->trx }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Tax') }}</strong></td>
                            <td>{{ number_format($order->tax,2) }} </td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Total (Including Tax)') }}</strong></td>
                            <td>{{ number_format($order->price+$order->tax,2) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Status') }}</td>
                            @php
                            $status = [
                            0 => ['class' => 'badge-danger',  'text' => 'Rejected'],
                            1 => ['class' => 'badge-primary', 'text' => 'Accepted'],
                            2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                            3 => ['class' => 'badge-danger', 'text' => 'Expired']
                            ][$order->status]
                            @endphp
                            <td>
                                <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Payment Status') }}</td>
                            @php
                                $pstatus = [
                                    0 => ['class' => 'badge-danger',  'text' => 'Rejected'],
                                    1 => ['class' => 'badge-primary', 'text' => 'Accepted'],
                                    2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                    3 => ['class' => 'badge-danger', 'text' => 'Expired']
                                ][$order->payment_status];
                            @endphp
                            <td>
                                <span class="badge {{ $pstatus['class'] }}">{{ $pstatus['text'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Created At') }}</td>
                            <td>{{ $order->created_at->isoFormat('LL') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Expire Date') }}</td>
                            <td class="text-danger"><strong>{{ \Carbon\Carbon::parse($order->will_expire)->isoFormat('LL') }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

