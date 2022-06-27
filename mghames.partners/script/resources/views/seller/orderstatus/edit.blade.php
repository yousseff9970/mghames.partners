@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section class="section">
   {{-- section title --}}
    <div class="section-header">
        <a href="{{ url('seller/orderstatus') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Edit Status') }}</h1>
    </div>
   {{-- /section title --}}
   <div class="row">
      <div class="col-lg-12">
          <form class="ajaxform" method="post" action="{{ route('seller.category.update',$info->id) }}">
                @csrf
                @method('PUT')
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <strong>{{ __('Information') }}</strong>
                  <p>{{ __('Edit your order status necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                        <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Name') }} : </label>
                                <div class="col-lg-12">
                                    <input type="text" name="name" value="{{ $info->name }}" class="form-control" placeholder="Enter Status Name">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Badge Color') }} : </label>
                                <div class="col-lg-12">
                                    <input type="color" name="slug" value="{{ $info->slug }}" class="form-control" >
                                </div>
                            </div>
                             <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{__('Short :')}} </label>
                                <div class="col-lg-12">
                                    <input type="number" name="featured" class="form-control" value="{{ $info->featured }}">
                                </div>
                            </div>

                          
                            <input type="hidden" name="type" value="status">
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




