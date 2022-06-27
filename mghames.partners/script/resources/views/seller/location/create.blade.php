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
   <a href="{{ url('seller/location') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i></a>
   <h1>{{ __('Create Location') }}</h1>
</div>
{{-- /section title --}}
<div class="row">
   <div class="col-lg-12">
      <form class="ajaxform_with_reset" method="post" action="{{ route('seller.location.store') }}">
                @csrf
         <div class="row">
            {{-- left side --}}
            <div class="col-lg-5">
                <h6>{{ __('Image') }}</h6>
                <strong>{{ __('Upload your location image here') }}</strong>
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
               <p>{{ __('Add your location details and necessary information from here') }}}</p>
            </div>
            {{-- /left side --}}
            {{-- right side --}}
            <div class="col-lg-7">
               <div class="card">
                  <div class="card-body">
                      <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Name :') }}  </label>
                                <div class="col-lg-12">
                                    <input type="text" name="name" class="form-control" placeholder="Enter Location Name">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Latitude :') }}  </label>
                                <div class="col-lg-12">
                                    <input type="number" step="any" name="lat" class="form-control" placeholder="Enter Latitude">
                                </div>
                            </div>
                           <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Longitude :') }}  </label>
                                <div class="col-lg-12">
                                    <input type="number" step="any" name="long" class="form-control" placeholder="Enter Longitude">
                                </div>
                            </div>
                            
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Location Range :') }} </label>
                                <div class="col-lg-12">
                                    <input type="number" step="any" name="range" class="form-control" placeholder="Enter Range">
                                </div>
                            </div>
                            
                             <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Is Featured ?') }} : </label>
                                <div class="col-lg-12">
                                    <select name="featured"  class="form-control">
                                       <option value="1">{{ __('Yes') }}</option>
                                       <option value="0" selected="">{{ __('No') }}</option>
                                    </select>
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


