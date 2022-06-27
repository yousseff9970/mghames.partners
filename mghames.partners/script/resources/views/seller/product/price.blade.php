@push('css')
<link rel="stylesheet" href="{{ asset('admin/css/select2.min.css') }}">
@endpush

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit Product Price','prev'=> url('seller/product')])
@endsection

@extends('seller.product.productmain',['product_id'=>$id])

@section('product_content')
<div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="home-tab4">
   <form class="ajaxform " action="{{ route('seller.product.update',$info->id) }}" method="post">
      @csrf
      @method("PUT")
      <div class="from-group row mb-2">
         <label for="" class="col-lg-12">{{ __('Price Type') }} : </label>
         <div class="col-lg-12">
            <select name="product_type"  class="form-control product_type selectric">
            <option value="0" @if($info->is_variation == 0) selected @endif>{{ __('Simple Product') }}</option>
            <option value="1" @if($info->is_variation == 1) selected @endif>{{ __('Variation Product') }}</option>
            </select>
         </div>
      </div>
      <input type="hidden" name="type" value="price">
      <div class="{{ $info->is_variation == 1 ? 'none' : '' }} single_product_area">
         <div class="from-group row mb-2">
            <label for="" class="col-lg-12">{{ __('Product Price') }} : </label>
            <div class="col-lg-12">
               <input type="number" step="any" class="form-control" name="price" value="{{ $info->price->price ?? '' }}">
            </div>
         </div>
         <div class="from-group row mb-2">
            <label for="" class="col-lg-12">{{ __('Quantity') }} : </label>
            <div class="col-lg-12">
               <input type="number" class="form-control" name="qty" value="{{ $info->price->qty ?? '' }}">
            </div>
         </div>
         <div class="from-group row mb-2">
            <label for="" class="col-lg-12">{{ __('SKU') }} : </label>
            <div class="col-lg-12">
               <input type="text" class="form-control" name="sku" value="{{ $info->price->sku ?? '' }}">
            </div>
         </div>
         <div class="from-group row mb-2">
            <label for="" class="col-lg-12">{{ __('Weight') }} : </label>
            <div class="col-lg-12">
               <input type="number" step="any" class="form-control" name="weight" value="{{ $info->price->weight ?? '' }}">
            </div>
         </div>
         @php
         $stock_manage=$info->price->stock_manage ?? '';
         $stock_status=$info->price->stock_status ?? '';
         @endphp
         <div class="from-group row mb-2">
            <label for="" class="col-lg-12">{{ __('Stock manage') }} : </label>
            <div class="col-lg-12">
               <select name="stock_manage" class="form-control selectric">
               <option value="1" @if($stock_manage == 1) selected="" @endif>{{ __('Yes') }}</option>
               <option value="0" @if($stock_manage == 0) selected="" @endif>{{ __('No') }}</option>
               </select>
            </div>
         </div>
         <div class="from-group row mb-2">
            <label for="" class="col-lg-12">{{ __('Stock Status') }} : </label>
            <div class="col-lg-12">
               <select name="stock_status" class="form-control selectric">
               <option value="1" @if($stock_status == 1) selected="" @endif>{{ __('In Stock') }}</option>
               <option value="0" @if($stock_status == 0) selected="" @endif>{{ __('Out Of Stock') }}</option>
               </select>
            </div>
         </div>
      </div>
      <div class="variation_product_area {{ $info->is_variation == 0 ? 'none' : '' }}">
         <div id="accordion">
            @foreach($info->productoptionwithcategories ?? [] as $key => $row)
            @php
            $selected_childs=[];

            foreach($row->priceswithcategories ?? [] as $price_category){
                array_push($selected_childs, $price_category->category_id);
            }
            @endphp
             <div class="accordion renderchild{{ $key }}">
               <div class="accordion-header h-50" role="button" data-toggle="collapse" data-target="#panel-body-{{ $key }}">
                  <div class="float-left">
                     <h6>
                        <span id="option_name4">{{ $row->categorywithchild->name ?? '' }}</span> 
                        @if($row->is_required == 1)<span class="text-danger">*</span> @endif
                    </h6>
                  </div>
                  <div class="float-right">
                     <a class="btn btn-danger btn-sm text-white option_delete" data-id="{{ $key }}"><i class="fa fa-trash"></i></a>
                  </div>
               </div>
               <div class="accordion-body collapse show" id="panel-body-{{ $key }}" data-parent="#accordion">
                  <div class="row mb-2 " >
                     <div class="col-lg-6 from-group">
                        <label for="" >{{ __('Select Attribute :') }} </label>
                        <select required name="parentattribute[]"  class="form-control parentattribute selectric parentattribute{{ $key }}">
                           <option value="{{ $row->category_id }}"  class="parentAttr{{ $row->id }}" data-parentname="{{ $row->name }}" data-short="{{ $key }}" data-childattributes="{{ $row->categorywithchild->categories }}">{{ $row->categorywithchild->name ?? '' }}</option>
                        </select>
                     </div>
                     <div class="col-lg-6 from-group">
                        <label for="" >{{ __('Select Attribute Values :') }} </label>
                        <select required  class="form-control select2 childattribute childattribute{{$key}} multi-select" multiple="">
                            @foreach($row->categorywithchild->categories as $category)
                            <option  
                            @if(in_array($category->id, $selected_childs)) 
                            selected 
                            @endif 
                            value="{{ $category->id }}" 
                            data-parentid="{{ $row->id }}" 
                            data-parent="{{ $row->categorywithchild->name ?? '' }}" 
                            data-short="{{ $key }}" 
                            data-attrname="{{ $category->name }}" 
                            class='child_attr{{ $category->id }} 
                            childattr{{ $key }}'
                            >
                            {{ $category->name }}
                           </option>
                            @endforeach
                        </select>
                     </div>
                     <div class="from-group col-lg-6  mb-2">
                        <label for="" >{{ __('Select Type :') }} </label>
                        <div >
                           <select name="childattribute[child][{{$row->id}}][select_type]" class="form-control selectric    selecttype{{ $key }}">
                              <option value="1" @if($row->select_type == 1) selected @endif>{{ __('Multiple Select') }}</option>
                              <option value="0" @if($row->select_type == 0) selected @endif>{{ __('Single Select') }}</option>
                           </select>
                        </div>
                     </div>
                     <div class="from-group col-lg-6  mb-2">
                        <label for="" >{{ __('Is Required ? :') }} </label>
                        <div >
                           <select name="childattribute[child][{{$row->id}}][is_required]" class="form-control selectric    is_required{{ $key }}">
                              <option value="1" @if($row->is_required == 1) selected @endif>{{ __('Yes') }}</option>
                              <option value="0" @if($row->is_required == 0) selected @endif>{{ __('No') }}</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <hr>
                  <div id="children_attribute_render_area{{ $key }}">
                    @foreach($row->priceswithcategories ?? [] as $priceswithcategory)
                     <div class=" " id="childcard{{$priceswithcategory->category_id}}">
                        <div class="card-header">
                           <h4>{{ $row->categorywithchild->name ?? '' }} / <span class="text-danger">  {{ $priceswithcategory->category->name ?? '' }}</span></h4>
                        </div>
                        <div class=" row">
                           <div class="from-group col-lg-6">
                              <label for="" >{{ __('Price :') }} </label>
                              <div >
                                 <input type="number" step="any" class="form-control" name="childattribute[priceoption][{{$priceswithcategory->id}}][price]" value="{{ $priceswithcategory->price }}" />
                              </div>
                           </div>
                           <div class="from-group col-lg-6  mb-2">
                              <label for="">{{ __('Stock Quantity :') }} </label>
                              <div >
                                 <input type="number" class="form-control" name="childattribute[priceoption][{{$priceswithcategory->id}}][qty]" value="{{ $priceswithcategory->qty }}"/>
                              </div>
                           </div>
                           <div class="from-group col-lg-6 mb-2">
                              <label for="" >{{ __('SKU :') }} </label>
                              <div >
                                 <input type="text" class="form-control" name="childattribute[priceoption][{{$priceswithcategory->id}}][sku]" value="{{ $priceswithcategory->sku }}"/>
                              </div>
                           </div>
                           <div class="from-group col-lg-6  mb-2">
                              <label for="" >{{ __('Weight :') }} </label>
                              <div >
                                 <input type="number" step="any" class="form-control" name="childattribute[priceoption][{{$priceswithcategory->id}}][weight]" value="{{ $priceswithcategory->weight }}"/>
                              </div>
                           </div>
                           <div class="from-group col-lg-6  mb-2">
                              <label for="" >{{ __('Manage Stock ?') }} </label>
                              <div >
                                 <select class="form-control selectric" name="childattribute[priceoption][{{$priceswithcategory->id}}][stock_manage]">
                                    <option value="1" @if($priceswithcategory->stock_manage == 1) selected @endif>{{ __('Yes') }}</option>
                                    <option value="0" @if($priceswithcategory->stock_manage == 0) selected @endif>{{ __('No') }}</option>
                                 </select>
                              </div>
                           </div>
                           <div class="from-group col-lg-6  mb-2">
                              <label for="" >{{ __('Stock Status:') }} </label>
                              <div >
                                 <select class="form-control selectric" name="childattribute[priceoption][{{$priceswithcategory->id}}][stock_status]">
                                    <option value="1" @if($priceswithcategory->stock_status == 1) selected @endif>{{ __('In Stock') }}</option>
                                    <option value="0" @if($priceswithcategory->stock_status == 0) selected @endif>{{ __('Out Of Stock') }}</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
      <div class="from-group  mb-2">
         <button class="btn btn-primary basicbtn col-lg-2 float-left" type="submit"><i class="far fa-save"></i> {{ __('Update') }}</button>

          <button class="btn btn-primary col-lg-3 float-right add_more_attribute" type="button"><i class="fas fa-plus"></i> {{ __('Add More variation') }}</button>
      </div>
   </form>
</div>
<input type="hidden" id="max_short" value="{{ count($info->productoptionwithcategories) }}">
<input type="hidden" id="parentattributes" value="{{ $attributes }}" />
@endsection

@push('script')
<script src="{{ asset('admin/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/js/product-price.js?v=1') }}"></script>

@endpush