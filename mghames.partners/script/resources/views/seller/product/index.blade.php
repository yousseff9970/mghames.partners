@extends('layouts.backend.app')

@section('title','Products')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Products','button_name'=> 'Create New','button_link'=> url('seller/product/create')])
@endsection

@section('content')
@if(Session::has('error'))
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ Session::get('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
@endif
<div class="card card-primary">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-lg-12">
                <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#import">{{ __('Bulk Import') }}</a>
            </div>
        </div>
        <br>
        <div class="float-right">
            <form>
                <div class="input-group mb-2">

                    <input type="text" id="src" class="form-control" placeholder="Search..." required="" name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                    <select class="form-control selectric" name="type" id="type">
                       
                        <option value="full_id" @if($type == 'full_id') selected @endif>{{ __('Search By Id') }}</option>
                        <option value="title" @if($type == 'title') selected @endif>{{ __('Search By Name') }}</option>
                    </select>
                    <div class="input-group-append">                                            
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <form method="post" action="{{ route('seller.products.destroys') }}" class="ajaxform_with_reload">
            @csrf
            <div class="float-left">
                <div class="input-group">
                    <select class="form-control selectric" name="method">
                        <option disabled selected="">{{ __('Select Action') }}</option>
                        <option value="1">{{ __('Publish Now') }}</option>
                        <option value="0">{{ __('Draft') }}</option>
                        
                       
                        <option value="delete" class="text-danger">{{ __('Delete Permanently') }}</option>
                       
                    </select>
                    <div class="input-group-append">                                            
                        <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                    </div>
                </div>
                
            </div>
            <div class="table-responsive custom-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="am-select">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input checkAll" id="selectAll">
                                    <label class="custom-control-label checkAll" for="selectAll"></label>
                                </div>
                            </th>
                            
                            <th>{{ __('Name') }}</th>
                            <th class="text-right"><i class="far fa-image"></i></th>
                            <th class="text-right">{{ __('Type') }}</th>
                            <th class="text-right">{{ __('Price') }}</th>
                            <th class="text-right">{{ __('Status') }}</th>
                            <th class="text-right">{{ __('Sales') }}</th>
                            <th class="text-right">{{ __('Created At') }}</th>
                            <th class="text-right">{{ __('Edit') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $row)
                        <tr id="row{{  $row->id }}">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $row->id }}" value="{{ $row->id }}">
                                    <label class="custom-control-label" for="customCheck{{ $row->id }}"></label>
                                </div>
                            </td>
                             
                                  <td>{{ Str::limit($row->title,20) }} ({{$row->full_id}})</td>
                                  <td class="text-right"><img src="{{ asset($row->media->value ?? 'uploads/default.png') }}" height="50" alt=""></td>
                                  <td class="text-right">{{ $row->is_variation == 1 ? 'Variations' : 'Simple'  }}</td>
                                  <td class="text-right">{{$row->price->price ?? '' }}{{ $row->is_variation == 1 ? '*' : ''  }}</td>
                                  <td class="text-right"><span class="badge badge-{{ $row->status == 1 ? 'success' : 'danger' }}">{{ $row->status == 1 ? 'Active' : 'Disable' }}</span></td>
                                  <td>{{ $row->orders_count }}</td>
                                  <td class="text-right">{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                                  <td class="text-right">
                                    <a class="text-primary" href="{{ route('seller.product.edit', $row->id) }}"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>  
                        @endforeach
                    </tbody>
                </table>
            </form>
            {{ $posts->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="import" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Product Import') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('seller.product.import') }}" method="POST" class="ajaxform_with_reload" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-control">
                            <input type="file" name="file" accept=".csv">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="import_area">
                        <div>
                            <p class="text-left"><a href="{{ asset('uploads/demo.csv') }}">{{ __('Download Sample') }}</a>
                            </p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Import') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</section>
@endsection


