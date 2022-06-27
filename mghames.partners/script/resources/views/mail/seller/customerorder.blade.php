<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
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

        .invoice-box table.item {
            text-align: center;
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

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            font-weight: bold;
            padding: 10px 0;
        }

        

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
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

        /* RTL */
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
        .text-left{
            text-align: left;
        }
        .text-right{
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
                            <td class="title">
                                <img height="80" width="160" src="{{ asset('uploads/'.tenant('uid').'/logo.png') }}">
                                
                            </td>
                            
                            <td>
                                <strong>Invoice No: </strong>{{ $order->invoice_no }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
           
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            @if($order->order_method == 'delivery')
                            @php
                            $shipping_price=$order->shippingwithinfo->shipping_price ?? 0;
                            $shipping_info=json_decode($order->shippingwithinfo->info ?? '');
                            $location=$order->shippingwithinfo->location->name ?? '';
                            $address=$shipping_info->address ?? '';
                            @endphp
                            @endif
                            <td>
                             @if($order->order_method == 'delivery' && !empty($ordermeta))
                               Bill To<br>
                              
                               Name: {{ $ordermeta->name ?? '' }}<br>
                               Email: {{ $ordermeta->email ?? '' }}<br>
                               Phone: {{ $ordermeta->phone ?? '' }}<br>
                               Shipping Method: {{ $order->shippingwithinfo->shipping->name ?? '' }}<br>
                               Area: {{ $location ?? '' }}<br>
                               Postal Code: {{ $shipping_info->post_code ?? '' }}
                               <br>
                               Address: {{ $address ?? '' }}
                                

                               <br>
                               @endif
                               @if($order->order_method != 'delivery')
                               Name: {{ $ordermeta->name ?? '' }}<br>
                               Email: {{ $ordermeta->email ?? '' }}<br>

                               @endif 
                           </td>
                           

                           
                           
                           <td>
                             Bill from<br>
                           
                            @if(!empty($invoice_info))
                            <strong>{{ $invoice_info->store_legal_name ?? '' }}</strong><br>
                            {{ $invoice_info->post_code ?? '' }}, {{ $invoice_info->store_legal_address ?? '' }}, <br>{{ $invoice_info->store_legal_city ?? '' }}, {{ $invoice_info->country ?? '' }}<br>
                            
                            Email: {{ $invoice_info->email ?? '' }}<br>
                            Phone: {{ $invoice_info->store_legal_phone ?? '' }}<br>
                            @endif

                           
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Payment Status: <br>


                            @if($order->payment_status==2)
                            <div class="badge">Pending</div>
                            @elseif($order->payment_status==1)
                            <div class="badge">Paid</div>
                            @elseif($order->payment_status==0)
                            <div class="badge">Cancel</div>
                            @elseif($order->payment_status==3)
                            <div class="badge">Incomplete</div>
                            @endif
                            <br>
                            Order Status: <br>


                            <div class="badge text-white" style="background-color: {{ $order->orderstatus->slug ?? '' }}">{{ $order->orderstatus->name ?? 'Waiting for fulfillment' }}</div>
                        </td>
                        
                        <td>
                            Order Date: <br>
                            {{ $order->created_at->format('d-F-Y') }} 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <table class="item">
            <tbody>
                <tr class="heading">
                    <td class="text-left">Product</td>
                                 
                    <td class="text-center">Product Price</td>
                    <td class="text-right">Totals</td>
                </tr>
                @foreach($order->orderitems ?? [] as $row)
                @php
                $variations=json_decode($row->info);

                $options=$variations->options ?? [];

                @endphp
                <tr>
                    <td class="text-left">{{ $row->term->title ?? '' }}
                        @foreach ($options ?? [] as $key => $item)
                        <br>
                        <span>{{ $key }}:</span><br>

                        @foreach($item ?? [] as $r)
                        <span>{{ __('Name:') }} {{ $r->name ?? '' }},</span>                   
                        <span>{{ __('Price:') }} {{ number_format($r->price ?? 0,2) }},</span>
                       
                        @endforeach
                        <hr>
                        @endforeach
                    </td>
                    <td class="text-center">{{ $row->amount }} × {{ $row->qty }}</td>
                    <td class="text-right">{{  number_format($row->amount*$row->qty,2) }}</td>
                </tr>
                @endforeach
                <tr class="subtotal">
                    
                    <td></td>
                    <td></td>
                    <td><hr></td>
                </tr>
               
               
                <tr class="subtotal">
                    
                    <td></td>
                    <td class="text-right"><strong>Discount:</strong></td>
                    <td class="text-right">- {{ number_format($order->discount,2) }}</td>
                </tr>
                
                <tr>
                   
                    <td></td>
                    <td class="text-right"><strong>Tax:</strong></td>
                    <td class="text-right">{{ number_format($order->tax,2) }}</td>
                </tr>
                @if($order->order_method == 'delivery')
                <tr>
                   
                    <td></td>
                    <td class="text-right"><strong>Shippping:</strong></td>
                    <td class="text-right">{{ number_format($shipping_price,2) }}</td>
                </tr>
                @endif
                 <tr class="subtotal">
                   
                    <td></td>
                    <td class="text-right"><strong>Subtotal:</strong></td>
                    @php
                    $shipping_price=$shipping_price ?? 0;
                    @endphp
                    <td class="text-right">{{ number_format($order->total-$shipping_price,2) }}</td>
                </tr>
                <tr>
                   
                    
                    <td></td>
                    
                    <td class="text-right"><strong>Total:</strong></td>
                    <td class="text-right">{{ number_format($order->total,2) }}</td>
                </tr>
            </tbody>
        </table>
    </table>
</div>
</body>
</html>