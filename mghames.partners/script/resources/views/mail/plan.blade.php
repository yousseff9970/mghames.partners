@component('mail::message')
# New Message

Name: {{ $data['name'] }}<br>

Message: {{ $data['message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent