@component('mail::message')

# Title : {{ $data['title'] }}
{{ $data['message'] }} <br>
<a href="{{ $data['link'] }}"># {{ $data['ticket'] }}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent