@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Add or edit domain','prev'=>route('admin.domain.index')])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h4>{{ __('Subdomain') }}</h4>
                            <div class="card-header-action">
                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#subdomain"><i class="{{ !empty($info->subdomain) ? 'fa fa-edit' : 'fas fa-plus-circle' }}"></i></a>
                                @if(!empty($info->subdomain))
                                <form class="d-none" id="delete_form_{{ $info->subdomain->id }}"
                                    action="{{ route('admin.domain.destroy', $info->subdomain->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="#" class="btn btn-danger delete-confirm" data-id={{ $info->subdomain->id }}><i class="fa fa-trash"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if(!empty($info->subdomain))
                            <p> {{ $info->subdomain->domain ?? '' }}</p>
                            @if($info->subdomain->status == 1)
                            <span class="badge badge-success">{{ __('Connected') }} </span>
                            @elseif($info->subdomain->status == 2)
                            <span class="badge badge-warning">{{ __('Pending') }}   </span>
                            @else
                            <span class="badge badge-danger">{{ __('Disabled') }}   </span>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h4>{{ __('Custom domain') }}</h4>
                            <div class="card-header-action">
                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="{{ !empty($info->customdomain) ? 'fa fa-edit' : 'fas fa-plus-circle' }}"></i></a>
                                 @if(!empty($info->customdomain))
                                <form class="d-none" id="delete_form_{{ $info->customdomain->id }}"
                                    action="{{ route('admin.domain.destroy', $info->customdomain->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="#" class="btn btn-danger delete-confirm" data-id={{ $info->customdomain->id }}><i class="fa fa-trash"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if(!empty($info->customdomain))
                            <p> {{ $info->customdomain->domain ?? '' }}</p>
                            @if($info->customdomain->status == 1)
                            <span class="badge badge-success">{{ __('Connected') }} </span>
                            @elseif($info->customdomain->status == 2)
                            <span class="badge badge-warning">{{ __('Pending') }}   </span>
                            @else
                            <span class="badge badge-danger">{{ __('Disabled') }}   </span>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(empty($info->subdomain))
<!-- Modal -->
<div class="modal fade" id="subdomain" tabindex="-1" aria-labelledby="subdomain" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subdomain">{{ __('Add Subdomain') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="ajaxform_with_reload" action="{{ route('admin.domain.store') }}">
                @csrf
                <input type="hidden" name="tenant_id" value="{{ $info->id }}">
                <input type="hidden" name="domain_type" value="2">
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Add new subdomain') }}</label>
                        <div class="form-group">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control text-right" name="subdomain" placeholder="enter shop name" value="{{ $info->id }}">
                            <div class="input-group-append">
                            <div class="input-group-text">.{{ env('APP_PROTOCOLESS_URL') }}</div>
                            </div>
                        </div>
                        <small class="form-text">{{ __('Example:') }} {example}.{{ env('APP_PROTOCOLESS_URL') }}</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary basicbtn">{{ __('Connect') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@else
<!-- Modal -->
<div class="modal fade" id="subdomain" tabindex="-1" aria-labelledby="subdomain" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subdomain">{{ __('Edit Subdomain') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="ajaxform_with_reload" action="{{ route('admin.domain.update',$info->subdomain->id) }}">
                @csrf
                @method('PUT')
                    <input type="hidden" name="tenant_id" value="{{ $info->id }}">
                    <input type="hidden" name="domain_type" value="2">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Add new subdomain') }}</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="domain" placeholder="enter subdomain" value="{{ $info->subdomain->domain }}">
                            <small class="form-text">{{ __('Example:') }} {example}.{{ env('APP_PROTOCOLESS_URL') }}</small>
                            </div>
                        </div>
                        <label>{{ __('Status') }}</label>
                        <div class="form-group">
                            <select class="form-control" name="status">
                                <option value="1" @if($info->subdomain->status == 1) selected @endif>{{ __('Connected') }}</option>
                                <option value="2" @if($info->subdomain->status == 2) selected @endif>{{ __('Pending') }}</option>
                                <option value="0" @if($info->subdomain->status == 0) selected @endif>{{ __('Disabled') }}</option>
                            </select>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary basicbtn">{{ __('Connect') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if(empty($info->customdomain))
<div class="modal fade" tabindex="-1" id="createModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" class="ajaxform_with_reload" accept-charset="UTF-8" action="{{ route('admin.domain.store') }}">
                @csrf
                 <input type="hidden" name="tenant_id" value="{{ $info->id }}">
                <input type="hidden" name="domain_type" value="2">
                <div class="modal-card card">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customdomain">{{ __('Add existing domain') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                    <div class="card-body">
                        <div id="form-errors"></div>
                        <div class="form-group">
                            <label>{{ __('Custom domain') }}</label>
                            <input class="form-control" autofocus="" name="domain" type="text" placeholder="example.com" required="">
                            <small class="form-text text-muted">{{ __('Enter the domain you want to connect.') }}</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary basicbtn" data-style="expand-left" data-loading-text="Verify..."><span class="ladda-label">{{ __('Save') }}</span><span class="ladda-spinner"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>

@else
<div class="modal fade" tabindex="-1" id="createModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" class="ajaxform_with_reload" accept-charset="UTF-8" action="{{ route('admin.domain.update',$info->customdomain->id) }}">
                @csrf
                @method('PUT')
                 <input type="hidden" name="tenant_id" value="{{ $info->id }}">
                <input type="hidden" name="domain_type" value="2">
                <div class="modal-card card">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customdomain">{{ __('Add existing domain') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                    <div class="card-body">
                        <div id="form-errors"></div>
                        <div class="form-group">
                            <label>{{ __('Custom domain') }}</label>
                            <input class="form-control" autofocus="" name="domain" type="text" placeholder="example.com" required="" value="{{ $info->customdomain->domain ?? '' }}">
                            <small class="form-text text-muted">{{ __('Enter the domain you want to connect.') }}</small>
                        </div>
                        <div id="form-errors"></div>
                        <div class="form-group">
                            <label>{{ __('Status') }}</label>
                           <select class="form-control" name="status">
                               <option value="1" @if($info->customdomain->status == 1) selected @endif>{{ __('Connect') }}</option>
                               <option value="2" @if($info->customdomain->status == 2) selected @endif>{{ __('Pending') }}</option>
                               <option value="0" @if($info->customdomain->status == 0) selected @endif>{{ __('Disabled') }}</option>
                           </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary basicbtn" data-style="expand-left" data-loading-text="Verify..."><span class="ladda-label">{{ __('Save') }}</span><span class="ladda-spinner"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

