@extends('layouts.backend.app')

@section('title','Edit Page')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Page','prev'=> route('admin.page.index')])
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
        @if ($errors->any())
          <div class="alert alert-danger">
              <strong>{{ __('Whoops') }}!</strong> {{ __('There were some problems with your input') }}.<br><br>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
        @php
          $info = json_decode($page_edit->page->value);
        @endphp
        <form method="POST" action="{{ route('admin.page.update', $page_edit->id) }}" enctype="multipart/form-data" class="ajaxform">
          @csrf
          @method('put')
          <div class="card-body">
            <div class="form-group">
              <label>{{ __('Page Title') }}</label>
              <input type="text" class="form-control" placeholder="Page Title" required name="page_title" value="{{ $page_edit->title }}">
            </div>
            <div class="form-group">
                <label>{{ __('Page excerpt') }}</label>
                <textarea name="page_excerpt" cols="30" rows="10" class="form-control">{{ $info->page_excerpt }}</textarea>
            </div>
            <div class="form-group">
              <label>{{ __('Page Content') }}</label>
              <textarea name="page_content" class="summernote">{{ $info->page_content }}</textarea>
            </div>
            <div class="form-group">
              <div class="custom-file mb-3">
                <label>{{ __('Status') }}</label>
                <select name="status" class="form-control">
                  <option value="1" {{ ($page_edit->status == 1) ? 'selected' : '' }}>{{ __('Active') }}</option>
                  <option value="0" {{ ($page_edit->status == 0) ? 'selected' : '' }}>{{ __('Inactive') }}</option>
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