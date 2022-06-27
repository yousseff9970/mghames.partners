@foreach($info->optionwithcategories ?? [] as $key => $row)
<div class="option-colors">	
	
	<h6><span class="text-danger {{ $row->is_required == 1 ? 'required_var' : '' }}" data-id="{{$row->id}}">{{ $row->is_required == 1 ? '*' : '' }}</span>{{ $row->category->name ?? '' }} :</h6>

	@foreach($row->priceswithcategories ?? [] as $k => $price)
	<div class="single_color color">
	@if($row->category->slug == 'checkbox')
	&nbsp
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
	&nbsp
	<div class="custom_checkbox variation{{ $price->id ?? '' }}">
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
	&nbsp

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
	&nbsp
	<div class="custom_radio_section variations{{$row->id}} variation{{ $price->id ?? '' }}">
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
	<div class="color_widget">
		<div class="single_color">
			<input class=" variations{{$row->id}} color_single pricesvariations {{ $price->is_required == 1 ? 'req' : '' }}"  data-stockstatus="{{ $price->stock_status }}"  
		data-stockmanage="{{ $price->stock_manage }}" 
		data-sku="{{ $price->sku }}" 
		data-qty="{{ $price->qty }}"  
		data-oldprice="{{ $price->old_price }}" 
		data-price="{{ $price->price }}" 
		type="{{ $row->select_type == 1 ? 'checkbox' : 'radio' }}" 
		id="variation{{ $price->id.$k+$key }}" 
		name="option[{{$row->id}}][]" 
		value="{{ $price->id ?? '' }}">

		<label class="one variation{{ $price->id.$k+$key }} @if(strtolower($price->category->name ?? '') != 'white') text-light @else text-dark @endif" for="variation{{ $price->id.$k+$key }}"  style="background-color: {{ $price->category->name ?? ''; }}"><i></i></label>
			
		</div>

	</div>
	@elseif($row->category->slug == 'color_multi')
	<div class="color_widget">
		<div class="single_color">
			<input class=" variations{{$row->id}} color_single pricesvariations {{ $price->is_required == 1 ? 'req' : '' }}"  data-stockstatus="{{ $price->stock_status }}"  
		data-stockmanage="{{ $price->stock_manage }}" 
		data-sku="{{ $price->sku }}" 
		data-qty="{{ $price->qty }}"  
		data-oldprice="{{ $price->old_price }}" 
		data-price="{{ $price->price }}" 
		type="{{ $row->select_type == 1 ? 'checkbox' : 'radio' }}" 
		id="variation{{ $price->id.$k+$key }}" 
		name="option[{{$row->id}}][]" 
		value="{{ $price->id ?? '' }}">

		<label class="one variation{{ $price->id.$k+$key }} @if(strtolower($price->category->name ?? '') != 'white') text-light @else text-dark @endif" for="variation{{ $price->id.$k+$key }}"  style="background-color: {{ $price->category->name ?? ''; }}"></label>
			
		</div>

	</div>
	@endif
	</div>
	@endforeach

</div>
@endforeach