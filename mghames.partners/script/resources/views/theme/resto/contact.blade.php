@extends('theme.resto.layouts.app')

@section('content')

<!-- Start Breadcrumbs Area -->
<div class="breadcrumbs" style="background-image:url({{ asset($page_data->contact_banner ?? '') }})">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-8 col-12">
				<div class="breadcrumbs-content">
					<h1 class="page-title">{{ $page_data->contact_page_title ?? 'Contact Us' }}</h1>
					<p>{{ $page_data->contact_des ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text' }}</p>
				</div>
				<ul class="breadcrumb-nav">
					<li><a href="{{ url('/') }}"><i class="icofont-home"></i> {{ __('Home') }}</a></li>
					<li><i class="icofont-cart"></i> {{ $page_data->contact_page_title ?? 'Cart' }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!--/ End Breadcrumbs Area -->



{{-- contact area start --}}
<section>
    <div class="contact-area">
        <div class="container">
            <div class="contact-form">
                <form action="{{ url('contact/send') }}" method="POST" class="ajaxform_with_reset">
					@csrf
                    <div class="checkout-form m-top-30">
						<div class="checkout-form-inner">
							<div class="checkout-heading">
								<h2>Contact Us</h2>
							</div>
							<!-- Form -->
							<div class="row">
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>Name<span>*</span></label>
										<input type="text" name="name" placeholder="" required="required">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>Email Address<span>*</span></label>
										<input type="email" name="email" placeholder="" required="required">
									</div>
								</div>
                                <div class="col-lg-12 col-md-12 col-12">
									<div class="form-group">
										<label>Subject<span>*</span></label>
										<input type="text" name="subject" placeholder="" required="required">
									</div>
								</div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea class="form-control h-150" name="message" maxlength="300"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-btn">
                                       <button type="submit" class="btn btn-primary basicbtn">Send Message</button>
                                    </div>
                                </div>
                            </div>
							<!--/ End Form -->
						</div>
					</div>
                </form>
            </div>
            
        </div>
    </div>
</section>
{{-- contact area end --}}
@endsection


@push('js')
	<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
	<script src="{{ asset('admin/js/form.js') }}"></script>
@endpush