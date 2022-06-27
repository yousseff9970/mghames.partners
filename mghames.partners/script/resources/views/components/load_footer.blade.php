@if(tenant('custom_css_js') == 'on')
@if(file_exists('uploads/'.tenant('uid').'/custom.js'))
<script src="{{ asset('uploads/'.tenant('uid').'/custom.js?v='.tenant('cache_version')) }}"></script>
@endif
@endif




@if(Auth::check() == true)

@if(tenant('push_notification') == 'on' && env('FMC_SERVER_API_KEY') != null)
<input type="hidden" id="apiKey" value="{{ env('FMC_CLIENT_API_KEY') }}">
<input type="hidden" id="authDomain" value="{{ env('FMC_AUTH_DOMAIN') }}">
<input type="hidden" id="projectId" value="{{ env('FMC_PROJECT_ID') }}">
<input type="hidden" id="storageBucket" value="{{ env('FMC_STORAGE_BUCKET') }}">
<input type="hidden" id="messagingSenderId" value="{{ env('FMC_MESSAGING_SENDER_ID') }}">
<input type="hidden" id="appId" value="{{ env('FMC_APP_ID') }}">
<input type="hidden" id="measurementId" value="{{ env('FMC_MEASUREMENT_ID') }}">
<input type="hidden" id="save_token" value="{{ route('save-token') }}">
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"></script>
<script src="{{ asset('firebasestatus.js') }}"></script>
@endif
@endif
@if(tenant('pwa') == 'on')
@if(file_exists('uploads/'.tenant('uid').'/manifest.json'))
<script type="text/javascript">
    "use strict";
    
        window.onload = () => {
              'use strict';
              if ('serviceWorker' in navigator) {
                 navigator.serviceWorker.register('/sw.js?v=1.0');
               
            }
        }
</script>
@endif
@endif