@extends('layouts.backend.app')

@section('title','Support Tickets')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Support Tickets'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            @if (Session::has('success'))
                <div class="alert alert-danger">{{ Session::get('success') }}</div>
            @endif
            <div class="card-body">
                <div class="tickets">
                    <div class="ticket-items" id="ticket-items">
                        @forelse ($supports as $support)
                            <div class="ticket-item mb-3 position-relative" data-id="{{ $support->id }}">
                                <div class="ticket-title">
                                    <h4>{{ $support->title }}</h4>
                                </div>
                                <div class="ticket-desc">
                                    <div class="user">{{ $support->user->name }}</div>
                                    <div class="bullet"></div>
                                    <div class="date">{{ $support->created_at->diffForHumans() }}</div>
                                </div>
                                <a class="btn btn-danger delete-chat" href="javascript:void(0)"
                                    data-id={{ $support->id }}><i class="fa fa-trash"></i></a>
                                <!-- Delete Form -->
                                <form class="d-none" id="delete_form_{{ $support->id }}"
                                    action="{{ route('admin.support.destroy', $support->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        @empty
                            <h6>{{ __('No support ticket found!') }}</h6>
                        @endforelse
                        {{ $supports->links('vendor.pagination.bootstrap-4') }}
                    </div>
                    <div class="ticket-content position-relative {{ count($supports) == 0 ? 'd-none' : '' }}">
                        <span class="loader">
                            <img src="{{ asset('frontend/assets/img/loader.gif') }}" alt="" width=100>
                        </span>
                        <select name="" id="turnoff" class="ml-3 supportStatusSelect">
                            {{-- Turn off this support! --}}
                            <option>{{ __('Turn off?') }}</option>
                            <option value="0">{{ __('OFF') }}</option>
                            <option value="1">{{ __('Active') }}</option>
                        </select>
                        <div id="msgbox" class="position-relative">
                    </div>
                    <div class="ticket-form">
                        <form method="POST" class="ajaxform" id="ticketform">
                            @csrf
                            @method('put')
                            <input type="hidden" id="supportid" value="">
                            <div class="form-row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('Comment') }}</label>
                                        <textarea name="comment" class="form-control" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-lg float-right w-100 basicbtn">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="{{ route('admin.support.info') }}" id="support_route">
<input type="hidden" value="{{ route('admin.support.status') }}" id="support_status">
<input type="hidden" value="{{  url('admin/support') }}/" id="url_admin_support"> 
@endsection

@push('script')
<script src="{{ asset('admin/assets/js/support.js') }}"></script>
@endpush
