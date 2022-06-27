"use strict";

var currency_name = $('#currency_name').val();
var cart_link = $('#cart_link').val();
var base_url = $('#base_url').val();
var preloader= $('#preloader').val();
var cart_increment = $('#cart_increment').val();
var cart_decrement = $('#cart_decrement').val();
var defaut_img=base_url+'/uploads/default.png';
const cart_content = JSON.parse($('#cart_content').val());

 /*====================================
        render_product_preloaded
    ======================================*/
function render_product_preloaded(preload_count = 6, target,additional_class='',pre_class='') {
    var html = `<div class="${pre_class}"><div class="single-product content-preloader ${additional_class}" style="width:100%">
                     <div class="product-head">
                        <div class="image-colors">
                           <div class="image-colors content-placeholder" data-height="205px" data-width="100%"></div>
                        </div>
                     </div>
                     <div class="product-content">
                        <h3 class="content-placeholder" data-height="12px" data-width="100%"></h3>
                        <div class="product-button prc-button content-placeholder" data-height="30px" data-width="100%"> 
                        </div>
                     </div>
               </div></div>`;
    for (var i = 1; i <= preload_count; i++) {
        $(target).append(html);
    }
}

 /*====================================
        render_primary_product
    ======================================*/
function render_primary_product(products, target,additional_class='',visible_badge=false) {
    
    var base_url = $('#base_url').val();
   

    var listview= $('.grid_products_area').length != 0 ? true : false;

    $.each(products, function(key, product) {

        var preview = product.preview != null ? product.preview.value : base_url + '/uploads/default.png';
        var badge='';

        if (visible_badge == true) {
          
            $.each(product.features, function(k, feature) {
                badge =`<div class="p-badge popular">${feature.name}</div>`;
               
            });

        }
       
       
         if (product.is_variation == 1 ) {
            var lastprice=  product.lastprice ? product.lastprice.price : 0;
            
            var price= product.firstprice.price == lastprice ? lastprice :  product.firstprice.price +' - '+ lastprice;
          
        }
        else{
            var price= product.firstprice.old_price == null ? product.firstprice.price : product.firstprice.price + ` <del class="pr-sale">${amount_format(product.firstprice.old_price,'icon')}</del>`;
        }

        var price=amount_format(price,'icon');

        var countDown='';
         

        if (product.discount != null) {
            countDown=`<div class="count-down-time">
                        <div class="clearfix" data-countdown="${product.discount.ending_date}"></div>
                        </div>`;
        }

        

         if (product.is_variation == 1) {
              

             var cart_html=`<div class="product-button">
                                            <a href="${base_url+'/product/'+product.slug}" class="theme-btn prodcut-btn"><i class="icofont-search"></i> View Product</a>
                                        </div>`;                               
        }
        else{
            if (product.firstprice.stock_status == 0) {
                 
                 var cart_html=`<div class="product-button">
                                            <a href="${base_url+'/product/'+product.slug}" class="theme-btn prodcut-btn bg-danger"><i class="icofont-not-allowed"></i> Stock Out</a>
                                        </div>`;                           
            }
            else{
                var cart_html=`<div class="product-button prc-button">
                           <a class="pc-btn theme-btn prodcut-btn"><i class="icofont-cart"></i> Add To Cart</a>
                           <div class="quantity">
                              <div class="input-group">
                                 <div class="button minus">
                                    <button type="button" class="btn btn-primary btn-number add_to_decrease_cart add_to_decrease_cart${product.id}" data-id="${product.id}"  disabled="disabled" data-type="minus" data-field="quant[${product.firstprice.stock_status == 1  ? 1 : 0}]"><i class="icofont-minus"></i></button>
                                 </div>
                                 <input type="number" readonly name="quant[${product.id}]" class="input-number cart_qty${product.id}" ${product.firstprice.stock_status == 0  ? 'disabled' : ''} data-min="${product.firstprice.stock_status == 1  ? 1 : 0}" data-isvariation="${product.is_variation}"  data-id="${product.id}" data-stockstatus="${product.firstprice.stock_status}" data-stockmanage="${product.firstprice.stock_manage}" data-max="${product.firstprice.qty}" value="0">
                                 <div class="button plus">
                                    <button type="button" class="btn btn-primary btn-number add_to_cart cart${product.id}" data-type="plus" ${product.firstprice.stock_status == 0  ? 'disabled' : ''} data-min="${product.firstprice.stock_status == 1  ? 1 : 0}" data-isvariation="${product.is_variation}"  data-id="${product.id}" data-stockstatus="${product.firstprice.stock_status}" data-stockmanage="${product.firstprice.stock_manage}" data-qty="${product.firstprice.qty}"  data-max="${product.firstprice.qty}"  data-field="quant[${product.firstprice.stock_status == 1  ? 1 : 0}]"><i class="icofont-plus"></i></button>
                                 </div>
                              </div>
                           </div>
                        </div>`;  
            }
          
        }
        

        
        
        var ratings='';

         for (var i = 1; i <= 5; i++) {
            var review_full=`<li><i class="icofont-star star"></i></li>`;
            var review_half=`<li><i class="icofont-star"></i></li>`;

            i > product.rating ? ratings += review_half: ratings += review_full;
        }

        var rating_html=`<div class="rating-main">
                    <ul class="rating">

                    ${product.rating != null ? ratings : ''}
                    </ul>
                    <a href="#" class="total-review">${product.rating != null ? '('+product.rating+')' : ''}</a>
               </div>`;
       
        var listViewHtml=`<div class="single-product gr-list product-item">
    <!-- Product Head -->
    <div class="product-head">
        ${badge}
        <div class="image-colors"><img class="lazy grid_img" height="450" src="${preloader}" data-src="${preview}"></div>
        <!-- Button Head -->
        <div class="button-head">
            <!-- Action  Button -->
            <div class="product-action">
                <a data-bs-toggle="modal" class="add_to_cart_modal" data-id="${product.id}" data-bs-target="#exampleModal" title="Quick View" href="#"><i class="icofont-eye-alt"></i><span>Quick Shop</span></a>
                <a title="Wishlist" href="javascript:void(0)" data-id="${product.id}" class="add_to_wishlist wishlist${product.id}"><i class="icofont-heart"></i><span>Add to Wishlist</span></a>
                <a title="View Product" href="${base_url+'/product/'+product.slug}" ><i class="icofont-search"></i><span>View Product</span></a>
               
            </div>
            <!-- Action to Cart Button -->
            <div class="product-action-2">
                 <a title="Add to cart" href="${base_url+'/product/'+product.slug}">View Product</a>
            </div>
        </div>
    </div>
    <!-- Product Content -->
    <div class="product-content">
        ${countDown}
       
        <!-- Product Title -->
        <h3 class="product-title"><a href="${base_url+'/product/'+product.slug}">${product.title}</a></h3>
        <p>${product.excerpt != null ? product.excerpt.value : ''}</p>
        <!-- Product Price -->
        <div class="product-price">
            <b>${price}</b>
        </div>
        <!-- Ratting -->
        ${product.rating != null ? rating_html : ''}
        <!-- Product Button -->
        ${cart_html}
    </div>
</div>`;

           

            var html=`<div class="single-product ${additional_class}">
                     <!-- Product Head -->
                     <div class="product-head">
                        ${badge}
                        <div class="image-colors"><img class="lazy" src="${preloader}" data-src="${preview}"></div>
                        <!-- Button Head -->
                        <div class="button-head">
                           <!-- Action  Button -->
                           <div class="product-action">
                              <a  data-bs-toggle="modal"  class="add_to_cart_modal" data-id="${product.id}" data-bs-target="#exampleModal" href="#"><i class="icofont-eye-alt"></i><span>Quick Shop</span></a>
                              <a title="Wishlist" href="javascript:void(0)" data-id="${product.id}" class="add_to_wishlist wishlist${product.id}"><i class="icofont-heart"></i><span>Add to Wishlist</span></a>
                              <a title="View Product" href="${base_url+'/product/'+product.slug}" ><i class="icofont-search"></i><span>View Product</span></a>
                           </div>
                           <!-- Action to Cart Button -->
                           <div class="product-action-2">
                              <a title="Add to cart" href="${base_url+'/product/'+product.slug}">View Product</a>
                           </div>
                        </div>
                     </div>
                     <!-- Product Content -->
                     <div class="product-content">
                        ${countDown}
                       
                        <!-- Product Title -->
                        <h3 class="product-title"><a href="${base_url+'/product/'+product.slug}">${str_limit(product.title,20)} </a></h3>
                        <!-- Product Price -->
                        <div class="product-price">
                           <b>${price}</b>
                        </div>
                        <!-- Ratting -->
                          ${product.rating != null ? rating_html : ''}
                        <!-- Product Button -->
                        ${cart_html}
                     </div>
                  </div>`;

            listview == true ? $('.grid_products_area').append(listViewHtml) : '';                                             


             $(target).append(html);

    });
    
    run_lazy();
    
    
}


 /*====================================
        render_reviews
    ======================================*/
function render_reviews(data,target) {
    $.each(data, function(key, row) {
        var html=`<div class="col-lg-4 col-md-6 col-12">
                  <div class="single-testimonial">
                     <div class="text">
                        <p>${escapeHtml(row.comment)}</p>
                     </div>
                     <div class="testi-author">
                        <div class="image">
                           <div class="quote-icon"><i class="icofont-quote-left"></i></div>
                           <img src="https://ui-avatars.com/api/?background=random&rounded=true&name=${escapeHtml(row.user.name)}" alt="#">
                        </div>
                        <h4 class="name"> ${escapeHtml(row.user.name)} </h4>
                     </div>
                  </div>
               </div>`;
        $(target).append(html);       
    });

    testimonial_slider()
}

 /*====================================
        render_discountable_product
    ======================================*/
function render_discountable_product(products, target) {
     var base_url = $('#base_url').val();


    $.each(products, function(key, product) {

        if (product.is_variation == 1 ) {
            var lastprice=' - ' + product.lastprice.price > 0 ? product.lastprice.price : '';
           
            var price= product.firstprice.price + lastprice;
        }
        else{
            var price= product.firstprice.old_price == null ? product.firstprice.price : product.firstprice.price + ` <span>${product.firstprice.old_price}</span>`;
        }

        var price=amount_format(price,'icon');

        var preview = product.preview != null ? product.preview.value : base_url + '/uploads/default.png';
        var ratings='';

         for (var i = 1; i <= 5; i++) {
            var review_full=`<li><i class="icofont-star star"></i></li>`;
            var review_half=`<li><i class="icofont-star"></i></li>`;

            i > product.rating ? ratings += review_half: ratings += review_full;
        }
       

   var html=` <div class="col-lg-6 col-md-6 col-6">
                        <!-- Start Single Deal -->
                        <div class="single-deal">
                           <div class="row align-items-center">
                              <div class="col-lg-5 col-md-5 col-12">
                                 <div class="image">
                                   <a href="${base_url+'/product/'+product.slug}"> <img class="lazy" src="${preloader}" data-src="${preview}" alt=""/></a>
                                 </div>
                              </div>
                              <div class="col-lg-7 col-md-7 col-12">
                                 <div class="content">
                                    <h3><a href="${base_url+'/product/'+product.slug}">${str_limit(product.title,20)}</a></h3>
                                    <p>
                                       ${str_limit(product.excerpt != null ? product.excerpt.value : '',30)}
                                    </p>
                                    <div class="price">
                                       <h5>${price}</h5>
                                    </div>

                                    <div class="rating-main">
                                       <ul class="rating">
                                          ${ratings != '' ? ratings : ''}
                                       </ul>
                                       <a href="${base_url+'/product/'+product.slug}" class="total-review">${product.rating != null ? '('+product.rating+') Review' : ''}</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- End Single Deal -->
                     </div>`;

                      $(target).append(html);
                 });
     run_lazy();
}

 /*====================================
        Add To Cart Product
    ======================================*/
$(document).on('click', '.add_to_cart', function() {
    var id = $(this).data('id');
    var stockstatus = $(this).data('stockstatus');
    var stockmanage = $(this).data('stockmanage');
    var stockqty = $(this).data('qty');
    var input_qty=$('.input_qty'+id).val();

    if (stockstatus == 0) {
        Sweet('error', 'Stock Out');

        return true;
    }
   

    var ajax_request=true;

    if (stockmanage == 1) {
        if ($('.exist_cart' + id).length != 0) {
            var exisist_cart = $('.exist_cart' + id).val();
            exisist_cart = parseInt(exisist_cart);
          
            if (exisist_cart >= stockqty || exisist_cart >= input_qty || input_qty >= stockqty) {
                Sweet('error', 'Opps maximum stock limit exceeded...!!');

                ajax_request= false;
            }


        }
        else{
            ajax_request=true;
        }
    }

   

    if (ajax_request == true) {
    var btn_html = $(this).html();
    $(this).attr('disabled', '');
    var spinner = `<div class="spinner-border spinner-border-sm" role="status">
    <span class="visually-hidden"></span>
    </div>`;
    $(this).html('');
    $(this).html(spinner);
    var qty = $('.cart_qty' + id).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: cart_link,
        data: {
            id: id,
            qty: 1
        },
        dataType: 'json',
        success: function(response) {
            $('.cart' + id).html(btn_html);
            $('.cart' + id).removeAttr('disabled');
            $('.cart_decrement_'+id).removeAttr('disabled');
            $('.add_to_decrease_cart'+id).removeAttr('disabled');
            
            $('.cart_subtotal').html(amount_format(response.cart_subtotal));
            
            $('.cart_count').html(response.cart_count);
            $('.cart_total').html(response.cart_total);
            $('.cart_tax').html(response.cart_tax);
            render_cart(response.cart_content);
           
            Sweet('success', 'Cart Added');
        },
        error: function(xhr, status, error) {

            $('.cart' + id).html(btn_html);
            $('.cart' + id).removeAttr('disabled');

            $.each(xhr.responseJSON.errors, function(key, item) {
                Sweet('error', item)
            });

        }
    });

   }


});

 /*=======================
        Remove Cart
    =========================*/
$(document).on('click', '.remove_cart', function() {
   
    var rowid = $(this).data('id');
    var productid=$(this).data('productid');

    $('.cart_item' + rowid).remove();
    $.ajax({
        type: 'get',
        url: base_url + '/remove-cart/' + rowid,
        dataType: 'json',
        success: function(response) {
            $('.cart_qty'+productid).val(0);
         
            $('.cart_count').html(response.cart_count);
            $('.cart_subtotal').text(amount_format(response.cart_subtotal));
             $('.cart_total').html(response.cart_total);
            $('.cart_tax').html(response.cart_tax);

        },

    });
});

$(document).on('click','.add_to_decrease_cart',function(){
    
    var id=$(this).data('id');
 
    if ($('.cart_decrement_'+id).length != 0) {
        $('.cart_decrement_'+id).click();
        
    }
});

/*=======================
       Cart Update
    =========================*/
$(document).on('click', '.cart_increment', function() {

    var rowid = $(this).data('id');
    var stock = $(this).data('stock');
    var productid = $(this).data('productid');
    var totalqty = $('.current_cart_qty' + rowid).val();
    if ($(this).data('isvariation') == 1) {
        return true;
    }


    
    totalqty = parseInt(totalqty);
    if (stock != null || stock != '') {

        if (totalqty < stock) {
            var newqty = totalqty + 1;
            $('.current_cart_qty' + rowid).val(newqty);
            
           
            cartqty(rowid, newqty);
        } else {
          
            Sweet('error', 'Opps maximum stock limit exceeded...!!');
        }
    } else {
        var newqty = totalqty + 1;
        $('.current_cart_qty' + rowid).val(newqty);
        cartqty(rowid, newqty);
    }

});


/*=======================
       Cart Update
    =========================*/
$(document).on('click', '.cart_decrement', function() {
    var rowid = $(this).data('id');
    var stock = $(this).data('stock');
    var productid = $(this).data('productid');
    var totalqty = $('.current_cart_qty' + rowid).val();
    var product_id=$(this).data('productid');

    if ($(this).data('isvariation') == 1) {
        return true;
    }


    totalqty = parseInt(totalqty);
    var newqty = totalqty - 1;
    $('.current_cart_qty' + rowid).val(newqty);
    
    if (newqty == 0 || newqty == NaN) {
        $('.cart_item' + rowid).remove();
        $('cart_qty'+product_id).val(0);
    }
    cartqty(rowid, newqty);


});

/*=======================
      Render Cart 
    =========================*/
function render_cart(items) {
    $('.cart_item').remove();
    var cartpage=$('.cart_page').length != 0 ? true : false;
    $.each(items, function(key, item) {
         var cart_options='';
              $.each(item.options.options, function (option_key, option) 
              {
                var child_options='';
                $.each(option, function (child_option_key, child_option_value) 
                 {
                  child_options +=`${child_option_value.name},`;
                 })

                cart_options +=`<br><small>${option_key}: (${child_options})</small>`;
              });

           

        

        var qtyrow=parseInt(item.qty);
        var cart_item=` <li class="cart_item cart_item${item.rowId}">
               <div class="cart-single-main">
                  <div class="cart-top">
                     <a data-id="${item.rowId}" data-productid="${item.id}" href="javascript:void(0)" class="remove remove_cart" title="Remove this item"><i class="icofont-close-circled"></i></a>
                     <a class="cart-img" href="${base_url+'/product/'+item.options.slug}"><img src="${item.options.preview != null ? item.options.preview : ''}" alt=""></a>
                  </div>
                  <div class="cart-single-item">
                     <h4><a href="${base_url+'/product/'+item.options.slug}">${str_limit(item.name,20)}</a><span>${cart_options}</span>
                     </h4>
                     <div class="quantity-price">
                        <div class="quantity">
                           <div class="quantity">
                             <div class="input-group">
                              <div class="button minus" >
                                 <button type="button" class="inline arrow sp-minus fff cart_decrement  cart_decrement_${item.id} btn btn-primary btn-number" data-productid="${item.id}" data-id="${item.rowId}"   data-type="minus" data-field="quant[1]"><i class="icofont-minus"></i></button>
                              </div>
                              <input type="text" name="quant[1]" class="input-number quntity-input current_cart_qty${item.rowId} exist_cart${item.id}" data-min="1"  value="${item.qty}">
                              <div class="button plus">
                                 ${item.options.options.length != 0 ? `<a href="${base_url+'/product/'+item.options.slug}" class="btn btn-primary btn-number cart_increment last" data-type="plus" data-field="quant[1]" data-id="${item.rowId}" data-stock="${item.options.stock}" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}"><i class="icofont-plus"></i></a>` : `<button type="button" class="btn btn-primary btn-number cart_increment last" data-type="plus" data-field="quant[1]" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}"><i class="icofont-plus"></i></button>`}
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="product-price">
                        <b>${amount_format(item.price*parseInt(item.qty),'icon')}</b>
                     </div>
                  </div>
               </div>
            </div>
         </li>`;          

        if (cartpage == true) {
           

            var cart_page_item=`<tr class="cart_item cart_item${item.rowId}">
                            <td class="image" data-title="Product">
                                <div class="primary-head-d">
                                    <img src="${item.options.preview != null ? item.options.preview : ''}" alt="#">
                                    <div class="image-cart-right">
                                        <p class="product-name"><a href="${base_url+'/product/'+item.options.slug}">${str_limit(item.name,100)}</a></p>
                                        <p class="product-des">${cart_options}</p>
                                        <p class="action"><a  data-id="${item.rowId}" class="remove remove_cart" href="javascript:void(0)"><i class="icofont-trash"></i>Remove</a></p>
                                    </div>
                                </div>
                            </td>
                          
                            <td class="qty" data-title="Qty">
                                <div class="quantity">
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number cart_decrement" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}""  data-type="minus" data-field="quant[1]"><a class="text-dark" href="${item.options.options.length != 0 ? base_url+'/product/'+item.options.slug : 'javascript:void(0)'}"><i class="icofont-minus"></i></a></button>
                                        </div>
                                      
                                        <input type="text" class="input-number current_cart_qty${item.rowId} exist_cart${item.id}" data-min="1" data-max="${item.options.stock}" value="${item.qty}">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number cart_increment" data-type="plus" data-field="quant[1]" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}"><a class="text-dark" href="${item.options.options.length != 0 ? base_url+'/product/'+item.options.slug : 'javascript:void(0)'}"><i class="icofont-plus"></i></a></button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="total-m" data-title="Total"><span>${amount_format(item.price)}</span></td>
                        </tr>`;

            $('.cart_page').append(cart_page_item);
        }

        $('.shopping-list').append(cart_item);


    });
}

/*=======================
      CartQty function 
    =========================*/
function cartqty(cartId, qty) {
    var url = cart_increment;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            id: cartId,
            qty: qty
        },
        dataType: 'json',
        success: function(response) {

            $('.cart_subtotal').html(amount_format(response.cart_subtotal));
           
            $('.cart_count').html(response.cart_count);
            $('.cart_total').html(response.cart_total);
            $('.cart_tax').html(response.cart_tax);
            

        },
        error: function(xhr, status, error) {



            $.each(xhr.responseJSON.errors, function(key, item) {
                Sweet('error', item)
            });

        }
    });

}

/*=======================
      Add To Cart Modal  
    =========================*/
 $(document).on('click','.add_to_cart_modal',function(){

    var product_id=$(this).data('id');
    render_card_modal(product_id);

    var previous_id=$('.quickview-slider-active').data('termid');
    $('.quickview-slider-active').removeClass('gellery_'+previous_id);

    $('.quickview-slider-active').addClass('gellery_'+product_id);
    $('.quickview-slider-active').attr('termid',product_id);
    
    
  
  });

/*=======================
      Add To Wishlist   
    =========================*/
$(document).on('click','.add_to_wishlist',function(){
    var termid=$(this).data('id');
    

        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
            type: 'POST',
            url: base_url+'/add-to-wishlist',
            data: {id: termid},
            dataType: 'json',
            beforeSend: function(){
                var spinner = `<div class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden"></span>
                </div>`;
                $('.wishlist'+termid).html(spinner);

            },
            success: function(response){ 
               $('.wishlist'+termid).removeClass('add_to_wishlist');
               $('.wishlist'+termid).attr('href',base_url+'/wishlist');
               $('.wishlist'+termid).html(`<i class="icofont-check-circled"></i>`);
               $('.wishlist_count').html(response);
           }
      });
});

 /*=======================
      render_card_modal   
    =========================*/
  function render_card_modal(product_id) {
     var url=base_url+'/product-details';
     $('#modal_id').val('');

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: 'GET',
      url: url+'/'+product_id,
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      beforeSend: function() {
            $('.option_form_area').html('');
            $('.modal_pricesvariationshide').remove();
            $('.modal-option-area').html('');
            $('.quick_single_slider').remove();
            $('.quick_sliders').html('');
      },
      
      success: function(response){ 
        var html='';
        $('.single-slider').remove();
        $('.render_star').html('');
        $('.total_review').remove();
        $('.cats_area').html('');

        $('#modal_id').val(product_id);
        
        $.each(response.galleries, function (key, item){
            var html=`<div class="quick_single_slider single-slider">
                           <img src="${item}" alt="${response.data.title}">
                        </div>`;
            $('.quick_sliders').append(html);
          
        });

        if (response.data.rating  != null && response.data.rating != 0) {
            for (var i=1; i <= 5; i++) {
                var rating_html=`<li><i class="icofont-star ${i <= response.data.rating ? 'star' : ''}"></i></li>`;
                $('.render_star').append(rating_html);
            }

            $('.render_rating').append(`<a href="#" class="total-review total_review"> ${response.data.rating} | (${response.data.reviews_count}) Reviews</a>`);
        }

        if (response.data.category.length > 0) {
            var cats_html='';
           $.each(response.data.category, function (key, item) {
                
                cats_html +=`<a href="${base_url+'/category/'+item.slug}" class="categories" data-id="${item.id}">${item.name}</a>`;

           });

           $('.cats_area').append(`<p class="cat">Category :${cats_html}</p>`);
        }

        if (response.data.brands.length > 0) {
            var cats_html='';
           $.each(response.data.brands, function (key, item) {
                
                cats_html +=`<a href="${base_url+'/brand/'+item.slug}" class="categories" data-id="${item.id}">${item.name}</a>`;

           });

           $('.cats_area').append(`<p class="cat">Brand :${cats_html}</p>`);
        }

        if (response.data.tags.length > 0) {
            var cats_html='';
           $.each(response.data.tags, function (key, item) {
                
                cats_html +=`<a href="${base_url+'/tag/'+item.slug}" class="categories" data-id="${item.id}">${item.name}</a>`;

           });

           $('.cats_area').append(`<p class="cat">Tags :${cats_html}</p>`);
        }
       

        $('.quickViewtitle').text(response.data.title);
        $('.quickViewdescription').text(response.data.excerpt != null ? response.data.excerpt.value : '');
        if (response.galleries.length > 1) {
            quickViewSlider('.gellery_'+product_id);
        }

        $('.modal_stock').remove();
        if (response.data.optionwithcategories.length == 0) {
          var stock_status=  response.data.price.stock_status == 1 ? 'In Stock' : 'Out of stock';
          var stock_status=`<a href="javascript:void(0)">${response.data.price.stock_status == 1 ? 'In Stock' : '<span class="text-danger">Out of stock</span>'}</a>`
        }
        else{
          var stock_status='';
        }

       var stock_html=`<div class="product-tag modal_stock modal_stock_status ${response.data.optionwithcategories.length != 0 ? 'none' : ''}">
        <p class="cat">Availability: 
           <span class="modal_stock_status_display">
            ${response.data.optionwithcategories.length == 0 ? stock_status : ''}
            </span>
        </p></div>
       `;

       $('.quick_stock_area').html(stock_html);

        if (response.data.optionwithcategories.length == 0) {
            

            var main_price=amount_format(response.data.price.price,'sign');
            var old_price=null;
            if (response.data.price.old_price != null) {
                old_price=amount_format(response.data.price.old_price,'sign');

                main_price=`<span class="discount">${main_price}</span><s>${old_price}</s>`;
            }
            else{
                main_price=`<span class="discount">${main_price}</span>`;
            }

            var hide_input=`<input class="none modal_pricesvariationshide" 
                                   data-stockstatus="${response.data.price.stock_status}"  
                                   data-stockmanage="${response.data.price.stock_manage}" 
                                   data-sku="${response.data.price.sku}" 
                                   data-qty="${response.data.price.qty}"  
                                   data-oldprice="${response.data.price.old_price}" 
                                   data-price="${response.data.price.price}" 
                                   type="radio" 
                                   checked>`;

            $('.quick_price_area').html(main_price);    
            $('.quick_form').append(hide_input);     

        }
        else{
            render_price_variation(response.data.optionwithcategories);
        }
        

        
        modal_variations();
      },
      error: function(xhr, status, error) 
      {
       
        $.each(xhr.responseJSON.errors, function (key, item) 
        {
          Sweet('error',item)
          
        });
      
      }
    })
  }


$(document).on('submit','.modal_product_option_form', function(e) {
        e.preventDefault();

        if ($('.modal_pricesvariationshide').length == 1) {
            var $qty = $('.input-number');
            var $button = $(this);
            var $input = $button.closest('.quantity').find("input.input-number");
            var currentVal = parseInt($input.val(), 10);
            if (!isNaN(currentVal)) {
                
                if ($('.modal_input_qty').data('max') < currentVal) {
                    Sweet('error',$('.modal_input_qty').data('max')+' Pieces Available Only');
                    return false;
                }
                
            }

        }

        var required=false;
        
        
        if($('.modal_required_var').length > 0){
            $('.modal_required_var').each(function () {
                var optionid=$(this).data('id');
                required = false;
               
                $('.modal_variations'+optionid).each(function () {
                    if (this.checked == true) {
                        required = true;
                    }
                }); 

            });
        }
        else{
            required = true;
        }

        if(required == false){
            Sweet('error','Select a required variation');
            return false;
        }



        

        var form_data = $(this).serialize();
      
        if (required == true) {
           $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
           });

          $.ajax({
            type: 'POST',
            url: cart_link,
            data: form_data,
            dataType: 'json',
            beforeSend: function(){
              $('.modal_add_to_cart_btn').text('Please Wait.....');
              $('.modal_add_to_cart_btn').attr('disabled','');
            },
            success: function(response){ 
              $('.modal_add_to_cart_btn').text('Add To Cart');
              $('.modal_add_to_cart_btn').removeAttr('disabled');

              render_cart(response.cart_content);
              $('.subtotal').html(response.cart_subtotal);
              $('.cart_subtotal').html(response.cart_subtotal);
              
              $('.tax').html(response.cart_tax);
              
              $('.total_amount').val(response.cart_total);
              $('.cart_count').html(response.cart_count)
              
              Sweet('success','Cart Added');
             
              
             

              
            },
            error: function(xhr, status, error) 
            {
              $('.modal_add_to_cart_btn').text('Add To Cart');
              $('.modal_add_to_cart_btn').removeAttr('disabled');
        
              $.each(xhr.responseJSON.errors, function (key, item) 
              {
                Sweet('error',item)
              });
              
            }
        });


        }
});

$(document).on('change','.input-number',function(){

   if ($(this).val() <= 0) {
    $(this).val(1);
   }

   var stockmanage=$(this).data('stockmanage');
   var stockstatus=$(this).data('stockstatus');
   var max=$(this).data('max');
   if (stockstatus == 0) {
    $(this).val(0);
    $(this).attr('disabled','');
   }

   if (stockmanage == 1) {
        if (max < $(this).val()) {
            $(this).val(max);
        }
   }


});


$(document).on('click','.product_option',function(){

    var qty=$(this).data('qty');
    var stockmanage=$(this).data('stockmanage');
    var stockstatus=$(this).data('stockstatus');

    if (stockmanage == 1) {
      $('.input_qty').attr('max',qty);
    }
    else{
      $('.input_qty').removeAttr('max');
    }


  });
    
  $(document).on('submit','.option_form', function(e) {
        e.preventDefault();
         var form_data = $(this).serialize();
        var required = false;
        if ($('.req').length > 0) {
            $('.req:checked').each(function() {
                if (this.checked == true) {
                    required = true;
                } else {
                    required = false;
                }

            });
            if (required == false) {
                $('.required_option').show();
            } else {
                $('.required_option').hide();
            }
        } else {
            required = true;
        }
        if (required == true) {
           $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
           });

          $.ajax({
            type: 'POST',
            url: cart_link,
            data: form_data,
            dataType: 'json',
            beforeSend: function(){
              $('.add_to_cart_form_btn').text('Please Wait.....');
              $('.add_to_cart_form_btn').attr('disabled','');
            },
            success: function(response){ 
              $('.add_to_cart_form_btn').text('Add To Cart');
              $('.add_to_cart_form_btn').removeAttr('disabled');

              render_cart(response.cart_content);
              $('.subtotal').text(amount_format(response.cart_subtotal));
             
              $('.cart_count').html(response.cart_count)
            
              Sweet('success','Cart Added');
             
              $('#product_variation_modal').modal('toggle');
             

              
            },
            error: function(xhr, status, error) 
            {
              $('.add_to_cart_form_btn').text('Add To Cart');
              $('.add_to_cart_form_btn').removeAttr('disabled');
        
              $.each(xhr.responseJSON.errors, function (key, item) 
              {
                Sweet('error',item)
              });
              
            }
        });


        }
    });   

function modal_variations() {
var totalprice=0;
var totaloldprice=0;
  
    if ($('.modal_pricesvariationshide').length == 1) {
       
        $('.modal_pricesvariationshide').each(function() {

        
            var oldprice=$(this).data('oldprice');
            var price=$(this).data('price');
            var qty=$(this).data('qty');
            totalprice= totalprice+price;
            totaloldprice= totaloldprice+oldprice;

            if ($(this).data('stockstatus') == 1) {
                $('.modal_input_qty').attr('data-max',qty);
                $('.modal_input_qty').attr('max',qty);
            }
            $('.modal_add_to_cart_btn').removeAttr('disabled');
            $('.modal_maxqty').text(qty);   
            $('.modal_qty_display').show();
        });

        $('.modal_pricesvariationshide').each(function() {
            if ($(this).is(':checked') && $(this).data('stockstatus') == 0) {
                $('.modal_add_to_cart_btn').attr('disabled','');
            }
        });


        
        
    }
    else{
        $('.modal_pricesvariations').each(function() {

        if ($(this).is(':checked') && $(this).data('stockstatus') == 1) {
            var oldprice=$(this).data('oldprice');
            var price=$(this).data('price');
            var qty=$(this).data('qty');
            totalprice= totalprice+price;
            totaloldprice= totaloldprice+oldprice;

            if ($(this).data('stockmanage') == 1) {
                $('.modal_input_qty').attr('data-max',qty);
                $('.modal_input_qty').attr('max',qty);
            }
            $('.modal_add_to_cart_btn').removeAttr('disabled');
               
            }
        });

        $('.modal_pricesvariations').each(function() {
            if ($(this).is(':checked') && $(this).data('stockstatus') == 0) {
                $('.modal_add_to_cart_btn').attr('disabled','');
            }
        });


        if (totalprice == 0) {
            $('.price_area').html('');
            return false;
        }
    }

    



    
    var newtotaloldprice = totaloldprice != 0 ? amount_format(totaloldprice) : '';
    var price_html=`<span class="discount">${amount_format(totalprice)}</span><s>${newtotaloldprice}</s>`;
    $('.quick_price_area').html(price_html);


}


function render_price_variation(prices) {
    $.each(prices, function (key, row) {
       var option_group_title=`<h6><span class="text-danger ${row.is_required == 1 ? 'modal_required_var' : ''}" data-id="${row.id}">${row.is_required == 1 ? '*' : ''}</span>${row.category.name ?? '' } :</h6>`; 
        
        var option_html='';
        $.each(row.priceswithcategories, function (k, price) {
            if (row.category.slug == 'checkbox') {
                var input_option=`&nbsp&nbsp <input
    class="custom-control modal_variations${row.id} modal_pricesvariations ${row.is_required == 1 ? 'req' : ''}" 
    data-stockstatus="${price.stock_status}"  
    data-stockmanage="${ price.stock_manage }" 
    data-sku="${ price.sku }" 
    data-qty="${ price.qty }"  
    data-oldprice="${ price.old_price }" 
    data-price="${ price.price }" 
    type="${ row.select_type == 1 ? 'checkbox' : 'radio' }" 
    id="modal_variation${ price.id }" 
    name="option[${row.id}][]" 
    value="${ price.id }"
    ${ row.is_required == 1 && k == 0 ? 'checked' : '' }
    >

    <label for="modal_variation${ price.id }">${ price.category.name }</label>`;
            }

            else if (row.category.slug == 'checkbox_custom') {
                var input_option=`
        <div class="custom_checkbox modal_variation${ price.id }">
        <input 
        class="custom-control modal_variations${row.id} modal_pricesvariations ${price.is_required == 1 ? 'req' : '' }" 
        data-stockstatus="${ price.stock_status }"  
        data-stockmanage="${ price.stock_manage }" 
        data-sku="${ price.sku }" 
        data-qty="${ price.qty }"  
        data-oldprice="${ price.old_price }" 
        data-price="${ price.price }" 
        type="${ row.select_type == 1 ? 'checkbox' : 'radio' }" 
        id="modal_variation${ price.id }" 
        name="option[${row.id}][]" 
        value="${ price.id }">
        <label for="modal_variation${ price.id }">${ price.category.name }</label>
        </div>`;

            }

           else if (row.category.slug == 'radio') {
              var input_option=`<div class="custom_radio"><input 
        class="custom-control modal_variations${row.id} modal_pricesvariations ${ row.is_required == 1 ? 'req' : '' }" 
        data-stockstatus="${ price.stock_status }"  
        data-stockmanage="${ price.stock_manage }" 
        data-sku="${ price.sku }" 
        data-qty="${ price.qty }"  
        data-oldprice="${ price.old_price }" 
        data-price="${ price.price }" 
        type="${ row.select_type == 1 ? 'checkbox' : 'radio' }" 
        id="modal_variation${ price.id }" 
        name="option[${row.id}][]" 
        value="${ price.id }">
        <label for=" modal_variation${ price.id }">${ price.category.name }</label></div>`;

           }

           else if (row.category.slug == 'radio_custom') {
              var input_option=`&nbsp&nbsp
            <div class="custom_radio modal_variations${row.id} modal_pricesvariations variation${ price.id }">
                <input 
                class="custom-control modal_variations${row.id} modal_pricesvariations ${ row.is_required == 1 ? 'req' : '' }" 
        data-stockstatus="${ price.stock_status }"  
        data-stockmanage="${ price.stock_manage }" 
        data-sku="${ price.sku }" 
        data-qty="${ price.qty }"  
        data-oldprice="${ price.old_price }" 
        data-price="${ price.price }" 
        type="${ row.select_type == 1 ? 'checkbox' : 'radio' }" 
        id="modal_variation${ price.id }" 
        name="option[${row.id}][]" 
        value="${ price.id }">
               <label for="modal_variation${ price.id }">${ price.category.name }</label>
            </div>`;
           }

           else if (row.category.slug == 'color_single') {
            var input_option=`<div class="color_widget">
        <div class="single_color">
            <input class=" modal_variations${row.id} color_single modal_pricesvariations ${ row.is_required == 1 ? 'req' : '' }" 
        data-stockstatus="${ price.stock_status }"  
        data-stockmanage="${ price.stock_manage }" 
        data-sku="${ price.sku }" 
        data-qty="${ price.qty }"  
        data-oldprice="${ price.old_price }" 
        data-price="${ price.price }" 
        type="${ row.select_type == 1 ? 'checkbox' : 'radio' }" 
        id="modal_variation${ price.id }" 
        name="option[${row.id}][]" 
        value="${ price.id }">

        
        <label 
        class="modal_variation$${ price.id }

         ${price.category.name != 'white' ? 'text-light' : 'text-dark'}
         " 
         for="modal_variation${ price.id }"  
         style="background-color: ${ price.category.name }">
        </label>


        </div>
      </div>`;
           }

          else if (row.category.slug == 'color_multi') {
            var input_option=`<div class="color_widget">
        <div class="single_color">
            <input class=" modal_variations${row.id} color_single modal_pricesvariations ${ price.is_required == 1 ? 'req' : '' }"  
        data-stockstatus="${ price.stock_status }"  
        data-stockmanage="${ price.stock_manage }" 
        data-sku="${ price.sku }" 
        data-qty="${ price.qty }"  
        data-oldprice="${ price.old_price }" 
        data-price="${ price.price }" 
        type="${ row.select_type == 1 ? 'checkbox' : 'radio' }" 
        id="modal_variation${ price.id }" 
        name="option[${row.id}][]" 
        value="${ price.id }">

        <label 
        class="modal_variation$${ price.id }
         ${price.category.name != 'white' ? 'text-light' : 'text-dark'}
         " 
         for="modal_variation${ price.id }"  
         style="background-color: ${ price.category.name }">
        </label>
            
        </div>

    </div>`;
          
          }   
           
            option_html +=`<div class="color">${input_option}</div>`;
        });

       var base_html=`<div class="option-colors">
            ${option_group_title}

            ${option_html}
         </div>`;

       $('.modal-option-area').append(base_html);  
    });
   
}


$(document).on('change','.modal_pricesvariations',function(){
    var stockstatus=$(this).data('stockstatus');
    var stockmanage=$(this).data('stockmanage');
    var sku=$(this).data('sku');
    var qty=$(this).data('qty');
    var oldprice=$(this).data('oldprice');
    var price=$(this).data('price');
    
    if ($(this).is(':checked')){
         var stockstatus_html=`<a href="javascript:void(0)">${stockstatus == 1 ? 'In Stock' : '<span class="text-danger">Out of stock</span>'}</a>`
       
        $('.modal_stock_status_display').html(stockstatus_html);
        $('.modal_stock_status').show();

        if(stockmanage == 1){
            $('.modal_qty_display').show();
            $('.modal_maxqty').html(qty);
        }
        
    }
    else{

        $('.modal_stock_status').hide();
        $('.modal_qty_display').hide();
    
    }
    
    modal_variations();


});


render_cart(cart_content);

$('.trans_lang').on('change',function(){
  $('.change_lang_form').submit();
});

var entityMap = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;',
      '/': '&#x2F;',
      '`': '&#x60;',
      '=': '&#x3D;'
};

/*-------------------------
        escapeHtml
    --------------------------*/
function escapeHtml(string) {
      return String(string).replace(/[&<>"'`=\/]/g, function (s) {
        return entityMap[s];
    });
 }
