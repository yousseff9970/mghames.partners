@component('mail::message')

# Order No : {{ $data['data']['orderno'] }}

{{ $data['data']['message'] }} <br>
<a href="{{ $data['data']['link'] }}"># View Order</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent