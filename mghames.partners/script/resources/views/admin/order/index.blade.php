@extends('layouts.backend.app')

@section('title','Order Lists')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Order List','button_name'=> 'Add New','button_link'=>
route('admin.order.create')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
                <div class="float-left mb-1">
                    <a href="{{ url('/admin/order') }}" class="mr-2 btn btn-outline-primary {{ $st == "" ? 'active' : '' }}">{{ __('All') }}
                    ({{$all}})</a>
                    <a href="{{ url('/admin/order?1') }}" class="mr-2 btn btn-outline-success {{ $st == "1" ? 'active' : '' }}">{{ __('Accepted') }}
                    ({{$active}})</a>
                    <a href="{{ url('/admin/order?0') }}" class="mr-2 btn btn-outline-danger {{ $st == "0" ? 'active' : '' }}">{{ __('Rejected') }}
                    ({{$inactive}})</a>
                    <a href="{{ url('/admin/order?2') }}" class="mr-2 btn btn-outline-warning {{ $st == "2" ? 'active' : '' }}">{{ __('Pending') }}
                    ({{$pending}})</a>
                    <a href="{{ url('/admin/order?3') }}" class="mr-2 btn btn-outline-secondary {{ $st == "3" ? 'active' : '' }}">{{ __('Expired') }}
                    ({{$expired}})</a>
                </div>
                <div class="float-right mb-1">
                    <form action="{{ route('admin.order.index') }}" type="get">
                        <div class="input-group form-row">
                            <input type="text" class="form-control" placeholder="Search ..." required=""
                            name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                            <select  id="type_src" class="form-control" name="type">
                                <option value="trx">{{ __('Trx Id') }}</option>
                                <option value="customer_email">{{ __('Customer email') }}</option>
                                <option value="tenant_id">{{ __('Store Id') }}</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                            <tr>
                                <th>{{ __('Store Id') }}</th>
                                <th>{{ __('TRX') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Plan') }}</th>
                                <th>{{ __('Gateway') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Tax') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Payment') }}</th>
                                <th>{{ __('Order Created')}}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->orderlog->tenant_id ?? '' }}</td>
                                <td><a href="{{ route('admin.order.show',$order->id) }}"><small>{{ $order->trx }}</small></a></td>
                                <td><a href="{{ route('admin.partner.show',$order->user_id) }}">{{ $order->user->name }}</a></td>
                                <td><a href="{{ route('admin.plan.show',$order->plan_id) }}">{{ $order->plan->name }}</a></td>
                                <td>{{ $order->getway->name }}</td>
                                <td>{{ number_format($order->price,2) }}</td>
                                <td>{{ number_format($order->tax,2) }}</td>
                                <td>
                                    @php
                                    $status = [
                                    0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
                                    1 => ['class' => 'badge-success', 'text' => 'Accepted'],
                                    2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                    3 => ['class' => 'badge-danger', 'text' => 'Expired'],
                                    4 => ['class' => 'badge-secondary', 'text' => 'Trash'],
                                    ][$order->status];
                                    @endphp
                                    <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                                </td>
                                <td>
                                @php
                                $payment_status = [
                                0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
                                1 => ['class' => 'badge-success', 'text' => 'Accepted'],
                                2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                3 => ['class' => 'badge-danger', 'text' => 'Expired'],
                                4 => ['class' => 'badge-secondary', 'text' => 'Trash'],
                                ][$order->payment_status];
                                @endphp
                                <span class="badge {{ $payment_status['class'] }}">{{ $payment_status['text'] }}</span>
                                </td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                    id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item has-icon"
                                            href="{{ route('admin.order.show', $order->id) }}"><i
                                            class="fa fa-eye"></i>{{ __('View') }}</a>
                                        <a class="dropdown-item has-icon"
                                        href="{{ route('admin.order.edit', $order->id) }}"><i
                                        class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)"
                                        data-id={{ $order->id }}><i
                                        class="fa fa-trash"></i>{{ __('Delete') }}</a>
                                        <!-- Delete Form -->
                                        <form class="d-none" id="delete_form_{{ $order->id }}"
                                            action="{{ route('admin.order.destroy', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="type" value="{{ $request->type ?? '' }}">
@endsection

@push('script')
<script src="{{ asset('admin/js/admin.js') }}"></script>
@endpush

