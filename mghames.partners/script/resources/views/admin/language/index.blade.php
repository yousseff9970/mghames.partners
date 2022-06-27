@extends('layouts.backend.app')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Manage Language','button_name'=> 'Add New','button_link'=> route('admin.language.create')])
@endsection

@section('content')
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">{{ __('Manage Language') }}</h6>
	</div>
	<div class="card-body">
		<form class="ajaxform" action="{{ route('admin.languages.active') }}" method="post">
			@csrf
				<div class="table-responsive">
					<table class="table table-hover table-nowrap card-table text-center">
						<thead>
							<tr>
								<th class="text-left" ><input type="checkbox" class="checkAll"></th>

								<th>{{ __('Language Key') }}</th>
								<th>{{ __('Language Name') }}</th>
								<th class="text-right">{{ __('Action') }}</th>
							</tr>
						</thead>
						<tbody class="list font-size-base rowlink" data-link="row">
							@foreach($posts ?? [] as $key => $row)
							<tr>
								<td class="text-left"><input type="checkbox" @if(in_array($key, $actives)) checked="" @endif name="ids[{{ $key }}][{{ $row }}]" value="{{ $key }}"></td>
								<td>{{ $key }}</td>									
								<td>{{ $row }}</td>									
								<td class="text-right"><a href="{{ route('admin.language.show',$key) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
								<a href="{{ route('admin.languages.delete',$key) }}" class="btn btn-danger btn-sm cancel"><i class="fa fa-trash"></i></a></td>
							</tr>	
							@endforeach
						</tbody>
					</table>
				</div>
			<div class="form-group row mb-4">
				<div class="col-sm-12 col-md-12">
					<button class="btn btn-primary basicbtn" type="submit">{{ __('Save For Main Site') }}</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection