@extends('layouts.frontend.app')

@section('title','Blog Lists')

@section('content')
<!-- header area start -->
@include('layouts.frontend.partials.header')
<!-- header area end -->

<!-- breadcrumb area start -->
 <section>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="breadcrumb-content text-center">
                        <h2>{{ __('Blog Lists') }}</h2>
                        <p><a href="{{ url('/') }}">{{ __('Home') }}</a> > {{ __('Blog Lists') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb area end -->

<!-- blog area start -->
<section>
    <div class="blog-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @if($blogs->count() > 0)
                        @foreach ($blogs as $blog)
                        <div class="col-lg-6">
                            <div class="single-blog">
                                <div class="blog-img">
                                    <img class="img-fluid" src="{{ asset($blog->preview->value) }}" alt="">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-author-date">
                                        <span>{{ $blog->created_at->toDateString() }}</span>
                                    </div>
                                    <div class="blog-title">
                                        <h2>{{ $blog->title }}</h2>
                                    </div>
                                    <div class="blog-des">
                                        <p>{{ $blog->excerpt->value }}</p>
                                    </div>
                                    <div class="blog-action">
                                        <a href="{{ route('blog.show',$blog->slug) }}">{{ __('Read Story') }} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg></a>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        @endforeach
                        @else 
                        <div class="col-lg-12">
                            <div class="blog-no-found-data text-center">
                                <p>{{ __('No Found Data!😓😢😪') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="blog-sidebar">
                                    <div class="blog-searchbar">
                                        <div class="blog-searchbar-header">
                                            <h2>{{ __('Search') }}</h2>
                                        </div>
                                        <form action="{{ route('blog.search') }}" method="GET">
                                            @csrf
                                            <div class="searchbar-input">
                                                <input type="text" placeholder="{{ __('Search...') }}" name="search">
                                                <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z"/></svg></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="blog-sidebar-header-title">
                                    <h2>{{ __('Recent Blogs') }}</h2>
                                </div>
                                <div class="blog-body-area">
                                    <div class="row">
                                        @foreach ($recent_blogs as $blog)
                                        <div class="col-lg-12">
                                            <div class="sidebar-blog">
                                                <div class="sidebar-blog-img">
                                                    <a href="{{ route('blog.show',$blog->slug) }}">
                                                        <img class="img-fluid" src="{{ asset($blog->preview->value) }}" alt="">
                                                    </a>
                                                </div>
                                                <div class="sidebar-blog-content">
                                                    <a href="{{ route('blog.show',$blog->slug) }}">
                                                        <h2>{{ $blog->title }}</h2>
                                                    </a>
                                                    <p>{{ $blog->created_at->isoFormat('ll') }}</p>
                                                </div>
                                            </div>
                                        </div> 
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- blog area end -->

<!-- footer area start -->
@include('layouts.frontend.partials.footer')
<!-- footer area end -->
@endsection