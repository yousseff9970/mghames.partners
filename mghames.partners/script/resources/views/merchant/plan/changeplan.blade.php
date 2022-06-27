@extends('layouts.backend.app')

@section('title','Select your plan')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Select your plan'])
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        @if (Session::has('message'))
            <div class="alert alert-{{ Session::get('type') }}">{{ Session::get('message') }}</div>
        @endif
    </div>
    @foreach ($plans ?? [] as $plan)
       @php $plan_data = json_decode($plan->data)
       @endphp
        <div class="col-12 col-md-4 col-lg-4">
            <div class="pricing {{ $plan->is_featured ? 'pricing-highlight' : '' }}">
                <div class="pricing-title">
                    {{ $plan->name }}
                </div>
                <div class="pricing-padding">
                    <div class="pricing-price">
                        <div>{{ $symbol }}{{ $plan->price }}</div>
                        <div>
                            @if ($plan->duration == 7)
                                {{ __('Per Week') }}
                            @elseif($plan->duration == 30)
                                {{ __('Per Month') }}
                            @elseif($plan->duration == 365)
                                {{ __('Per Year') }}
                            @else
                                {{ $plan->duration }} {{ __('Days') }}
                            @endif
                        </div>
                    </div>
                    <div class="pricing-details">
                         @foreach($plan_data ?? [] as $key => $row)
                        <div class="pricing-item ">
                            <div class="pricing-item-icon @if($row == 'on' || $row == 'off') {{ $row == 'on' ? '' : 'bg-danger' }} @endif"><i class="@if($row == 'on' || $row == 'off') {{ $row == 'on' ? 'fas fa-check' : 'fas fa-times' }} @else fas fa-check @endif"></i></div>
                            <div class="pricing-item-label">{{ ucwords(str_replace('_', ' ',$key)) }} @if($row != 'on' && $row != 'off') {{ $row }} @endif
                            </div>
                        </div>
                        @endforeach 
                    </div>
                </div>
                <div class="pricing-cta">
                    <a href="{{ url('/partner/plancharge/'.$info->id.'/'.$plan->id) }}">{{ __('Enroll') }}<i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
