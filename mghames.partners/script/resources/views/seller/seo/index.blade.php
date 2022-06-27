@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'SEO Settings'])
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Site SEO Settings') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4">
                        <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                            @foreach($pages as $key => $row)
                            <li class="nav-item">
                                <a class="nav-link @if($key == 0) active @endif"  data-toggle="tab" href="#{{$row}}" role="tab" aria-controls="home" aria-selected="true">{{ str_replace('_',' ',$row) }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-8">
                        <div class="tab-content no-padding" id="myTab2Content">
                            @foreach($pages as $key => $row)
                            <div class="tab-pane fade @if($key == 0) show active @endif" id="{{$row}}" role="tabpanel" aria-labelledby="{{$row}}">
                                @php
                                $data=get_option($row,true)->seo ?? '';
                                @endphp
                                <form method="post" class="ajaxform" action="{{ route('seller.seo.update',$row) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="site_title">{{ __('Site Title') }}</label>
                                        <input type="text" name="site_title" id="site_title" class="form-control" value="{{ $data->site_title ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="twitter_title">{{ __('Twitter Title') }}</label>
                                        <input type="text" name="twitter_title" id="twitter_title" class="form-control" value="{{ $data->twitter_title ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="tags">{{ __('Tags') }}</label>
                                        <input type="text" name="tags" id="tags" class="form-control" value="{{ $data->tags ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ __('Description') }}</label>
                                        <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ $data->description ?? '' }}</textarea>
                                    </div>

                                <div class="form-group">
                                    <label>{{ __('Meta Image') }}</label>
                                    {{mediasection([
                                        'preview_class'=>'product_page_icon'.$key,
                                        'input_id'=>'product_page_icon'.$key,
                                        'input_class'=>'product_page_image'.$key,
                                        'input_name'=>'meta_image',
                                        'value'=>$data->meta_image ?? '',
                                        'preview'=>$data->meta_image ?? 'admin/img/img/placeholder.png'
                                    ])}}
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
                                </div>
                              </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
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
