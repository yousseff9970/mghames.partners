
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment-invoice</title>
    {{-- Inline Style for pdf --}}
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }


        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .last-item {
            font-weight: 700;
            text-align: right;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            {{config('app.name')}}
                        </td>

                        <td>
                            {{__('Date :')}} {{\Carbon\Carbon::now()->format('M d Y')}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>User Info<br></td>

                        <td>
                            {{$data->user->name}}<br>
                            {{$data->user->email}}<br>
                            {{$data->user->phone}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>Title</td>
            <td>Details</td>
        </tr>

        <tr class="item">
            <td>Order Created Date:</td>
            <td>{{$data->created_at->format('M d Y')}}</td>
        </tr>
        <tr class="item">
            <td>Order Will Be Expired:</td>
            <td>{{$data->will_expire}}</td>
        </tr>

        <tr class="item">
            <td>Order Amount:</td>
            <td>{{$data->price ?? 'null'}}</td>
        </tr>
        <tr class="item">
            <td>{{__('Plan Name')}}</td>
            <td>{{$data->plan->name}}</td>
        </tr>

        @if ($data->tenant->id)
        <tr class="item">
            <td>{{__('Tenant')}}</td>
            <td>{{$data->tenant->id ?? ''}}</td>
        </tr>
        @endif
        
        <tr class="item">
            <td>{{__('Payment Mode')}}</td>
            <td>{{$data->getway->name}}</td>
        </tr>
        <tr class="item">
            <td>{{__('Payment Id')}}</td>
            <td>{{$data->trx}}</td>
        </tr>
        <tr class="item">
            <td>{{__('Status')}}</td>
            <td>
                @if($data->status ==1)
                    <span>Active</span>
                @elseif($data->status ==2)
                    <span>Pending</span>
                @elseif($data->status ==3)
                    <span>Expired</span>
                @endif
            </td>
        </tr>
    </table>
</div>
</body>
</html>
