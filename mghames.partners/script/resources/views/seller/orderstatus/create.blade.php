@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section class="section">
   {{-- section title --}}
   <div class="section-header">
        <a href="{{ url('seller/orderstatus') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Create Order Status') }}</h1>
    </div>
   {{-- /section title --}}
   <div class="row">
      <div class="col-lg-12">
          <form class="ajaxform_with_reset" method="post" action="{{ route('seller.category.store') }}">
                @csrf
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <strong>{{ __('Information') }}</strong>
                  <p>{{ __('Add your order status necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                        <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Name :') }} </label>
                                <div class="col-lg-12">
                                    <input type="text" name="name" class="form-control" placeholder="{{ __('Enter Status Name') }}">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Badge Color :') }} </label>
                                <div class="col-lg-12">
                                    <input type="color" name="slug" class="form-control" >
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{__('Short :')}} </label>
                                <div class="col-lg-12">
                                    <input type="number" name="featured" class="form-control" >
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



