@extends('layouts.backend.app')

@section('title','Admins')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'All Admins','button_name'=> 'Create New Admin','button_link'=> url('seller/admin/create')])
@endsection

@section('content')
<div class="card"  >
	<div class="card-body">
		<div class="card-action-filter">
			<form method="post" class="ajaxform_with_reload" action="{{ route('seller.admins.destroy') }}">
				@csrf
				<div class="row">
					<div class="col-lg-6">
						<div class="d-flex">
							<div class="single-filter">
								<div class="form-group">
									<select class="form-control selectric" name="status">
										<option disabled selected>{{ __('Select Action') }}</option>
										<option value="1">{{ __('Active') }}</option>
										<option value="0">{{ __('Deactivate') }}</option>
									</select>
								</div>
							</div>
							<div class="single-filter">
								<button type="submit" class="btn btn-primary btn-lg ml-2 basicbtn">{{ __('Apply') }}</button>
							</div>
						</div>
					</div>
					<div class="col-lg-6"></div>
				</div>
			</div>
			<div class="table-responsive custom-table">
				<table class="table">
					<thead>
						<tr>
							<th>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input checkAll" id="selectAll">
									<label class="custom-control-label checkAll" for="selectAll"></label>
								</div>
							</th>
							<th>{{ __('Name') }}</th>
							<th>{{ __('Email') }}</th>
							<th>{{ __('Status') }}</th>
							<th>{{ __('Role') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $row)
						<tr>
							<td>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $row->id }}" value="{{ $row->id }}">
									<label class="custom-control-label" for="customCheck{{ $row->id }}"></label>
								</div>
							</td>
							<td>
								{{ $row->name }}

								<div class="hover">
									<a href="{{ route('seller.admin.edit',$row->id) }}">{{ __('Edit') }}</a>
								</div>
							</td>
							<td>
								{{ $row->email }}
							</td>
							<td>
								@if($row->status==1)
								<span class="badge badge-success">{{ __('Active') }}</span>
								@else
								<span class="badge badge-danger">{{ __('Deactive') }}</span>
								@endif
							</td>
							<td>
								
								@php
								$permissions=json_decode($row->permissions ?? '');
								@endphp
								@foreach($permissions as $r) 
								<span class="badge badge-primary">{{ $r }}</span> 
								@endforeach
							</td>
						</tr>
						@endforeach
					</tbody>
				</form>
			</table>
		</div>
	</div>
</div>
@endsection
