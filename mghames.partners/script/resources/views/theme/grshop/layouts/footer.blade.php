<!--  Footer -->
      <footer class="footer-area">
         <!--  Footer Top -->
         <div class="footer-top bg-full">
            <div class="container">
               <div class="row">
                  <div class="col-lg-3 col-md-6 col-12">
                     <!-- Footer Widget -->
                     <div class="footer-widget footer-about">
                        
                        {{ content_format($site_settings->footer_column1 ?? '') }}
                     </div>
                     <!-- End Footer Widget -->
                  </div>
                  <div class="col-lg-3 col-md-6 col-12">
                     <!-- Footer Widget -->
                     <div class="footer-widget footer-links">
                       {{ content_format($site_settings->footer_column2 ?? '') }}
                     </div>
                     <!-- End Footer Widget -->
                  </div>
                  <div class="col-lg-3 col-md-6 col-12">
                     <!-- Footer Widget -->
                     <div class="footer-widget footer-links">
                        {{ content_format($site_settings->footer_column3 ?? '') }}
                     </div>
                     <!-- End Footer Widget -->
                  </div>
                  <div class="col-lg-3 col-md-6 col-12">
                     <!-- Footer Widget -->
                     <div class="footer-widget newslatter">
                         {{ content_format($site_settings->footer_column4 ?? '') }}
                         @php
                         $news_status=$site_settings->newsletter_status ?? 'no';
                         @endphp
                         @if($news_status == 'yes')
                        <div class="newsletter-inner">
                           <form  method="post" class="newsletter-area ajaxform_with_reset" action="{{ route('customer.subscribe') }}">
                              @csrf
                              <input type="email" name="email" placeholder="Your email address">
                              <button type="submit" class="basicbtn">{{ __('Subscribe Now') }}</button>
                           </form>
                        </div>
                        
                        @endif
                     </div>
                     <!-- End Footer Widget -->
                  </div>
               </div>
            </div>
         </div>
         <!-- End Footer Top -->
         <!-- Copyright -->
         <div class="copyright">
            <div class="container">
               <div class="row ">
                  <div class="col-lg-6 col-md-6 col-12">
                     {{ content_format($site_settings->bottom_left_column ?? '') }}
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                     
                     {{ content_format($site_settings->bottom_right_column ?? '') }}
                  </div>
               </div>
            </div>
         </div>
         <!-- End Copyright -->
      </footer>
      <!-- End Footer -->