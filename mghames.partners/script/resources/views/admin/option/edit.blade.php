@extends('layouts.backend.app')

@section('title','Edit Page')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>{{ __('Edit Page') }}</h4>
      </div>
      <form method="POST" action="{{ route('admin.option.update', $option->key) }}" class="ajaxform_with_reload">
        @csrf
        <div class="card-body">
          <div class="form-group">
              <label>{{ strtoupper(str_replace('_', ' ', $option->key)) }}</label>
              @if ($option->key == 'auto_enroll_after_payment')
                  <select name="value" class="form-control">
                      <option value="on" {{ $option->value == 'on' ? 'selected' : '' }}>{{ __('ON') }}</option>
                      <option value="off" {{ $option->value == 'off' ? 'selected' : '' }}>{{ __('OFF') }}</option>
                  </select>
              @else
              <input class="form-control" name="value" type="text" value="{{ $option->value }}">
              @endif
          </div>
          <div class="row">
            <div class="col-lg-12">
              <button type="submit" class="btn btn-primary btn-lg float-right w-100 basicbtn">{{ __('Update') }}</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

