@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Subscribers','button_link'=> url('seller/notification/create'),'button_name'=>'Make Notify To User'])
@endsection

@section('content')
<section class="section">
    <div class="section-body">
      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <form action="{{ route('seller.notification.destroys') }}" method="POST" class="ajaxform_with_reload">
                @csrf
                <div class="card-body">
                <div class="float-left">
                  <div class="d-flex align-items-center">
                      <select class="form-control selectric mr-3" tabindex="-1" name="status">
                          <option selected disabled>{{ __('Select Action') }}</option>
                          <option value="delete">{{ __('Delete Pemanently') }}</option>
                      </select>

                      <button class="btn btn-primary btn-lg basicbtn">{{ __('Submit') }}</button>
                  </div>
                </div>
                <div class="clearfix mb-3"></div>
                <div class="table-responsive">
                    <table class="table table-striped">
                    <tbody>
                      <thead>
                        <tr>
                          <th class="text-center pt-2">
                          <div class="custom-checkbox custom-checkbox-table custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                              <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                          </div>
                          </th>
                          <th>{{ __('User') }}</th>
                          <th>{{ __('Token') }}</th>
                          <th>{{ __('Last Updated At') }}</th>
                      </tr>
                    </thead>
                    @foreach ($posts as $row)
                    <tr>
                        <td class="text-center">
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" name="id[]" class="custom-control-input" value="{{ $row->id }}" id="media-{{ $row->id }}">
                            <label for="media-{{ $row->id }}" class="custom-control-label">&nbsp;</label>
                        </div>
                        </td>
                        <td>@if(!empty($row->user))<a href="{{ url('/seller/user/'.$row->user->id ?? '') }}">{{ $row->user->name ?? '' }}</a> @else {{ __('Guest') }} @endif</td>
                        <td>
                        <a href="{{ route('seller.notification.show',$row->id) }}">{{ Str::limit($row->token,50) }}</a>
                        </td>
                        <td>{{ $row->updated_at }}</td>
                    </tr>
                    @endforeach
                    </tbody></table>
                </div>
                <div class="float-left">
                    {{ $posts->links('vendor.pagination.bootstrap-4') }}
                </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

