<table>
    {{-- Inline Style for pdf --}}
    <style>
        tr {
            font-size: smaller;
        }
        .text-center {
            text-align: center;
        }
        .green {
            color: green;
        }
        .red {
            color: red;
        }
    </style>
    <thead>
    <tr>
        <th class="text-center">{{__('SL')}}</th>
        <th class="text-center">{{__('Plan Name')}}</th>
        <th class="text-center">{{__('Plan duration')}}</th>
        <th class="text-center">{{__('Gateway Name')}}</th>
        <th class="text-center">{{__('User Name')}}</th>
        <th class="text-center">{{__('Amount')}}</th>
        <th class="text-center">{{__('Exp Date')}}</th>
        <th class="text-center">{{__('Payment Status')}}</th>
        <th class="text-center">{{__('Payment ID')}}</th>
        <th class="text-center">{{__('Status')}}</th>
        <th class="text-center">{{__('Created Date')}}</th>
        <th class="text-center">{{__('Created Time')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $key=> $value)
        <tr>
            <td class="text-center">{{ $key+1 }}</td>
            <td class="text-center">{{ $value->plan->name ?? null }}</td>
            <td class="text-center">{{ $value->plan->duration ?? null }}</td>
            <td class="text-center">{{ $value->getway->name ?? null }}</td>
            <td class="text-center">{{ $value->user->name ?? null }}</td>
            <td class="text-center">{{ $value->amount ?? null }}</td>
            <td class="text-center">{{ $value->exp_date ?? null }}</td>
            <td class="text-center">
                @if($value->payment_status ==1)
                    <span class="green">Active</span>
                @elseif($value->payment_status ==2)
                    <span class="green">Pending</span>
                @elseif($value->payment_status ==3)
                    <span class="red">Expired</span>
                @else
                    <span class="red">Inactive</span>
                @endif
            </td>
            <td class="text-center">{{ $value->payment_id ?? null }}</td>
            <td class="text-center">
                @if($value->status ==1)
                    <span class="green">Active</span>
                @elseif($value->status ==2)
                    <span class="green">Pending</span>
                @elseif($value->status ==3)
                    <span class="red">Expired</span>
                @else
                    <span class="red">Inactive</span>
                @endif
            </td>
            <td class="text-center">{{ $value->created_at->format('d.m.Y') ?? null }}</td>
            <td class="text-center">{{ $value->created_at->diffForHumans() ?? null }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
