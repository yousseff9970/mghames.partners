@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h4>{{ __('User Info') }}</h4>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Name:') }} <b>{{ $user->name }}</b>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Email:') }} <b>{{ $user->email }}</b>
                            </li>
                               <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Phone:') }} <b>{{ $user->phone }}</b>
                            </li>
                          
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Registration Date:') }} <b>{{ $user->created_at->isoFormat('LL') }}</b>
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
                                <span class="badge badge-info badge-pill">{{ $user->user_orders->count() }}</span>
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
                                <span class="badge badge-danger badge-pill">{{ $cancalled_orders }}</span>
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
                                <tbody>
                                    <tr>
                                        <th>{{ __('Invoice ID') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Order Type') }}</th>
                                        <th>{{ __('Payment Status') }}</th>
                                        <th>{{ __('Order Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                    @foreach ($user->user_orders()->paginate(20) as $key=>$value)
                                    <tr>
                                        <td><a href="{{ route('seller.order.show',$value->id) }}">{{ $value->invoice_no }}</a></td>
                                        <td class="font-weight-600">{{ get_option('currency_data',true)->currency_icon }}{{ $value->total }}</td>
                                        <td>
                                            {{ $value->order_method }}
                                        </td>
                                        <td>
                                            @if ($value->payment_status == 1)
                                            <span class="badge badge-primary">{{ __('Active') }}</span>
                                            @else 
                                            <span class="badge badge-danger">{{ __('Incompleted') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->status_id == 1)
                                                <span class="badge badge-primary">{{ __('Complete') }}</span>
                                            @elseif($value->status_id == 2)
                                                <span class="badge badge-warning">{{ __('Cancelled') }}</span>
                                            @elseif($value->status_id == 3)
                                                <span class="badge badge-danger">{{ __('Pending') }}</span> 
                                            @else 
                                                <span class="badge badge-info">{{ $value->orderstatus->name }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('seller.order.show',$value->id) }}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $user->user_orders()->paginate(20)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection