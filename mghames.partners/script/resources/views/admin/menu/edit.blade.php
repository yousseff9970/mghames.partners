@extends('layouts.backend.app')

@section('title','Edit Menu')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h4 class="mb-20">{{ __('Edit Menu') }}</h4>
				<div class="row">
					<div class="col-lg-12">
						<form method="post"  class="ajaxform" action="{{ route('admin.menu.update',$info->id) }}">
							@csrf
							@method('PUT')
							<div class="custom-form">
								<div class="form-group">
									<label for="name">{{ __('Menu Name') }}</label>
									<input type="text" name="name" class="form-control" id="name" value="{{ $info->name }}">
								</div>
								<div class="form-group">
									<label for="position">{{ __('Menu Position') }}</label>
									<select class="custom-select mr-sm-2" id="position" name="position">
										@if(!empty($positions))
										@foreach($positions as $key=>$row)
										<option value="{{ $row['position'] }}" @if($info->position == $row['position']) selected="" @endif>{{ $row['position'] }}</option>
										@endforeach
										@else
										<option value="header" @if($info->position=='header') selected="" @endif>{{ __('Header') }}</option>
										<option value="footer" @if($info->position=='footer') selected="" @endif>{{ __('Footer') }}</option>
										@endif
									</select>
								</div>
								<div class="form-group">
									<label for="lang">{{ __('Select Language') }}</label>
									<select class="custom-select mr-sm-2" id="lang" name="lang">
										@foreach($langs as $row)
										<option value="{{ $row->name }}" @if($info->lang== $row->name) selected="" @endif>{{ $row->data }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label for="position">{{ __('Menu Status') }}</label>
									<select class="custom-select mr-sm-2" id="status" name="status">
										<option value="1" @if($info->status==1) selected="" @endif>{{ __('Active') }}</option>
										<option value="0"  @if($info->status==0) selected="" @endif>{{ __('Draft') }}</option>
									</select>
								</div>
								<button class="btn basicbtn btn-primary col-12 mt-10">{{ __('Update') }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
