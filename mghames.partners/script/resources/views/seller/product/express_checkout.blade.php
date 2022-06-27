@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Express Checkout','prev'=> url('seller/product')])
@endsection

@extends('seller.product.productmain',['product_id'=>$id])

@section('product_content')
<div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="home-tab4">
  <div class="row">
    <div class="col-12 col-md-8 col-lg-8">
      <form class="express_form">
        <input type="hidden" name="term" value="{{ $info->id }}">
        @if($info->is_variation == 1)
        @foreach($info->productoptionwithcategories ?? [] as $row)
        <div class="form-group">
          <label class="form-label">{{ $row->categorywithchild->name ?? '' }} @if($row->is_required == 1)<span class="text-danger">*</span> @endif</label>
          <div class="selectgroup w-100">
            @foreach($row->priceswithcategories ?? [] as $child)
            <label class="selectgroup-item">
              <input type="{{ $row->select_type == 1 ? 'checkbox' : 'radio' }}" name="option[{{$row->id}}][]" value="{{ $child->id }}" class="selectgroup-input @if($row->is_required == 1) req @endif">
              <span class="selectgroup-button">{{ $child->category->name ?? '' }}</span>
            </label>
            @endforeach
          </div>
        </div>
        @endforeach
        @endif
        <div class="form-group">
          <label class="form-label">{{ __('Quantity') }}</label>
          <input type="number" name="qty" class="form-control" value="1" required min="1">
        </div>
        <p class="text-danger none required_option">{{ __('Please Select A Option From Required Field') }}</p>
        <button type="submit" class="btn btn-primary">{{ __('Generate Url') }}</button>
      </form>
    </div>
    <div class="col-12 col-md-4 col-lg-4"> <p class="exp_area none">{{ __('Checkout Url:') }} <span class="express_url text-primary"></span></p></div>
  </div>
</div>
<input type="hidden" id="base_url" value="{{ url('/') }}">
@endsection

@push('script')
<script src="{{ asset('admin/js/product-express.js') }}"></script>
@endpush
