@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Language','prev'=>route('seller.language.index')])
@endsection

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Create Language') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('seller.language.store') }}" method="POST" class="ajaxform_with_reset">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="language">{{ __('Select Langugae') }}</label>
                                        <select name="language" id="language" class="form-control selectric">
                                            @foreach ($languages ?? [] as $key =>  $language)
                                            <option value="{{ $key }}">{{ $language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                               
                                
                               
                                <div class="col-lg-12">
                                    <div class="f-right mr-0">
                                        <button type="submit" class="btn btn-primary btn-lg basicbtn">{{ __('Save') }}</button>
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