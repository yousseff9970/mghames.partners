@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section class="section">
    {{-- section title --}}
    <div class="section-header">
        <h1 class="d-inline-block mr-2">{{ __('Tax') }}</h1>
        <a href="{{ url('seller/tax/create') }}" class="btn btn-primary">{{ __('Add New') }}</a>
    </div>
    {{-- /section title --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="Search">{{ __('Search') }}</label>
                        <div class="row">
                            <input type="text" class="form-control col-lg-4 ml-2" placeholder="{{ __('search...') }}">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center table-borderless">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Details') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Icon') }}</th>
                                    <th>{{ __('Slug') }}</th>
                                    <th>{{ __('Group') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row1">
                                    <td>1</td>
                                    <td>Clothes</td>
                                    <td>Weafkg ksdj jkdsfjk gdhg kjhdfghj</td>
                                    <td>
                                        <img width="70px" height="70px" src="" alt="">
                                    </td>
                                    <td>
                                        <i class="fas fa-money"></i>
                                    </td>
                                    <td>
                                        seller-clothes
                                    </td>
                                    <td>
                                        Weareble
                                    </td>
                                    <td class="">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu tags-dropdown" x-placement="bottom-start">
                                            <a class="dropdown-item has-icon text-success" href="{{ url('seller/tax/1') }}"><i class="fa fa-eye"></i>View</a>
                                            <a class="dropdown-item has-icon text-warning" href="{{ url('seller/tax/1/edit') }}"><i class="fa fa-edit"></i>Edit</a>
                                            <a class="dropdown-item has-icon delete-confirm text-danger" href="javascript:void(0)" data-id="1"><i class="fa fa-trash"></i>Delete</a>
                                            <!-- Delete Form -->
                                            <form class="d-none" id="delete_form_1" action="http://shopifire.test/admin/order/1" method="POST">
                                                <input type="hidden" name="_token" value="dkLRqrIpmo0wapeynqjEJV9vrjxMzX0tJAqctzzt">
                                                <input type="hidden" name="_method" value="DELETE">
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

