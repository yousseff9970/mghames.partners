  "use strict";
   function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;

      document.body.innerHTML = printContents;

      window.print();

      document.body.innerHTML = originalContents;
   }

   $(".barcode_form").on('submit', function(e){
      e.preventDefault();
      $.ajaxSetup({
         headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      $.ajax({
         type: 'POST',
         url: this.action,
         data: new FormData(this),
         dataType: 'json',
         contentType: false,
         cache: false,
         processData:false,
         beforeSend: function() {
               
               $('.basicbtn').attr('disabled','')

         },
         
         success: function(response){ 
         $('.basicbtn').removeAttr('disabled');
         var barcode=response.barcode;
         var style=$('#barcode_style').val();
         var image=$('#preview').val();
         var product_name=$('#product_name').val();
         var full_id=$('#full_id').val();

         var label_height=$('#label_height').val();
         var label_width=$('#label_width').val();
         var barcode_height=$('#barcode_height').val();
         var preview_height=$('#preview_height').val();
         var price=$('#price').val();
         var currency_name=$('#currency_name').val();
         
         var product_name_html='';
         if ($('#product_status_name').is(":checked")) {
            product_name_html=`<div class="product_name_area">
                     <span  class="barcode_name">${product_name}</span>
                  </div>`;
         }

         var product_code_html='';
         if ($('#product_code').is(':checked')) {
            product_code_html=`<div class="text-right mr-4" style="font-size:12px;">
                        ${full_id}                               
                     </div>`;
         }

         if(!$('#currency').is(':checked')){
            currency_name='';
         }

         var price_html='';
         if ($('#price_status').is(':checked')) {
            price_html=` <div class="barcode_price_area" >
                     
                     ${amount_format(price)}
                  </div>`;
         }

         var product_image_html='';
         if ($('#product_image').is(':checked')) {
            product_image_html=`<span class="product_image"><img src="${image}" style="height:${preview_height}" /></span>`;
         }




         $('.item').remove();
         for (var i = 0; i < $('#print_qty').val(); i++) {
            
            var html=`<div class="item ${style}" style="height:${label_height};width:${label_width}">
               <div class="item-inner">
                  
                  ${product_image_html}
                  
                  ${product_name_html}
               ${price_html}
                  <span class="barcode_image">
                     <img src="data:image/png;base64,${barcode}" class="bcimg" style="height:${barcode_height}" />
                     ${product_code_html}
                  </span>
               </div>
            </div>`; 

            $("#barcode").append(html);
         }
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