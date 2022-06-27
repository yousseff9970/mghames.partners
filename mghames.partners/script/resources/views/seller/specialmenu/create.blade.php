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
   <a href="{{ url('seller/special-menu') }}" class="btn btn-primary mr-2">
   <i class="fas fa-arrow-left"></i>
   </a>
   <h1>{{ __('Create Day') }}</h1>
</div>
{{-- /section title --}}
<div class="row">
   <div class="col-lg-12">
     <form class="ajaxform_with_reset" method="post" action="{{ route('seller.special-menu.store') }}">
                @csrf
         <div class="row">
            {{-- left side --}}
            <div class="col-lg-5">
               <strong>{{ __('Image') }}</strong>
               <p>{{ __('Upload menu image here') }}</p>
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
               <p>{{ __('Add your menu details and necessary information from here') }}</p>
            </div>
            {{-- /left side --}}
            {{-- right side --}}
            <div class="col-lg-7">
               <div class="card">
                  <div class="card-body">
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Title :') }} </label>
                        <div class="col-lg-12">
                           <input type="text" name="name" class="form-control" required="" maxlength="100">
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Days :') }} </label>
                        <div class="col-lg-12">
                           <input type="text" name="days" placeholder="Monday - Saturday" class="form-control" required="" maxlength="20">
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Time :') }} </label>
                        <div class="col-lg-12">
                           <input type="text" name="time" placeholder="09:00AM - 18:00PM" class="form-control" required="" maxlength="50">
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Additional Link :') }} </label>
                        <div class="col-lg-12">
                           <input type="text"  name="link"  class="form-control" >
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Short :') }} </label>
                        <div class="col-lg-12">
                           <input type="number" min="0" name="short" value="0" class="form-control" placeholder="enter short number">
                        </div>
                     </div>
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


