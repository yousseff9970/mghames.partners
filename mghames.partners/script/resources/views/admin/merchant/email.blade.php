@component('mail::message')

# Subject: {{ $data['subject'] }}
# Message: {{ $data['message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

