@extends('layouts.backend.app')
@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Theme Settings'])
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endsection
@section('content')
<div class="row">
	<div class="col-12 col-sm-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Theme Settings') }}</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-4">
						<ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
							<li class="nav-item">
								<a class="nav-link active"  data-toggle="tab" href="#home_page" role="tab" aria-controls="home" aria-selected="true">{{ __('Home Page') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"  data-toggle="tab" href="#product_page" role="tab" aria-controls="profile" aria-selected="false">{{ __('Product Page') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"  data-toggle="tab" href="#cart_page" role="tab" aria-controls="profile" aria-selected="false">{{ __('Cart Page') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"  data-toggle="tab" href="#wishlist_page" role="tab" aria-controls="profile" aria-selected="false">{{ __('Wishlist Page') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"  data-toggle="tab" href="#checkout_page" role="tab" aria-controls="profile" aria-selected="false">{{ __('Checkout Page') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"  data-toggle="tab" href="#menu_page" role="tab" aria-controls="profile" aria-selected="false">{{ __('Menu Page') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"  data-toggle="tab" href="#products_page" role="tab" aria-controls="profile" aria-selected="false">{{ __('Products Page') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"  data-toggle="tab" href="#blog_page" role="tab" aria-controls="profile" aria-selected="false">{{ __('Blogs Page') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"  data-toggle="tab" href="#settings_page" role="tab" aria-controls="profile" aria-selected="false">{{ __('Template primary settings') }}</a>
							</li>

							<li class="nav-item">
								<a class="nav-link"  data-toggle="tab" href="#contact" role="tab" aria-controls="profile" aria-selected="false">{{ __('Contact Page') }}</a>
							</li>
							
						</ul>
					</div>
					<div class="col-12 col-sm-12 col-md-8">
						<div class="tab-content no-padding" id="myTab2Content">
							<div class="tab-pane fade show active" id="home_page" role="tabpanel" aria-labelledby="home_page">
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','home_page') }}">
									@csrf
									@php
									$home_page_data=get_option('home_page',true);
									$home_page_data=$home_page_data->meta ?? '';
									@endphp
								<h6>{{ __('Featured product Area') }}</h6>
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" name="option[featured_products_title]" value="{{ $home_page_data->featured_products_title ?? '' }}" class="form-control">
								</div>
								<div class="form-group">
									<label>{{ __('Description  :') }}</label>
									<textarea name="option[featured_products_description]" class="form-control">{{ $home_page_data->featured_products_description ?? '' }}</textarea>
								</div>
								@php
								$featured_products_status=$home_page_data->featured_products_status ?? 'yes';
								@endphp
								<div class="form-group">
									<label>{{ __('Status :') }}</label>
									<select class="form-control selectric" name="option[featured_products_status]">
										<option value="yes" @if($featured_products_status == 'yes') selected="" @endif>{{ __('Enabled') }}</option>
										<option value="no" @if($featured_products_status == 'no') selected="" @endif>{{ __('Disabled') }}</option>
									</select>
								</div>

								<hr>
								<h6>{{ __('Products Area') }}</h6>
								<div class="form-group">
									<label>{{ __('Short Title :') }}</label>
									<input type="text"  value="{{ $home_page_data->products_area_short_title ?? '' }}" name="option[products_area_short_title]" class="form-control">
								</div>
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $home_page_data->products_area_title ?? '' }}" name="option[products_area_title]" class="form-control">
								</div>
								
								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[products_area_description]" class="form-control">{{ $home_page_data->products_area_description ?? '' }}</textarea>
								</div>

								<hr>
								<h6>{{ __('Discount Product Area') }}</h6>
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $home_page_data->discount_product_title ?? '' }}" name="option[discount_product_title]" class="form-control">
								</div>
								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[discount_product_description]" class="form-control">{{ $home_page_data->discount_product_description ?? '' }}</textarea>
								</div>
								@php
								$discount_product_status=$home_page_data->discount_product_status ?? 'yes';
								@endphp
								<div class="form-group">
									<label>{{ __('Status :') }}</label>
									<select class="form-control selectric" name="option[discount_product_status]">
										<option value="yes" @if($discount_product_status == 'yes') selected="" @endif>{{ __('Enabled') }}</option>
										<option value="no" @if($discount_product_status == 'no') selected="" @endif>{{ __('Disabled') }}</option>
									</select>
								</div>

								<hr>
								<h6>{{ __('Testimonial Area') }}</h6>
								<label>{{ __('Section Background Image :') }}</label>
								{{mediasection([
										'preview_class'=>'testimonial_background',
										'input_id'=>'testimonial_background',
										'input_class'=>'testimonial_background',
										'input_name'=>'option[testimonial_background]',
										'value'=>$home_page_data->testimonial_background ?? '',
										'preview'=>$home_page_data->testimonial_background ?? 'admin/img/img/placeholder.png'
									])}}
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" name="option[testimonial_title]" value="{{ $home_page_data->testimonial_title ?? '' }}" class="form-control">
								</div>
								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[testimonial_description]" value="{{ $home_page_data->testimonial_description ?? '' }}" class="form-control"></textarea>
								</div>
								@php
								$testimonial_status=$home_page_data->testimonial_status ?? 'yes';
								@endphp
								<div class="form-group">
									<label>{{ __('Status :') }}</label>
									<select class="form-control selectric" name="option[testimonial_status]">
										<option value="yes" @if($testimonial_status == 'yes') selected="" @endif>{{ __('Enabled') }}</option>

										<option value="no" @if($testimonial_status == 'no') selected="" @endif>{{ __('Disabled') }}</option>
									</select>
								</div>

								<hr>
								<h6>{{ __('Menu Area') }}</h6>
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $home_page_data->menu_area_title ?? '' }}" name="option[menu_area_title]" class="form-control">
								</div>
								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[menu_area_description]" class="form-control">{{ $home_page_data->menu_area_description ?? '' }}</textarea>
								</div>
								@php
								$menu_area_status=$home_page_data->menu_area_status ?? 'yes';
								@endphp
								<div class="form-group">
									<label>{{ __('Status :') }}</label>
									<select class="form-control selectric" name="option[menu_area_status]">
										<option value="yes" @if($menu_area_status == 'yes') selected="" @endif>{{ __('Enabled') }}</option>

										<option value="no" @if($menu_area_status == 'no') selected="" @endif>{{ __('Disabled') }}</option>
									</select>
								</div>

								<hr>
								<h6>{{ __('Blog Area') }}</h6>
								<div class="form-group">
									<label>{{ __('Short Title :') }}</label>
									<input type="text" value="{{ $home_page_data->blog_area_short_title ?? '' }}" name="option[blog_area_short_title]" class="form-control">
								</div>
								<div class="form-group">
									<label>{{ __('Title :') }} </label>
									<input type="text" value="{{ $home_page_data->blog_area_title ?? '' }}" name="option[blog_area_title]" class="form-control">
								</div>
								<div class="form-group">
									<label>{{ __('Description :') }} </label>
									<textarea name="option[blog_area_description]" class="form-control">{{ $home_page_data->blog_area_description ?? '' }}</textarea>
								</div>
								@php
								$blog_area_status=$home_page_data->blog_area_status ?? 'yes';
								@endphp
								<div class="form-group">
									<label>{{ __('Status :') }} </label>
									<select class="form-control selectric" name="option[blog_area_status]">
										<option value="yes" @if($blog_area_status == 'yes') selected="" @endif>{{ __('Enabled') }}</option>

										<option value="no" @if($blog_area_status == 'no') selected="" @endif>{{ __('Disabled') }}</option>
									</select>
								</div>
								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
								</form>
							</div>


							<div class="tab-pane fade" id="product_page" role="tabpanel" aria-labelledby="profile-tab4">
								@php
								$product_page_data=get_option('product_page',true);
								$product_page_data=$product_page_data->meta ?? '';
								@endphp
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','product_page') }}">
									@csrf
								<div class="form-group">
									<label>{{ __('Short Title :') }}</label>
									<input placeholder="Related products" type="text" name="option[product_page_short_title]" value="{{ $product_page_data->product_page_short_title ?? '' }}" class="form-control">
								</div>
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text"  value="{{ $product_page_data->product_page_title ?? '' }}" name="option[product_page_title]" class="form-control">
								</div>
								<div class="form-group">
									<label>{{ __('Page Banner') }}</label>
									{{mediasection([
										'preview_class'=>'product_page_icon',
										'input_id'=>'product_page_icon',
										'input_class'=>'product_page_image',
										'input_name'=>'option[product_page_banner]',
										'value'=>$product_page_data->product_page_banner ?? '',
										'preview'=>$product_page_data->product_page_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>
								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
							  </form>
							</div>

							
							<div class="tab-pane fade" id="cart_page" role="tabpanel" aria-labelledby="profile-tab4">
								@php
								$cart_page=get_option('cart_page',true);
								$cart_page=$cart_page->meta ?? '';
								@endphp
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','cart_page') }}">
									@csrf
								
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $cart_page->cart_page_title ?? '' }}" name="option[cart_page_title]" class="form-control">
								</div>

								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[cart_page_description]" class="form-control">{{ $cart_page->cart_page_description ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Page Banner') }}</label>
									{{mediasection([
										'preview_class'=>'cart_page_icon',
										'input_id'=>'cart_page_icon',
										'input_class'=>'cart_page_image',
										'input_name'=>'option[cart_page_banner]',
										'value'=>$cart_page->cart_page_banner ?? '',
										'preview'=>$cart_page->cart_page_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>
								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
							  </form>
							</div>

							<div class="tab-pane fade" id="wishlist_page" role="tabpanel" aria-labelledby="profile-tab4">
								@php
								$wishlist_page=get_option('wishlist_page',true);
								$wishlist_page=$wishlist_page->meta ?? '';
								@endphp
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','wishlist_page') }}">
									@csrf
								
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $wishlist_page->wishlist_page_title ?? '' }}" name="option[wishlist_page_title]" class="form-control">
								</div>

								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[wishlist_page_description]" class="form-control">{{ $wishlist_page->wishlist_page_description ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Page Banner') }}</label>
									{{mediasection([
										'preview_class'=>'wishlist_page_icon',
										'input_id'=>'wishlist_page_icon',
										'input_class'=>'wishlist_page_image',
										'input_name'=>'option[wishlist_page_banner]',
										'value'=>$wishlist_page->wishlist_page_banner ?? '',
										'preview'=>$wishlist_page->wishlist_page_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>
								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
							  </form>
							</div>
							<div class="tab-pane fade" id="checkout_page" role="tabpanel" aria-labelledby="profile-tab4">
								@php
								$checkout_page=get_option('checkout_page',true);
								$checkout_page=$checkout_page->meta ?? '';
								@endphp
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','checkout_page') }}">
									@csrf
								
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $checkout_page->cart_page_title ?? '' }}" name="option[cart_page_title]" class="form-control">
								</div>

								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[cart_page_description]" class="form-control">{{ $checkout_page->cart_page_description ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Page Banner') }}</label>
									{{mediasection([
										'preview_class'=>'checkout_page_icon',
										'input_id'=>'checkout_page_icon',
										'input_class'=>'checkout_page_image',
										'input_name'=>'option[checkout_page_banner]',
										'value'=>$checkout_page->checkout_page_banner ?? '',
										'preview'=>$checkout_page->checkout_page_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>
								<div class="form-group">
									<label>{{ __('Checkout Form Title :') }}</label>
									<input type="text" value="{{ $checkout_page->checkout_form_title ?? '' }}" name="option[checkout_form_title]" class="form-control">
								</div>

								<div class="form-group">
									<label>{{ __('Checkout Description :') }}</label>
									<textarea name="option[checkout_form_description]" class="form-control">{{ $checkout_page->checkout_form_description ?? '' }}</textarea>
								</div>

								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
							  </form>
							</div>

							<div class="tab-pane fade" id="blog_page" role="tabpanel" aria-labelledby="profile-tab4">
								@php
								$blog_page=get_option('blog_page',true);
								$blog_page=$blog_page->meta ?? '';
								@endphp
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','blog_page') }}">
									@csrf
								
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $blog_page->blog_page_title ?? '' }}" name="option[blog_page_title]" class="form-control">
								</div>

								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[blog_page_description]" class="form-control">{{ $blog_page->blog_page_description ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Page Banner') }}</label>
									{{mediasection([
										'preview_class'=>'blog_page_icon',
										'input_id'=>'blog_page_icon',
										'input_class'=>'blog_page_image',
										'input_name'=>'option[blog_page_banner]',
										'value'=>$blog_page->blog_page_banner ?? '',
										'preview'=>$blog_page->blog_page_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>
								

								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
							  </form>
							</div>
							

							<div class="tab-pane fade" id="menu_page" role="tabpanel" aria-labelledby="profile-tab4">
								@php
								$menu_page=get_option('menu_page',true);
								$menu_page=$menu_page->meta ?? '';
								@endphp
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','menu_page') }}">
									@csrf
								<h3>{{ __('Menu page header section') }}</h3>
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $menu_page->menu_page_title ?? '' }}" name="option[menu_page_title]" class="form-control">
								</div>

								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[menu_page_description]" class="form-control">{{ $menu_page->menu_page_description ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Page Banner') }}</label>
									{{mediasection([
										'preview_class'=>'menu_page_icon',
										'input_id'=>'menu_page_icon',
										'input_class'=>'menu_page_image',
										'input_name'=>'option[menu_page_banner]',
										'value'=>$menu_page->menu_page_banner ?? '',
										'preview'=>$menu_page->menu_page_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>
								<hr>
								<h3>{{ __('Menu page product section') }}</h3>
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $menu_page->menu_product_section_title ?? '' }}" name="option[menu_product_section_title]" class="form-control">
								</div>

								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[menu_product_section_description]" class="form-control">{{ $menu_page->menu_product_section_description ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Menu page ads') }}</label>
									{{mediasection([
										'preview_class'=>'menu_page_product_ads_icon',
										'input_id'=>'menu_page_product_ads_icon',
										'input_class'=>'menu_page_product_ads_image',
										'input_name'=>'option[menu_page_product_ads_banner]',
										'value'=>$menu_page->menu_page_product_ads_banner ?? '',
										'preview'=>$menu_page->menu_page_product_ads_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>
								<div class="form-group">
									<label>{{ __('Ads Link :') }}</label>
									<input type="text" name="option[menu_page_product_ads_link]"  value="{{ $menu_page->menu_page_product_ads_link ?? '' }}" class="form-control">
								</div>
								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
							  </form>
							</div>

							<div class="tab-pane fade" id="products_page" role="tabpanel" aria-labelledby="profile-tab4">
								@php
								$products_page=get_option('products_page',true);
								$products_page=$products_page->meta ?? '';
								@endphp
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','products_page') }}">
									@csrf
								<h3>{{ __('Products page header section') }}</h3>
								<div class="form-group">
									<label>{{ __('Title :') }}</label>
									<input type="text" value="{{ $products_page->products_page_title ?? '' }}" name="option[products_page_title]" class="form-control">
								</div>

								<div class="form-group">
									<label>{{ __('Description :') }}</label>
									<textarea name="option[products_page_description]" class="form-control">{{ $products_page->products_page_description ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Page Banner') }}</label>
									{{mediasection([
										'preview_class'=>'products_page_icon',
										'input_id'=>'products_page_icon',
										'input_class'=>'products_page_image',
										'input_name'=>'option[products_page_banner]',
										'value'=>$products_page->products_page_banner ?? '',
										'preview'=>$products_page->products_page_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>
								<div class="form-group">
									<label>{{ __('Products page ads') }}</label>
									{{mediasection([
										'preview_class'=>'products_page_product_ads_banner',
										'input_id'=>'products_page_product_ads_banner',
										'input_class'=>'products_page_product_ads_banner',
										'input_name'=>'option[products_page_product_ads_banner]',
										'value'=>$products_page->products_page_product_ads_banner ?? '',
										'preview'=>$products_page->products_page_product_ads_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>
								<div class="form-group">
									<label>{{ __('Ads Link :') }}</label>
									<input type="text" name="option[products_page_product_ads_link]" class="form-control" value="{{ $products_page->products_page_product_ads_link ?? '' }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
							  </form>
							</div>

							<div class="tab-pane fade" id="settings_page" role="tabpanel" aria-labelledby="profile-tab4">
								@php
								$site_settings=get_option('site_settings',true);
								$site_settings=$site_settings->meta ?? '';
								@endphp
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','site_settings') }}">
									@csrf
								<h6>{{ __('Template primary settings') }}</h6>
								<div class="form-group">
									<label>{{ __('Footer Column 1:') }}</label>
									<textarea name="option[footer_column1]" class="form-control">{{ $site_settings->footer_column1 ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Footer Column 2:') }}</label>
									<textarea name="option[footer_column2]" class="form-control">{{ $site_settings->footer_column2 ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Footer Column 3:') }}</label>
									<textarea name="option[footer_column3]" class="form-control">{{ $site_settings->footer_column3 ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Footer Column 4:') }}</label>
									<textarea name="option[footer_column4]" class="form-control">{{ $site_settings->footer_column4 ?? '' }}</textarea>
								</div>
								
								<div class="form-group">
									<label>{{ __('Bottom Left Column:') }}</label>
									<textarea name="option[bottom_left_column]" class="form-control">{{ $site_settings->bottom_left_column ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Bottom Center Column:') }}</label>
									<textarea name="option[bottom_center_column]" class="form-control">{{ $site_settings->bottom_center_column ?? '' }}</textarea>
								</div>
								<div class="form-group">
									<label>{{ __('Bottom Right Column:') }}</label>
									<textarea name="option[bottom_right_column]" class="form-control">{{ $site_settings->bottom_right_column ?? '' }}</textarea>
								</div>
								@php
								$scroll_to_top=$site_settings->scroll_to_top ?? 'yes';
								$cart_sidebar=$site_settings->cart_sidebar ?? 'yes';
								$preloader=$site_settings->preloader ?? 'yes';
								$bottom_bar=$site_settings->bottom_bar ?? 'yes';
								@endphp
								<div class="form-group">
									<label>{{ __('Preloader') }}</label>
									<select class="form-control" name="option[preloader]">
										<option value="yes" @if($preloader == 'yes') selected="" @endif>{{ __('Enable') }}</option>
										<option value="no" @if($preloader == 'no') selected="" @endif>{{ __('Disable') }}</option>
									</select>
								</div>
								<div class="form-group">
									<label>{{ __('Scroll To Top Button') }}</label>
									<select class="form-control" name="option[scroll_to_top]">
										<option value="yes" @if($scroll_to_top == 'yes') selected="" @endif>{{ __('Enable') }}</option>
										<option value="no" @if($scroll_to_top == 'no') selected="" @endif>{{ __('Disable') }}</option>
									</select>
								</div>
								<div class="form-group">
									<label>{{ __('Cart Sidebar') }}</label>
									<select class="form-control" name="option[cart_sidebar]">
										<option value="yes" @if($cart_sidebar == 'yes') selected="" @endif>{{ __('Enable') }}</option>
										<option value="no" @if($cart_sidebar == 'no') selected="" @endif>{{ __('Disable') }}</option>
									</select>
								</div>
								
								<div class="form-group">
									<label>{{ __('Mobile bottom menubar') }}</label>
									<select class="form-control" name="option[bottom_bar]">
										<option value="yes" @if($bottom_bar == 'yes') selected="" @endif>{{ __('Enable') }}</option>
										<option value="no" @if($bottom_bar == 'no') selected="" @endif>{{ __('Disable') }}</option>
									</select>
								</div>
								
								
								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
							  </form>
							</div>


							<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="profile-tab4">
								@php
								$contact_info=get_option('contact_page',true);
								$contact_info=$contact_info->meta ?? '';
								
								@endphp
								<form method="post" class="ajaxform" action="{{ route('seller.themeoption.update','contact_page') }}">
									@csrf
								<h6>{{ __('Contact Page') }}</h6>
								<div class="form-group">
									<label>{{ __('Title') }}</label>
									<input type="text"  name="option[contact_page_title]" class="form-control" value="{{ $contact_info->contact_page_title ?? '' }}" required="">
								</div>

								<div class="form-group">
									<label>{{ __('Description') }}</label>
									<textarea name="option[contact_des]" id="" cols="30" rows="10" class="form-control">{{ $contact_info->contact_des ?? '' }}</textarea>
								</div>

								<div class="form-group">
									<label>{{ __('Page Banner') }}</label>
									{{mediasection([
										'preview_class'=>'contact_banner',
										'input_id'=>'contact_banner',
										'input_class'=>'contact_banner',
										'input_name'=>'option[contact_banner]',
										'value'=>$contact_info->contact_banner ?? '',
										'preview'=>$contact_info->contact_banner ?? 'admin/img/img/placeholder.png'
									])}}
								</div>

								<div class="form-group">
									<button class="btn btn-primary basicbtn">{{ __('Update') }}</button>
								</div>
							  </form>
							</div>

						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{ mediasingle() }} 
@endsection

@push('script')
<script src="{{ asset('admin/assets/js/summernote-bs4.js') }}"></script>
<script src="{{ asset('admin/assets/js/summernote.js') }}"></script>
<!-- JS Libraies -->
<script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('admin/plugins/dropzone/components-multiple-upload.js') }}"></script>
<script src="{{ asset('admin/js/media.js') }}"></script>
@endpush