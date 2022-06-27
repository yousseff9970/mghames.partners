@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" class="ajaxform" enctype="multipart/form-data" action="{{ route('seller.settings.update') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger none">
                    <ul id="errors">

                    </ul>
                    </div>
                    <div class="alert alert-success none">
                            <ul id="success">

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="mb-20">{{ __('Edit Genaral Settings') }}</h4>
                        <div class="custom-form">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" required placeholder="Enter User's  Name" value="{{ Auth::User()->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="text" name="email" id="email" class="form-control" required placeholder="Enter Email"  value="{{ Auth::User()->email }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-info">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="mb-20">{{ __('Change Password') }}</h4>
                        <div class="custom-form">
                            <div class="form-group">
                                <label for="oldpassword">{{ __('Old Password') }}</label>
                                <input type="password" name="old_password" id="oldpassword" class="form-control"  placeholder="Enter Old Password">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('New Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control"  placeholder="Enter New Password">
                            </div>
                            <div class="form-group">
                                <label for="password1">{{ __('Enter Again Password') }}</label>
                                <input type="password" name="password_confirmation" id="password1" class="form-control"  placeholder="Enter Again">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Change') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
    
        </form>
    </div>
</div>
@endsection