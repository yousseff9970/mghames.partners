@extends('layouts.backend.app')

@section('title', 'Support')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Support Tickets','button_name'=> 'Add New','button_link'=>
    route('merchant.support.create')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            @if (Session::has('success'))
                <div class="alert alert-danger">{{ Session::get('success') }}</div>
            @endif
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Ticket No') }}</th>
                            <th scope="col">{{ __('Title') }}</th>
                            <th scope="col">{{ __('Comment') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col">{{ __('Date / Time') }}</th>
                            <th scope="col">{{ __('Details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supports as $key => $support)
                            <tr>
                                <td>{{ $support->ticket_no }}</td>
                                <td>{{ Str::limit($support->title, 15) }}</td>
                                <td>{{ Str::limit($support->meta[0]->comment, 15) ?? '' }}</td>
                                <td>
                                    @if ($support->status == 1)
                                        <span class="badge badge-primary">{{ __('Active') }}</span>
                                    @elseif($support->status == 2)
                                        <span class="badge badge-warning">{{ __('Pending') }}</span>
                                    @else 
                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td>{{ $support->created_at->isoFormat('LL') }}</td>
                                <td>
                                    <a class="btn btn-primary"
                                        href="{{ route('merchant.support.show', $support->id) }}">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-right">
                    {{ $supports->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="support_status_url" value="{{ route('admin.support.status') }}">
<input type="hidden" id="support_info_url" value="{{ route('admin.support.info') }}">
<input type="hidden" id="ticket_form_url" value="{{ url('admin/support') }}">
@endsection

@push('js')
    <script src="{{ asset('backend/admin/assets/js/support.js') }}"></script>
@endpush
