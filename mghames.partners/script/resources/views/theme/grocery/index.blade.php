@extends('theme.grocery.layouts.app')

@section('content')
<div class="hero-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 category-lists-sidebar">
                <div class="grocery-items-collection" id="categories">
                    
                </div>
            </div>
            <div class="col-lg-9 hero-fixed">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hero-area" style="background-image: url('{{ asset($page_data->hero_img ?? '') }}');">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="hero-content">
                                        <div class="hero-stay">
                                            <h3>{{ $page_data->hero_title ?? '' }}</h3>
                                            <p>{{ $page_data->hero_des ?? '' }}</p>
                                        </div>
                                        <div class="hero-btn">
                                            <div class="hero-input">
                                                <input type="text" placeholder="Here you search your product..." class="product_search">
                                            </div>
                                            <div class="hero-search-btn">
                                                <button><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z"/></svg><span>{{ __('Search') }}</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="products-section">
                            <div class="row align-items-center">
                                <div class="col-lg-6 offset-lg-3">
                                    <div class="product text-center">
                                        <h1>{{ __('Our Products') }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="latest_product">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="pagination mb-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
 <script src="{{ asset('theme/grocery/js/home.js') }}"></script>
@endpush
