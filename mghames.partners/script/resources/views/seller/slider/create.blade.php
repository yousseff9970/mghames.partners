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
        <a href="{{ url('seller/slider') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Create Slider') }}</h1>
    </div>
{{-- /section title --}}
<div class="row">
   <div class="col-lg-12">
       <form class="ajaxform_with_reset" method="post" action="{{ route('seller.slider.store') }}">
                @csrf
         <div class="row">
            {{-- left side --}}
            <div class="col-lg-5">
               <strong>{{ __('Image') }}</strong>
               <p>{{ __('Upload slider image here') }}</p>
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
               <strong>{{ __('Information') }}</strong>
                <p>{{ __('Add your slider details and necessary information from here') }}</p>
            </div>
            {{-- /left side --}}
            {{-- right side --}}
            <div class="col-lg-7">
               <div class="card">
                  <div class="card-body">
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Title') }} </label>
                        <div class="col-lg-12">
                           <input type="text" required name="name" class="form-control">
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Description') }} </label>
                        <div class="col-lg-12">
                           <textarea class="form-control h-150" name="description"></textarea>
                        </div>
                     </div>
                  
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Slider Link') }} </label>
                        <div class="col-lg-12">
                           <input type="text" required name="link" class="form-control">
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Button Title') }} </label>
                        <div class="col-lg-12">
                           <input type="text" required name="button_text" class="form-control">
                        </div>
                     </div>
                     <input type="hidden" name="type" value="slider">
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

