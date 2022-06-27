@push('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Product SEO','prev'=> url('seller/product')])
@endsection

@extends('seller.product.productmain',['product_id'=>$id])

@section('product_content')
<div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="home-tab4">
  <form class="ajaxform" action="{{ route('seller.product.update',$info->id) }}" method="post">
    @csrf
    @method("PUT")
    <div class="from-group row mb-2">
      <label for="" class="col-lg-12">{{ __('Meta Image') }} : </label>
      <div class="col-lg-12">
        {{ !empty($seo) ? mediasection(['preview'=>$seo->preview ?? '','value'=>$seo->preview ?? '']) : mediasection() }}
      </div>
    </div>
    <div class="from-group row mb-2">
      <label for="" class="col-lg-12">{{ __('Meta Title :') }} </label>
      <div class="col-lg-12">
       <input type="text"  class="form-control" name="title" value="{{ !empty($seo) ? $seo->title : $info->title }}">
     </div>
    </div>
     <div class="from-group row mb-2">
      <label for="" class="col-lg-12">{{ __('Meta Tags :') }} </label>
      <div class="col-lg-12">
       <input type="text"  class="form-control" placeholder="tag1,tag2" name="tags" value="{{ $seo->tags ?? '' }}">
     </div>
    </div>
    <div class="from-group row mb-2">
      <label for="" class="col-lg-12">{{ __('Meta Description :') }} </label>
      <div class="col-lg-12">
       <textarea class="form-control h-150" name="description">{{ $seo->description ?? '' }}</textarea>
     </div>
    </div>
    <input type="hidden" name="type" value="seo">
   <div class="from-group  mb-2">
    <button class="btn btn-primary basicbtn col-lg-2" type="submit"><i class="far fa-save"></i> {{ __('Update') }}</button>
  </div>
</form>
</div>
{{ mediasingle() }} 
@endsection

@push('script')
<script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('admin/js/media.js') }}"></script>
<script src="{{ asset('admin/js/jquery-ui.min.js') }}"></script>
@endpush