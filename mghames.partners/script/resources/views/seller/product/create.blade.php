@extends('layouts.backend.app')

@push('css')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/select2.min.css') }}">
@endpush

@section('title','Dashboard')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Create Product','prev'=> url('seller/product')])
@endsection

@section('content')
<section class="section">
   <div class="row">
      <div class="col-lg-12">
         <form class="ajaxform_with_reset" method="post" action="{{ route('seller.product.store') }}">
            @csrf
            {{-- Featured Image --}}
            <div class="row">
               {{-- left side --}}
            <div class="col-lg-4">
                  <strong>{{ __('Featured Image') }}</strong>
                  <p>{{ __('Upload your product image here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-8">
                  <div class="card card-primary">
                     <div class="card-body">
                        {{mediasection()}}
                     </div>
                  </div>
               </div>
               {{-- /right side --}}
            </div>
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-4">
                  <strong>{{ __('Information') }}</strong>
                  <p>{{ __('Add your product details and necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-8">
                  <div class="card card-primary">
                     <div class="card-body">
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Name :') }} </label>
                           <div class="col-lg-12">
                              <input  type="text" name="name" class="form-control" placeholder="Enter Product Name">
                           </div>
                        </div>
                     <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Short Description :') }} </label>
                           <div class="col-lg-12">
                              <textarea  name="short_description" maxlength="500" class="form-control h-150"></textarea>
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Select Featured Type') }} : </label>
                           <div class="col-lg-12">
                              <select name="categories[]"   class="form-control selectric">
                              @foreach($features as $row)
                              <option value="{{ $row->id }}">{{ $row->name }}</option>
                              @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Status') }} : </label>
                           <div class="col-lg-12">
                              <select name="status"  class="form-control selectric">
                                 <option value="1">{{ __('Publish') }}</option>
                                 <option value="0">{{ __('Draft') }}</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            {{-- Gallery --}}
            <div class="row">
               {{-- left side --}}
            <div class="col-lg-4">
                  <strong>{{ __('Categories & Brands') }}</strong>
                  <p>{{ __('Select product brand and categories from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-8">
                  <div class="card card-primary">
                     <div class="card-body">
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Select Product Category') }} : </label>
                           <div class="col-lg-12">
                              <select name="categories[]" multiple="" class="select2 form-control">
                              
                              {{NastedCategoryList('category')}}
                              </select>
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Select Product Brand') }} : </label>
                           <div class="col-lg-12">
                              <select name="categories[]"  class="selectric form-control">
                              <option disabled="" value="" selected="">{{ __('Select Brand') }}</option>
                              {{NastedCategoryList('brand')}}
                              </select>
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Select Product Tags') }} : </label>
                           <div class="col-lg-12">
                              <select name="categories[]" multiple=""  class="form-control select2">
                              {{NastedCategoryList('tag')}}
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               {{-- /right side --}}
            </div>
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-4">
                  <strong>{{ __('Product Type') }}</strong>
                  <p>{{ __('Select product type form here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-8">
                  <div class="card card-primary">
                     <div class="card-body">
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Product Type') }} : </label>
                           <div class="col-lg-12">
                              <select name="product_type"  class="form-control product_type ">
                                 <option value="0">{{ __('Simple Product') }}</option>
                                 <option value="1">{{ __('Variation Product') }}</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row single_product_price_area">
               {{-- left side --}}
               <div class="col-lg-4">
                  <strong>{{ __('Simple Product Information') }}</strong>
                  <p>{{ __('Add your simple product description and necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-8">
                  <div class="card card-primary">
                     <div class="card-body">
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Product Price') }} : </label>
                           <div class="col-lg-12">
                              <input type="number" step="any" class="form-control" name="price">
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Quantity') }} : </label>
                           <div class="col-lg-12">
                              <input type="number" class="form-control" name="qty">
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('SKU') }} : </label>
                           <div class="col-lg-12">
                              <input type="text" class="form-control" name="sku">
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Weight') }} : </label>
                           <div class="col-lg-12">
                              <input type="number" step="any" class="form-control" name="weight">
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Stock manage') }} : </label>
                           <div class="col-lg-12">
                              <select name="stock_manage" class="form-control selectric">
                                 <option value="1">{{ __('Yes') }}</option>
                                 <option value="0">{{ __('No') }}</option>
                              </select>
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Stock Status') }} : </label>
                           <div class="col-lg-12">
                              <select name="stock_status" class="form-control selectric">
                                 <option value="1" >{{ __('In Stock') }}</option>
                                 <option value="0" >{{ __('Out Of Stock') }}</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="card-footer">
                           <button class="btn btn-primary mt-2 basicbtn" type="submit">{{ __('Create Product') }}</button>
                        </div>
                  </div>
               </div>
            </div>
            <div class="row variation_select_area " style="display:none">
               {{-- left side --}}
               <div class="col-lg-4">
                  <strong>{{ __('Product Variation Information') }}</strong>
                  <p>{{ __('Add your product variation and necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-8">
                  <div class="card card-primary">
                     <div class="attribute_render_area">
                     </div>
                     <button class="btn btn-primary col-sm-12 add_more_attribute" type="button"><i class="fa fa-plus"></i> {{ __('Add More') }}</button>

                     <button class="btn btn-primary mt-2 basicbtn" type="submit">{{ __('Create Product') }}</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</section>
{{ mediasingle() }} 
<input type="hidden" id="parentattributes" value="{{ $attributes }}" />
@endsection

@push('script')
 <!-- JS Libraies -->
<script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('admin/plugins/dropzone/components-multiple-upload.js') }}"></script>
<script src="{{ asset('admin/js/media.js') }}"></script>
<script src="{{ asset('admin/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/js/product-create.js') }}"></script>
@endpush

