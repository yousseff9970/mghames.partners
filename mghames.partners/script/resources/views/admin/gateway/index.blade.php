@extends('layouts.backend.app')

@section('title','Gateway List')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Gateway List','button_name'=> 'Add New','button_link'=> route('admin.gateway.create')])
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
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                        <tr>
                            <th>{{ __('SL.') }}</th>
                            <th>{{ __('Logo') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Currency') }}</th>
                            <th>{{ __('Namespace') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($gateways ?? [] as $gateway)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img class="image-thumbnail" src="{{ asset($gateway->logo) }}" alt="{{ $gateway->name }}"></td>
                                <td>{{ $gateway->name }}</td>
                                <td>{{ $gateway->currency_name }}</td>
                                <td>{{ $gateway->namespace }}</td>
                                <td>
                                    <a class="btn btn-primary"
                                        href="{{ route('admin.gateway.edit', $gateway->id) }}"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
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
@endsection


