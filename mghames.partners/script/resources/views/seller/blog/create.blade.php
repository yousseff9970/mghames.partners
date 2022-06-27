@extends('layouts.backend.app')

@section('title','Create New Page')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Create New Blog Post','prev'=> route('seller.blog.index')])
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
        <h4>{{ __('Add New Post') }}</h4>
      </div>
      <form method="POST" action="{{ route('seller.blog.store') }}"  class="ajaxform_with_reset">
        @csrf
       
        <div class="card-body">
          <div class="form-group">
             {{mediasection()}}
          </div>
          <div class="form-group">
            <label>{{ __('Title') }}</label>
            <input type="text" class="form-control" placeholder="Page Title" required name="title">
          </div>
          <div class="form-group">
              <label>{{ __('Short Description') }}</label>
              <textarea name="short_description" cols="30" rows="10" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label>{{ __('Content') }}</label>
            <textarea name="content" class="summernote form-control"></textarea>
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
<script src="{{ asset('admin/assets/js/summernote-bs4.js') }}"></script>
<script src="{{ asset('admin/assets/js/summernote.js') }}"></script>
<!-- JS Libraies -->
<script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('admin/plugins/dropzone/components-multiple-upload.js') }}"></script>
<script src="{{ asset('admin/js/media.js') }}"></script>
@endpush
