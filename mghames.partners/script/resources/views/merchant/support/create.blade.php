@extends('layouts.backend.app')

@section('title', 'Support')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Support'])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('merchant.support.store') }}" method="post" class="ajaxform_with_reset"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">{{ __('Title') }}</label>
                                    <input type="text" name="title" value="{{ old('title') }}"
                                        class="@error('title') is-invalid @enderror form-control"
                                        placeholder="{{ __('Enter Your Title') }}">
                                </div>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">{{ __('Comment') }}</label>
                                    <textarea name="comment" cols="30" rows="5"
                                        class="@error('description') is-invalid @enderror form-control"
                                        placeholder="{{ __('Message') }}"></textarea>
                                </div>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center mt-3">
                                <div class="button-btn">
                                    <button type="submit"
                                        class="btn btn-primary basicbtn w-100">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
