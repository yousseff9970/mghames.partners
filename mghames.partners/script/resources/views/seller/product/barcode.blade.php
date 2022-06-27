@extends('layouts.backend.app')

@push('css')
   <link rel="stylesheet" href="{{ asset('admin/assets/css/barcode_style.css') }}"> 
@endpush

@section('title','Brands')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Print Barcode'])
@endsection

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Barcode Generate') }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3 dlj-middle">{{ __('Add Product') }}</label>
                <div class="col-sm-12 col-md-7">
                    <div class="product-add-input-section">
                        <div class="product-search-input">
                            <div class="input-group">
                                <input type="text" onkeyup="product_search()" placeholder="Search Products..." id="product_search" autocomplete="off">
                            </div>
                        </div>
                        <div class="product-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M2 4h2v16H2V4zm4 0h1v16H6V4zm2 0h2v16H8V4zm3 0h2v16h-2V4zm3 0h2v16h-2V4zm3 0h1v16h-1V4zm2 0h3v16h-3V4z"/></svg>
                        </div>
                        <div class="product-search-area" id="product_search_append">
                            
                        </div>
                    </div>
                </div>
            </div>
            <form class="barcode_form" action="{{ route('seller.barcode.generate') }}" method="post">
                @csrf
                <div class="product-append-area">
                    <div class="product-table-main-area">
                        <div class="table-responsive">
                            <table id="product-table" class="table table-striped table-bordered">
                                <thead class="h-10">
                                    <tr class="h-10">
                                        <th class="w-50 text-center">
                                            {{ __('Product Name with Code') }}                            
                                        </th>
                                        <th class="w-20 text-center">
                                            {{ __('Price') }}                            
                                        </th>
                                        <th class="w-20 text-center">
                                            {{ __('Quantity') }}                            
                                        </th>
                                        <th class="w-10 text-center">
                                            {{ __('Delete') }}                            
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="product_barcode_append">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="product-select">
                    <div class="from-group row mb-2">
                        <label for="" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Bar-code generate type :') }} </label>
                        <div class="col-sm-12 col-md-7">
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
                        <label for="" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Style') }} </label>
                        <div class="col-sm-12 col-md-7">
                        <select name="barcode_style" class="form-control" id="barcode_style">
                            <option value="barcode_style1">{{ __('Barcode Style One') }}</option>
                            <option value="barcode_style2">{{ __('Barcode Style Two') }}</option>
                            <option value="barcode_style3">{{ __('Barcode Style Three') }}</option>
                            <option value="barcode_style4">{{ __('Barcode Style Four') }}</option>
                            <option value="barcode_style5">{{ __('Barcode Style Five') }}</option>
                        </select>
                        </div>
                    </div>
                    <div class="from-group row mb-2">
                        <label for="" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Custom Label Height') }} </label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" id="label_height" value="auto" class="form-control"  />
                        </div>
                    </div>
                    <div class="from-group row mb-2">
                        <label for="" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Custom Label Width') }} </label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" id="label_width" value="auto" class="form-control" />
                        </div>
                    </div>
                    <div class="from-group row mb-2">
                        <label for="" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Custom Barcode Height') }} </label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" id="barcode_height" value="auto" class="form-control" />
                        </div>
                    </div>
                    <div class="from-group row mb-2">
                        <label for="" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Custom Label Image Height') }} </label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" id="preview_height" value="auto" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="product-fields">
                    <div class="from-group row mb-2 align-items-center">
                        <label for="" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Fileds') }} </label>
                        <div class="col-sm-12 col-md-7">
                        
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
                    <input type="hidden" name="type" value="barcode">
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7 row">
                        <div class="col-sm-3 col-sm-offset-3 text-center">            
                            <button class="btn btn-info btn-block" type="submit">
                            <i class="fa fa-fw fa-cog"></i>
                            {{ __('Generate') }}</button>
                        </div>
                        <div class="col-sm-3 text-center">            
                            <a href="javascript:void(0)" onclick="barcode_reset()"  class="btn btn-danger btn-block">
                            <span class="fa fa-fw fa-circle-o"></span>
                            {{ __('Reset') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div id="barcode-con">
                <div class="barcode-section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="f-right mr-0">
                                <div class="btn-group">
                                    <button class="btn btn-lg btn-warning" id="btnPrint"><span class="fa fa-print"></span> {{ __('Print') }}</button>
                                   

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="print_area">
                        <div class="row mt-5">
                            <div id="barcode-con">
                                <div class="">
                                    <div class="row barcode barcodea4"id="barcode">
    
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" id="preview" value="{{ asset($info->preview->value ?? 'admin/img/img/placeholder.png') }}">
<input type="hidden" id="product_name">
<input type="hidden" id="full_id">
<input type="hidden" id="price">
<input type="hidden" id="currency_name">
<input type="hidden" id="product_search_url" value="{{ route('seller.barcode.search') }}">
<input type="hidden" id="asset_url" value="{{ asset('/') }}">
<input type="hidden" id="bootstrap_url" value="{{ asset('admin/assets/css/bootstrap.min.css') }}"> 
<input type="hidden" id="style_url" value="{{ asset('admin/assets/css/style.css') }}"> 
<input type="hidden" id="component_url" value="{{ asset('admin/assets/css/components.css') }}"> 
<input type="hidden" id="barcode_url" value="{{ asset('admin/assets/css/barcode_style.css') }}">
@endsection

@push('script')
<script src="{{ asset('admin/js/product-barcode.js') }}"></script>
@endpush

