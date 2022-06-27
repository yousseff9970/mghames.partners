@extends('layouts.frontend.app')

@section('title',$blog->title)

@section('content')
<!-- header area start -->
@include('layouts.frontend.partials.header')
<!-- header area end -->

 <!-- breadcrumb area start -->
 <section>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="breadcrumb-content text-center">
                        <h2>{{ Str::limit($blog->title,50) }}</h2>
                        <p><a href="{{ url('/') }}">{{ __('Home') }}</a> > {{ Str::limit($blog->title,100) }}</p>
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
                    <div class="single-blog-details">
                        <div class="blog-details-img">
                            <img class="img-fluid" src="{{ asset($blog->preview->value) }}" alt="">
                        </div>
                        <div class="blog-details-title">
                            <h2>{{ $blog->title }}</h2>
                        </div>
                        <div class="blog-details-content">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2v2h6V1h2v2zm3 8H4v8h16v-8zm-5-6H9v2H7V5H4v4h16V5h-3v2h-2V5zm-9 8h2v2H6v-2zm5 0h2v2h-2v-2zm5 0h2v2h-2v-2z"/></svg> <span>{{ $blog->created_at->isoFormat('LL') }}</span>
                        </div>
                        <div class="blog-details-des">
                            <p>{{ content_format($blog->description->value?? '') }}</p>
                            <p></p>
                        </div>
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
                                        @foreach ($blogs as $blog)
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