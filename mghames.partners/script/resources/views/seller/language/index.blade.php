@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Manage Language') }}</h1>
        <div class="section-header-button">
          <a href="{{ route('seller.language.create') }}" class="btn btn-primary">Create New</a>
        </div>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
          <div class="breadcrumb-item"><a href="#">{{ __('Language') }}</a></div>
          <div class="breadcrumb-item">{{ __('Manage Language') }}</div>
        </div>
    </div>
    <div class="section-body">
      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody>
                      <thead>
                        <tr>
                          <th>{{ __('Name') }}</th>
                          <th>{{ __('Code') }}</th>
                          <th class="text-right">{{ __('Delete') }}</th>
                        </tr>
                      </thead>
                    @foreach ($languages ?? [] as $language)
                    <tr>
                        <td>{{ $language->name }}</td>
                        <td>
                        {{ $language->code }}
                        </td>
                        <td class="text-right">
                          
                          <a class="btn btn-danger btn-sm delete-confirm" href="javascript:void(0)"
                            data-id={{ $language->code }}><i
                            class="fa fa-trash"></i></a>
                            <!-- Delete Form -->
                            <form class="d-none" id="delete_form_{{ $language->code }}"
                                action="{{ route('seller.language.destroy', $language->code) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection