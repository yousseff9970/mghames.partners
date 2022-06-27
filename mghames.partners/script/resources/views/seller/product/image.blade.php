@push('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Product Image','prev'=> url('seller/product')])
@endsection

@extends('seller.product.productmain',['product_id'=>$id])

@section('product_content')
<div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="home-tab4">
  <form class="ajaxform" action="{{ route('seller.product.update',$info->id) }}" method="post">
    @csrf
    @method("PUT")
     <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Featured Image') }} : </label>
        <div class="col-lg-12">
          {{mediasection(['preview'=>$info->media->value ?? '','value'=>$info->media->value ?? ''])}}
      </div>
     </div>
     <div class="from-group row mb-2">
        <label for="" class="col-lg-12">{{ __('Gallery Images') }} : </label>
        <div class="col-lg-12">
          {{mediasectionmulti(['value'=>$medias])}}
        </div>
     </div>
    <input type="hidden" name="type" value="images">         
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