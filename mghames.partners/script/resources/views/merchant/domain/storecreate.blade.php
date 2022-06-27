<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Create Store') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- css here --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/storecreate.css') }}">

</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="loader-area text-center">
                    <div class="store-loader">
                        <div class="loader"></div>
                        <div class="store-loading">
                            <h6>{{ __('Sit tight, we’re creating your store!') }}</h6>
                            <p id="command_line">{{ __('Please Wait...') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="store_create_url" value="{{ route('merchant.enroll.domain') }}">

    <!-- General JS Scripts -->
    <script src="{{ asset('admin/assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/js/merchant.js') }}"></script>
    <script src="{{ asset('admin/js/storecreate.js') }}"></script>
    
</body>
</html>