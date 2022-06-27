@extends('layouts.backend.app')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Developer mode','prev'=>route('merchant.domain.list')])
@endsection

@section('content')
<section class="section">
  <div class="section-body">
    <h2 class="section-title"><b class="text-danger">{{ __('Note:') }}</b></h2>
    <p class="section-lead">{{ __('this section is for developers if you are not a developer then dont do anything') }}</p>
    <div class="row">
      @if($info->tenancy_db_name != null)
        <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                <h4>{{ __('Database Migrate Fresh With Demo Import') }}</h4>
            </div>
            <div class="card-body">
                <p>{{ $instruction->db_migrate_fresh_with_demo ?? '' }}</p>
            </div>
            <div class="card-footer bg-whitesmoke">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">{{ __('Proceed') }}</button>
            </div>
        </div>
        </div>
         <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                <h4>{{ __('Database Migrate For New Table') }}</h4>
            </div>
            <div class="card-body">
                <p>{{ $instruction->db_migrate ?? '' }}</p>
            </div>
            <div class="card-footer bg-whitesmoke">
                <button class="btn btn-primary" data-toggle="modal" data-target="#migrate">{{ __('Proceed') }}</button>
            </div>
        </div>
        </div>
      @endif
      @if(env('CACHE_DRIVER') == 'memcached' ||  env('CACHE_DRIVER') == 'redis')
       <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                <h4>{{ __('Remove Store Cache') }}</h4>
            </div>
            <div class="card-body">
                <p>{{ $instruction->remove_cache ?? '' }}</p>
            </div>
            <div class="card-footer bg-whitesmoke">
                 <button class="btn btn-primary" data-toggle="modal" data-target="#cache">{{ __('Proceed') }}</button>
            </div>
        </div>
        </div> 
        @endif
        <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                <h4>{{ __('Clear Storage') }}</h4>
            </div>
            <div class="card-body">
                <p>{{ $instruction->remove_storage ?? '' }}</p>
            </div>
            <div class="card-footer bg-whitesmoke">
                <button class="btn btn-primary" data-toggle="modal" data-target="#remove_storage">{{ __('Proceed') }}</button>
            </div>
        </div>
        </div>
    </div>
</div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="ajaxform" action="{{ route('merchant.domain.migrate-seed',$info->id) }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Database Migrate Fresh With Demo Import') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ $instruction->db_migrate_fresh_with_demo ?? '' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn btn-primary basicbtn">{{ __('Submit') }}</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="migrate" tabindex="-1" aria-labelledby="migrate" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="ajaxform" action="{{ route('merchant.domain.migrate',$info->id) }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="migrate">{{ __('Database Migrate For New Table') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ $instruction->db_migrate ?? '' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn btn-primary basicbtn">{{ __('Submit') }}</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="migrate" tabindex="-1" aria-labelledby="migrate" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="ajaxform" action="{{ route('merchant.domain.migrate',$info->id) }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="migrate">{{ __('Database Migrate For New Table') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ $instruction->db_migrate ?? '' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn btn-primary basicbtn">{{ __('Submit') }}</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="cache" tabindex="-1" aria-labelledby="cache" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="ajaxform" action="{{ route('merchant.domain.clear-cache',$info->id) }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >{{ __('Remove Store Cache') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ $instruction->remove_cache ?? '' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn btn-primary basicbtn">{{ __('Submit') }}</button>
      </div>
     </form>
    </div>
  </div>
</div>
<div class="modal fade" id="remove_storage" tabindex="-1" aria-labelledby="remove_storage" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="ajaxform" action="{{ route('merchant.domain.storage.clear',$info->id) }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cache">{{ __('Remove Storage') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ $instruction->remove_storage ?? '' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn btn-primary basicbtn">{{ __('Submit') }}</button>
      </div>
     </form>
    </div>
  </div>
</div>
@endsection



