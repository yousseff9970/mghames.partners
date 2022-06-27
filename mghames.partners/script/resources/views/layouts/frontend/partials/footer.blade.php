<footer>
    @php
        $info = get_option('footer_theme',true);
        $theme = get_option('theme',true);
        $logo_img=$theme->logo_img ?? '';
    @endphp
    <div class="footer-area pt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-left-area">
                        <div class="footer-img">
                           <a href="{{ url('/') }}">
                            <img class="img-fluid" src="{{ asset('uploads/'.$logo_img) }}" alt="">
                           </a> 
                        </div>
                        <div class="footer-des">
                            <p>{{ $info->address ?? '' }}</p>
                        </div>
                        <div class="footer-newsletter">
                            <form action="{{ route('subscribe') }}" method="POST" class="ajaxform_with_reset">
                                @csrf 
                                <label>{{ __('Newsletter') }}</label>
                                <div class="newsletter-input-group">
                                    <input type="email" placeholder="Email Address" name="email">
                                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories-menu">
                        <div class="categories-header">
                            <h4>{{ __('About Company') }}</h4>
                        </div>
                        <nav>
                            <ul>
                                {{ThemeMenu('footer_left_menu','layouts.components.menu')}}
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories-menu">
                        <div class="categories-header">
                            <h4>{{ __('Our Services') }}</h4>
                        </div>
                        <nav>
                            <ul>
                                {{ThemeMenu('footer_right_menu','layouts.components.menu')}}
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-contact-us">
                        <div class="categories-header">
                            <h4>{{ __('Contact Us') }}</h4>
                        </div>
                        <div class="footer-contact-email-phone">
                            <p>{{ $info->email ?? ''  }}</p>
                            <p>{{ $info->phone  ?? '' }}</p>
                        </div>
                        <div class="footer-social-icon">
                            <nav>
                                <ul>
                                    @foreach ($info->social ?? [] as $social)
                                    <li><a href="{{ $social->link }}"><span class="iconify" data-icon="{{ $social->icon }}"></span></a></li>
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom-area">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="footer-copywriter">
                            <p>{{ $info->copyright ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="footer-menu">
                            <nav>
                                <ul>
                                    {{ThemeMenu('footer','layouts.components.menu')}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>