@extends('layouts.backend.app')

@push('css')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/select2.min.css') }}">
@endpush

@section('title','Dashboard')

@section('content')
<section class="section">
   {{-- section title --}}
   <div class="section-header">
      <a href="{{ url('seller/shipping') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Edit Shipping') }}</h1>
   </div>
   {{-- /section title --}}
   <div class="row">
      <div class="col-lg-12">
         <form class="ajaxform" method="post" action="{{ route('seller.shipping.update',$info->id) }}">
                @csrf
                @method('PUT')
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                   <h6>{{ __('Image') }}</h6>
                    <strong>{{ __('Upload your shipping image here') }}</strong>
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
                   <strong>{{ __('Description') }}</strong>
                   <p>{{ __('Add your shipping details and necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                        <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Name :') }} </label>
                                <div class="col-lg-12">
                                    <input type="text" value="{{ $info->name }}" name="name" class="form-control" placeholder="Enter Shipping Name">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Price :') }} </label>
                                <div class="col-lg-12">
                                    <input type="number" value="{{ $info->slug }}" required="" value="0" step="any" name="price" class="form-control" placeholder="Enter Price">
                                </div>
                            </div>
                             <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{__('Select Locations :')}} </label>
                                <div class="col-lg-12">
                                   <select name="locations[]" multiple="" class="select2 form-control">
                                    @foreach($posts as $row)
                                       <option value="{{ $row->id }}" @if(in_array($row->id,$location_array)) selected @endif>{{ $row->name }}</option>
                                     @endforeach  
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
<script src="{{ asset('admin/js/select2.min.js') }}"></script>
@endpush


