@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Google Analytics'])
@endsection

@section('title','Dashboard')

@section('content')
<section class="section">
   <div class="row">
      <div class="col-lg-12">
         <form class="ajaxform" method="post" action="{{ route('seller.google-analytics.store') }}" enctype="multipart/form-data">
            @csrf
         <div class="row">
            {{-- left side --}}
            <div class="col-lg-5">
               <strong>{{ __('Google Analytics') }}</strong>
               <p>{{ __('Configure your google analytics for traffic view') }}</p>
            </div>
            {{-- /left side --}}
            {{-- right side --}}
            <div class="col-lg-7">
               <div class="card">
                  <div class="card-body">
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12"><a href="https://developers.google.com/analytics/devguides/collection/gtagjs" target="_blank">{{ __('GA_MEASUREMENT_ID :') }}</a></label>
                        <div class="col-lg-12">
                           <input type="text" name="ga_measurement_id" required="" class="form-control" placeholder="UA-123456789" value="{{ $info->ga_measurement_id ?? '' }}">
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('ANALYTICS VIEW ID :') }}</label>
                        <div class="col-lg-12">
                        
                           <input type="text" class="form-control" required="" name="analytics_view_id" placeholder="12345678" value="{{ $info->analytics_view_id ?? '' }}">
                        </div>
                     </div>
                     <div class="from-group row mb-2">
                        <label for="" class="col-lg-12">{{ __('service-account-credentials.json :') }} </label>
                        <div class="col-lg-12">
                           <input type="file" name="file" class="form-control" accept=".json">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-12">
                           <button class="btn btn-primary basicbtn mt-2" type="submit">{{ __('Update') }}</button>
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



