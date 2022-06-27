@extends('theme.grshop.layouts.app')

@section('content')
<!-- start Registration section -->
<section class="login section mt-5 mb-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
				<div class="form-head">
					<h4 class="title">{{ __('Register') }}</h4>
					<form action="{{ route('customer.register') }}" method="post">
						@csrf
						<div class="form-group">
							<label>{{ __('Name') }}</label>
							<input class="margin-5px-bottom" value="{{ old('name') }}" type="text" name="name" id="exampleInputName1" required="" placeholder="Name"/>
							@error('name')
							<span class="text-danger" >
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="form-group">
							<label>{{ __('Email') }}</label>
							<input class="margin-5px-bottom" value="{{ old('email') }}" type="email" name="email" id="exampleInputEmail1" required placeholder="Email"/>
							@error('email')
							<span class="text-danger" >
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="form-group">
							<label>{{ __('Password') }}</label>
							<input class="margin-5px-bottom" name="password" type="password" id="exampleInputPassword1" required placeholder="Password"/>
							@error('password')
							<span class="text-danger" >
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="form-group">
							<label>{{ __('Confirm Password') }}</label>
							<input class="margin-5px-bottom" required name="password_confirmation" type="password" id="exampleInputPassword1" placeholder="Password"/>
						</div>
						
						<div class="button">
							<button type="submit" class="btn btn-success">{{ __('Register') }}</button>
						</div>
						<p class="outer-link">{{ __('Already have an account?') }} <a href="{{ url('/customer/login') }}">{{ __('Login') }}</a></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Registration section -->
@endsection