<?php
    $dnl="\n\n";
    $nl="\n\n";
    $tabSpace="      ";
?>
{{ __("Hi, I'd like to place an order")." 👇"}}


{{"*".__('Order No').": ".$info->invoice_no."*"}}

---------

<?php
foreach($info->orderitems ?? [] as $row){
    $lineprice = $row->qty.' X '.$row->term->title ." - ".number_format($row->amount*$row->qty,2);
    
    $variations=json_decode($row->info ?? '');
    $options=$variations->options ?? [];

    foreach ($options ?? [] as $key => $item){
        $lineprice .=$nl.$tabSpace.__('Variant:')." ". $key .' - ';
        foreach($item ?? [] as $r){
             $lineprice .=' '.$r->name ?? '';
             $lineprice .=',';
        }
    }

?>
{{ $lineprice }}

<?php
}
?>

---------
@if($info->order_method == 'delivery')
@php
$shipping_price=$info->shippingwithinfo->shipping_price ?? 0;
@endphp
{{ __('Shipping Fee: ').number_format($shipping_price,2) }}
@endif
@php
$shipping_price=$shipping_price ?? 0;
@endphp
{{ __('Tax: ').number_format($info->tax,2) }}
{{ __('Discount: ') }} - {{ number_format($info->discount,2) }}
{{ __('Subtotal: ').number_format($info->total-$shipping_price,2) }}
{{ __('Total: ').number_format($info->total,2) }}
---------

@if(!empty($info->ordermeta))
@php
$ordermeta=json_decode($info->ordermeta->value ?? '');
@endphp
{{ __('My Information') }}

{{ __('Name: ').$ordermeta->name ?? '' }}
{{ __('Email: ').$ordermeta->email ?? '' }}
{{ __('Phone: ').$ordermeta->phone ?? '' }}

@endif