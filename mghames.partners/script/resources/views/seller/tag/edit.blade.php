@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section class="section">
   {{-- section title --}}
   <div class="section-header">
      <a href="{{ url('seller/tag') }}" class="btn btn-primary mr-2">
      <i class="fas fa-arrow-left"></i>
      </a>
      <h1>{{ __('Edit Tag') }}</h1>
   </div>
   {{-- /section title --}}
   <div class="row">
      <div class="col-lg-12">
         <form action="{{ route('seller.tag.update',$info->id) }}" class="ajaxform">
             @csrf
             @method('PUT')
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <strong>{{ __('Information') }}</strong>
                  <p>{{ __('Edit your tag details and necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                       <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Tag Name') }} : </label>
                                <div class="col-lg-12">
                                    <input type="text" name="tag_name" required class="form-control" placeholder="name" value="{{ $info->name }}">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Slug') }} : </label>
                                <div class="col-lg-12">
                                    <input type="text" name="slug" required class="form-control" placeholder="slug" value="{{ $info->slug }}">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Is Featured') }} : </label>
                                <div class="col-lg-12">
                                    <select name="is_featured" id="" class="form-control">
                                        <option value="1" @if($info->featured == 1) selected="" @endif >{{ __('Yes') }}</option>
                                        <option value="0" @if($info->featured != 1) selected="" @endif >{{ __('No') }}</option>
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
@endsection



