@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Create Store','prev'=>route('admin.store.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('Create New Store') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.store.store') }}" class="ajaxform">
                    @csrf
                    <div class="store-card">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="store-section">
                                    <h5>{{ __('Login Information') }}</h5>
                                    <p>{{ __("Give your store a name and enter the password you want to use to log in to the store directly. You'll use your business email address to log in: ") }} {{ Auth::User()->email }}</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group mb-4">
                                    <label>{{ __('Store Name') }}</label>
                                    <input type="text" id="store_name" name="store_id" class="form-control" placeholder="Store Name">
                                </div>
                                <div class="form-group mb-4">
                                    <label
                                    class="col-form-label">{{ __('User Email') }}</label>
                                        <input type="email" class="form-control"
                                        placeholder="Customer Email" required name="user_email" required>
                                </div>
                                <div class="form-group  mb-4">
                                    <label>{{ __('Password') }}</label>
                                    <div class="">
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group  mb-0">
                                    <label>{{ __('Confirm Password') }}</label>
                                    <div class="">
                                        <input name="password_confirmation" type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="store-card">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="store-section">
                                    <h5>{{ __('Additional Information') }}</h5>
                                    <p>{{ __("Please fill up all input section.") }}</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Select Plan</label>
                                    <select name="plan" class="form-control">
                                        @foreach ($plans as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>    
                                        @endforeach                           
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="col-form-label">{{ __('Select Getaway') }}</label>
                                    <select name="getaway" class="form-control">
                                        @foreach($getaways as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="col-form-label">{{ __('Payment Id') }}</label>
                                        <input type="text" class="form-control"
                                        placeholder="TRX ID" required name="trx" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="col-form-label">{{ __('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                                @if(env('AUTO_DB_CREATE') == false)           
                                <div class="form-group row mb-4">
                                    <label
                                    class="col-form-label">{{ __('Database Name') }}</label>
                                    <div class="">
                                        <input type="text" class="form-control"
                                        placeholder="Database name" required name="db_name" required>     
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label
                                    class="col-form-label">{{ __('Database Username') }}</label>
                                    <div class="">
                                        <input type="text" class="form-control"
                                        placeholder="Database Username" required name="db_username" required>     
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label
                                    class="col-form-label">{{ __('Database Password') }}</label>
                                    <div class="">
                                        <input type="text" class="form-control"
                                        placeholder="Database Password" name="db_password" >     
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label
                                    class="col-form-label">{{ __('Migrate Database Now') }}</label>
                                    <div class="">
                                        <select name="migrate" class="form-control">
                                            <option value="yes">{{ __('Yes') }}</option>
                                            <option value="no">{{ __('No') }}</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="store-card">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="store-section">
                                    <h6>{{ __('Store address') }}</h6>
                                    <p>{{ __('Let us know where your store is located.') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group  mb-4">
                                    <label>{{ __('Address') }}</label>
                                    <div class="">
                                        <input type="text" name="address" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group  mb-4">
                                            <label>{{ __('City') }}</label>
                                            <div class="">
                                                <input type="text" name="city" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group  mb-4">
                                            <label>{{ __('Postal / ZIP code') }}</label>
                                            <div class="">
                                                <input type="number" class="form-control" name="postal_code">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group  mb-0">
                                    <label>{{ __('Country') }}</label>
                                    @php
                                        $countrylists = file_get_contents(resource_path('lang/countrylist.json'));
                                        $countries = json_decode($countrylists);
                                    @endphp
                                    <div class="">
                                        <select class="form-control" name="country">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->code }}">{{ $country->name }}</option>
                                            @endforeach
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
                                    <input type="hidden" value="{{ route('admin.store.index') }}" id="store_list_url">
                                    <button class="btn btn-primary btn-lg">{{ __('Submit') }}</button>
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
 <script src="{{ asset('admin/js/domain/create.js') }}"></script>
@endpush