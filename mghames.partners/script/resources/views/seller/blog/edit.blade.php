@extends('layouts.backend.app')

@section('title','Create New Page')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Post','prev'=> route('seller.blog.index')])
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>{{ __('Edit Post') }}</h4>
      </div>
      <form method="POST" action="{{ route('seller.blog.update',$info->id) }}"  class="ajaxform">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="form-group">
             {{mediasection(['value'=>$info->preview->value ?? '','preview'=> $info->preview->value])}}
          </div>
          <div class="form-group">
            <label>{{ __('Title') }}</label>
            <input type="text" class="form-control" placeholder="Title" required name="title" value="{{ $info->title }}">
          </div>
          <div class="form-group">
              <label>{{ __('Short Description') }}</label>
              <textarea name="short_description" cols="30" rows="10" class="form-control">{{ $info->excerpt->value ?? '' }}</textarea>
          </div>
          <div class="form-group">
            <label>{{ __('Content') }}</label>
            <textarea name="content" class="summernote form-control">{{ $info->description->value ?? '' }}</textarea>
          </div>
          <div class="form-group">
            <div class="custom-file mb-3">
              <label>{{ __('Status') }}</label>
              <select name="status" class="form-control">
                <option value="1">{{ __('Active') }}</option>
                <option value="0">{{ __('Inactive') }}</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <button type="submit" class="btn btn-primary btn-lg float-right w-100 basicbtn">{{ __('Submit') }}</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
{{ mediasingle() }} 
@endsection

@push('script')
<script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('admin/plugins/dropzone/components-multiple-upload.js') }}"></script>
<script src="{{ asset('admin/js/media.js') }}"></script>
@endpush
