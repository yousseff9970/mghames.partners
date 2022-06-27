"use strict";

/*=====================================
  Testimonials
======================================= */

function testimonial_slider() {
 
tns({
        container: ".testimonial-slider",
        items: 3,
        slideBy: "page",
        autoplay: false,
        mouseDrag: false,
        gutter: 0,
        nav: true,
        controls: false,
        controlsText: [
            '<i class="lni lni-arrow-left"></i>',
            '<i class="lni lni-arrow-right"></i>',
        ],
        responsive: {
            0: {
                items: 1,
            },
            540: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1170: {
                items: 3,
            },
        },
});
}

/*=====================================
Popular Food Slider
======================================= */
function popular_productslider(topratedproducts) {
  

    if (topratedproducts.length == 0) {
        $('.popular__food').remove()
        return false
    }

    

    $.each(topratedproducts,function(key ,product){
            var preview = product.preview != null ? product.preview.value : base_url + '/uploads/default.png';
            var price= product.firstprice.price;
            price = amount_format(price,'icon');

            var html = `<div class="p-slide-active">
                     <div class="single-p-food align-items-center">
                        <div class="food-text">
                           <h4 class="s-food-title"><a href="${base_url+'/product/'+product.slug}">${str_limit(product.title,18)}</a></h4>
                           <p class="s-food-price"><span>Starting from</span>${price}</p>
                        </div>
                        <div class="s-food-image">
                           <img src="${preloader}" data-src="${preview}" class="lazy" alt="${product.title}">
                        </div>
                     </div>
                  </div>`;

            $('.popular-food-slider').append(html);      
        });
    run_lazy();
    
    tns({
        container: ".popular-food-slider",
        slideBy: "page",
        autoplay: false,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 15,
        nav: false,
        controls: true,
        controlsText: [
            '<i class="icofont-long-arrow-left"></i>',
            '<i class="icofont-long-arrow-right"></i>',
        ],
        responsive: {
            0: {
                items: 1,
            },
            540: {
                items: 2,
            },
            768: {
                items: 3,
            },
            992: {
                items: 3,
            },
            1170: {
                items: 4,
            },
        },
});
}

function render_specialmenudays(data) {
    if (data.length == 0) {
        $('.recommendations').remove()
        return false
    }



    $.each(data,function(key ,row){
            var preview = row.preview != null ? row.preview : base_url + '/uploads/default.png';
            

            var html = key == 0 ? `
                        <div class="single-recommendation">
                           <div class="image">
                              <a href="${row.link}"><img class="lazy" src="${preloader}" data-src="${preview}" alt="${row.title}"></a>
                             
                           </div>
                           <div class="content">
                              <h2><a href="${row.link}">${row.title}</a></h2>
                              <ul>
                                 <li><i class="icofont-calendar"></i> ${row.days}</li>
                                 <li><i class="icofont-clock-time"></i> ${row.time}</li>
                              </ul>
                              <div class="button">
                                 <a class="btn" href="${row.link}" ><i class="icofont-long-arrow-right"></i></a>
                              </div>
                           </div>
                        </div>
                     ` : `
                     <div class="col-lg-6 col-md-6 col-12">
                              <div class="single-recommendation small">
                                 <div class="image">
                                    <a href="${row.link}"><img class="lazy" src="${preloader}" data-src="${preview}" alt="${row.title}"></a>
                                    
                                 </div>
                                 <div class="content">
                                    <h2><a href="${row.link}">${row.title}</a></h2>
                                    <ul>
                                       <li><i class="icofont-calendar"></i> ${row.days}</li>
                                       <li><i class="icofont-clock-time"></i> ${row.time}</li>
                                    </ul>
                                    <div class="button">
                                       <a class="btn" href="${row.link}"><i class="icofont-rounded-right"></i></a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           `;

            $(key == 0 ? '.day1' : '.day2').append(html);      
        });
    run_lazy();
}


runpreloader();


"use strict";

var next_url = $('#next_page').val();

var categories = [];
render_cart(cart_content);

var callbackdata = {
    "productmenu":{
        "limit":5,
        "with":['icon']
    },
    "heroslider":{
        "with":['preview','description']
    },
    "shortbanner":{
        "with":['preview']
    },
    "largebanner":{
        "limit":1,
        "with":['preview','description']
    },
    "menudays":{
        "limit":5,
        "with":["preview"]
    },
    "topratedproducts": {
        "limit":12,
        "with": ["preview", "excerpt"]
    },
    "products": {
        "with_paginate": false,
        "limit":12,
        "with": ["preview", "excerpt"]
    },
    "getdiscountbleproducts": {
        "with_paginate": false,
        "limit":6,
        "with": ["preview", "excerpt","discount"]
    },
    "getreviews": {
        "with_paginate": false,
        "limit":6,
        "with": ["user"]
    },
    "latestblogs": {
        "limit":4,
        "with": ["preview", "excerpt"]
    },
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
        render_product_preloaded(6, '.food_list');
        runpreloader();
    },
    success: function(response) {


       

        $('.content-preloader').remove();

        $.each(response.productmenu, function(key, category) {
            var li = `<li class="nav-item" role="presentation">
                        <button class="nav-link filteredtab filter_products filter_product${category.id}" data-id="${category.id}" data-items="[]"  data-bs-toggle="tab" data-bs-target="#filteredtab" type="button" role="tab" aria-controls="2ndtab" aria-selected="true"><img src="${category.icon != null ? category.icon.content : ''}" alt=""> ${category.name}</button>
                     </li>`;
            $('.menutab').append(li);
        });
        
        $('.all_products').attr('data-items',response.products.data);

        render_primary_product(response.products.data, '.latest_products');
        if (response.getdiscountbleproducts == '') {
            $('.count-down').remove();
        }
        else{
            render_discountable_product(response.getdiscountbleproducts.data, '.getdiscountbleproducts');
        }

        if (response.getreviews == '') {
            
            $('.testimonials').remove();
            
        }
        else{
            render_reviews(response.getreviews.data,'.testimonial-slider')
        }
        
        heroSlider(response.heroslider);
        $.each(response.shortbanner, function(key, row) {
            var button=row.button_text != '' ? `<div class="button">
                                 <a href="${row.link}" class="btn">${row.button_text}</a>
                              </div>` : '';
            var html=`<div class="col-lg-12 col-md-6 col-12">
                        <div class="small-content ${key == 1 ? 'secound dark' : 'first'} " style=" background-image: url('${row.preview}');">
                           <div class="inner">
                              <h4 class="title">${row.title}</h4>
                              ${button}
                              
                           </div>
                        </div>
                     </div>`;

            $('.short_banner').append(html);       
        });

        popular_productslider(response.topratedproducts);
        

       
        $.each(response.largebanner,function(key, row) {
            
            var button=row.button_text != '' ? `<div class="button call-action-button">
                             <a href="${row.link}" class="btn second-btn">${row.button_text}</a>
                          </div>` : '';
            

            var html=`<div class="container">
                        <div class="row">
                           <div class="col-lg-6 col-md-8 col-12">
                              <h2 class="call-action-title"> ${row.title}</h2>
                              <p class="call-action-des">${row.description}</p>
                               ${button}
                           </div>
                        </div>
                     </div>`;         

         
            $('.large_banner').css('background-image','url('+row.preview+')');
            $('.large_banner').append(html);               
        });
        response.largebanner.length == 0 ? $('.large_banner').remove() : run_lazy();
        

        render_specialmenudays(response.menudays);

        var blog_read_more=$('.blog_read_more').val();

        $.each(response.latestblogs,function(key, row) {

            var html=`<div class="col-lg-3 col-md-6 col-12">
                  <div class="shop-single-blog">
                     <div class="image"><a href="${row.url}"><img src="${preloader}" class="lazy" data-src="${row.preview}" alt="${row.title}"></a></div>
                     <div class="content">
                        <p class="date"><i class="icofont-calendar"></i>${row.time}</p>
                        <h4 class="title"><a href="${row.url}">${row.title}</a></h4>
                        <p class="text">${row.short_description}</p>
                        <div class="button">
                           <a href="${row.url}" class="btn">${blog_read_more}</a>
                        </div>
                     </div>
                  </div>
               </div>`;

            $('.latest_blogs').append(html);
        });

        response.latestblogs.length == 0 ? $('.blog_section').remove() : run_lazy();




        if (response.products.next_page_url == null) {
            $('.load_more_product').hide();
        } else {
            $('.load_more_product').show();
        }

    },
    error: function(xhr, status, error) {


    }
});



$('.load_more_product').on('click', function() {
    var url = $(this).data('nextpage');
    getproducts(url);
});






$(document).on('click','.filter_products',function(){
    
    var productid=$(this).data('id');
    var products=$(this).data('items');
    
       console.log(products) 
    
    
    if (products == null || products == '') {
      

        var arr = [];
        arr.push(productid)
       
        var base_url = $('#base_url').val();
        $('.product_item').remove();
       
         var callbackdata = {
        "with_paginate": false,
        "limit":30,
        "categories": arr,
        "with": ["preview", "excerpt"]
        }

        $.ajax({
            type: 'get',
            url: base_url + '/get-product',
            data: callbackdata,
            dataType: 'json',
            beforeSend: function() {
                $('.filteredproduct').remove();
                render_product_preloaded(6, '.filtered_product_tab');
                runpreloader();
            },
            success: function(response) {
                $('.content-preloader').remove();
                render_primary_product(response.data, '.filtered_product_tab','filteredproduct');
                $('.filter_product'+productid).attr('data-items',JSON.stringify(response.data));

                console.log(productid);
                

            },

        });
    }
    else{
        $('.filteredproduct').remove();
        var products=JSON.parse(products);
        render_primary_product(products, '.filtered_product_tab','filteredproduct');
    }


});



function getproducts(url) {
    var callbackdata = {
        "with_paginate": true,
        "categories": categories,
        "with": ["preview", "excerpt"]
    }

    $.ajax({
        type: 'get',
        url: url,
        data: callbackdata,
        dataType: 'json',
        beforeSend: function() {
            render_product_preloaded(6, '.food_list');
            runpreloader();
        },
        success: function(response) {
            $('.content-preloader').remove();

            render_product(response.data, '.food_list');


            response.next_page_url != null ? $('.load_more_product').attr('data-nextpage', response.next_page_url) : $('.load_more_product').removeAttr('data-nextpage');

            if (response.next_page_url == null) {
                $('.load_more_product').hide();
            } else {
                $('.load_more_product').show();
            }

        },

    });
}

 /*=====================================
       Hero Slider
======================================= */

function heroSlider(data) {

    if (data.length == 0) {
        return false;
    }
    $.each(data, function(key, row) {
        var html=`<div class="big-content" style="background-image: url(${row.preview});">
                           <div class="inner">
                              <h4 class="title">${row.title}</h4>
                              <p class="des">${row.description}</p>
                              <div class="button">
                                 <a href="${row.link}" class="btn second-btn">${row.button_text}</a>
                              </div>
                           </div>
                        </div>`;
        $('.hero-slider').append(html);                
    });


    tns({
        container: ".hero-slider",
        slideBy: "page",
        items: 1,
        autoplay: false,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 15,
        nav: false,
        controls: true,
        controlsText: [
        '<i class="icofont-rounded-left"></i>',
        '<i class="icofont-rounded-right"></i>',
        ],
    });
}