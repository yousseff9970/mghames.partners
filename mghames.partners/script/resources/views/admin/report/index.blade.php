@extends('layouts.backend.app')

@section('title', 'Reports')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-clipboard"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Orders') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_orders }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Earnings') }}</h4>
                        </div>
                        <div class="card-body">
                            $ {{ $total_earning }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Pendings') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_pending }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Expired Orders') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_expired }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-5">
                        <form action="{{ url('/admin/report') }}" type="get">
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
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('Search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3 mt-2">
                        <form action="{{ url('/admin/report') }}" type="get">
                            <div class="input-group form-row mt-3">
                                <select class="form-control" name="select_day">
                                    <option value="today">{{ __('Today') }}</option>
                                    <option value="thisWeek">{{ __('This Week') }}</option>
                                    <option value="thisMonth">{{ __('This Month') }}</option>
                                    <option value="thisYear">{{ __('This Year') }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-4 mt-2">
                        <form action="{{ url('/admin/report') }}" type="get">
                            <div class="input-group form-row mt-3">

                                <input type="text" class="form-control" placeholder="Search ..." required=""
                                    name="value" autocomplete="off" value="">
                                <select class="form-control" name="type">
                                    <option value="customer_name">{{ __('Customer name') }}</option>
                                    <option value="customer_email">{{ __('Customer email') }}</option>
                                    <option value="plan_name">{{ __('plan name') }}</option>
                                    <option value="getway_name">{{ __('gateway name') }}</option>
                                    <option value="exp_date">{{ __('exp date') }}</option>
                                    <option value="trx">{{ __('Trx') }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <div class="buttons">
                            <a href="{{ route('admin.order.pdf') }}" class="btn  btn-primary">{{ __('PDF') }}</a>
                            <a href="{{ route('admin.order.csv') }}" class="btn  btn-primary">{{ __('CSV') }}</a>
                            <a href="{{ route('admin.order.excel') }}"
                                class="btn  btn-primary">{{ __('EXCEL') }}</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                            <tr>
                                <th>{{ __('Sl') }}</th>
                                <th>{{ __('Trx') }}</th>
                                <th>{{ __('Plan Name') }}</th>
                                <th>{{ __('Tenant') }}</th>
                                <th>{{ __('Getway name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Payment Status') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $key =>$value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('admin.report.pdf', $value->id) }}">{{ $value->trx ?? '' }}</a></td>
                                    <td>{{ $value->plan->name ?? '' }}</td>
                                    <td>{{ $value->tenant->id ?? '' }}</td>
                                    <td>{{ $value->getway->name ?? '' }}</td>
                                    <td>{{ $value->user->email ?? '' }}</td>
                                    <td>
                                        @if ($value->status == 1)
                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($value->status == 2)
                                            <span class="badge badge-danger">{{ __('Pending') }}</span>
                                        @elseif($value->status == 3)
                                            <span class="badge badge-danger">{{ __('Expired') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($value->status == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($value->status == 2)
                                            <span class="badge badge-danger">{{ __('Pending') }}</span>
                                        @elseif($value->status == 3)
                                            <span class="badge badge-danger">{{ __('Expired') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            {{ __('Action') }}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item has-icon"
                                                href="{{ route('admin.report.show', $value->id) }}"><i
                                                    class="far fa-eye"></i>{{ __('View') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    {{ $data->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
