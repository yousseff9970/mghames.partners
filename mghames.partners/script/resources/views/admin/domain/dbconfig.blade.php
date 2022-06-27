@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Database','prev'=>route('admin.domain.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Edit Database for ').$info->id }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.database.update',$info->id) }}" class="ajaxform">
                    @csrf
                    @method('PUT')                     
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Database Name') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control"
                            placeholder="Database name" required name="tenancy_db_name" required value="{{ $info->tenancy_db_name ?? '' }}">     
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Database Username') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control"
                            placeholder="Database Username"  name="db_username"  value="{{ $info->tenancy_db_username ?? '' }}">     
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Database Password') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control"
                            placeholder="Database Password" name="db_password" value="{{ $info->tenancy_db_password ?? '' }}">     
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Migrate New Tenant Table') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="migrate" class="form-control">
                                <option value="yes">{{ __('Yes') }}</option>
                                <option value="no" selected>{{ __('No') }}</option>
                            </select>
                            <small>{{ __('Warning') }}: <span class="text-danger">{{ __('if you select yes that means it will create install new tables only') }}</span></small>
                        </div>
                    </div>
                               
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Make Migrate Database With Import The Demo Data') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="migrate_fresh" class="form-control">
                                <option value="yes">{{ __('Yes') }}</option>
                                <option value="no" selected>{{ __('No') }}</option>
                            </select>
                            <small>{{ __('Warning') }}: <span class="text-danger">{{ __('if you select yes that means it will create reinstall the database freshly with import dummy data') }}</span></small>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Update Database') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

