@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Product Price Discount','prev'=> url('seller/product')])
@endsection

@extends('seller.product.productmain',['product_id'=>$id])

@section('product_content')
<div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="home-tab4">
  <form class="ajaxform" action="{{ route('seller.product.update',$info->id) }}" method="post">
    @csrf
    @method("PUT")
    @php
    $discount_type=$info->discount->price_type ?? '';
    @endphp
    <div class="from-group row mb-2">
      <label for="" class="col-lg-12">{{ __('Discount Type') }} </label>
      <div class="col-lg-12">
       <select class="form-control selectric" name="price_type">
         <option value="0" @if($discount_type == 0) selected="" @endif>{{ __('Flat Discount') }}</option>
         <option value="1" @if($discount_type == 1) selected="" @endif>{{ __('Percentage Discount') }}</option>
       </select>
     </div>
    </div>
    <div class="from-group row mb-2">
      <label for="" class="col-lg-12">{{ __('Discount Value') }} </label>
      <div class="col-lg-12">
       <input type="number" step="any"  class="form-control" required=""  name="special_price" value="{{ $info->discount->special_price ?? '' }}">
      </div>
    </div>
    <div class="from-group row mb-2">
      <label for="" class="col-lg-12">{{ __('Discount Will Expire') }} </label>
      <div class="col-lg-12">
       <input type="date"   class="form-control" required="" name="ending_date" value="{{ $info->discount->ending_date ?? '' }}">
     </div>
    </div>
    <input type="hidden" name="type" value="discount">
    <div class="from-group  mb-2">
      <button class="btn btn-primary basicbtn col-lg-2" type="submit"><i class="far fa-save"></i> {{ __('Save') }}</button>
    </div>
  </form>
</div>
@endsection
