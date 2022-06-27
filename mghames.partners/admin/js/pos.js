(function ($) {
  "use strict";
	$('body').addClass('sidebar-mini');

  var product_url=$('#product_link').val();
  var defaut_img=$('#defaut_img').val();
  var basicbtnhtml=$('.load_more_btn').html();
  var currency_name= $('#currency_name').val();
  var cart_link=$('#cart_link').val();
  var clickaudio=$('#click_sound').val();
  var cart_sound=$('#cart_sound').val();
  var base_url=$('#base_url').val();

  var cart_increment=$('#cart_increment').val();
  var cart_decrement=$('#cart_decrement').val();
  const cart_content= JSON.parse($('#cart_content').val());

  var category='';
  

  render_cart(cart_content);
  get_products(product_url);

  
  $('.barcode').on('input',function(){
    var code= $(this).val();
    if (code != '') {
      if (code.length > 4) {
         $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
      type: 'POST',
      url: cart_link,
      data: {barcode: code, qty: 1},
      dataType: 'json',
      success: function(response){ 
        $('.barcode').val('');
        if (response.product_id != '') {
          render_card_modal(response.product_id);
          $('#product_variation_modal').modal('show');
          
        }
        else{
          render_cart(response.cart_content);
          $('.subtotal').html(response.cart_subtotal);
          $('.tax').html(response.cart_tax);
          $('.total').html(response.cart_total);
          $('.total_amount').val(response.cart_total);
          audio();
          Sweet('success','Cart Added');
        }

        
      },
      error: function(xhr, status, error) 
      {
        $('.barcode').val('');
  
        $.each(xhr.responseJSON.errors, function (key, item) 
        {
          Sweet('error',item)
        });
        
      }
    });
      }
    }

  });

    
    $('.category_item').on('click',function () {
      var category_id=$(this).data('id');
      $('.category_item').removeClass('active');
      $(this).addClass('active');
      

      if (category == category_id) {
        return true;
      }

      category=category_id;
      get_products(product_url,true);
    });
   
                

    $(document).on('click','.load_more_btn',function(){
      var next_url=$(this).attr('data-url');
     
      get_products(next_url);
    });

    function str_limit(text,limit=16) {
      if (text.length > limit) {
        return  (text.slice(0,limit))+'...';
      }
      return text;
     
    }

    $(document).on('click','.add_to_cart',function(){
      var id=$(this).data('id');
      var stockstatus=$(this).data('stockstatus');
      var stockmanage=$(this).data('stockmanage');
      var stockqty=$(this).data('qty');
      

      if (stockstatus == 0) {
        Sweet('error','Stock Out');

        return true;
      }

      if(stockmanage == 1){
        if ($('.exist_cart'+id).length != 0) {
          var exisist_cart=$('.exist_cart'+id).text();
          exisist_cart=parseInt(exisist_cart);
          console.log(exisist_cart)
          if (exisist_cart == stockqty) {
            Sweet('error','Opps maximum stock limit exceeded...!!');

            return true;
          }
        }
      }


      var btn_html=$(this).html();
      $(this).attr('disabled','');
      var spinner=`<div class="spinner-border spinner-border-sm" role="status">
  <span class="visually-hidden"></span>
</div> Please Wait...`;
      $(this).html('');
      $(this).html(spinner);
      var qty=$('.cart_qty'+id).val();

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
      type: 'POST',
      url: cart_link,
      data: {id: id, qty: qty},
      dataType: 'json',
      success: function(response){ 
        $('.cart'+id).html(btn_html);
        $('.cart'+id).removeAttr('disabled'); 

        render_cart(response.cart_content);
        $('.subtotal').html(response.cart_subtotal);
        $('.tax').html(response.cart_tax);
        $('.total').html(response.cart_total);
        $('.total_amount').val(response.cart_total);
        audio();
        Sweet('success','Cart Added');
      },
      error: function(xhr, status, error) 
      {
        
        $('.cart'+id).html(btn_html);
        $('.cart'+id).removeAttr('disabled'); 
  
        $.each(xhr.responseJSON.errors, function (key, item) 
        {
          Sweet('error',item)
        });
        
      }
    });

     


    });


    $(document).on('click','.remove_cart',function(){
       audio(cart_sound);
      var rowid=$(this).data('id');
      $('.cart_item'+rowid).remove();
      $.ajax({
      type: 'get',
      url: base_url+'/seller/remove-cart/'+rowid,
      dataType: 'json',
      success: function(response){ 
        $('.subtotal').html(response.cart_subtotal);
        $('.tax').html(response.cart_tax);
        $('.total').html(response.cart_total);
        $('.total_amount').val(response.cart_total);
        
      },
      
      });
    });

    $(document).on('click','.cart_increment',function(){
      var rowid=$(this).data('id');
      var stock=$(this).data('stock');
      var productid=$(this).data('productid');
       var totalqty=$('.current_cart_qty'+rowid).text();
      if ($(this).data('isvariation') == 1) {
        render_card_modal(productid);
        $('#product_variation_modal').modal('show');
         $('.input_qty').val(totalqty);
        return true;
      }

      
      totalqty=parseInt(totalqty);
      if (stock != null || stock != '') {
        
        if (totalqty < stock) {
          var newqty=totalqty+1;
          $('.current_cart_qty'+rowid).text(newqty);
          $('.current_modal_cart_qty'+rowid).text(newqty);
          audio(cart_sound);
          cartqty(rowid,newqty);
        }
        else{
          Sweet('error','Opps maximum stock limit exceeded...!!');
        }
      }
      else{
        var newqty=totalqty+1;
        $('.current_cart_qty'+rowid).text(newqty);
        $('.current_modal_cart_qty'+rowid).text(newqty);
        
        audio(cart_sound);
        cartqty(rowid,newqty);
      }
      
    });



    $(document).on('click','.cart_decrement',function(){
      var rowid=$(this).data('id');
      var stock=$(this).data('stock');
      var productid=$(this).data('productid');
      var totalqty=$('.current_cart_qty'+rowid).text();

      if ($(this).data('isvariation') == 1) {
        render_card_modal(productid);

        $('#product_variation_modal').modal('show');
        $('.input_qty').val(totalqty);
        return true;
      }

      
      totalqty=parseInt(totalqty);
      var newqty=totalqty-1;
      $('.current_cart_qty'+rowid).text(newqty);
      $('.current_modal_cart_qty'+rowid).text(newqty);
      
      if (newqty == 0 || newqty == NaN) {
        $('.cart_item'+rowid).remove();
      }
      audio(cart_sound);
      cartqty(rowid,newqty);
     

    });

     function get_products(url,remove_item=false) {
      $.ajax({
      type: 'GET',
      url: url,
      data:{category:category},
      dataType: 'json',
      beforeSend: function() {
            
           $('.load_more_btn').html("Please Wait....");
           $('.load_more_btn').attr('disabled','');
           preload();


      },
      
      success: function(response){ 
       if (remove_item == true) {
        $('.product').remove();
       }
       $('.product_preload').remove();

       $('.load_more_btn').removeAttr('disabled');
       $('.load_more_btn').html(basicbtnhtml);
       $('.load_more_btn').attr('data-url',response.next_page_url);
       
       

       response.next_page_url == null ?  $('.load_more_btn').hide() : $('.load_more_btn').show();
       render_product(response.data);

      },
      error: function(xhr, status, error) 
      {
        
      }
     })
    }



    function render_product(items) {
        
        $.each(items, function (key, item) 
        {
           
            var title=str_limit(item.title);
            if (item.media == null) {
              var image = defaut_img;
              
            }
            else{
              var image = item.media.value;
             
            }


            var price = item.is_variation == 1 ?  item.firstprice.price+' - '+item.lastprice.price : item.firstprice.price;
            price= currency_name+' '+price;


            
            if (item.is_variation == 1) {
              var cart_html=`<a data-toggle="modal" data-target="#product_variation_modal" class="add_to_cart_modal" href="javascript:void(0)" data-isvariation="${item.is_variation}" data-id="${item.id}" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg> Add To Cart</a>`;
            }
            else{
              if(item.firstprice.stock_status == 0){
                var is_disable="disabled";
                var cart_text="<del>Stock Out</del>";
              }
              else{
                var is_disable="";
                var cart_text="Add To Cart";
              }

              var cart_html=`<button ${is_disable} type="button" class="add_to_cart cart${item.id}" href="javascript:void(0)" data-isvariation="${item.is_variation}"  data-id="${item.id}" data-stockstatus="${item.firstprice.stock_status}" data-stockmanage="${item.firstprice.stock_manage}" data-qty="${item.firstprice.qty}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>${cart_text}</button>`;
            }
            

            var product_card=` <div class="col-lg-3 mb-30 product" >
                  <div class="single-product">
                    <div class="product-img text-center">
                      <img class="img-fluid" src="${image}" alt="" style="height:150px;"/>
                    </div>
                    <div class="product-content">
                      <div class="product-name">
                        <h5>${title}</h5>
                      </div>
                      <div class="product-price">
                        <span>${price}</span> 
                      </div>
                      <div class="prouct-qty-btn">
                        <div class="product-input">
                        <input type="number" value="1" min="1" class="form-control cart_qty${item.id}" />
                        </div>
                        <div class="product-btn">
                          ${cart_html}
                        </div>
                      </div>
                       
                    </div>
                    <div class="product-codebar">
                      <span>Code: ${item.full_id}</span>
                    </div>
                  </div>
                </div>`;

            $('#product_list').append(product_card);  
        });

    }  



      
    function audio(sound_link=clickaudio) {
        var audio = document.createElement("AUDIO")
        audio.setAttribute('allow', 'autoplay')
        audio.setAttribute('autoplay', 'autoplay')
        document.body.appendChild(audio);
        audio.src = sound_link;
        audio.currentTime = 0;
        return audio;
    }

    

    function render_cart(items) {
        $('.cart_item').remove();
        $.each(items, function (key, item) 
        {

          var cart_item=`<tr class="cart_item cart_item${item.rowId}">
                  <td>
                    <div class="product-qty">
                      <div class="product-qty-minus">
                        <a href="javascript:void(0)" class="cart_decrement" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"/></svg></a>
                      </div>
                      <span class="current_cart_qty${item.rowId} exist_cart${item.id}">${item.qty}</span>
                      <div class="product-qty-plus">
                        <a href="javascript:void(0)" class="cart_increment" data-id="${item.rowId}" data-stock="${item.options.stock }" data-isvariation="${item.options.options.length != 0 ? 1 : 0}" data-productid="${item.id}">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/></svg>
                        </a>
                      </div>
                    </div>
                  </td>
                  <td class="align-middle">
                   ${str_limit(item.name,10)}
                  </td>
                  <td>
                    ${item.price}
                  </td>
                  <td>
                    <div class="delete-btn">
                      <a href="javascript:void(0)" class="remove_cart" data-id="${item.rowId}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M7 4V2h10v2h5v2h-2v15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6H2V4h5zM6 6v14h12V6H6zm3 3h2v8H9V9zm4 0h2v8h-2V9z"/></svg></a>
                    </div>
                  </td>
                </tr>`;

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
            var cart_modal_item=`<tr class="cart_item cart_item${item.rowId}">
                  <td class="w-80 text-left">${str_limit(item.name,70)} (<span class="current_modal_cart_qty${item.rowId}">${item.qty}</span>) ${cart_options}</td>
                  <td class="text-right w-10">${item.price}</td>
               </tr>`;

            $('.cart_modal').append(cart_modal_item);
            $('.cart_table_body').append(cart_item); 


        });  
    }

    function cartqty(cartId,qty) {
      var url = cart_increment;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
      type: 'POST',
      url: url,
      data: {id: cartId, qty: qty},
      dataType: 'json',
      success: function(response){ 
       
        $('.subtotal').html(response.cart_subtotal);
        $('.tax').html(response.cart_tax);
        $('.total').html(response.cart_total);
        $('.total_amount').val(response.cart_total);

      },
      error: function(xhr, status, error) 
      {
        
       
  
        $.each(xhr.responseJSON.errors, function (key, item) 
        {
          Sweet('error',item)
        });
        
      }
    });
      
    }

    function preload() {
      return true;
    }

      /*----------------------------
          Jquery Live Search for table
          ------------------------------*/
  $('#product_search').keyup(function(){  
    search_table($(this).val());  
  });  
  function search_table(value){  
    $('#product_list .col-lg-3').each(function(){  
      var found = 'false';  
      $(this).each(function(){  
        if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)  
        {  
          found = true;  
        }  
      });  
      if(found == true)  
      {  
        $(this).show();  
      }  
      else  
      {  
        $(this).hide();  
      }  
    });  
  } 

  $(".search_form").on('submit', function(e){
    e.preventDefault();
      

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: 'POST',
      url: this.action,
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      beforeSend: function() {

       },
      
      success: function(response){ 
         $('.product').remove();
         $('.product_preload').remove();
         
         $('.load_more_btn').removeAttr('disabled');
         $('.load_more_btn').html(basicbtnhtml);
         $('.load_more_btn').attr('data-url',response.next_page_url);
         
         

         response.next_page_url == null ?  $('.load_more_btn').hide() : $('.load_more_btn').show();
         render_product(response.data);
      },
      error: function(xhr, status, error) 
      {
       
        $.each(xhr.responseJSON.errors, function (key, item) 
        {
          Sweet('error',item)
          
        });
      
      }
    })


  });

  $(document).on('click','.add_to_cart_modal',function(){

    var product_id=$(this).data('id');
    render_card_modal(product_id);

  });

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
              $('.subtotal').html(response.cart_subtotal);
              $('.tax').html(response.cart_tax);
              $('.total').html(response.cart_total);
              $('.total_amount').val(response.cart_total);
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


  //end pos code

  $('#customer_email').on('focusout',function(){
    var email=$(this).val();
    if (email == '') {
      $('#customer_id').val('');
      return false;
    }
    if (validateEmail(email) == false) {
      Sweet('error','Enter a valid email');
      return false;
    }

    var url=base_url+'/seller/check-customer';
           $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
           });

          $.ajax({
            type: 'POST',
            url: url,
            data: {email:email},
            dataType: 'json',
            beforeSend: function(){
             
              $('#order_btn').attr('disabled','');
            },
            success: function(response){ 
             
             $('#order_btn').removeAttr('disabled');
             $('#customer_id').val(response.user_id);
             $('.customer_name').val(response.name);
             $('.customer_email').val(response.email);
             

              
            },
            error: function(xhr, status, error) 
            {
              $('#order_btn').removeAttr('disabled');
              Sweet('error','Customer Not Found');
              
            }
        });
    
  });

  $('.customer_store_form').on('submit',function(e){
            e.preventDefault();
           $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
           });
            var form_data = $(this).serialize();
          $.ajax({
            type: 'POST',
            url: this.action,
            data: form_data,
            dataType: 'json',
            beforeSend: function(){
              
              $('.customer_create_btn').attr('disabled','');
              $('#order_btn').attr('disabled','');
            },
            success: function(response){ 
             $('.customer_store_form').trigger('reset');
             $('#order_btn').attr('disabled','');
             $('#customer_create_btn').removeAttr('disabled');
             $('#customer_id').val(response.user_id);
             $('#customer_email').val(response.email);
             $('.customer_name').val(response.name);
             $('.customer_email').val(response.email);
             
             Sweet('success','Customer Created....!!!');
              
            },
            error: function(xhr, status, error) 
            {
              $('#order_btn').removeAttr('disabled');
              $('#customer_create_btn').removeAttr('disabled');
              $.each(xhr.responseJSON.errors, function (key, item) 
              {
                Sweet('error',item)
               
              });
              
            }
        });
  });



  function validateEmail(email) 
  {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
  }


  $('.pre_order').on('change',function(){
    $(this).val() == 1 ? $('.date_time').show() : $('.date_time').hide();
  });

  $('.order_method').on('change',function(){
    var method=$(this).val();
    method == 'table' ? $('.table_area').show() : $('.table_area').hide();
    method == 'delivery' ? $('.location_area').show() : $('.location_area').hide();

    if (method != 'delivery') {
      var main_price=$('.total_amount').val();
      $('.shipping_charge').html('0.0');
      $('.shipping_price').val('0');
      $('.total').html(main_price);
    }

  });

  $('#order_btn').on('click',function(){
      if ($('.cart_item').length == 0) {
        return false;
      }

      $.ajax({
            type: 'GET',
            url: base_url+'/seller/apply-tax',
            dataType: 'json',
  
            success: function(response){ 
              $('.subtotal').html(response.cart_subtotal);
              $('.tax').html(response.cart_tax);
              $('.total').html(response.cart_total);
              $('.total_amount').val(response.cart_total);
              
            },
            error: function(xhr, status, error) 
            {
             
              $.each(xhr.responseJSON.errors, function (key, item) 
              {
                Sweet('error',item)
               
              });
              
            }
        });
  });

  $('#time').on('change',function(){
     var inputEle = document.getElementById('time');
     var timeSplit = inputEle.value.split(':'),
     hours,
     minutes,
     meridian;
     hours = timeSplit[0];
     minutes = timeSplit[1];
     if (hours > 12) {
      meridian = 'PM';
      hours -= 12;
    } else if (hours < 12) {
      meridian = 'AM';
      if (hours == 0) {
        hours = 12;
      }
    } else {
      meridian = 'PM';
    }
    

    $('.time').val(hours + ':' + minutes + ' ' + meridian)
  });

  $('#location').on('change',function(){
    $('.methods').remove();
    var shippings=$(this).find(':selected').data('shipping');
    

    $.each(shippings,function(key,item){
     var shipping_methods =`<option class="methods" value="${item.id}" data-price="${item.slug}">${item.name}</option>`;
      $('#shipping_method').append(shipping_methods);
    });

    

  });

  $('#shipping_method').on('change',function(){
     var price=$(this).find(':selected').data('price');
     var price=parseInt(price);

     var main_price=$('.total_amount').val();
         main_price=main_price.replace(',','');
         main_price=parseFloat(main_price);
     var new_price=main_price+price;
     $('.shipping_charge').html(price);
     $('.shipping_price').val(price);
     $('.total').html(new_price);
  });

})(jQuery);