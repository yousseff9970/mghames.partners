@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section class="section">
    {{-- section title --}}
    <div class="section-header">
        <a href="{{ url('seller/tax') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Edit Tax') }}</h1>
    </div>
    {{-- /section title --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        {{-- left side --}}
                        <div class="col-lg-5">
                            <h4>{{ __('Description') }}</h4>
                            <p>{{ __('Add your') }} <strong class="text-primary">{{ __('tax') }}</strong> {{ __('details and necessary information from here') }}</p>
                        </div>
                        {{-- /left side --}}
                        {{-- right side --}}
                        <div class="col-lg-5 ml-2">
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Name') }} : </label>
                                <div class="col-lg-12">
                                    <input type="text" name="tax-name" class="form-control" placeholder="email">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Details') }} : </label>
                                <div class="col-lg-12">
                                    <textarea type="text" name="tax-details" class="form-control" placeholder="details"></textarea>
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Amount') }} : </label>
                                <div class="col-lg-12">
                                    <input type="number" min="0" max="100" name="tax-amount" class="form-control">
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Icon') }} : </label>
                                <div class="col-lg-12">
                                    <select name="tax-icon" id="" class="form-control">
                                        <option value="">{{ __('Select Icon') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="from-group row mb-2">
                                <label for="" class="col-lg-12">{{ __('Types') }} : </label>
                                <div class="col-lg-12">
                                    <select name="tax-type" id="" class="form-control">
                                        <option value="">{{ __('Select Type') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                        {{-- /right side --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
@endsection

