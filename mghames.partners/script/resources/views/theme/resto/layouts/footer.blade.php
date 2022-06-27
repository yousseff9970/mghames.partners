<!-- Start Footer Area  -->
      <footer class="footer">
         <div class="footer-middle">
            <div class="container">
               <div class="bottom-inner">
                  <div class="row">
                     <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer our-app">
                           {{ content_format($site_settings->footer_column1 ?? '') }}
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer f-contact">
                            {{ content_format($site_settings->footer_column2 ?? '') }}
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer f-link">
                           {{ content_format($site_settings->footer_column3 ?? '') }}
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer f-link">
                            {{ content_format($site_settings->footer_column4 ?? '') }}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="footer-bottom">
            <div class="container">
               <div class="inner-content">
                  <div class="row align-items-center">
                     <div class="col-lg-4 col-12">
                        <div class="payment-gateway">
                            {{ content_format($site_settings->bottom_left_column ?? '') }}
                        </div>
                     </div>
                     <div class="col-lg-4 col-12">
                        <div class="copyright">
                           {{ content_format($site_settings->bottom_center_column ?? '') }}
                        </div>
                     </div>
                     <div class="col-lg-4 col-12">
                        {{ content_format($site_settings->bottom_right_column ?? '') }}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- End Footer Area  -->
      <!--  scroll-top -->
      @if($site_settings->scroll_to_top ?? 'yes' == 'yes')
      <a href="#" class="scroll-top btn-hover"><i class="icofont-long-arrow-up"></i></a>
      @endif