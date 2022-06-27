"use strict";

render_product_preloaded(6, '.latest_products_preloader');
render_product_preloaded(5, '.random_products_preload','tabs-p col-lg-3 col-md-6 col-6');
render_product_preloaded(5, '.toprated_products_preload');


runpreloader();
ActiveCarousel('.latest_products_preloader',5,false);
ActiveCarousel('.random_products_preload',5,false);
ActiveCarousel('.toprated_products_preload',5,false);


var next_url = $('#next_page').val();

var categories = [];


var callbackdata = []; 

if ($('.hero_slider_section').length != 0) {
   callbackdata.push({
       "key":"heroslider",
       "row":"heroslider",
       "with":['preview','description']
    });
}


if ($('.short_banner_section').length != 0) {
   callbackdata.push({
       "key":"shortbanner",
       "row":"shortbanner",
       "with":['preview','description']
    });
}


if ($('.latest_product_section').length != 0) {
   callbackdata.push({
        "key":"products",
        "row":"latest_products",
        "limit":12,
        "with": ["preview","features","discount"]
    });
}


if ($('.category_section').length != 0) {
   callbackdata.push({
       "key":"categories",
       "row":"featured_category",
       "featured":1,
       "limit": -1,
       "type":"category",
       "with":['preview']
    });
}

if ($('.product_tab_section').length != 0) {
   callbackdata.push({
       "key":"productmenu",
       "row":"productmenu",
       "limit": 5,
       "type":"category",
       "with":['icon']
    },
    {
        "key":"products",
        "row":"random_products",
        "is_random":true,
        "limit":12,
        "with": ["preview","features","discount"]
    });
}

if ($('.featured_products_area').length != 0) {
   callbackdata.push({  
       "key":"HomePageFeaturedWithProducts",
       "row":"home_page_featured_with_products",
       "limit":2,
       "with": ["preview"],
       "product_with":["preview","discount"],
       "is_product_random":true
    });
}

if ($('.toprated_products_area').length != 0) {
   callbackdata.push({
        "key":"topratedproducts",
        "row":"topratedproducts",
        "limit":12,
        "with": ["preview","discount"]
    });
}

if ($('.blog_section').length != 0) {
   callbackdata.push({  
       "key":"latestblogs",
       "row":"latestblogs",
       "limit":2,
       "with": ["preview", "excerpt"]
    });
}


if ($('.brand_section').length != 0) {
   callbackdata.push({
       "key":"categories",
       "row":"brands",
       "featured":1,
       "limit": -1,
       "type":"brand",
       "with":['preview']
    });
}




var callback_url = $('#callback_url').val();  

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


       
         $('.latest_products_preloader').remove();
         $('.toprated_products_preload').remove();
         $('.random_products_preload').remove();
         

        $('.content-preloader').remove();

       
        if ($('.hero_slider_section').length != 0) {
         if (response.heroslider.length != 0) {
            heroSlider(response.heroslider);
         }
         else{
            $('.hero_slider_section').remove();
          
         }
        }

        if ($('.short_banner_section').length != 0) {
         if (response.shortbanner.length != 0) {
            render_shortbanner(response.shortbanner);
         }
         else{
            $('.short_banner_section').remove();
          
         }
        }

        if ($('.latest_product_section').length != 0) {
         if (response.latest_products.length != 0) {
            render_primary_product(response.latest_products,'.latest_products','ps-slider product-slider',true)
         }
         else{
            $('.latest_product_section').remove();
          
         }
        }

        if ($('.category_section').length != 0) {
         if (response.featured_category.length != 0) {
            render_featuredcategory(response.featured_category);
         }
         else{
            $('.category_section').remove();
          
         }
        }

        
         if ($('.product_tab_section').length != 0) {
         if (response.random_products.length != 0) {
            render_primary_product(response.random_products, '.random_products','tabs-p col-lg-3 col-md-6 col-6',true);

            $.each(response.productmenu, function(key, category) {
              var html=` <li><a class="list-group-item  filteredtab filterproducts filter_product${category.id}" data-id="${category.id}" data-items="[]" data-bs-toggle="list" href="#f-tab2" role="tab"><img src="${category.icon != null ? category.icon.content : ''}" alt="">${category.name}</a></li>`;
              $('.product_menu').append(html);

           });

         }
         else{
            $('.product_tab_section').remove();
          
         }
        }
        

        if ($('.featured_products_area').length != 0) {

         if (response.home_page_featured_with_products.length != 0) {
            render_featured_products(response.home_page_featured_with_products);

         }
         else{
            $('.featured_products_area').remove();
          
         }
        }
        
        if ($('.toprated_products_area').length != 0) {
         if (response.topratedproducts.length != 0) {
             render_primary_product(response.topratedproducts,'.toprated_products','ps-slider product-slider',true)
         }
         else{
            $('.toprated_products_area').remove();
          
         }
        }

        if ($('.blog_section').length != 0) {
         if (response.latestblogs.length != 0) {
             render_blogs(response.latestblogs);
         }
         else{
            $('.blog_section').remove();
          
         }
        }
        

        if ($('.brand_section').length != 0) {
         if (response.brands.length != 0) {
             render_brands(response.brands);
         }
         else{
            $('.brand_section').remove();
          
         }
        }

        
       
        
       
        
        
        
       
        
        

        
        ActiveCarousel('.latest_products');
        ActiveCarousel('.toprated_products');

        runCountdown();
    },
    error: function(xhr, status, error) {


    }
});

$(document).on('click','.filteredtab',function(){
   $('.tab2').addClass('active'); 
   $('.tab2').addClass('show'); 

   $('.tab1').removeClass('show'); 
   $('.tab1').removeClass('active'); 
   
    
})

function heroSlider(data) {

    if (data.length == 0) {
        return false;
    }
    $.each(data, function(key, row) {
       
         var html=`<div class="single-slider" style="background-image:url(${row.preview})">
         <div class="container">
            <div class="row">
               <div class="col-lg-5 col-md-6 col-12">
                 
                  <div class="hero-content">
                     <h1 class="slider-title">${row.title}</h1>
                     <p>${row.description}</p>
                     <div class="buttons">
                        <a href="${row.link}" class="theme-btn">${row.button_text}</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>`;               
        $('.hero-slider').append(html);                
    });


    $('.hero-slider').owlCarousel({
      items: 1,
      autoplay: true,
      loop: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: false,
      smartSpeed: 500,
      merge: true,
      nav: true,
      navText: ['<i class="icofont-simple-left" aria-hidden="true"></i>', '<i class="icofont-simple-right" aria-hidden="true"></i>'],
      dots: false,
      margin: 0,
   });
}

function render_shortbanner(data) {

   if (data.length == 0) {
        return false;
    }
    $.each(data, function(key, row) {
        
         var button=row.button_text != '' ? `
                                 <a href="${row.link}" class="theme-btn primary">${row.button_text}</a>
                              ` : '';

         var html=`<div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay=".2s">
                  <div class="features-banner overlay-simple">
                     <div class="feature-img">
                        <img src="${row.preview}" alt="">
                        <div class="feature-content">
                           <h3>${row.title} <span class="font-style">${row.description}</span></h3>
                           ${button}
                        </div>
                     </div>
                  </div>
               </div>`;

      $('.short_banner').append(html);                
    });      
}



function render_blogs(data) {
     var blog_read_more=$('#blog_read_more').val();

     $.each(data,function(key, row) {

     

      var html=`<div class="col-lg-6 col-md-6 col-12 wow fadeInUp"  data-wow-delay=".4s">
            <div class="single-blog m-top-30">
               <div class="blog-image">
                  <img src="${preloader}" class="lazy" data-src="${row.preview}" alt="${row.title}">
                  <div class="blog-img-bottom">
                     <ul class="blog-top-meta">
                     </ul>
                     <div class="blog-button">
                        <a href="${row.url}" class="theme-btn without-bordered">${blog_read_more}</a>
                     </div>
                  </div>
               </div>
               <div class="blog-content">
                  <h3 class="blog-title"><a href="${row.url}">${row.title}</a></h3>
                  <p>${row.short_description} </p>
                  <div class="blog-btm-meta flex">
                     <div class="meta-btm m-date"><span class="pr-color"><i class="icofont-calendar"></i></span>${row.time}</div>
                  </div>
               </div>
            </div>
         </div>`;

      $('.latest_blogs').append(html);
   });

     data.length == 0 ? $('.blog_section').remove() : run_lazy();
}

function render_featuredcategory(data) {
   if (data.length == 0) {
      $('.featured_category').remove();
      return false;
   }


   $.each(data,function(key, row) {
      var preview=row.preview != null ? row.preview.content : defaut_img;

     

        var html=`<div >
               <a href="${base_url+'/category/'+row.slug}">
                  <div class="single-category text-center">
                     <div class="category-img">
                        <img src="${preloader}" class="lazy" data-src="${preview}" alt="${row.name}">
                     </div>
                     <div class="category-name">
                        <h4>${row.name}</h4>
                       
                     </div>
                  </div>
               </a>
            </div>`;       

      $('.department-slider').append(html);
   });

   $('.department-slider').owlCarousel({
            items: 4,
            autoplay: true,
            loop: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            smartSpeed: 500,
            merge: true,
            nav: true,
            navText: ['<i class="icofont-rounded-double-left" aria-hidden="true"></i>', '<i class="icofont-rounded-double-right" aria-hidden="true"></i>'],
            dots: false,
            margin: 30,
            responsive: {
                300: {
                    items: 2,
                    margin: 15,
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
      run_lazy();
}


function render_brands(data) {
    if (data.length == 0) {
      $('.partner-area').remove();
      return false;
    }


   $.each(data,function(key, row) {
      var preview=row.preview != null ? row.preview.content : defaut_img;

      var html=`
               <div class="single-partner">
                  <a href="${base_url+'/brand/'+row.slug}"><img src="${preloader}" class="lazy" data-src="${preview}" alt="${row.name}"></a>
               </div>
               `;

      $('.partner-slider').append(html);
   });

   $('.partner-slider').owlCarousel({
            items: 6,
            autoplay: true,
            loop: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: false,
            smartSpeed: 500,
            merge: true,
            nav: false,
            dots: false,
            margin: 30,
            responsive: {
                300: {
                    items: 2,
                },
                480: {
                    items: 3,
                },
                768: {
                    items: 4,
                },
                1170: {
                    items: 6,
                },
            }
        });

    run_lazy();
}

function isOdd(n) {
   return Math.abs(n % 2) == 1;
}

function render_featured_products(data) {
   if (data.length == 0) {
      $('.featured_products_area').remove();
      return false;
    }


   $.each(data,function(key, row) {

      

      var html=`<section class="cat-side-area section-padding ${isOdd(key) == false ? 'bg-second' : ''}">
         <div class="container">
               <div class="row">
                  <div class="col-lg-4 col-md-4 col-12 wow fadeInLeft"  data-wow-delay=".3s">
                     <div class="cat-shop-card">
                       <a href="${base_url+'/featured/'+row.slug}">
                        <img class="lazy"  data-src="${row.preview}" src="${preloader}" alt="${row.name}">
                       </a>
                     </div>
                  </div>
                  <div class="col-lg-8 col-md-8 col-12">
                     <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="section-title m-btm-30">
                              
                              <h2 class="s-content-title font-stylish m-btm-10 pr-color">${row.name}</h2>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="sc-title-button">
                              <a href="${base_url+'/featured/'+row.slug}" class="theme-btn btn-second font-stylish ">All Products</a>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-12">
                           <div class="dcat-slider render_featured_product_area${key}">
                           
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>`;

     $('.featured_products_area').append(html);
     render_primary_product(row.products,'.render_featured_product_area'+key,'cat-sidebar');
     

     $('.render_featured_product_area'+key).owlCarousel({
            autoplay: false,
            loop: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            smartSpeed: 500,
            merge: true,
            nav: row.products.length > 3 ? true : false,
            navText: ['<i class="icofont-simple-left" aria-hidden="true"></i>', '<i class="icofont-simple-right" aria-hidden="true"></i>'],
            dots: false,
            margin: 30,
            responsive: {
                300: {
                    items: 2,
                },
                480: {
                    items: 2,
                },
                768: {
                    items: 2,
                },
                1170: {
                    items: 3,
                },
            }
        });
   });


   
}

$(document).on('click','.filterproducts',function(){
    
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
        "with": ["preview","discount"]
        }

        $.ajax({
            type: 'get',
            url: base_url + '/get-product',
            data: callbackdata,
            dataType: 'json',
            beforeSend: function() {
                $('.filteredproduct').remove();
               
                runpreloader();
            },
            success: function(response) {
            
                render_primary_product(response.data, '.filtered_product_tab','filteredproduct tabs-p col-lg-3 col-md-6 col-6');
                $('.filter_product'+productid).attr('data-items',JSON.stringify(response.data));

               
                runCountdown();

            },

        });
    }
    else{
       
    }


});


