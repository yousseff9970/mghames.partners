@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section class="section">
    {{-- section title --}}
    <div class="section-header">
        <a href="{{ url('seller/shipping') }}" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('Shipping Detail') }}</h1>
    </div>
    {{-- /section title --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card mw-580">
                <div class="card-header">
                    <h4>{{ __('Shipping Information') }}</h4>
                    <a href="{{ url('seller/shipping/1/edit') }}" class="btn btn-warning">
                        {{ __('Edit') }}
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>{{ __('Name') }} </td>
                                    <td><b>{{ __('Nokia') }}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Price') }} </td>
                                    <td>
                                        <b>{{ __('198.3$') }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Location') }} </td>
                                    <td>
                                        <b class="badge badge-primary">{{ __('Dahak') }}</b>
                                        <b class="badge badge-primary">{{ __('Comilla') }}</b>
                                        <b class="badge badge-primary">{{ __('Khulna') }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
@endsection

