<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog shop" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
             <form class="modal_product_option_form quick_form" method="post" action="{{ route('add.tocart') }}">
                @csrf
                <input type="hidden" name="id" id="modal_id" >
             <div class="row no-gutters">
                <div class="col-lg-5 col-md-6  col-12">
                   <!-- Product Slider -->
                   <div class="product-gallery">
                      <div class="quickview-slider-active quick_sliders">
                         
 
                      </div>
                   </div>
                   <!-- End Product slider -->
                </div>
                <div class="col-lg-7 col-md-6 col-12">
                   <div class="product-des">
                      <!-- Description -->
                      <div class="short">
                         <div class="title-n-desc">
                            <p class="price quick_price_area"></p>
                            
                            <div class="quick_stock_area"></div>
 
                            <h2 class="quickViewtitle"></h2>
                            <p class="quickViewdescription"></p>
                         </div>
                         <div class="rating-main render_rating">
                            <ul class="rating render_star">
                               
                            </ul>
                            
                         </div>
                      </div>
                      
                      <!--/ End Description -->
                      <div class="modal-option-area">
                         
                      </div>
                       <!-- Product Buy -->
                       <div class="product-buy">
                        <div class="quantity">
                           <h6>Quantity:</h6>
                           <!-- Input Order -->
                           <div class="input-group">
                              <div class="button minus">
                                 <button type="button"  class="btn btn-primary btn-number  add_to_decrease_cart"  data-type="minus" data-field="quant[1]">
                                    <i class="icofont-minus"></i>
                                 </button>
                              </div>
                              <input type="text" readonly="" name="qty"  class="input-number  modal_input_qty" value="1">
                              <div class="button plus">
                                 <button type="button" class="btn btn-primary btn-number qty_increase" data-type="plus" data-field="quant[1]">
                                    <i class="icofont-plus"></i>
                                 </button>
                              </div>
                           </div>
                           <!--/ End Input Order -->
                        </div>
                        
                        <div class="add-to-cart">
                           
                           <button type="submit" class="btn modal_add_to_cart_btn">{{ __('Add to cart') }}</button>
                           
                           
                        </div>
                     </div>
                     <!--/ End Product Buy -->
                      <div class="cats_area"></div>
                      <p class="availability none modal_qty_display">{{ __('Availability') }} : <span class="modal_maxqty"></span> {{ __('Products In Stock') }}</p>
                      
                     
                   </div>
                </div>
             </div>
          </div>
          </form>
       </div>
    </div>
 </div>