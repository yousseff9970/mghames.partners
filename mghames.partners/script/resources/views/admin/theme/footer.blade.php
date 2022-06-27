@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h4>{{ __('Footer Theme Settings') }}</h4>
    </div>
    <div class="section-body">
        <form action="{{ route('admin.settings.footer.update') }}" class="ajaxform" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Footer Theme Settings') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <input type="text" id="address" name="address" class="form-control" value="{{ $info->address }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input type="text" id="email" name="email" class="form-control" value="{{ $info->email }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="phone">{{ __('Phone Number') }}</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="{{ $info->phone }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="copyright">{{ __('Copyright Content') }}</label>
                                <input type="text" id="copyright" name="copyright" class="form-control" value="{{ $info->copyright }}">
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4>{{ __('Footer Social Links') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group field_wrapper">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <label for="">{{ __('Iconify Icon') }}</label> <br>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">{{ __('Link') }}</label><br>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="javascript:"
                                                            class="add_button text-xxs mr-2 btn btn-primary mb-0 btn-sm  text-xxs ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                                <path
                                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                @foreach ($info->social as $key=> $social)
                                                <div class="row">
                                                    <div class="col-md-5"><br>
                                                        <input type="text" data-key="{{ $key }}"
                                                            class="form-control" value="{{ $social->icon }}" name="social[0][icon]"
                                                            placeholder="icon here">
                                                    </div>
                                                    <div class="col-md-6"><br>
                                                        <input type="text" class="form-control"
                                                            name="social[0][link]" class="" placeholder="link here" value="{{ $social->link }}">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="javascript:void(0);"
                                                            class="remove_button text-xxs mr-2 btn btn-danger mb-0 btn-sm  text-xxs mt-4"
                                                            title="Remove"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-x-circle"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                                <path
                                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col-lg-12">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('Save & Changes') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('script')
<script src="{{ asset('admin/js/custom.js') }}"></script>
@endpush