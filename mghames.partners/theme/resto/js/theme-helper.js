"use strict";

var currency_name = $('#currency_name').val();
var cart_link = $('#cart_link').val();
var clickaudio = $('#click_sound').val();
var cart_sound = $('#cart_sound').val();
var base_url = $('#base_url').val();
var preloader= $('#preloader').val();
var cart_increment = $('#cart_increment').val();
var cart_decrement = $('#cart_decrement').val();
const cart_content = JSON.parse($('#cart_content').val());

/*-------------------------------------
		render_product_preloaded
	---------------------------------------*/
function render_product_preloaded(preload_count = 6, target) {
    var html = `<div class="col-lg-3 col-md-6 col-6 content-preloader">
                              <div class="single-popular-product  content-placeholder" data-height="200px" data-width="100%"  >
                              </div>
                           </div>`;
    for (var i = 1; i <= preload_count; i++) {
        $(target).append(html);
    }
}

/*-------------------------------------
		render_primary_product
	---------------------------------------*/
function render_primary_product(products, target,additional_class='') {
    var base_url = $('#base_url').val();
    additional_class != '' ? $('.'+additional_class).remove() : '';

    var listview= $('.listviewproducts').length != 0 ? true : false;

    $.each(products, function(key, product) {

        var preview = product.preview != null ? product.preview.value : base_url + '/uploads/default.png';

       
       
        var price= product.firstprice.price;
        
        
        price = amount_format(price,'icon');


        if (product.is_variation == 1) {
              var cart_html=`<a  href="${base_url+'/product/'+product.slug}"><i class="icofont-basket"></i>Add to cart</a>`;
        } else {
            if (product.firstprice.stock_status == 0) {
               var cart_html=`<a  href="${base_url+'/product/'+product.slug}"><i class="icofont-basket"></i>Add to cart</a>`;
            } else {
                var cart_html=`<a class="add_to_cart cart${product.id}" href="javascript:void(0)" data-isvariation="${product.is_variation}"  data-id="${product.id}" data-stockstatus="${product.firstprice.stock_status}" data-stockmanage="${product.firstprice.stock_manage}" data-qty="${product.firstprice.qty}"><i class="icofont-basket"></i>Add to cart</a>`;;
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
                    <a href="#" class="total-review">${product.rating != null ? '('+product.rating+') Review' : ''}</a>
               </div>`;

        var html=`<div class="col-lg-3 col-md-6 col-6 ${additional_class}">
                                        <div class="single-popular-product">
                                            <div class="image">
                                                <img class="lazy" src="${preloader}" data-src="${preview}" alt="">
                                                <div class="product-overlay">
                                                    <a href="${base_url+'/product/'+product.slug}" class="btn add-to-cart" title="add to Cart"><i class="icofont-shopping-cart"></i></a>
                                                    <a href="javascript:void(0)" data-id="${product.id}" class="btn wishlist add_to_wishlist" title="add to Wishlist"><i class="icofont-heart"></i></a>
                                                    <a href="${base_url+'/product/'+product.slug}"class="btn view"><i class="icofont-link-alt"></i></a>
                                                </div>
                                            </div>
                                            <div class="single-item-text">
                                                <h4 class="single-item-price">${price}</h4>
                                                <h3 class="single-item-title"><a href="${base_url+'/product/'+product.slug}">${str_limit(product.title,20)}</a></h3>
                                                ${product.rating != null ? rating_html : ''}
                                                <p>${str_limit(product.excerpt != null ? product.excerpt.value : '',30)}</p>
                                            </div>
                                            <div class="single-item-bottom">
                                                <div class="quantity-main boxed-quantity">
                                                    
                                                    <div class="sp-quantity">
                                                      <button class="inline arrow sp-minus fff"><a class="minus" data-multi="-1">-</a></button>
                                                      <div class="inline sp-input">
                                                        <input type="number" ${product.stock_status == 0 ? 'disabled' : ''}  value="1" min="1" data-max="${product.firstprice.stock_manage == 1 ? product.firstprice.qty : 1}" class="quntity-input cart_qty${product.firstprice.stock_status == 0 ? '' :product.id}" >
                                                      </div>
                                                      <button class="inline arrow sp-plus fff"><a class="plus" data-multi="1">+</a></button>
                                                    </div>
                                                </div>
                                                <div class="cart-button">
                                                    ${cart_html}
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;

            var listViewHtml=`<div class="col-12 ${additional_class}">
                                            <div class="single-popular-product list-style">
                                                        <div class="image">
                                                            <img class="lazy" src="${preloader}" data-src="${preview}" alt="">
                                                            <div class="product-overlay">
                                                            <a href="${base_url+'/product/'+product.slug}" class="btn add-to-cart" title="add to Cart"><i class="icofont-shopping-cart"></i></a>
                                                            <a href="javascript:void(0)" data-id="${product.id}" class="btn wishlist add_to_wishlist" title="add to Wishlist"><i class="icofont-heart"></i></a>
                                                            <a href="${base_url+'/product/'+product.slug}"class="btn view"><i class="icofont-link-alt"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="single-item-text">
                                                            <h4 class="single-item-price">${price}</h4>
                                                            <h3 class="single-item-title"><a href="${base_url+'/product/'+product.slug}">${str_limit(product.title,20)}</a></h3><div class="rating-main">
                                                                ${rating_html}
                                                            </div>
                                                            <p>${str_limit(product.excerpt != null ? product.excerpt.value : '',100)}</p>
                                                        </div>
                                                        <div class="single-item-bottom">
                                                            <div class="quantity-main boxed-quantity">
                                                            <div class="sp-quantity">
                                                            <button class="inline arrow sp-minus fff"><a class="minus" data-multi="-1">-</a></button>
                                                            <div class="inline sp-input">
                                                            <input type="number" ${product.stock_status == 0 ? 'disabled' : ''}  value="1" min="1" data-max="${product.firstprice.stock_manage == 1 ? product.firstprice.qty : 1}" class="quntity-input cart_qty${product.firstprice.stock_status == 0 ? '' :product.id}" >
                                                            </div>
                                                            <button class="inline arrow sp-plus fff"><a class="plus" data-multi="1">+</a></button>
                                                            </div>
                                                            </div>
                                                            <div class="cart-button">
                                                                ${cart_html}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;

            listview == true ? $('.listviewproducts').append(listViewHtml) : '';                                             

             $(target).append(html);

    });

    run_lazy();
}

/*-------------------------------------
		render_primary_product
	---------------------------------------*/
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


/*-------------------------------------
		render_discountable_product
	---------------------------------------*/
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

/*-------------------------------------
		Add To Cart Modal
	---------------------------------------*/
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
            qty: qty
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

/*----------------------
		remove_cart
	------------------------*/
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
});

/*----------------------
		cart_increment
	------------------------*/
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


/*----------------------
		cart_decrement
	------------------------*/
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
        $('.cart_item' + rowid).remove();
    }
    audio(cart_sound);
    cartqty(rowid, newqty);


});

/*----------------------
		render_cart
	------------------------*/
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

        var cart_item = `<li class="cart_item cart_item${item.rowId}">
                     <a data-id="${item.rowId}" href="javascript:void(0)" class="remove remove_cart" title="Remove this item"><i class="icofont-close-circled"></i></a>
                     <div class="cart-single-main">
                        <div class="cart-single-item">
                           <h4><a href="${base_url+'/product/'+item.options.slug}">${str_limit(item.name,20)}</a><span>${cart_options}</span></h4>
                           <div class="quantity-main">
                              <p class="quantity">Quantity</p>
                              <div class="sp-quantity">
                                <button class="inline arrow sp-minus fff cart_decrement" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}""><a class="ddd" href="${item.options.options.length != 0 ? base_url+'/product/'+item.options.slug : 'javascript:void(0)'}" data-multi="-1">-</a></button>
                                <div class="inline sp-input">
                                 <input type="text" class="quntity-input current_cart_qty${item.rowId} exist_cart${item.id}" value="${item.qty}">
                                </div>
                                <button class="inline arrow sp-plus fff cart_increment last" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}"><a class="ddd" href="${item.options.options.length != 0 ? base_url+'/product/'+item.options.slug : 'javascript:void(0)'}" data-multi="1">+</a></button>
                              </div>
                           </div>
                        </div>
                        <div class="cart-top">
                           <a class="cart-img " ><img src="${item.options.preview != null ? item.options.preview : ''}" alt=""></a>
                        </div>
                     </div>
                  </li>`;

        if (cartpage == true) {
            var cart_page_item=`<tr class="cart_item cart_item${item.rowId}">
            <td class="image" data-title="No"><img src="${item.options.preview != null ? item.options.preview : ''}" alt="#"></td>
            <td class="product-desc" data-title="Description">
            <p class="product-name"><a href="${base_url+'/product/'+item.options.slug}">${str_limit(item.name,100)}</a></p>
            <p class="product-des">${cart_options}</p>
            </td>
            <td class="price" data-title="Price"><span>${amount_format(item.price)} </span></td>
            <td class="qty" data-title="Qty">
            <div class="sp-quantity">
                <button class="inline arrow sp-minus fff cart_decrement" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}""><a class="ddd" href="${item.options.options.length != 0 ? base_url+'/product/'+item.options.slug : 'javascript:void(0)'}" data-multi="-1">-</a></button>
                <div class="inline sp-input">
                 <input type="text" class="quntity-input current_cart_qty${item.rowId} exist_cart${item.id}" value="${item.qty}">
                </div>
                <button class="inline arrow sp-plus fff cart_increment last" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}"><a class="ddd" href="${item.options.options.length != 0 ? base_url+'/product/'+item.options.slug : 'javascript:void(0)'}" data-multi="1">+</a></button>
            </div>

            </td>
            <td class="total-amount" data-title="Total"><span>${amount_format(item.price*parseInt(item.qty))}</span></td>
            <td class="action" data-title="Remove"><a data-id="${item.rowId}" class="remove remove_cart" href="javascript:void(0)"><i class="icofont-trash remove-icon"></i></a></td>
            </tr>`;

            $('.cart_page').append(cart_page_item);
        }

        $('.shopping-list').append(cart_item);


    });
}

/*----------------------
		cartqty
	------------------------*/
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

/*-------------------------
		add_to_cart_modal
	--------------------------*/
 $(document).on('click','.add_to_cart_modal',function(){

    var product_id=$(this).data('id');
    render_card_modal(product_id);

  });

  /*-------------------------
		add_to_wishlist
	--------------------------*/
 $(document).on('click','.add_to_wishlist',function(){
    var product_id=$(this).data('id');
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
            $('.wishlist_count').html(response);
        },
        error: function(xhr, status, error) {
            $.each(xhr.responseJSON.errors, function(key, item) {
                Sweet('error', item)
            });

        }
    });

 });

   /*-------------------------
		render_card_modal
	--------------------------*/
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
              <span class="selectgroup-button">${child.stock_status == 0 && child.qty == 0 ? '<del>' : ''} ${child.category.name} ${child.stock_status == 0 && child.qty == 0  ? '</del>' : ''}</span>
            </label>
            `;
          });

          html +=`
            <div class="form-group">
          <label class="form-label">${item.categorywithchild.name} ${item.is_required == 1 ? '<span class="text-danger">*</span>' : ''} </label>
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

    /*-------------------------
		    product_option
	    --------------------------*/
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
    
    /*-------------------------
        option_form
    --------------------------*/
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
              $('.subtotal').text(response.cart_subtotal);
             
              $('.cart_count').html(response.cart_count)
              audio();
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

