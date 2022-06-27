@extends('theme.grocery.layouts.app')

@section('content')
<!-- start Registration section -->
<section class="login section mt-5 mb-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
				<div class="form-head">
					<h4 class="title">{{ __('Login') }}</h4>
					<form action="{{ route('login') }}" method="post">
						@csrf

						<div class="form-group">
							<label>Email</label>
							<input class="margin-5px-bottom" type="email" id="exampleInputEmail1" placeholder="Email" required="" name="email"  value="{{ old('email') }}" />
							
							@error('email')
							<div class="text-danger">
								{{ $message }}
							</div>
							@enderror
						</div>

						<div class="form-group">
							<label>Password</label>
							<input class="margin-5px-bottom" type="password" id="exampleInputPassword1" placeholder="Password" equired="" name="password"/>
							@error('password')
							<div class="text-danger">
								{{ $message }}
							</div>
							@enderror
						</div>
						<div class="row mt-3 mb-3">
							<div class="col-sm-6">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="remember" class="custom-control-input" id="rememberMe">
									<label class="custom-control-label" for="rememberMe">Remember Me</label>
								</div>
							</div>
							<div class="col-sm-6 text-right">
								<p class="mb-0"><a href="{{ url('/password/reset') }}" class="text-dark">{{ __('Forgot Password ?') }}</a></p>
							</div>
						</div>
						<div class="button">
							<button type="submit" class="btn btn-success">{{ __('Login') }}</button>
						</div>
						<p class="outer-link">{{ __('Dont have any account?') }} <a href="{{ url('/customer/register') }}">{{ __('Register') }}</a></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Registration section -->
@endsection