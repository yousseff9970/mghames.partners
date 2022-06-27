"use strict";

var totalprice=0;
var totaloldprice=0;

$(document).on('click','.page-link',function(){
	var link=$(this).data('url');
	if (link == '') {
		return false;
	}
	getreviews(link);
});

/*-------------------------
		pricesvariations
	-------------------------*/
$('.pricesvariations').on('change',function(){
	var stockstatus=$(this).data('stockstatus');
	var stockmanage=$(this).data('stockmanage');
	var sku=$(this).data('sku');
	var qty=$(this).data('qty');
	var oldprice=$(this).data('oldprice');
	var price=$(this).data('price');
	totalprice=0;
	totaloldprice=0;

	if ($(this).is(':checked')){
		var stockstatus_html= stockstatus == 1 ? `<a href="javascript:void(0)">In stock</a>` : '<a href="javascript:void(0)">Stock Out</a>';
		$('.stock_status_display').html(stockstatus_html);
		$('.stock_status').show();

		if(stockmanage == 1){
			$('.qty_display').show();
		    $('.modal_maxqty').text(qty);
		    $('.modal_qty_display').show();
		}
		
	}
	else{

		$('.stock_status').hide();
		$('.qty_display').hide();
	
	}
	
	variations();


});

/*-------------------------
		variations
	-------------------------*/
variations();

function variations() {

	if ($('.pricesvariationshide').length == 1) {

		$('.pricesvariationshide').each(function() {

		
			var oldprice=$(this).data('oldprice');
		    var price=$(this).data('price');
		    var qty=$(this).data('qty');
		    totalprice= totalprice+price;
		    totaloldprice= totaloldprice+oldprice;

		    if ($(this).data('stockstatus') == 1) {
		    	$('.input_qty').attr('data-max',qty);
		    	$('.input_qty').attr('max',qty);
		    }
		    $('.add_to_cart_btn').removeAttr('disabled');
		       
			
        });

	    $('.pricesvariationshide').each(function() {
	    	if ($(this).is(':checked') && $(this).data('stockstatus') == 0) {
	    		$('.add_to_cart_btn').attr('disabled','');
	    	}
	    });
	}
	else{
		$('.pricesvariations').each(function() {

		if ($(this).is(':checked') && $(this).data('stockstatus') == 1) {
			var oldprice=$(this).data('oldprice');
		    var price=$(this).data('price');
		    var qty=$(this).data('qty');
		    totalprice= totalprice+price;
		    totaloldprice= totaloldprice+oldprice;

		    if ($(this).data('stockmanage') == 1) {
		    	$('.input_qty').attr('data-max',qty);
		    	$('.input_qty').attr('max',qty);
		    }
		    $('.add_to_cart_btn').removeAttr('disabled');
		       
			}
	    });

	    $('.pricesvariations').each(function() {
	    	if ($(this).is(':checked') && $(this).data('stockstatus') == 0) {
	    		$('.add_to_cart_btn').attr('disabled','');
	    	}
	    });


		if (totalprice == 0) {
			$('.price_area').html('');
			return false;
		}
	}
	
    var newtotaloldprice = totaloldprice != 0 ? amount_format(totaloldprice) : '';
    var price_html=`<span class="discount">${amount_format(totalprice)}</span><s>${newtotaloldprice}</s>`;
	$('.price_area').html(price_html);
}


var categories=[];

$('.categories').each(function() {
	categories.push($(this).data('id'));
});

/*-------------------------
		Get Products
	-------------------------*/
var callbackdata = {
	"with_paginate": false,
	"limit":6,
	"categories": categories,
	"with": ["preview","features","discount"]
}

$.ajax({
	type: 'get',
	url: base_url + '/get-product',
	data: callbackdata,
	dataType: 'json',
	beforeSend: function() {

		render_product_preloaded(6, '.related_product_slider_preloader');
		ActiveCarousel('.related_product_slider_preloader',5,false);
		runpreloader();
	},
	success: function(response) {
		$('.related_product_slider_preloader').remove();
		render_primary_product(response.data, '.related-slider');
		$('.related-sliders').owlCarousel({
            autoplay: true,
            loop: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            smartSpeed: 500,
            merge: true,
            nav: false,
            dots: false,
            margin: 30,
            responsive: {
                300: {
                    items: 1,
                },
                480: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                1170: {
                    items: 5,
                },
            }
        });
		runCountdown();
		


	},

});

/*-------------------------
		getreviews
	-------------------------*/
function getreviews(url){
	 $.ajax({
		    type: 'get',
		    url: url,
		    dataType: 'json',
		    beforeSend: function() {
		        runpreloader();
		    },
		    success: function(response) {
		    	$('.single-rating').remove();
		    	$.each(response.data,function(key ,row){
		    		var ratings='';

		    		for (var i = 1; i <= 5; i++) {
		    			var review_full=`<li><i class="icofont-star star"></i></li>`;
		    			var review_half=`<li><i class="icofont-star"></i></li>`;

		    			i > row.rating ? ratings += review_half : ratings += review_full;
		    		}

			    		var html=`
						<div class="single-rating">
											<div class="rating-author">
												<img src="${'https://ui-avatars.com/api/?rounded=true&background=random&'+row.username}" alt="#"/>
											</div>
											<div class="rating-des">
												<h6>${escapeHtml(row.username)}</h6>
												<div class="ratings">
													<ul class="rating">
														${ratings}
													</ul>
													<div class="rate-count">(<span>${row.rating}</span>)</div>
												</div>
												<p>${escapeHtml(row.comment)}</p>
											</div>
										</div>`;

			    	   $('.ratting-main').append(html);
		         });		
		    	if(response.links.length > 3) {
		    	render_pagination('.pagination',response.links);
		        }
		        else{
                  $('.page-item').remove();
                }
		       
		    },
		    error: function(xhr, status, error) {


		    }
     });
	}

	/*-------------------------
			product_option_form
		-------------------------*/
  	$(document).on('submit','.product_option_form', function(e) {
        e.preventDefault();

        if ($('.pricesvariationshide').length == 1) {
	        var $qty = $('.input-number');
	        var $button = $(this);
	        var $input = $button.closest('.quantity').find("input.input-number");
	        var currentVal = parseInt($input.val(), 10);
	        if (!isNaN(currentVal)) {
	        	
	        	if ($('.input_qty').data('max') < currentVal) {
	        		Sweet('error',$('.input_qty').data('max')+' Pieces Available Only');
	        		return false;
	        	}
	        	
	        }

        }

        var required=false;
        
        
        if($('.required_var').length > 0){
        	$('.required_var').each(function () {
        		var optionid=$(this).data('id');
        		required = false;

        		$('.variations'+optionid).each(function () {
        			if (this.checked == true) {
        				required = true;
        			}
        		});	

        	});
        }
        else{
        	required = true;
        }

        if(required == false || totalprice == 0){
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
              $('.add_to_cart_form_btn').text('Please Wait.....');
              $('.add_to_cart_form_btn').attr('disabled','');
            },
            success: function(response){ 
              $('.add_to_cart_form_btn').text('Add To Cart');
              $('.add_to_cart_form_btn').removeAttr('disabled');

              render_cart(response.cart_content);
              $('.subtotal').html(response.cart_subtotal);
              $('.cart_subtotal').html(response.cart_subtotal);
              
              $('.tax').html(response.cart_tax);
              $('.cart_subtotal').html(response.cart_total);
              $('.total_amount').val(response.cart_total);
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

	/*-------------------------
			color_single
		-------------------------*/
    $('.color_single').on('change', function () {
			var id=$(this).val();
			var idName=$(this).attr('id');

			if ($(this).is(':checked')){
				$('.'+idName).html('<i class="icofont-verification-check"></i>');
			}
			else{
				$('.'+idName).html('');
			}
			
	});

	/*-------------------------
			wishlist_btn
		-------------------------*/
	$(document).on('click','.wishlist_btn',function(){
		$(this).removeClass('wishlist_btn');
		$(this).addClass('wishlist_active');
		var html= $(this).html();

		   $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
           });

          $.ajax({
            type: 'POST',
            url: base_url+'/add-to-wishlist',
            data: {id: $(this).data('id'),getrowid:true},
            dataType: 'json',
            beforeSend: function(){
            	var spinner = `<div class="spinner-border spinner-border-sm" role="status">
            	<span class="visually-hidden"></span>
            	</div>`;
            	 $('.wishlist_active').html(spinner);
              
            },
            success: function(response){ 
            	 $('.wishlist_active').html(html);
            	 $('.wishlist_active').attr('data-rowid',response.rowid);
            	 $('.wishlist_count').html(response.count);
            },
            error: function(xhr, status, error) 
            {
              
              $(this).addClass('wishlist_btn');
            }
        });

	});

	/*-------------------------
			wishlist_active
		-------------------------*/
	$(document).on('click','.wishlist_active',function(){
		$(this).removeClass('wishlist_active');
		$(this).addClass('wishlist_btn');
          $.ajax({
            type: 'GET',
            url: base_url+'/remove-wishlist/'+$(this).data('rowid'),
            dataType: 'json',
            success: function(response){ 
            	
            }
        });

	});

