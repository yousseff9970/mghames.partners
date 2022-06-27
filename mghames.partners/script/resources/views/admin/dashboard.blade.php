@extends('layouts.backend.app')

@section('content')
<section class="section">
	<div class="row">
		<div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div class="card card-statistic-1">
				<div class="card-icon bg-primary">
					<i class="fas fa-users"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>{{ __('Customers') }}</h4>
					</div>
					<div class="card-body" id="total_subscribers">
						<img src="{{ asset('uploads/loader.gif') }}">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div class="card card-statistic-1">
				<div class="card-icon bg-danger">
					<i class="fas fa-globe"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>{{ __('Domain Request') }}</h4>
					</div>
					<div class="card-body" id="total_domain_requests">
						<img src="{{ asset('uploads/loader.gif') }}">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div class="card card-statistic-1">
				<div class="card-icon bg-warning">
					<i class="fas fa-wallet"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>{{ __('Total Earnings') }}</h4>
					</div>
					<div class="card-body" id="total_earnings">
						<img src="{{ asset('uploads/loader.gif') }}">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div class="card card-statistic-1">
				<div class="card-icon bg-success">
					<i class="fas fa-receipt"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>{{ __('Total Tax Amount') }}</h4>
					</div>
					<div class="card-body" id="total_expired_subscriptions">
						<img src="{{ asset('uploads/loader.gif') }}">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12">
			<div class="card card-statistic-2">
				<div class="card-stats">
					<div class="card-stats-title">{{ __('Order Statistics') }} -
						<div class="dropdown d-inline">
							<a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month" id="orders-month">{{ Date('F') }}</a>
							<ul class="dropdown-menu dropdown-menu-sm">
								<li class="dropdown-title">{{ __('Select Month') }}</li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='January') active @endif" data-month="January" >{{ __('January') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='February') active @endif" data-month="February" >{{ __('February') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='March') active @endif" data-month="March" >{{ __('March') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='April') active @endif" data-month="April" >{{ __('April') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='May') active @endif" data-month="May" >{{ __('May') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='June') active @endif" data-month="June" >{{ __('June') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='July') active @endif" data-month="July" >{{ __('July') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='August') active @endif" data-month="August" >{{ __('August') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='September') active @endif" data-month="September" >{{ __('September') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='October') active @endif" data-month="October" >{{ __('October') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='November') active @endif" data-month="November" >{{ __('November') }}</a></li>
								<li><a href="#" class="dropdown-item month @if(Date('F')=='December') active @endif" data-month="December" >{{ __('December') }}</a></li>
							</ul>
						</div>
					</div>
					<div class="card-stats-items">
						<div class="card-stats-item">
							<div class="card-stats-item-count" id="pending_order"></div>
							<div class="card-stats-item-label">{{ __('Pending') }}</div>
						</div>

						<div class="card-stats-item">
							<div class="card-stats-item-count" id="completed_order"></div>
							<div class="card-stats-item-label">{{ __('Completed') }}</div>
						</div>

						<div class="card-stats-item">
							<div class="card-stats-item-count" id="shipping_order"></div>
							<div class="card-stats-item-label">{{ __('Expired') }}</div>
						</div>
					</div>
				</div>
				<div class="card-icon shadow-primary bg-primary">
					<i class="fas fa-archive"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>{{ __('Total Orders') }}</h4>
					</div>
					<div class="card-body" id="total_order">

					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12">
			<div class="card card-statistic-2">
				<div class="card-chart">
					<canvas id="sales_of_earnings_chart" height="80"></canvas>
				</div>
				<div class="card-icon shadow-primary bg-primary">
					<i class="fas fa-dollar-sign"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>{{ __('Total Sales Of Earnings') }} - {{ date('Y') }}</h4>
					</div>
					<div class="card-body" id="sales_of_earnings">
						<img src="{{ asset('uploads/loader.gif') }}">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12">
			<div class="card card-statistic-2">
				<div class="card-chart">
					<canvas id="total_sales_chart" height="80"></canvas>
				</div>
				<div class="card-icon shadow-primary bg-primary">
					<i class="fas fa-shopping-bag"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>{{ __('Total Sales') }} - {{ date('Y') }}</h4>
					</div>
					<div class="card-body" id="total_sales">
						<img src="{{ asset('uploads/loader.gif') }}" class="loads">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 col-md-12 col-12 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-header-title">{{ __('Earnings performance') }} <img src="{{ asset('uploads/loader.gif') }}" height="20" id="earning_performance"></h4>
					<div class="card-header-action">
						<select class="form-control" id="perfomace">
							<option value="7">{{ __('Last 7 Days') }}</option>
							<option value="15">{{ __('Last 15 Days') }}</option>
							<option value="30">{{ __('Last 30 Days') }}</option>
							<option value="365">{{ __('Last 365 Days') }}</option>
						</select>
					</div>
				</div>
				<div class="card-body">
					<canvas id="myChart" height="145"></canvas> 
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-12 col-12 col-sm-12">
			<div class="card gradient-bottom">
				<div class="card-header">
					<h4>{{ __('Latest Expired Orders') }}</h4>

				</div>
				<div class="card-body" id="top-5-scroll">
					<ul class="list-unstyled list-unstyled-border">
						@foreach($recent_expired as $row)
						<li class="media">
							<a href="{{ route('admin.partner.show',$row->user->id) }}">
								<img class="mr-3 rounded" width="55" src="{{ asset('https://ui-avatars.com/api/?name='.$row->user->name) }}" >
							</a>
							<div class="media-body">
								<div class="float-right"><div class="font-weight-600 text-muted text-small">{{ amount_admin_format($row->order->price) }}</div></div>
								<div class="media-title"><a href="{{ url('/admin/order/'.$row->order_id) }}">{{ $row->order->invoice_no ?? '' }}</a></div>
								<div class="mt-1">
									<div class="budget-price">
										<div class="budget-price-square bg-primary" data-width="64%"></div>
										<div class="budget-price-label"><a href="{{ route('admin.store.edit',$row->id) }}">{{ $row->id }}</a></div>
									</div>
									<div class="budget-price">
										<div class="budget-price-square bg-danger" data-width="43%"></div>
										<div class="budget-price-label">{{ $row->will_expire }}</div>
									</div>
								</div>
							</div>
						</li>
						@endforeach
					</ul>
				</div>
				<div class="card-footer pt-3 d-flex justify-content-center">
					<div class="budget-price justify-content-center">
						<div class="budget-price-square bg-primary" data-width="20"></div>
						<div class="budget-price-label">{{ __('Store ID') }}</div>
					</div>
					<div class="budget-price justify-content-center">
						<div class="budget-price-square bg-danger" data-width="20"></div>
						<div class="budget-price-label">{{  __('Expired Date') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-12 col-sm-12">
			<div class="card">
				<div class="card-header">

					<h4 class="card-header-title">{{ __('Deposits') }} <img src="{{ asset('uploads/loader.gif') }}" height="20" id="deposit_performance_loader"></h4>
					<div class="card-header-action">
						<select class="form-control" id="deposit_perfomace">
							<option value="7">{{ __('Last 7 Days') }}</option>
							<option value="15">{{ __('Last 15 Days') }}</option>
							<option value="30">{{ __('Last 30 Days') }}</option>
							<option value="365">{{ __('Last 365 Days') }}</option>
						</select>
					</div>
				</div>
				<div class="card-body">
					<canvas id="depositChart" height="100"></canvas> 
				</div>
			</div>
		</div>
		<div class="col-md-12 col-12 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4><a href="{{ route('admin.order.index','status=2') }}">{{ __('Recent Domain Request') }}</a></h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-nowrap card-table text-center">
							<thead>
								<tr>
									<th>{{ __('Store Id') }}</th>
									<th>{{ __('Domain Name') }}</th>
									<th>{{ __('User') }}</th>
									<th>{{ __('Requested At') }}</th>
									<th>{{ __('Status') }}</th>
									<th class="text-right">{{ __('Action') }}</th>
								</tr>
							</thead>
							<tbody class="list font-size-base rowlink" data-link="row">
								@foreach($domains ?? [] as $key => $row)
								<tr>

									<td><a href="{{ route('admin.store.edit',$row->tenant_id) }}">{{ $row->tenant_id }}</a></td>
									<td>{{ $row->domain }}</td>
									<td><a href="{{ url('/admin/partner/'.$row->tenant->user_id) }}">{{ $row->tenant->user->name ?? '' }}</a></td>
									<td>{{ $row->created_at->diffForHumans() }}</td>
									<td>@if($row->status == 1)
				                      <span class="badge badge-success">{{ __('Active') }} </span>
				                      @elseif($row->status == 2)
				                        <span class="badge badge-warning">{{ __('Pending') }}   </span>
				                      @elseif($row->status == 3)
				                        <span class="badge badge-warning">{{ __('Expired') }}   </span>
				                      @else
				                        <span class="badge badge-danger">{{ __('Disabled') }}   </span>
				                      @endif</td>
				                   
				                    <td class="text-right">
				                      @can('domain.edit')
				                      <a href="{{ route('admin.domain.edit',$row->id) }}"><i class="far fa-edit"></i> {{ __('Edit Domain') }}</a>
				                      @endcan
				                    </td>
								</tr> 
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-12 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4><a href="{{ route('admin.order.index','status=2') }}">{{ __('Recent Orders') }}</a></h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-nowrap card-table text-center">
							<thead>
								<tr>
									<th>{{ __('Store Id') }}</th>
									<th>{{ __('TRX') }}</th>
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
							<tbody class="list font-size-base rowlink" data-link="row">
								@foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->orderlog->tenant_id ?? '' }}</td>
                            <td><a href="{{ route('admin.order.show',$order->id) }}"><small>{{ $order->trx }}</small></a></td>
                            <td><a href="{{ route('admin.partner.show',$order->user_id) }}">{{ $order->user->name }}</a></td>
                            <td><a href="{{ route('admin.plan.show',$order->plan_id) }}">{{ $order->plan->name }}</a></td>
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
                            <button class="btn btn-primary dropdown-toggle" type="button"
                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Action
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
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-12 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4><a href="{{ url('/admin/fund/history?data=2') }}">{{ __('Recent Deposits') }}</a></h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-nowrap card-table text-center">
							<tr>        
								<th>{{ __('Trx Id') }}</th>
								<th>{{ __('User Name') }}</th>
								<th>{{ __('Gateway Name') }}</th>
								<th>{{ __('Amount') }}</th>
								<th>{{ __('Payment Status') }}</th>
								<th>{{ __('Action') }}</th>
							</tr>  
							@foreach ($funds as $fund)
							<tr>
								
								<td>{{ $fund->trx }}</td>
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
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="row">
	<div class="col-lg-12 col-md-12 col-12 col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Site Analytics') }}</h4>
				<div class="card-header-action">
					<select class="form-control" id="days"> 
						<option value="7">{{ __('Last 7 Days') }}</option>
						<option value="15">{{ __('Last 15 Days') }}</option>
						<option value="30">{{ __('Last 30 Days') }}</option>
						<option value="180">{{ __('Last 180 Days') }}</option>
						<option value="365">{{ __('Last 365 Days') }}</option>
					</select>
				</div>
			</div>
			<div class="card-body">
				<canvas id="google_analytics" height="120"></canvas>
				<div class="statistic-details mt-sm-4">
					<div class="statistic-details-item">

						<div class="detail-value" id="total_visitors"></div>
						<div class="detail-name">{{ __('Total Vistors') }}</div>
					</div>
					<div class="statistic-details-item">

						<div class="detail-value" id="total_page_views"></div>
						<div class="detail-name">{{ __('Total Page Views') }}</div>
					</div>

					<div class="statistic-details-item">

						<div class="detail-value" id="new_vistors"></div>
						<div class="detail-name">{{ __('New Visitor') }}</div>
					</div>

					<div class="statistic-details-item">

						<div class="detail-value" id="returning_visitor"></div>
						<div class="detail-name">{{ __('Returning Visitor') }}</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6 col-md-6 col-12">
				<div class="card">
					<div class="card-header">
						<h4>{{ __('Referral URL') }}</h4>
					</div>
					<div class="card-body refs" id="refs" >

					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h4>{{ __('Top Browser') }}</h4>
					</div>
					<div class="card-body">
						<div class="row" id="browsers"></div>
					</div>
				</div>

			</div>

			<div class="col-lg-6 col-md-6 col-12">
				<div class="card">
					<div class="card-header">
						<h4>{{ __('Top Most Visit Pages') }}</h4>
					</div>
					<div class="card-body tmvp" id="table-body">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="base_url" value="{{ url('/') }}">
<input type="hidden" id="site_url" value="{{ url('/') }}">
<input type="hidden" id="dashboard_static" value="{{ url('/admin/dashboard/static') }}">
<input type="hidden" id="dashboard_perfomance" value="{{ url('/admin/dashboard/perfomance') }}">
<input type="hidden" id="deposit_perfomance" value="{{ url('/admin/dashboard/deposit/perfomance') }}">
<input type="hidden" id="dashboard_order_statics" value="{{ url('/admin/dashboard/order_statics') }}">
<input type="hidden" id="gif_url" value="{{ asset('uploads/loader.gif') }}">
<input type="hidden" id="month" value="{{ date('F') }}">
@endsection

@push('script')
<script src="{{ asset('admin/assets/js/chart.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('admin/js/dashboard.js') }}"></script>
@endpush