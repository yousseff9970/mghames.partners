@extends('layouts.backend.app')

@section('content')
@include('layouts.backend.partials.headersection',['title'=>'Google analytics'])
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>{{ __('Google Analytics') }}</h4><br>
      </div>
      <div class="card-body">
        <form class="ajaxform" action="{{ route('admin.google_analytics_service') }}" enctype="multipart/form-data" method="post">
          @csrf
            <input type="hidden" name="type" value="google-analytics">
            <div class="form-group row mb-4">
                <a href="{{ url('/admin/setting/env') }}" class="col-form-label text-md-right col-12 col-md-3 col-lg-3 text-primary" >{{ __('ANALYTICS_VIEW_ID') }}</a>
                <div class="col-sm-12 col-md-7">
                    <input type="text" disabled class="form-control" value="{{ env('ANALYTICS_VIEW_ID') }}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3 text-primary" >{{ __('service-account-credentials.json') }}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="file" name="file" class="form-control" accept=".json">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                    <button class="btn btn-primary basicbtn" type="submit">{{ __('Upload') }}</button><br>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
