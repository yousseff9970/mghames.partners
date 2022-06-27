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
      <a href="{{ url('seller/brand') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
      </a>
      <h1>{{ __('Edit Brand') }}</h1>
   </div>
   {{-- /section title --}}
   <div class="row">
      <div class="col-lg-12">
         <form class="ajaxform" method="post" action="{{ route('seller.category.update',$info->id) }}">
            @csrf
            @method("PUT")
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <strong>{{ __('Image') }}</strong>
                  <p>{{ __('Upload brand image here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                        {{mediasection(['value'=>$info->preview->content ?? '','preview'=> $info->preview->content ?? 'admin/img/img/placeholder.png'])}}
                     </div>
                  </div>
               </div>
               {{-- /right side --}}
            </div>
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <strong>{{ __('Information') }}</strong>
                  <p>{{ __('Edit your brand details and necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                         <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Name') }} : </label>
                                <div class="col-lg-12">
                                    <input value="{{ $info->name }}" type="text" name="name" class="form-control" placeholder="Enter Brand Name">
                                </div>
                            </div>
                             <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Slug') }} : </label>
                                <div class="col-lg-12">
                                    <input value="{{ $info->slug }}" type="text" name="slug" class="form-control" placeholder="Enter Brand Slug">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Description :') }} </label>
                                <div class="col-lg-12">
                                    <textarea  name="description" class="form-control h-150">{{ $info->description->content ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                              <label for="" class="col-lg-12">{{ __('Is Featured ?') }} : </label>
                              <div class="col-lg-12">
                                 <select name="featured"  class="form-control">
                                    <option value="1" @if($info->featured == 1) selected @endif>{{ __('Yes') }}</option>
                                    <option value="0" @if($info->featured == 0) selected @endif>{{ __('No') }}</option>
                                 </select>
                              </div>
                           </div>
                            <input type="hidden" name="type" value="{{ $info->type }}">
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



