@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h4>{{ __('Review & Rattings') }}</h4>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">{{ __('seller') }}</div>
            <div class="breadcrumb-item">{{ __('review') }}</div>
        </div>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Review & Rattings') }}</h4>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('seller.review.destroy') }}" class="ajaxform_with_reload">
                    @csrf
                    <div class="float-left">
                        <div class="input-group mb-2">
                            <select class="form-control selectric" name="method" tabindex="-1">
                                <option disabled="" selected="">{{ __('Select Action') }}</option>
                                <option value="delete" class="text-danger">{{ __('Delete Permanently') }}</option>
                            </select>
                            <div class="input-group-append">                                            
                                <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive custom-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="am-select">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input checkAll" id="selectAll">
                                            <label class="custom-control-label checkAll" for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th>{{ __('OrderID') }}</th>
                                    <th>{{ __('User Name') }}</th>
                                    <th>{{ __('Rattings') }}</th>
                                    <th>{{ __('Comment') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $key=>$review)
                                <tr id="row3">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="id[]" class="custom-control-input" id="review_id_{{ $review->id }}" value="{{ $review->id }}">
                                            <label class="custom-control-label" for="review_id_{{ $review->id }}"></label>
                                        </div>
                                    </td>
                                    <td><a href="{{ route('seller.order.show',$review->order->id) }}">{{ $review->order->invoice_no }}</a></td>
                                    <td>
                                        <a href="{{ route('seller.user.show',$review->user->id) }}">
                                            {{ $review->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $review->rating }} {{ __('star') }}</td>
                                    <td>{{ Str::limit($review->comment,50) }}</td>
                                    <td>{{ $review->created_at->toDateString() }}</td>
                                </tr>  
                                @endforeach          
                            </tbody>
                        </table>
                         {{ $reviews->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection