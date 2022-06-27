@push('css')
<link rel="stylesheet" href="{{ asset('admin/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/summernote/summernote-bs4.css') }}">
@endpush

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Product','prev'=> url('seller/product')])
@endsection

@extends('seller.product.productmain',['product_id'=>$id])

@section('product_content')
<form class="ajaxform" action="{{ route('seller.product.update',$info->id) }}" method="post">
    @csrf
    @method("PUT")
<div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="home-tab4">
    <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Name :') }} </label>
        <div class="col-lg-12">
            <input type="text" name="name" required="" class="form-control" placeholder="Enter Product Name" value="{{ $info->title }}">
        </div>
    </div>
    <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Slug :') }} </label>
        <div class="col-lg-12">
            <input type="text" name="slug" required="" class="form-control" placeholder="Enter Product Slug" value="{{ $info->slug }}">
        </div>
    </div>
    <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Short Description :') }} </label>
        <div class="col-lg-12">
            <textarea  name="short_description" maxlength="500" class="form-control h-150">{{ $info->excerpt->value ?? '' }}</textarea>
        </div>
    </div>
    <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Long Description :') }} </label>
        <div class="col-lg-12">
            <textarea  name="long_description" class="form-control summernote">{{ $info->description->value ?? '' }}</textarea>
        </div>
    </div>
    <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Select Product Category') }} : </label>
        <div class="col-lg-12">
            <select name="categories[]" multiple="" class="select2 form-control">

                {{NastedCategoryList('category',$selected_categories)}}
            </select>
        </div>
    </div>
    <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Select Product Brand') }} : </label>
        <div class="col-lg-12">
            <select name="categories[]"  class="selectric form-control">
               
                {{NastedCategoryList('brand',$selected_categories)}}
            </select>
        </div>
    </div>
    <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Select Product Tags') }} : </label>
        <div class="col-lg-12">
            <select name="categories[]" multiple=""  class="form-control select2">

                {{NastedCategoryList('tag',$selected_categories)}}
            </select>
            <input type="hidden" name="type" value="general">
        </div>
    </div>
   
    <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Select Featured Type') }} : </label>
        <div class="col-lg-12">
         <select name="categories[]"   class="form-control selectric">
           <option value="" selected=""></option>
           @foreach($features as $row)
           <option value="{{ $row->id }}" @if(in_array($row->id,$selected_categories)) selected @endif>{{ $row->name }}</option>
           @endforeach
        </select>
      </div>
    </div>
    <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Status') }} : </label>
        <div class="col-lg-12">
            <select name="status"  class="form-control selectric">
                <option value="1" @if($info->status == 1) selected @endif>{{ __('Publish') }}</option>
                <option value="0" @if($info->status == 0) selected @endif>{{ __('Draft') }}</option>
            </select>
        </div>
    </div>
    <div class="from-group  mb-2">
        <button class="btn btn-primary basicbtn col-lg-2" type="submit"><i class="far fa-save"></i> {{ __('Update') }}</button>
    </div>
</div>
</form>
@endsection

@push('script')
<script src="{{ asset('admin/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/summernote-bs4.js') }}"></script>
<script src="{{ asset('admin/assets/js/summernote.js') }}"></script>
@endpush