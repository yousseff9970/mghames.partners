@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/barcode.css') }}">
@endpush
@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Barcode Print','prev'=> url('seller/product')])
@endsection
@extends('seller.product.productmain',['product_id'=>$id])
@section('product_content')
<div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="home-tab4">
   <form class="barcode_form" action="{{ route('seller.product.update',$info->id) }}" method="post">
      @csrf
      @method("PUT")
      <div class="from-group row mb-2">
         <label for="" class="col-lg-12">{{ __('Bar-code generate type :') }} </label>
         <div class="col-lg-12">
            <select name="barcode_type" class="form-control" id="barcode_type">
               <option value="QRCODE">{{ __('Qr Code') }}</option>
               <option value="PDF417">{{ __('PDF417') }}</option>
               <option value="C39">{{ __('C39') }}</option>
               <option value="C39+">{{ __('C39+') }}</option>
               <option value="C39E">{{ __('C39E') }}</option>
               <option value="C39E+">{{ __('C39E+') }}</option>
               <option value="C93">{{ __('C93') }}</option>
               <option value="S25">{{ __('S25') }}</option>
               <option value="S25+">{{ __('S25+') }}</option>
               <option value="I25">{{ __('I25') }}</option>
               <option value="I25+">{{ __('I25+') }}</option>
               <option value="C128">{{ __('C128') }}</option>
               <option value="C128A">{{ __('C128A') }}</option>
               <option value="C128B">{{ __('C128B') }}</option>
               <option value="C128C">{{ __('C128C') }}</option>
            </select>
         </div>
      </div>
      <div class="from-group row mb-2">
         <label for="" class="col-lg-12">{{ __('Select Style') }} </label>
         <div class="col-lg-12">
            <select name="barcode_style" class="form-control" id="barcode_style">
               <option value="barcode_style1">{{ __('Style 1') }}</option>
               <option value="barcode_style2">{{ __('Style 2') }}</option>
               <option value="barcode_style3">{{ __('Style 3') }}</option>
               <option value="barcode_style4">{{ __('Style 4') }}</option>
               <option value="barcode_style5">{{ __('Style 5') }}</option>
               <option value="barcode_style5_squire">{{ __('barcode_style5_squire') }}</option>
               <option value="barcode_style5_rectangle">{{ __('barcode_style5_rectangle') }}</option>
               <option value="barcode_style6">{{ __('barcode_style6') }}</option>
               <option value="barcode_style6_round">{{ __('barcode_style6_round') }}</option>
               <option value="barcode_style7">{{ __('Style 7') }}</option>
               <option value="barcode_style8">{{ __('Style 8') }}</option>
               <option value="barcode_style8_oval">{{ __('barcode_style8_oval') }}</option>
               <option value="barcode_style9"> {{ __('barcode_style9') }}</option>
               <option value="barcode_style10_rounded"> {{ __('barcode_style10_rounded') }}</option>
               <option value="barcode_style10"> {{ __('barcode_style10') }}</option>
               <option value="barcode_style11">{{ __('barcode_style11') }}</option>
               <option value="barcode_style11_rounded">{{ __('barcode_style11_rounded') }}</option>
               <option value="barcode_style12">{{ __('barcode_style12') }}</option>
               <option value="barcode_style12_rounded">{{ __('barcode_style12_rounded') }}</option>
               <option value="barcode_style13_oval">{{ __('barcode_style13_oval') }}</option>
               <option value="barcode_style14">{{ __('barcode_style14') }}</option>
               <option value="barcode_style15">{{ __('barcode_style15') }}</option>
               <option value="barcode_style16">{{ __('barcode_style16') }}</option>
               <option value="barcode_style17">{{ __('barcode_style17') }}</option>
               <option value="barcode_style18">{{ __('barcode_style18') }}</option>
               <option value="barcode_style19">{{ __('barcode_style19') }}</option>
            </select>
         </div>
      </div>
      <div class="from-group row mb-2">
         <label for="" class="col-lg-12">{{ __('Custom Label Height') }} </label>
         <div class="col-lg-12">
            <input type="text" id="label_height" value="auto" class="form-control"  />
         </div>
      </div>
      <div class="from-group row mb-2">
         <label for="" class="col-lg-12">{{ __('Custom Label Width') }} </label>
         <div class="col-lg-12">
            <input type="text" id="label_width" value="auto" class="form-control" />
         </div>
      </div>
      <div class="from-group row mb-2">
         <label for="" class="col-lg-12">{{ __('Custom Barcode Height') }} </label>
         <div class="col-lg-12">
            <input type="text" id="barcode_height" value="auto" class="form-control" />
         </div>
      </div>
      <div class="from-group row mb-2">
         <label for="" class="col-lg-12">{{ __('Custom Label Image Height') }} </label>
         <div class="col-lg-12">
            <input type="text" id="preview_height" value="auto" class="form-control" />
         </div>
      </div>
      <div class="from-group row mb-2">
         <label for="" class="col-lg-12">{{ __('Print Quantity') }} </label>
         <div class="col-lg-12">
            <input type="number" id="print_qty" value="1" class="form-control" />
         </div>
      </div>
      <div class="from-group row mb-2">
         <label for="" class="col-lg-12">{{ __('Fileds') }} </label>
         <div class="col-lg-12">
           
            <label><input type="checkbox" id="product_status_name" value="1" 
               checked
               >{{ __('Product name') }}</label>&nbsp;&nbsp;&nbsp;
            <label>

               <input type="checkbox" id="product_code" value="1" 
               checked
               >{{ __('Product code') }}</label>&nbsp;&nbsp;&nbsp;

            <label><input type="checkbox" id="price_status" value="1" 
               checked
               >{{ __('Price') }}</label>&nbsp;&nbsp;&nbsp;
            <label><input type="checkbox" id="currency" value="1" 
               checked
               >{{ __('Currency') }}</label>&nbsp;&nbsp;&nbsp;
            
            <label><input type="checkbox" id="product_image" value="1" 
               checked
               >{{ __('Product Image') }}</label>
         </div>
      </div>
      <div class="from-group  mb-2">
         <button class="btn btn-primary basicbtn col-lg-2" type="submit"><i class="far fa-save"></i> {{ __('Generate') }}</button>
      </div>
      <input type="hidden" name="type" value="barcode">
   </form>
</div>
@endsection
@section('product_extra_content')
<div class="card">
  <div class="text-center">
         <div class="btn-group">
            <button class="btn btn-warning" onclick="printDiv('barcode-con')"><span class="fa fa-print"></span> Print</button>
         </div>
      </div>
   <div id="barcode-con">
      <div class="barcode barcodea4" id="barcode">
         
      </div>
   </div>
</div>
<input type="hidden" id="preview" value="{{ asset($info->preview->value ?? 'admin/img/img/placeholder.png') }}">
<input type="hidden" id="product_name" value="{{ $info->title }}">
<input type="hidden" id="full_id" value="{{ $info->full_id }}">
<input type="hidden" id="price" value="{{ $info->price->price ?? '' }}">

<input type="hidden" id="currency_settings" value="{{ get_option('currency_data') }}">
@endsection

@push('script')
<script src="{{ asset('admin/js/product-based-barcode.js') }}"></script>
@endpush