   
"use strict";
var period=$('#days').val();


var base_url=$("#base_url").val();
var site_url=$("#site_url").val();
var dashboard_static_url=$("#dashboard_static").val();


loadStaticData();
load_perfomace(7);


dashboard_order_statics($('#month').val());



function getCurrentOrders() {
    $.ajax({
        type: 'get',
        url: $('#new_order_link').val(),

        dataType: 'json',

        success: function(response){ 
            if (response.orders.length == 0) {
                return false;
            }
            current_pending_orders(response.orders);

           
            
        }
    })
}



$('#perfomace').on('change',function(){
    var period=$('#perfomace').val();
    load_perfomace(period);
});

$('.month').on('click',function(e){
    $('.month').removeClass('active');
    $(this).addClass("active");
    var month=e.currentTarget.dataset.month;
    
    
    $('#orders-month').html(month);
    dashboard_order_statics(month);
});

function dashboard_order_statics(month) {
    var url = $('#dashboard_order_statics').val();
    var gif_url= $('#gif_url').val();
    var html="<img src="+gif_url+">";
    $('#pending_order').html(html);
    $('#completed_order').html(html);
    $('#shipping_order').html(html);
    $('#total_order').html(html);
    $.ajax({
        type: 'get',
        url:url+'/'+month,

        dataType: 'json',
        

        success: function(response){ 
            $('#pending_order').html(response.total_pending);
            $('#completed_order').html(response.total_completed);
            $('#shipping_order').html(response.total_processing);
            $('#total_order').html(response.total_orders);
        }
    })
}

function loadStaticData() {
    var url = dashboard_static_url;

   

    $.ajax({
        type: 'get',
        url: url,

        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,

        success: function(response){ 

            $('#sales_of_earnings').html(amount_format(response.totalEarnings));
            $('#total_sales').html(response.totalSales);
            
            $('#monthly_total_sales').html(amount_format(response.thismonth_sale_amount));
            $('#today_order').html(response.today_orders);
            $('#today_total_sales').html(amount_format(response.today_sale_amount));
            $('#last_month_total_sales').html(amount_format(response.lastmonth_sale_amount));
            $('#last_seven_days_total_sales').html(amount_format(response.lastweek_sale_amount));
            $('#yesterday_total_sales').html(amount_format(response.yesterday_sale_amount));
            $('.plan_name').html(response.plan_name);
            $('.plan_expire').html(response.will_expired);
            $('.pages').html(response.pages);
            $('.posts_created').html(response.products);
            
            $('.plan_load').hide();
            $('.product_used').hide();

            var dates=[];
            var totals=[];

            $.each(response.earnings, function(index, value){
                var dat=value.month+' '+value.year;
                var total=value.total;

                dates.push(dat);
                totals.push(total);
            });
            sales_of_earnings_chart(dates,totals);
            current_pending_orders(response.current_pending_orders);

            var dates=[];
            var sales=[];

            $.each(response.orders, function(index, value){
                var dat=value.month+' '+value.year;
                var sale=value.sales;

                dates.push(dat);
                sales.push(sale);
            });

            order_chart(dates,sales);
           

            top_sell_products(response.top_sell_products);  
            maxrated_products(response.maxrated_products);
            top_customer(response.top_customers);
            product_carousel();

            $.each(response.today_orders_list,function (index, value) {
               var html=`<li class="media">
                 <i class="fas fa-shopping-basket mr-3 rounded"  width="55"></i>
                <div class="media-body">
                  <div class="float-right">
                    <div class="font-weight-600 text-muted text-small">${value.time}</div>
                  </div>
                  <div class="media-title"><a href="${value.url}">${value.orderid} <span class="badge text-white" style="background-color: ${value.status_color}">${value.status}</span></a></div>
                  <div class="mt-1">
                    <div class="budget-price">
                      <div class="budget-price-square " style="background-color: ${value.status_color}" data-width="64%"></div>
                      <div class="budget-price-label">${value.amount}</div>
                    </div>
                  </div>
                </div>
              </li>`;

              $('.todays_orders_list').append(html);
            });
            
        },
        error: function(xhr, status, error){
            if(status == 'parsererror'){
                $('#sales_of_earnings').html(0);
                $('#total_sales').html(0);
                $('#storage_used').html(0);
                $('#monthly_total_sales').html(0);
                $('#today_order').html(0);
                $('#today_total_sales').html(0);
                $('#last_month_total_sales').html(0);
                $('#last_seven_days_total_sales').html(0);
                $('#yesterday_total_sales').html(0);
                $('.plan_name').html('');
                $('.plan_expire').html('');
                $('.pages').html(0);
                $('.posts_created').html(0);
                $('.product_capacity').html(0);
                $('.storage_used').html(0);
                $('.storage_capacity').html(0+'MB');
                $('.posts_used').html(0);
                $('.plan_load').hide();
                $('.product_used').hide();
                $('#pending_order').html(0);
                $('#completed_order').html(0);
                $('#shipping_order').html(0);
                $('#total_order').html(0);
            }
            
        }
    })
}



function current_pending_orders(data) {
   $('.orderitems').remove();

           if ($('.notification-toggle').length != 0) {
               $('.notification-toggle').addClass('beep');

               $.each(data, function(index, row){
                  var html=`<a href="${row.url}" class="dropdown-item dropdown-item-unread orderitems">
                            <div class="dropdown-item-icon bg-primary text-white">
                              <i class="fas fa-shopping-basket"></i>
                            </div>
                            <div class="dropdown-item-desc">
                              You have received a new order. (${row.orderid})
                              <div class="time text-primary">${row.time}</div>
                            </div>
                          </a>`;

                  $('.dropdown-list-content').append(html);
               });
           }

           if ($('.pending_order_list').length != 0) {
            $.each(data,function(index,row){

                var html=`<div class="col-12 col-md-6 col-lg-3 orderitems"> <div class="card card-primary ">
                      <div class="card-header">
                        <a href="${row.url}"><h4>${row.orderid}</h4></a>
                      </div>
                      <div class="card-body">
                        <h6>Amount: <code>${row.amount}</code><br><br>
                        Status: <div style="background-color: ${row.status_color};color: #fff;" class="badge">${row.status}</div>
                        </h6>
                        <h6>Time: <code>${row.time}</code>
                        </h6>
                      </div>
                      <div class="card-footer pt-0">
                        <a href="${row.url}" class="btn btn-primary w-100">
                          <i class="fas fa-eye"></i> View </a>
                      </div>
                    </div></div>`;

                $('.pending_order_list').append(html);    

            });
           }

         
         
}

function load_perfomace(period) {
    $('#earning_performance').show();
    var url=$('#dashboard_perfomance').val();
    $.ajax({
        type: 'get',
        url: url+'/'+period,

        dataType: 'json',
        

        success: function(response){ 
            $('#earning_performance').hide();
            var month_year=[];
            var dates=[];
            var totals=[];

            

            if (period != 365) {
                $.each(response, function(index, value){
                    var total=value.total;
                    var dte=value.date;
                    totals.push(total);
                    dates.push(dte);
                });
                load_perfomace_chart(dates,totals);
                
            }
            else{
                $.each(response, function(index, value){
                    var month=value.month;
                    var total=value.total;

                    month_year.push(month);
                    totals.push(total);
                });
                load_perfomace_chart(month_year,totals);
               
            }
            
        }
    })
}


$.ajax({
  type: 'get',
  url: base_url+'/seller/subscription-status',
  dataType: 'json',
  success: function(response){ 

      $.each(response, function(index, value){
        if (value == 'on') {
          var status='Active';
        }
        else if(value == 'off'){
           var status='Disable';
        }
        else{
           var status=value;
        }

        var html=`<li class="media">
                
                <div class="media-body ">
                  <div class="float-right">
                   <span class="badge  ${value == 'off' ? 'badge-danger badge-sm' : 'badge-success badge-sm'}">${status}</span>
                  </div>
                  <div class="media-title">${index} :</div>
                  
                </div>
              </li>`;


        $('.subscription_data_list').append(html);
      });


   
  }
});


function lower(str) {
    var str= str.toLowerCase();
    var str=str.replace(' ',str);
    return str;
}


function number_format(number) {
    var num= new Intl.NumberFormat( { maximumSignificantDigits: 3 }).format(number);
    return num;
}




function percentage(partialValue, totalValue) {
   var n= (100 / totalValue) * partialValue;

  
   return parseInt(n);
} 


var ctx = document.getElementById("myChart").getContext('2d');

function load_perfomace_chart(dates,totals) {
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Total Amount',
                data: totals,
                borderWidth: 2,
                backgroundColor: 'rgba(63,82,227,.8)',
                borderWidth: 0,
                borderColor: 'transparent',
                pointBorderWidth: 0,
                pointRadius: 3.5,
                pointBackgroundColor: 'transparent',
                pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
         
          drawBorder: false,
          color: '#f2f2f2',
      },
      ticks: {
        beginAtZero: true,
        stepSize: 1500,
        callback: function(value, index, values) {
            return  value;
        }
      }
  }],
      xAxes: [{
        gridLines: {
            display: false,
            tickMarkLength: 15,
        }
      }]
    },
    }
    });
}


var balance_chart = document.getElementById("sales_of_earnings_chart").getContext('2d');

var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

function sales_of_earnings_chart(dates,totals) {
    

    

    var myChart = new Chart(balance_chart, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Total Amount',
                data: totals,
                backgroundColor: balance_chart_bg_color,
                borderWidth: 3,
                borderColor: 'rgba(63,82,227,1)',
                pointBorderWidth: 0,
                pointBorderColor: 'transparent',
                pointRadius: 3,
                pointBackgroundColor: 'transparent',
                pointHoverBackgroundColor: 'rgba(63,82,227,1)',
            }]
        },
        options: {
            layout: {
                padding: {
                    bottom: -1,
                    left: -1
                }
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: false,
                        display: false,
                    },
                    ticks: {
                        display: false
                    }
                }]
            },
        }
    });

}


var sales_chart = document.getElementById("total-sales-chart").getContext('2d');

var sales_chart_bg_color = sales_chart.createLinearGradient(0, 0, 0, 80);
balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

function order_chart(dates,sales) {
    var myChart = new Chart(sales_chart, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Orders',
                data: sales,
                borderWidth: 2,
                backgroundColor: balance_chart_bg_color,
                borderWidth: 3,
                borderColor: 'rgba(63,82,227,1)',
                pointBorderWidth: 0,
                pointBorderColor: 'transparent',
                pointRadius: 3,
                pointBackgroundColor: 'transparent',
                pointHoverBackgroundColor: 'rgba(63,82,227,1)',
            }]
        },
        options: {
            layout: {
                padding: {
                    bottom: -1,
                    left: -1
                }
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: false,
                        display: false,
                    },
                    ticks: {
                        display: false
                    }
                }]
            },
        }
    }); 
}

if($(".top-5-scroll").length) {
  $(".top-5-scroll").css({
    height: 315
  }).niceScroll();


}

  /*-----------------------
        DownloadPng
    ------------------------*/
   
    $('.downloadPng').on('click',function(){
     var dataURI = document.getElementById('qrcode_img').src;
     var download = document.createElement('a');
     download.href = dataURI;
     download.download = 'qrcode.png';
     download.click();
   })
   
   $('.clear_site_cache').on('click',function(){
    $(this).attr('disabled','');
    $(this).text('Please Wait....');

     $.ajax({
        type: 'get',
        url: base_url+'/seller/clear-cache',
        dataType: 'json',
        success: function(response){ 
           $('.clear_site_cache').text('Site Cache Cleared');
            
        }
    });

   });  


function top_customer(data) {
  $.each(data,function (index, row) {

     var html=`<div>
            <div class="product-item pb-3">
              <div class="product-image">
                <img alt="image" src="https://ui-avatars.com/api/?name=${row.name}&rounded=true&bold=true&background=random" class="img-fluid">
              </div>
              <div class="product-details">
                <div class="product-name">${row.name}</div>
                <div class="product-review">
                 
                </div>
                <div class="text-muted text-small">${row.orders_count} Orders</div>
                <div class="product-cta">
                  <a href="${base_url+'/seller/user/'+row.id}" class="btn btn-primary">Detail</a>
                </div>
              </div>  
            </div>
          </div>`;

    $('.top_customer').append(html);
  });
}

function top_sell_products(data) {
  $.each(data,function (index, row) {
       var ratings='';

       for (var i = 1; i <= 5; i++) {
        var review_full=`<i class="fas fa-star"></i>`;
        var review_half=`<i class="fas fa-star text-light" ></i>`;

        i > row.rating ? ratings += review_half: ratings += review_full;
      }


     var html=`<div>
            <div class="product-item pb-3">
              <div class="product-image">
                <img alt="image" src="${row.preview != null ? row.preview.value : base_url+'/uploads/default.png' }" class="img-fluid">
              </div>
              <div class="product-details">
                <div class="product-name">${row.title}</div>
                <div class="product-review">
                 ${ratings}
                </div>
                <div class="text-muted text-small">${row.orders_count} Sales</div>
                <div class="product-cta">
                  <a href="${base_url+'/seller/product/'+row.id+'/edit'}" class="btn btn-primary">Detail</a>
                </div>
              </div>  
            </div>
          </div>`;

     $('.top_selling_products').append(html);
  });
}

function maxrated_products(data) {
 $.each(data,function (index, row) {
       var ratings='';

       for (var i = 1; i <= 5; i++) {
        var review_full=`<i class="fas fa-star"></i>`;
        var review_half=`<i class="fas fa-star text-light" ></i>`;

        i > row.rating ? ratings += review_half: ratings += review_full;
      }


     var html=`<div>
            <div class="product-item pb-3">
              <div class="product-image">
                <img alt="image" src="${row.preview != null ? row.preview.value : base_url+'/uploads/default.png' }" class="img-fluid">
              </div>
              <div class="product-details">
                <div class="product-name">${row.title}</div>
                <div class="product-review">
                 ${ratings}
                </div>
                <div class="text-muted text-small">${row.reviews_count} Reviews</div>
                <div class="product-cta">
                  <a href="${base_url+'/seller/product/'+row.id+'/edit'}" class="btn btn-primary">Detail</a>
                </div>
              </div>  
            </div>
          </div>`;

     $('.max_rated_products').append(html);
  });
}


function product_carousel() {
  $(".products-carousel").owlCarousel({
  items: 3,
  margin: 10,
  autoplay: true,
  autoplayTimeout: 5000,
  loop: true,
  nav:false,
  responsive: {
    0: {
      items: 2
    },
    768: {
      items: 2
    },
    1200: {
      items: 3
    }
  }
});

  


}

function amount_format(amount,type='name') {
  const currency_settings=JSON.parse($('#currency_settings').val());

  var format= type == 'name' ?  ' '+currency_settings.currency_name+' ' : currency_settings.currency_icon;
 
    
    if (currency_settings.currency_position == 'left') {
        var price=format+amount;
       
    }
    else{
        var price=amount+' '+format;
    }

   
    
    return price;
    
   
}