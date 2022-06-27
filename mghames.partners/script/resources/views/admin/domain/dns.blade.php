@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'DNS Info','prev'=>route('admin.domain.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <h4>{{ __('How to connect custom domain with '.env('APP_NAME')) }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.dns.update') }}"  class="ajaxform">
                    @csrf
                    @method('PUT')                  
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Configure DNS record instructions') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="form-control" name="dns_configure_instruction" required="">{{ $info->dns_configure_instruction ?? '' }}</textarea>   
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('DNS Record Settings') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <table class="table table-nowrap card-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Record') }}</th>
                                        <th>{{ __('Value') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text"  disabled=""  placeholder="Record Type" class="form-control"  value="A" name="a_record[name]">
                                        </td>
                                        <td>
                                            <input type="text" disabled=""  class="form-control" value="" name="a_record[record]">
                                        </td>
                                        <td>
                                            <input type="text" disabled=""   placeholder="server ip" class="form-control" value="{{ env('SERVER_IP') }}" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" disabled=""  placeholder="Record Type" class="form-control" value="CNAME" name="c_record[name]">
                                        </td>
                                        <td>
                                            <input type="text" disabled=""  class="form-control" value="www" name="c_record[record]">
                                        </td>
                                        <td>
                                            <input type="text" disabled=""  placeholder="domain" class="form-control" value="{{ env('CNAME_DOMAIN') }}">
                                        </td>                                
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Support instructions') }}</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="form-control" name="support_instruction" required="">{{ $info->support_instruction ?? '' }}</textarea>   
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button type="submit" class="btn btn-primary basicbtn">{{ __('Update Information') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
