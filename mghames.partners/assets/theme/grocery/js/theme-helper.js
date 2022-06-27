"use strict";

var currency_name = $('#currency_name').val();
var cart_link = $('#cart_link').val();
var clickaudio = $('#click_sound').val();
var cart_sound = $('#cart_sound').val();
var base_url = $('#base_url').val();
var preloader= $('#preloader').val();
var cart_increment = $('#cart_increment').val();
var cart_decrement = $('#cart_decrement').val();
var defaut_img=base_url+'/uploads/default.png';
const cart_content = JSON.parse($('#cart_content').val());

/*---------------------------------
       render_product_preloaded
    ---------------------------------*/
function render_product_preloaded(preload_count = 6, target) {
    var html = `<div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>`;
    for (var i = 1; i <= preload_count; i++) {
        $(target).append(html);
    }
}

/*---------------------------------
       render_primary_product
    ---------------------------------*/
function render_primary_product(products, target,additional_class='',visible_badge=false,push_data='append') {
    
    var base_url = $('#base_url').val();
    
    var count_data = 0;

    $.each(products, function(key, product) {

        
        var preview = product.preview != null ? product.preview.value : base_url + '/uploads/default.png';
        var badge='';

        if (visible_badge == true) {
          
            $.each(product.features, function(k, features) {
                badge=`<div class="p-badge popular">${escapeHtml(features.name)}</div>`;
            });

        }
       
       
         if (product.is_variation == 1 ) {
            var lastprice=' - ' + product.lastprice.price > 0 ? product.lastprice.price : '';
           
            var price= product.firstprice.price + lastprice;
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
             var cart_html=`<div class="product-card">
             <a href="javascript:void(0)" class="add_to_cart_modal" data-id="${product.id}">Add To Cart <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg></a>
         </div>`;                               
        }
        else{
            if (product.firstprice.stock_status == 0) {
                 var cart_html=`<div class="product-card">
                 <a href="javascript:void(0)" disabled>Stock Out <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg></a>
             </div>`;                           
            }
            else{
                var cart_html=`<div class="product-card">
                <a href="javascript:void(0)" class="add_to_cart" data-id="${product.id}" data-qty="1" data-stockstatus="${product.firstprice.stock_status}" data-stockmanage="${product.firstprice.stock_manage}">Add To Cart <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg></a>
            </div>`;  
            }
        }
        
        var ratings='';

         for (var i = 1; i <= 5; i++) {
            var review_full=`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 17l-5.878 3.59 1.598-6.7-5.23-4.48 6.865-.55L12 2.5l2.645 6.36 6.866.55-5.231 4.48 1.598 6.7z"/></svg>`;
            var review_half=`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.26l-7.053 3.948 1.575-7.928L.587 8.792l8.027-.952L12 .5l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928L12 18.26zm0-2.292l4.247 2.377-.949-4.773 3.573-3.305-4.833-.573L12 5.275l-2.038 4.42-4.833.572 3.573 3.305-.949 4.773L12 15.968z"/></svg>`;

            i > product.rating ? ratings += review_half: ratings += review_full;
        }  

        var tag_content = '';

        if(product.tags.length > 0)
        {
            $.each(product.tags, function(key, tag) {
                tag_content = `${escapeHtml(tag.name)},`;
            })
        }else{
            $.each(product.tags, function(key, tag) {
                tag_content = `${escapeHtml(tag.name)}`;
            })
        }

        var rating_html=`<div class="wishlist-product">
                    ${product.rating != null ? ratings : ''}
               </div>`;

            var html=`<div class="col-lg-3 product-item">
            <div class="grocery-details">
                <div class="single-product">
                    <img class="img-fluid" src="${preview}" alt="">
                </div>
                <div class="product-name">
                    <h5>${tag_content}</h5>
                    <h3>${escapeHtml(product.title.substr(0,22))}...</h3>
                </div>
                <div class="product-wishlist-price">
                    <div class="price-product">
                        <span>${price}</span>
                    </div>
                    ${rating_html}
                </div>
                <div class="product-card-section">
                    ${cart_html}
                    <div class="wishlist-view-area">
                        <a href="javascript:void(0)" class="add_to_wishlist" data-id="${product.id}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"/></svg></a>

                        <a href="javascript:void(0)" class="add_to_cart_modal" data-id="${product.id}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M1.181 12C2.121 6.88 6.608 3 12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9zM12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0-2a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg></a>
                    </div>
                </div>
            </div>
        </div>`;
                 
        
        if(push_data == 'append')
        {
            $(target).append(html);
        }else{
            
            if(count_data == 0)
            {
                $(target).html('');
                count_data = 1;
            }
            $(window).scrollTop( $(target).offset().top );
            $(target).append(html);
        }

    });
    
}

/*---------------------------------
       render_categories
    ---------------------------------*/
function render_categories(data,target)
{
    $.each(data, function(key,value) {
        if(value.preview == null)
        {
            var image = base_url + '/uploads/default.png';
        }else{
            var image = value.preview.content;
        }
        var html = `<div class="single-category">
        <a href="javascript:void(0)" onclick="category_product('${value.slug}')">
            <div class="category-content">
                <div class="item-img">
                    <img src="${image}" alt="">
                </div>
                <div class="item-name">
                    <h5>${escapeHtml(value.name)}</h5>
                </div>
            </div>
            <div class="next-item-search">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg>
            </div>
        </a>
    </div>`;

        $(target).append(html);
    });
}

/*---------------------------------
       category_product
    ---------------------------------*/
function category_product(slug)
{
    var category_product_url = $('#category_product_url').val();
    $.ajax({
        type: 'get',
        url: category_product_url,
        data: {
            slug: slug
        },
        dataType: 'json',
        beforeSend: function() {
        },
        success: function(response) {
            
            render_primary_product(response.products, '#latest_product','',false,'html');
        },
        error: function(xhr, status, error) {
    
        }
    });
}

/*---------------------------------
       render_reviews
    ---------------------------------*/
function render_reviews(data,target) {
    $.each(data, function(key, row) {
        var html=`<div class="col-lg-4 col-md-6 col-12">
                  <div class="single-testimonial">
                     <div class="text">
                        <p>"${escapeHtml(row.comment)}"</p>
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

/*---------------------------------
       render_discountable_product
    ---------------------------------*/
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
                                    <h3><a href="${base_url+'/product/'+product.slug}">${escapeHtml(str_limit(product.title,20))}</a></h3>
                                    <p>
                                       ${escapeHtml(str_limit(product.excerpt != null ? product.excerpt.value : '',30))}
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


/*---------------------------------
       Add To Cart Prooduct
    ---------------------------------*/
$(document).on('click', '.add_to_cart', function() {
    var id = $(this).data('id');
    var stockstatus = $(this).data('stockstatus');
    var stockmanage = $(this).data('stockmanage');
    var stockqty = $(this).data('qty');
    

    if (stockstatus == 0) {
        Sweet('error', 'Stock Out');

        return true;
    }

    if (stockmanage == 1) {
        if ($('.exist_cart' + id).length != 0) {
            var exisist_cart = $('.exist_cart' + id).text();
            exisist_cart = parseInt(exisist_cart);
            console.log(exisist_cart)
            if (exisist_cart == stockqty) {
                Sweet('error', 'Opps maximum stock limit exceeded...!!');

                return true;
            }
        }
    }


    var btn_html = $(this).html();
    $(this).attr('disabled', '');
    var spinner = `<div class="spinner-border spinner-border-sm" role="status">
  <span class="visually-hidden"></span>
</div> Please Wait...`;
    var btn_prev = `Add To Cart <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg>`;
    $(this).html('');
    $(this).html(spinner);
    
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

            
            $('.cart_subtotal').html(response.cart_subtotal);
            
            $('.cart_count').html(response.cart_count);
            $('.cart_total').html(response.cart_total);
            $('.cart_tax').html(response.cart_tax);
            render_cart(response.cart_content);
            audio();
            Sweet('success', 'Cart Added');
            
            $('.product-card a').html(btn_prev)

        },
        error: function(xhr, status, error) {

            $('.cart' + id).html(btn_html);
            $('.cart' + id).removeAttr('disabled');

            $.each(xhr.responseJSON.errors, function(key, item) {
                Sweet('error', item)
            });

        }
    });


});

/*---------------------------------
        Remove Cart Product
    ---------------------------------*/
$(document).on('click', '.remove_cart', function() {
    audio(cart_sound);
    var rowid = $(this).data('id');
    $('.cart_item' + rowid).remove();
    $.ajax({
        type: 'get',
        url: base_url + '/remove-cart/' + rowid,
        dataType: 'json',
        success: function(response) {
            $('.cart_count').html(response.cart_count);
            $('.cart_subtotal').text(response.cart_subtotal);
             $('.cart_total').html(response.cart_total);
            $('.cart_tax').html(response.cart_tax);
        },

    });
    $(this).closest('.single-cart-product').remove();
});

/*---------------------------------
        Cart Increment 
    ---------------------------------*/
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
            
            audio(cart_sound);
            cartqty(rowid, newqty);
        } else {
            Sweet('error', 'Opps maximum stock limit exceeded...!!');
        }
    } else {
        var newqty = totalqty + 1;
        $('.current_cart_qty' + rowid).val(newqty);
        

        audio(cart_sound);
        cartqty(rowid, newqty);
    }

});


/*---------------------------------
        Cart Decrement 
    ---------------------------------*/
$(document).on('click', '.cart_decrement', function() {
    var rowid = $(this).data('id');
    var stock = $(this).data('stock');
    var productid = $(this).data('productid');
    var totalqty = $('.current_cart_qty' + rowid).val();

    if ($(this).data('isvariation') == 1) {
        
        return true;
    }


    totalqty = parseInt(totalqty);
    var newqty = totalqty - 1;
    $('.current_cart_qty' + rowid).val(newqty);
    

    if (newqty == 0 || newqty == NaN) {
        $(this).closest('.single-cart-product').remove();
    }
    audio(cart_sound);
    cartqty(rowid, newqty);


});


/*---------------------------------
        Render Cart
    ---------------------------------*/
function render_cart(items) {
    $('.cart_item').remove();

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

        var cart_item = `
                <div class="single-cart-product cart_item">
                    <div class="cart-product-img">
                        <a href="#"><img class="img-fluid" src="${item.options.preview != null ? item.options.preview : ''}" alt=""></a>
                    </div>
                    <div class="cart-content-area">
                        <div class="cart-product-name">
                            <a href="#"><h2>${escapeHtml(str_limit(item.name,20))}</h2></a>
                            <div class="product-cart-price">
                                <h2>${amount_format(item.price,'icon')}</h2>
                            </div>
                            <div class="product-cart-qty-area">
                                <a href="javascript:void(0)" class="plus-qty cart_increment" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/></svg></a>
                                <input type="number" class="current_cart_qty${item.rowId} exist_cart${item.id}" value="${item.qty}">
                                <a href="javascript:void(0)" class="minus-qty cart_decrement" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"/></svg></a>
                            </div>
                        </div>
                    </div>
                    <div class="cart-remove-area">
                        <a href="javascript:void(0)" data-id="${item.rowId}" class="remove remove_cart"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg></a>
                    </div>
                </div>`;

    
        $('.cart_page').append(cart_item);


    });
}

/*---------------------------------
        Cart Qty
    ---------------------------------*/
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

            $('.cart_subtotal').html(response.cart_subtotal);
           
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

        $('#exampleModal').modal('show')
        render_card_modal(product_id);
    
        var previous_id=$('.quickview-slider-active').data('termid');
        $('.quickview-slider-active').removeClass('gellery_'+previous_id);
    
        $('.quickview-slider-active').addClass('gellery_'+product_id);
        $('.quickview-slider-active').attr('termid',product_id);
    });

    /*---------------------------------
            Add To Wishlist
        ---------------------------------*/
    $(document).on('click','.add_to_wishlist',function(){
        var product_id = $(this).data('id');
        console.log(product_id);
        $(this).addClass('activewishlist');
        $(this).removeClass('add_to_wishlist');
        var url = base_url+'/add-to-wishlist';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                id: product_id,
            },
            dataType: 'json',
            success: function(response) {
                audio();
            },
            error: function(xhr, status, error) {
                $.each(xhr.responseJSON.errors, function(key, item) {
                    Sweet('error', item)
                });
            }
        });

    });

    /*---------------------------------
            render_card_modal
        ---------------------------------*/
    function render_card_modal(product_id) {
        var url=$('#pos_product_varidation').val();

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
                preload();  
        },
        success: function(response){ 
            var html='';

            $.each(response.productoptionwithcategories, function(key, item){
            var child_html='';

            $.each(item.priceswithcategories,function(k,child){
                child_html +=`
                <label class="selectgroup-item">
                <input data-qty="${child.qty}" data-stockmanage="${child.stock_manage}" data-stockstatus="${child.stock_status}" ${child.stock_status == 0 && child.qty == 0  ? 'disabled' : ''} type="${item.select_type == 1 ? 'checkbox' : 'radio'}" name="option[${item.id}][]" value="${child.id}" class="selectgroup-input product_option ${item.is_required == 1 ? 'req' : ''}">
                <span class="selectgroup-button">${child.stock_status == 0 && child.qty == 0 ? '<del>' : ''} ${escapeHtml(child.category.name)} ${child.stock_status == 0 && child.qty == 0  ? '</del>' : ''}</span>
                </label>
                `;
            });

            html +=`
                <div class="form-group">
            <label class="form-label">${escapeHtml(item.categorywithchild.name)} ${item.is_required == 1 ? '<span class="text-danger">*</span>' : ''} </label>
            <div class="selectgroup w-100">
                ${child_html}
            
            </div>
            </div>
            `;
            });
            html +=`<div class="form-group">
    <label class="form-label">Quantity</label>
    <input type="number" name="qty" class="form-control input_qty" value="0" required min="1">
    <p class="text-danger none required_option">Please Select A Option From Required Field</p>
    <input type="hidden" name="id" value="${product_id}" />
    </div>
    `; 

            $('.option_form_area').html(html);
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
                   
                   cats_html +=`<a href="${base_url+'/category/'+item.slug}" class="categories" data-id="${item.id}">${escapeHtml(item.name)}</a>`;
   
              });
    
           }
   
           if (response.data.brands.length > 0) {
               var cats_html='';
              $.each(response.data.brands, function (key, item) {
                   
                   cats_html +=`<a href="${base_url+'/brand/'+item.slug}" class="categories" data-id="${item.id}">${escapeHtml(item.name)}</a>`;
   
              });
   
           }
   
           if (response.data.tags.length > 0) {
               var cats_html='';
              $.each(response.data.tags, function (key, item) {
                   
                   cats_html +=`<a href="${base_url+'/tag/'+item.slug}" class="categories" data-id="${item.id}">${escapeHtml(item.name)}</a>`;
   
              });
   
           }
          
   
           $('.quickViewtitle').text(escapeHtml(response.data.title));
           $('.quickViewdescription').text(escapeHtml(response.data.excerpt != null ? response.data.excerpt.value : ''));
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
   
   /*-----------------------
        Input Number Change
    -------------------------*/
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
   
    /*-----------------------
        Input Number Change
    -------------------------*/
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
       
    /*------------------------------
            Input Number Change
        -----------------------------*/
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
   
    /*------------------------------
            modal_variations
        -----------------------------*/
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
   
   /*------------------------------
            render_price_variation
        -----------------------------*/
   function render_price_variation(prices) {
       $.each(prices, function (key, row) {
          var option_group_title=`<h6><span class="text-danger ${row.is_required == 1 ? 'modal_required_var' : ''}" data-id="${row.id}">${row.is_required == 1 ? '*' : ''}</span>${escapeHtml(row.category.name ?? '' )} :</h6>`; 
           
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
   
       <label for="modal_variation${ price.id }">${ escapeHtml(price.category.name) }</label>`;
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
           <label for="modal_variation${ price.id }">${ escapeHtml(price.category.name) }</label>
           </div>`;
   
               }
   
              else if (row.category.slug == 'radio') {
                 var input_option=`<input 
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
           <label for="modal_variation${ price.id }">${ escapeHtml(price.category.name) }</label>`;
   
              }
   
              else if (row.category.slug == 'radio_custom') {
                 var input_option=`&nbsp&nbsp
               <div class="modal_variations${row.id} modal_pricesvariations variation${ price.id }">
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
                  <label for="modal_variation${ price.id }">${ escapeHtml(price.category.name) }</label>
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
            style="background-color: ${ escapeHtml(price.category.name) }">
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
            style="background-color: ${ escapeHtml(price.category.name) }">
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
   
    /*------------------------------
            modal_pricesvariations
        -----------------------------*/
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
   

