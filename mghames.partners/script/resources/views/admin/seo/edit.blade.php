@extends('layouts.backend.app')
@section('title','Edit SEO Settings')
@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Edit SEO
Information','prev'=> route('admin.seo.index') ])
@endsection

@section('content')
@php
$value = json_decode($data->value ?? null)
@endphp
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <form method="POST" action="{{ route('admin.seo.update',$data->id) }}"
                            class="ajaxform">
                            @method("PUT")
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>{{ __('Whoops!') }}</strong>
                                    {{ __('There were some problems with your input.') }}<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="form-group row mb-4">
                                    <label class=" text-md-right col-12 col-md-3 col-lg-3">{{ __('Site Name') }}
                                        <sup>*</sup></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="site_name"
                                            value="{{old('site_name') ? old('site_name') :$value->site_name}}">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class=" text-md-right col-12 col-md-3 col-lg-3">{{ __('Meta Tag Name') }}
                                        <sup>*</sup></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="matatag"
                                            value="{{old('matatag') ? old('matatag') :$value->matatag}}">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label
                                        class=" text-md-right col-12 col-md-3 col-lg-3">{{ __('Twitter Site Title') }}
                                        <sup>*</sup></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="twitter_site_title"
                                            value="{{old('twitter_site_title') ? old('twitter_site_title') :$value->twitter_site_title}}">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class=" text-md-right col-12 col-md-3 col-lg-3">{{ __('Meta Description') }}
                                        <sup>*</sup></label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea name="matadescription" id="" cols="30" rows="10"
                                            class="form-control">{{ $value->matadescription ?? null }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button class="btn btn-primary basicbtn w-100 btn-lg"
                                            type="submit">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection