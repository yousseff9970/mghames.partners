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
        <a href="{{ url('seller/coupon') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Create Coupon') }}</h1>
    </div>
    {{-- /section title --}}
    <div class="row">
        <div class="col-lg-12">
            <form class="ajaxform_with_reset" method="post" action="{{ route('seller.coupon.store') }}">
                @csrf
                <div class="row">
                    {{-- left side --}}
                    <div class="col-lg-5">
                    <strong>{{ __('Image') }}</strong>
                    <p>{{ __('Upload Coupon image here') }}</p>
                    </div>
                    {{-- /left side --}}
                    {{-- right side --}}
                    <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            {{mediasection()}}
                        </div>
                    </div>
                    </div>
                    {{-- /right side --}}
                </div>
                <div class="row">
                    {{-- left side --}}
                    <div class="col-lg-5">
                    <strong>{{ __('Information') }}</strong>
                        <p>{{ __('Add your coupon details and necessary information from here') }}</p>
                    </div>
                    {{-- /left side --}}
                    {{-- right side --}}
                    <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="from-group row mb-2">
                                        <label for="" class="col-lg-12">{{ __('Coupon Code:') }} </label>
                                        <div class="col-lg-12">
                                            <input type="text" required name="coupon_code" class="form-control" placeholder="Enter Coupon Code">
                                        </div>
                                    </div>
                                    <div class="from-group row mb-2">
                                        <label for="" class="col-lg-12">{{ __('Price:') }} </label>
                                        <div class="col-lg-12">
                                            <input type="number" required="" value="0" step="any" name="price" class="form-control" placeholder="Enter Percentage Rate Or Flat Rate">
                                        </div>
                                    </div>
                                    <div class="from-group row mb-2">
                                        <label for="" class="col-lg-12">{{ __('Discount Type:') }} </label>
                                        <div class="col-lg-12">
                                            <select class="form-control" name="discount_type" >
                                                <option value="1">{{ __('Percentage') }}</option>
                                                <option value="0">{{ __('Flat Rate Discount') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="from-group row mb-2">
                                        <label for="" class="col-lg-12">{{ __('Is Conditional ?') }} </label>
                                        <div class="col-lg-12">
                                            <select class="form-control" name="is_conditional" id="is_conditional">
                                                <option value="1">{{ __('Yes') }}</option>
                                                <option value="0" selected="">{{ __('No') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="from-group row mb-2 none" id="min_amount_area">
                                        <label for="" class="col-lg-12">{{ __('Min Amount:') }} </label>
                                        <div class="col-lg-12">
                                            <input type="number" required="" value="0" step="any" name="min_amount" class="form-control" placeholder="Enter Min Amount">
                                        </div>
                                    </div>
                                    <div class="from-group row mb-2">
                                        <label for="" class="col-lg-12">{{ __('Start From:') }} </label>
                                        <div class="col-lg-12">
                                            <input type="date" required=""   name="start_from" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="from-group row mb-2">
                                        <label for="" class="col-lg-12">{{ __('Will Expire:') }} </label>
                                        <div class="col-lg-12">
                                            <input type="date" required=""  name="will_expire" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="from-group row mb-2">
                                        <label for="" class="col-lg-12">{{ __('Is Featured ?') }} </label>
                                        <div class="col-lg-12">
                                            <select class="form-control" name="is_featured">
                                                <option value="1">{{ __('Yes') }}</option>
                                                <option value="0" selected="">{{ __('No') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="from-group row mb-2">
                                        <label for="" class="col-lg-12">{{ __('Status') }} </label>
                                        <div class="col-lg-12">
                                            <select class="form-control" name="status">
                                                <option value="1">{{ __('Enable') }}</option>
                                                <option value="0">{{ __('Disable') }}</option>
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
{{ mediasingle() }} 
@endsection

@push('script')
 <!-- JS Libraies -->
<script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('admin/plugins/dropzone/components-multiple-upload.js') }}"></script>
<script src="{{ asset('admin/js/media.js') }}"></script>
<script src="{{ asset('admin/js/seller.js') }}"></script>
@endpush

