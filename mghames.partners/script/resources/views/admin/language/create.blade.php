@extends('layouts.backend.app')

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/selectric.css') }}">
@endsection

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Create Language','prev'=> route('admin.language.index')])
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<h5>{{ __('Create New Language') }}</h5>
	</div>
	<div class="card-body">
		<form action="{{ route('admin.language.store') }}" method="POST" class="ajaxform_with_reset">
			@csrf
			<div class="form-group">
				<label>{{ __('Language Name') }}</label>
				<input type="text" name="name" class="form-control" required>
			</div>
			<div class="form-group">
				<label>{{ __('Select Language') }}</label>
				<select name="language_code" class="form-control selectric">
					@foreach($countries as $row)
					<option value="{{ $row['code'] }}">{{ $row['name'] }}  -- {{ $row['nativeName'] }} -- ( {{ $row['code'] }})</option>
					@endforeach
				</select>
			</div>
			
			<button type="submit" class="btn btn-primary btn-lg basicbtn">{{ __('Submit') }}</button>
		</form>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('admin/assets/js/jquery.selectric.min.js') }}"></script>
@endsection

