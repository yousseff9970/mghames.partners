@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Manage Orders') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('login') }}">{{ __('Dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('rider.order.index') }}">{{ __('Orders') }}</a></div>
            <div class="breadcrumb-item">{{ __('All Orders') }}</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-0">
                    <div class="card-body">
                      <ul class="nav nav-pills">
                        <li class="nav-item">
                           
                          <a class="nav-link  {{ url('/rider/order') == url()->full() ? 'active' : '' }}" href="{{ url('/rider/order') }}">All <span class="badge badge-{{ isset($request_status) ? 'primary' : 'white' }}">{{ $orders_counts }}</span></a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ url('/rider/order/?status=1') == url()->full() ? 'active' : '' }}" href="{{ url('/rider/order/?status=1') }}">{{ __('Completed') }} <span class="badge badge-success">{{ $complete_orders ?? 0 }}</span></a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ url('/rider/order/?status=3') == url()->full() ? 'active' : '' }}" href="{{ url('/rider/order/?status=3') }}">{{ __('Pending') }} <span class="badge badge-warning">{{ $pending_orders ?? 0 }}</span></a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ url('/rider/order/?status=2') == url()->full() ? 'active' : '' }}" href="{{ url('/rider/order/?status=2') }}">{{ __('Cancelled') }} <span class="badge badge-danger">{{ $cancelled_orders ?? 0 }}</span></a>
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
                        <h4>{{ __('Manage Orders') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="float-left">
                            <form method="get" action="/rider/order">
                                @csrf
                                <div class="row">
                                    <div class="form-group ml-3">
                                        <label>{{ __('Starting Date') }}</label>
                                        <input type="date" name="start_date" class="form-control" required="" value="{{ $request->start_date ?? '' }}">
                                    </div>
                                    <div class="form-group ml-2">
                                        <label>{{ __('Ending Date') }}</label>
                                        <input type="date" name="end_date" class="form-control" required="" value="{{ $request->end_date ?? '' }}">
                                    </div>
                                    <div class="form-group mt-4">
                                        <button class="btn btn-primary btn-lg  ml-2 mt-1" type="submit">{{ __('Filter') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="float-right">
                            <form action="/rider/order" method="GET">
                                @csrf
                                <div class="input-group mt-3 col-12">
                                    <input type="text" class="form-control" placeholder="{{ __('Search By Order ID') }}" required="" name="search" value="{{ $request->search ?? '' }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover text-center table-borderless">
                                <thead>
                                    <tr>
                                        <th>{{ __('Order ID') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Time') }}</th>
                                        <th>{{ __('View') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td><a href="{{ route('rider.order.show',$order->order->id) }}">{{ $order->order->invoice_no }}</a></td>
                                        <td>{{ number_format($order->order->total,2) }}</td>
                                        <td>
                                           @php
                                           if($order->status_id == 1){
                                            $status= 'Complate';
                                            $color= 'success';
                                           }
                                           elseif($order->status_id == 3){
                                            $status='Pending';
                                            $color='warning';
                                           }
                                           else{
                                            $status='Cancelled';
                                            $color='danger';
                                           }

                                           @endphp

                                           <span class="badge badge-{{ $color }}">{{ $status }}</span>
                                        </td>
                                        <td>{{ $order->order->created_at->diffForhumans() }}</td>
                                        <td>
                                            <a href="{{ route('rider.order.show',$order->order->id) }}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{ __('Order ID') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Time') }}</th>
                                        <th>{{ __('View') }}</th>
                                    </tr>
                                </tfoot>
                            </table>

                            {{ $orders->links('vendor.pagination.bootstrap') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection