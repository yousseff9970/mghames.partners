@extends('layouts.backend.app')

@section('title','Shippings')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Shipping Methods','button_name'=> 'Create New','button_link'=> url('seller/shipping/create')])
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
                                <input name="src" type="text" value="{{ $request->src ?? '' }}" class="form-control col-lg-4 ml-2" placeholder="search...">
                            </div>
                         </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center table-borderless">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-image"></i></th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Locations') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $row)
                                <tr>
                                   <td><img src="{{ asset($row->preview->content ?? '') }}" height="50" alt=""></td>
                                  <td>{{ $row->name }}</td>
                                  <td>{{ $row->slug }}</td>
                                  <td><span class="badge badge-{{ $row->status == 1 ? 'success' : 'danger' }}">{{ $row->status == 1 ? 'Active' : 'Disable' }}</span></td>
                                  <td>
                                    @foreach($row->locations ?? [] as $r)
                                    <div class="badge badge-success ">{{ $r->name }}</div>
                                   @endforeach
                                  </td>
                                  <td class="">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start">
                                        <a class="dropdown-item has-icon text-warning" href="{{ route('seller.shipping.edit', $row->id) }}"><i class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon delete-confirm text-danger" href="javascript:void(0)" data-id="{{$row->id}}"><i class="fa fa-trash"></i>{{ __('Delete') }}</a>
                                        <!-- Delete Form -->
                                         <form class="d-none" id="delete_form_{{ $row->id }}" action="{{ route('seller.category.destroy', $row->id) }}" method="POST">
                                       @csrf
                                       @method('delete')
                                    </form>
                                    </div>
                                </td>
                            </tr>      
                            @endforeach
                        </tbody>
                    </table>
                     {{ $posts->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

