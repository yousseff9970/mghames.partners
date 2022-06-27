@extends('layouts.backend.app')

@section('title','Users')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Users','button_name'=> 'Create New','button_link'=> url('seller/user/create')])
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="Search">{{ __('Search') }}</label>
                         <form method="get">
                            <div class="row">
                                <input name="src" type="email" value="{{ $request->src ?? '' }}" class="form-control col-lg-4 ml-2" placeholder="example@email.com">
                            </div>
                         </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $row)
                                <tr>
                                  <td>{{ $row->name }}</td>
                                  <td>{{ $row->email }}</td>
                                  <td><span class="badge badge-{{ $row->status == 1 ? 'success' : 'warning' }}">{{ $row->status == 1 ? 'Active' : 'Disable' }}</span></td>
                                  <td class="">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start">
                                        <a class="dropdown-item has-icon text-warning" href="{{ route('seller.user.show', $row->id) }}"><i class="fa fa-eye"></i>{{ __('View') }}</a>
                                        <a class="dropdown-item has-icon text-warning" href="{{ route('seller.user.edit', $row->id) }}"><i class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon text-warning" href="{{ route('seller.user.login', $row->id) }}"><i class="fa fa-key"></i>{{ __('login') }}</a>
                                        <a class="dropdown-item has-icon delete-confirm text-danger" href="javascript:void(0)" data-id="{{$row->id}}"><i class="fa fa-trash"></i>{{ __('Delete') }}</a>
                                        <!-- Delete Form -->
                                         <form class="d-none" id="delete_form_{{ $row->id }}" action="{{ route('seller.user.destroy', $row->id) }}" method="POST">
                                       @csrf
                                       @method('delete')
                                    </form>
                                    </div>
                                </td>
                            </tr>      
                            @endforeach
                        </tbody>
                    </table>
                     {{ $users->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

