@extends('layouts.backend.app')

@section('title','Dashboard')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'POS'])
@endsection

@section('content')
{{-- pos area start --}}
<section>
  <div class="pos-main-area">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8 pos-right-bar">
          <div class="pos-product-area">
            <div class="pos-search-bar-main-area">
              <div class="pos-search-bar">
                <div class="search-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z"/></svg>
                </div>
                <div class="search-input">
                  <form class="search_form" method="post" action="{{ route('seller.pos.search') }}">
                   @csrf
                  <input type="text" name="src" required="" placeholder="Search Product" id="product_search">
                  </form>
                </div>
              </div>
            </div>
            <div class="product-categories-lists">
              <nav>
                <ul class="nav nav-pills " role="tablist">
                  <li   class="nav-item active category_item" data-id=""><a href="#" class="category-item">{{ __('ALL') }}</a></li>
                  @foreach($categories as $row)
                  <li class="nav-item category_item" data-id="{{ $row->id }}"><a class="category-item" href="#" data-id="{{ $row->id }}">{{ $row->name }}</a></li>
                  @endforeach
                </ul>
              </nav>
            </div>
            <div class="pos-product-main-content">
              <div class="row" id="product_list">
              </div>
              <div class="row">
                <div class="col-lg-6 offset-lg-3">
                  <div class="load-more text-center">
                    <a href="javascript:void(0)" class="load_more_btn none">{{ __('Load More') }}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="pos-right-area">
            <div class="customer-header-input">
              <div class="customer-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-4.987-3.744A7.966 7.966 0 0 0 12 20c1.97 0 3.773-.712 5.167-1.892A6.979 6.979 0 0 0 12.16 16a6.981 6.981 0 0 0-5.147 2.256zM5.616 16.82A8.975 8.975 0 0 1 12.16 14a8.972 8.972 0 0 1 6.362 2.634 8 8 0 1 0-12.906.187zM12 13a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
              </div>
              <div class="customer-input">
                <input type="text" id="customer_email" name="customer_email" placeholder="Select Customers">
              </div>
            </div>
            @if(tenant('customer_modules') == 'on')
            <div class="add-new-customer-btn">
              <a href="javascript:void(0)" data-toggle="modal" data-target="#customer_create_modal"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg></a>
            </div>
            @endif
          </div>
          <div class="form-group mt-3">
            <div class="barcode-input-area">
              <div class="input-group">
                <input type="text" class="barcode" placeholder="Enter product barcode">
              </div>
              <div class="barcode-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M2 4h2v16H2V4zm4 0h1v16H6V4zm2 0h2v16H8V4zm3 0h2v16h-2V4zm3 0h2v16h-2V4zm3 0h1v16h-1V4zm2 0h3v16h-3V4z"/></svg>
              </div>
            </div>
          </div>
          <div class="pos-item-lists">
            <div class="table-responsive">
              <table class="table table-striped">
                <tbody class="cart_table_body"><tr>
                  <th>{{ __('Qty') }}</th>
                  <th>{{ __('Product') }}</th>
                  <th>{{ __('Price') }}</th>
                  <th>{{ __('Action') }}</th>
                </tr>
              </tbody></table>
            </div>
          </div>
          <div class="pos-payable-amount">
            <div class="table-responsive">
              <table class="table table-striped">
                <tbody>
                <tr>
                  <th><strong>{{ __('Subtotal') }}</strong></th>
                  <th class="payable-right subtotal" >{{ Cart::subtotal() }}</th>
                </tr>
                <tr>
                  <th><strong>{{ __('Tax') }}</strong></th>
                  <th class="payable-right tax">{{ Cart::tax() }}</th>
                </tr>
                <tr>
                  <th><strong>{{ __('Total(Payable)') }}</strong></th>
                  <th class="payable-right total">{{ Cart::total() }}</th>
                </tr>
              </tbody></table>
            </div>
          </div>
          <div class="pos-button">
           <button class="btn btn-primary" id="order_btn" type="button" data-toggle="modal" data-target="#ordermodal" >{{ __('Make Order') }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
{{-- pos area end --}}

<!-- optionable product Modal -->
 <form class="option_form" method="post" action="{{ route('seller.add.tocart') }}">
<div class="modal fade" id="product_variation_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{ __('Select Variation') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tables-lists">
          <div class="row">
           <div class="col-sm-12 option_form_area">
             
           </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary add_to_cart_form_btn">{{ __('Add To Cart')  }}</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- optionable product Modal -->
 <form class="customer_store_form" method="post" action="{{ route('seller.pos.customer.store') }}">
  @csrf
<div class="modal fade" id="customer_create_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{ __('Create Customer') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tables-lists">
          <div class="row">
           <div class="col-sm-12">
             <div class="form-group">
               <label>{{ __('Name') }}</label>
               <input type="text" name="name" class="form-control" required="">
             </div>
             <div class="form-group">
               <label>{{ __('Email') }}</label>
               <input type="email" name="email" class="form-control" required="">
             </div>
             <div class="form-group">
               <label>{{ __('Password') }}</label>
               <input type="password" name="password" class="form-control" required="">
             </div>
             <div class="form-group">
               <label>{{ __('Wallet') }}</label>
               <input type="number" value="0" step="any" name="wallet" class="form-control" required="">
             </div>
           </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary customer_create_btn">{{ __('Create Customer')  }}</button>
      </div>
    </div>
  </div>
</div>
</form>
 
<form method="post" class="ajaxform_with_reload" action="{{ route('seller.pos.order') }}">
  @csrf
<!-- Modal -->
<div class="modal fade" id="ordermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Make Order') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <input type="hidden" name="customer_id" id="customer_id">
        <div class="row">
        <div class="col-sm-2">
          <div class="form-group">
            <label>{{ __('Select Payment Method') }}</label>
            <div class="custom-switches-stacked ">
              @foreach($getways as $key => $getway)
            <label>
              <input type="radio" name="getway" value="{{ $getway->id }}" class="custom-switch-input" {{ $key == 0 ? 'checked' : '' }}>
              <span class="custom-switch-indicator"></span>
              <span class="custom-switch-description">{{ $getway->name }}</span>
            </label>
            @endforeach
          </div>
        </div>
        </div>
        <div class="col-sm-6">
          <div class="pos-item-lists">
          <div class="table-responsive">
            <table class="table table-bordered  table-striped" >
              <thead>
                 <tr>
                  <th>{{ __('Product Name') }}</th>
                  <th class="text-right">{{ __('Price') }}</th>
                </tr>
              </thead>
              <tbody class="cart_modal">

              </tbody>
            </table>
          </div>
        </div>
         <div class="table-responsive mt-2">
        <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>
              <th class="text-left w-60" colspan="2">{{ __('Detail') }}</th>
              <th class="text-right">{{ __('Price') }}</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-left w-60" colspan="2">
                {{ __('Subtotal') }}              
              </th>
              <td class="text-right w-40 subtotal ">{{ Cart::subtotal() }}</td>
            </tr>
            <tr>
              <th class="text-left w-60 " colspan="2">
                {{ __('Discount') }} 
              </th>
              <td class="text-right w-40 ">{{ Cart::discount() }}</td>
            </tr>
            <tr>
              <th class="text-left w-60" colspan="2">
                {{ __('Order Tax') }}             
              </th>
              <td class="text-right w-40 tax">{{ Cart::tax() }}</td>
            </tr>
            <tr>
              <th class="text-left w-60 " colspan="2">
                {{ __('Shipping Charge') }} 
              </th>
              <td class="text-right w-40 shipping_charge">0.00</td>
              <input type="hidden" name="shipping_price" class="shipping_price">
            </tr>
            <tr>
              <th class="text-left w-60 " colspan="2">
                {{ __('Payable Amount') }}
              </th>
              
              <td class="text-right w-40 total">{{ Cart::total() }}</td>
            </tr>
          </tfoot>
        </table>
        <div class="form-group">
            <label><b>{{ __('Customer Name') }}</b> </label>
            <input type="text" name="name" class="form-control customer_name">
        </div>
        <div class="form-group">
            <label><b>{{ __('Customer Email') }}</b> </label>
            <input type="email" name="email" class="form-control customer_email">
        </div>
        <div class="form-group">
            <label><b>{{ __('Customer Phone') }}</b> </label>
            <input type="tel" name="phone" class="form-control customer_phone">
        </div>
        <div class="form-group">
            <label><b>{{ __('Order Note:') }}</b> </label>
            <textarea class="form-control" name="note"></textarea>
        </div>
      </div>
      </div>
      <div class="col-sm-4">
        <div class="table-responsive">
        <table class="table table-bordered table-striped table-condensed">
          <tfoot>
            <tr>
              <td colspan="3" >
                <div class="form-group">
                  <label><b>{{ __('Select Order Method') }}</b> </label>
                  <select class="selectric form-control order_method" name="order_method">
                    <option value="table">{{ __('Order From Table') }}</option>
                    <option value="pickup">{{ __('Pickup Order') }}</option>
                    <option value="delivery">{{ __('Delivery Order') }}</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr class="table_area">
              <td colspan="3" >
                <div class="form-group">
                  <label><b>{{ __('Select Table') }}</b> </label>
                  <select class="selectric form-control" name="table">
                    @foreach($tables as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                  </select>
                </div>
              </td>
            </tr>
            <tr class="location_area none">
              <td colspan="3" >
                <div class="form-group">
                  <label><b>{{ __('Select Delivery Area') }}</b> </label>
                  <select class="selectric form-control" name="location" id="location">
                    <option value="" data-shipping="[]">{{ __('Select Location') }}</option>
                    @foreach($locations as $row)
                    <option value="{{ $row->id }}" data-shipping="{{ $row->shipping }}">{{ $row->name }}</option>
                    @endforeach
                  </select>
                </div>
              </td>
            </tr>
            <tr class="location_area none">
              <td colspan="3" >
                <div class="form-group">
                  <label><b>{{ __('Select Shipping Method') }}</b> </label>
                  <select class="form-control" name="shipping_method" id="shipping_method">
                  <option value="" data-price="0">{{ __('Select Shipping Method') }}</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr class="location_area none">
              <td colspan="3" >
                <div class="form-group">
                  <label><b>{{ __('Delivery Address') }}</b> </label>
                  <textarea class="form-control" name="delivery_address"></textarea>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <div class="form-group">
                  <label><b>{{ __('Is Pre Order?') }}</b> </label>
                  <select class="selectric form-control pre_order" name="pre_order">
                    <option value="1">{{ __('Yes') }}</option>
                    <option value="0" selected="">{{ __('No') }}</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" class="date_time none">
                <div class="form-group">
                  <label><b>{{ __('Select Date') }}</b> </label>
                  <input type="date" name="date" class="form-control">
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" class="date_time none">
                <div class="form-group">
                  <label><b>{{ __('Select Time') }}</b> </label>
                  <input type="time" id="time" class="form-control">
                  <input type="hidden" name="time" class="time">
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" >
                <div class="form-group">
                  <label><b>{{ __('Order Status') }}</b> </label>
                  <select class="form-control selectric" name="order_status">
                    @foreach($order_status as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" >
                <div class="form-group">
                  <label><b>{{ __('Payment Status') }}</b> </label>
                  <select class="form-control selectric" name="payment_status">
                    <option value="1">{{ __('Paid') }}</option>
                    <option value="2">{{ __('Pending') }}</option>
                    <option value="0">{{ __('Faild') }}</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" >
                <div class="form-group">
                  <label><b>{{ __('Payment Id') }}</b> </label>
                  <input type="text" name="payment_id" class="form-control">
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" >
                <div class="form-group">
                  <label><b>{{ __('Coupon Code') }}</b> </label>
                  <input type="text" name="coupon" class="form-control">
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
      </div>
    </div>
  </div>
</div>
</form>
<input type="hidden" id="product_link" value="{{ route('seller.product.json') }}"/>
<input type="hidden" id="defaut_img" value="{{ asset('uploads/default.png') }}" />
<input type="hidden" id="currency_name" value="{{ currency() }}" />
<input type="hidden" id="cart_link" value="{{ route('seller.add.tocart') }}" />
<input type="hidden" id="base_url" value="{{ url('/') }}" />
<input type="hidden" id="click_sound" value="{{ asset('uploads/click.wav') }}">
<input type="hidden" id="cart_sound" value="{{ asset('uploads/cart.wav') }}">
<input type="hidden" id="cart_increment" value="{{ url('/seller/cart-qty') }}">
<input type="hidden" id="pos_product_varidation" value="{{ url('/seller/product-varidation') }}">
<input type="hidden" id="cart_content" value="{{ Cart::content() }}">
<input type="hidden" class="total_amount" value="{{ str_replace(',','',Cart::total()) }}">
@endsection

@push('script')
<script src="{{ asset('admin/js/pos.js') }}"></script>
@endpush