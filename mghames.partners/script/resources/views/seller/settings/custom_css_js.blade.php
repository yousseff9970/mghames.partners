@extends('layouts.backend.app')

@section('content')
<section class="section">
<div class="section-header">
   <h1>{{ __('Additional Css & Js') }}</h1>
</div>    
<div class="row">
   <div class="col-lg-12">
    
         <div class="row">
            {{-- left side --}}
            <div class="col-lg-5">
               <strong>{{ __('Custom css and js') }}</strong>
               <p>{{ __('Add your custom css and js code from here') }}</p>
            </div>
            {{-- /left side --}}
            {{-- right side --}}
            <div class="col-lg-7">
               <div class="card">
                  <div class="card-body">
                     <form action="{{ route('seller.custom_css_js.update') }}" method="POST" class="ajaxform">
                    @csrf 
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="css">{{ __('Additional Css') }}</label>
                                <textarea name="css" id="css" cols="30" rows="15" class="form-control">{{ $css }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="js">{{ __('Additional Js') }} </label>
                                <textarea name="js" id="js" cols="30" rows="15" class="form-control">{{ $js }}</textarea>
                                <small>{{ __('Write your js code without <script> </script> tags') }}</small>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary  basicbtn">{{ __('Update') }}</button>
                        </div>
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