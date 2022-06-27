@component('mail::message')

@if(isset($data))
@foreach ($data as $key => $item)
    {{ $key }}: {{ $item }} <br>
@endforeach
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
