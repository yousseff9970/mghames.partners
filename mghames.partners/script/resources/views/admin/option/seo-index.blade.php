@extends('layouts.backend.app')

@section('title','SEO Option List')

@section('head')
    @include('layouts.backend.partials.headersection',['title'=>'SEO Option List'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table" id="table-2">
                        <thead>
                        <tr>
                            <th>{{ __('SL.') }}</th>
                            <th>{{ __('Site Name') }}</th>
                            <th>{{ __('Mata Tag') }}</th>
                            <th>{{ __('Twitter Site Title') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $key => $val)
                        @php                                
                            $value = json_decode($val->value ?? null);
                        @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{$value->site_name}}</td>
                                <td>{{$value->matatag}}</td>
                                <td>{{$value->twitter_site_title}}</td>
                                <td>
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item has-icon" href="{{ route('admin.option.seo-edit', $val->id) }}"><i class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <p class="text-danger">{{ __('No data') }}</p>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


