@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Store List',])
@endsection 

@section('content')
<div class="row">
  <div class="col-12 mt-2">
    <div class="card">
      <div class="card-body">
        <form method="post" action="{{ route('admin.stores.destroys') }}" class="ajaxform_with_reload">
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
            <div class="float-right"></div>
            <div class="table-responsive">
              <table class="table table-striped table-hover text-center table-borderless">
                <thead>
                  <tr>
                    <th></th>
                    <th>{{ __('Store Id') }}</th>
                    <th>{{ __('Plan') }}</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Database Name') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Expire') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('Action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($posts as $row)
                  <tr id="row{{ $row->id }}">
                    <td><input type="radio" name="ids[]" value="{{ $row->id }}"></td>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->orderwithplan->plan->name }}</td>
                    <td><a href="{{ url('/admin/partner/'.$row->user_id) }}">{{ $row->user->name ?? null }}</a></td>
                    <td>{{ $row->tenancy_db_name ?? null }}</td>
                    <td>@if($row->status == 1)
                      <span class="badge badge-success">{{ __('Active') }} </span>
                      @elseif($row->status == 2)
                        <span class="badge badge-warning">{{ __('Pending') }}   </span>
                      @elseif($row->status == 3)
                        <span class="badge badge-warning">{{ __('Expired') }}   </span>
                      @else
                        <span class="badge badge-danger">{{ __('Disabled') }}   </span>
                      @endif</td>
                    <td>{{ $row->will_expire  }}</td>  
                    <td>{{ $row->created_at->diffforHumans()  }}</td>
                    <td>
                      @can('domain.edit')
                      <div class="dropdown d-inline">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ __('Action') }}
                      </button>
                      <div class="dropdown-menu">
                      <a class="dropdown-item has-icon" href="{{ route('admin.store.edit',$row->id) }}"><i class="far fa-edit"></i> {{ __('Edit Store') }}</a>
                      <a class="dropdown-item has-icon" href="{{ route('admin.store.show',$row->id) }}"><i class="far fa-edit"></i> {{ __('Add & Edit Domains') }}</a>
                      <a class="dropdown-item has-icon" href="{{ route('admin.domain.database.edit',$row->id) }}"><i class="far fa-edit"></i> {{ __('Edit Database') }}</a>
                      <a class="dropdown-item has-icon" href="{{ route('admin.domain.plan.edit',$row->id) }}"><i class="far fa-edit"></i> {{ __('Edit Plan') }}</a>
                      </div>
                      </div>
                      @endcan
                      </td>
                  </tr>
                  @endforeach
                </tbody>
             </table>
             {{ $posts->links('vendor.pagination.bootstrap') }}
           </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection