@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Media Lists'])
@endsection

@section('content')
<section class="section">
    <div class="section-body">
      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <form action="{{ route('seller.mediacompress.store') }}" method="POST" class="ajaxform_with_reload">
                @csrf
                <div class="card-body">
                <div class="float-left">
                  <div class="d-flex align-items-center">
                      <select class="form-control selectric mr-3" tabindex="-1" name="status">
                          <option selected value="">{{ __('Select Action') }}</option>
                          <option value="compress">{{ __('Make Compress') }}</option>
                      </select>
                        <select class="form-control selectric mr-3" tabindex="-1" name="compress">
                          <option value="80">{{ __('Compression level') }}</option>
                          <option value="80">{{ __('80%') }}</option>
                          <option value="70">{{ __('70%') }}</option>
                          <option value="60">{{ __('60%') }}</option>
                          <option value="50">{{ __('50%') }}</option>
                          <option value="40">{{ __('40%') }}</option>
                          <option value="30">{{ __('30%') }}</option>
                          <option value="20">{{ __('20%') }}</option>
                          <option value="10">{{ __('10%') }}</option>
                      </select>
                      <button class="btn btn-primary btn-lg basicbtn">{{ __('Compress') }}</button>
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
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('URL') }}</th>
                            <th>{{ __('Created At') }}</th>
                          </tr>
                        </thead>
                      @foreach ($posts as $media)
                      <tr>
                        <td class="text-center">
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" name="id[]" class="custom-control-input" value="{{ $media->id }}" id="media-{{ $media->id }}">
                            <label for="media-{{ $media->id }}" class="custom-control-label">&nbsp;</label>
                        </div>
                        </td>
                        <td><a href="{{ asset($media->url) }}" target="_blank"><img class="media-img" src="{{ asset($media->url) }}" alt=""></a></td>
                        <td>
                        {{ asset($media->url) }}
                        </td>
                        <td>{{ $media->created_at->toDateString() }}</td>
                      </tr>
                      @endforeach
                      </tbody>
                    </table>
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

