@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Merchant View'])
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6">
       <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-center">
                                    @if ($data->image != '')
                                    <img src="{{ asset($data->image) }}" alt="" class="image-thumbnail mt-2">
                                    @else
                                    <img alt="image" src='https://ui-avatars.com/api/?name={{$data->name}}'
                                    class="rounded-circle profile-widget-picture ">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Name')}}</td>
                                <td>{{$data->name}}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Email')}}</td>
                                <td>{{$data->email}}</td>
                            </tr>
                            
                            <tr>
                                <tr>
                                    <td>{{ __('status')}}</td>
                                    <td>@if($data->status ==1)
                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                        @else
                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </tr>
                            <tr>
                                <td>{{ __('Credit') }}</td>
                                <td>{{ number_format($data->amount,2) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Send Mail') }}</td>
                                <td><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">{{ __('Send Mail') }}</button></td>
                            </tr>                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{{ __('Total Orders')}}</td>
                                <td>{{ $data->orders_count }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Total Active Orders')}}</td>
                                <td>{{ $data->active_orders_count }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Total Stores')}}</td>
                                <td>{{ $data->tenant_count }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Total Spends')}}</td>
                                <td>{{ number_format($data->orders_sum_price,2) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Total Support Tickets')}}</td>
                                <td>{{ $data->supports_count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="{{ url('admin/merchant-send-mail',$data->id) }}" class="ajaxform" id="mailform">
    @csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Send Mail') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Subject') }}<sup>*</sup></label>
                                    <input type="text" class="form-control" name="subject">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Message') }} <sup>*</sup></label>
                                    <textarea name="message" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary basicbtn" >{{ __('Send') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Plan Purchase History') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center table-borderless">
                        <thead>
                            <tr>
                                <th>{{ __('Store Id') }}</th>
                                
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
                                <td>{{ $order->plan->name }}</td>
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
                    {{ $orders->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>  
</div>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Stores') }}</h4>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.stores.destroys') }}" class="ajaxform_with_reload">
                  @csrf
                  <div class="float-left mb-1">
                    @can('domain.delete')
                    <div class="input-group">
                      <select class="form-control" name="method">
                        <option value="" >{{ __('Select Action') }}</option>
                        <option value="delete" >{{ __('Delete Permanently') }}</option>
                    </select>
                    <div class="input-group-append">                                            
                        <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                    </div>
                </div>
                @endcan
            </div>
            <div class="float-right">
                @can('domain.create')
                <a href="{{ route('admin.store.create') }}" class="btn btn-primary">{{ __('Create Store') }}</a>
                @endcan
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center table-borderless">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkAll"></th>
                            <th>{{ __('Store Id') }}</th>
                            <th>{{ __('Plan') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Database Name') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Created at') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenants as $row)
                        <tr id="row{{ $row->id }}">
                            <td><input type="checkbox" name="ids[]" value="{{ $row->id }}"></td>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->orderwithplan->plan->name }}</td>
                            <td><a href="{{ url('/admin/partner/'.$row->user_id) }}">{{ $row->user->name ?? null }}</a></td>
                            <td>{{ $row->tenancy_db_name ?? null }}</td>
                            <td>@if($row->status == 1)
                                <span class="badge badge-success">{{ __('Active') }} </span>
                                @elseif($row->status == 2)
                                <span class="badge badge-warning">{{ __('Pending') }}   </span>
                                @elseif($row->status == 3)
                                <span class="badge badge-warning">{{ __('Expired') }}   </span>
                                @else
                                <span class="badge badge-danger">{{ __('Disabled') }}   </span>
                                @endif
                            </td>
                            <td>{{ $row->created_at->diffforHumans()  }}</td>
                            <td>
                                @can('domain.edit')
                                <div class="dropdown d-inline">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item has-icon" href="{{ route('admin.store.edit',$row->id) }}"><i class="far fa-edit"></i> {{ __('Edit Store') }}</a>
                                        <a class="dropdown-item has-icon" href="{{ route('admin.store.show',$row->id) }}"><i class="far fa-edit"></i> {{ __('Add & Edit Domains') }}</a>
                                        <a class="dropdown-item has-icon" href="{{ route('admin.domain.database.edit',$row->id) }}"><i class="far fa-edit"></i> {{ __('Edit Database') }}</a>
                                        <a class="dropdown-item has-icon" href="{{ route('admin.domain.plan.edit',$row->id) }}"><i class="far fa-edit"></i> {{ __('Edit Plan') }}</a>
                                    </div>
                                </div>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </form>
        </div>
    </div>
</div>  
</div>
@endsection

@push('js')
<script src="{{ asset('admin/js/admin.js') }}"></script>
@endpush
