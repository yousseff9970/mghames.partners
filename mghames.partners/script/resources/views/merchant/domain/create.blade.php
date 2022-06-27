@extends('layouts.backend.app')

@section('title','Add Store')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Create Store'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>{{ __('Create A New Store') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('merchant.domain.store') }}" method="POST" class="ajaxform">
                @csrf
                <div class="store-card">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="store-section">
                                <h5>{{ __('Login Information') }}</h5>
                                <p>{{ __("Give your store a name and enter the password you want to use to log in to the store directly. You'll use your business email address to log in: ") }} {{ Auth::user()->email }}</p><br>

                                <p><b>{{ __('Default Credentials') }}</b></p>
                                <p>{{ __('Email: store@email.com') }}</p>
                                <p>{{ __('Password: 12345678') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group mb-4">
                                <label>{{ __('Store Name') }}</label>
                                <input type="text" id="store_name" name="store_name" class="form-control" placeholder="Enter Store Name Without Space">
                            </div>
                            @if (env('SUBDOMAIN_TYPE') == 'real')
                            <div class="form-group mb-4">
                                <label>{{ __('Store URL') }}</label>
                                <div class="">
                                    <div class="store-url-section">
                                        <input readonly="" type="text" id="store_url" class="form-control">
                                        <div class="store-domain-name">
                                            <span>.{{ env('APP_PROTOCOLESS_URL') }}</span>
                                        </div>
                                    </div>
                                    <div class="store-url-danger"></div>
                                </div>
                            </div>
                            @else 
                            <div class="form-group mb-4">
                                <label>{{ __('Store URL') }}</label>
                                <div class="">
                                    <div class="store-url-section">
                                        <input readonly="" type="text" id="store_url" class="form-control url-with-tenant">
                                        <div class="store-domain-left-name">
                                            <span>{{ env('APP_URL_WITH_TENANT') }}</span>
                                        </div>
                                    </div>
                                    <div class="store-url-danger"></div>
                                </div>
                            </div>
                            @endif
                            <div class="form-group  mb-4">
                                <label>{{ __('Email') }}</label>
                                <div class="">
                                    <input type="text" name="email" class="form-control" value="{{ Auth::User()->email }}">
                                </div>
                            </div>
                            <div class="form-group  mb-4">
                                <label>{{ __('Password') }}</label>
                                <div class="">
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group  mb-4">
                                <label>{{ __('Confirm Password') }}</label>
                                <div class="">
                                    <input name="password_confirmation" type="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group  mb-0">
                                <label>{{ __('DataBase') }}</label>
                                <div class="">
                                    <select name="db[]"   class="form-control selectric">
                                        <option value="pizza" >pizza</option>
                                        <option value="burger" >pizza</option>
                                        
                                        
                                       
                                     </select>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="store-card">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="cancel-btn">
                                <a href="{{ route('merchant.domain.list') }}" class="btn btn-info btn-lg">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="button-btn float-right">
                                <button class="btn btn-primary btn-lg">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{ asset('admin/js/merchant.js') }}"></script>
    <script>
        "use strict";
        function success()
        {
           var url=$('#base_url').val();
            window.location.href = url+'/partner/domain/select/plan';
            
        }
    </script>
@endpush