(function ($) {
"use strict";

/*-------------------------------
    	Chart Data Load
  	-----------------------------------*/
$('#days').on('change',()=>{
	period = $('#days').val();
	loadData();
})
loadData();
loadStaticData();

/*-------------------------------
    	LoadStaticData Function
  	-----------------------------------*/
function loadStaticData(){
	$.ajax({
		type: 'get',
		url: base_url+'/admin/static_data',

		dataType: 'json',
		contentType: false,
		cache: false,
		processData:false,

		success: function(response){ 
			$('.pending_list').html(response.total_pending);
			$('.rejected_list').html(response.total_rejected);
			$('.approved_list').html(response.total_active);
			$('.total_list').html(response.total_posts);
			$('.total_earnings_amount').html(response.total_earnings_amount);
			$('.total_transection_count').html(response.total_transection_count);

			var dates=[];
			var sales=[];

			$.each(response.sales, function(index, value){
				var dat=value.month+' '+value.year;
				var sale=value.sales;
				dates.push(dat);
				sales.push(sale);
			});

			count_chart(dates,sales);

			var dates=[];
			var totals=[];

			$.each(response.amount, function(index, value){
				var dat=value.month+' '+value.year;
				var total=value.amount;

				dates.push(dat);
				totals.push(total);
			});
			earnings_chart(dates,totals);

			var dates=[];
			var posts=[];
			$.each(response.post_count, function(index, value){
				var dat=value.month+' '+value.year;
				var total=value.post;

				dates.push(dat);
				posts.push(total);
			});
			load_perfomace_chart(dates,posts);

		}
	})
}

/*-------------------------------
    	Earning Chart function
  	-----------------------------------*/
var balance_chart = document.getElementById("sales_of_earnings_chart").getContext('2d');
var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');
function earnings_chart(dates,totals) {	

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

/*-------------------------------
    	Count Chart function
  	-----------------------------------*/
var sale_count_chart = document.getElementById("sale_count_chart").getContext('2d');

var sales_chart_bg_color = sale_count_chart.createLinearGradient(0, 0, 0, 80);
sales_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
sales_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

function count_chart(dates, sales){
	var myChart = new Chart(sale_count_chart, {
		type: 'line',
		data: {
			labels: dates,
			datasets: [{
				label: 'Orders',
				data: sales,
				borderWidth: 2,
				backgroundColor: sales_chart_bg_color,
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


/*-------------------------------
    	LoadData function
  	-----------------------------------*/
function loadData() {

	$.ajax({
		type: 'get',
		url: dataUrl+'/'+period,

		dataType: 'json',
		contentType: false,
		cache: false,
		processData:false,

		success: function(response){ 
			analytics_report(response.TotalVisitorsAndPageViews);
			top_browsers(response.TopBrowsers);
			Referrers(response.Referrers);
			TopPages(response.MostVisitedPages);
			$('#new_vistors').html(number_format(response.fetchUserTypes[0].sessions))
			$('#returning_visitor').html(number_format(response.fetchUserTypes[1].sessions))
		}
	})

}
function analytics_report(data) {
	var statistics_chart = document.getElementById("myChart").getContext('2d');
	var labels=[];
	var visitors=[];
	var pageViews=[];
	var total_visitors=0;
	var total_page_views=0;
	$.each(data, function(index, value){
		labels.push(value.date);
		visitors.push(value.visitors);
		pageViews.push(value.pageViews);
		var total_visitor = total_visitors+value.visitors;
		total_visitors=total_visitor;
		var total_page_view = total_page_views+value.pageViews;
		total_page_views=total_page_view;
	});

	$('#total_visitors').html(number_format(total_visitors));
	$('#total_page_views').html(number_format(total_page_views));

	var myChart = new Chart(statistics_chart, {
		type: 'line',
		data: {
			labels: labels,
			datasets: [{
				label: 'Visitors',
				data: visitors,
				borderWidth: 5,
				borderColor: '#6777ef',
				backgroundColor: 'transparent',
				pointBackgroundColor: '#fff',
				pointBorderColor: '#6777ef',
				pointRadius: 4
			},
			{
				label: 'PageViews',
				data: pageViews,
				borderWidth: 5,
				borderColor: '#6777ef',
				backgroundColor: 'transparent',
				pointBackgroundColor: '#fff',
				pointBorderColor: '#6777ef',
				pointRadius: 4
			}]
		},
		options: {
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
						stepSize: 150
					}
				}],
				xAxes: [{
					gridLines: {
						color: '#fbfbfb',
						lineWidth: 2
					}
				}]
			},
		}
	});

}

/*-------------------------------
    	Referrers function
  	-----------------------------------*/
function Referrers(data) {
	$('#refs').html('');
	$.each(data, function(index, value){
		var html='<div class="mb-4"> <div class="text-small float-right font-weight-bold text-muted">'+number_format(value.pageViews)+'</div><div class="font-weight-bold mb-1">'+value.url+'</div></div><hr>';
		
		$('#refs').append(html);
	});
}

/*---------------------------------
    	Top Browsers Data Render
  	-----------------------------------*/
function top_browsers(data) {
	$('#browsers').html('');
	$.each(data, function(index, value){
		var browser_name=value.browser;
		if (browser_name=='Edge') {
			var browser_name='internet-explorer';
		}
		var html=' <div class="col text-center"> <div class="browser browser-'+lower(browser_name)+'"></div><div class="mt-2 font-weight-bold">'+value.browser+'</div><div class="text-muted text-small"><span class="text-primary"></span> '+number_format(value.sessions)+'</div></div>';
		$('#browsers').append(html);
		if (index==4) {
			return false;
		}
	});
}

/*---------------------------------
    	Top Pages Data Render
  	-----------------------------------*/
function TopPages(data) {
	$('#table-body').html('');
	$.each(data, function(index, value){
		var index=index+1;
		var html='<div class="mb-4"> <div class="text-small float-right font-weight-bold text-muted">'+number_format(value.pageViews)+' (Views)</div><div class="font-weight-bold mb-1"><a href="'+base_url+value.url+'" target="_blank" draggable="false">'+value.pageTitle+'</a></div></div>';
		$('#table-body').append(html);
	});
}

/*---------------------------
    	Lower Data Return
  	----------------------------*/
function lower(str) {
	var str= str.toLowerCase();
	var str=str.replace(' ',str);
	return str;
}

/*---------------------------
    	Number Format
  	----------------------------*/
function number_format(number) {
	var num= new Intl.NumberFormat( { maximumSignificantDigits: 3 }).format(number);
	return num;
}

/*---------------------------
    	Load Perfomace Chart 
  	----------------------------*/
var ctx = document.getElementById("post_cart").getContext('2d');
function load_perfomace_chart(dates,totals) {
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: dates,
			datasets: [{
				label: 'Posts',
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
})(jQuery);	


