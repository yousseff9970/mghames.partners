@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Edit Service') }}</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Edit Service') }}</h4>
                        
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.service.update',$service->id) }}" method="POST" class="ajaxform">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $service->title }}"> 
                                    </div>
                                </div>
                                @php
                                    $info = json_decode($service->servicemeta->value ?? '');
                                @endphp
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="short_content">{{ __('Short Content') }}</label>
                                        <textarea name="short_content" id="short_content" cols="30" rows="5" class="form-control">{{ $info->short_content }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description">{{ __('Description') }}</label>
                                        <textarea name="description" id="description" cols="40" rows="15" class="form-control">{{ $info->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" name="image"> 
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="status">{{ __('Status') }}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option {{ $service->status == 1 ? 'selected' : '' }} value="1">{{ __('Active') }}</option>
                                            <option {{ $service->status == 0 ? 'selected' : '' }} value="0">{{ __('Deactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="button-btn float-right">
                                        <button type="submit" class="btn btn-primary btn-lg">{{ __('Save & Changes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection