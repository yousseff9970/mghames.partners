@extends('layouts.backend.app')

@push('css')
<link href='{{ asset('admin/css/calender.css') }}' rel='stylesheet'/>
<script src='{{ asset('admin/js/calender.js') }}'></script>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h4>{{ __('Manage Orders') }}</h4>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Calender') }}</h4>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script src="{{ asset('admin/js/seller.js') }}"></script>
@endpush