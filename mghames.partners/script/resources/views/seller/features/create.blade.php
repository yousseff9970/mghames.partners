@extends('layouts.backend.app')

@push('css')
<!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush

@section('title','Dashboard')

@section('content')
<section class="section">
{{-- section title --}}
<div class="section-header">
   <a href="{{ url('seller/features') }}" class="btn btn-primary mr-2">
   <i class="fas fa-arrow-left"></i>
   </a>
   <h1>{{ __('Create Feature') }}</h1>
</div>
{{-- /section title --}}
<div class="row">
   <div class="col-lg-12">
     <form class="ajaxform_with_reset" method="post" action="{{ route('seller.category.store') }}">
         @csrf
         <div class="row">
            {{-- left side --}}
            <div class="col-lg-5">
               <strong>{{ __('Image') }}</strong>
               <p>{{ __('Upload table image here') }}</p>
            </div>
            {{-- /left side --}}
            {{-- right side --}}
            <div class="col-lg-7">
               <div class="card">
                  <div class="card-body">
                     {{mediasection()}}
                  </div>
               </div>
            </div>
            {{-- /right side --}}
         </div>
         <div class="row">
            {{-- left side --}}
            <div class="col-lg-5">
               <strong>{{ __('Description') }}</strong>
               <p>{{ __('Add your feature details and necessary information from here') }}</p>
            </div>
            {{-- /left side --}}
            {{-- right side --}}
            <div class="col-lg-7">
               <div class="card">
                  <div class="card-body">
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Feature Name :') }} </label>
                        <div class="col-lg-12">
                           <input type="text" name="name" class="form-control" placeholder="Enter Features Name">
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Description :') }} </label>
                        <div class="col-lg-12">
                           <textarea  name="description" class="form-control h-150"></textarea>
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Short :') }} </label>
                        <div class="col-lg-12">
                           <input type="number" min="0" name="menu_status" value="0" class="form-control" placeholder="enter short number">
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Featured On Homepage:') }} : </label>
                        <div class="col-lg-12">
                           <select name="featured"  class="form-control">
                              <option value="1">{{ __('Yes') }}</option>
                              <option value="0" selected="">{{ __('No') }}</option>
                           </select>
                        </div>
                     </div>
                     <input type="hidden" name="type" value="product_feature">
                     <div class="row">
                        <div class="col-lg-12">
                           <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
</section>
{{ mediasingle() }} 
@endsection

@push('script')
 <!-- JS Libraies -->
<script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('admin/plugins/dropzone/components-multiple-upload.js') }}"></script>
<script src="{{ asset('admin/js/media.js') }}"></script>
@endpush


