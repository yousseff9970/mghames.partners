@if(env('CONTENT_EDITOR') == true)
{!! $data !!}
@else
{{ $data }}
@endif
