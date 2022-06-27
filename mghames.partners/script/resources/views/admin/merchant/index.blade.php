@extends('layouts.backend.app')

@section('title','Partner List')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Partner List','button_name'=> 'Add New','button_link'=> route('admin.partner.create')])
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
                    <a href="{{ url('/admin/partner') }}" class="mr-2 btn btn-outline-primary  active ">{{ __('All') }}
                        ({{$all}})</a>
                    <a href="{{ url('/admin/partner?1') }}" class="mr-2 btn btn-outline-success ">{{ __('Active') }}
                        ({{$active}})</a>
                    <a href="{{ url('/admin/partner?0') }}" class="mr-2 btn btn-outline-danger ">{{ __('Inactive') }}
                        ({{$inactive}})</a>
                </div>
               
                    <div class="float-right mb-1">
                <form type="get">
                    <div class="input-group form-row ">

                        <input type="text"  class="form-control" placeholder="Search ..." required=""
                        name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                        <select  id="type_src" class="form-control" name="type">
                            <option value="email">{{ __('email') }}</option>
                            <option value="name">{{ __('name') }}</option>
                            <option value="id">{{ __('user Id') }}</option>

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
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Stores') }}</th>
                                <th>{{ __('Orders') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Registered At')}}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $key => $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{$value->name}}</td>
                                <td>{{ $value->amount }}</td>
                                <td>{{$value->email}}</td>
                                <td>{{$value->tenant_count}}</td>
                                <td>{{$value->orders_count}}</td>
                                <td>@if($value->status ==1)
                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td>{{ $value->created_at->diffForHumans() }}</td>
                                <td>
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item has-icon"
                                            href="{{ route('admin.partner.show', $value->id) }}"><i
                                                class="fa fa-edit"></i>{{ __('View') }}</a>

                                        <a class="dropdown-item has-icon"
                                            href="{{ route('admin.partner.edit', $value->id) }}"><i
                                                class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon"
                                            href="{{ route('admin.merchant.login', $value->id) }}"><i
                                                class="fa fa-key"></i>{{ __('login') }}</a>        
                                        @if($value->tenant_count == 0)
                                        <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)"
                                            data-id={{ $value->id }}><i class="fa fa-trash"></i>{{ __('Delete') }}
                                        </a>

                                        <!-- Delete Form -->
                                        <form class="d-none" id="delete_form_{{ $value->id }}"
                                                action="{{ route('admin.partner.destroy', $value->id) }}"
                                                method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6"><p class="text-center">{{ __('No Data Found') }}</p></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $data->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
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

