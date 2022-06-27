@extends('layouts.backend.app')

@push('css')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/dropzone.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
           <div class="card-body">
              {{mediasection()}}
           </div>
        </div>
     </div>
</div>
{{ mediasingle() }} 
@endsection

@push('script')
<!-- JS Libraies -->
<script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('admin/plugins/dropzone/components-multiple-upload.js') }}"></script>
<script src="{{ asset('admin/js/media.js') }}"></script>
@endpush