@component('mail::message')

# Dear  {{ $data['name'] }},

Please use the confirmation code below on the {{ env('APP_NAME') }} for transfer {{ $data['tenant_id'] }} to {{ $data['email'] }}<br>

<h2><b>{{ $data['otp'] }}</b></h2>

If you didn't request this please contact with support team immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent