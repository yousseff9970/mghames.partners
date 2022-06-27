@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Plan','prev'=>route('admin.plan.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Edit Plan') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.plan.update',$info->id) }}" class="ajaxform">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Plan Name') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Name" required name="name" value="{{ $info->name }}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Duration') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" class="form-control @error('duration') is-invalid @enderror"
                            placeholder="Duration" required name="duration" value="{{ $info->duration }}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                        {{ __('Price') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" step="any" class="form-control @error('price') is-invalid @enderror"
                            placeholder="Price" required name="price" value="{{ $info->price }}">
                        </div>
                    </div>
                    @foreach($features as $key => $value)
                    @if($value['type'] == 'option')
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ ucfirst(str_replace('_',' ',$key)) }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="plan[{{ $key }}]" class="form-control">
                                @foreach($value['value'] ?? [] as $k => $row)
                                <option value="{{ $row }}" @if(isset($data->$key)) {{ $data->$key == $row ? 'selected' : ''  }} @endif>{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @else
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                        {{ ucfirst(str_replace('_',' ',$key)) }} {{ $key == 'storage_limit' ? "(MB)" : '' }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="{{ $value['type'] }}" class="form-control"
                            placeholder="Enter The Value" required name="plan[{{ $key }}]" value="{{ $data->$key ?? '' }}">                            
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is featured ?') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="is_featured" class="form-control">
                                <option value="1" @if($info->is_featured == 1) selected @endif>{{ __('Yes') }}</option>
                                <option value="0" @if($info->is_featured == 0) selected @endif>{{ __('No') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="status" class="form-control">
                                <option value="1" @if($info->status==1) selected @endif>{{ __('Active') }}</option>
                                <option value="0" @if($info->status==0) selected @endif>{{ __('Inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is Trial ?') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="is_trial" class="form-control">
                                <option value="1" @if($info->is_trial == 1) selected @endif>{{ __('Yes') }}</option>
                                <option value="0"  @if($info->is_trial == 0) selected @endif>{{ __('No') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Update Plan') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

