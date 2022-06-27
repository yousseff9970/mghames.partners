@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Plan Data','prev'=>route('admin.store.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Edit Plan Data For ').$info->id }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.domain.plan.update',$info->id) }}" class="ajaxform">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Will Expire') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="date" class="form-control"
                            placeholder="Expire Date" required value="{{ $info->will_expire }}" name="will_expire">                        
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
                                <option value="{{ $row }}" @if(isset($info->$key)) {{ $info->$key == $row ? 'selected' : ''  }} @endif>{{ $k }}</option>
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
                            placeholder="Enter The Value" required name="plan[{{ $key }}]" value="{{ $info->$key ?? ''  }}">                            
                        </div>
                    </div>
                    @endif
                    @endforeach
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

