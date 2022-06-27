@extends('layouts.backend.app')

@section('content')
<div class="card">
    <div class="card-body">
       <div class="row">
        <div class="col-md-12">
            </div>
            <div class="col-md-6">
                <form method="post" id="ajaxform"  action="{{ route('admin.users.genupdate') }}">
                    @csrf
                    <h4 class="mb-20">{{ __('Edit Genaral Settings') }}</h4>
                    <div class="custom-form">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" required placeholder="Enter User's  Name" value="{{ $info->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="text" name="email" id="email" class="form-control" required placeholder="Enter Email"  value="{{ $info->email }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info basicbtn">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <form method="post" class="ajaxform_with_reset" action="{{ route('admin.users.passup') }}">
                    @csrf
                    <h4 class="mb-20">{{ __('Change Password') }}</h4>
                    <div class="custom-form">
                        <div class="form-group">
                            <label for="oldpassword">{{ __('Old Password') }}</label>
                            <input type="password" name="current" id="oldpassword" class="form-control"  placeholder="Enter Old Password" required>
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('New Password') }}</label>
                            <input type="password" name="password" id="password" class="form-control"  placeholder="Enter New Password" required>
                        </div>
                        <div class="form-group">
                            <label for="password1">{{ __('Enter Again Password') }}</label>
                            <input type="password" name="password_confirmation" id="password1" class="form-control"  placeholder="Enter Again" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Change') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
