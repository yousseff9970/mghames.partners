@foreach($info->optionwithcategories ?? [] as $key => $row)
<div class="product-weight">
	<h6><span class="text-danger {{ $row->is_required == 1 ? 'required_var' : '' }}" data-id="{{$row->id}}">{{ $row->is_required == 1 ? '*' : '' }}</span>{{ $row->category->name ?? '' }} :</h6>
	@foreach($row->priceswithcategories ?? [] as $k => $price)

	@if($row->category->slug == 'checkbox')
	<input 

	class="custom-control variations{{$row->id}} pricesvariations {{ $row->is_required == 1 ? 'req' : '' }}" 
	data-stockstatus="{{ $price->stock_status }}"  
	data-stockmanage="{{ $price->stock_manage }}" 
	data-sku="{{ $price->sku }}" 
	data-qty="{{ $price->qty }}"  
	data-oldprice="{{ $price->old_price }}" 
	data-price="{{ $price->price }}" 
	type="{{ $row->select_type == 1 ? 'checkbox' : 'radio' }}" 
	id="variation{{ $price->id.$k+$key }}" 
	name="option[{{$row->id}}][]" 
	value="{{ $price->id ?? '' }}"
	{{ $row->is_required == 1 && $k == 0 ? 'checked' : '' }}
	>

	<label for="variation{{ $price->id.$k+$key }}">{{ $price->category->name ?? '' }}</label>
	@elseif($row->category->slug == 'checkbox_custom')
	<div class="single_weight variation{{ $price->id ?? '' }}">
		<input 
		class="custom-control variations{{$row->id}} pricesvariations {{ $price->is_required == 1 ? 'req' : '' }}" 
		data-stockstatus="{{ $price->stock_status }}"  
		data-stockmanage="{{ $price->stock_manage }}" 
		data-sku="{{ $price->sku }}" 
		data-qty="{{ $price->qty }}"  
		data-oldprice="{{ $price->old_price }}" 
		data-price="{{ $price->price }}" 
		type="{{ $row->select_type == 1 ? 'checkbox' : 'radio' }}" 
		id="variation{{ $price->id.$k+$key }}" 
		name="option[{{$row->id}}][]" 
		value="{{ $price->id ?? '' }}">
		<label for="variation{{ $price->id.$k+$key }}">{{ $price->category->name ?? '' }}</label>
	</div>
	@elseif($row->category->slug == 'radio')


	<input 
	class="custom-control variations{{$row->id}} pricesvariations {{ $row->is_required == 1 ? 'req' : '' }}" 
	data-stockstatus="{{ $price->stock_status }}"  
	data-stockmanage="{{ $price->stock_manage }}" 
	data-sku="{{ $price->sku }}" 
	data-qty="{{ $price->qty }}"  
	data-oldprice="{{ $price->old_price }}" 
	data-price="{{ $price->price }}" 
	type="{{ $row->select_type == 1 ? 'checkbox' : 'radio' }}" 
	id="variation{{ $price->id.$k+$key }}" 
	name="option[{{$row->id}}][]" 
	value="{{ $price->id ?? '' }}">

	<label for="variation{{ $price->id.$k+$key }}">{{ $price->category->name ?? '' }}</label>


	@elseif($row->category->slug == 'radio_custom')
	<div class="single_weight variations{{$row->id}} variation{{ $price->id ?? '' }}">
		<input 
		class="custom-control pricesvariations {{ $price->is_required == 1 ? 'req' : '' }}" 
		data-stockstatus="{{ $price->stock_status }}"  
		data-stockmanage="{{ $price->stock_manage }}" 
		data-sku="{{ $price->sku }}" 
		data-qty="{{ $price->qty }}"  
		data-oldprice="{{ $price->old_price }}" 
		data-price="{{ $price->price }}" 
		type="{{ $row->select_type == 1 ? 'checkbox' : 'radio' }}" 
		id="variation{{ $price->id.$k+$key }}" 
		name="option[{{$row->id}}][]" 
		value="{{ $price->id ?? '' }}">
		<label for="variation{{ $price->id.$k+$key }}">{{ $price->category->name ?? '' }}</label>
	</div>
	@elseif($row->category->slug == 'color_single')
	<div class="single_weight">
		<input 
		class="custom-control variations{{$row->id}} color_single pricesvariations {{ $price->is_required == 1 ? 'req' : '' }}" 
		data-stockstatus="{{ $price->stock_status }}"  
		data-stockmanage="{{ $price->stock_manage }}" 
		data-sku="{{ $price->sku }}" 
		data-qty="{{ $price->qty }}"  
		data-oldprice="{{ $price->old_price }}" 
		data-price="{{ $price->price }}" 
		type="{{ $row->select_type == 1 ? 'checkbox' : 'radio' }}" 
		id="variation{{ $price->id.$k+$key }}" 
		name="option[{{$row->id}}][]" 
		value="{{ $price->id ?? '' }}">
		<label class="variation{{ $price->id.$k+$key }} h-34 w-55 @if(strtolower($price->category->name ?? '') != 'white') text-light @else text-dark @endif" for="variation{{ $price->id.$k+$key }}" class="text-light" style="background-color: {{ $price->category->name ?? ''; }}">&nbsp&nbsp</label>
	</div>
	@elseif($row->category->slug == 'color_multi')
	<div class="single_weight">
		<input 
		class="custom-control variations{{$row->id}} color_single pricesvariations {{ $price->is_required == 1 ? 'req' : '' }}" 
		data-stockstatus="{{ $price->stock_status }}"  
		data-stockmanage="{{ $price->stock_manage }}" 
		data-sku="{{ $price->sku }}" 
		data-qty="{{ $price->qty }}"  
		data-oldprice="{{ $price->old_price }}" 
		data-price="{{ $price->price }}" 
		type="{{ $row->select_type == 1 ? 'checkbox' : 'radio' }}" 
		id="variation{{ $price->id.$k+$key }}" 
		name="option[{{$row->id}}][]" 
		value="{{ $price->id ?? '' }}">
		<label class="variation{{ $price->id.$k+$key }} h-34 w-55 @if(strtolower($price->category->name ?? '') != 'white') text-light @else text-dark @endif" for="variation{{ $price->id.$k+$key }}" class="text-light" style="background-color: {{ $price->category->name ?? ''; }};">&nbsp&nbsp</label>
	</div>
	@endif

	@endforeach

</div>
@endforeach