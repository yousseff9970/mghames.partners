<section>
    <div class="header-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <div class="header-left-area">
                        @php
                             $info = get_option('theme',true);
                             $logo=$info->logo_img ?? '';
                        @endphp
                        <div class="header-logo">
                            <a href="{{ url('/') }}">
                                <img class="img-fluid" src="{{ asset('uploads/'.$logo) }}" alt="">
                            </a>
                        </div>
                        <div class="header-menu">
                            <div class="mobile-menu">
                                <a class="toggle f-right" href="#" role="button" aria-controls="hc-nav-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M14 10v4h-4v-4h4zm2 0h5v4h-5v-4zm-2 11h-4v-5h4v5zm2 0v-5h5v4a1 1 0 0 1-1 1h-4zM14 3v5h-4V3h4zm2 0h4a1 1 0 0 1 1 1v4h-5V3zm-8 7v4H3v-4h5zm0 11H4a1 1 0 0 1-1-1v-4h5v5zM8 3v5H3V4a1 1 0 0 1 1-1h4z"/></svg></a>
                            </div>
                            <nav id="main-nav">
                                <ul>
                                    <li></li>
                                    {{ThemeMenu('header','layouts.frontend.components.menu')}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                   <div class="header-right-area">
                    <div class="language-switch f-right">
                        <select name="language" class="form-select" id="language">
                            @foreach (get_option('active_languages',true) as $key => $language)
                                <option {{ App::currentLocale() == $key ? 'selected' : '' }} value="{{ $key }}">{{ $language }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="header-right-area">
                        <div class="header-btn f-right">
                            <a href="{{ route('user.register') }}">{{ __('Become A Partner') }}</a>
                        </div>
                    </div>
                   </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
