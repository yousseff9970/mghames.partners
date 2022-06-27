@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section class="section">
    <div class="section-header row">
        <div class="col-sm-12">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link  {{ $request_status == null ? 'active' : '' }} " href="{{ route('seller.order.index') }}">All</a>
                </li>
                @foreach($status as $row)
                <li class="nav-item">
                <a class="nav-link  {{ $request_status == $row->id ? 'active' : '' }}" href="{{ url('seller/order?status='.$row->id) }}">{{$row->name}} <span class="badge badge-secondary">{{$row->orderstatus_count}}</span></a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
 <div class="card">
    <div class="card-header">
        <h4>{{ __('Orders') }}</h4>
        <form class="card-header-form">
            <div class="input-group">
                <input type="text" name="src" value="{{ $request->src ?? '' }}" class="form-control" required=""  placeholder="Order Id" />
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <button class="btn btn-sm btn-primary  ml-1" type="button" data-toggle="modal" data-target="#searchmodal">
            <i class="fe fe-sliders mr-1"></i> {{ __('Filter') }} <span class="badge badge-primary ml-1 d-none">0</span>
        </button>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('seller.order.multipledelete') }}" class="ajaxform_with_reload">
            @csrf
            <div class="float-left">
                @if(count($orders) > 0)
                <div class="input-group mb-1">
                    <select class="form-control selectric" name="method">
                        <option disabled selected="">{{ __('Select Fulfillment') }}</option>
                        @foreach($status as $row)
                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                    
                        <option value="delete">{{ __('Delete Permanently') }}</option>
                    
                    </select>
                    <div class="input-group-append">                                            
                        <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                    </div>
                </div>
                @endif
            </div>  
            <div class="float-right">
                @if(count($request->all()) > 0)
                {{ $orders->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
                @else
                {{ $orders->links('vendor.pagination.bootstrap-4') }}
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-nowrap card-table text-center">
                    <thead>
                        <tr>
                            <th class="text-left" ><div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input checkAll" id="selectAll">
                            <label class="custom-control-label checkAll" for="selectAll"></label>
                            </div></th>
                            <th class="text-left" >{{ __('Order') }}</th>
                            <th >{{ __('Date') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th class="text-right">{{ __('total') }}</th>
                            <th>{{ __('Payment') }}</th>
                            <th>{{ __('Fulfillment') }}</th>
                            <th class="text-right">{{ __('Type') }}</th>
                            <th class="text-right">{{ __('Item(s)') }}</th>
                            <th class="text-right">{{ __('Print') }}</th>
                        </tr>
                    </thead>
                    <tbody class="list font-size-base rowlink" data-link="row">
                        @foreach($orders ?? [] as $key => $row)
                        <tr>
                            <td  class="text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $row->id }}" value="{{ $row->id }}">
                                    <label class="custom-control-label" for="customCheck{{ $row->id }}"></label>
                                </div>
                            </td>
                            <td class="text-left">
                                <a href="{{ route('seller.order.show',$row->id) }}">{{ $row->invoice_no }}</a>
                            </td>
                            <td><a href="{{ route('seller.order.show',$row->id) }}">{{ $row->created_at->format('d-F-Y') }}</a></td>
                            <td>@if($row->user_id !== null)<a href="{{ route('seller.user.show',$row->user_id) }}">{{ $row->user->name }}</a> @else {{ __('Guest User') }} @endif</td>
                            <td >{{ number_format($row->total,2) }}</td>
                            <td>
                                @if($row->payment_status==2)
                                <span class="badge badge-warning">{{ __('Pending') }}</span>

                                @elseif($row->payment_status==1)
                                <span class="badge badge-success">{{ __('Complete') }}</span>

                                @elseif($row->payment_status==0)
                                <span class="badge badge-danger">{{ __('Cancel') }}</span> 
                                @elseif($row->payment_status==3)
                                <span class="badge badge-danger">{{ __('Incomplete') }}</span> 

                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $row->orderstatus == null ? 'badge-warning' :'' }} text-white" style="background-color: {{ $row->orderstatus->slug  }}">{{ $row->orderstatus->name ?? '' }}</span>
                            </td>
                            <td>{{ $row->order_method }}</td>

                            <td>{{ $row->orderitems_count }}</td>
                            <td>
                                <a target="_blank" href="{{ route('seller.order.print',$row->id) }}" class="btn btn-primary">Print</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="searchmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="card-header-title">{{ __('Filters') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
            <div class="modal-body">
                <div class="form-group row mb-4">
                    <label class="col-sm-7">{{ __('Payment Status') }}</label>
                    <div class="col-sm-5">
                        <select class="form-control selectric" name="payment_status" id="payment_status">
                            <option value="2">{{ __('Pending') }}</option>
                            <option value="1" >{{ __('Complete') }}</option>
                            <option value="3" >{{ __('Incomplete') }}</option>
                            <option value="0" >{{ __('Cancel') }}</option>
                           
                        </select>
                    </div>
                </div>
                <hr />
                <div class="form-group row mb-4">
                    <label class="col-sm-7">{{ __('Fulfillment status') }}</label>
                    <div class="col-sm-5">
                        <select class="form-control selectric" name="status" id="status" >
                          @foreach($status as $row)
                            <option value="{{ $row->id }}" {{ $request_status == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
                <hr />
                <div class="form-group row mb-4">
                    <label class="col-sm-3">{{ __('Starting date') }}</label>
                    <div class="col-sm-9">
                        <input type="date" name="start" class="form-control" value="{{ $request->start }}" />
                    </div>
                </div>
                <hr />
                <div class="form-group row mb-4">
                    <label class="col-sm-3">{{ __('Ending date') }}</label>
                    <div class="col-sm-9">
                        <input type="date" name="end" class="form-control" value="{{ $request->end }}" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('seller.order.index') }}" class="btn btn-secondary">{{ __('Clear Filter') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>
<input type="hidden" id="payment" value="{{ $request->payment_status ?? '' }}">
<input type="hidden" id="order_status" value="{{ $request->status ?? '' }}">
@endsection

@push('js')
<script src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/order_index.js') }}"></script>
@endpush