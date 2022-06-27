@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section class="section">
   {{-- section title --}}
   <div class="section-header">
        <a href="{{ url('seller/notification') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Push notification to the user') }}</h1>
    </div>
   {{-- /section title --}}
   <div class="row">
      <div class="col-lg-12">
          <form class="ajaxform_with_reset" method="post" action="{{ route('seller.notification.update',$id) }}">
                @csrf
                @method('PUT')
            <div class="row">
               {{-- left side --}}
               <div class="col-lg-5">
                  <strong>{{ __('Information') }}</strong>
                  <p>{{ __('Add your push notification necessary information from here') }}</p>
               </div>
               {{-- /left side --}}
               {{-- right side --}}
               <div class="col-lg-7">
                  <div class="card">
                     <div class="card-body">
                        <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Title') }} </label>
                                <div class="col-lg-12">
                                    <input type="text" name="title" class="form-control" placeholder="Enter notification title">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{__('Description')}} </label>
                                <div class="col-lg-12">
                                    <textarea class="h-150 form-control" name="description"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="type" value="status">
                           <div class="row">
                           <div class="col-lg-12">
                              <button class="btn btn-primary basicbtn" type="submit">{{ __('Sent') }}</button>
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



