@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Instruction','prev'=>route('admin.domain.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Edit Domain') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.developer.instruction.update') }}" class="ajaxform">
                    @csrf
                    @method('PUT')                 
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Database Migrate Fresh With demo Import') }}</label>
                        <div class="col-sm-12 col-md-7">
                        <textarea class="form-control" required="" name="db_migrate_fresh_with_demo">{{$info->db_migrate_fresh_with_demo}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Database Migrate Only') }}</label>
                        <div class="col-sm-12 col-md-7">
                        <textarea class="form-control" required="" name="db_migrate">{{$info->db_migrate}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Cache remove') }}</label>
                        <div class="col-sm-12 col-md-7">
                        <textarea class="form-control" required="" name="remove_cache">{{$info->remove_cache}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Remove Storage') }}</label>
                        <div class="col-sm-12 col-md-7">
                        <textarea class="form-control" required="" name="remove_storage">{{$info->remove_storage}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

