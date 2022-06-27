@extends('theme.grocery.layouts.app')

@section('content')
<div class="hero-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 category-lists-sidebar">
                <div class="grocery-items-collection" id="categories">
                    
                </div>
            </div>
            <div class="col-lg-9 hero-fixed">
                @php
				$autoloaddata=getautoloadquery();
				$currency_data=$autoloaddata['currency_data'];
				@endphp
				<div class="row">
					<div class="col-lg-12">
						<div class="wishlist-area">
							<div class="wishlist-header text-center">
								<h3>{{ $page_data->wishlist_page_title ?? 'Wishlist' }}</h3>
							</div>
							<div class="wishlist-table">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Remove</th>
												<th scope="col">Product</th>
												<th>Name</th>
												<th scope="col">Unit Price</th>
												<th>Add To Cart</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($contents as $row)
											<tr>
												<td scope="row"><a href="{{ url('/remove-wishlist',$row->rowId) }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg></a></td>
												<td><img src="{{ asset($row->options->preview) }}" alt="{{ $row->name }}"></td>
												<td><span class="product-name">{{ $row->name }}</span></td>
												<td><span class="product-price">{{ number_format($row->price,2) }}</span></td>
												<td><a class="cart-btn add_to_cart_modal" data-id="{{ $row->id }}" href="javascript:void(0)">Add To Cart</a></td>
											</tr>
											@endforeach
										</tbody>
									</table>
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

@push('js')
 <script src="{{ asset('theme/grocery/js/home.js') }}"></script>
@endpush