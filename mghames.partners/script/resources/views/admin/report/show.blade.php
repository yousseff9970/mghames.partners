@extends('layouts.backend.app')

@section('title','Order View')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Order View'])
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
                                <td>{{ __('Payment Status') }}</td>
                                <td>@if($data->payment_status ==1)
                                        <span class="badge badge-success">{{ __('Done') }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ __('Pending') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Order Created Date') }}</td>
                                <td><b>{{$data->created_at->format('d.m.Y')}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Order Created At') }}</td>
                                <td><b>{{$data->created_at->diffForHumans()}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Order Will Be Expired') }}</td>
                                <td><b>{{$data->will_expire}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Order Price') }}</td>
                                <td><b>{{$data->price}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Plan Name') }}</td>
                                <td><b>{{$data->plan->name}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Tenant Name') }}</td>
                                <td><b>{{$data->tenant->id ?? ''}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Payment Mode') }}</td>
                                <td><b>{{$data->getway->name}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Trx Id') }}</td>
                                <td><b>{{$data->trx}}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('Status') }}</td>
                                <td>@if($data->status ==1)
                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ __('Deactive') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Download Invoice') }}</td>
                                <td><b> <a href="{{ url('admin/report-invoice',$data->id)}}" class="btn btn-icon btn-dark">pdf</a></b></td>
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
                <h4>{{ __('User Information') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>{{ __('User Name') }}</td>
                                <td><b><a href="#">{{$data->user->name}}</a></b></td>
                            </tr>
                            <tr>
                                <td>{{ __('User Email') }}</td>
                                <td><a href="mailto:{{$data->user->email}}"><b>{{$data->user->email}}</b></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

