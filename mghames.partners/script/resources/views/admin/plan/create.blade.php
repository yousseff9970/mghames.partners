@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Create Plan','prev'=>route('admin.plan.index')])
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/selectric.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Create New Plan') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.plan.store') }}" class="ajaxform_with_reset">
                    @csrf
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Plan Name') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Name" required name="name">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Duration') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" class="form-control @error('duration') is-invalid @enderror"
                            placeholder="Duration" required name="duration">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                        {{ __('Price') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" step="any" class="form-control @error('price') is-invalid @enderror"
                            placeholder="Price" required name="price">
                        </div>
                    </div>
                    @foreach($features as $key => $value)
                    @if($value['type'] == 'option')
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ ucfirst(str_replace('_',' ',$key)) }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="plan[{{ $key }}]" class="form-control selectric">
                                @foreach($value['value'] ?? [] as $k => $row)
                                <option value="{{ $row }}">{{ $k }}</option>
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
                            placeholder="Enter The Value" required name="plan[{{ $key }}]" value="{{ $value['value'] }}">                            
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is featured') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="is_featured" class="form-control selectric">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Inactive') }}</option>
                            </select>
                        </div>
                    </div>
                  <div class="form-group row mb-4">
                    <label
                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                    <div class="col-sm-12 col-md-7">
                        <select name="status" class="form-control selectric">
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label
                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is featured ?') }}</label>
                    <div class="col-sm-12 col-md-7">
                        <select name="is_featured" class="form-control selectric">
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>
                 <div class="form-group row mb-4">
                    <label
                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is Trial ?') }}</label>
                    <div class="col-sm-12 col-md-7">
                        <select name="is_trial" class="form-control selectric">
                            <option value="1">{{ __('Yes') }}</option>
                            <option value="0" selected="">{{ __('No') }}</option>
                        </select>
                    </div>
                </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                    <button type="submit" class="btn btn-primary basicbtn w-100 btn-lg">{{ __('Create Plan') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('admin/assets/js/jquery.selectric.min.js') }}"></script>
@endpush

