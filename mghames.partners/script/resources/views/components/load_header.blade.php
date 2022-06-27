@if(tenant('custom_css_js') == 'on')
@if(file_exists('uploads/'.tenant('uid').'/custom.css'))
<script src="{{ asset('uploads/'.tenant('uid').'/custom.css?v='.tenant('cache_version')) }}"></script>
@endif
@endif


@if(tenant('pwa') == 'on')
@if(file_exists('uploads/'.tenant('uid').'/manifest.json'))
<link rel="manifest"  href="{{ asset('uploads/'.tenant('uid').'/manifest.json?v='.tenant('cache_version')) }}">
@endif
@endif