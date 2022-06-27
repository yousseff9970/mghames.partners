"use strict";

var base_url = $('#base_url').val();
$.ajax({
	type: 'get',
	url: base_url+'/partner/dashboard-data',
	dataType: 'json',
	contentType: false,
	cache: false,
	processData:false,
	success: function(response){ 
		$('#total_stores').html(response.total_stores_count);
		$('#total_active_stores').html(response.total_active_stores);
		$('#total_expire_stores').html(response.total_expires);
		$('#fund').html(response.fund);
		$('#upcoming_count').html(response.upcoming_renewal_count);
		let upcoming_renewals_html = '';
		response.upcoming_renewals.forEach(row => {
			upcoming_renewals_html += `
			<a href="${base_url+'/partner/plancharge/'+row.id+'/'+row.renew_plan}" class="ticket-item">
			<div class="ticket-title">
			<h4>${row.id}</h4>
			</div>
			<div class="ticket-info">
			<div>${row.invoice_no} (${row.plan})</div>
			<div class="bullet"></div>
			<div class="text-primary">${row.will_expire}</div>
			</div>
			</a>`;
		});
		$('.upcoming_renewals_html').html(upcoming_renewals_html);
	}
})