@extends('layouts.backend.app')

@section('content')
<section class="section">
    {{-- section title --}}
    <div class="section-header">
        <a href="{{ url('seller/attribute') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Create Attribute') }}</h1>
    </div>
    {{-- /section title --}}
    <div class="row">
        <div class="col-lg-12">
           <form class="ajaxform_with_reset" method="post" action="{{ route('seller.attribute.store') }}">
            @csrf
            <div class="row">
                {{-- left side --}}
                <div class="col-lg-5">
                    <strong>{{ __('Attribute') }}</strong>
                    <p>{{ __('Add your attribute name and necessary information from here.') }}</p>
                </div>
                {{-- /left side --}}
                {{-- right side --}}
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Name :') }} </label>
                                <div class="col-lg-12">
                                    <input type="text" name="parent_name" class="form-control" required="" placeholder="Parent Attribute">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Type :') }} </label>
                                <div class="col-lg-12">
                                    <select class="form-control selectric" name="select_type">
                                       
                                        <option value="checkbox">{{ __('Checkbox (Multiple Select)') }}</option>
                                        <option value="checkbox_custom">{{ __('Checkbox (Custom Multiple Select)') }}</option>
                                        <option value="radio">{{ __('Radio Button (Single Select)') }}</option>
                                        <option value="radio_custom">{{ __('Radio Button (Custom Single Select)') }}</option>
                                        <option value="color_single">{{ __('Color Selector (Single Select)') }}</option>
                                        <option value="color_multi">{{ __('Color Selector (Multiple Select)') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Is Filterable ?') }} </label>
                                <div class="col-lg-12">
                                   <select class="form-control selectric" name="featured">
                                       <option value="1">{{ __('Yes') }}</option>
                                       <option value="0">{{ __('No') }}</option>
                                   </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary basicbtn">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
                 {{-- /right side --}}
            </div>
             <div class="row">
                {{-- left side --}}
                <div class="col-lg-5">
                    <strong>{{ __('Attribute Values') }}</strong>
                    <p>{{ __('Add your attribute value and necessary information from here') }}</p>
                </div>
                {{-- /left side --}}

                {{-- right side --}}
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body child_row">
                            
                        </div>
                        <div class="card-footer">
                            <div class="from-group row mb-2 attribute-value">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary add_more"><i class="fa fa-plus"></i> {{ __('Add Child Attribute') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 {{-- /right side --}}
            </div>
        </form>
    </div>
</div>
</section>
@endsection

@push('script')
<script>
    "use strict";
    function success(argument) {
        $('.childs').remove()
    }
</script>
@endpush
