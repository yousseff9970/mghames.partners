@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Domain Settings','prev'=>route('merchant.domain.list')])
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
                                    action="{{ route('merchant.destroy.subdomain', $info->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @if($info->subdomain->status == 1 && $info->status == 1)
                                 <form class="d-none" id="login_form_{{ $info->subdomain->id }}" action="{{ route('merchant.domain.login.domain', $info->subdomain->id) }}" method="POST">
                                    @csrf
                                </form>
                                <a class="btn btn-primary login-confirm" data-id="{{ $info->subdomain->id }}" href="#"><i class="fas fa-key"></i></a>
                                @endif
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
                                <a href="#" class="btn btn-success @if($info->custom_domain)
                                @if($info->custom_domain == 'off') notavaible_customdomain @endif @endif" data-toggle="modal" data-target="#createModal"><i class="{{ !empty($info->customdomain) ? 'fa fa-edit' : 'fas fa-plus-circle' }}"></i></a>
                                @if(!empty($info->customdomain))
                                <form class="d-none" id="delete_form_{{ $info->customdomain->id }}"
                                    action="{{ route('merchant.destroy.customdomain', $info->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @if($info->customdomain->status == 1 && $info->status == 1)
                                <form class="d-none" id="login_form_{{ $info->customdomain->id }}" action="{{ route('merchant.domain.login.domain', $info->customdomain->id) }}" method="POST">
                                    @csrf
                                </form>
                                <a class="btn btn-primary login-confirm" data-id="{{ $info->customdomain->id }}" href="#"><i class="fas fa-key"></i></a>
                                @endif
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
@if(!empty($info->sub_domain))
@if($info->sub_domain == 'on')
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
            <form class="ajaxform_with_reload" action="{{ route('merchant.add.subdomain',$info->id) }}" method="POST">
                @csrf
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
            <form class="ajaxform_with_reload" action="{{ route('merchant.update.subdomain',$info->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Add new subdomain') }}</label>
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control text-right" name="subdomain" placeholder="enter shop name" value="{{ str_replace('.'.env('APP_PROTOCOLESS_URL'), '', $info->subdomain->domain) }}">
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
@endif
@endif
@endif

@if($info->custom_domain)

@if($info->custom_domain == 'on')
@if(empty($info->customdomain))
<div class="modal fade" tabindex="-1" id="createModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" class="ajaxform_with_reload" accept-charset="UTF-8" action="{{ route('merchant.add.customdomain',$info->id) }}">
                @csrf
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
                    <div class="form-group">
                        <label>{{ __('Configure your DNS records') }}</label>
                        <small class="form-text text-muted">{{ $dns->dns_configure_instruction ?? '' }}</small>
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
                                    <td>{{ __('A') }}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ env('SERVER_IP') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('CNAME') }}</td>
                                    <td>{{ __('www') }}</td>
                                    <td>{{ env('CNAME_DOMAIN') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <small class="form-text text-muted">{{ $dns->support_instruction ?? '' }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary basicbtn" data-style="expand-left" data-loading-text="Verify..."><span class="ladda-label">{{ __('Connect') }}</span><span class="ladda-spinner"></span></button>
            </div>
        </form>
    </div>
</div>
</div>
@else

<div class="modal fade" tabindex="-1" id="createModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" class="ajaxform_with_reload" accept-charset="UTF-8" action="{{ route('merchant.update.customdomain',$info->id) }}">
                @csrf
                @method('PUT')
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
                    <div class="form-group">
                        <label>{{ __('Configure your DNS records') }}</label>
                        <small class="form-text text-muted">{{ $dns->dns_configure_instruction ?? '' }}</small>
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
                                    <td>{{ __('A') }}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ env('SERVER_IP') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('CNAME') }}</td>
                                    <td>{{ __('www') }}</td>
                                    <td>{{ env('CNAME_DOMAIN') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <small class="form-text text-muted">{{ $dns->support_instruction ?? '' }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary basicbtn" data-style="expand-left" data-loading-text="Verify..."><span class="ladda-label">{{ __('Connect') }}</span><span class="ladda-spinner"></span></button>
            </div>
        </form>
    </div>
</div>
</div>
@endif
@endif
@endif
@endsection
@push('script')
<script src="{{ asset('admin/js/merchant.js') }}"></script>
@endpush
