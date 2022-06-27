@extends('layouts.backend.app')

@section('title','Brands')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Shop Special Menu Days','button_name'=> 'Create New','button_link'=> url('seller/special-menu/create')])
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Preview') }}</th>
                                    <th>{{ __('Short') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $row)
                                <tr>
                                  <td>{{ $row->name }}</td>
                                  <td><img src="{{ asset($row->preview->content ?? '') }}" height="50" alt=""></td>
                                  <td>{{ $row->featured }}</td>
                                  <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                                  <td class="">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start">
                                       
                                        <a class="dropdown-item has-icon text-warning" href="{{ route('seller.special-menu.edit', $row->id) }}"><i class="fa fa-edit"></i>{{ __('Edit') }}</a>
                                        <a class="dropdown-item has-icon delete-confirm text-danger" href="javascript:void(0)" data-id="{{$row->id}}"><i class="fa fa-trash"></i>{{ __('Delete') }}</a>
                                        <!-- Delete Form -->
                                         <form class="d-none" id="delete_form_{{ $row->id }}" action="{{ route('seller.category.destroy', $row->id) }}" method="POST">
                                       @csrf
                                       @method('delete')
                                    </form>
                                    </div>
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
</section>
@endsection

