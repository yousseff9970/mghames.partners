@component('mail::message')
# Subject : {{ $data['subject'] }}

{{ $data['message'] }}



Thanks,<br>
{{ $data['name'] }}
@endcomponent
