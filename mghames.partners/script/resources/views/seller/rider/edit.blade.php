@extends('layouts.backend.app')

@push('css')
<!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush

@section('title','Dashboard')

@section('content')
<section class="section">
    {{-- section title --}}
    <div class="section-header">
        <a href="{{ url('seller/rider') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Edit Rider') }}</h1>
    </div>
    {{-- /section title --}}
    <div class="row">
    <div class="col-lg-12">
        <form class="ajaxform" method="post" action="{{ route('seller.rider.update',$user->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                {{-- left side --}}
                <div class="col-lg-5">
                <strong>{{ __('Information') }}</strong>
                    <p>{{ __('Edit your rider details and necessary information from here') }}</p>
                </div>
                {{-- /left side --}}
                {{-- right side --}}
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('User Name:') }} </label>
                                <div class="col-lg-12">
                                    <input type="text" required name="name" class="form-control" placeholder="Enter User Name" value="{{ $user->name }}">
                                </div>
                            </div>
                                <div class="from-group row mb-2">
                                    <label for="" class="col-lg-12">{{ __('Email:') }} </label>
                                    <div class="col-lg-12">
                                        <input type="email" required name="email" class="form-control" placeholder="Enter Email Address" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="from-group row mb-2">
                                    <label for="" class="col-lg-12">{{ __('Password:') }} </label>
                                    <div class="col-lg-12">
                                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                                    </div>
                                </div>
                                <div class="from-group row mb-2">
                                    <label for="" class="col-lg-12">{{ __('Confirmation Password:') }} </label>
                                    <div class="col-lg-12">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Enter Confirmation Password">
                                    </div>
                                </div>
                                <div class="from-group row mb-2">
                                    <label for="" class="col-lg-12">{{ __('Status') }} </label>
                                    <div class="col-lg-12">
                                        <select class="form-control" name="status">
                                            <option {{ $user->status == 1 ? 'selected' : '' }} value="1">{{ __('Enable') }}</option>
                                            <option {{ $user->status == 0 ? 'selected' : '' }} value="0">{{ __('Disable') }}</option>
                                        </select>
                                    </div>
                                </div>
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


