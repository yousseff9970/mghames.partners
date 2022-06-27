@extends('layouts.backend.app')

@section('title','Edit Page')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Page','prev'=> route('seller.page.index')])
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
        <div class="card-header">
          <h4>{{ __('Edit Page') }}</h4>
        </div>
        <form method="POST" action="{{ route('seller.page.update', $info->id) }}" enctype="multipart/form-data" class="ajaxform">
          @csrf
          @method('put')
          <div class="card-body">
            <div class="form-group">
              <label>{{ __('Page Title') }}</label>
              <input type="text" class="form-control" placeholder="Page Title" required name="page_title" value="{{ $info->title }}">
            </div>
            <div class="form-group">
              <label>{{ __('Slug') }}</label>
              <input type="text" class="form-control"  required name="slug" value="{{ $info->slug }}">
            </div>
            <div class="form-group">
                <label>{{ __('Short Description') }}</label>
                <textarea name="page_excerpt" cols="30" rows="10" class="form-control">{{ $meta->page_excerpt ?? '' }}</textarea>
            </div>
            <div class="form-group">
              <label>{{ __('Page Content') }}</label>
              <textarea name="page_content" class="summernote form-control">{{ $meta->page_content ?? '' }}</textarea>
            </div>
            <div class="form-group">
              <div class="custom-file mb-3">
                <label>{{ __('Status') }}</label>
                <select name="status" class="form-control">
                  <option value="1" {{ ($info->status == 1) ? 'selected' : '' }}>{{ __('Active') }}</option>
                  <option value="0" {{ ($info->status == 0) ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                </select>
              </div>
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

@push('script')
  <script src="{{ asset('admin/assets/js/summernote-bs4.js') }}"></script>
  <script src="{{ asset('admin/assets/js/summernote.js') }}"></script>
@endpush