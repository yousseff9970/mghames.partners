"use strict";

/*------------------------------
        render_pagination
    -----------------------------*/
runpreloader();
function render_pagination(target,data,left_icon="fas fa-angle-left",right_icon="fas fa-angle-right"){
        $('.page-item').remove();
       $.each(data, function(key,value){
            if(value.label === '&laquo; Previous'){
                if(value.url === null){
                    var is_disabled="disabled"; 
                    var is_active=null;
                }
                else{
                    var is_active='page-link-no'+key;
                    var is_disabled='';
                }
                var html='<li  class="page-item '+is_active+'"><a '+is_disabled+' class="products-link '+is_active+'" href="javascript:void(0)" data-url="'+value.url+'"><i class="'+left_icon+'"></i></a></li>';
            }
            else if(value.label === 'Next &raquo;'){
                if(value.url === null){
                    var is_disabled="disabled"; 
                    var is_active=null;
                }
                else{
                    var is_active='page-link-no'+key;
                   var is_disabled='';
                }
                var html='<li class="page-item '+is_active+'"><a '+is_disabled+'  class=" products-link '+is_active+'" href="javascript:void(0)" data-url="'+value.url+'"><i class="'+right_icon+'"></i></a></li>';
            }
            else{
                if(value.active==true){
                    var is_active="active";
                    var is_disabled="disabled";
                    var url=null;

                }
                else{
                    var is_active='page-link-no'+key;
                    var is_disabled='';
                    var url=value.url;
                }
                var html='<li class="page-item '+is_active+'"><a class="products-link '+is_active+'" '+is_disabled+' href="javascript:void(0)" data-url="'+url+'">'+value.label+'</a></li>';
            }
            if(value.url !== null){
              $(target).append(html);
            }
            
       });
    }

	

	var term_src=$('#term_src').val();

	var callback_url = base_url+'/databack';

	var categories=[];
	var variations=[];

	/*---------------------
        products-link
    --------------------*/
	$(document).on('click','.products-link',function(){
		var link=$(this).data('url');
		if (link == '') {
			return false;
		}
		getproducts(link);
	});

	
	getproducts(base_url + '/get-product');

	$(document).on('change','#product_limit',function(){
		getproducts(base_url + '/get-product');
	});

	$(document).on('change','#order_by',function(){
		getproducts(base_url + '/get-product');
	});	

	$(document).on('click','#product_price_filter',function(){
		getproducts(base_url + '/get-product');
	});
	

	/*---------------------
       		getproducts
    	--------------------*/
	function getproducts(url) {
		var callbackdata = {
			"with_paginate": true,
			"limit":$('#product_limit').val(),
			"orderby": $('#order_by').val(),
			"with": ["preview", "excerpt","discount","features"],
			"hasdiscount":true
		}

		$.ajax({
			type: 'get',
			url: url,
			data: callbackdata,
			dataType: 'json',
			beforeSend: function() {
				$('.product-item').remove();
			
				render_product_preloaded($('#product_limit').val(), '.primary_products_area','','col-lg-3 col-6 product-item');
				runpreloader();
			},
			success: function(response) {
				$('.content-preloader').remove();
				$('.product-item').remove();

				$('.from_products').html(response.from);
				$('.to_products').html(response.to);
				$('.total_products').html(response.total);

				
				
				response.data.length == 0 ? $('.zero_product').show() : $('.zero_product').hide();

				

				 render_primary_product(response.data,'.primary_products_area','product-item col-lg-3 col-6',true);
				if(response.links.length > 3) {
					render_pagination('.pagination-list',response.links,'icofont-arrow-left','icofont-arrow-right');
				}
				else{
					$('.page-item').remove();
				}

				 runCountdown();


			},

		});
	}