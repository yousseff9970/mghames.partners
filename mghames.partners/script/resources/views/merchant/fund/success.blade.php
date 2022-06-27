@extends('layouts.backend.app')

@section('title','Payment Success')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Payment Success'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          @if (Session::has('message'))
          <div class="alert alert-{{ Session::get('type') ?? '' }}">
            {{ Session::get('message') }}
          </div>
          @endif
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                      <tr>
                        <td>
                          {{ __('Payment Id') }}
                        </td>
                        <td>
                          {{ $payment_info['payment_id'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          {{ __('Payment Method') }}
                        </td>
                        <td>
                          {{ $payment_info['payment_method'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          {{ __('Charge') }}
                        </td>
                        <td>
                          {{ $payment_info['charge'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          {{ __('Amount') }}
                        </td>
                        <td>
                          {{ $payment_info['amount'] }}
                        </td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
@endsection