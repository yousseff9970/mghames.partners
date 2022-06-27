@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h4>{{ __('My Information') }}</h4>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('My Information') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rider.settings.update') }}" method="POST" class="ajaxform">
                            @csrf 
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ __('Enter Your Name') }}" name="name" value="{{ Auth::User()->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="email">{{ __('Email') }}</label>
                                        <input type="email" class="form-control" placeholder="{{ __('Enter Email Address') }}" name="email" value="{{ Auth::User()->email }}">
                                    </div>
                                </div>
                                <br><br><br><br>    
                                <div class="col-lg-12">
                                    <strong>{{ __('Password Change') }}</strong>
                                </div>
                                <br><br>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{ __('Current Password') }}</label>
                                        <input type="password" class="form-control" name="current_password" placeholder="{{ __('Current Password') }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{ __('Password') }}</label>
                                        <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{ __('Confirmation Password') }}</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirmation Password') }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="button-btn">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection