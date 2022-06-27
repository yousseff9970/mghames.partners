@extends('layouts.backend.app')

@section('title','Order Information')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Order View','prev'=> route('admin.order.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Order Information') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td>{{ __('Order Created Date')}}</td>
                            <td><b>{{$order->created_at->isoFormat('LL')}}</b></td>
                        </tr>
                        <tr>
                            <td>{{ __('Order Created At')}}</td>
                            <td><b>{{$order->created_at->diffForHumans()}}</b></td>
                        </tr>
                        <tr>
                            <td>{{ __('Plan') }}</td>
                        <td><a href="{{ route('admin.plan.edit',$order->plan->id) }}">{{ $order->plan->name }}</a></td>
                        </tr>
                        <tr>
                            <td>{{ __('Getway') }}</td>
                        <td>{{ $order->getway->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Amount') }}</td>
                        <td>{{ $order->price }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Tax') }}</td>
                        <td>{{ number_format($order->tax,2) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Transaction ID') }}</td>
                            <td>{{ $order->trx }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Payment Status') }}</td>
                            @php
                                $payment_status = [
                                0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
                                1 => ['class' => 'badge-success', 'text' => 'Accepted'],
                                2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                3 => ['class' => 'badge-danger', 'text' => 'Expired'],
                                4 => ['class' => 'badge-secondary', 'text' => 'Trash'],
                            ][$order->payment_status];
                            @endphp
                            <td>
                                <span class="badge {{ $payment_status['class'] }}">{{ $payment_status['text'] }}</span>
                            </td>
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
                        @if(!empty($order->ordermeta))
                        @php
                        $comments=json_decode($order->ordermeta->value);
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
                            <td>{{ __('Created At') }}</td>
                            <td>{{ $order->created_at->isoFormat('LL') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Expire At') }}</td>
                            <td class="text-danger"><strong>{{ \Carbon\Carbon::parse($order->exp_date)->isoFormat('LL') }}</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('User Information')}} </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>{{ __('User Name')}}</td>
                                <td><a href="{{ route('admin.partner.show', $order->user_id) }}">{{ $order->user->name }}</a></td>
                            </tr>
                            <tr>
                                <td>{{ __("Email") }}</td>
                                <td>{{ $order->user->email }}</td>
                            </tr>

                            <tr>
                                <td>{{ __("Tenant") }}</td>
                                <td>{{ $order->tenant->id ?? $order->orderlog->tenant_id ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

