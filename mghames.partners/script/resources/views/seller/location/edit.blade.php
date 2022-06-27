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
     <a href="{{ url('seller/location') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Edit location') }}</h1>
   </div>
   {{-- /section title --}}
   <div class="row">
      <div class="col-lg-12">
          <form class="ajaxform" method="post" action="{{ route('seller.location.update',$info->id) }}">
                @csrf
                @method('PUT')
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <h6>{{ __('Image') }}</h6>
                  <strong>{{ __('Edit your location image here') }}</strong>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                        {{mediasection(['value'=>$info->avatar ?? '','preview'=> $info->avatar ?? 'admin/img/img/placeholder.png'])}}
                     </div>
                  </div>
               </div>
               {{-- /right side --}}
            </div>
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <strong>{{ __('Description') }}</strong>
                 <p>{{ __('Edit location details and necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                         <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Name') }} : </label>
                                <div class="col-lg-12">
                                    <input type="text" value="{{ $info->name }}" name="name" class="form-control" placeholder="Enter Location Name">
                                </div>
                            </div>
                             <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Slug') }} : </label>
                                <div class="col-lg-12">
                                    <input type="text" value="{{ $info->slug }}" name="slug" class="form-control" placeholder="Enter Location slug">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Latitude') }} : </label>
                                <div class="col-lg-12">
                                    <input type="number" value="{{ $info->lat }}" step="any" name="lat" class="form-control" placeholder="Enter Latitude">
                                </div>
                            </div>

                           <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Longitude') }} : </label>
                                <div class="col-lg-12">
                                    <input type="number" value="{{ $info->long }}" step="any" name="long" class="form-control" placeholder="Enter Longitude">
                                </div>
                            </div>
                            
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Location Range') }} : </label>
                                <div class="col-lg-12">
                                    <input type="number" value="{{ $info->range }}" step="any" name="range" class="form-control" placeholder="Enter Range">
                                </div>
                            </div>
                            
                             <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Is Featured ?') }} : </label>
                                <div class="col-lg-12">
                                    <select name="featured"  class="form-control">
                                       <option value="1" @if($info->featured == 1) selected @endif>{{ __('Yes') }}</option>
                                       <option value="0" @if($info->featured != 1) selected @endif>{{ __('No') }}</option>
                                    </select>
                                </div>
                            </div>
                             <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Status') }} : </label>
                                <div class="col-lg-12">
                                    <select name="status"  class="form-control">
                                       <option value="1" @if($info->status == 1) selected @endif>{{ __('Enable') }}</option>
                                       <option value="0" @if($info->status != 1) selected @endif>{{ __('Disable') }}</option>
                                    </select>
                                </div>
                            </div>
                        <div class="row">
                           <div class="col-lg-12">
                              <input type="hidden" name="type" value="{{ $info->type }}">
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


