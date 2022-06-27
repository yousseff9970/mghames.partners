@extends('layouts.backend.app')

@section('content')
<div class="row">
  <div class="col-12 mt-2">
    <div class="card">
      <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover text-center table-borderless">
              <thead>
                <tr>
                 <th>{{ __('Store Id') }}</th>
                 <th>{{ __('User') }}</th>
                 <th>{{ __('Plan') }}</th>
                 <th>{{ __('Gateway') }}</th>
                 <th>{{ __('Amount') }}</th>
                 <th>{{ __('Tax') }}</th>
                 <th>{{ __('Status') }}</th>
                 <th>{{ __('Payment') }}</th>
                 <th>{{ __('Order Created')}}</th>
                 <th>{{ __('Action') }}</th>
               </tr>
              </thead>
              <tbody>
                @foreach ($orders as $order)
                <tr>
                  <td>{{ $order->orderlog->tenant_id ?? '' }}</td>
                  <td>{{ $order->user->name }}</td>
                  <td>{{ $order->plan->name }}</td>
                  <td>{{ $order->getway->name }}</td>
                  <td>{{ number_format($order->price,2) }}</td>
                  <td>{{ number_format($order->tax,2) }}</td>
                  <td>
                    @php
                    $status = [
                    0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
                    1 => ['class' => 'badge-success', 'text' => 'Accepted'],
                    2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                    3 => ['class' => 'badge-danger', 'text' => 'Expired'],
                    4 => ['class' => 'badge-secondary', 'text' => 'Trash'],
                    ][$order->status];
                    @endphp
                    <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                  </td>
                  <td>
                  @php
                  $payment_status = [
                  0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
                  1 => ['class' => 'badge-success', 'text' => 'Accepted'],
                  2 => ['class' => 'badge-warning', 'text' => 'Pending'],
                  3 => ['class' => 'badge-danger', 'text' => 'Expired'],
                  4 => ['class' => 'badge-secondary', 'text' => 'Trash'],
                  ][$order->payment_status];
                  @endphp
                  <span class="badge {{ $payment_status['class'] }}">{{ $payment_status['text'] }}</span>
                </td>
                <td>{{ $order->created_at->diffForHumans() }}</td>
                <td>
                  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    {{ __('Action') }}
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item has-icon"
                    href="{{ route('admin.order.show', $order->id) }}"><i
                    class="fa fa-eye"></i>{{ __('View') }}</a>
                    <a class="dropdown-item has-icon"
                    href="{{ route('admin.order.edit', $order->id) }}"><i
                    class="fa fa-edit"></i>{{ __('Edit') }}</a>
                    <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)"
                    data-id={{ $order->id }}><i
                    class="fa fa-trash"></i>{{ __('Delete') }}</a>
                    <!-- Delete Form -->
                    <form class="d-none" id="delete_form_{{ $order->id }}"
                      action="{{ route('admin.order.destroy', $order->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $orders->links('vendor.pagination.bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection