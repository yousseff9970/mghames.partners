"use strict";

$('.cart_subtotal').text(amount_format(subtotal));
$('.cart_tax').text(amount_format(tax));
$('.cart_total').text(amount_format(total));


 /*-------------------------
        Order Method Change
    --------------------------*/
$('.order_method').on('change',function(){

	if ($(this).val() == 'pickup') {
    $('.shipping_method_area').hide();
    $('.delivery_address_area').hide();
    $('.post_code_area').hide();
    $('.shipping_fee').hide();
    $('.map_area').hide();
    $('.cart_total').text(amount_format(subtotal));
	}
	else{
		$('.shipping_method_area').show();
    $('.delivery_address_area').show();
    $('.post_code_area').show();
    $('.shipping_fee').show();
    $('.map_area').show();
    $('.cart_total').text(parseFloat(new_total.toFixed(2)));
	}
});

/*-------------------------
        Payment Getway
    --------------------------*/
$('.getway').on('click',function(){
	$('.currency_area').hide();
	$('.rate_area').hide();
	$('.charge_area').hide();
	$('.instruction_area').hide();
	


	var logo=$(this).data('logo');
	var instruction=$(this).data('instruction');
	var currency=$(this).data('currency');
	var rate=$(this).data('rate');
	var charge=$(this).data('charge');
	
	

	$('.getway_logo').attr('src',logo);
	$('.currency').text(currency);
	$('.rate').text(rate);
	$('.charge').text(charge);
	$('.instruction').text(instruction);

	$('.payement_inst').show();

	currency != '' ? $('.currency_area').show() : $('.currency_area').hide();
	rate != '' ? $('.rate_area').show() : $('.rate_area').hide();
	charge != '' ? $('.charge_area').show() : $('.charge_area').hide();
	instruction != '' ? $('.instruction_area').show() : $('.instruction_area').hide();

});

/*-------------------------
       Location Change
    --------------------------*/
$('#locations').on('change',function(){

	$('.shipping_method').remove();
	var shippings=$(this).find('option:selected').data('shipping')
	
	
	$.each(shippings,function(key,value){

		var html=`<label class="checkbox-inline shipping_method" for="shipping${value.id}">
					<input name="shipping_method" class="shipping_item" value="${value.id}" data-price="${value.slug}"  id="shipping${value.id}" type="radio" > ${value.name}
					</label>`;

		$('.shipping_render_area').append(html);
	});

	$('.shipping_method_area').show();

});

/*-------------------------
       shipping_item
    --------------------------*/
$(document).on('change','.shipping_item',function(){
	var price=$(this).data('price');
	$('.shipping_fee').text(amount_format(price));
	new_total=total+price;


	$('.cart_total').text(amount_format(new_total));

});

/*-------------------------
       Create New Account
    --------------------------*/
$('#create_account').on('change',function(){
	
	if ($(this).is(':checked')){
		$('.password_area').show();
	}
	else{
		$('.password_area').hide();
	}
})

/*-------------------------
       Order Form Submit
    --------------------------*/
$('.orderform').on('submit', function(e) {
	$('.submitbtn').attr("disabled", "disabled");
	$('.submitbtn').text("Please wait...");
});

/*-------------------------
       Pre Order Change
    --------------------------*/
$('#pre_order').on('change',function(){
if ($(this).is(':checked')){
		$('.pre_order_area').show();
	}
	else{
		$('.pre_order_area').hide();
	}
});

/*-------------------------
       Getway Btn Click
    --------------------------*/
$(document).on('click','.getway_btn',function(){

var id=$(this).data('id');
$('#getway'+id).prop("checked", true);

});

/*-------------------------
       Time Change
    --------------------------*/
$(document).on('change','#time',function(){
	var inputEle = document.getElementById('time');
	var timeSplit = inputEle.value.split(':'),
	hours,
	minutes,
	meridian;
	hours = timeSplit[0];
	minutes = timeSplit[1];
	if (hours > 12) {
	meridian = 'PM';
	hours -= 12;
} else if (hours < 12) {
	meridian = 'AM';
	if (hours == 0) {
	hours = 12;
	}
} else {
	meridian = 'PM';
}


$('.time').val(hours + ':' + minutes + ' ' + meridian)
});