"use strict";

/*-----------------------
        Sweet Aleart
    -------------------------*/
function Sweet(icon,title,time=3000){
    
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: time,
        timerProgressBar: true,
        onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })


    Toast.fire({
        icon: icon,
        title: title,
    })
}

var status_data = 0;
$(document).on('click','.page-link',function(){
	var link=$(this).data('url');
	if (link == '') {
		return false;
	}
	getproducts(link);
    status_data = 1;
});

/*==================================
    Product page Quantity Counter
    ===================================*/
    $(document).on('click','.add_to_cart', function() {
    var $qty = $('.input-number');
    var $button = $(this);
    var $input = $button.closest('.quantity').find("input.input-number");
    var currentVal = parseInt($input.val(), 10);
    if (!isNaN(currentVal)) {
        
        $input.val(currentVal + 1);
    }
});
$(document).on('click','.add_to_decrease_cart', function() {
    var $qty = $('.input-number');
    var $button = $(this);
    var $input = $button.closest('.quantity').find("input.input-number");
    var currentVal = parseInt($input.val(), 10);
    
    if (!isNaN(currentVal) && currentVal > 1) {

        $input.val(currentVal - 1);
    }
});

$(document).on('click','.qty_increase', function() {

    var $qty = $('.input-number');
    var $button = $(this);
    var $input = $button.closest('.quantity').find("input.input-number");
    var currentVal = parseInt($input.val(), 10);
    if (!isNaN(currentVal)) {
        
        if ($('.input_qty').data('max') <= currentVal) {
            Sweet('error',$('.input_qty').data('max')+' Pieces Available Only');
            return false;
        }
        else{
            
            $input.val(currentVal + 1);
        }
        
    }
});

$('.minus_qty').on('click', function() {
    var $qty = $('.input-number');
    var $button = $(this);
    var $input = $button.closest('.quantity').find("input.input-number");
    var currentVal = parseInt($input.val(), 10);
    if (!isNaN(currentVal) && currentVal > 1) {
        $input.val(currentVal - 1);
    }
});


var next_url = $('#next_page').val();

var categories = [];


var callbackdata = {
    "productmenu": {
        "limit": '-1'
    },
    "products": {
        "with_paginate": true,
        "with": ["preview", "excerpt","tags"]
    },
    "categories": {
        "with_child": true,
        "with": ["preview"]
    }
}

const callback_url = $('#callback_url').val();

$.ajax({
    type: 'get',
    url: callback_url,
    data: {
        body: callbackdata
    },
    dataType: 'json',
    beforeSend: function() {
    },
    success: function(response) {
        $('.content-preloader').remove();

        status_data = 0;

        render_primary_product(response.products.data, '#latest_product');
        render_categories(response.categories, '#categories');

        if(response.products.links.length > 3) {
            render_pagination('.pagination',response.products.links,'icofont-arrow-left','icofont-arrow-right');
        }
        else{
            $('.page-item').remove();
        }

    },
    error: function(xhr, status, error) {

    }
});

if(status_data == 1){
getproducts(base_url + '/get-product');
}

function getproducts(callback_url)
{
    $.ajax({
        type: 'get',
        url: callback_url,
        data: {
            body: callbackdata
        },
        dataType: 'json',
        beforeSend: function() {
        },
        success: function(response) {
            $('.content-preloader').remove();
            $('.product-item').remove();
            render_primary_product(response.products.data, '#latest_product');
    
            if(response.products.links.length > 3) {
                render_pagination('.pagination',response.products.links,'icofont-arrow-left','icofont-arrow-right');
            }
            else{
                $('.page-item').remove();
            }
    
        },
        error: function(xhr, status, error) {
    
        }
    });
}


/*------------------------
       Cart Sidebar Modal
    ------------------------*/
$('.cart_sidebar_modal').on('click',function(){
    $('.cart-content-main-area').addClass('active');
});

/*-------------------------------
        Category Mobile icon
    -------------------------------*/
$('.category_mobile_icon').on('click',function(){
    $('.grocery-items-collection').toggleClass('active');
}); 

/*------------------------
        Cart Remove
    ------------------------*/
$('#cart_remove').on('click',function(){
    $('.cart-content-main-area').removeClass('active');
});

 /*------------------------
        Product Search
    ------------------------*/
$('.product_search').on('keyup',function(){
    var data = $('.product_search').val();
    var url = $('#product_search_url').val();

    $.ajax({
        type: 'get',
        url: url,
        data: {
            value: data
        },
        dataType: 'json',
        beforeSend: function() {

        },
        success: function(response) {
            $('.content-preloader').remove();

            render_primary_product(response.data, '#latest_product','',false,'html');
        },
        error: function(xhr, status, error) {
    
        }
    });
    
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
