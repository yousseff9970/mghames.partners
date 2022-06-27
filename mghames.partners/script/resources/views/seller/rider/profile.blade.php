@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h4>{{ __('Rider Info') }}</h4>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Name:') }} <b>{{ $rider->name }}</b>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Email:') }} <b>{{ $rider->email }}</b>
                            </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Phone:') }} <b>{{ $rider->phone }}</b>
                            </li>
                           
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Registration Date:') }} <b>{{ $rider->created_at->isoFormat('LL') }}</b>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Total Orders') }}
                                <span class="badge badge-info badge-pill">{{ $rider->rider_orders->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Total Processing Orders') }}
                                <span class="badge badge-warning badge-pill">{{ $pending_orders }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Total Complete Orders') }}
                                <span class="badge badge-success badge-pill">{{ $completed_orders }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Total Cancalled Orders') }} 
                                <span class="badge badge-primary badge-pill">{{ $cancalled_orders }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Order History') }}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <tbody><tr>
                                    <th>{{ __('Invoice ID') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    
                                   
                                    <th>{{ __('Order Status') }}</th>
                                    <th>{{ __('Order Date') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                              
                                    @foreach($orders as $key=>$value)
                                    <tr>
                                        <td><a href="">{{ $value->order->invoice_no }}</a></td>
                                        <td class="font-weight-600">{{ $value->order->total }}</td>
                                        <td>
                                            <span class="badge text-white" style="background-color: {{ $value->order->orderstatus->slug ?? '' }}">{{ $value->order->orderstatus->name ?? '' }}</span>
                                        </td>
                                       
                                        <td>{{ $value->order->created_at->toDateString() }}</td>
                                        <td>
                                            <a href="{{ route('seller.order.show',$value->order_id) }}" class="btn btn-primary">{{ __('Detail') }}</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection