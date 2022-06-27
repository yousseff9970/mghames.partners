@extends('layouts.backend.app')

@section('title','Fund History')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Fund History'])
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>{{ __('History') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <form action="{{ route('merchant.fund.history') }}" type="get">
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
                <form action="{{ route('merchant.fund.history') }}" type="get">
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
                        <th>{{ __('Getway') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Payment Status') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($funds ?? [] as $fund)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $fund->trx }}</td>
                            <td>{{ $fund->getway->name }}</td>
                            <td>{{ $fund->amount }}</td>
                            <td>
                                @php
                                 $payment_status = [
                                    0 => ['class' => 'badge-danger', 'text' => 'Failed'],
                                    1 => ['class' => 'badge-primary', 'text' => 'Active'],
                                    2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                                    3 => ['class' => 'badge-danger', 'text' => 'Expired'],
                                ][$fund->payment_status];
                                @endphp
                                <span class="badge {{ $payment_status['class'] }}">{{ $payment_status['text'] }}</span>
                            </td>
                            <td>{{ $fund->created_at->isoFormat('LL') }}</td>
                            <td>
                                <div class="fund-button">
                                    <a class="btn btn-primary"
                                    href="{{ route('merchant.fund.show', $fund->id) }}"><i class="fa fa-eye"></i> {{ __('View') }}</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $funds->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
@endsection