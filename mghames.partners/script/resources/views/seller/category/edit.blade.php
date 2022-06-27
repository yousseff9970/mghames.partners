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
      <a href="{{ url('seller/category') }}" class="btn btn-primary mr-2">
      <i class="fas fa-arrow-left"></i>
      </a>
      <h1>{{ __('Edit Category') }}</h1>
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
                  <p>{{ __('Upload your category image here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                        {{mediasection([
                        'value'=>$info->preview->content ?? '',
                        'preview'=> $info->preview->content ?? 'admin/img/img/placeholder.png'
                        ])}}
                     </div>
                  </div>
               </div>
               {{-- /right side --}}
            </div>
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <strong>{{ __('Category Icon') }}</strong>
                  <p>{{ __('Upload your category icon image here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                       {{mediasection([
                       'preview_class'=>'category_icon',
                       'input_id'=>'category_icon',
                       'input_class'=>'icon_image',
                       'input_name'=>'icon',
                       'value'=>$info->icon->content ?? '',
                       'preview'=> $info->icon->content ?? 'admin/img/img/placeholder.png'
                       ])}}
                     </div>
                  </div>
               </div>
               {{-- /right side --}}
            </div>
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <strong>{{ __('Information') }}</strong>
                  <p>{{ __('Edit your category details and necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Name') }} : </label>
                           <div class="col-lg-12">
                              <input value="{{ $info->name }}" type="text" name="name" class="form-control" placeholder="Enter Category Name">
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">{{ __('Slug') }} : </label>
                           <div class="col-lg-12">
                              <input value="{{ $info->slug }}" type="text" name="slug" class="form-control" placeholder="Enter Category Slug">
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">Parent Category : </label>
                           <div class="col-lg-12">
                              <select name="category_id"  class="form-control">
                                  <option value="">{{ __('Select Parent Category') }}</option>
                                  {{NastedCategoryList('category',$info->category_id,$info->id)}}
                              </select>
                           </div>
                        </div>
                        <div class="from-group row mb-2">
                           <label for="" class="col-lg-12">Description : </label>
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
                      <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('Add to menu ?') }} : </label>
                        <div class="col-lg-12">
                           <select name="menu_status"  class="form-control">
                              <option value="1" @if($info->menu_status == 1) selected @endif>{{ __('Yes') }}</option>
                              <option value="0" @if($info->menu_status == 0) selected @endif>{{ __('No') }}</option>
                           </select>
                        </div>
                     </div>
                        <div class="row">
                           <div class="col-lg-12">
                              <input type="hidden" name="type" value="{{ $info->type }}">
                              <button class="btn btn-primary basicbtn" type="submit">Save</button>
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


