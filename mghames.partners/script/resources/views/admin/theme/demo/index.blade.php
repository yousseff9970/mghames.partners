@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Theme Lists') }}</h1>
        <div class="section-header-button">
            <a href="{{ route('admin.settings.demo.create') }}" class="btn btn-primary">{{ __('Add New') }}</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Theme Lists') }}</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.settings.demo.destroy') }}" class="ajaxform_with_reload">              
                            <div class="float-left mb-3">
                                <div class="input-group">
                                    <select class="form-control" name="method">
                                    <option value="" disabled selected>{{ __('Select Action') }}</option>
                                    <option value="delete">{{ __('Delete Permanently') }}</option>
                                    </select>
                                    <div class="input-group-append">                                            
                                        <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                                    </div>
                                </div>               
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center table-borderless">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="checkAll"></th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Created at') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>  
                                        @foreach ($demos as $demo)
                                        <tr id="row1">
                                            <td><input type="checkbox" name="ids[]" value="{{ $demo->id }}"></td>
                                            <td>{{ $demo->title }}</td>
                                            <td>
                                                @if ($demo->status == 1)
                                                <span class="badge badge-success">{{ __('Active') }}</span>
                                                @else
                                                <span class="badge badge-danger">{{ __('Deactive') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $demo->created_at->diffforhumans() }}</td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('admin.settings.demo.edit',$demo->id) }}"><i class="far fa-edit"></i> {{ __('Edit') }}</a>
                                            </td>
                                        </tr>  
                                        @endforeach  
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection