@extends('layouts.backend.app')

@section('content')
<section class="section">
<div class="section-header">
   <h1>{{ __('PWA Settings') }}</h1>
</div>    
<div class="row">
   <div class="col-lg-12">
         <div class="row">
            {{-- left side --}}
            <div class="col-lg-5">
               <strong>{{ __('Progressive Web App Configuration') }}</strong>
               <p>{{ __('Add your pwa details and necessary information from here') }}</p>
            </div>
            {{-- /left side --}}
            {{-- right side --}}
            <div class="col-lg-7">
               <div class="card">
                  <div class="card-body">
                     <form method="post" action="{{ route('seller.pwa.update') }}" enctype="multipart/form-data" class="ajaxform">
                        @csrf                     
                        <div class="form-group">
                            <label>{{ __('APP Title') }}</label>
                            <input class="form-control" name="pwa_app_title" value="{{ $pwa->name ?? '' }}" type="text" required="">
                        </div>
                        <div class="form-group">
                            <label>{{ __('App Name (Short Name)') }}</label>
                            <input class="form-control" name="pwa_app_name" value="{{ $pwa->short_name ?? '' }}" type="text" required="">
                        </div>
                        <div class="form-group">
                            <label>{{ __('APP Background Color (Dont use color code)') }}</label>
                            <input class="form-control" name="pwa_app_background_color" value="{{ $pwa->background_color ?? '' }}" type="text" required="">
                        </div>
                        <div class="form-group">
                            <label>{{ __('APP Theme Color') }}</label>
                            <input class="form-control" name="pwa_app_theme_color" value="{{ $pwa->theme_color ?? '' }}" type="text" required="">
                        </div>
                        <div class="form-group">
                            <label>{{ __('APP Main Language') }}</label>
                            <input class="form-control" name="app_lang" value="{{ $pwa->lang ?? '' }}" type="text" required="" placeholder="en-US">
                            <small>{{ __('Example: en-US') }}</small>
                        </div>
                        <div class="form-group">
                            <label>{{ __('App Icon 128x128') }}</label>
                            <input class="form-control" name="app_icon_128x128" type="file" accept="image/.png">
                        </div>
                        <div class="form-group">
                            <label>{{ __('App Icon 144x144') }}</label>
                            <input class="form-control" name="app_icon_144x144" type="file" accept="image/.png">
                        </div>
                        <div class="form-group">
                            <label>{{ __('App Icon 152x152') }}</label>
                            <input class="form-control" name="app_icon_152x152" type="file" accept="image/.png">
                        </div>
                        <div class="form-group">
                            <label>{{ __('App Icon 192x192') }}</label>
                            <input class="form-control" name="app_icon_192x192" type="file" accept="image/.png">
                        </div>
                        <div class="form-group">
                            <label>{{ __('App Icon 512x512') }}</label>
                            <input class="form-control" name="app_icon_512x512" type="file" accept="image/.png">
                        </div>
                        <div class="form-group">
                            <label>{{ __('App Icon 256x256') }}</label>
                            <input class="form-control" name="app_icon_256x256" type="file" accept="image/.png">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-left basicbtn">{{ __('Update') }}</button> 
                        </div>
                    </form>
                  </div>
               </div>
            </div>
         </div>
    </div>
</div>
</section>
@endsection