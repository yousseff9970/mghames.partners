@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Domain List'])
@endsection

@section('content')
<div class="row">
  <div class="col-12 mt-2">
    <div class="card">
      <div class="card-header">
        <div class="col-sm-10">
          <ul class="nav nav-pills">
              <li class="nav-item">
                  <a class="nav-link {{ $status == "" ? 'active' : '' }}" href="{{ url('/admin/domain') }}">{{ __('All') }} ({{$all}})</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ $status == "1" ? 'active' : '' }}" href="{{url('/admin/domain?status=1') }}">{{ __('Active') }} <span class="badge badge-success">{{$active}}</span></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link  {{ $status == "2" ? 'active' : '' }}" href="{{ url('/admin/domain?status=2') }}">{{ __('Pending') }} <span class="badge badge-warning">{{ $pending }}</span></a>
              </li>
                <li class="nav-item">
                  <a class="nav-link  {{ $status == "0" ? 'active' : '' }}" href="{{ url('/admin/domain?status=0') }}">{{ __('Rejected') }} <span class="badge badge-danger">{{ $inactive }}</span></a>
              </li>
          </ul>
        </div>
        <div class="col-sm-2">
            <a href="{{ route('admin.domain.create') }}" class="btn btn-primary float-right">{{ __('Create Domain') }}</a>
        </div>
      </div>
    </div>


    <div class="card">
      <div class="card-body">
        <div class="float-right mb-2">
            <form  type="get">
                <div class="input-group form-row ">

                    <input type="text"  class="form-control" placeholder="Search ..." required=""
                    name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                    <select  id="type_src" class="form-control" name="type">
                        <option value="domain">{{ __('Domain') }}</option>
                        <option value="tenant_id">{{ __('Store Id') }}</option>

                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <form method="post" action="{{ route('admin.domains.destroys') }}" class="ajaxform_with_reload">
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
          <div class="table-responsive">
            <table class="table table-striped table-hover text-center table-borderless">
              <thead>
                <tr>
                  <th><input type="checkbox" class="checkAll"></th>

                  <th>{{ __('Store Id') }}</th>
                  <th>{{ __('Domain') }}</th>
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Created at') }}</th>
                  <th>{{ __('Action') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($domains as $row)
                
                <tr id="row{{ $row->id }}">
                  <td><input type="checkbox" name="ids[]" value="{{ $row->id }}"></td>
                  <td>{{ $row->tenant_id }}</td>
                  <td>{{ $row->domain }}</td>
                
                  <td>@if($row->status == 1)
                    <span class="badge badge-success">{{ __('Active') }} </span>
                    @elseif($row->status == 2)
                      <span class="badge badge-warning">{{ __('Pending') }}   </span>
                    @elseif($row->status == 3)
                      <span class="badge badge-warning">{{ __('Expired') }}   </span>
                    @else
                      <span class="badge badge-danger">{{ __('Disabled') }}   </span>
                    @endif</td>
                  <td>{{ $row->created_at->diffforHumans()  }}</td>
                  <td>
                    @can('domain.edit')
                    <a href="{{ route('admin.domain.edit',$row->id) }}"><i class="far fa-edit"></i> {{ __('Edit Domain') }}</a>
                    @endcan
                    </td>
                  
                </tr>
                @endforeach
              </tbody>
              
            </table>
            {{ $domains->appends($request->all())->links('vendor.pagination.bootstrap') }}
          </div>
         </form>
       </div>
     </div>
  </div>
</div>
<input type="hidden" id="type" value="{{ $request->type ?? '' }}">
@endsection

@push('script')
<script src="{{ asset('admin/js/admin.js') }}"></script>
@endpush