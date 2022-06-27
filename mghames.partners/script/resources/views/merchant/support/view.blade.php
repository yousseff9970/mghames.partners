@extends('layouts.backend.app')

@section('title', 'Support Details')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Support Details'])
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th class="text-right">{{ __('Details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('Ticket No') }}</td>
                            <td class="text-right">{{ $support->ticket_no }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Status') }}</td>
                            <td class="text-right">
                                <h4
                                    class="text-white badge bg-{{ $support->status == 1 ? 'primary' : ($support->status == 2 ? 'warning' : 'danger') }}">
                                    {{ $support->status == 1 ? 'Active' : ($support->status == 2 ? 'Pending' : 'Inactive') }}
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Title') }}</td>
                            <td class="text-right">
                                <strong>
                                    {{ $support->title }}
                                </strong>
                            </td>
                        </tr>
                        @foreach ($support->meta as $item)
                            <tr>
                                <td colspan='2' class="{{ $item->type == 1 ? 'text-right' : 'text-left' }}">
                                    @if ($item->type == 1)
                                        <div class="mb-2">
                                            <strong class="support-user-name">{{ $support->user->name }} </strong>
                                            <img class="rounded-circle user-img"
                                                src="{{ url('https://ui-avatars.com/api/?background=random&name=' . $support->user->name) }}"
                                                alt="">
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <img class="rounded-circle user-img"
                                                src="{{ url('https://ui-avatars.com/api/?background=random&name=Admin') }}">
                                            <strong class="support-user-name">{{ __('Admin') }} </strong>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="card p-2 shadow-sm">
                                            <h5>{{ $item->comment }}</h5>
                                            <span
                                                class="text-primary support-time">{{ $item->created_at->diffforhumans() }}</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($support->status != 0)
                            <tr>
                                <td colspan="2">
                                    <form action="{{ route('merchant.support.update', $support->id) }}" method="post"
                                        enctype="multipart/form-data" class="ajaxform_with_reload">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('Comment') }}</label>
                                                    <textarea name="comment" id="" cols="30" rows="5"
                                                        class="@error('description') is-invalid @enderror form-control"></textarea>
                                                </div>
                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-center mt-3">
                                                <div class="button-btn">
                                                    <button type="submit"
                                                        class="btn btn-primary basicbtn w-100">{{ __('Submit') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
