@extends('layouts.backend.app')

@section('title', 'Plan View')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Install Site'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('merchant.enroll.domain') }}" class="ajaxform">
                    @csrf
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Store Name') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ env('APP_URL_WITH_TENANT') }}</div>
                                </div>
                                <input id="name" value="{{ $domain_data['name'] }}" required placeholder="store name" type="text"  name="name" class="form-control @error('name') is-invalid @enderror" required/>
                            </div>  
                        </div>
                    </div>  
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Install') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="planroute" value="{{ route('merchant.domain.list') }}">
@endsection

@push('script')
 <script src="{{ asset('admin/js/plansuccess.js') }}"></script>
@endpush
