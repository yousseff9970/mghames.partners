@extends('layouts.backend.app')

@section('title','Edit Blog')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Edit Blog','prev'=> route('admin.blog.index')])
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>{{ __('Edit Blog') }}</h4>
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
      <form method="POST" action="{{ route('admin.blog.update', $blog_edit->id) }}" enctype="multipart/form-data" class="ajaxform">
        @csrf
        @method('put')
        @php
        $excerpt_info = $blog_edit->excerpt->value;
        $description_info = $blog_edit->description->value;
        $thumimg_info = $blog_edit->preview->value;
        @endphp
        <div class="card-body">
          <div class="form-group">
            <label>{{ __('Name') }}</label>
            <input type="text" class="form-control" placeholder="Name" required name="name" value="{{ $blog_edit->title }}">
          </div>
          <div class="form-group">
            <label>{{ __('Short Content') }}</label>
            <textarea name="excerpt" cols="30" rows="10" class="form-control">{{ $excerpt_info }}</textarea>
          </div>
          <div class="form-group">
            <label>{{ __('Description') }}</label>
            <textarea name="description" class="summernote">{{ $description_info }}</textarea>
          </div>
          <div class="form-group">
            <div class="custom-file mb-3">
              <input type="file" class="custom-file-input" id="customFile" name="thum_image">
              <label class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
            </div>
            <br>
            <img width="100" src="{{ asset($thumimg_info) }}" alt="{{ $thumimg_info }}">
          </div>
          <div class="form-group">
            <div class="custom-file mb-3">
              <label>{{ __('Status') }}</label>
              <select name="status" class="form-control">
                <option value="1" {{ ($blog_edit->status == 1) ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option value="0" {{ ($blog_edit->status == 0) ? 'selected' : '' }}>{{ __('Inactive') }}</option>
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
