@extends('layouts.backend.app')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'Fund History'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link {{ $status == 'active' ? 'active' : '' }}" href="?data=1">{{ __('All') }} <span class="badge badge-{{ $status == 'active' ? 'white' : 'primary' }}">{{ $all_deposits_count }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status == 'pending' ? 'active' : '' }}" href="?data=2">{{ __('Pending') }} <span class="badge badge-{{ $status == 'pending' ? 'white' : 'primary' }}">{{ $pending_deposits_count }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status == 'failed' ? 'active' : '' }}" href="?data=0">{{ __('Failed') }} <span class="badge badge-{{ $status == 'failed' ? 'white' : 'primary' }}">{{ $failed_deposits_count }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status == 'expired' ? 'active' : '' }}" href="?data=3">{{ __('Expired') }} <span class="badge badge-{{ $status == 'expired' ? 'white' : 'primary' }}">{{ $expired_deposits_count }}</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Fund History') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.fund.approved') }}" method="POST" id="ajaxform">
                    @csrf
                    <div class="float-left">
                        <div class="d-flex align-items-center">
                            <select class="form-control selectric" tabindex="-1" name="status">
                                <option disabled selected>{{ __('Action For Selected') }}</option>
                                <option value="1">{{ __('Move to Approved') }}</option>
                                <option value="2">{{ __('Move to Pending') }}</option>
                                <option value="5">{{ __('Delete Pemanently') }}</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-lg ml-2">{{ __('Submit') }}</button>
                        </div>
                    </div>
                    <div class="float-right">
                        <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-lg">{{ __('Add Fund') }}</a>
                    </div>
                    <div class="clearfix mb-3"></div>
                        <div class="fund_section">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th class="">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkAll" id="selectAll">
                                                    <label class="custom-control-label checkAll" for="selectAll"></label>
                                                </div>
                                            </th>
                                            <th>{{ __('Trx Id') }}</th>
                                            <th>{{ __('User Name') }}</th>
                                            <th>{{ __('Gateway Name') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Payment Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>  
                                        @foreach ($funds as $fund)
                                        @php
                                        $meta=json_decode($fund->meta);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ $fund->id }}" name="multi_id[]" value="{{ $fund->id }}">
                                                    <label for="checkbox-{{ $fund->id }}" class="custom-control-label">&nbsp;</label>
                                                </div> 
                                            </td>
                                            <td><a href="javascript:void(0)" @if($fund->type == 0) data-toggle="modal" data-target="#viewstament" data-file="{{ $meta->screenshot ?? '' }}" data-comment="{{ $meta->comment ?? '' }}" @endif class="{{ $fund->type == 1 ? 'text-dark' : '' }} attachment_view">{{ $fund->trx }}</a></td>
                                            <td><a href="{{ route('admin.partner.show',$fund->user_id) }}">{{ $fund->user->name }}</a></td>
                                            <td>{{ $fund->getway->name }}</td>
                                            <td>{{ $fund->amount }}</td>
                                            <td>
                                                @if ($fund->payment_status == 1)
                                                    <div class="badge badge-primary">{{ __('Active') }}</div>
                                                @elseif($fund->payment_status == 2)
                                                    <div class="badge badge-danger">{{ __('Pending') }}</div>
                                                @elseif($fund->payment_status == 3)
                                                    <div class="badge badge-warning">{{ __('Expired') }}</div>
                                                @else 
                                                    <div class="badge badge-danger">{{ __('Failed') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($fund->payment_status == 2)
                                                    <a href="javascript:void(0)" onclick="payment_approved('{{ route('admin.fund.approved') }}','{{ $fund->id }}')" class="btn btn-primary">{{ __('Approved') }}</a>
                                                @endif
                                            </td>
                                        </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $funds->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Fund') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.fund.store') }}" method="POST" class="ajaxform_with_reset">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">{{ __('Trx ID') }}</label>
                        <input type="text" class="form-control" id="recipient-name" name="trx_id">
                    </div>
                    <div class="form-group">
                        <label for="recipient-email" class="col-form-label">{{ __('Customer Email') }}</label>
                        <input type="email" class="form-control" id="recipient-email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="recipient-email" class="col-form-label">{{ __('Select Gateway') }}</label>
                        <select class="form-control" name="gateway">
                            @foreach ($gateways as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-email" class="col-form-label">{{ __('Amount') }}</label>
                        <input type="number" class="form-control" id="recipient-email" name="amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewstament" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Comments and attachment') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="statement_comments"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
        <a  href="javascript:void(0)" target="_blank" class="btn btn-primary download_file">{{ __('Download Attachment') }}</a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script src="{{ asset('admin/js/admin.js') }}"></script>
<script src="{{ asset('admin/js/history/history.js') }}"></script>
@endpush