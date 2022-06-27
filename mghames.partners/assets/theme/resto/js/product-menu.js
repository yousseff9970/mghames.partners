"use strict";

runpreloader();

var callbackdata = {
    "productmenu":{
        "limit": -1,
        "withcount":true
    },
}

var callback_url = $('#callback_url').val();

var categories=[];

$(document).on('click','.menu_item',function(){
	$('.menu_item').removeClass('active');
	$(this).addClass('active')
	if ($(this).data('count') == 0) {
		$('.product-item').remove();
		$('.zero_product').show();
		return false;
	}
	$('.zero_product').hide();
	categories=[];
	categories.push($(this).data('id'));

	getproducts(base_url + '/get-product');


});

$.ajax({
    type: 'get',
    url: callback_url,
    data: {
        body: callbackdata
    },
    dataType: 'json',
    beforeSend: function() {
    	   for (var i = 0; i <= 10; i++) {
        		var html=`<div class="col-lg-4 col-md-6 col-12 content-preloader">
        		<div class="top-addon-single  content-placeholder"  data-height="100px"  data-width="100%">
        		</div>
        		</div>`;
        		$('.product_area').append(html);		
        	}
            runpreloader();
    },
    success: function(response) {
       $('.menu_preload').remove();

       $.each(response.productmenu, function(key, category) {
         	categories.push(category.id);
       		var html=`<li><a data-count="${category.termcategories_count}" data-id="${category.id}" class="menu_item" href="javascript:void(0)">${category.name}<span>${category.termcategories_count}</span></a></li>`;
        	
        	$('.product_menu').append(html);
        	
        	
        });

       getproducts(base_url + '/get-product');



    },
    error: function(xhr, status, error) {


    }
});

$(document).on('click','.page-link',function(){
	var link=$(this).data('url');
	if (link == '') {
		return false;
	}
	getproducts(link);
});

function getproducts(url) {
    var callbackdata = {
        "with_paginate": true,
        "limit":12,
        "categories": categories,
        "with": ["preview", "excerpt","features"]
    }

    $.ajax({
        type: 'get',
        url: url,
        data: callbackdata,
        dataType: 'json',
        beforeSend: function() {
        	$('.product-item').remove();
        	for (var i = 0; i <= 10; i++) {
        		var html=`<div class="col-lg-4 col-md-6 col-12 content-preloader">
        		<div class="top-addon-single  content-placeholder"  data-height="100px"  data-width="100%">
        		</div>
        		</div>`;
        		$('.product_area').append(html);		
        	}
            runpreloader();
        },
        success: function(response) {
           $('.content-preloader').remove();
          
           
           $.each(response.data, function(key, product) {
           	 var preview = product.preview != null ? product.preview.value : base_url + '/uploads/default.png';
	         var price= product.firstprice.price;
             price = amount_format(price,'name');



           	var html=`<div class="col-lg-4 col-md-6 col-12 product-item">
							<div class="top-addon-single">
								<div class="top-single-left">
									<div class="top-s-title"><a href="${base_url+'/product/'+product.slug}"><h5>${product.title}</h5></a></div>
									<p>${str_limit(product.excerpt != null ? product.excerpt.value : '',50)}</p>
									<div class="addon-price"><span>${price}</span> &nbsp&nbsp <span class="pr-tag">${product.features.length != 0 ? product.features[0].name : '' }</span></div>
								</div>
								<div class="top-single-right">
									<div class="top-right-img">
									<a href="${base_url+'/product/'+product.slug}">
										<img src="${preview}" alt="${product.title}">
									</a>	
									</div>
								</div>
							</div>
					   </div>`;

			$('.product_area').append(html);		   

           });
           if(response.links.length > 3) {
           	render_pagination('.pagination-list',response.links,'icofont-arrow-left','icofont-arrow-right');
           }
           else{
           	$('.page-item').remove();
           }


           

        },

    });
}