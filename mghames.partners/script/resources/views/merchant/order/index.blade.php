@extends('layouts.backend.app')

@section('title','Manage Orders')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Manage Orders'])
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>{{ __('Orders') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <form action="{{ route('merchant.order.index') }}" type="get">
                    <div class="form-row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>{{ __('Start Date') }}</label>
                                <input type="date" class="form-control" name="start_date" required="">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>{{ __('End Date') }}</label>
                                <input type="date" class="form-control" name="end_date" required="">
                            </div>
                        </div>
                        <div class="col-lg-2 mt-2">
                            <button type="submit" class="btn btn-primary mt-3 btn-lg">{{ __('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6 mt-2">
                <form action="{{ route('merchant.order.index') }}" type="get">
                    <div class="input-group form-row mt-3">
                        <input type="text" class="form-control" placeholder="Search Trx Id ..." required="" name="value" autocomplete="off" value="">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mt-2">
                <thead>
                    <tr>
                        <th>{{ __('Sl.') }}</th>
                        <th>{{ __('Trx Id') }}</th>
                        <th>{{ __('Plan') }}</th>
                        <th>{{ __('Getway') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Order Status') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders ?? [] as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->trx }}</td>
                            <td>{{ $order->plan->name }}</td>
                            <td>{{ $order->getway->name }}</td>
                            <td>{{ $order->price }}</td>
                            <td>
                                 @php
                                 $status = [
                                    0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
                                    1 => ['class' => 'badge-primary', 'text' => 'Accepted'],
                                    2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                    3 => ['class' => 'badge-danger', 'text' => 'Expired'],
                                    4 => ['class' => 'badge-secondary', 'text' => 'Trash'],
                                ][$order->status];
                                @endphp
                                <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                            </td>
                            <td>{{ $order->created_at->isoFormat('LL') }}</td>
                            <td>
                                <div class="order-button">
                                    <a class="btn btn-primary"
                                    href="{{ route('merchant.plan.show', $order->id) }}"><i class="fa fa-eye"></i> {{ __('View') }}</a>
                                    <a href="{{ url('partner/plan-invoice',$order->id)}}" class="btn btn-icon btn-info ml-2">{{ __('PDF') }}</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
@endsection