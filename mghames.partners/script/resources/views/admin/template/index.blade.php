@extends('layouts.backend.app')

@section('title','Manage Tamplates')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Manage Store Tamplates'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ __('Store Templates') }}</h4>
                <div class="card-header-action">
                   <button class="btn btn-primary m-3" data-toggle="modal" data-target="#exampleModal">{{ __('Upload Theme') }}</button>
               </div>
           </div>
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
                            <th><i class="fa fa-image"></i></th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('View Path') }}</th>
                            <th>{{ __('Asset Path') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($themes ?? [] as $key=> $value)
                        <tr class="pt-2">
                            <td><img src="{{ asset($value->asset_path.'/screenshot.png') }}" height="50"></td>
                            <td><b>{{ $value->name ?? '' }}</b></td>
                            <td>{{ $value->view_path ?? '' }}</td>
                            <td>{{ $value->asset_path ?? ''}}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Upload New Theme
                ') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.template.store') }}" method="post" class="ajaxform_with_reset">
                    @csrf

                    <div class="modal-body">
                        <label for="file">{{ __('Select File') }}</label>
                        <input type="file" class="form-control" name="file">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary basicbtn">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection