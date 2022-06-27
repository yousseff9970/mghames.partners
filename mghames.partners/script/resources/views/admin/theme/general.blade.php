@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('General Settings') }}</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('General Settings') }}</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.general.update') }}" method="POST" class="ajaxform">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="logo">{{ __('Logo') }}</label>
                                        <input type="file" name="logo" id="logo" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="favicon">{{ __('Favicon') }}</label>
                                        <input type="file" name="favicon" id="favicon" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="hero_img">{{ __('Hero Section Image') }}</label>
                                        <input type="file" class="form-control" name="hero_img">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="market_img">{{ __('Market Section Image') }}</label>
                                        <input type="file" class="form-control" name="market_img">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="market_url">{{ __('Market Section URL') }}</label>
                                        <input type="text" class="form-control" name="market_url" value="{{ $info->market_url ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sell_img">{{ __('Sell Section Image') }}</label>
                                        <input type="file" class="form-control" name="sell_img">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="sell_url">{{ __('Sell Section URL') }}</label>
                                        <input type="text" class="form-control" name="sell_url" value="{{ $info->sell_url ?? '' }}">
                                    </div>
                                </div>
                               
                                <div class="col-lg-12">
                                    <div class="button-btn float-right">
                                        <button type="submit" class="btn btn-primary btn-lg">{{ __('Save & Changes') }}</button>
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

@push('script')
<script src="{{ asset('admin/js/custom.js') }}"></script>
@endpush