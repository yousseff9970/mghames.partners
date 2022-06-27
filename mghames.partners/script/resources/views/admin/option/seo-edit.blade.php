@extends('layouts.backend.app')

@section('title','SEO Option Edit')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'SEO Option Edit','button_name'=> 'All','button_link'=> route('admin.option.seo-index')])
@endsection

@section('content')
@php                                
    $value = json_decode($data->value ?? null);
@endphp
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Edit SEO Option') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.option.seo-update',$data->id) }}" class="ajaxform_with_reload">
                @method("PUT")
                @csrf
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Site Name') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="site_name" value="{{old('site_name') ? old('site_name') :$value->site_name}}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Mata Tag Name') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="matatag" value="{{old('matatag') ? old('matatag') :$value->matatag}}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Twitter Site Title') }}<sup>*</sup></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="twitter_site_title" value="{{old('twitter_site_title') ? old('twitter_site_title') :$value->twitter_site_title}}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Mata Description') }} <sup>*</sup></label>
                        <div class="col-sm-12 col-md-7" >
                            <textarea name="matadescription" id="" cols="30" rows="10" class="form-control">{{ $value->matadescription ?? null }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary basicbtn btn-lg w-100" type="submit">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


