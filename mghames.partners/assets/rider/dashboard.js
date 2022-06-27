(function ($) {
	"use strict";


    /*-------------------------
            Live Order Data
        --------------------------*/
	$(window).on('load', function(e){
		e.preventDefault();
			
        var url = $('#live_order_url').val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: 'GET',
			url: url,
			data: {},
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {

    		},
			success: function(response){ 

                var base_url = $('#base_url').val();

                $.each(response,function(key,data){

                    var html = '';

                    html += `<div class="col-12 col-md-6 col-lg-3">
                    <div class="card card-primary">
                      <div class="card-header">
                        <h4>${data.invoice_no}</h4>
                      </div>
                      <div class="card-body">
                        <h6>Amount: <code>${data.total}</code></h6>
                       
                        
                        <h6>Time: <code>${data.created_at}</code></h6>
                      </div>
                      <div class="card-footer pt-0">
                          <a href="${'/rider/order/'+data.order_id}" class="btn btn-primary w-100"><i class="fas fa-eye"></i>View</a>
                      </div>
                    </div>
                </div>`;

                $('#live_orders').append(html);

                });

                
			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})


	});

})(jQuery);	